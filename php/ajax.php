<?php 

include('conexao.php');
include "funcoes.php";
$_POST['ID'] = 30;
$_POST['op'] = 0;
if(isset($_POST['ID'])) {  
    if($_POST['ID'] != 0) {
    if ($_POST['op'] == 0) {

        $ID = clear($_POST['ID']);
   
        $sql_code = "SELECT `ID`,`valor_venda` FROM `estoque` WHERE ID = $ID";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $result = $sql_query->fetch_assoc();

        if (mb_strpos($result['valor_venda'], '.') !== false) {
            echo 'true';
        }
        

        $resultado = substr_replace($result['valor_venda'], ',00', 20, 0);
        echo $resultado;

    }elseif ($_POST['op'] == 1) {
        
        $sql_code = "SELECT `ID`,`valor_venda` FROM `estoque` WHERE ID = $ID";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $result = $sql_query->fetch_assoc();
        echo $result['valor_venda'];
    }
}else{
    // selecione um campo
} 

}else{
    echo "erro!!!";
}

?>