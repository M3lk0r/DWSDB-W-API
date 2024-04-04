<?php
session_start();

if ($_SESSION['tipo'] != 'atendente') {
    header("Location: ../login.php");
    exit;
}

include_once '../../models/Atendimento.php';

include_once '../../models/Usuario.php';

$usuario = new Usuario();

$pacientes = $usuario->listarUsuariosPorTipo('paciente');
$medicos = $usuario->listarUsuariosPorTipo('medico');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_paciente']) && isset($_POST['id_medico']) && isset($_POST['data_atendimento']) && isset($_POST['observacoes'])) {
        $idPaciente = $_POST['id_paciente'];
        $idMedico = $_POST['id_medico'];
        $dataAtendimento = $_POST['data_atendimento'];
        $observacoes = $_POST['observacoes'];

        $atendimento = new Atendimento();

        $resultado = $atendimento->agendarConsulta($idPaciente, $idMedico, $dataAtendimento, $observacoes);

        if ($resultado) {
            echo '<div class="alert alert-success" role="alert">Consulta agendada com sucesso!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erro ao agendar consulta. Por favor, tente novamente.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Todos os campos são obrigatórios. Por favor, preencha todos os campos.</div>';
    }
}
?>

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
        <h1>Agendar Consulta</h1>
    </header>

    <div class="container">
        <form action="agendar_consulta.php" method="POST">
            <div class="form-group">
                <label for="id_paciente">Paciente:</label>
                <select id="id_paciente" name="id_paciente" required>
                    <option value="">Selecione o paciente</option>
                    <?php foreach ($pacientes as $paciente) : ?>
                        <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_medico">Médico:</label>
                <select id="id_medico" name="id_medico" required>
                    <option value="">Selecione o médico</option>
                    <?php foreach ($medicos as $medico) : ?>
                        <option value="<?php echo $medico['id']; ?>"><?php echo $medico['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="data_atendimento">Data do Atendimento:</label>
                <input type="datetime-local" id="data_atendimento" name="data_atendimento" required>
            </div>
            <div class="form-group">
                <label for="observacoes">Observações:</label>
                <textarea id="observacoes" name="observacoes" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Agendar Consulta</button>
        </form>
        <ul>
            <li><a href="atendente.php">Voltar</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>