//Busca todas as tarefas abertas de um Cliente Especifico atravez do WebService
//Metodo TarefaCliente
//Parametros: ClienteNome

//Importações
const puppeteer = require('puppeteer');
const axios = require('axios');
const cheerio = require('cheerio');

async function BuscaTarefasClienteMain(){

    const browser = await puppeteer.launch({headless: false});  //Abre o Navegador
    const page = await browser.newPage();                       //Cria uma nova Pagina
    await page.setViewport({width: 1200, height: 720});         //Seta o ViewPort da Pagina
    var _DadosExtraidos = [];                                   //Dados extraidos pela Função
    
    //Controle de Execução
    var __LoginRealizado = await Login();                  //Inicia o Login

    if(__LoginRealizado == true)
    { 
       _DadosExtraidos = await BuscaDados();               //Busca os Dados
       GravaBanco();
       //console.log(_DadosExtraidos);
    };   


    /* ===== Metodos ===== */

    /* Realiza o Login na Pagina Principal */
    async function Login(){
        await page.goto('http://redmine.chapeco-solucoes.com.br/login', { waitUntil: 'networkidle0' }); // Navega para a Pagina de Login
        await page.type('#username', 'matheus.favero');                                                 // Usuario
        await page.type('#password', 'favero10');                                                       // Senha

        await Promise.all([
            page.click('#login-submit'),                            //Clica no Botão de Entrar
            page.waitForNavigation({ waitUntil: 'networkidle0' }),  //Aguarda o Carregamento da Pagina
            console.log('Login Realizado com Sucesso!'),
        ]);
        return true;
    }

    async function BuscaDados(){
        var url = 'http://redmine.chapeco-solucoes.com.br/projects/gsat-desenv/issues?utf8=%E2%9C%93&set_filter=1&sort=id%3Adesc&f%5B%5D=status_id&op%5Bstatus_id%5D=o&f%5B%5D=&c%5B%5D=project&c%5B%5D=tracker&c%5B%5D=status&c%5B%5D=subject&c%5B%5D=assigned_to&c%5B%5D=estimated_hours&c%5B%5D=cf_36&c%5B%5D=cf_20&c%5B%5D=cf_19&c%5B%5D=closed_on&group_by=&t%5B%5D=';
        await page.goto(url, { waitUntil: 'networkidle0' });        //Navega para a Pagina do Cliente
        const content = await page.content();                       //Pega o HTML da Pagina
        const $html = cheerio.load(content);                        //Carrega o HTML

        const _GridTarefas = $html('.issue');                       //Elemento de Inicio do Grid de Tarefas
        const _Tarefas = [];                                        //Array que armazena os dados

        _GridTarefas.each(function(){
            const _ID = $html(this).find('.id').text();        
            const _Projeto = $html(this).find('.project').text();
            const _Tipo = $html(this).find('.tracker').text();
            const _Situacao = $html(this).find('.status').text();
            const _Titulo = $html(this).find('.subject').text();
            const _OTRS = $html(this).find('.cf_36').text();
            const _AlteradoEm = $html(this).find('.updated_on').text();
            const _CriadoEm = $html(this).find('.created_on').text();
            const _WEB = $html(this).find('.cf_20').text();
            const _Desktop = $html(this).find('.cf_19').text();


            //Armazena os dados no Array
            _Tarefas.push({
                _ID,
                _Projeto,
                _Tipo,
                _Situacao,
                _Titulo,
                _OTRS,
                _AlteradoEm,
                _CriadoEm,
                _WEB,
                _Desktop
            });
        });
        console.log(_Tarefas);
        return _Tarefas;
        
    }

    function GravaBanco(){
        const { Pool } = require('../../../webserver/node_modules/pg') //Importa o Postgres
        const pool = new Pool({
            host: 'localhost',
            user: 'postgres',     
            password: 'favero10',
            database: 'gestorxdb',
            port: 5432
        })

        const pool2 = new Pool({
            host: 'localhost',
            user: 'postgres',     
            password: 'favero10',
            database: 'gestorxdb',
            port: 5432
        })

        const pool3 = new Pool({
            host: 'localhost',
            user: 'postgres',     
            password: 'favero10',
            database: 'gestorxdb',
            port: 5432
        })

        for(var i = 0; i < (_DadosExtraidos.length - 1); i++){
            //Verifica se existe a tarefa no Banco
            console.log('Dentro do For' + i)
            GravaDados(i);
        };

        async function GravaDados(i){


            console.log('Verificando Tarefa ' + i);

            //pool.query("select * from ctar_cliente_tarefa cct where codigo = " + _DadosExtraidos[i]._ID + " and ctar_cliente_nome = '" + _DadosExtraidos[i]._Projeto + "' and ctar_tipo = '" + _DadosExtraidos[i]._Tipo + "' and ctar_situacao = '" + _DadosExtraidos[i]._Situacao + "' and ctar_titulo = '" + _DadosExtraidos[i]._Titulo + "' and ctar_otrs = '" + _DadosExtraidos[i]._OTRS + "' and ctar_data_alteracao = '" + _DadosExtraidos[i]._AlteradoEm + "' and ctar_data_cadastro = '" + _DadosExtraidos[i]._CriadoEm + "' and ctar_web = '" + _DadosExtraidos[i]._WEB + "' and ctar_desktop = '" + _DadosExtraidos[i]._Desktop +"'", async (err, res) => {

            pool.query("select * from ctar_cliente_tarefa cct where codigo = " + _DadosExtraidos[i]._ID, async (err, res) => {
            console.log('Efetuando Select ' +i);
                if(res.rowCount == 0){
                    console.log('Inserindo Tarefa ' + i);
                    //Tarefa não encontrada, realizar inserção
                    pool.query("INSERT INTO public.ctar_cliente_tarefa (codigo, ctar_cliente_nome, ctar_tipo, ctar_situacao, ctar_titulo, ctar_otrs, ctar_data_alteracao, ctar_data_cadastro, ctar_web, ctar_desktop) VALUES("+ _DadosExtraidos[i]._ID +",'"+_DadosExtraidos[i]._Projeto+"', '"+_DadosExtraidos[i]._Tipo+"', '"+_DadosExtraidos[i]._Situacao+"', '"+_DadosExtraidos[i]._Titulo+"', '"+_DadosExtraidos[i]._OTRS+"', '"+_DadosExtraidos[i]._AlteradoEm+"', '"+_DadosExtraidos[i]._CriadoEm+"', '"+_DadosExtraidos[i]._WEB+"', '"+_DadosExtraidos[i]._Desktop+"');", (err, res) => {
                        console.log('Tarefa Inserida:');
                    });
                } else {
                    pool.query("UPDATE public.ctar_cliente_tarefa SET ctar_cliente_nome = '" + _DadosExtraidos[i]._Projeto + "', ctar_tipo = '" + _DadosExtraidos[i]._Tipo + "', ctar_situacao = '" + _DadosExtraidos[i]._Situacao + "', ctar_titulo = '" + _DadosExtraidos[i]._Titulo + "', ctar_otrs = '" + _DadosExtraidos[i]._OTRS + "', ctar_data_alteracao = '" + _DadosExtraidos[i]._AlteradoEm + "', ctar_data_cadastro = '" + _DadosExtraidos[i]._CriadoEm + "', ctar_web = '" + _DadosExtraidos[i]._WEB + "', ctar_desktop = '" + _DadosExtraidos[i]._Desktop + "' where codigo = " + _DadosExtraidos[i]._ID + ";");
                    console.log('Tarefa encontrada ' + _DadosExtraidos[i]._ID);
                }
            });
        }

    }

}






module.exports = {
    BuscaTarefasClienteMain: BuscaTarefasClienteMain,
  };