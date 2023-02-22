<?php 
include("./Chamados_BuscaDadosChamado.php");

$CodigoChamado = $_GET['CodigoChamado'];                        //Codigo do Chamado retornado pelo chamados.php
$DadosChamado = BuscaDadosDoChamadoEdit($CodigoChamado);        //Roda a Função para buscar os dados do Chamado
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link href="../css/chamados_iframe_edit.css" rel="stylesheet">
    </head>



    <body style="width: 1050px;">
        <form id="container" class="teste" method="post" action="./Chamado_Salvar_EditarChamado.php">
            <h6 style="text-align: center;">Editar Chamado</h6>
        
            <div class="row" style="margin-top: 25px;">

                <!-- Prioridade -->
                <div class="col">
                    <div class="form-floating">
                        <select class="form-select form-select-sm shadow-none form-border" required data-select-search="true" id="select-prioridade" name="post-prioridade">
                            <option value="Baixa"   <?php if($DadosChamado['ccha_prioridade'] == "Baixa")   {echo 'selected';}  ?>   >Baixa</option>
                            <option value="Media"   <?php if($DadosChamado['ccha_prioridade'] == "Media")   {echo 'selected';}  ?>   >Media</option>
                            <option value="Alta"    <?php if($DadosChamado['ccha_prioridade'] == "Alta")    {echo 'selected';}  ?>   >Alta</option>
                            <option value="Critica" <?php if($DadosChamado['ccha_prioridade'] == "Critica") {echo 'selected';}  ?>   >Critica</option>
                        </select>
                        <label for="select-prioridade" style="font-size: 13px;">Prioridade</label>
                    </div>
                </div>

                <!-- Data do Chamado -->
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" required class="form-control shadow-none select-font form-border" id="select-data" placeholder="Dia/Mes/Ano" name="post-datachamado" value="<?php echo $DadosChamado['ccha_data']; ?>">
                        <label for="select-data" style="font-size: 13px;">Data do Chamado</label>
                    </div>
                </div>

                <!-- Cliente  -->
                <div class="col">
                    <div class="form-floating">
                        <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-cliente" name="post-cliente">
                            <option value="<?php echo $DadosChamado['cli_codigo']; ?>"> <?php echo $DadosChamado['cli_nome']; ?> </option>
                            <?php //BuscalistaDeClientes(); ?>
                        </select>
                        <label for="select-cliente" style="font-size: 13px;">Cliente</label>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Ticket  -->
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" required class="form-control shadow-none select-font form-border" id="select-ticket" placeholder="Chamado" name="post-ticket" value="<?php echo $DadosChamado['ccha_ticket']; ?>">
                        <label for="select-ticket" style="font-size: 13px;">Ticket</label>
                    </div>
                </div>

                <!-- Cod. Tarefa  -->
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow-none select-font form-border" id="select-tarefa" placeholder="Tarefa" name="post-tarefa" value="<?php echo $DadosChamado['ccha_tarefa_cod']; ?>">
                        <label for="select-tarefa" style="font-size: 13px;">Cod. Tarefa</label>
                    </div>
                </div>

                <!-- Fila  -->
                <div class="col">
                    <div class="form-floating">
                        <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-fila" name="post-fila">
                            <option value="Em Atendimento"    <?php if($DadosChamado['ccha_fila'] == "Em Atendimento")   {echo 'selected';}  ?>   >Atendimento</option>
                            <option value="Analise"           <?php if($DadosChamado['ccha_fila'] == "Analise")          {echo 'selected';}  ?>   >Analise</option>
                            <option value="Projeto"           <?php if($DadosChamado['ccha_fila'] == "Projeto")          {echo 'selected';}  ?>   >Projeto</option>
                            <option value="Infraestrutura"    <?php if($DadosChamado['ccha_fila'] == "Infraestrutura")   {echo 'selected';}  ?>   >Infraestrutura</option>
                        </select>
                        <label for="select-fila" style="font-size: 13px;">Fila</label>
                    </div>
                </div>        
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="form-floating">
                        <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-tipo" name="post-tipo">
                            <option value="Duvida"  <?php if($DadosChamado['ccha_tipo'] == "Duvida")    {echo 'selected';}  ?>   >Duvida</option>
                            <option value="Defeito" <?php if($DadosChamado['ccha_tipo'] == "Defeito")   {echo 'selected';}  ?>   >Defeito</option>
                            <option value="Outros"  <?php if($DadosChamado['ccha_tipo'] == "Outros")    {echo 'selected';}  ?>   >Outros</option>
                        </select>
                        <label for="select-tipo" style="font-size: 13px;">Tipo</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-Status" name="post-status">
                            <option value="Novo"                <?php if($DadosChamado['ccha_status'] == "Novo")                {echo 'selected';}  ?>  >Novo</option>
                            <option value="Aguardando Cliente"  <?php if($DadosChamado['ccha_status'] == "Aguardando Cliente")  {echo 'selected';}  ?>  >Aguardando Cliente</option>
                            <option value="Pendente"            <?php if($DadosChamado['ccha_status'] == "Pendente")            {echo 'selected';}  ?>  >Pendente</option>
                            <option value="Em Analise"          <?php if($DadosChamado['ccha_status'] == "Em Analise")          {echo 'selected';}  ?>  >Em Analise</option>
                            <option value="Aguardando ATT"      <?php if($DadosChamado['ccha_status'] == "Aguardando ATT")      {echo 'selected';}  ?>  >Aguardando ATT</option>
                            <option value="Concluido"           <?php if($DadosChamado['ccha_status'] == "Concluido")           {echo 'selected';}  ?>  >Concluido</option>
                        </select>
                        <label for="select-Status" style="font-size: 13px;">Status</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input shadow-none" type="checkbox" role="switch" id="post-SwitchAlerta" <?php if($DadosChamado['ccha_alerta'] == 'S') {echo 'checked';} ?> disabled >
                        <label class="form-check-label" for="SwitchAlerta">Ativar Alerta</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input shadow-none" type="checkbox" role="switch" id="post-SwitchBloquear" <?php if($DadosChamado['ccha_bloqueado'] == 'S') {echo 'checked';} ?> disabled >
                        <label class="form-check-label" for="SwitchBloquear">Bloquear Chamado</label>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 16px;">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow-none select-font form-border" required id="select-titulo" placeholder="Titulo" name="post-titulo" value="<?php echo $DadosChamado['ccha_titulo']; ?>">
                        <label for="select-titulo" style="font-size: 13px;">Titulo</label>
                    </div>
                </div>
                <!--
                <div class="col-4">
                    <div class="form-floating">
                        <select class="form-select form-outline form-select-sm shadow-none select-font form-border" id="select-Status" name="post-status">
                        <option value="Novo"></option>    
                        <option value="Novo">Agurdando Analise</option>
                            <option value="Aguardando Cliente">Em Analise</option>
                            <option value="Pendente">Aguardando Comercial</option>
                            <option value="Em Analise">Aguardando Aprovação</option>
                            <option value="Aguardando ATT">Aprovado</option>
                            <option value="Concluido">Em Execução</option>
                            <option value="Concluido">Concluído</option>
                        </select>
                        <label for="select-Status" style="font-size: 13px;">Projeto Status</label>
                    </div>
                </div> -->
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating">                            
                        <textarea class="form-control shadow-none select-font form-border" id="select-observacoes" rows="3" name="post-observacao"><?php echo $DadosChamado['ccha_observacoes']; ?></textarea>
                        <label for="select-observacoes" style="font-size: 13px;">Observações</label>
                    </div>
                </div>
            </div>
            <input type="text" style="display: none;" name="post-codigo" value="<?php echo $DadosChamado['codigo']; ?>"> <!-- Envia no POST o codigo do Chamado a ser editado -->
            <div id="modal-btn-box">
                <button type="submit" id="salvar-btn" class="btn btn-primary btn-md" style="width: 120px;background-color: #8117c9;">Finalizar</button>
            </div>
        </form>
        
        
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>