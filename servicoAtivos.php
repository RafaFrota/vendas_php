<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(1);
include "php/menu.php";


$envio_form = 0;

if (isset($_POST['cancelar'])) {
    $id = $_POST['cancelar'];

    $sql_code = "UPDATE `servicovenda` SET `status`= 4 WHERE ID = $id";
    
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    //echo "Entrar";
    
    $envio_form = 1;
}

if (isset($_POST['servicocancelar'])) {
    $id = $_POST['servicocancelar'];

    $sql_code = "UPDATE `servico` SET `status`= 4 WHERE ID = $id";
    
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    //echo "Entrar";
    
    $envio_form = 1;
}



// GET categoria
$sql_code = "SELECT servicovenda.ID, servicovenda.profissional, servicovenda.descricao, servicovenda.valServico, statusservico.`nome` FROM `servicovenda` INNER JOIN statusservico ON servicovenda.status = statusservico.ID WHERE status = 1 or status = 2;";
//SELECT servicovenda.ID, servicovenda.profissional, servicovenda.descricao, servicovenda.valServico, servicovenda.venda_ID, servicovenda.status, statusservico.ID AS idstatus, statusservico.`nome`, statusservico.data FROM `servicovenda` INNER JOIN statusservico ON servicovenda.status = statusservico.ID WHERE status = 1 or status = 2;
//echo $sql_code . "</br>";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

$sql_code_s = "SELECT servico.`ID`, servico.`valor`, servico.`profissional`, servico.`descricao`, servico.`status`, statusservico.`nome` FROM `servico` INNER JOIN statusservico ON servico.status = statusservico.ID WHERE status = 1 or status = 2";
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
                                                                    <P class="card-title"> Descrição: '. $row['descricao'] .'</P>
                                                                    <p class="card-text"> Status: '. $row['nome'] .'</p>
                                                                    <p class="card-text"> À receber: R$'. $row['valServico'] .'</p>
                                                                    <p class="card-text"> Pagamento: R$'. $row['valServico'] .'</p>
                                                                    
                                                                        <button type="button" class="btn btn-danger" data-toggle="modal" onclick="modal('. $row['ID'] .')" data-target="#canceModal">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                                                            </svg>
                                                                        Cancelar
                                                                        </button>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Serviços avulso</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardservico">
                                    <div class="card-body">
                                        <div class="card-columns">
                                            <?php 
                                            
                                            while($row = $sql_query_s->fetch_assoc()) {
                                                echo '<div class="card ">
                                                <div class="card-body">
                                                                <p class="card-title"> Descrição: '. $row['descricao'] .'</p>
                                                                <p class="card-text"> Status: '. $row['nome'] .'</p>
                                                                
                                                                <p class="card-text"> Pagamento: R$'. $row['valor'] .'</p>
                                                                <p class="card-text"> Pagamento:'. $row['ID'] .'</p>
                                                                
                                                                    <button type="button" class="btn btn-danger" data-toggle="modal" onclick="servico('. $row['ID'] .')" data-target="#servicoModal">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                                                        </svg>
                                                                    Cancelar
                                                                    </button>
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

    <!-- cancel Modal venda-->
    <div class="modal fade" id="canceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Você tem certeza que quer cancelar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <p style="color: rgba(217, 39, 39, 0.8)">Atenção:</p> 
                <p>O cancelamento não pode ser revertido</p> 
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    <form action="" method="post">
                        <button type="submit" class="btn btn-danger" value="" name="cancelar" id="cancelmodal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                            </svg>
                            Cancelar
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- cancel Modal servico-->
    <div class="modal fade" id="servicoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Você tem certeza que quer cancelar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <p style="color: rgba(217, 39, 39, 0.8)">Atenção:</p> 
                <p>O cancelamento não pode ser revertido</p> 
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"  data-dismiss="modal">Voltar</button>
                    <form action="" method="post">
                        <button type="submit" class="btn btn-danger" name="servicocancelar" value="" id="servModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                            </svg>
                            Cancelar
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

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

    <script>

        function modal(id){
            document.getElementById("cancelmodal").setAttribute("value", id);
            
        }

        function servico(id){
            document.getElementById("servModal").setAttribute("value", id);
        }

        
        if ( <?php echo $envio_form; ?> ) {
            alert("Servico!");
            window.history.replaceState( null, null, window.location.href );
        }


    </script>

</body>

</html>