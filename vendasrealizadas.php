<?php 

include "php/conexao.php";
include "php/funcoes.php";


//Verifica cessão 
cessao(1);
include "php/menu.php";



// GET categoria
$sql_code = 'SELECT venda.ID, venda.valormetro, venda.desconto, DATE_FORMAT(venda.data,"Data: %d/%m/%Y Hora: %h:%m"), venda.quantidadeMetros,venda.statusPagamento,estoque.Nome, venda.pagamento,cliente.nome FROM `venda` INNER JOIN cliente on venda.cliente = cliente.ID INNER JOIN estoque on venda.produto = estoque.ID ORDER BY venda.ID DESC LIMIT 100;';
$sql_venda = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

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
                        
                        while($row = $sql_venda->fetch_assoc()) {
                            
                            $valor_a_pagar = $row['valormetro'] * $row['quantidadeMetros'] - $row['desconto'];
                            echo '<div class="card ">
                            <div class="card-body">
                                            <p class="card-title"> Produto: '. $row['Nome'] .'</p>
                                            <p class="card-text"> Cliente: '. $row['nome'] .'</p>
                                            <p class="card-text"> Valor da venda: R$'. $valor_a_pagar .'</p>
                                            <p class="card-text"> '. $row['DATE_FORMAT(venda.data,"Data: %d/%m/%Y Hora: %h:%m")']  .'</p>';
                                            
                            if ($row['statusPagamento'] == 1 ) {
                                $pagamento = "Pagamento feito";
                                echo '<p style="color: rgba(39, 245, 58, 1)" class="card-text"> Pagamento: Pagamento feito </p>';
                            }else {
                                $sql_code = 'SELECT * FROM `servicovenda` WHERE venda_ID ='. $row['ID'];
                                $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
                                $result_venda = $sql_query->fetch_assoc();
                                
                                if (isset($result_venda['valServico'])) {
                                    
                                    $result = $valor_a_pagar + $result_venda['valServico'] - $row['pagamento'] - $result_venda['valorPago'];
                                }else{
                                    $result = $valor_a_pagar - $row['pagamento'];
                                    
                                }
                                 
                                echo '<p style="color: rgba(245, 39, 39, 0.8)" class="card-text"> Pagamento: Falta R$ ' . farmat_virgula($result) .' para quitar </p>';
                                echo '<button class="btn btn-success" type="button" data-toggle="modal" data-target="#receberModal" onclick="modalvalue(' . $row['ID'].','  .farmat_virgula($result) . ')"> Receber </button>';
                            }
                                  
                            echo ' </div>
                            </div>
                            
                            
                            ';
                             
                        }
                
                    ?>
                        
                    </div>
                    
                    
                    
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Logout Modal-->
            

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

    <div class="modal fade" id="receberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confira os valores antes de salvar</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body"><div id="total_areceber"></div>
                                                <form class="was-validated " action="php/pagamento.php" method="POST">
                                                <div class="col-md-12 mb-3">
                                                        <label for="valor_produto">Valor Recebido </label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                                            </div>
                                                            <input type="text" class="form-control " id="money" value="" id="valor_produto" placeholder="Valor do produto" name="pagamento" aria-describedby="basic-addon1">
                                                        </div>
                                                        <!-- <input type="text" class="form-control money" value="" id="valor_produto" placeholder="Valor do produto" name="valormetro" Readonly> -->
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" name="vendapagamento" id="cadastravalor" value="" class="btn btn-primary">
                                                            Fechar venda
                                                        </button>
                                                </div>       
                                            </div>
                                            </form>
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
    <script src="js/jquery.mask.js" type="text/javascript"></script>                   
    <script type="text/javascript">
        
        

        function modalvalue(id, real, centavos){
            
            document.getElementById("cadastravalor").setAttribute("value", id);
            if(centavos < 10){
                document.getElementById('money').value= real + ",0" + centavos;
            }else{
                document.getElementById('money').value= real + "," + centavos;
            } 
        
        }
        $(document).ready(function() {
            $('#money').mask("0000000000,00" , { reverse: true }); 
        });

    </script>

</body>



</html>