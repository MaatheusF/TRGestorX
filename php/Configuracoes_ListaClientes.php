<?php
$clientes = null;

session_start();
//Verifica se o Post é para Salvar a Lista e Chama o Método
if(isset($_POST['SalvaListaClientes'])) {
    $clientes = $_POST;                         //Guarda os Dados do Post em uma Array
    unset($clientes['SalvaListaClientes']);     //Remove o Nome/Valor do Botão de Submit
    SalvaClientes($clientes);                   //Inicia a Gravação dos Dados
}



function BuscaClientes(){
    include('./rootlocale.php');
    include('./bin/System/db_config.php');
    $user_id = $_COOKIE['user_account_id'];         #Busca o ID do Usuario nos Cookies


    $pg_query_listaclientes = "select cc.cli_nome,cc.cli_codigo from cli_clientes cc";

    //Busca os dados no banco
    $pg_result_listaclientes= pg_query($cconn, $pg_query_listaclientes);
    while ($result = pg_fetch_assoc($pg_result_listaclientes)) {
        
        
        //Verifica se está Marcado
        $pg_query_verificaMarcado = pg_query($cconn,"select acg_usua_codigo_gestor from acg_associa_cliente_gestor aacg where acg_usua_codigo_gestor = $user_id and acg_cli_cliente_codigo = ".$result['cli_codigo']."");
        $pg_result_verificaMarcado = pg_fetch_assoc($pg_query_verificaMarcado);
        
        //print_r($$pg_result_verificaMarcado['acg_usua_codigo_gestor']);

        if(isset($pg_result_verificaMarcado['acg_usua_codigo_gestor']) == $user_id){
            $Check = 'checked';
        } else {
            $Check = null;
        }
    
        //Impreme os Clientes
        echo '<div class="col-4">
                <div class="form-check cliente-checkbox form-check">
                    <input class="form-check-input" type="checkbox" name="'.$result['cli_nome'].'" value="'.$result['cli_codigo'].'" id="flexCheckDefault" '.$Check.'>
                    <label class="form-check-label" for="flexCheckDefault">
                        '.$result['cli_nome'].'
                    </label>
                </div>
            </div>';
    }
}

function SalvaClientes($clientes){
    include('../rootlocale.php');
    include('../bin/System/db_config.php');

    $user_id = $_COOKIE['user_account_id'];         #Busca o ID do Usuario nos Cookies


    #Deleta todos os Registros de vinculo do Usuario na ACG
    $pg_query_delete = "DELETE FROM acg_associa_cliente_gestor WHERE acg_usua_codigo_gestor = ".$user_id."";
    pg_query($cconn, $pg_query_delete);


    #Grava os Registros Novos
    foreach ($clientes as $valor) {
        $pg_query_insert = "INSERT INTO public.acg_associa_cliente_gestor(acg_codigo, acg_cli_cliente_codigo, acg_usua_codigo_gestor)
        VALUES(0,".$valor.",".$user_id.");
        ";
        pg_query($cconn, $pg_query_insert);
    }
    $_SESSION['ListaClientesSalva'] = true;
    header('Location: ../configuracoes.php');
}

?>