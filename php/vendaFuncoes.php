<?php

function somar_estoque($produto,$quantidademetros){
    include "conexao.php";
    $sql_code = "SELECT SUM(estoque_metros_quadrados) FROM `controle_estoque` WHERE id_estoque = $produto";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $soma_estoque = $sql_query->fetch_assoc();
    //echo $soma_estoque['SUM(estoque_metros_quadrados)'] . "<br>";
    //echo $quantidademetros . "<br>";
    if($soma_estoque['SUM(estoque_metros_quadrados)'] >= $quantidademetros && $quantidademetros != 0 && $quantidademetros != ""){
        return 1;    
    }else {
        $soma_estoque['SUM(estoque_metros_quadrados)'] = farmat_virgula($soma_estoque['SUM(estoque_metros_quadrados)']);
        return "Quantidade em estoque é " . $soma_estoque['SUM(estoque_metros_quadrados)'] . " m³, por favor, coloque um valor valido.";
    }

    // echo $sql_code . "<br>";
    // echo $soma_estoque['SUM(valor_compra)'] . "<br>" . $soma_estoque['SUM(estoque_metros_quadrados)'];
    
}

function estoque($produto,$quantidademetros){
    include "conexao.php";
    $controle = TRUE;
    //$estoque = 30;
    do{
        $sql_code = "SELECT `estoque_metros_quadrados` FROM `controle_estoque` WHERE `id_estoque` = $produto LIMIT 1";
        //echo $sql_code . " </br>";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $estoque = $sql_query->fetch_assoc();
        $result = $estoque['estoque_metros_quadrados'] - $quantidademetros;
        //echo $result . "</br>";
        if ($result < 0){

            $sql_code = "DELETE FROM `controle_estoque` WHERE `id_estoque` = $produto LIMIT 1";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
            $quantidademetros =- $result; 
            //echo $result . "</br>";
                        
        }else if ($result == 0){
            $sql_code = "DELETE FROM `controle_estoque` WHERE `id_estoque` = $produto LIMIT 1";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
            $controle = FALSE;
            $quantidademetros =- $result; 
            //echo $result . "</br>";
                        
        }else if($result > 0){

            $sql_code = "UPDATE `controle_estoque` SET `estoque_metros_quadrados`= $result WHERE `id_estoque` = $produto LIMIT 1";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
            $quantidademetros =- $result; 
            $controle = FALSE;
                //echo $result . "</br>";
        }else {
            return 0;
        }

    }while($controle);
    return 1;
}

function validar_op_pagamento($statuspagamento, $valormetro, $quantidademetros, $desconto,$input_pagamento, $chack, $valservico){
    if ($statuspagamento == 1) {
        return $valormetro * $quantidademetros - $desconto;
    }else if ($statuspagamento == 2){
        if ($chack == 1){
            $result = ($valormetro * $quantidademetros) + $valservico - $desconto;
           // echo $valservico . "  pagamento_serv</br>";
            //echo $result . "  result</br>";
            
            if ($result < $input_pagamento) {
                //echo "Algo errado com o pagamento";
                //echo "aqui";
                return -1;
            }else if ($result >= $input_pagamento){
                //echo $result . "  aqui mesmo </br>";
                return ($valormetro * $quantidademetros) - $desconto;
            }
        }else {
            //echo "aqui";
            $result = ($valormetro * $quantidademetros) - $desconto;
           
           // echo $input_pagamento . "  result</br>";
            // echo $result;
            if ($result < $input_pagamento) {
                return -1;
            }else if ($result >= $input_pagamento){
                return $input_pagamento;
            }
            
        }
    }else if ($statuspagamento == 3){
        return 0.00;
    }else {
        //return FALSE;
    }
    
}

function Cadastro_venda($cliente,$produto,$valormetro,$quantidademetros_BD,$oppagamento,$statuspagamento,$desconto, $pagamento, $id_user, $valservico, $chack){
    include "conexao.php";
    echo $chack;
    if ($chack == 1) {
        $result = $valormetro * $quantidademetros_BD + $valservico - $desconto;
    }else{
        $result = $valormetro * $quantidademetros_BD - $desconto;
    }

    if ($result == $pagamento){
        $statuspagamento = 1;
    }else{
        $statuspagamento = 2;
    }

    $result = $valormetro * $quantidademetros_BD - $desconto;

    $sql_code = "INSERT INTO `venda`(`cliente`, `produto`, `valormetro`, `quantidadeMetros`, `formaDePagamento`, `statusPagamento`,`desconto`, `pagamento`, `user_ID`) VALUES ($cliente,$produto,$valormetro,$quantidademetros_BD,$oppagamento,$statuspagamento,$desconto,$pagamento,$id_user)";
    //echo $sql_code . "</br>";
    $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $idsql = $mysqli->insert_id;
    
    return $idsql;

}

function Cadastro_servico($valservico,$Profissional,$descricao,$valormetro,$quantidademetros,$desconto,$input_pagamento,$idproduto){
    include "conexao.php";
    // echo "------------------------------------------</br>";
    // echo $valormetro . "</br>";
    // echo $quantidademetros . "</br>";
    // echo $valservico . "</br>";
    // echo $desconto . "</br>";
    // echo $input_pagamento . "</br>"; 
    

    $pagamento_serv = $valormetro * $quantidademetros - $desconto - $input_pagamento;
    //echo $pagamento_serv . "</br>";
    if ($pagamento_serv < 0) {
        $pagamento_serv = abs($pagamento_serv);
    }else{
        $pagamento_serv = 0;
    }
    
    
    $sql_code = "INSERT INTO `servicovenda`(`profissional`, `descricao`, `valServico`, `valorPago`, `venda_ID`) VALUES ($Profissional, '$descricao',$valservico, $pagamento_serv,$idproduto)";
    //echo $sql_code . "</br>";
    $result = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    
    return $result;
}