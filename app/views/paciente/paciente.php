<?php
session_start();

if ($_SESSION['tipo'] !== 'paciente') {
    header('Location: login.php');
    exit;
}

$idPaciente = $_SESSION['id'];

require_once '../../models/Usuario.php';
require_once '../../models/Atendimento.php';

$atendimento = new Atendimento();
$listaAtendimentos = $atendimento->listarAtendimentosPaciente($idPaciente);

if (!empty($listaAtendimentos)) {
    $idMedico = $listaAtendimentos[0]['id_medico'];
    $medico = new Usuario();
    $dadosMedico = $idMedico ? $medico->buscarUsuarioPorId($idMedico) : null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Paciente</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
</head>

<body>
    <header>
        <h1>Bem-vindo, Paciente</h1>
    </header>

    <div class="style-tabela">
        <h2>Seus Atendimentos Agendados</h2>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                </tr>
            </thead>
            <tfoot>
                <tr>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td class="top center">Data do atendimento</td>
                    <td class="top center">Medico</td>
                    <td class="top center">Observações</td>
                </tr>
                <?php if ($listaAtendimentos) : ?>
                    <?php foreach ($listaAtendimentos as $atendimento) : ?>
                        <tr>
                            <td align="center"><?php if (($atendimento['data_atendimento'] < $atendimento['data_retorno']) or ($atendimento['data_agendamento'] != null)) {
                                                    echo $atendimento['data_retorno'];
                                                } else {
                                                    echo $atendimento['data_atendimento'];
                                                } ?></td>
                            <td align="center"><?php echo $dadosMedico['nome']; ?></td>
                            <td align="center"><?php echo $atendimento['observacoes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td align="center" colspan="3">Não há atendimentos agendados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="../logout.php">Logout</a>
    </div>

    <script src="../../assets/js/script.js"></script>
</body>

<style>
    .style-tabela table {
        float: left;
        border: 1px solid #ccc;
        border-bottom: 0;
        border-right: 0;
        font-size: 0.8em;
    }

    .style-tabela table tr td {
        padding: 0.5em;
        border: 1px solid #ccc;
        border-top: 0;
        border-left: 0;
    }

    .style-tabela table td.top {
        background-color: #00bcc4;
        color: #fff;
        font-size: 1.2em;
    }

    .style-tabela table td.top.center {
        text-align: center;
    }

    .style-tabela table td.total {
        text-align: left;
        font-weight: bold;
    }

    .style-tabela table td.top-toltip {
        background-color: #207d97;
        height: 25px;
        color: #fff;
        font-size: 16px;
    }

    .style-tabela tbody tr td {
        padding: 0.3em;
        border: 1px solid #ccc;
        border-top: 0;
        border-left: 0;
    }

    .style-tabela tbody tr {
        background-color: #fff;
        color: #666;
    }

    .style-tabela tbody tr:hover {
        background-color: #f4f4f4;
        color: #00bcc4;
    }


    .style-tabela tbody tr td .editar {
        color: #00d549;
        font-size: 1.2em;
        font-weight: bold;
        display: inline;
        text-decoration: none;
    }

    .style-tabela tbody tr td .deletar {
        color: #bf303c;
        font-size: 1.2em;
        font-weight: bold;
        display: inline;
        text-decoration: none;
    }

    .style-tabela tbody tr.mensagemAlerta {
        background-color: #fdeeef;
        color: #bf303c;
    }
</style>

</html>