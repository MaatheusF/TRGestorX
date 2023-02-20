<?php
//Recebe os dados do Cadastro de Chamados
include('../bin/System/db_config.php');
$post_prioridade    = $_POST['post-prioridade'];
$post_datachamado   = $_POST['post-datachamado'];
$post_cliente       = $_POST['post-cliente'];
$post_ticket        = $_POST['post-ticket'];
$post_titulo        = $_POST['post-titulo'];
$post_tarefa        = $_POST['post-tarefa'];
$post_fila          = $_POST['post-fila'];
$post_tipo          = $_POST['post-tipo'];
$post_status        = $_POST['post-status'];
$post_observacao    = $_POST['post-observacao'];

$user_id = $_COOKIE['user_account_id']; #Busca o ID do Usuario nos Cookies

if($post_tarefa == null){
    $post_tarefa = null;
}

/*
if($post_datachamado == null){
    $post_datachamado = date("d/m/Y");    
}*/


#INATIVO
function BuscaChamadosDuplicados(){
    include('./bin/System/db_config.php');

    $SQL_BuscaChamadoTicket = ("SELECT * FROM ccha_cliente_chamado ccc WHERE ccha_ticket = '{$post_ticket}'");
    $RESULT_BuscaChamadoTicket = pg_query($cconn, $SQL_BuscaChamadoTicket);

    //Verifica se ouve retorno de alguma informação
    if(pg_num_rows($RESULT_BuscaChamadoTicket) >= 1){
        
    }

    ##INATIVO
}


include('../bin/System/db_config.php');

$SQL_Insere_Chamado = pg_query_params($cconn,"INSERT INTO public.ccha_cliente_chamado
(ccha_titulo, ccha_data, ccha_cliente_id, ccha_fila, ccha_tipo, ccha_status, ccha_tarefa_cod, ccha_usua_proprietario, ccha_ticket, ccha_prioridade)
VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10);", 
array($post_titulo,$post_datachamado, $post_cliente,$post_fila,$post_tipo,$post_status,$post_tarefa,$user_id,$post_ticket,$post_prioridade));

//pg_query($cconn, $SQL_Insere_Chamado);

/*
$SQL_Insere_Chamado = ("INSERT INTO public.ccha_cliente_chamado
(ccha_titulo, ccha_data, ccha_cliente_id, ccha_fila, ccha_tipo, ccha_status, ccha_tarefa_cod, ccha_usua_proprietario, ccha_ticket, ccha_prioridade)
VALUES('{$post_titulo}',{$post_datachamado},$post_cliente,'{$post_fila}','{$post_tipo}','{$post_status}',$post_tarefa,$user_id,'{$post_ticket}','{$post_prioridade}');");

pg_query($cconn, $SQL_Insere_Chamado);
*/
$_SESSION['NovoChamadoSalvo'] = true;
header('Location: ../chamados.php');
?>