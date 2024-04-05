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
            $listaAtendimentos = $atendimento->listarAtendimentosPaciente($u['id']);

            if (!empty($listaAtendimentos)) {
                $idMedico = $listaAtendimentos[0]['id_medico'];
                $medico = new Usuario();
                $dadosMedico = $idMedico ? $medico->buscarUsuarioPorId($idMedico) : null;
            }
            $atendimentos[$u['id']] = $atendimento->listarAtendimentosPaciente($u['id']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>Pesquisar Paciente e Listar Atendimentos</h1>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
</header>

<body>
    <div class="style-tabela">
        <form action="listar_atendimentos.php" method="POST">
            <div class="form-group">
                <label for="termo">Nome ou CPF do Paciente:</label>
                <input type="text" id="termo" name="termo" required>
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>

        <h2>Resultados da Pesquisa:</h2>
        <?php if (!empty($usuarios)) : ?>
            <?php foreach ($usuarios as $u) : ?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th colspan="6"><?php echo $u['nome']; ?></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6">CPF: <?php echo $u['cpf']; ?></td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td class="top center">Medico</td>
                            <td class="top center">Data</td>
                            <td class="top center">Observações</td>
                            <td class="top center" colspan="2" width="1"><strong>Ações</strong></td>
                        </tr>
                        <?php if (!empty($atendimentos[$u['id']])) : ?>
                            <?php foreach ($atendimentos[$u['id']] as $atendimento) : ?>
                                <tr>
                                    <td align="center"><?php echo $dadosMedico['nome']; ?></td>
                                    <td align="center"><?php if (($atendimento['data_atendimento'] < $atendimento['data_retorno']) or ($atendimento['data_agendamento'] != null)) {
                                                            echo $atendimento['data_retorno'];
                                                        } else {
                                                            echo $atendimento['data_atendimento'];
                                                        } ?></td>
                                    <td align="center"><?php echo $atendimento['observacoes']; ?></td>
                                    <td align="center"> <a href="#" class="bi bi-pencil-fill" title="Editar"></a> </td>
                                    <td align="center"> <a href="#" class="deletar fa fa-times-circle" title="Deletar"></a> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td align="center" colspan="5">Nenhum atendimento registrado.</td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td align="center" colspan="5">Nenhum resultado encontrado.</td>
                    </tr>
                <?php endif; ?>
                    </tbody>
                </table>
                <a href="atendente.php">Voltar</a>
                <a href="../logout.php">Logout</a>
    </div>
    <script src="../../public/assets/js/script.js"></script>
</body>
<!-- não sei pq a porcaria da tabela n puxa o css -->
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