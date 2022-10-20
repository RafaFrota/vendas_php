<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(2);
include "php/menu.php";
$id_user = clear($_SESSION['id']);
$sql_code = "SELECT COUNT(ID) FROM `servico` WHERE status = 3 AND profissional = $id_user;";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
$countconcluido = $sql_query->fetch_assoc();

$sql_code = "SELECT COUNT(ID) FROM `servico` WHERE status = 1 OR status = 2 AND profissional = $id_user;";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
$countativo = $sql_query->fetch_assoc();
$id_user = clear($_SESSION['id']);

$sql_code = "SELECT COUNT(ID) FROM `servicovenda` WHERE status = 3 AND profissional = $id_user;";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
$soma =$sql_query->fetch_assoc();
$countconcluido = $countconcluido['COUNT(ID)'] + $soma['COUNT(ID)'];

$sql_code = "SELECT COUNT(ID) FROM `servicovenda` WHERE status = 1 OR status = 2 AND profissional = $id_user;";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
$soma =$sql_query->fetch_assoc();
$countativo = $countativo['COUNT(ID)'] + $soma['COUNT(ID)'];
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

</head>

<style>

@import url("https://fonts.googleapis.com/css2?family=Poppins:weight@100;200;300;400;500;600;700;800&display=swap");


      

       .containerCard{
        height: 50vh;
       }

       .card{

        width: 380px;
        border: none;
        border-radius: 15px;
        padding: 8px;
        background-color: #fff;
        position: relative;
        height: 370px;
       }

       .upper{

        height: 100px;

       }

       .upper img{

        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;

       }

       .user{
        position: relative;
       }

       .profile img{

        
        height: 80px;
        width: 80px;
        margin-top:2px;

       
       }

       .profile{

        position: absolute;
        top:-50px;
        left: 38%;
        height: 90px;
        width: 90px;
        border:3px solid #fff;

        border-radius: 50%;

       }

       .follow{

        border-radius: 15px;
        padding-left: 20px;
        padding-right: 20px;
        height: 35px;
       }

       .stats span{

        font-size: 29px;
       }

</style>

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
                    <div class="containerCard d-flex justify-content-center align-items-center">
             
                        <div class="card">

                            <div class="upper">

                                <img src="https://i.imgur.com/Qtrsrk5.jpg" class="img-fluid">
                                
                            </div>

                            <div class="user text-center">

                                <div class="profile">

                                <img src="img/man.png" class="rounded-circle" width="80">
                                
                                </div>

                            </div>


                            <div class="mt-5 text-center">
                                <?php 
                                $user = "";
                                if($_SESSION['adm'] == 1){
                                    $user = "Admin";
                                }else{
                                    $user = "Usuário";
                                }
                                
                                ?>
                                <h4 class="mb-0"><?php echo $_SESSION['nome']; ?></h4>
                                <span class="text-muted d-block mb-2"><?php echo $user; ?></span>

                                

                                <div><h5>Serviços:</h5></div>
                                <div class="d-flex justify-content-between align-items-center mt-4 px-4">
                                    
                                    <div class="stats">
                                        <h6 class="mb-0">Ativos</h6>
                                        <span><?php echo $countativo ?></span>

                                    </div>


                                    <div class="stats">
                                        <h6 class="mb-0">Concluidos</h6>
                                        <span><?php echo $countconcluido ?></span>

                                    </div>


                                                                 
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