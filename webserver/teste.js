const axios = require('axios');
const cheerio = require('cheerio');
var fs = require('fs');

BuscaChamadosAbertos();

function BuscaChamadosAbertos(){
    var HTML = fs.readFileSync('./pagina.html','utf8');                                                                                                 //Debug // Pagina HTML
    const $html = cheerio.load(HTML);                                                                                                                   //Carrega o HTML da pagina usando Cheerio
    
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
    const { Pool } = require('../webserver/node_modules/pg')                                //Importa o Postgres

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




/*
dados = $html('#TicketID_55617').find('td:eq(1)').text();
var title = [];
for (var i = 0; i < 1; i++){
    $html('.teste').each(function () {
        title[1] = $html(this)
         .find('td:eq(0)')
         .text()
    });
}*/

//Ordem das Colunas no OTRS
    //Prioridade
    //Novo Arquigo
    //Ticket
    //Idade
    //Remente
    //Titulo
    //Estado
    //Bloquear
    //Fila
    //Nome do Cliente
    //Criado
    //Alterado

//console.log(dados);
/*
for(var i = 0; i <= tamanho; i++){
    console.log(dados)
}*/

//console.log(_grid);

