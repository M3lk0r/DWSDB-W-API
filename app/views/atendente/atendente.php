<?php
session_start();

if ($_SESSION['tipo'] != 'atendente') {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Atendente</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Bem-vindo, Atendente</h1>
    </header>

    <div class="container">
        <p>Aqui você pode realizar várias tarefas de atendimento.</p>
        <ul>
            <li><a href="cadastrar_usuario.php">Cadastrar novo usuário</a></li>
            <li><a href="pesquisar_usuarios.php">Pesquisar usuários</a></li>
            <li><a href="agendar_consulta.php">Agendar consulta</a></li>
            <li><a href="listar_atendimentos.php">Pesquisar atendimento por paciente</a></li>
        </ul>
        <a href="../logout.php">Logout</a>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>