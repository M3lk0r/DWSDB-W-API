<?php
session_start();

if ($_SESSION['tipo'] != 'atendente') {
    header("Location: ../login.php");
    exit;
}

include_once '../../models/Usuario.php';

$usuario = new Usuario();
$resultadoPesquisa = $usuario->buscar('');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['termo_pesquisa'])) {
    $termoPesquisa = $_POST['termo_pesquisa'];
    $resultadoPesquisa = $usuario->buscar($termoPesquisa);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletar_usuario'])) {
    $idUsuario = $_POST['deletar_usuario'];
    $resultado = $usuario->deletarUsuarioPorId($idUsuario);
    echo $resultado;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_usuario'])) {
    if (isset($_POST['editar_usuario']['edit-id']) && isset($_POST['editar_usuario']['edit-nome']) && isset($_POST['editar_usuario']['edit-endereco']) && isset($_POST['editar_usuario']['edit-email']) && isset($_POST['editar_usuario']['edit-celular']) && isset($_POST['editar_usuario']['edit-peso']) && isset($_POST['editar_usuario']['edit-tipo'])) {

        $idUsuario = $_POST['editar_usuario']['edit-id'];
        $nome = $_POST['editar_usuario']['edit-nome'];
        $endereco = $_POST['editar_usuario']['edit-endereco'];
        $email = $_POST['editar_usuario']['edit-email'];
        $celular = $_POST['editar_usuario']['edit-celular'];
        $peso = $_POST['editar_usuario']['edit-peso'];
        $tipo = $_POST['editar_usuario']['edit-tipo'];

        $dadosUsuario = array(
            'nome' => urldecode($nome),
            'endereco' => urldecode($endereco),
            'email' => urldecode($email),
            'celular' => urldecode($celular),
            'peso' => $peso,
            'tipo' => $tipo,
        );

        $resultado = $usuario->atualizar($idUsuario, $dadosUsuario);

        if ($resultado) {
            echo "Usuário atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar o usuário.";
        }
    } else {
        echo "Dados do formulário incompletos.";
    }
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
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="editar_usuario" value="<?php echo $usuario['id']; ?>">
                                    <button type="editar" class="editar bi bi-pencil-fill" title="Editar"></button>
                                </form>
                            </td>
                            <td align="center">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
    <div id="modal-editar" class="modal" style="display: none;">
        <div class="modal-content">
            <h2>Editar Usuário</h2>
            <form id="form-editar-usuario">
                <input type="hidden" id="edit-id" name="edit-id">
                <label for="edit-nome">Nome:</label>
                <input type="text" id="edit-nome" name="edit-nome">
                <label for="edit-email">Email:</label>
                <input type="text" id="edit-email" name="edit-email">
                <label for="edit-endereco">Endereço:</label>
                <input type="text" id="edit-endereco" name="edit-endereco">
                <label for="edit-celular">Celular:</label>
                <input type="text" id="edit-celular" name="edit-celular">
                <label for="edit-peso">Peso:</label>
                <input type="text" id="edit-peso" name="edit-peso">
                <label for="edit-tipo">Tipo:</label>
                <input type="text" id="edit-tipo" name="edit-tipo">
                <button type="button" id="btn-gravar">Gravar</button>
                <button type="button" id="btn-fechar">Fechar</button>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
    </script>

    <script type="text/javascript">
        $('.editar').click(function(e) {
            e.preventDefault();
            var nome = $(this).closest('tr').find('td:eq(0)').text();
            var email = $(this).closest('tr').find('td:eq(1)').text();
            var endereco = $(this).closest('tr').find('td:eq(3)').text();
            var celular = $(this).closest('tr').find('td:eq(4)').text();
            var peso = $(this).closest('tr').find('td:eq(6)').text();
            var tipo = $(this).closest('tr').find('td:eq(8)').text();
            var idUsuario = $(this).closest('form').find('input[name="editar_usuario"]').val();

            $('#edit-nome').val(nome);
            $('#edit-email').val(email);
            $('#edit-endereco').val(endereco);
            $('#edit-celular').val(celular);
            $('#edit-peso').val(peso);
            $('#edit-tipo').val(tipo);
            $('#edit-id').val(idUsuario);

            $('#modal-editar').show();
        });

        $('#btn-gravar').click(function(e) {
            e.preventDefault();
            var dadosDoFormulario = $('#form-editar-usuario').serialize();
            $.ajax({
                url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                method: 'POST',
                data: dadosDoFormulario, // Passando os dados diretamente
                success: function(response) {
                    console.log(response);
                    alert('Atualização realizada com sucesso.');
                    location.reload(); // Recarregando a página após a atualização
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.error(error);
                    alert('Erro ao atualizar usuário. Verifique o console para mais detalhes.');
                }
            });
        });

        $('#btn-fechar').click(function() {
            $('#modal-editar').toggle();
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
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }
            });

        });
    </script>
</body>

</html>