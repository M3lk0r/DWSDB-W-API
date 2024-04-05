<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Consulta</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Listar Atendimento</h1>
    </header>

    <?php
    session_start();

    if ($_SESSION['tipo'] != 'medico') {
        header("Location: ../login.php");
        exit;
    }

    include_once '../../models/Atendimento.php';
    include_once '../../models/Usuario.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_atendimento'])) {
        $idAtendimento = $_POST['id_atendimento'];
        $observacoes = $_POST['observacoes'];
        $dataRetorno = $_POST['data_retorno'];

        $atendimento = new Atendimento();
        $resultado = $atendimento->atualizarAtendimento($idAtendimento, $observacoes, $dataRetorno);

        if ($resultado) {
            echo '<div class="alert alert-success" role="alert">Atendimento atualizado com sucesso!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erro ao atualizar atendimento. Por favor, tente novamente.</div>';
        }
    }

    $idMedico = $_SESSION['id'];
    $atendimento = new Atendimento();
    $listaAtendimentos = $atendimento->listarAtendimentosMedico($idMedico);

    if ($listaAtendimentos) {
        echo '<h2>Atendimentos Agendados</h2>';
        foreach ($listaAtendimentos as $atendimento) {
            echo '<form action="listar_atendimento.php" method="POST">';
            echo '<input type="hidden" name="id_atendimento" value="' . $atendimento['id'] . '">';

            $usuario = new Usuario();
            $paciente = $usuario->buscarUsuarioPorId($atendimento['id_paciente']);

            echo '<p>Nome do Paciente: ' . $paciente['nome'] . '</p>';
            echo '<p>CPF: ' . $paciente['cpf'] . '</p>';
            echo '<p>Telefone: ' . $paciente['celular'] . '</p>';
            echo '<p>Data da Primeira Consulta: ' . $atendimento['data_atendimento'] . '</p>';
            echo '<p>Data do Retorno: ' . $atendimento['data_retorno'] . '</p>';
            echo '<label for="observacoes">Observações:</label>';
            echo '<textarea id="observacoes" name="observacoes" rows="4">' . $atendimento['observacoes'] . '</textarea>';
            echo '<label for="data_retorno">Data do Retorno:</label>';
            echo '<input type="datetime-local" id="data_retorno" name="data_retorno" value="' . $atendimento['data_retorno'] . '">';
            echo '<button type="submit">Salvar Alterações</button>';
            echo '</form>';
            echo '<hr>';
        }
    } else {
        echo '<p>Não há atendimentos agendados.</p>';
    }
    ?>
</body>
<a href="medico.php">Voltar</a>
<a href="../logout.php">Logout</a>