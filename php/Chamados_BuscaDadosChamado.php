<?php
# PHP utilizado para Buscar Informações dos Chamados



# Busca Lista de Clietes que possuem associação com o usua logado
# Utilizado na Tela de Novo Chamado
function BuscalistaDeClientes(){

    include('./bin/System/db_config.php');
    include('../bin/System/db_config.php');
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

#Busca todos os dados de um Chamado especifico, usando a variavel $codigo
#Utilizado na Edição de um Chamado Existente
function BuscaDadosDoChamadoEdit($codigo){
    include('../bin/System/db_config.php');
    $user_id = pg_escape_string($cconn, $_COOKIE['user_account_id']); #Busca o ID do Usuario nos Cookies

    $SQL_Busca_Chamado = ("SELECT * FROM ccha_cliente_chamado ccha
    JOIN cli_clientes cc ON cc.cli_codigo = ccha.ccha_cliente_id
    WHERE ccha.codigo = $codigo");

    $RESUL_Busca_Chamado = pg_query($cconn, $SQL_Busca_Chamado);
    $RESULT = pg_fetch_assoc($RESUL_Busca_Chamado);
    return $RESULT;
}
?>
