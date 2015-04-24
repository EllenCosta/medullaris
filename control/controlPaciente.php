<?php

#inclui a classe Modelo
include '../../model/modelPaciente.php';

class ControlPaciente {
    
    #consulta
    function buscar($cpf) {

        $objPaciente = new modelPaciente();
        return $nomePaciente = $objPaciente->buscar($cpf);
    }

    #inserir
    function inserir($nome, $cpf, $tel) {

        #invocar métódo  e passar parâmetros
        $objPaciente = new modelPaciente();
        return $return = $objPaciente->inserir($nome, $cpf, $tel);
    }

    #alterar
    function logar($login, $pass) {

        #invocar métódo  e passar parâmetros
        $objPaciente = new modelPaciente();
        return $valor = $objPaciente->logar($login, $pass);
    }

    function listar($id,$nome,$cpf,$status,$sqlp) {
        $objList = new modelPaciente();
        return $lista = $objList->listar($id,$nome,$cpf,$status,$sqlp);
    }

    function alterar($id, $nome, $cpf, $tel,$status){

        $objPaciente = new modelPaciente();
        return $resposta = $objPaciente->alterar($id, $nome, $cpf, $tel,$status);
    }

    function excluir($id){
        
        $objPaciente = new modelPaciente();
        return $status = $objPaciente->excluir($id);
    }

    function busca($cpf){
        
        $objPaciente = new modelPaciente();
        return $status = $objPaciente->busca($cpf);
    }

    function contar(){
        $objPaciente = new modelPaciente();
        return $cont = $objPaciente->contar();
    }

    function dataSMS($id) {

        $objPaciente = new modelPaciente();
        $objPaciente->dataSMS($id);
    }
}
