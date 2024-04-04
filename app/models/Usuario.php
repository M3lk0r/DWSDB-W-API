<?php

include_once 'database.php';

class Usuario
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function cadastrar($dados)
    {
        $nome = $this->conn->real_escape_string($dados['nome']);
        $endereco = $this->conn->real_escape_string($dados['endereco']);
        $cpf = $this->conn->real_escape_string($dados['cpf']);
        $celular = $this->conn->real_escape_string($dados['celular']);
        $altura = $this->conn->real_escape_string($dados['altura']);
        $peso = $this->conn->real_escape_string($dados['peso']);
        $tipo_sanguineo = $this->conn->real_escape_string($dados['tipo_sanguineo']);
        $tipo = $this->conn->real_escape_string($dados['tipo']);
        $email = $this->conn->real_escape_string($dados['email']);
        $senha = $this->conn->real_escape_string($dados['senha']);

        if (empty($nome) || empty($cpf) || empty($email) || empty($senha)) {
            return false;
        }

        $sql = "INSERT INTO usuarios (nome, endereco, cpf, celular, altura, peso, tipo_sanguineo, tipo, email, senha) VALUES ('$nome', '$endereco', '$cpf', '$celular', $altura, $peso, '$tipo_sanguineo', '$tipo', '$email', '$senha')";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }


    public function buscar($termo)
    {
        $termo = $this->conn->real_escape_string($termo);
        $sql = "SELECT * FROM usuarios WHERE nome LIKE '%$termo%' OR cpf LIKE '%$termo%' OR email LIKE '%$termo%'";
        $result = $this->conn->query($sql);

        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        return $usuarios;
    }

    public function atualizar($id, $novosDados)
    {
        $sql = "UPDATE usuarios SET ";
        foreach ($novosDados as $campo => $valor) {
            $valor = $this->conn->real_escape_string($valor);
            $sql .= "$campo = '$valor', ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= " WHERE id = $id";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function listarUsuariosPorTipo($tipo)
    {
        $tipo = $this->conn->real_escape_string($tipo);
        $sql = "SELECT * FROM usuarios WHERE tipo = '$tipo'";
        $result = $this->conn->query($sql);

        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        return $usuarios;
    }
}
