<?php 
include "conexao.php";

function clear($input){
    global $mysqli;

    $var = mysqli_escape_string($mysqli, $input);
    $var = htmlspecialchars($var);
    
    return $var;

}

function cessao($nivel_cesso){

    if(!isset($_SESSION)) {
        session_start();
    }
    
    if(!isset($_SESSION['id'])) {
        header("Location: login.php");
    }
    
    // Nivel 1 - ADM
    // Nivel 2 - user
    if($nivel_cesso < $_SESSION['adm']) {
        header("Location: login.php");
    }

}

?>