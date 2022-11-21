<?php

include "conexao.php";

// echo $_POST["op"] . "   ///////////////     ";
// echo $_POST["id"];

if (isset($_POST["op"])) {
    $op = $_POST["op"];
}
if (isset($_POST["id"])) {
    $id = $_POST["id"];
}

if ($op == 0) {
    echo "aqui 1";
    $sql_code = "UPDATE `servicovenda` SET `status`= 3 WHERE venda_ID = $id";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    echo 1;
    
}else if ($op == 2) {
    //echo $id;
    $sql_code = "UPDATE `servico` SET `status`= 3 WHERE ID = $id";
    //echo $sql_code;
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    echo 1;

}else{
    echo "ERRO";
}