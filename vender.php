<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(1);
include "php/menu.php";
 
 // Registrar produto
 $msg = "";
 if(isset($_POST['cliente']) && isset($_POST['produto']) && isset($_POST['valormetro']) && isset($_POST['quantidademetros']) && isset($_POST['oppagamento']) && isset($_POST['statuspagamento']) ) {
        
        $cliente = clear($_POST['cliente']);
        $produto = clear($_POST['produto']);
        $valormetro = clear($_POST['valormetro']);
        $quantidademetros = clear($_POST['quantidademetros']);
        $quantidademetros_BD = $quantidademetros;
        $oppagamento = clear($_POST['oppagamento']);
        $statuspagamento = clear($_POST['statuspagamento']);
        $id_user = clear($_SESSION['id']);
        $pagamento = 0;
        $pagamento_serv = 0;
        
        $sql_code = "SELECT SUM(valor_compra), SUM(estoque_metros_quadrados) FROM `controle_estoque` WHERE id_estoque = $produto";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        //echo $sql_code;
        $soma_estoque = $sql_query->fetch_assoc();

        if($quantidademetros <= $soma_estoque['SUM(estoque_metros_quadrados)'] && $quantidademetros > 0 ){
            
            if (isset($_POST['pagamento']) && $_POST['pagamento'] != '' && $statuspagamento == 2) {
            
                $valor_total = $valormetro * $quantidademetros;
                if ($_POST['pagamento'] <= $valor_total) {
                    $pagamento = clear($_POST['pagamento']);
                }else{
                    
                    $pagamento = $valormetro * $quantidademetros;
                    $pagamento_serv = clear($_POST['pagamento']) - $pagamento;
                }
    
            }else if ($statuspagamento == 1 && $quantidademetros != 0){
                $pagamento = $valormetro * $quantidademetros;
            }else if ($quantidademetros == 0){
                $pagamento = $quantidademetros;
            }
    
            $calc = $pagamento + $pagamento_serv;
    
            if ($calc <= $_POST['pagamento'] && $_POST['pagamento'] > 0 or $statuspagamento == 1 or $statuspagamento == 2 or $statuspagamento == 3) {
                $controle = TRUE;
                //$estoque = 30;
                do{
                    $sql_code = "SELECT `estoque_metros_quadrados` FROM `controle_estoque` WHERE `id_estoque` = $produto LIMIT 1";
                    //echo $sql_code . " </br>";
                    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                    $estoque = $sql_query->fetch_assoc();
                    $result = $estoque['estoque_metros_quadrados'] - $quantidademetros;
                    if ($result < 0){

                        $sql_code = "DELETE FROM `controle_estoque` LIMIT 1";
                        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                        $quantidademetros =- $result; 
                        
                    }else if ($result == 0){
                        $sql_code = "DELETE FROM `controle_estoque` LIMIT 1";
                        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                        $controle = FALSE;
                        $quantidademetros =- $result; 
                        
                    }else if($result > 0){

                        $sql_code = "UPDATE `controle_estoque` SET `estoque_metros_quadrados`= $result LIMIT 1";
                        
                        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                        $quantidademetros =- $result; 
                        $controle = FALSE;
                    }else {
                        $controle = FALSE;
                    }

                }while($controle);

                if ($quantidademetros <= 0) {
                    $sql_code = "INSERT INTO `venda`(`cliente`, `produto`, `valormetro`, `quantidadeMetros`, `formaDePagamento`, `statusPagamento`, `pagamento`, `user_ID`) VALUES ($cliente,$produto,$valormetro,$quantidademetros_BD,$oppagamento,$statuspagamento,$pagamento,$id_user)";
                    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                        
                    $idsql = $mysqli->insert_id;
                                        
                    if(isset($_POST['Profissional']) && isset($_POST['descricao']) && isset($_POST['valservico']) && isset($_POST['check']) && $idsql != 0) {
                            
                        if ($statuspagamento == 1){
                            $pagamento_serv = clear($_POST['valservico']);
                        }
                            
                        $valservico = clear($_POST['valservico']);
                        $Profissional = clear($_POST['Profissional']);
                        $descricao = clear($_POST['descricao']);
                        $sql_code = "INSERT INTO `servicovenda`(`profissional`, `descricao`, `valServico`, `valorPago`, `venda_ID`) VALUES ($Profissional, '$descricao',$valservico, $pagamento_serv, $idsql)";
                        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                            
                        }
                        
                    }else {
                        $msg = "Algo errado com o pagamento";
                        echo $result;
                    }
                }
                
        }else {
            $msg = "ERRO!! Estoque atual é " . $soma_estoque['SUM(estoque_metros_quadrados)'] ."m², insira um valor valido";
        } 
}
 // Registrar cliente

 if(isset($_POST['nomecliente'])) {
    
    $nome = clear($_POST['nomecliente']);
    if (empty($_POST['email'])) {
        $email="";
    }else {
        $email= clear($_POST['email']);
    }

    if (empty($_POST['celular'])) {
        $celular = 0;
    }else{
        $celular = clear($_POST['celular']);
    }

    if (empty($_POST['celular'])) {
        $cep = 0;
    }else{
        $cep = clear($_POST['cep']);
    }

    if (empty($_POST['endereco'])) {
        $endereco = "";
    }else{
        $endereco = clear($_POST['endereco']);
    }
    
    $id_user = clear($_SESSION['id']);
    


    $sql_code = "INSERT INTO `cliente`( `nome`, `email`, `celular`, `cep`, `endereco`, `criado_por`) VALUES ('$nome','$email',$celular,$cep,'$endereco',$id_user)";
    echo $sql_code;
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
                                <div class="collapse" id="cliente">
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
                                                <input type="number" class="form-control" id="celular" placeholder="(99) 9999-9999" name="celular" >
                                            </div>
                                            
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="cep">CEP: </label>
                                                <input type="text" class="form-control" id="cep" placeholder="Ex.: 00000-000" name="cep" >
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="endereco">Endereço: </label>
                                                <input type="number" class="form-control" id="endereco" placeholder="Endereco" name="endereco" >
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
                                        <h4>
                                            <?php 
                                                echo $msg;
                                                $msg = "";
                                            ?>
                                        </h4>
                                    <form class="was-validated " action="" method="POST">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="validationCustom02">Cliente</label>
                                                <select class="custom-select" name="cliente" required>
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
                                                        <label for="valor_produto">Valor do m² </label>
                                                        <input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" value="" id="valor_produto" placeholder="Valor do produto" name="valormetro" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                        <label for="metros">Quantidade em m²</label>
                                                        <input type="number" class="form-control" value="" id="metros" placeholder="Metros" name="quantidademetros" required>
                                                </div>
                                            </div>

                                            
                                                
                                        
                                        <div class="form-check form-switch mt-2 mb-3">
                                                <input class="form-check-input" type="checkbox" name="check" id='btn-div' value="1">
                                                <label for="flexSwitchCheckDefault">Gerar ordem de serviço?</label>
                                        </div>
                                                  
                                        
                                        <div class="container-servico" style="display: none;">
                                            
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                        <label for="valservico" >Valor do serviço: </label>
                                                        <input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" id="valservico" placeholder="Valor recebido" name="valservico" >
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="Profissional">Profissional responsavel: </label>
                                                    <select class="custom-select" name="Profissional" id="responsavel">
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
                                                    <textarea class="form-control" id="desc" rows="3" name="descricao" ></textarea>
                                                </div>
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
                                                        <input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" id="valor-recebido" placeholder="Valor recebido" name="pagamento" >
                                                </div>
                                            </div>                
                                        
                                        
                                        
                                        <div id="total_areceber"></div>
                                        <div id="total_servico" ></div>
                                        <div id="total_recebido" ></div>
                                        <div id="total"></div>
                                        
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
     
    
    <script>
//----------------------------------------------------
var btn = document.getElementById('btn-div');
var container = document.querySelector('.container-servico');
var valservico = document.querySelector('#valservico');
var responsavel = document.querySelector('#responsavel');
var desc = document.querySelector('#desc');

serv = false;
val_par = false;

btn.addEventListener('change', function() {
    
  if(container.style.display === 'block') {
        serv = true;
        calcula();
        container.style.display = 'none';
        valservico.removeAttribute('required');
        responsavel.removeAttribute('required');
        desc.removeAttribute('required');
    } else {
      container.style.display = 'block';
      
        valservico.setAttribute('required', '');
        responsavel.setAttribute('required', '');
        desc.setAttribute('required', '');
      container.setAttribute('required', '');
      serv = false;
      calcula();
  }
});


//----------------------------------------------------
var inp_valor = document.getElementById('valor-recebido');

inp_valor.addEventListener('change', function() {
    
    calcula();
    
  });


//----------------------------------------------------
var inp_valor = document.getElementById('valservico');

inp_valor.addEventListener('change', function() {
    
   calcula();
    
  });

//----------------------------------------------------
var btn_pagamento = document.getElementById('pagamento');
var container_pagamento = document.querySelector('.container-pagamento');
var valor_recebido = document.querySelector('#valor-recebido');

btn_pagamento.addEventListener('change', function() {
    
    console.log(btn_pagamento.value);
    if (btn_pagamento.value == 2) {
        container_pagamento.style.display = 'block';
        valor_recebido.setAttribute('required', '');
        val_par = false;
        calcula();
    }else{
        container_pagamento.style.display = 'none';
        valor_recebido.removeAttribute('required');
        val_par = true;
        calcula();
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

        function calcula(op){
                
                
            var produto = parseFloat(document.querySelector("#valor_produto").value);
            var metros = parseFloat(document.querySelector("#metros").value);
            var valor_pago = parseFloat(document.querySelector("#valor-recebido").value);
            var valservico = parseFloat(document.querySelector("#valservico").value);
            
            if (isNaN(produto)) {
                produto = 0;
            }
            
            if(isNaN(metros)) {
                metros = 0;
            }
            
            if(isNaN(valor_pago)) {
                valor_pago = 0;
            }
            
            if (isNaN(valservico)) {
                valservico = 0;
            }
            
            if (serv) {
                valservico = 0;
            }
            
            if (val_par) {
                valor_pago = 0;
            }
            
            var result = (produto * metros) + valservico - valor_pago;
            var total_produt = produto * metros;
            
            document.querySelector('#total_areceber').innerHTML = '<h5> Total produto: R$'+ total_produt +' </h5>';
            document.querySelector('#total_servico').innerHTML = '<h5> Total serviço: R$'+ valservico +' </h5>';
            document.querySelector('#total_recebido').innerHTML = '<h5 style="color: rgba(15, 191, 2, 0.8);"> Valor pago: R$ '+ valor_pago +' </h5>';
            document.querySelector('#total').innerHTML = '<h5 style="color: rgba(255, 0, 0, 0.69);"> Total: R$'+ result +' </h5>';

        }
</script>

</body>

</html>