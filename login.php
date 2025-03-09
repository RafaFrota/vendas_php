<?php 

// Ativar exibição de erros PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('php/conexao.php');

// Verificar conexão com o banco de dados
if ($mysqli->connect_error) {
    die("Erro de conexão com o banco: " . $mysqli->connect_error);
}

if(!isset($_SESSION)) {
    session_start();
}

// Array para armazenar mensagens de erro e debug
$errors = array();
$debug_logs = array();

// Função para adicionar logs de debug
function addDebugLog($message, $type = 'info') {
    global $debug_logs;
    $debug_logs[] = array(
        'type' => $type,
        'message' => $message
    );
}

if(isset($_POST['email']) || isset($_POST['senha'])) {
    // Debug dos dados recebidos
    addDebugLog('Dados recebidos - Login: ' . $_POST['email']);
    
    if(strlen($_POST['email']) == 0) {
        $errors[] = "Preencha seu nome de usuário";
    } else if(strlen($_POST['senha']) == 0) {
        $errors[] = "Preencha sua senha";
    } else {
        $login = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM `user` WHERE nome = '$login' AND senha = '$senha'";
        addDebugLog('Query SQL: ' . $sql_code);

        $sql_query = $mysqli->query($sql_code);
        
        if (!$sql_query) {
            $errors[] = "Erro na execução da query: " . $mysqli->error;
            addDebugLog('Erro SQL: ' . $mysqli->error, 'error');
        } else {
            $quantidade = $sql_query->num_rows;
            addDebugLog('Número de registros encontrados: ' . $quantidade);

            if($quantidade == 1) {
                $usuario = $sql_query->fetch_assoc();
                addDebugLog('Dados do usuário: ' . json_encode($usuario));
                
                $_SESSION['id'] = $usuario['ID'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['adm'] = $usuario['ADM'];
                
                addDebugLog('Nível de acesso: ' . $_SESSION['adm']);
                
                if ($_SESSION['adm'] == 1) {
                    addDebugLog('Redirecionando para index.php - ADM');
                    header("Location: index.php");
                    exit();
                } else if($_SESSION['adm'] == 2) {
                    addDebugLog('Redirecionando para servicoativo.php - Usuário');
                    header("Location: servicoativo.php");
                    exit();
                } else {
                    $errors[] = "Nível de acesso inválido: " . $_SESSION['adm'];
                    addDebugLog('Nível de acesso inválido: ' . $_SESSION['adm'], 'error');
                    header("Location: login.php");
                    exit();
                }
            } else {
                $errors[] = "Falha ao logar! Nome de usuário ou senha incorretos";
                addDebugLog('Tentativa de login falhou - Nenhum usuário encontrado', 'error');
            }
        }
    }
}

// Exibir erros na tela
if (!empty($errors)) {
    echo '<div style="color: red; background-color: #ffe6e6; padding: 10px; margin: 10px; border: 1px solid red; border-radius: 5px;">';
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    echo '</div>';
}

// Adicionar script de debug no final da página
if (!empty($debug_logs)) {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        const debugLogs = " . json_encode($debug_logs) . ";
        debugLogs.forEach(function(log) {
            if (log.type === 'error') {
                console.error(log.message);
            } else {
                console.log(log.message);
            }
        });
    });
    </script>";
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

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" action="" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                name="email"
                                                placeholder="Escreva seu login...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="senha" name="senha" placeholder="Senha">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit">Entrar</button>
                                    </form>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
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

</body>

</html>