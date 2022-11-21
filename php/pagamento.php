<?php 

include('conexao.php');
include "funcoes.php";
//Verifica cessão 
cessao(1);


if(isset($_POST['vendapagamento'])) {
    if(isset($_POST['pagamento'])) {
        $redirect = "../Vendasrealizadas.php";
        $ID = clear($_POST['vendapagamento']);
        $pagamento = farmat_num(limpar_texto(clear($_POST['pagamento'])));
        $status = ",`status`=3";
    }   
}

if(isset($_POST['vendapfinanceiro'])) {
    if(isset($_POST['pagamento'])) {
        $redirect = "../areceber.php";
        $ID = clear($_POST['vendapfinanceiro']);
        $pagamento = farmat_num(limpar_texto(clear($_POST['pagamento'])));
        $status = "";
    }   
}

if(isset($_POST['pagamentoservico'])) {
    if(isset($_POST['pagamento'])) {
        $redirect = "../servicoativo.php";
        $ID = clear($_POST['pagamentoservico']);
        $pagamento = farmat_num(limpar_texto(clear($_POST['pagamento'])));
        $status = ",`status`=3";
        
    }   
}
$servico = 0;
if(isset($_POST['servico'])) {
    $servico = 1;
}


$validarvalor = 0;
//echo $ID . "</br>";
//$ID = 115;
// echo $redirect . "</br>";
//echo $ID . "</br>";
// echo $pagamento . "</br>";


// Validar dados

