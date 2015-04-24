<?php
//@require($_SERVER['DOCUMENT_ROOT']."/medullaris/model/modelGrupoUsuario.php");
#inclui a classe Modelo
include '../model/modelG.php';

class ControlGrupoUsuario {
   

    function listar($sql) {

        $objList = new modelGrupoUsuario();
        return $lista = $objList->listar($sql);
    }

    
    function inserir($descricao) {
    
        $objList = new modelGrupoUsuario();
        return $resp = $objList->inserir($descricao);
    }

   
    function alterar($id_grupo, $descricao) {
 
        $objList = new modelGrupoUsuario();
        return $resp = $objList->alterar($id_grupo, $descricao);
    }

    function excluir($id_grupo) {
 
        $objList = new modelGrupoUsuario();
        return $resp = $objList->excluir($id_grupo);
    }

    function contar($sql) {

        $objList = new modelGrupoUsuario();
        return $res = $objList->contar($sql);
    }
}
