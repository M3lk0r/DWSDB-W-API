<?php

include_once '../models/Atendimento.php';

class MedicoController
{

    public function listarAtendimentos($idMedico)
    {
        $atendimento = new Atendimento();
        return $atendimento->listarAtendimentosMedico($idMedico);
    }

    public function abrirAtendimento($idAtendimento)
    {
        $atendimento = new Atendimento();
        return $atendimento->abrirAtendimento($idAtendimento);
    }

    public function adicionarObservacoes($idAtendimento, $observacoes)
    {
        $atendimento = new Atendimento();
        return $atendimento->adicionarObservacoes($idAtendimento, $observacoes);
    }

    public function encerrarAtendimento($idAtendimento, $dataRetorno)
    {
        $atendimento = new Atendimento();
        return $atendimento->encerrarAtendimento($idAtendimento, $dataRetorno);
    }

}
