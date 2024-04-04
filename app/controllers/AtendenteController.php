<?php

include_once '../models/Usuario.php';
include_once '../models/Atendimento.php';

class AtendenteController
{

    public function cadastrarUsuario($dados)
    {
        $usuario = new Usuario();
        return $usuario->cadastrar($dados);
    }

    public function pesquisarUsuarios($termo)
    {
        $usuario = new Usuario();
        return $usuario->buscar($termo);
    }

    public function editarUsuario($id, $novosDados)
    {
        $usuario = new Usuario();
        return $usuario->atualizar($id, $novosDados);
    }

    public function agendarConsulta($idPaciente, $idMedico, $data, $observacoes)
    {
        $atendimento = new Atendimento();
        return $atendimento->agendarConsulta($idPaciente, $idMedico, $data, $observacoes);
    }

}
