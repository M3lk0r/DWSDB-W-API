<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Atendimentos</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Visualizar Atendimentos</h1>
    </header>

    <div class="container">
        <?php
        session_start();

        if ($_SESSION['tipo'] != 'paciente') {
            header("Location: index.php");
            exit;
        }

        #include_once '../config/database.php';
        include_once '../../models/Atendimento.php';

        $idPaciente = $_SESSION['id'];

        $atendimento = new Atendimento();

        $listaAtendimentos = $atendimento->listarAtendimentosPaciente($idPaciente);

        if ($listaAtendimentos) {
            echo '<h2>Atendimentos Agendados</h2>';
            echo '<ul>';
            foreach ($listaAtendimentos as $atendimento) {
                echo '<li>ID: ' . $atendimento['id'] . ' - Data: ' . $atendimento['data_atendimento'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Não há atendimentos agendados.</p>';
        }
        ?>
        <a href="atendente.php">Voltar</a>
        <a href="../logout.php">Logout</a>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>