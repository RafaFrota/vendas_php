<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(1);
include "php/menu.php";



// GET categoria
$sql_code = "SELECT venda.valormetro,venda.quantidadeMetros,venda.statusPagamento,estoque.Nome, venda.pagamento,cliente.nome FROM `venda` INNER JOIN cliente on venda.cliente = cliente.ID INNER JOIN estoque on venda.produto = estoque.ID;";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

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

                    <h1 class="h3 mb-2 text-gray-800"> Vendas realizadas </h1>
                    <p class="mb-4"> Aqui você vê todas as vendas realizadas. </p>
                    </br>
                    <?php 
                    
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg']; 
                        unset($_SESSION['msg']);
                    }
                    
                    ?>

                    <div class="card-columns">
                    <?php 
                    
                        while($row = $sql_query->fetch_assoc()) {
                            $valor_a_pagar = $row['valormetro'] * $row['quantidadeMetros'];
                            if ($row['statusPagamento'] == 1 ) {
                                $pagamento = "Pagamento feito";
                            }else {
                                $result = $valor_a_pagar - $row['pagamento'];
                                $pagamento = "Falta R$" .$result. " para quitar";
                            }
                            
                            echo '<div class="card ">
                            <div class="card-body">
                                            <p class="card-title"> Produto: '. $row['Nome'] .'</p>
                                            <p class="card-text"> Cliente: '. $row['nome'] .'</p>
                                            <p class="card-text"> Valor da venda: R$'. $valor_a_pagar .'</p>
                                            <p class="card-text"> Pagamento: '. $pagamento .'</p>  
                                </div>
                            </div>';
                        }
                
                    ?>
                        
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

</body>

</html>