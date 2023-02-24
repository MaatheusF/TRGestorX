//Busca todos os Chamados Abertos de um Cliente no OTRS
//Parametros: ClienteNome
// Util: https://gist.github.com/tokland/d3bae3b6d3c1576d8700405829bbdb52


//Importações
const puppeteer = require('puppeteer');
const axios = require('axios');
const cheerio = require('cheerio');

var _OTRSLoginURL =             'https://suporte.chapeco-solucoes.com.br/otrs/index.pl'     //Pagina de Login do OTRS
//var _OTRSChamadosAbertosURL = 'https://suporte.chapeco-solucoes.com.br/otrs/index.pl?Action=AgentTicketSearch;Subaction=Search;StateType=Open;CustomerIDRaw=%5B056%5D%20-%20TJ'
var _OTRSLogoutURL =            'https://suporte.chapeco-solucoes.com.br/otrs/index.pl?Action=Logout;ChallengeToken='
BuscaChamadosOTRS();

async function BuscaChamadosOTRS(){

    //Configurações
    browser = await puppeteer.launch({headless: false});  //Abre o Navegador
    page = await browser.newPage();                       //Cria uma nova Pagina
    await page.setViewport({width: 1200, height: 720});         //Seta o ViewPort da Pagina

    var __LoginRealizado = await Login();
    if(__LoginRealizado == true){
        console.log('Login Realizado com Sucesso!');
        BuscaChamadosAbertos();
    }
}

async function BuscaChamadosAbertos(){
    var _OTRSChamadosAbertosURL =   'https://suporte.chapeco-solucoes.com.br/otrs/index.pl?Action=AgentTicketSearch;Subaction=Search;StateType=Open;CustomerIDRaw=%5B025%5D%20-%20GSat';
    await page.goto(_OTRSChamadosAbertosURL, { waitUntil: 'networkidle0' });        //Navega para a Pagina do Cliente
    const content = await page.content();                                           //Pega o HTML da Pagina
    const $html = cheerio.load(content);                                            //Carrega o HTML
    
    var _LinhasQuantidade = $html('tr').length;                                                                                                         //Verifica a Quantidade de Registros com a TAG <TR>

    //Busca todos os chamados do cliente
    for(var i = 0; i < _LinhasQuantidade; i++){
        var _Ticket =       $html('tr:eq('+ i +')').find('td:eq(3)').text().trim();                                                                     //Numero do Chamado
        var _Idade =        $html('tr:eq('+ i +')').find('td:eq(4)').find('div').attr('title');                                                         //Idade do Chamado  
        var _Titulo =       $html('tr:eq('+ i +')').find('td:eq(6)').find('div').attr('title');                                                         //Titulo do Chamado
        var _Fila =         $html('tr:eq('+ i +')').find('td:eq(9)').find('div').attr('title');                                                         //Fila do Chamado
        var _CriadoEm =     $html('tr:eq('+ i +')').find('td:eq(11)').find('div').attr('title')?.replace(' (America/Sao_Paulo)','');                    //Cadastro do Chamado
        var _AlteradoEm =   $html('tr:eq('+ i +')').find('td:eq(12)').find('div').attr('title')?.replace(' (America/Sao_Paulo)','');                    //Alteração do Chamado
        GravaChamadoBanco(_Ticket,_Idade,_Titulo,_Fila,_CriadoEm,_AlteradoEm,0);
    }
}

function GravaChamadoBanco(_Ticket,_Idade,_Titulo,_Fila,_CriadoEm,_AlteradoEm,_ClienteID){
    const { Pool } = require('../../../webserver/node_modules/pg')                                //Importa o Postgres

    //Dados da Conexão
    const pool = new Pool({
        host: 'localhost',
        user: 'postgres',     
        password: 'favero10',
        database: 'gestorxdb',
        port: 5432
    })

    //SQL's
    var SQL_BuscaChamado = "SELECT * FROM cchao_clientes_chamados_otrs ccco WHERE cchao_ticket = '" + _Ticket +"'";
    var SQL_InsereChamado = "INSERT INTO public.cchao_clientes_chamados_otrs(cchao_ticket, cchao_idade, cchao_titulo, cchao_estado, cchao_fila, cchao_criado, cchao_alterado, cchao_cliente_codigo) VALUES('"+ _Ticket + "', '"+_Idade+"', '"+_Titulo+"', '', '"+_Fila+"', '"+_CriadoEm+"', '"+_AlteradoEm+"', '"+_ClienteID+"');";
    
    var SQL_AtualizaChamado = "UPDATE public.cchao_clientes_chamados_otrs SET cchao_idade='"+_Idade+"', cchao_titulo='"+_Titulo+"', cchao_fila='"+_Fila+"', cchao_criado='"+_CriadoEm+"', cchao_alterado='"+_AlteradoEm+"' WHERE cchao_ticket = '"+_Ticket+"'";

    //Verifica se já existe um Chamado Salvo com o Numero do Chamado recebido
    pool.query(SQL_BuscaChamado, (err, res) => {
        if(res.rowCount == 0){
            console.log("Chamado não Encontrado, Gravando...");
            
            //Salva os Dados do Chamado
            pool.query(SQL_InsereChamado, (err, res) => {
                if(err){
                    console.log(err.message);
                }
                console.log("Chamado Inserido com Sucesso!");
                pool.end();
            });
        }
        else{
            console.log("Chamado Duplicado, Atualizando...");

            //Atualiza o Chamado já Existente
            pool.query(SQL_AtualizaChamado, (err, res) => {
                if(err){
                    console.log(err.message);
                }
                console.log("Chamado Atualizado com Sucesso!");
                pool.end();
            });
        }
    });
    
}

async function Login(){
    await page.goto(_OTRSLoginURL, { waitUntil: 'networkidle0' });                                      // Navega para a Pagina de Login
    await page.type('#User', 'matheus.favero');                                                         // Usuario
    await page.type('#Password', 'Favero10@M');                                                         // Senha

    await Promise.all([
        page.click('#LoginButton'),                             //Clica no Botão de Entrar
        page.waitForNavigation({ waitUntil: 'networkidle0' }),  //Aguarda o Carregamento da Pagina 
    ]);
    return true;
}

async function Logout(){
    const cookies = await page.cookies();
    await page.goto(_OTRSLogoutURL + (cookies[0].value) + ';', { waitUntil: 'networkidle0' });                                      // Navega para a Pagina de Login
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'networkidle0' }),  //Aguarda o Carregamento da Pagina 
    ]);
    console.log("Logout Realizado com Sucesso");
}





module.exports = {
    BuscaChamadosOTRS: BuscaChamadosOTRS,
  };