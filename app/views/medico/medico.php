<?php
session_start();

if ($_SESSION['tipo'] != 'medico') {
    header("Location: login.php");
    exit;
}

#include_once '../../config/database.php';
include_once '../../models/Atendimento.php';

$idMedico = $_SESSION['id'];

$atendimento = new Atendimento();

$listaAtendimentos = $atendimento->listarAtendimentosMedico($idMedico);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Médico</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Bem-vindo, Médico</h1>
    </header>

    <div class="container">
        <p>Aqui você pode realizar várias tarefas de atendimento.</p>
        <ul>
            <li><a href="abrir_atendimento.php">Agendar Atendimento</a></li>
            <li><a href="listar_atendimento.php">Pesquisar Atendimento</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>