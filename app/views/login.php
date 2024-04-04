<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SESSION['tipo'] == 'paciente') {
        header("Location: paciente.php");
    } elseif ($_SESSION['tipo'] == 'funcionario') {
        header("Location: funcionario.php");
    } elseif ($_SESSION['tipo'] == 'medico') {
        header("Location: medico.php");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once '../../config/database.php';

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['tipo'] = $row['tipo'];

        if ($_SESSION['tipo'] == 'paciente') {
            header("Location: ./paciente/paciente.php");
        } elseif ($_SESSION['tipo'] == 'medico') {
            header("Location: ./medico/medico.php");
        } elseif ($_SESSION['tipo'] == 'atendente') {
            header("Location: ./atendente/atendente.php");
        }
    } else {
        header("Location: index.php?error=login_failed");
    }
} else {
    header("Location: ../../public/index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Login</h1>
    </header>

    <div class="container">
        <?php
        if (isset($mensagemErro)) {
            echo '<div class="alert alert-danger" role="alert">' . $mensagemErro . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>

</html>