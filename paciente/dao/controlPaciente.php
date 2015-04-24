<?php

include 'modelPaciente.php';

class ControlPaciente {
    

    function buscar($cpf) {

        $objPaciente = new modelPaciente();
        return $nomePaciente = $objPaciente->buscar($cpf);
    }

    function note($cpf) {

        $objPaciente = new modelPaciente();
        return $data = $objPaciente->note($cpf);
    }

    function alerta($cpf) {

        $objPaciente = new modelPaciente();
        return $data = $objPaciente->alerta($cpf);
    }

    function nome($cpf) {

        $objPaciente = new modelPaciente();
        return $nome = $objPaciente->nome($cpf);
    }

    function inserir($nome, $cpf, $tel) {

        #invocar métódo  e passar parâmetros
        $objPaciente = new modelPaciente();
        return $return = $objPaciente->inserir($nome, $cpf, $tel);
    }


    function avaliacao($cpf, $dor) {

        $objPaciente = new modelPaciente();
        return $valor = $objPaciente->avaliacao($cpf, $dor);
    }

    function listar($id,$nome,$cpf,$sqlp) {
        $objList = new modelPaciente();
        return $lista = $objList->listar($id,$nome,$cpf,$sqlp);
    }

    function alterar($id, $nome, $cpf, $tel){

        $objPaciente = new modelPaciente();
        return $status = $objPaciente->alterar($id, $nome, $cpf, $tel);
    }

    function excluir($id){

        $objPaciente = new modelPaciente();
        return $status = $objPaciente->excluir($id);
    }

    function contar(){
        $objPaciente = new modelPaciente();
        return $cont = $objPaciente->contar();
    }
}
