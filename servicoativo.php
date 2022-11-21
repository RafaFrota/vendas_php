<?php 

include "php/conexao.php";
include "php/funcoes.php";
include "php/calculaValorDevido.php";


//Verifica cessão 
cessao(2);
include "php/menu.php";

$servico = '';
if (isset($_POST['iniciar'])) {
    $id = $_POST['iniciar'];

    $sql_code = "UPDATE `servicovenda` SET `status`= 2 WHERE ID = $id";
    //echo $sql_code;
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    if ($sql_query == 1) {
        $_SESSION['msg'] = "Serviço iniciado";
    }else{
        $_SESSION['err'] = "Erro ao cadastrar no banco!";
    }

    
}else if (isset($_POST['concluir'])) {
    $id = $_POST['concluir'];
    $result = calculaVenda($id);

    if ($result == 0) {
        $sql_code = "UPDATE `servicovenda` SET `status`= 3 WHERE venda_ID = $id";
        //echo $sql_code;
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        if ($sql_query == 1) {
            $_SESSION['msg'] = "Serviço encerrado!";
        }else{
            $_SESSION['err'] = "Erro ao cadastrar no banco!";
        }
    }else{
        $IDmodal= $id;
        $op = 1;
        $modal = "$('#receberModal').modal('show');";
        $apagar = farmat_virgula($result);
    }
    

}

if (isset($_POST['iniciarserv'])) {
    $id = $_POST['iniciarserv'];

    $sql_code = "UPDATE `servico` SET `status`= 2 WHERE ID = $id";
    //echo $sql_code;
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    if ($sql_query == 1) {
        $_SESSION['msg'] = "Serviço iniciado";
    }else{
        $_SESSION['err'] = "Erro ao cadastrar no banco!";
    }

    
}else if (isset($_POST['concluirserv'])) {
    $id = $_POST['concluirserv'];
    $result = cauculaservi($id);

    if ($result == 0) {
        $sql_code = "UPDATE `servico` SET `status`= 3 WHERE ID = $id";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        if ($sql_query == 1) {
            $_SESSION['msg'] = "Serviço encerrado!";
        }else{
            $_SESSION['err'] = "Erro ao cadastrar no banco!";
        }

    }else{
        $IDmodal= $id;
        $op = 2;
        $servico = '<input type="checkbox" style="display: none;" name="servico" checked readonly>';
        $modal = "$('#receberModal').modal('show');";
        $apagar = $result;
    }

}

// GET categoria
$prof_ID = $_SESSION['id'];
$sql_code = "SELECT servicovenda.ID, servicovenda.profissional, servicovenda.descricao, servicovenda.valServico,servicovenda.venda_ID, servicovenda.status , statusservico.nome AS idstatus FROM `servicovenda` INNER JOIN statusservico ON servicovenda.status = statusservico.ID WHERE status < 3 AND profissional = $prof_ID";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

