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

    public function atualizar($id, $dadosDoFormulario)
    {
        $sql = "UPDATE usuarios SET ";
        $params = array();
        foreach ($dadosDoFormulario as $campo => $valor) {
            $sql .= "$campo = ?, ";
            $params[] = $valor;
        }
        $sql = rtrim($sql, ', ');
        $sql .= " WHERE id = ?";

        $params[] = $id;

        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);

        $result = $stmt->execute();

        if ($result === false) {
            return false;
        } else {
            return true;
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

    public function buscarUsuarioPorId($id)
    {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function login($email, $senha)
    {
        $email = $this->conn->real_escape_string($email);
        $senha = $this->conn->real_escape_string($senha);
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        return $row;
    }

    public function deletarUsuarioPorId($id)
    {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM usuarios WHERE id = $id";
        $result = $this->conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
