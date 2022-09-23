<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao();
include "php/menu.php";
 
 // Registrar produto

 if(isset($_POST['nome']) || isset($_POST['estoque']) || isset($_POST['valor_compra']) || isset($_POST['valor_venda']) || isset($_POST['categoria']) || isset($_POST['descricao'])) {

        $nome = clear($_POST['nome']);
        $estoque = clear($_POST['estoque']);
        $valor_compra = clear($_POST['valor_compra']);
        $valor_venda = clear($_POST['valor_venda']);
        $categoria = clear($_POST['categoria']);
        $descricao = clear($_POST['descricao']);
        $id_user = clear($_SESSION['id']);


        $sql_code = "INSERT INTO `estoque`(`Nome`, `valor_venda`, `categoria_id`, `descricao`, `user`) VALUES ('$nome','$valor_venda','$categoria','$descricao','$id_user')";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $idsql = $mysqli->insert_id;

        $sql_code = "INSERT INTO `controle_estoque`(`id_estoque`, `valor_compra`, `estoque_metros_quadrados`, `ID_user`) VALUES ('$idsql', '$valor_compra','$estoque','$id_user')";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $_SESSION['msg'] = '<h2 style="color:green;">Produto cadastrado com sucesso!!!</h2>';
        header("Location: produtoscadastrados.php");

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

// GET produto
$sql_code = "SELECT * FROM `estoque`";
$sql_query_produto = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// GET cliente
$sql_code = "SELECT * FROM `cliente`";
$sql_query_cliente = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

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
                                                <label for="produto">Produto</label>
                                                <select class="custom-select" id="produto" name="produto" required>
                                                    <option value="">---</option>
                                                    
                                                    <?php 
                                                    
                                                    while($row = $sql_query_produto->fetch_assoc()) {
                                                        echo '<option value="'. $row['ID'] . '">'. $row['Nome'] . ' </option>';
                                                    }
                                                    
                                                    ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                        <label for="valor_produto">Valor do metro quadrado: </label>
                                                        <input type="text" class="form-control" value="" id="valor_produto" placeholder="Valor do produto" name="nomecliente" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                        <label for="metros">: </label>
                                                        <input type="text" class="form-control" value="" id="metros" placeholder="Metros" name="nomecliente" required>
                                                </div>
                                            </div>

                                            
                                                
                                        
                                        <div class="form-check form-switch mt-2 mb-3">
                                                <input class="form-check-input" type="checkbox" id='btn-div' require>
                                                <label for="flexSwitchCheckDefault">Gerar ordem de serviço?</label>
                                        </div>
                                                  
                                        
                                        <div class="container-servico " style="display: none;">
                                            
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                        <label for="valor_servico">Valor do serviço: </label>
                                                        <input type="text" class="form-control" id="valor_servico" placeholder="Valor recebido" name="nomecliente" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
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
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="exampleFormControlTextarea1"> Descrição do Serviço </label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descricao" required></textarea>
                                                </div>
                                            </div>

                                                 
                                        </div>

                                        <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="validationCustom02">Forma de pagamento: </label>
                                                        <select class="custom-select" name="categoria" required>
                                                            <option value="">---</option>
                                                            <option value="1">A vista</option>
                                                            <option value="2">Cartão de credito</option>
                                                            <option value="3">Cartão de debito</option>
                                                            <option value="3">PIX</option>
                                                        </select>
                                                </div>
                                                
                                                <div class="form-group col-md-6 ">
                                                    <label for="pagamento">Pagamentos</label>
                                                        <select class="custom-select" name="pagamento" id="pagamento" required>
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
                                                        <input type="text" class="form-control" id="valor-recebido" placeholder="Valor recebido" name="nomecliente" required>
                                                </div>
                                            </div>                
                                        <div id="total"><h5 style="color: rgba(255, 0, 0, 0.69);">Total produto R$00,00</h5></div>
                                        <div id="total_servico" ></div>
                                        <div id="total_recebido" ></div>
                                        <div id="total_areceber"></div>
                                        
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
//----------------------------------------------------
var btn = document.getElementById('btn-div');
var container = document.querySelector('.container-servico');

btn.addEventListener('change', function() {
    
  if(container.style.display === 'block') {
        var produto = document.querySelector("#valor_produto").value;
        var metros = document.querySelector("#metros").value;
        var valor_pago = document.querySelector("#valor-recebido").value;
        var valor_servico = document.querySelector("#valor_servico").value;

        var result = (metros * produto) - valor_pago;

        document.querySelector("#total_servico").innerHTML = '';
        document.querySelector("#total_areceber").innerHTML = '<h5 style="color: rgba(255, 0, 0, 0.69);">Recebido R$ '+result+'</h5>';
        container.style.display = 'none';
    } else {
      container.style.display = 'block';
      
   
  }
});


//----------------------------------------------------
var inp_valor = document.getElementById('valor-recebido');

inp_valor.addEventListener('change', function() {
    
    console.log(inp_valor.value);

    var produto = document.querySelector("#valor_produto").value;
    var metros = document.querySelector("#metros").value;
    var valor_pago = document.querySelector("#valor-recebido").value;

    var result = (metros * produto) - valor_pago;

    document.querySelector("#total_recebido").innerHTML = '<h5 style="color: rgba(38, 190, 37, 0.75);">Recebido R$ '+valor_pago+'</h5>';
    document.querySelector("#total_areceber").innerHTML = '<h5 style="color: rgba(255, 0, 0, 0.69);">Valor à receber R$ '+result+'</h5>';
    
  });


//----------------------------------------------------
var inp_valor = document.getElementById('valor_servico');

inp_valor.addEventListener('change', function() {
    
    console.log(inp_valor.value);

    var produto = document.querySelector("#valor_produto").value;
    var metros = document.querySelector("#metros").value;
    var valor_pago = document.querySelector("#valor-recebido").value;
    var valor_servico = document.querySelector("#valor_servico").value;

    var result = (metros * produto) + valor_servico - valor_pago;

    
    //document.querySelector("#total_areceber").innerHTML = '<h5 style="color: rgba(255, 0, 0, 0.69);">Valor à receber R$ '+result+'</h5>';
    document.querySelector("#total_servico").innerHTML = '<h5 style="color: rgba(255, 0, 0, 0.69);">Valor do serviço R$ '+valor_servico+'</h5>';
    
  });

//----------------------------------------------------
var btn_pagamento = document.getElementById('pagamento');
var container_pagamento = document.querySelector('.container-pagamento');

btn_pagamento.addEventListener('change', function() {
    
    console.log(btn_pagamento.value);
    if (btn_pagamento.value == 2) {
        container_pagamento.style.display = 'block';
    }else{
        container_pagamento.style.display = 'none';
        document.querySelector("#total_recebido").innerHTML = '';
        document.querySelector("#total_areceber").innerHTML = '';
    }
    
  });

//----------------------------------------------------
            $(document).ready(function () {

                function carrega_dados(ID){
                    
                    $.ajax({
                        url: "php/ajax.php",
                        method: "POST",
                        data: {ID: ID, op: 0},
                        dataType: "text",
                        success: function (data)
                        {
                            var value = document.querySelector("#valor_produto");
                            value.setAttribute("value", data);
                        }
                    })
                }
                $(document).on('change', '#produto', function () {
                    var produt_id = $('#produto').val();
                    carrega_dados(produt_id);
                });

                $("#valor_produto").change(function(){
                    console.log('Calcula');
                    calcula();

                });

                $("#metros").change(function(){
                    console.log('Calcula');
                    calcula();

                });

            });

        function calcula(){
                
                // 1 m2 = R$10
                var produto = document.querySelector("#valor_produto").value;
                var metros = document.querySelector("#metros").value;

                var result = metros * produto;
                
                var value = document.querySelector("#total").innerHTML = '<h5 style="color: rgba(255, 0, 0, 0.69);">Total produto R$'+ result+'</h5>';
        
        }
</script>

</body>

</html>