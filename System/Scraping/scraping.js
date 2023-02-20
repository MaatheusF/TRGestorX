const puppeteer = require('puppeteer');
const axios = require('axios');
const cheerio = require('cheerio');
//main();

async function main(){
  const browser = await puppeteer.launch({headless: false});
  const page = await browser.newPage();
  await page.setViewport({width: 1200, height: 720});
  await page.goto('http://redmine.chapeco-solucoes.com.br/login', { waitUntil: 'networkidle0' }); // Navega para a Pagina de Login
  
  login();
  async function login() {

    await page.type('#username', 'matheus.favero');
    await page.type('#password', 'favero10');
    // click and wait for navigation
    await Promise.all([
      page.click('#login-submit'),
      page.waitForNavigation({ waitUntil: 'networkidle0' }),
      console.log('Login Realizado com Sucesso!'),
    ]);
    BuscaDados('http://redmine.chapeco-solucoes.com.br/projects/gsat-desenv/issues'); // Troca a Pagina
  }

  async function BuscaDados(url){
    await page.goto(url, 
    { waitUntil: 'networkidle0' }); // wait until page load
    //await new Promise(r => setTimeout(r, 1000));
    const html = await page.content(); //HTML da Pagina
    const $ = cheerio.load(html);
    const tabelaStatus = $('#issue-36647');
    const tabelaJogador = [];
    tabelaStatus.each(function(){
        const nomeJogador = $(this).find('.id').text();
        const posicaoJogador = $(this).find('.project').text();
        const numeroGols = $(this).find('.status').text();
        const timeJogador = $(this).find('.tracker').text();
        tabelaJogador.push({
            nomeJogador,
            posicaoJogador,
            numeroGols,
            timeJogador
        });
    });
    console.log(tabelaJogador);
  }




  async function Sair(){
    await Promise.all([
      page.click('.logout'),
      page.waitForNavigation({ waitUntil: 'networkidle0' }),
      console.log('Logout realizado com sucessso!'),
    ]);
  }
}

module.exports = {
  main: main,
};

//logout

/*const axios = require('axios');
const cheerio = require('cheerio');
const url = 'https://globoesporte.globo.com/rj/futebol/campeonato-carioca/';
axios(url).then(response => {
    const html = response.data;
    const $ = cheerio.load(html);
    const tabelaStatus = $('.ranking-item-wrapper');
    const tabelaJogador = [];
    tabelaStatus.each(function(){
        const nomeJogador = $(this).find('.jogador-nome').text();
        const posicaoJogador = $(this).find('.jogador-posicao').text();
        const numeroGols = $(this).find('.jogador-gols').text();
        const timeJogador = $(this).find('.jogador-escudo > img').attr('alt');
        tabelaJogador.push({
            nomeJogador,
            posicaoJogador,
            numeroGols,
            timeJogador
        });
    });
    console.log(tabelaJogador);
}).catch(console.error);*/