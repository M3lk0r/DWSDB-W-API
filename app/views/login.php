<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SESSION['tipo'] == 'paciente') {
        header("Location: ./paciente/paciente.php");
    } elseif ($_SESSION['tipo'] == 'funcionario') {
        header("Location: ./funcionario/funcionario.php");
    } elseif ($_SESSION['tipo'] == 'medico') {
        header("Location: ./medico/medico.php");
    }
    session_unset();
    session_destroy();
    header("Location: ../../index.php");
} else {
    header("Location: ../../index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once '../models/Usuario.php';

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = new Usuario();

    $row = $usuario->login($email, $senha);

    if (!isset($_SESSION['id']) or !isset($_SESSION['tipo'])) {

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
        header("Location: logout.php");
    }
} else {
    header("Location: ../../index.php");
}
