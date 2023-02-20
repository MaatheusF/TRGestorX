<?php 
include("./php/login-validador.php");
include("./php/Chamados_ListaChamados.php");
include("./php/Chamados_BuscaDadosNovoChamado.php");
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
        <script type="text/javascript">

            function LimpaAlertaSalvamentoChamado(){
                //Limpa o alerta de erro ao Salvar um chamado, quando clicar para fechar o modal
                var alert = document.getElementById("savelist-alert");
                alert.style.display = 'none';
            }

        </script>



        <!-- Container-->
        <div class="container2">



            
            <!-- Botão Flutuante nvo chamado -->
            <div class="flutu-novo">
                <button type="button" class="btn  btn-flutu-novo" data-bs-toggle="modal" data-bs-target="#modal-novo-chamado"><i class="bi bi-plus-circle btn-flutu-icon"></i></button>
            </div>

            <!-- Criar novo Chamado -->
            <!-- Modal -->
            <div class="modal fade" id="modal-novo-chamado" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" style="width: 900px;">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 id="novo-chamado-titulo">Criar novo Chamado</h5>

                            <!-- Alerta de Salvamento --> <!-- Controlado pelo JS -->
                                <div id="savelist-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Ocorreu um erro ao Salvar o Chamado!
                                    <button id="savelist-button" type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                            <!-- Formulario -->
                            <form method="post" action="./php/Chamados_InsereNovoChamado.php" target="_self">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-select form-select-sm shadow-none form-border" required data-select-search="true" id="select-prioridade" name="post-prioridade">
                                              <option value="Baixa">Baixa</option>
                                              <option value="Media">Media</option>
                                              <option value="Alta">Alta</option>
                                              <option value="Critica">Critica</option>
                                            </select>
                                            <label for="select-prioridade" style="font-size: 13px;">Prioridade</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control shadow-none select-font form-border" id="select-data" placeholder="Dia/Mes/Ano" name="post-datachamado">
                                            <label for="select-data" style="font-size: 13px;">Data do Chamado</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-select form-outline form-select-sm shadow-none select-font form-border" required id="select-cliente" name="post-cliente">
                                              <!-- <option value="Gsat">Gsat</option> -->
                                                <?php BuscalistaDeClientes(); ?>
                                            </select>
                                            <label for="select-cliente" style="font-size: 13px;">Cliente</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control shadow-none select-font form-border" id="select-ticket" placeholder="Chamado" name="post-ticket">
                                            <label for="select-ticket" style="font-size: 13px;">Ticket</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control shadow-none select-font form-border" required id="select-titulo" placeholder="Titulo" name="post-titulo">
                                            <label for="select-titulo" style="font-size: 13px;">Titulo</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control shadow-none select-font form-border" id="select-tarefa" placeholder="Tarefa" name="post-tarefa">
                                            <label for="select-tarefa" style="font-size: 13px;">Cod. Tarefa</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-fila" name="post-fila">
                                              <option value="Em Atendimento">Em Atendimento</option>
                                              <option value="Analise">Analise</option>
                                              <option value="Projeto">Projeto</option>
                                              <option value="Infraestrutura">Infraestrutura</option>
                                            </select>
                                            <label for="select-fila" style="font-size: 13px;">Fila</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-tipo" name="post-tipo">
                                              <option value="Duvida">Duvida</option>
                                              <option value="Defeito">Defeito</option>
                                              <option value="Outros">Outros</option>
                                            </select>
                                            <label for="select-tipo" style="font-size: 13px;">Tipo</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-Status" name="post-status">
                                              <option value="Novo">Novo</option>
                                              <option value="Aguardando Cliente">Aguardando Cliente</option>
                                              <option value="Pendente">Pendente</option>
                                              <option value="Em Analise">Em Analise</option>
                                              <option value="Aguardando ATT">Aguardando ATT</option>
                                              <option value="Concluido">Concluido</option>
                                            </select>
                                            <label for="select-Status" style="font-size: 13px;">Status</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating" style="margin-top: 20px;">                            
                                            <textarea class="form-control shadow-none select-font form-border" id="select-observacoes" rows="3" name="post-observacao"></textarea>
                                            <label for="select-observacoes" style="font-size: 13px;">Observações</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-btn-box">
                                    <button type="button" class="btn btn-outline-primary btn-md" data-bs-dismiss="modal" style="width: 120px; margin-right: 30px;" onclick="LimpaAlertaSalvamentoChamado()">Fechar</button>
                                    <button type="submit" class="btn btn-primary btn-md" style="width: 120px;">Finalizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <!-- Popper Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>