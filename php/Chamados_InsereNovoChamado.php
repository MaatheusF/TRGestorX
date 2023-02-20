<?php
//Recebe os dados do Cadastro de Chamados


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

$SQL_Insere_Chamado = ("INSERT INTO public.ccha_cliente_chamado
(ccha_titulo, ccha_data, ccha_cliente_id, ccha_fila, ccha_tipo, ccha_status, ccha_tarefa_cod, ccha_usua_proprietario, ccha_ticket, ccha_prioridade)
VALUES('{$post_titulo}',$post_datachamado,$post_cliente,'{$post_fila}','{$post_tipo}','{$post_status}',$post_tarefa,$user_id,'{$post_ticket}','{$post_prioridade}');");
//, {$post_datachamado}, {$post_cliente}, {$post_fila}, {$post_tipo}, {$post_status}, {$post_tarefa}, {$user_id}, {$post_ticket}, {$post_prioridade}); 
pg_query($cconn, $SQL_Insere_Chamado);

$_SESSION['NovoChamadoSalvo'] = true;
?>