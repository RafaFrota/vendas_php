<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao();
include "php/menu.php";

// GET produto
 $sql_code = "SELECT * FROM `estoque`";
 $sql_query_produto = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

 // GET cliente
 $sql_code = "SELECT * FROM `cliente`";
 $sql_query_cliente = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

 // GET cliente
 $sql_code = "SELECT * FROM `user`";
 $sql_query_user = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
 
 // Registrar produto

 if(isset($_POST['nome']) || isset($_POST['estoque']) || isset($_POST['valor_compra']) || isset($_POST['valor_venda']) || isset($_POST['categoria']) || isset($_POST['descricao'])) {

        // $nome = clear($_POST['nome']);
        // $estoque = clear($_POST['estoque']);
        // $valor_compra = clear($_POST['valor_compra']);
        // $valor_venda = clear($_POST['valor_venda']);
        // $categoria = clear($_POST['categoria']);
        // $descricao = clear($_POST['descricao']);
        // $id_user = clear($_SESSION['id']);


        // $sql_code = "INSERT INTO `estoque`(`Nome`, `valor_venda`, `categoria_id`, `descricao`, `user`) VALUES ('$nome','$valor_venda','$categoria','$descricao','$id_user')";
        // $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        // $idsql = $mysqli->insert_id;

        // $sql_code = "INSERT INTO `controle_estoque`(`id_estoque`, `valor_compra`, `estoque_metros_quadrados`, `ID_user`) VALUES ('$idsql', '$valor_compra','$estoque','$id_user')";
        // $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        // $_SESSION['msg'] = '<h2 style="color:green;">Produto cadastrado com sucesso!!!</h2>';
        // header("Location: produtoscadastrados.php");

}
 // Registrar cliente

 if(isset($_POST['nomecliente']) || isset($_POST['email']) || isset($_POST['celular']) || isset($_POST['cep']) || isset($_POST['endereco'])) {

    $nome = clear($_POST['nomecliente']);
    $email= clear($_POST['email']);
    $celular = clear($_POST['celular']);
    $cep = clear($_POST['cep']);
    $endereco = clear($_POST['endereco']);
    $id_user = clear($_SESSION['id']);


    $sql_code = "INSERT INTO `cliente`( `nome`, `email`, `celular`, `cep`, `endereco`, `criado_por`) VALUES ('$nome','$email',$celular,$cep,'$endereco',$id_user)";
    
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

}

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
                <h1 class="h3 mb-2 text-gray-800">Registrar venda</h1>
                    
                    
                    <!-- Collapsable Card Example -->
                    <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#cliente" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="cliente">
                                    <h6 class="m-0 font-weight-bold text-primary"> Cliente </h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="cliente">
                                    <div class="card-body">
                                    <form class="was-validated " action="" method="POST">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                    <label for="validationCustom01">Nome: </label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="nome" name="nomecliente" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom02">E-mail: </label>
                                                <input type="email" class="form-control" id="validationCustom02" placeholder="E-mail" name="email" >
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="celular">Celular: </label>
                                                <input type="number" class="form-control" id="celular" placeholder="(99) 9999-9999" name="celular" required>
                                            </div>
                                            
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="cep">CEP: </label>
                                                <input type="text" class="form-control" id="cep" placeholder="Ex.: 00000-000" name="cep" >
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="endereco">Endereço: </label>
                                                <input type="number" class="form-control" id="endereco" placeholder="Endereco" name="endereco" required>
                                            </div>
                                        </div>    
                                        <button class="btn btn-primary" type="submit"> Cadastrar </button>
                                    </form>
                                    </div>
                                </div>
                            </div>

                    <!-- Collapsable Card Example -->
                    <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#vender" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="vender">
                                    <h6 class="m-0 font-weight-bold text-primary">Venda</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="vender">
                                    <div class="card-body">
                                    <form class="was-validated " action="" method="POST">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="validationCustom02">Cliente</label>
                                                <select class="custom-select" name="categoria" required>
                                                    <option value="">---</option>
                                                    
                                                    <?php 
                                                    
                                                    while($row = $sql_query_cliente->fetch_assoc()) {
                                                        echo '<option value="'. $row['ID'] . '">'. $row['nome'] . ' </option>';
                                                    }
                                                    
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="validationCustom02">Produto</label>
                                                <select class="custom-select" name="produto" required>
                                                    <option value="">---</option>
                                                    
                                                    <?php 
                                                    
                                                    while($row = $sql_query_produto->fetch_assoc()) {
                                                        echo '<option value="'. $row['ID'] . '">'. $row['Nome'] . ' </option>';
                                                    }
                                                    
                                                    ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id='btn-div'>
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Gerar ordem de serviço?</label>
                                        </div>
                                                  
                                        
                                        <div class="container-servico" style="display: none;">
                                            <h5> Gerar ordem de serviço </h5>

                                            <div class="form-row">
                                                <label for="Profissional">Profissional responsavel: </label>
                                                <select class="custom-select" name="Profissional" required>
                                                    <option value="">---</option>
                                                    
                                                    <?php 
                                                    
                                                    while($row = $sql_query_user->fetch_assoc()) {
                                                        echo '<option value="'. $row['ID'] . '">'. $row['nome'] . ' </option>';
                                                    }
                                                    
                                                    ?>
                                                </select>
                                               
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="exampleFormControlTextarea1"> Descrição do Serviço </label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descricao" required></textarea>
                                                </div>
                                            </div>

                                                 
                                        </div>
                                        

                                        <button class="btn btn-primary" type="button"> Cadastrar </button>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
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

var btn = document.getElementById('btn-div');
var container = document.querySelector('.container-servico');

btn.addEventListener('click', function() {
    
  if(container.style.display === 'block') {
      container.style.display = 'none';
  } else {
      container.style.display = 'block';
  }
});

jQuery("#cep").mask("99999-999");
jQuery("#celular").mask("(99) 9999-9999");


</script>

</body>

</html>