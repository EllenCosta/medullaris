<?php
//@require($_SERVER['DOCUMENT_ROOT']."/medullaris/model/modelUsuario.php");
include '../../../model/modelUser.php';

class ControlUsuario {


    function inserir($login,$senha,$nome,$status,$id_grupo,$master,$generico) {

        $objUsuario = new modelUsuario();
        return $objUsuario->inserir($login,$senha,$nome,$status,$id_grupo,$master,$generico);
    }

    #alterar
    function logar($login, $pass) {

        #invocar métódo  e passar parâmetros
        $objUsuario = new modelUsuario();
        return $valor = $objUsuario->logar($login, $pass);
    }

    function alterar($id_usuario, $login, $senha, $nome, $status, $id_grupo, $master, $generico) {

        $objList = new modelUsuario();
        return $resp = $objList->alterar($id_usuario, $login, $senha, $nome, $status, $id_grupo, $master, $generico);
    }


    function excluir($id_usuario) {

        $objList = new modelUsuario();
        return $user = $objList->excluir($id_usuario);
    }


    function listar($sql) {
        $objList = new modelUsuario();
        return $lista = $objList->listar($sql);
    }

    function busca() {

        $objList = new modelUsuario();
        return $busca = $objList->busca();
    }

    function contar($sql) {

        $objList = new modelUsuario();
        return $lista = $objList->contar($sql);
    }

    function alteraSenha($id_usuario, $senha_atual, $nova_senha, $conf_nova_senha) {

        $objList = new modelUsuario();
        return $resp = $objList->alteraSenha($id_usuario, $senha_atual, $nova_senha, $conf_nova_senha);
    }
}
