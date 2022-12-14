<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(1);
include "php/menu.php";



// GET categoria
$sql_code = 'SELECT *,DATE_FORMAT(servicovenda.data,"Data: %d/%m/%Y Hora: %h:%m") FROM `servicovenda` INNER JOIN statusservico ON servicovenda.status = statusservico.ID WHERE status = 3 or status = 4';
//echo $sql_code . "</br>";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

$sql_code_s = 'SELECT *,DATE_FORMAT(servico.data,"Data: %d/%m/%Y Hora: %h:%m") FROM `servico` INNER JOIN statusservico ON servico.status = statusservico.ID WHERE status = 3 or status = 4';
//echo $sql_code_s;
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

                
                <?php 
                
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg']; 
                    unset($_SESSION['msg']);
                }
                
                echo $top_menu; 
                ?>



                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800"> Produtos cadastrados </h1>
                    <p class="mb-4"> Aqui você vê todos os produtos cadastrados no sistemas. </p>
                    </br>
                    <!-- Collapsable Card Example -->
                    <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardvenda" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardvenda">
                                    <h6 class="m-0 font-weight-bold text-primary">Serviços vendas</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardvenda">
                                    <div class="card-body">
                                        <div class="card-columns">
                                            <?php 
                                            
                                                while($row = $sql_query->fetch_assoc()) {
                                                    
                                                    
                                                    echo '<div class="card ">
                                                    <div class="card-body">
                                                                    <h5 class="card-title"> Descrição: '. $row['descricao'] .'</h5>';
                                                                    if($row['status'] == 3){
                                                                        echo '<p class="card-text" style="color: rgba(0, 0, 0, 0.7);"> Status: '. $row['nome'] .'</p>';
                                                                    }else{
                                                                        echo '<p class="card-text" style="color: rgba(245, 40, 145, 0.8);"> Status: '. $row['nome'] .'</p>';
                                                                    }
                                                                    
                                                                    echo '
                                                                    <p class="card-text"> Status: '. $row['DATE_FORMAT(servicovenda.data,"Data: %d/%m/%Y Hora: %h:%m")'] .'</p>
                                                                    
                                                                    <p class="card-text"> Valor pago: R$ '. $row['valServico'] .'</p>
                                                                        
                                                        </div>
                                                    </div>';
                                                }
                                        
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardservico" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardservico">
                                    <h6 class="m-0 font-weight-bold text-primary">Serviços</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardservico">
                                    <div class="card-body">
                                        <div class="card-columns">
                                            <?php 
                                            
                                                while($row = $sql_query_s->fetch_assoc()) {
                                                    
                                                    
                                                    echo '<div class="card ">
                                                    <div class="card-body">
                                                                    <h5 class="card-title"> Descrição: '. $row['descricao'] .'</h5>';
                                                                    
                                                                    if($row['status'] == 3){
                                                                        echo '<p class="card-text" style="color: rgba(0, 0, 0, 0.7);"> Status: '. $row['nome'] .'</p>';
                                                                    }else{
                                                                        echo '<p class="card-text" style="color: rgba(245, 40, 145, 0.8);"> Status: '. $row['nome'] .'</p>';
                                                                    }
                                                                    
                                                                    echo '<p class="card-text" >  '. $row['DATE_FORMAT(servico.data,"Data: %d/%m/%Y Hora: %h:%m")'] .'</p>
                                                                    <p class="card-text"> Valor pago: R$ '. $row['valor'] .'</p>
                                                                        
                                                        </div>
                                                    </div>';
                                                }
                                        
                                            ?>
                                            
                                        </div>
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

</body>

</html>