<?php
# Busca todos os Chamados e Plota na Tela de Chamados

# Regras:
    # Busca todos os Chamados que estejam Abertos (Não Concluidos)
    # Busca todos os Chamados criados para os Clientes associados ao Usuario logado
    # Ordena os Chamados por Ordem de Cadastro


session_start();

function BuscaTodosChamados(){

    include('./rootlocale.php');
    include('./bin/System/db_config.php');
    $user_id = $_COOKIE['user_account_id'];         #Busca o ID do Usuario nos Cookies

    $pg_query_chamados = "SELECT * FROM ccha_cliente_chamado ccc
    JOIN cli_clientes cc ON cc.cli_codigo = ccha_cliente_id
    JOIN acg_associa_cliente_gestor aacg on aacg.acg_cli_cliente_codigo = cc.cli_codigo 
    WHERE ccha_status != 'Concluido'
    AND aacg.acg_usua_codigo_gestor = $user_id
    ORDER BY ccha_data_cadastro asc";

    $pg_result_chamados = pg_query($cconn, $pg_query_chamados);

    while ($result = pg_fetch_assoc($pg_result_chamados)) {
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


        //Constroi o Link do Chamado para direcionar ao OTRS
        $OTRS_Link = 'https://suporte.chapeco-solucoes.com.br/otrs/index.pl?ChallengeToken=THGYujeIDdKWFvEa88aH1VmWDlLQ62nz&Action=AgentTicketSearch&Subaction=Search&EmptySearch=1&ShownAttributes=LabelFulltext%3BLabelTicketNumber&Profile=&Name=&Fulltext=&TicketNumber='.$result["ccha_ticket"].'&Attribute=&ResultForm=Normal';

        echo '<tr class="'.$alerta_ativo.' '.$alerta_fonte.'">
                <td scope="row">'.$result["ccha_prioridade"].'</td>
                <td>'.$result["ccha_data"].'</td>
                <td>'.$result["cli_nome"].'</td>
                <td>'.$result["ccha_ticket"].'</td>
                <td>'.$result["ccha_titulo"].'</td>
                <td>'.$result["ccha_fila"].'</td>
                <td>'.$result["ccha_tipo"].'</td>
                <td class="'.$cor_status.' '.$cor_fonte.'">'.$result["ccha_status"].'</td>
                <td>'.$result["ccha_tarefa_cod"].'</td>
                <td>Não Imp</td>
                <td style="width: 110px;">
                    <div class="td-icon-bandeja">
                        <button class="td-icon-btn"><i class="bi bi-eye-fill td-icon"></i></button>
                        <a onclick="CriaModalEditarChamado('.$result['codigo'].')" href="" class="td-icon-btn" data-bs-toggle="modal" data-bs-target="#modal-editar-chamado"><i class="bi bi-pencil-square td-icon"></i></a>
                        <a class="td-icon-btn" href="'.$OTRS_Link.'" target="_blank" style="margin-left: 10px;"><i class="bi bi-box-arrow-right td-icon"></i></a>
                    </div>
                </td>
              </tr>';
    }

    //INSERT INTO public.ccha_cliente_chamado
    //(codigo, ccha_titulo, ccha_data, ccha_cliente_id, ccha_fila, ccha_tipo, ccha_status, ccha_tarefa_cod, ccha_usua_proprietario, ccha_bloqueado, ccha_ticket)
    //VALUES(0, '', '', 0, '', '', '', 0, 0, '', '');

}


?>