if ($servico == 1) {
    $sql_code = "SELECT * FROM `servico` WHERE ID = $ID";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $servico = $sql_query->fetch_assoc();

    if (!is_null($servico)) {
        $result = $servico['valor'] - $servico['desconto'] - $servico['valorPago'] - $pagamento;
        
        if ($result  < 0 ) {
            echo "Valor pago invalido";
            $_SESSION['err'] = "Valor pago invalido";
            $Registrar_Valor = NULL;
            $pagamento_feito = NULL;
            header("Location: $redirect");
            exit;
        }else if ($result  == 0){
            $Registrar_Valor_BD = $servico['valorPago'] + $pagamento;
            $pagamento_feito = 1;
            $Registrar_Valor = 1;
        }else if ($result  > 0){
            $Registrar_Valor_BD = $servico['valor'] - $servico['desconto'] - $servico['valorPago'] + $pagamento;
            $Registrar_Valor = 1;
            $pagamento_feito = NULL;
        }else {
            $_SESSION['err'] = "Erro na chegagem do valor Servico";
            header("Location: $redirect");
            exit;
        }

    }else{
        $_SESSION['err'] = "Erro: Registro não encontrado no banco de dados";
        header("Location: $redirect");
        
        exit;
    }


    // Salvar no banco de dados os valores de servico 
    
    if ($Registrar_Valor == 1 && $pagamento_feito == 1) {
        $sql_code = "UPDATE `servico` SET `statusPagamento`=1 $status , `valorPago`= $Registrar_Valor_BD WHERE ID = $ID";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        if ($sql_query == 1) {
            $_SESSION['msg'] = "Valor registrado com sucesso!";
            header("Location: $redirect");
            exit;
        }else{
            $_SESSION['err'] = "ERRO ao registrar servico no banco";
            header("Location: $redirect");
            exit;
        }
    }else if ($Registrar_Valor == 1 && $pagamento_feito != 1){
        $sql_code = "UPDATE `servico` SET `valorPago`= $Registrar_Valor_BD $status WHERE ID = $ID";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        if ($sql_query == 1) {
            $_SESSION['msg'] = "Valor registrado com sucesso!";
            header("Location: $redirect");
            exit;
        }else{
            $_SESSION['err'] = "ERRO ao registrar servico no banco";
            header("Location: $redirect");
            exit;
        }
    }else {
        $_SESSION['err'] = "Erro ao registrar no banco de dados";
        header("Location: $redirect");
        exit;
    }


}else if ($servico == 0){

    
    echo "ID: $ID </br>";
    $sql_code = "SELECT *, venda.ID AS id_venda,servicovenda.ID AS id_servico FROM `servicovenda` RIGHT JOIN `venda` on venda.ID = servicovenda.venda_ID WHERE venda.ID = $ID";
    echo $sql_code . "<br/>";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $servicovenda = $sql_query->fetch_assoc();
    if (!is_null($servicovenda['id_venda'])) {

        // Validar valores da tabela venda
        echo "tem servico? ". !is_null($servicovenda['id_servico']) ."<br/>";
        if (is_null($servicovenda['id_servico'])) {
            $result = $servicovenda['valormetro'] * $servicovenda['quantidadeMetros']  - $servicovenda['desconto'] - $servicovenda['pagamento'] - $pagamento;
            
            if ($result < 0 ) {
                echo "Valor pago invalido";
                $_SESSION['err'] = "Valor pago invalido";
                $Registrar_Valor = NULL;
                $pagamento_feito = NULL;
                header("Location: $redirect");
                exit;
            }else if ($result  == 0){
                echo "Result 0";
                $Registrar_Valor_BD = $servicovenda['pagamento'] + $pagamento;
                $pagamento_feito = 1;
                $Registrar_Valor = 1;
                
            }else if ($result  > 0){
                $Registrar_Valor_BD = $servicovenda['pagamento'] + $pagamento;
                $Registrar_Valor = 1;
                $pagamento_feito = NULL;
            }else {
                $_SESSION['err'] = "Erro na chegagem do valor Servico";
                header("Location: $redirect");
                exit;
            }

            // Gravar no bando de dados

            if ($Registrar_Valor == 1 && $pagamento_feito == 1) {
                $sql_code = "UPDATE `venda` SET `statusPagamento`= 1,`pagamento`=$Registrar_Valor_BD WHERE ID = $ID";
                $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                if ($sql_query == 1) {
                    $_SESSION['msg'] = "Valor registrado com sucesso!";
                    header("Location: $redirect");
                    exit;
                }else{
                    $_SESSION['err'] = "ERRO ao registrar servico no banco";
                    header("Location: $redirect");
                    exit;
                }
    
            }else if ($Registrar_Valor == 1 && is_null($pagamento_feito)){
    
                $sql_code = "UPDATE `venda` SET `pagamento`=$Registrar_Valor_BD WHERE ID = $ID";
                $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                if ($sql_query == 1) {
                    $_SESSION['msg'] = "Valor registrado com sucesso!";
                    header("Location: $redirect");
                    exit;
                }else{
                    $_SESSION['err'] = "ERRO ao registrar servico no banco";
                    header("Location: $redirect");
                    exit;
                }
            
            }else {
                $_SESSION['err'] = "Erro ao validar registro no banco de dados";
                header("Location: $redirect");
                exit;
            }

        }else{
        

    
            //validating values
            $result = $servicovenda['valormetro'] * $servicovenda['quantidadeMetros'] + $servicovenda['valServico'] - $servicovenda['valorPago'] - $servicovenda['desconto'] - $servicovenda['pagamento'] - $pagamento;
            echo $servicovenda['valormetro'] . "<br/>";
            echo $servicovenda['quantidadeMetros'] . "<br/>";
            echo $servicovenda['desconto'] . "<br/>";
            echo $servicovenda['pagamento'] . "<br/>";
            echo "/////////////////////////////////////</br>";
            echo $servicovenda['valServico'] . "<br/>";
            echo $servicovenda['valorPago'] . "<br/>";
            
            $tabela_venda = $servicovenda['valormetro'] * $servicovenda['quantidadeMetros'] - $servicovenda['desconto'] - $servicovenda['pagamento'];
            $tabela_servico = $servicovenda['valServico'] - $servicovenda['valorPago'];
            echo "/////////////////////////////////////</br>";
            echo $result . "<br/>";
            echo $tabela_venda . "<br/>";
            echo $tabela_servico . "<br/>";
            
            if ($pagamento > ($tabela_venda + $tabela_servico)) {
                echo "Valor pago invalido";
                $_SESSION['err'] = "Valor pago invalido";
                $Registrar_Valor = NULL;
                $pagamento_feito = NULL;
                header("Location: $redirect");
                exit;
            }else if ($pagamento <= $tabela_venda) {
                $Registrar_Valor_BD_venda = $pagamento;
                $Registrar_Valor_BD_servico = NULL;
                $Registrar_Valor = 1;
                if(($pagamento - $tabela_venda) == 0){
                    $pagamento_feito = 1;
                }else{
                    $pagamento_feito = 0;
                }
                
            }else if($pagamento <= ($tabela_venda + $tabela_servico)){
                if ($tabela_venda == 0){
                    $Registrar_Valor_BD_venda = $servicovenda['pagamento'];
                    $Registrar_Valor_BD_servico = $pagamento + $servicovenda['valorPago'];
                    
                }else{
                    $Registrar_Valor_BD_venda = $tabela_venda + $servicovenda['pagamento'];
                    $Registrar_Valor_BD_servico = $pagamento - $tabela_venda + $servicovenda['valorPago'];
                }
                 
                $Registrar_Valor = 1;
                if(($pagamento - $tabela_venda - $tabela_servico) == 0){
                    $pagamento_feito = 1;
                }else{
                    $pagamento_feito = 0;
                }
            }else {
                $_SESSION['err'] = "Erro na checagem do valor Venda e Servico";
                header("Location: $redirect");
                exit;
            }


            // Gravar no banco de dados venda e servico


        if ($Registrar_Valor == 1 && $pagamento_feito == 1) {
            echo "Aqui </br> `pagamento:` $Registrar_Valor_BD_venda </br>";
            $sql_code = "UPDATE `venda` SET `statusPagamento`= 1,`pagamento`=$Registrar_Valor_BD_venda WHERE ID = $ID";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
            if ($sql_query == 1) {
                $_SESSION['msg'] = "Valor registrado com sucesso!";
                header("Location: $redirect");
                exit;
            }else{
                $_SESSION['err'] = "ERRO ao registrar servico no banco";
                header("Location: $redirect");
                exit;
            }

        }else if ($Registrar_Valor == 1 && $pagamento_feito == 0){

            $sql_code = "UPDATE `venda` SET `pagamento`=$Registrar_Valor_BD_venda WHERE ID = $ID";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
            if ($sql_query == 1) {
                $_SESSION['msg'] = "Valor registrado com sucesso!";
                header("Location: $redirect");
                exit;
            }else{
                $_SESSION['err'] = "ERRO ao registrar servico no banco";
                header("Location: $redirect");
                exit;
            }
        
        }else {
            $_SESSION['err'] = "Erro ao validar registro no banco de dados";
            echo "Erro ao validar registro no banco de dados </br>"; 
            header("Location: $redirect");
            exit;
        }


        echo "Registrar servico: $Registrar_Valor_BD_servico";
        // registrar valor servico 
        if ($Registrar_Valor_BD_servico > 0) {
            
            $sql_code = "UPDATE `servicovenda` SET `valorPago`=$Registrar_Valor_BD_servico $status WHERE venda_ID = $ID";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
            if ($sql_query == 1) {
                $_SESSION['msg'] = "Valor registrado com sucesso!";
                header("Location: $redirect");
                exit;
            }else{
                $_SESSION['err'] = "ERRO ao registrar servico no banco";
                header("Location: $redirect");
                exit;
            }
        }
    }    

    }else{
        $_SESSION['err'] = "Erro: Registro da venda não encontrado no banco de dados";
        header("Location: $redirect");
        exit;
    } 

}else {
    "erro!!";
}

//header("Location: $redirect");









?>