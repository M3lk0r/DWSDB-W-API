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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['termo'])) {
    try {
        $termo = $_POST['termo'] ?? '';
        $usuario = new Usuario();
        $usuarios = $usuario->buscar($termo);
        $atendimento = new Atendimento();

        $_POST = '';
        $_POST . clearstatcache();
        foreach ($usuarios as $u) {
            $listaAtendimentos = $atendimento->listarAtendimentosPaciente($u['id']);

            if (!empty($listaAtendimentos)) {
                $idMedico = $listaAtendimentos[0]['id_medico'];
                $medico = new Usuario();
                $dadosMedico = $idMedico ? $medico->buscarUsuarioPorId($idMedico) : null;
            }
            $atendimentos[$u['id']] = $atendimento->listarAtendimentosPaciente($u['id']);
        }
    } catch (Exception $e) {
        $_POST = '';
        $_POST . clearstatcache();
        echo 'Ocorreu um erro: ' . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletar_atendimento'])) {
    try {
        $atendimento = new Atendimento();
        $idAtendimento = $_POST['deletar_atendimento'];
        $resultado = $atendimento->deletarAtendimentoPorId($idAtendimento);
        $_POST = '';
        $_POST . clearstatcache();
        echo $resultado;
    } catch (Exception $e) {
        $_POST = '';
        $_POST . clearstatcache();
        echo 'Ocorreu um erro ao deletar atendimento: ' . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_atendimento'])) {

    try {
        $atendimento = new Atendimento();
        $idAtendimento = $_POST['editar_atendimento']['id'];
        $data = $_POST['editar_atendimento']['data'];
        $observacoes = $_POST['editar_atendimento']['observacoes'];

        $resultado = $atendimento->atualizarAtendimento($idAtendimento, $observacoes, $data);

        $_POST = '';
        $_POST . clearstatcache();
        if ($resultado) {
            echo "Atendimento atualizado com sucesso.";
        } else {
            throw new Exception("Erro ao atualizar o Atendimento.");
        }
    } catch (Exception $e) {
        $_POST = '';
        $_POST . clearstatcache();
        echo $e->getMessage();
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
                                    <td align="center">
                                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                            <input type="hidden" name="editar_atendimento[id]" value="<?php echo $atendimento['id']; ?>">
                                            <button type="editar" class="editar bi bi-pencil-fill" title="Editar"></button>
                                        </form>
                                    </td>
                                    <td align="center">
                                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                            <input type="hidden" name="deletar_atendimento" value="<?php echo $atendimento['id']; ?>">
                                            <button type="delete" class="deletar fa fa-times-circle" title="Deletar"></button>
                                        </form>
                                    </td>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $('.editar').click(async function(e) {
        e.preventDefault();
        var data = $(this).closest('tr').find('td:eq(1)').text();
        var observacoes = $(this).closest('tr').find('td:eq(2)').text();
        var idAtendimento = $(this).closest('tr').find('input[name="editar_atendimento[id]"]').val();

        $('#edit-data').val(data);
        $('#edit-observacoes').val(observacoes);
        $('#edit-id').val(idAtendimento);

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });

        const {
            value: formValues
        } = await Swal.fire({
            title: "Editar atendimento",
            html: `
        <input type="hidden" id="edit-id" name="edit-id">
        <label for="edit-email">Data do atendimento:</label>
        <input type="datetime-local" id="edit-data" name="edit-data" value="${data}">
        <div class="form-group">
            <label for="edit-observacoes">Observações:</label>
            <textarea id="edit-observacoes" name="edit-observacoes" rows="4" required><?php echo $atendimento['observacoes']; ?></textarea>
        </div>
        `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: "Editar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            preConfirm: async () => {
                return {
                    id: idAtendimento,
                    data: $('#edit-data').val(),
                    observacoes: $('#edit-observacoes').val(),
                };
            }
        });
        if (formValues) {
            console.log(formValues);
            $.ajax({
                url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                type: 'POST',
                data: {
                    editar_atendimento: formValues
                },
                success: function(result) {
                    swalWithBootstrapButtons.fire({
                        title: "Cadastro alterado",
                        text: 'O cadastro foi alterado com sucesso.',
                        icon: "success"
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swalWithBootstrapButtons.fire({
                        title: "Error!",
                        text: errorThrown,
                        icon: "error"
                    });
                }
            });
        }
    });

    $('.deletar').click(function(e) {
        e.preventDefault();
        var idAtendimento = $(this).closest('tr').find('input[name="editar_atendimento[id]"]').val();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                    type: 'POST',
                    data: {
                        deletar_atendimento: idAtendimento
                    },
                    success: function(result) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: 'Your file has been deleted.',
                            icon: "success"
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swalWithBootstrapButtons.fire({
                            title: "Error!",
                            text: errorThrown,
                            icon: "error"
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Fica para proxima :)",
                    icon: "error"
                });
            }
        });

    });
</script>

</html>