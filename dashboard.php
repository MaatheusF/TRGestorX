<?php
session_start();
include("./php/login-validador.php");
?>

<html>
    <head>
        <!-- https://www.youtube.com/watch?v=m05-kE_tSB8&ab_channel=JS -->
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
        <script src="./js/Dashboard/Graficos/InstanciaGrafico_DefeitoStatus.js"></script>
        <script src="./js/Dashboard/Graficos/InstanciaGrafico_ChamadosAbertos.js"></script>
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/topbar.css" rel="stylesheet">
        <title>GestorX - DashBoard</title>
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

            <!-- Menu Lateral -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px;">
           
                <ul class="nav nav-pills flex-column mb-auto">

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span style="margin-bottom: 20px;">Indicadores Chamados</span>
                    </h6>

                    <!-- Menu Item Tarefas Gerais-->
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-link-black active" id="v-pills-tarefas-gerais-menu" data-bs-toggle="pill" data-bs-target="#v-pills-menu-tarefas-gerais-conteudo" type="button" role="tab" aria-controls="v-pills-menu-tarefas-gerais-conteudo" aria-selected="true">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                            Chamados Abertos
                        </a>
                    </li>

                </ul>
            </div>




            <!-- Conteudo -->
            <div class="tab-content conteudo-container" id="v-pills-tabContent">



                <!-- Agenda -->
                <div class="tab-pane fade conteudo-box" id="v-pills-menu-agenda-conteudo" role="tabpanel" aria-labelledby="v-pills-agenda-menu" tabindex="0">
                    
                    <h6 class="px-3 mt-4 mb-1 text-muted text-uppercase" style="text-align: center;">Agenda</h6>
                    <hr>

                </div>


                <!-- Chamados Gerais -->
                <div class="tab-pane fade show active conteudo-box" id="v-pills-menu-tarefas-gerais-conteudo" role="tabpanel" aria-labelledby="v-pills-tarefas-gerais-menu" tabindex="0">
                    
                    <h6 class="px-3 mt-4 mb-1 text-muted text-uppercase" style="text-align: center;">Total de Chamados Abertos sob Gestão</h6>
                    <hr>

                    <!-- Graficos Container-->
                    <!--
                    <div>
                        <div class="row TR-cliente-row">
                            <h6 style="text-align: center;margin-top: 5px;">Gsat</h6>
                            <div class="col-4 TR-grafico">
                                <canvas id="pie-chamados-status"></canvas>
                                <script>InstanciaGrafico_ChamadosAbertos('pie-chamados-status');</script>          
                            </div>
                            <div class="col-4 TR-grafico">
                                <canvas id="pie-chamados-fila"></canvas>
                                <script></script>    
                            </div>
                            <div class="col-4 TR-grafico">
                                <canvas id="pie-chamados-tipo"></canvas>
                                <script></script>    
                            </div>
                        </div>
                    </div>-->
                    <div class="row TR-cliente-row">
                        <canvas id="pie-chamados-abertos"></canvas>
                        <script>InstanciaGrafico_ChamadosAbertos('pie-chamados-abertos')</script>
                    </div>
                </div>
            </div>

        </main>




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>