<?php
include("./php/login-validador.php");
include("./php/Configuracoes_ListaClientes.php");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="css/topbar.css" rel="stylesheet">
        <link href="css/configuracoes.css" rel="stylesheet">
        <title>GestorX - Main Page</title>


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
        <main class="d-flex flex-nowrap" style="height: 94.25%;">

            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;margin-right: 15px;" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            
                <ul class="nav nav-pills flex-column mb-auto">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span style="margin-bottom: 20px;">Configurações da Conta</span>
                    </h6>    

                    <li class="nav-item">
                        <a class="nav-link nav-link-black active" type="button" id="v-pills-meus-clientes-menu" data-bs-toggle="pill" data-bs-target="#v-pills-meus-clientes-conteudo" type="button" role="tab" aria-controls="v-pills-meus-clientes-conteudo" aria-selected="true">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                            Meus Clientes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link nav-link-black" id="v-pills-dados-pessoais-menu" data-bs-toggle="pill" data-bs-target="#v-pills-dados-pessoais-conteudO" type="button" role="tab" aria-controls="v-pills-dados-pessoais-conteudO" aria-selected="false">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                            Dados Pessoais
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link nav-link-black">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                            Aparencia
                        </a>
                    </li>

                    <hr>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span style="margin-bottom: 20px;">Configurações do Sistema</span>
                    </h6>   

                    <li class="nav-item">
                        <a href="#" class="nav-link nav-link-black">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                            Contas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link nav-link-black">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                            Clientes
                        </a>
                    </li>

                    <li class="nav-item" style="margin-top: 10px;">
                        <a href="#" class="nav-link nav-link-black">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                            Sistema
                        </a>
                    </li>

                    
                </ul>
            </div>

            <!-- Conteudo -->
            <div class="tab-content conteudo-container" id="v-pills-tabContent">

                <!-- Meus Clientes-->
                <div class="tab-pane fade show active conteudo-box" id="v-pills-meus-clientes-conteudo" role="tabpanel" aria-labelledby="v-pills-meus-clientes-menu" tabindex="0">
                    
                    <!-- Alerta de Salvamento --> <!-- Controlado pelo JS -->
                    <?php 
                        if(isset($_SESSION['ListaClientesSalva'])){
                            echo '
                            <div id="savelist-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                                Lista de Clientes salvo com Sucesso!
                                <button id="savelist-button" type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                    ?>
                    
                    
                    
                    
                    <h6 class="px-3 mt-4 mb-1 text-muted text-uppercase" style="text-align: center;">Meus Clientes</h6>
                    <h6 style="font-weight:lighter; font-size: 12px;text-align: center;margin-top: 15px;color: rgb(63, 63, 63);">Selecione os Clientes da sua Carteira. Está seleção será responsavel pelos dados exibidos no GestorX!</h6>
                    <hr>
                    <div class="flex">
                        <form method="post" action="./php/Configuracoes_ListaClientes.php">
                            <div class="container">
                                <div class="row align-items-start">
                                    <!-- PHP -->
                                    <?php BuscaClientes(); ?> <!-- Busca a Lista de Clientes e instancia na Pagina -->
                                    <!-- PHP -->
                                </div>                               
                            </div>
                            <button type="submit" name="SalvaListaClientes" value="SalvaListaClientes" class="btn btn-sm btn-dark" style="margin-top: 25px;margin-right: 35px; float: right;">Salvar</button>
                        </form>
                    </div>
                </div>

                <!-- Dados Pes-->
                <div class="tab-pane fade conteudo-box" id="v-pills-dados-pessoais-conteudo" role="tabpanel" aria-labelledby="v-pills-dados-pessoais-menu" tabindex="0">
                    <h6 class="px-3 mt-4 mb-1 text-muted text-uppercase" style="text-align: center;">Dados Pessoais</h6>
                    <h6 style="font-weight:lighter; font-size: 12px;text-align: center;margin-top: 15px;color: rgb(63, 63, 63);">Edite e Gerencie seus dados pessoais e configurações gerais da conta!</h6>
                    <hr>
                </div>
            </div>
        </main>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>

<?php 
session_destroy();
?>