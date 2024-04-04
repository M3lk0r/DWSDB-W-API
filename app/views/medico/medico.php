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
        <h2>Sua Agenda de Atendimentos</h2>
        <ul>
            <?php
            if ($listaAtendimentos) {
                foreach ($listaAtendimentos as $atendimento) {
                    echo '<li>ID do Atendimento: ' . $atendimento['id'] . '</li>';
                    echo '<li>Data do Atendimento: ' . $atendimento['data_atendimento'] . '</li>';
                    echo '<li>Observações: ' . $atendimento['observacoes'] . '</li>';
                    echo '<hr>';
                }
            } else {
                echo '<p>Não há atendimentos agendados em sua agenda.</p>';
            }
            ?>
        </ul>
        <a href="../logout.php">Logout</a>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>