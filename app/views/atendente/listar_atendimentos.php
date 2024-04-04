<?php
session_start();

if ($_SESSION['tipo'] != 'atendente') {
    header("Location: ../login.php");
    exit;
}

include_once '../../models/Usuario.php';
include_once '../../models/Atendimento.php';

$usuarios = [];
$atendimentos = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['termo'])) {
        $termo = $_POST['termo'];

        $usuario = new Usuario();
        $usuarios = $usuario->buscar($termo);

        $atendimento = new Atendimento();
        foreach ($usuarios as $u) {
            $atendimentos[$u['id']] = $atendimento->listarAtendimentosPaciente($u['id']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Paciente</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Pesquisar Paciente e Listar Atendimentos</h1>
    </header>

    <div class="container">
        <form action="listar_atendimentos.php" method="POST">
            <div class="form-group">
                <label for="termo">Nome ou CPF do Paciente:</label>
                <input type="text" id="termo" name="termo" required>
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>

        <h2>Resultados da Pesquisa:</h2>
        <?php if (!empty($usuarios)) : ?>
            <ul>
                <?php foreach ($usuarios as $u) : ?>
                    <li>
                        <h3><?php echo $u['nome']; ?></h3>
                        <p>CPF: <?php echo $u['cpf']; ?></p>
                        <h4>Atendimentos:</h4>
                        <?php if (!empty($atendimentos[$u['id']])) : ?>
                            <ul>
                                <?php foreach ($atendimentos[$u['id']] as $atendimento) : ?>
                                    <li>
                                        Data: <?php echo $atendimento['data_atendimento']; ?> | Observações: <?php echo $atendimento['observacoes']; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p>Nenhum atendimento registrado.</p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Nenhum resultado encontrado.</p>
        <?php endif; ?>

        <ul>
            <li><a href="atendente.php">Voltar</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
    <script src="../../public/assets/js/script.js"></script>
</body>

</html>