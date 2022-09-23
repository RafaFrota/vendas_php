<?php 

include('conexao.php');
include "funcoes.php";

if(isset($_POST['ID'])) {
    if ($_POST['op'] == 0) {

        $ID = clear($_POST['ID']);
   
        $sql_code = "SELECT `ID`,`valor_venda` FROM `estoque` WHERE ID = $ID";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $result = $sql_query->fetch_assoc();
        echo $result['valor_venda'];

    }elseif ($_POST['op'] == 1) {
        
        $sql_code = "SELECT `ID`,`valor_venda` FROM `estoque` WHERE ID = $ID";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $result = $sql_query->fetch_assoc();
        echo $result['valor_venda'];
    }
    

}else{
    echo "erro!!!   " . var_dump($_POST['ID']);
}

?>