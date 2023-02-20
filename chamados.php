<?php 
include("./php/login-validador.php");
include("./php/Chamados_ListaChamados.php");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <title>GestorX - Chamados</title>
        <link href="css/chamados.css" rel="stylesheet">
        <link href="css/topbar.css" rel="stylesheet">
        <script src="js/chamados-buscar.js"></script>
    </head>



    <!-- NavBar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark" aria-label="Fifth navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" id="header-title" href="#">GestorX</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu Equerda-->
                <div class="collapse navbar-collapse" id="navbarsExample05">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./tarefas.php">Tarefas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./chamados.php">Chamados</a>
                        </li>
                    </ul>

                    <!-- Menu Direita-->
                    <div>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="./configuracoes.php">Configurações</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <body>

        <!-- Container-->
        <div class="container2">

            <!-- Botão Flutuante -->
            <div class="flutu-novo">
                <button class="btn-flutu-novo"><i class="bi bi-plus-circle btn-flutu-icon"></i></button>
            </div>

            <!-- Cabeçalho do Filtro -->
            <div id="filtro-box">

                <!-- Buscar Input -->
                <div id="filtro-box-esqueda">
                    <form class="input-group" id="btn-buscar" method="post" target="_self" action="./php/Chamados_BuscaChamados.php">
                        <input type="text" class="form-control form-control-sm" placeholder="Buscar..." value="" id="input-busca" name="input-busca" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-primary btn-sm" type="submit" id="button-filtro-buscar">Buscar</button>
                       <!-- <a class="btn btn-warning btn-sm" type="button" id="button-filtro-limpar" href="./chamados.php">Limpar</a> -->
                    </form>   
                </div>
            </div>

            <!-- Tabela -->
            <table class="table" id="tabela-box">
                <thread>
                    <tr>
                        <!-- https://cursos.alura.com.br/forum/topico-como-eu-poderia-fazer-para-ordenar-a-tabela-67980 -->
                        <th scope="col" class="cabeçalho-item">Prioridade</th>
                        <th scope="col" class="cabeçalho-item">Data</th>
                        <th scope="col" class="cabeçalho-item">Cliente</th>
                        <th scope="col" class="cabeçalho-item">Ticket</th>
                        <th scope="col" class="cabeçalho-item">Titulo</th>
                        <th scope="col" class="cabeçalho-item">Fila</th>
                        <th scope="col" class="cabeçalho-item">Tipo</th>
                        <th scope="col" class="cabeçalho-item">Status</th>
                        <th scope="col" class="cabeçalho-item">Tarefa Cód</th>
                        <th scope="col" class="cabeçalho-item">Tarefa Stats</th>
                        <th scope="col" class="cabeçalho-item">Ações</th>
                    </tr>
                </thread>

                <tbody style="font-size: 12px;" id="tabela-chamados-corpo">
                    
                    <!-- Busca todos os Chamados -->
                    <?php if(!isset($_SESSION['BuscaChamadosFunc'])){
                        BuscaTodosChamados();
                    }           
                    ?>      

                    <!-- Busca os Chamados com Filtro -->
                    <?php 
                        if(isset($_SESSION['BuscaChamadosFunc'])){;
                            for($i = 0; $i < count($_SESSION['BuscaChamadosFunc']); $i++){
                                print_r($_SESSION['BuscaChamadosFunc'][$i]);
                            }
                            unset($_SESSION['BuscaChamadosFunc']);
                        }
                    ?>

                    <!--<tr>
                        <td scope="row">Baixa</td>
                        <td>15/02/2023</td>
                        <td>Gsat</td>
                        <td>2023021550000421</td>
                        <td>PGR DESATIVADOS APARECENDO NO SISTEMA WEB TRAFEGUS</td>
                        <td>Analise</td>
                        <td>Defeito</td>
                        <td>Aguardando ATT</td>
                        <td>355425</td>
                        <td>Aguardando Informação</td>
                        <td></td>
                    </tr>-->
                </tbody>
            </table>
        </div>

        
    </body>
</html>