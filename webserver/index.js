// == Configuraçãoes do WebServer
const http = require("http");
const host = '192.168.0.107';
const port = 8080;

// == Importações dos Métodos/Rotas do WebService
const teste3 = require('./teste3');
const info = require('./Rotas/Info');
const _BuscaTarefasCliente = require('../System/Scraping/Redmine/BuscaTarefasCliente');     //Busca as Tarefas de um Cliente
const _BuscaChamadosOTRS = require('../System/Scraping/OTRS/BuscaChamadosOTRS')             //Busca os Chamados do OTRS de um Cliente

//const teste = require('../System/Scraping/scraping');

// == Listenes do WebService
const requestListener = async function (req, res) {

    // == OLD == 
        // Ao utilizar Retorno Direto:
            //res.writeHead(200);
            //res.end("My first server!");
        // Ao Utilizar retorno em JSON
            //res.setHeader("Content-Type", "application/json");
            //res.writeHead(200);
            //res.end(`{"message": "This is a JSON response"}`);

    //Switch de Rotas
    switch (req.url) {

        case "/BuscaTarefasCliente":
            res.writeHead(200);
            res.end(JSON.stringify(await _BuscaTarefasCliente.BuscaTarefasClienteMain()));
            break

        case "/BuscaChamadosOTRS":
            res.writeHead(200);
            res.end(JSON.stringify(await _BuscaChamadosOTRS.BuscaChamadosOTRS()));
            break

        case "/Info":
            res.writeHead(200);
            res.end(JSON.stringify(await info.Info()));
            break

        //Rota Teste com importação
        case "/teste":
            res.writeHead(200);
            res.end('teste ' + teste3.teste3retorno());
            //res.end(books);
            break
        
        //Retorno Padrão
        default:
            res.writeHead(404);
            res.end(JSON.stringify({error:"Recurso não encontrado, Verifique o método Utilizado!"}));
    }
};


//WebService
const server = http.createServer(requestListener);
server.listen(port, host, () => {
    console.log(`Servidor rodando na Porta http://${host}:${port}`);
});