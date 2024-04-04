<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
