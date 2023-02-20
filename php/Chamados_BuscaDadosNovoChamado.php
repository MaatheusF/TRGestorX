<?php
//Busca os dados para inserir nos inputs da tela de novo chamado

// Busca Lista de Clietes que possuem associação com o usua logado

function BuscalistaDeClientes(){

    include('./bin/System/db_config.php');
    $user_id = pg_escape_string($cconn, $_COOKIE['user_account_id']); #Busca o ID do Usuario nos Cookies

    $SQL_Busca_Lista_Clientes = ("SELECT cli_nome,cli_codigo FROM acg_associa_cliente_gestor acg
    JOIN cli_clientes cc ON cc.cli_codigo = acg.acg_cli_cliente_codigo 
    WHERE acg_usua_codigo_gestor = '{$user_id}'");
    
    $RESULT_Busca_Lista_Clientes = pg_query($cconn, $SQL_Busca_Lista_Clientes); //Realiza a conexão e busca a lista de clientes
    
    while ($RESULT = pg_fetch_assoc($RESULT_Busca_Lista_Clientes)){
        
        $value  = $RESULT['cli_codigo'];        //Codigo do Cliente
        $nome   = $RESULT['cli_nome'];          //Nome do Cliente
        
        echo '<option value="'.$value.'">'.$nome.'</option>';
    }
}
?>
