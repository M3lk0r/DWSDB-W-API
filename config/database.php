<?php
$config = parse_ini_file('../config.ini', true);

$servername = $config['DATABASE']['host'];
$username = $config['DATABASE']['user'];
$password = $config['DATABASE']['passwd'];
$database = $config['DATABASE']['db'];

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
