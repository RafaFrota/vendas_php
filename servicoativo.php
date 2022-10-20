<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(2);
include "php/menu.php";

if (isset($_POST['iniciar'])) {
    $id = $_POST['iniciar'];

    $sql_code = "UPDATE `servicovenda` SET `status`= 2 WHERE ID = $id";
    //echo $sql_code;
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    
}else if (isset($_POST['concluir'])) {
    $id = $_POST['concluir'];

    $sql_code = "UPDATE `servicovenda` SET `status`= 3 WHERE ID = $id";
    //echo $sql_code;
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

}

if (isset($_POST['iniciarserv'])) {
    $id = $_POST['iniciarserv'];

    $sql_code = "UPDATE `servico` SET `status`= 2 WHERE ID = $id";
    //echo $sql_code;
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    
}else if (isset($_POST['concluirserv'])) {
    $id = $_POST['concluirserv'];

    $sql_code = "UPDATE `servico` SET `status`= 3 WHERE ID = $id";
    //echo $sql_code;
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

}

// GET categoria
$prof_ID = $_SESSION['id'];
$sql_code = "SELECT servicovenda.ID, servicovenda.profissional, servicovenda.descricao, servicovenda.valServico,statusservico.nome,statusservico.ID AS idstatus FROM `servicovenda` INNER JOIN statusservico ON servicovenda.status = statusservico.ID WHERE status = 1 OR status = 2 AND profissional = $prof_ID";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

$sql_code_s = "SELECT servico.`ID`, servico.`valor`, servico.`profissional`, servico.`descricao`, servico.`status`, statusservico.`nome` FROM `servico` INNER JOIN statusservico ON servico.status = statusservico.ID WHERE status = 1 or status = 2 AND profissional = $prof_ID";
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

                    <h1 class="h3 mb-2 text-gray-800"> Produtos cadastrados </h1>
                    <p class="mb-4"> Aqui você vê todos os produtos cadastrados no sistemas. </p>
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
                                                
                                                
                                                if ($row['idstatus'] == 1) {
                                                    echo '<p class="card-text" style="color: rgba(0, 198, 43, 0.7)"> Status: '. $row['nome'] .'</p>
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
                                                }else if ($row['idstatus'] == 2) {
                                                    echo '<p class="card-text" style="color: rgba(19, 0, 255, 0.7)" > Status: '. $row['nome'] .'</p>
                                                    <h5 class="card-title"> Descrição: '. $row['descricao'] .'</h5>
                                                    <form action="" method="post">
                                                <button type="submit" class="btn btn-success" value="'.$row['ID'].'" name="concluir">
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