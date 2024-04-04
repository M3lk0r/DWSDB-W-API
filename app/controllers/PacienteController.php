<?php

include_once '../models/Atendimento.php';

class PacienteController
{

    public function listarAtendimentos($idPaciente)
    {
        $atendimento = new Atendimento();
        return $atendimento->listarAtendimentosPaciente($idPaciente);
    }

}
