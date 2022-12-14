<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(1);
include "php/menu.php";
 
 // Registrar produto


 if (isset($_POST['edit_estoque'])) {

   $id =clear($_POST['edit_estoque']);

} elseif (isset($_POST['edd_estoque'])) {
    $id = $_POST['edd_estoque'];
    if(isset($_POST['estoque']) || isset($_POST['valor_compra'])) {
        $estoque = limpar_texto(clear($_POST['estoque']));
        $valor_compra = limpar_texto(clear($_POST['valor_compra']));
        $id_user = clear($_SESSION['id']);

        $sql_code = "INSERT INTO `controle_estoque`(`id_estoque`, `valor_compra`, `estoque_metros_quadrados`, `ID_user`) VALUES ($id,$valor_compra,$estoque,$id_user)";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    }else{
        
        echo "Campo vazios";
    }
}elseif (isset($_POST['delestoque'])) {
    $id_del = clear($_POST['delestoque']);
    $id = clear($_POST['idestoque']);
    
    $sql_code = "DELETE FROM `controle_estoque` WHERE `ID` = $id_del";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
} else {

    $id = 17;
}


$sql_code = "SELECT * FROM `controle_estoque` WHERE `id_estoque` = $id";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

$sql_code = "SELECT `ID`, `Nome` FROM `estoque` WHERE ID = $id";
$sql_query_nome = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

$nome = $sql_query_nome->fetch_assoc();

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
                <h1 class="h3 mb-2 text-gray-800">Cadastro de estoque</h1>
                    <p class="mb-4"> Aqui você pode cadastrar o estoque.</p>
                    
                    <!-- Basic Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cadastrar estoque</h6>
                        </div>
                        <div class="card-body">
                            <h4 style="margin-left:40%; margin-bottom: 50px;"><?php echo $nome['Nome'] ?> </h4>
                        <form class="was-validated" action="" method="post">
                            <div class="form-row">
                                <div class="col-5">
                                <label for="validationcompra">Custo: </label>
                                <input type="text"  class="form-control" placeholder="Custo do produto" id="validationcompra" name="valor_compra" required>
                                </div>
                                <div class="col-5">
                                <label for="validationestoque">Quantidade m³: </label>
                                <input type="text" class="form-control" placeholder="Quantidade m³" id="validationestoque" name="estoque" required>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success" style="margin-top: 30px;" value="<?php echo $id ?>" name="edd_estoque">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                        </svg>
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>
                                
                        </div>
                    </div>

                    <!-- Basic Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de estoque</h6>
                        </div>
                        <div class="card-body">
                        <?php 
                        
                        while($row = $sql_query->fetch_assoc()) {
                            echo '<h1 >  </h1>
                            
                                <div class="form-row">
                                    <div class="col-5">
                                    <input type="text" class="form-control" value="R$'. $row['valor_compra'] .'" disabled>
                                    </div>
                                    <div class="col-5">
                                    <input type="text" class="form-control" value="'. $row['estoque_metros_quadrados'] .' m³" disabled>
                                    </div>
                                    <div class="col">
                                    <form action="" method="post">
                                    <input type="text" style="display: none;" name="idestoque" value="'. $row['id_estoque'] .'">
                                        <button type="submit" class="btn btn-danger" value="'. $row['ID'] .'" name="delestoque">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>    
                                    </div>
                                </div>
                           ';

                        }
                        
                        
                        ?>
                            
                                
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#validationcompra').maskMoney({
              prefix:'R$ ',
              allowNegative: true,
              thousands:'.', decimal:',',
              affixesStay: true
            });
            $('#validationestoque').mask("0000000000,00 m³", { "escapeChar": "m³", reverse: true });
            
            
            // console.log("Aqui");
            // $("#valorvanda").mask('000.000.000.000.000,00', {reverse: true, "escapeChar": "\\"});
        });
    </script>
</body>

</html>