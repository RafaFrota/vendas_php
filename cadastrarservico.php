<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(1);
include "php/menu.php";
$msg = "";
 // Registrar produto
    if(isset($_POST['Profissional']) && isset($_POST['descricao']) && isset($_POST['valservico']) && isset($_POST['valservico']) && isset($_POST['valservico'])) {          
        
               
            $pagamento_serv = limpar_texto(clear($_POST['valservico']));       
            $valservico = limpar_texto(clear($_POST['valservico']));
            $Profissional = clear($_POST['Profissional']);
            $descricao = clear($_POST['descricao']);
            $formaPagamento = clear($_POST['oppagamento']);
            $valorPago = limpar_texto(clear($_POST['pagamento']));
            $statusPagamento = clear($_POST['statuspagamento']);
            if(!empty($_POST['desconto'])){
                // var_dump($_POST['desconto']);
                $desconto = limpar_texto(clear($_POST['desconto']));
            }else{
                $desconto = 0.00;
            }
            
            $user_id = clear($_SESSION['id']);

            if ($_POST['statuspagamento'] == 1) {
                
                $valorPago = $valservico;
            }else if ($_POST['statuspagamento'] == 3){
                
                $valorPago = 0;
            }
            if ($valorPago+$desconto <= $valservico) {
            
                // echo $pagamento_serv . "</br>";
                
                // echo $valservico . "</br>";
                // echo $Profissional . "</br>";
                // echo $descricao . "</br>";
                // echo $formaPagamento . "</br>";
                // echo $valorPago . "</br>";
                // echo $desconto  . "</br>";
                // echo $user_id . "</br>";
            

                $sql_code = "INSERT INTO `servico`(`valor`, `profissional`, `descricao`, `formdaPagamento`, `desconto`, `valorPago`, `status`, `statusPagamento`, `user_id`) VALUES ($valservico, $Profissional, '$descricao', $formaPagamento, $desconto, $valorPago, 1, $statusPagamento, $user_id)";
                // echo $sql_code;    
                $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
            }else{
                $msg = "Valor recebido maior que o valor do serviço";
            }
        
                    
    }

// GET cliente
$sql_code = "SELECT * FROM `user`";
$sql_query_user = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

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

    

    <!-- Page level custom scripts -->
    <script src="js/my_js.js"></script>

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
                <h1 class="h3 mb-2 text-gray-800">Registrar Servico</h1>
                <h4 style="color: rgba(223, 0, 0, 0.7);"><?php echo $msg ?></h4>
                
                    
                    
                    <!-- Collapsable Card Example -->
                    

                    <!-- Collapsable Card Example -->
                    <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#vender" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="vender">
                                    <h6 class="m-0 font-weight-bold text-primary">Serviço</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="vender">
                                    <div class="card-body">
                                    <form class="was-validated " action="" method="POST">
                                        <div class="container-servico">  
                                            <div class="form-row " >
                                                <div class="col-md-12 mb-3">
                                                <label for="valservico" >Valor do serviço: </label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                                        </div>
                                                    <input type="text" class="form-control money" id="valservico" placeholder="Valor recebido" name="valservico">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="Profissional">Profissional responsavel: </label>
                                                    <select class="custom-select" name="Profissional" id="responsavel" required>
                                                        <option value="">---</option>
                                                        
                                                        <?php 
                                                        
                                                        while($row = $sql_query_user->fetch_assoc()) {
                                                            echo '<option value="'. $row['ID'] . '">'. $row['nome'] . ' </option>';
                                                        }
                                                        
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="desc"> Descrição do Serviço </label>
                                                    <textarea class="form-control" id="desc" rows="3" name="descricao" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="validationCustom02">Forma de pagamento: </label>
                                                        <select class="custom-select" name="oppagamento" required>
                                                            <option value="">---</option>
                                                            <option value="1">A vista</option>
                                                            <option value="2">Cartão de credito</option>
                                                            <option value="3">Cartão de debito</option>
                                                            <option value="3">PIX</option>
                                                        </select>
                                                </div>
                                                
                                                <div class="form-group col-md-6 ">
                                                    <label for="pagamento">Pagamentos</label>
                                                        <select class="custom-select" name="statuspagamento" id="pagamento" required>
                                                            <option value="">---</option>
                                                            <option value="1">Pagamento efetuado</option>
                                                            <option value="2">Pagamento parcial</option>
                                                            <option value="3">Pagamento pendente</option>
                                                        </select>
                                                </div>
                                        </div>
                                        <div class="form-row container-pagamento" style="display: none;">
                                            <div class="col-md-12 mb-3">
                                                <label for="valor-recebido">Valor recebido: </label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text"  class="form-control money require" id="valor-recebido " placeholder="Valor recebido" name="pagamento" >
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <div class="form-row " >
                                            <div class="col-md-12 mb-3">
                                                <label for="valor-desconto">Desconto: </label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                                    </div>
                                                    <input type="text" class="form-control money" id="valor-desconto" placeholder="Valor desconto" name="desconto" >
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <button class="btn btn-primary" type="submit"> Cadastrar </button>
                                    </form>
                                    </div>
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
    <script src="js/jquery.maskMoney.js" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            $('.money').mask("0000000000,00" , { reverse: true });
            
        });
        var btn_pagamento = document.getElementById('pagamento');
        var container_pagamento = document.querySelector('.container-pagamento');
        var valor_recebido = document.querySelector('.require');

        btn_pagamento.addEventListener('change', function() {
            
            //console.log(btn_pagamento.value);
            if (btn_pagamento.value == 2) {
                container_pagamento.style.display = 'block';
                valor_recebido.setAttribute('required', '');
                
                
            }else{
                container_pagamento.style.display = 'none';
                valor_recebido.removeAttribute('required');
                
            }
            
        });
    </script>    
</body>

</html>