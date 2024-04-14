<?php
session_start();

if ($_SESSION['tipo'] != 'atendente') {
    header("Location: ../login.php");
    exit;
}

include_once '../../models/Usuario.php';
#include_once '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        <form action="cadastrar_usuario.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="text" id="celular" name="celular" required>
            </div>
            <div class="form-group">
                <label for="altura">Altura:</label>
                <input type="text" id="altura" name="altura">
            </div>
            <div class="form-group">
                <label for="peso">Peso:</label>
                <input type="text" id="peso" name="peso">
            </div>
            <div class="form-group">
                <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
                <select id="tipo_sanguineo" name="tipo_sanguineo" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select name="tipo" required id="tipo" name="tipo" required>
                    <option value="">Selecione um tipo</option>
                    <option value="paciente">Paciente</option>
                    <option value="medocp">Medico</option>
                    <option value="atendente">Atendente</option>
                </select><br>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Usuário</button>
            <a href="atendente.php">Voltar</a>
            <a href="../logout.php">Logout</a>
        </form>

    </div>

    <script src="../../assets/js/script.js"></script>
</body>

</html>