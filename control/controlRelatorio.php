<?php

include '../../model/modelRelatorio.php';

class ControlRelatorio {


    function listar($id, $nome, $cpf, $sql) {

        $objList = new modelRelatorio();
        return $lista = $objList->listar($id, $nome, $cpf,$sql);
    }

    function busca() {

        $objList = new modelRelatorio();
        return $busca = $objList->busca();
    }

    function contar($nome, $cpf) {

        $objList = new modelRelatorio();
        return $lista = $objList->contar($nome,$cpf);
    }

    function conte($sql) {

        $objList = new modelRelatorio();
        return $lista = $objList->conte($sql);
    }
   
}
