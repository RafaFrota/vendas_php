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
//limpar_texto(" asdasdas 122,50 mdsfg");
function limpar_texto($str){ 
    $str = preg_replace("/[^0-9]/", "", $str);
    return substr_replace($str, '.', -2, 0);
}

function farmat_num($num){ 
    return number_format($num, 2, '.', ''); 
}
  
function farmat_virgula($num){ 
    return number_format($num, 2, ',', ''); 
}


?>