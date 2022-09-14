<?php 
include "conexao.php";

function clear($input){
    global $mysqli;

    $var = mysqli_escape_string($mysqli, $input);
    $var = htmlspecialchars($var);
    
    return $var;

}

function cessao(){

    if(!isset($_SESSION)) {
        session_start();
    }
    
    if(!isset($_SESSION['id'])) {
        header("Location: login.php");
    }

}

?>