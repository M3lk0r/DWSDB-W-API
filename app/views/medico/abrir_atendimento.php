<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Atendimento</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Abrir Atendimento</h1>
    </header>

    <div class="container">
        <?php
        include_once '../config/database.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include_once '../models/Atendimento.php';

            session_start();

            if ($_SESSION['tipo'] != 'medico') {
                header("Location: index.php");
                exit;
            }

            $idAtendimento = $_POST['id_atendimento'];

            $atendimento = new Atendimento();

            $resultado = $atendimento->abrirAtendimento($idAtendimento);

            if ($resultado) {
                echo '<div class="alert alert-success" role="alert">Atendimento aberto com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Erro ao abrir atendimento. Por favor, tente novamente.</div>';
            }
        }
        ?>

        <form action="abrir_atendimento.php" method="POST">
            <button type="submit" class="btn btn-primary">Abrir Atendimento</button>
        </form>
        <a href="atendente.php">Voltar</a>
        <a href="../logout.php">Logout</a>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>