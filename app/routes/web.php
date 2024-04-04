<?php
require '../../config/config.php';

function CadastrarUsuario($obj)
{
    $ch = curl_init('http://127.0.0.1:5000' . '/users');

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($obj)); // Converte o objeto para JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Define o cabeçalho da solicitação
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $data = json_decode($response, true);
    $data['http_code'] = $http_code;
    $response_with_http_code = json_encode($data);

    if (curl_errno($ch)) {
        return null;
    }

    curl_close($ch);

    return $response_with_http_code;
}

function autenticar($usuario, $senha)
{
    $ch = curl_init('http://127.0.0.1:5000' . '/authenticate');
    $credentials = $usuario . ':' . $senha;
    $credentials = base64_encode($credentials);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials, 'Content-Type: application/json'));

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['usuario' => $usuario, 'senha' => $senha]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $data = json_decode($response, true);
    $data['http_code'] = $http_code;
    $response_with_http_code = json_encode($data);

    if (curl_errno($ch)) {
        return null;
    }

    curl_close($ch);

    return $response_with_http_code;
}
