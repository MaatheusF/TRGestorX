<?php 
# Recebe os Dados Editados no Modal de Edição de Chamados e Salva as Informações no Banco de Dados

//Recebe os dados do Cadastro de Chamados
include('../bin/System/db_config.php');
$post_prioridade    = $_POST['post-prioridade'];
$post_datachamado   = $_POST['post-datachamado'];
//$post_cliente       = $_POST['post-cliente'];
$post_ticket        = $_POST['post-ticket'];
$post_titulo        = $_POST['post-titulo'];
$post_tarefa        = $_POST['post-tarefa'];
$post_fila          = $_POST['post-fila'];
$post_tipo          = $_POST['post-tipo'];
$post_status        = $_POST['post-status'];
$post_observacao    = $_POST['post-observacao'];
$post_codigo        = $_POST['post-codigo'];
//$post_alarme        = $_POST['post-SwitchAlarme'];      #Não Implementado
//$post_bloquear      = $_POST['post-SwitchBloquear'];    #Não Implementado

$user_id = $_COOKIE['user_account_id'];                   #Busca o ID do Usuario nos Cookies

//Altera o valor da Variavel
if($post_tarefa == null){
    $post_tarefa = null;
}


include('../bin/System/db_config.php');

#Atualiza o Chamado
$SQL = "UPDATE public.ccha_cliente_chamado
SET ccha_titulo= $1, ccha_data= $2, ccha_fila= $3, ccha_tipo= $4, ccha_status= $5, ccha_tarefa_cod=$6, ccha_ticket=$7, ccha_prioridade=$8, ccha_observacoes=$9
WHERE codigo=$10; ";

$SQL_Atualiza_Chamado = pg_query_params($cconn, $SQL, array($post_titulo, $post_datachamado, $post_fila, $post_tipo, $post_status, $post_tarefa, $post_ticket, $post_prioridade, $post_observacao, $post_codigo));

$_SESSION['ChamadoEditadoSalvo'] = true;
header('Location: Chamados_ModalEditarChamado.php?CodigoChamado='.$post_codigo);




?>