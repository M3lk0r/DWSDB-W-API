<?php
session_start();

if ($_SESSION['tipo'] != 'atendente') {
    header("Location: ../login.php");
    exit;
}

include_once '../../models/Usuario.php';

$usuario = new Usuario();
$resultadoPesquisa = $usuario->buscar('');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletar_usuario'])) {
    $idUsuario = $_POST['deletar_usuario'];
    $resultado = $usuario->deletarUsuarioPorId($idUsuario);
    $_POST = '';
    $_POST . clearstatcache();
    echo $resultado;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_usuario'])) {

    echo $_POST['editar_usuario'];
    $idUsuario = $_POST['editar_usuario']['id'];
    $email = $_POST['editar_usuario']['email'];
    $endereco = $_POST['editar_usuario']['endereco'];
    $celular = $_POST['editar_usuario']['celular'];
    $peso = $_POST['editar_usuario']['peso'];
    $tipo = $_POST['editar_usuario']['tipo'];

    $dadosUsuario = array(
        'endereco' => urldecode($endereco),
        'email' => urldecode($email),
        'celular' => urldecode($celular),
        'peso' => $peso,
        'tipo' => $tipo,
    );

    $resultado = $usuario->atualizar($idUsuario, $dadosUsuario);

    $_POST = '';
    $_POST . clearstatcache();

    if ($resultado) {
        echo "Usuário atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o usuário.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['termo_pesquisa'])) {
    $termoPesquisa = $_POST['termo_pesquisa'];
    $resultadoPesquisa = $usuario->buscar($termoPesquisa);
    $_POST = '';
    $_POST . clearstatcache();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Usuários</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
</head>

<body>
    <header>
        <h1>Pesquisar Usuários</h1>
    </header>

    <div class="style-tabela">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="termo_pesquisa" placeholder="Digite o termo de pesquisa" required>
            <button type="submit">Pesquisar</button>
        </form>

        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th colspan="11">
                        <h2>Resultados da Pesquisa</h2>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="11"><a href="atendente.php">Voltar</a>
                        <a href="../logout.php">Logout</a>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td class="top center">Nome</td>
                    <td class="top center">Email</td>
                    <td class="top center">CPF</td>
                    <td class="top center">Endereço</td>
                    <td class="top center">Celular</td>
                    <td class="top center">Altura</td>
                    <td class="top center">Peso</td>
                    <td class="top center">Tipo Sanquineo</td>
                    <td class="top center">Tipo</td>
                    <td class="acoes" colspan="2" width="1"><strong>Ações</strong></td>
                </tr>
                <?php if ($resultadoPesquisa) : ?>
                    <?php foreach ($resultadoPesquisa as $usuario) : ?>
                        <tr>
                            <td align="center"><?php echo $usuario['nome']; ?></td>
                            <td align="center"><?php echo $usuario['email']; ?></td>
                            <td align="center"><?php echo $usuario['cpf']; ?></td>
                            <td align="center"><?php echo $usuario['endereco']; ?></td>
                            <td align="center"><?php echo $usuario['celular']; ?></td>
                            <td align="center"><?php echo $usuario['altura']; ?></td>
                            <td align="center"><?php echo $usuario['peso']; ?></td>
                            <td align="center"><?php echo $usuario['tipo_sanguineo']; ?></td>
                            <td align="center"><?php echo $usuario['tipo']; ?></td>
                            <td align="center">
                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <input type="hidden" name="editar_usuario[id]" value="<?php echo $usuario['id']; ?>">
                                    <button type="editar" class="editar bi bi-pencil-fill" title="Editar"></button>
                                </form>
                            </td>
                            <td align="center">
                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <input type="hidden" name="deletar_usuario" value="<?php echo $usuario['id']; ?>">
                                    <button type="delete" class="deletar fa fa-times-circle" title="Deletar"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td align="center" colspan="6">Nenhum resultado encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $('.editar').click(async function(e) {
            e.preventDefault();
            var nome = $(this).closest('tr').find('td:eq(0)').text();
            var email = $(this).closest('tr').find('td:eq(1)').text();
            var endereco = $(this).closest('tr').find('td:eq(3)').text();
            var celular = $(this).closest('tr').find('td:eq(4)').text();
            var peso = $(this).closest('tr').find('td:eq(6)').text();
            var tipo = $(this).closest('tr').find('td:eq(8)').text();
            var idUsuario = $(this).closest('tr').find('input[name="editar_usuario[id]"]').val();

            $('#edit-email').val(email);
            $('#edit-endereco').val(endereco);
            $('#edit-celular').val(celular);
            $('#edit-peso').val(peso);
            $('#edit-tipo').val(tipo);
            $('#edit-id').val(idUsuario);

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
                title: "Editar " + nome,
                html: `
        <input type="hidden" id="edit-id" name="edit-id">
        <label for="edit-email">Email:</label>
        <input type="text" id="edit-email" name="edit-email" value="${email}">
        <label for="edit-endereco">Endereço:</label>
        <input type="text" id="edit-endereco" name="edit-endereco" value="${endereco}">
        <label for="edit-celular">Celular:</label>
        <input type="text" id="edit-celular" name="edit-celular" value="${celular}">
        <label for="edit-peso">Peso:</label>
        <input type="text" id="edit-peso" name="edit-peso" value="${peso}">
        <label for="edit-tipo">Tipo:</label>
        <select name="edit-tipo" required id="edit-tipo">
            <option value="">Selecione um tipo</option>
            <option value="paciente" ${tipo === 'paciente' ? 'selected' : ''}>Paciente</option>
            <option value="atendente" ${tipo === 'atendente' ? 'selected' : ''}>Atendente</option>
            <option value="medico" ${tipo === 'medico' ? 'selected' : ''}>Medico</option>
        </select>
        `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Editar",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                preConfirm: async () => {
                    return {
                        id: idUsuario,
                        email: $('#edit-email').val(),
                        endereco: $('#edit-endereco').val(),
                        celular: $('#edit-celular').val(),
                        peso: $('#edit-peso').val(),
                        tipo: $('#edit-tipo').val()
                    };
                }
            });
            if (formValues) {
                $.ajax({
                    url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                    type: 'POST',
                    data: {
                        editar_usuario: formValues
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
            const idUsuario = $(this).closest('form').find('input[name="deletar_usuario"]').val();
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
                            deletar_usuario: idUsuario
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
</body>

</html>