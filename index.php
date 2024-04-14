<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SESSION['tipo'] == 'paciente') {
        header("Location: ./app/views/paciente/paciente.php");
    } elseif ($_SESSION['tipo'] == 'funcionario') {
        header("Location: ./app/views/funcionario/funcionario.php");
    } elseif ($_SESSION['tipo'] == 'medico') {
        header("Location: ./app/views/medico/medico.php");
    }
    session_unset();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Hospitalar</title>
    <link rel="stylesheet" href="./app/assets/css/style.css">
</head>

<body>
    <header>
        <h1>Bem-vindo ao Sistema Hospitalar</h1>
    </header>

    <div class="container">
        <h2>Login</h2>
        <form action="./app/views/login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <form action="./app/views/cadastro.php" method="POST">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script src="./app/assets/js/script.js"></script>
</body>

</html>