$sql_code_s = "SELECT servico.`ID`, servico.`valor`, servico.`profissional`, servico.`descricao`, servico.`status`, statusservico.`nome` FROM `servico` INNER JOIN statusservico ON servico.status = statusservico.ID WHERE status < 3 AND profissional = $prof_ID";
$sql_query_s = $mysqli->query($sql_code_s) or die("Falha na execução do código SQL: " . $mysqli->error);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Meu style-->
    <link href="css/meustyle.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php echo $menu_lateal; ?>




        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                
                <?php echo $top_menu; ?>



                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800"> Serviços ativos </h1>
                    <p class="mb-4"> Aqui você vê todos os seus serviços pendentes. </p>
                    </br>
                    <?php 
                    if(isset($_SESSION['err'])){
                        echo '<H5 style="color: rgba(245, 39, 39, 0.8);">';
                        echo $_SESSION['err']; 
                        unset($_SESSION['err']);
                    }else if (isset($_SESSION['msg'])) {
                        echo '<H5 style="color: rgba(20, 177, 0, 0.8);">';
                        echo $_SESSION['msg']; 
                        unset($_SESSION['msg']);
                    }
                    
                    ?>

                    <div class="card-columns">
                        <?php 
                        
                            while($row = $sql_query->fetch_assoc()) {
                                
                                
                                echo '<div class="card ">
                                <div class="card-body">
                                                ';
                                                var_dump($row);
                                                echo '<p class="card-text" style="color: rgba(0, 198, 43, 0.7)"> venda </p>';
                                                if ($row['status'] == 1) {
                                                    echo '<p class="card-text" style="color: rgba(0, 198, 43, 0.7)"> Status: '. $row['idstatus'] .'</p>
                                                    <h5 class="card-title"> Descrição: '. $row['descricao'] .'</h5>
                                                    <form action="" method="post">
                                                <button type="submit" class="btn btn-secondary" value="'.$row['ID'].'" name="iniciar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
                                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
                                                    </svg>
                                                    Iniciar
                                                </button>
                                                </form> ';   
                                                }else if ($row['status'] == 2) {
                                                    echo '<p class="card-text" style="color: rgba(19, 0, 255, 0.7)" > Status: '. $row['idstatus'] .'</p>
                                                    <h5 class="card-title"> Descrição: '. $row['descricao'] .'</h5>
                                                    <form action="" method="post">
                                                <button type="submit" class="btn btn-success" value="'.$row['venda_ID'].'" name="concluir">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
                                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
                                                    </svg>
                                                    Concluir
                                                </button>
                                                </form> '; 
                                                }
                                                
                                    echo '</div>
                                </div>';
                            }

                            while($row = $sql_query_s->fetch_assoc()) {
                                
                                
                                echo '<div class="card ">
                                <div class="card-body">
                                                ';
                                                
                                                
                                                if ($row['status'] == 1) {
                                                    echo '<p class="card-text" style="color: rgba(0, 198, 43, 0.7)"> Status: '. $row['nome'] .'</p>
                                                    <h5 class="card-title"> Descrição: '. $row['descricao'] .'</h5>
                                                    <form action="" method="post">
                                                <button type="submit" class="btn btn-secondary" value="'.$row['ID'].'" name="iniciarserv">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
                                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
                                                    </svg>
                                                    Iniciar
                                                </button>
                                                </form> ';   
                                                }else if ($row['status'] == 2) {
                                                    echo '<p class="card-text" style="color: rgba(19, 0, 255, 0.7)" > Status: '. $row['nome'] .'</p>
                                                    <h5 class="card-title"> Descrição: '. $row['descricao'] .'</h5>
                                                    <form action="" method="post">
                                                <button type="submit" class="btn btn-success" value="'.$row['ID'].'" name="concluirserv">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
                                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
                                                    </svg>
                                                    Concluir
                                                </button>
                                                </form> '; 
                                                }
                                                
                                    echo '</div>
                                </div>';
                            }

                            
                    
                        ?>
                        
                    </div>
                    
                    <div class="modal fade" id="receberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Foi feito o pagamento na entrega?</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body"><div id="total_areceber"></div>
                                                <form class="was-validated " action="php/pagamento.php" method="POST">
                                                <div class="col-md-12 mb-3">
                                                        <p>O valor devido é de R$ <?php echo $apagar?></p>
                                                        <label for="valor_produto">Valor Recebido: </label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                                            </div>
                                                            <input type="text" class="form-control " id="money" value="" id="valor_produto" placeholder="Valor do produto" name="pagamento" aria-describedby="basic-addon1">
                                                            <?php echo $servico ?>
                                                        </div>
                                                        <!-- <input type="text" class="form-control money" value="" id="valor_produto" placeholder="Valor do produto" name="valormetro" Readonly> -->
                                                    </div>
                                                </div>
                                                
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                    <button type="button" name="pagamentoservico" onclick="sempagamento(<?php echo $IDmodal ?>,<?php echo $op ?> );" id="cadastravalor" value="" class="btn btn-danger">Sem pagamento</button>
                                                    <button type="submit" name="pagamentoservico" id="cadastravalor" value="<?php echo $IDmodal ?>" class="btn btn-success">Fechar venda</button>
                                                </div>       
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                    
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php echo $LogoutModal ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/jquery.mask.js" type="text/javascript"></script>                   
    
    
<script>
$(document).ready(function() {
    
    
    <?php
        echo $modal;
    ?>
    $('#money').mask("0000000000,00" , { reverse: true });
     
        
});

function sempagamento(id, op){
    
    $.ajax({
        url : 'php/concluirser.php',
        dataType : 'html',
        type : 'POST',
        data : {op: op , id: id},
        beforeSend : function () {
            console.log('Carregando...');
        },
        success : function(retorno){
            if (retorno == 1) {
                window.location.href = "servicoativo.php";
            }
            
        },
        error : function(a,b,c){
            alert('Erro: ' + a['status'] + ' ' + c);
        }
    });
}


</script>
</body>

</html>