<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Cadastro de Usuário</h1>
    </header>

    <div class="container">
        <?php
        require_once '../config/database.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once '../app/models/Usuario.php';

            $dadosUsuario = array(
                'nome' => $_POST['nome'] ?? '',
                'endereco' => $_POST['endereco'] ?? '',
                'cpf' => $_POST['cpf'] ?? '',
                'celular' => $_POST['celular'] ?? '',
                'altura' => $_POST['altura'] ?? '',
                'peso' => $_POST['peso'] ?? '',
                'tipo_sanguineo' => $_POST['tipo_sanguineo'] ?? '',
                'email' => $_POST['email'] ?? '',
                'senha' => $_POST['senha'] ?? '',
                'tipo' => $_POST['tipo'] ?? ''
            );

            $usuario = new Usuario();

            $resultado = $usuario->cadastrar($dadosUsuario);

            if ($resultado) {
                header("Location: ../app/views/login.php");
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Erro ao cadastrar usuário. Por favor, tente novamente.</div>';
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="text" name="nome" placeholder="nome" required><br>
            <input type="text" name="endereco" placeholder="Endereço" required><br>
            <input type="text" name="cpf" placeholder="CPF" required><br>
            <input type="text" name="celular" placeholder="Celular" required><br>
            <input type="text" name="altura" placeholder="Altura" required><br>
            <input type="text" name="peso" placeholder="Peso" required><br>
            <input type="text" name="tipo_sanguineo" placeholder="Tipo Sanguíneo" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <select name="tipo" required>
                <option value="">Selecione um tipo</option>
                <option value="paciente">Paciente</option>
            </select><br>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>

</html>