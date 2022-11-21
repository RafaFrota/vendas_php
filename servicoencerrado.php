<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(2);
include "php/menu.php";



// GET categoria
$prof_ID = $_SESSION['id'];

$sql_code = 'SELECT *,DATE_FORMAT(servicovenda.data,"Data: %d/%m/%Y Hora: %h:%m") FROM `servicovenda` INNER JOIN statusservico ON servicovenda.status = statusservico.ID WHERE status = 3 OR status = 4 AND profissional ='. $prof_ID;
//echo $sql_code . "</br>";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

$sql_code_s = 'SELECT *,DATE_FORMAT(servico.data,"Data: %d/%m/%Y Hora: %h:%m") FROM `servico` INNER JOIN statusservico ON servico.status = statusservico.ID WHERE status = 3 OR status = 4 AND profissional ='. $prof_ID;
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

                
                <?php echo $top_menu; ?>



                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800"> Historico de serviços </h1>
                    <p class="mb-4"> Aqui você vê todos os serviços fechados atribuidos á você. </p>
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
                            
                            
                            echo '<div class="card ">
                            <div class="card-body">
                                            ';
                                            
                                            
                                            if ($row['status'] == 3) {
                                                echo '<p class="card-text" style="color: rgba(0, 183, 27, 0.8)"> Status: '. $row['nome'] .'</p>
                                                <p class="card-text"> Valor serviço: R$'. $row['valServico'] .'</p>
                                                <p class="card-title"> Descrição: '. $row['descricao'] .'</p>
                                                <p class="card-title"> '. $row['DATE_FORMAT(servicovenda.data,"Data: %d/%m/%Y Hora: %h:%m")'] .'</p>
                                                <form action="" method="post">
                                           
                                            </form> ';   
                                            }else if ($row['status'] == 4) {
                                                echo '<p class="card-text" style="color: rgba(245, 50, 39, 0.7)" > Status: '. $row['nome'] .'</p>
                                                <p class="card-text"> Valor serviço: R$'. $row['valServico'] .'</p>
                                                <p class="card-title"> Descrição: '. $row['descricao'] .'</p>
                                                <p class="card-title">'. $row['DATE_FORMAT(servicovenda.data,"Data: %d/%m/%Y Hora: %h:%m")'] .'</p>
                                                <form action="" method="post">
                                            
                                            </form> '; 
                                            }
                                            
                                echo '</div>
                            </div>';
                        }

                        while($row = $sql_query_s->fetch_assoc()) {
                            
                            
                            echo '<div class="card ">
                            <div class="card-body">
                                            ';
                                            
                                            
                                            if ($row['status'] == 3) {
                                                echo '<p class="card-text" style="color: rgba(0, 183, 27, 0.8)"> Status: '. $row['nome'] .'</p>
                                                <p class="card-text"> Valor serviço: R$'. $row['valor'] .'</p>
                                                <p class="card-title"> Descrição: '. $row['descricao'] .'</p>
                                                <p class="card-title">'. $row['DATE_FORMAT(servico.data,"Data: %d/%m/%Y Hora: %h:%m")'] .'</p>
                                                <form action="" method="post">
                                           
                                            </form> ';   
                                            }else if ($row['status'] == 4) {
                                                echo '<p class="card-text" style="color: rgba(245, 50, 39, 0.7)" > Status: '. $row['nome'] .'</p>
                                                <p class="card-text"> Valor serviço: R$'. $row['valor'] .'</p>
                                                <p class="card-title"> Descrição: '. $row['descricao'] .'</p>
                                                <p class="card-title">' . $row['DATE_FORMAT(servico.data,"Data: %d/%m/%Y Hora: %h:%m")'] .'</p>
                                                <form action="" method="post">
                                            
                                            </form> '; 
                                            }
                                            
                                echo '</div>
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