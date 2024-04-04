<?php
session_start();

if ($_SESSION['tipo'] != 'atendente') {
    header("Location: ../login.php");
    exit;
}

include_once '../../../config/database.php';

include_once '../../models/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['termo_pesquisa'])) {
    $termoPesquisa = $_POST['termo_pesquisa'];

    $usuario = new Usuario();

    $resultadoPesquisa = $usuario->buscar($termoPesquisa);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Usuários</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <header>
        <h1>Pesquisar Usuários</h1>
    </header>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="termo_pesquisa" placeholder="Digite o termo de pesquisa" required>
            <button type="submit">Pesquisar</button>
        </form>

        <?php
        if (isset($resultadoPesquisa)) {
            echo '<h2>Resultados da Pesquisa</h2>';
            if ($resultadoPesquisa) {
                echo '<ul>';
                foreach ($resultadoPesquisa as $usuario) {
                    echo '<li>ID: ' . $usuario['id'] . ', Nome: ' . $usuario['nome'] . ', Tipo: ' . $usuario['tipo'] . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Nenhum resultado encontrado.</p>';
            }
        }
        ?>

        <a href="atendente.php">Voltar</a>
        <a href="logout.php">Logout</a>
    </div>

    <script src="../../public/assets/js/script.js"></script>
</body>

</html>