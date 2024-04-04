<?php

include_once '../../../config/database.php';

class Atendimento
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function agendarConsulta($idPaciente, $idMedico, $dataAtendimento, $observacoes)
    {
        $stmt = $this->conn->prepare("INSERT INTO atendimentos (id_paciente, id_medico, data_atendimento, observacoes) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("iiss", $idPaciente, $idMedico, $dataAtendimento, $observacoes);
            $resultado = $stmt->execute();

            if ($resultado) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function listarAtendimentosMedico($idMedico)
    {
        $sql = "SELECT * FROM atendimentos WHERE id_medico = $idMedico";
        $result = $this->conn->query($sql);

        $atendimentos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $atendimentos[] = $row;
            }
        }
        return $atendimentos;
    }

    public function abrirAtendimento($idAtendimento)
    {
        $sql = "SELECT * FROM atendimentos WHERE id = $idAtendimento";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function adicionarObservacoes($idAtendimento, $observacoes)
    {
        $sql = "UPDATE atendimentos SET observacoes = '$observacoes' WHERE id = $idAtendimento";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function encerrarAtendimento($idAtendimento, $dataRetorno)
    {
        $sql = "UPDATE atendimentos SET data_retorno = '$dataRetorno' WHERE id = $idAtendimento";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function listarAtendimentosPaciente($idPaciente)
    {
        $sql = "SELECT * FROM atendimentos WHERE id_paciente = $idPaciente";
        $result = $this->conn->query($sql);

        $atendimentos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $atendimentos[] = $row;
            }
        }
        return $atendimentos;
    }
}
