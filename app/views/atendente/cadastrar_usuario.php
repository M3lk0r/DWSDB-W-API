<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Cadastrar Usuário</h1>
    </header>

    <div class="container">
        <?php
        session_start();

        if ($_SESSION['tipo'] != 'atendente') {
            header("Location: ../login.php");
            exit;
        }

        include_once '../../../config/database.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include_once '../models/Usuario.php';

            $dadosUsuario = array(
                'nome' => $_POST['nome'],
                'endereco' => $_POST['endereco'],
                'cpf' => $_POST['cpf'],
                'celular' => $_POST['celular'],
                'altura' => $_POST['altura'],
                'peso' => $_POST['peso'],
                'tipo_sanguineo' => $_POST['tipo_sanguineo'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha'],
                'tipo' => $_POST['tipo']
            );

            $usuario = new Usuario();

            $resultado = $usuario->cadastrar($dadosUsuario);

            if ($resultado) {
                echo '<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Erro ao cadastrar usuário. Por favor, tente novamente.</div>';
            }
        }
        ?>

        <form action="cadastrar_usuario.php" method="POST">
            <button type="submit" class="btn btn-primary">Cadastrar Usuário</button>
        </form>
        <a href="atendente.php">Voltar</a>
        <a href="../logout.php">Logout</a>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>