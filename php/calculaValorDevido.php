<?php

    function calculaVenda($ID){
        include('conexao.php');
        
        $sql_code = "SELECT * FROM `servicovenda` RIGHT JOIN venda ON servicovenda.venda_ID = venda.ID WHERE venda.ID = $ID";
        //echo $sql_code;
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $servicovenda = $sql_query->fetch_assoc();
        //var_dump($servicovenda);
        // echo $servicovenda['valServico'] ."<br>";
        // echo $servicovenda['valorPago']."<br>";

        // echo "<br>";
        
        // echo $ID ."<br>";
        // echo $servicovenda['valormetro'] ."<br>";
        // echo $servicovenda['quantidadeMetros'] ."<br>";
        // echo $servicovenda['desconto'] ."<br>";
        // echo $servicovenda['pagamento']."<br>";
        
        if (is_null($servicovenda["valServico"])) {
            $result = $servicovenda['valormetro'] * $servicovenda['quantidadeMetros'] - $servicovenda['desconto'] - $servicovenda['pagamento'];
        }else{
            $result = $servicovenda['valormetro'] * $servicovenda['quantidadeMetros'] + $servicovenda['valServico'] - $servicovenda['desconto'] - $servicovenda['pagamento'] - $servicovenda['valorPago'];
        }
        

        // echo "</br>";
        // echo "</br>" . $result;
        return $result;
    }  
    
    
    function cauculaservi($ID_servi){
        include('conexao.php');
        //echo $ID_servi. "</br>";
        $sql_code = "SELECT * FROM `servico` WHERE ID = $ID_servi";
        //echo $sql_code;
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $servicovenda = $sql_query->fetch_assoc();
              
        //var_dump($servicovenda);

        $result = $servicovenda['valor'] - $servicovenda['desconto'] - $servicovenda['valorPago'];
        //echo $result;
        return $result;
    }   
        
       
       
    
?>