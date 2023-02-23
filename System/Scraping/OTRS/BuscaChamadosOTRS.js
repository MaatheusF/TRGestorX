//Busca todos os Chamados Abertos de um Cliente no OTRS
//Parametros: ClienteNome
// Util: https://gist.github.com/tokland/d3bae3b6d3c1576d8700405829bbdb52


//Importações
const puppeteer = require('puppeteer');
const axios = require('axios');
const cheerio = require('cheerio');

var _OTRSLoginURL =             'https://suporte.chapeco-solucoes.com.br/otrs/index.pl'     //Pagina de Login do OTRS
//var _OTRSChamadosAbertosURL =   'https://suporte.chapeco-solucoes.com.br/otrs/index.pl?Action=AgentTicketSearch;Subaction=Search;StateType=Open;CustomerIDRaw=%5B056%5D%20-%20TJ'
var _OTRSLogoutURL =            'https://suporte.chapeco-solucoes.com.br/otrs/index.pl?Action=Logout;ChallengeToken='
BuscaChamadosOTRS();

async function BuscaChamadosOTRS(){

    //Configurações
    browser = await puppeteer.launch({headless: false});  //Abre o Navegador
    page = await browser.newPage();                       //Cria uma nova Pagina
    await page.setViewport({width: 1200, height: 720});         //Seta o ViewPort da Pagina
    _DadosExtraidos = [];                                   //Dados extraidos pela Função (Dados dos Chamados)

    var __LoginRealizado = await Login();
    if(__LoginRealizado == true){
        console.log('Login Realizado com Sucesso!');
        var tese = await BuscaChamadosAbertos();
    }
}

async function BuscaChamadosAbertos(){
    var _OTRSChamadosAbertosURL =   'https://suporte.chapeco-solucoes.com.br/otrs/index.pl?Action=AgentTicketSearch;Subaction=Search;StateType=Open;CustomerIDRaw=%5B056%5D%20-%20TJ';
    await page.goto(_OTRSChamadosAbertosURL, { waitUntil: 'networkidle0' });        //Navega para a Pagina do Cliente
    const content = await page.content();                                           //Pega o HTML da Pagina
    const $html = cheerio.load(content);                                            //Carrega o HTML

    dados = $html('#TicketID_55617').find('td:eq(1)').text();

    //console.log(dados);
    return dados;
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