<?php
session_start();

if(isset($_POST['input-busca'])){
    BuscaChamadosFunc($_POST['input-busca']);
}

function BuscaChamadosFunc($BuscarSTR){
    include('../rootlocale.php');
    include('../bin/System/db_config.php');
    $user_id = $_COOKIE['user_account_id'];         #Busca o ID do Usuario nos Cookies
    $result_chamados = [];

    $pg_query_buscar = "
    select * from ccha_cliente_chamado ccc
    join cli_clientes cc on cc.cli_codigo = ccha_cliente_id
    where ccha_titulo ilike $1
    or ccha_fila ilike $1
    or ccha_titulo ilike $1
    or ccha_status ilike $1
    or ccha_data = $3
    or ccha_ticket ilike $1
    or ccha_prioridade ilike $1
    or cc.cli_nome ilike $1
    or ccha_tarefa_cod = $2
    ORDER BY ccha_data_cadastro asc";

    $pg_result_buscar = pg_query_params($cconn, $pg_query_buscar, array('%'.$BuscarSTR.'%',null,null));

    while ($result = pg_fetch_assoc($pg_result_buscar)) {

        //Variaveis
        $cor_status;          //Cor do Status
        $cor_fonte;           //Cor da Fonte
        $alerta_fonte = null; //Cor da fonte na exibição do alerta
        $alerta_ativo = null; //Status do Alerta

        //Seletor de Cor do Status
        switch($result["ccha_status"]){
            case "Novo":
                $cor_status = "bg-novo";
                $cor_fonte = "fonte-white";
                break;
            case "Em Analise":
                $cor_status = "bg-emanalise";
                $cor_fonte = "fonte-white";
                break;
            case "Pendente":
                $cor_status = "bg-danger";
                $cor_fonte = "fonte-white";
                break;
            case "Aguardando ATT":
                $cor_status = "bg-aguardandoatt";
                $cor_fonte = "fonte-white";
                break;
            case "Aguardando Cliente":
                $cor_status = "bg-aguardandocliente";
                $cor_fonte = "fonte-white";
                break;
            case "Concluido":
                $cor_status = "bg-concluido";
                $cor_fonte = "fonte-black";
                break;
        }

        if($result["ccha_alerta"] == "S"){
            $alerta_ativo = 'bg-danger';
            $alerta_fonte = "fonte-white";
            $cor_status = null;
        }

        $result_chamados[] =  '<tr class="'.$alerta_ativo.' '.$alerta_fonte.'">
                <td scope="row">'.$result["ccha_prioridade"].'</td>
                <td>'.$result["ccha_data"].'</td>
                <td>'.$result["cli_nome"].'</td>
                <td>'.$result["ccha_ticket"].'</td>
                <td>'.$result["ccha_titulo"].'</td>
                <td>'.$result["ccha_fila"].'</td>
                <!--<td>'.$result["ccha_tipo"].'</td>--!>
                <td class="'.$cor_status.' '.$cor_fonte.'">'.$result["ccha_status"].'</td>
                <td>'.$result["ccha_tarefa_cod"].'</td>
                <td>Não Imp</td>
                <td></td>
              </tr>';
    }
    $_SESSION['BuscaChamadosFunc'] = $result_chamados;
    header('Location: ../chamados.php');
}

?>