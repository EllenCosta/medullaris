<?php

#inclui a classe Modelo
include '../../model/modelParametros.php';


class ControlParametros {

    public $idParametros;
    public $descricao;
    public $valor;
    
    #consultar
    public function setIdParametros( $idParametros ){
        $this->idParametros = $idParametros;
    }
    public function setValor( $valor ){
        $this->valor = $valor;
    }
    public function setDescricao( $descricao ){
        $this->descricao = $descricao;
    }
        
    public function getIdParametros(){
        return $this->idParametros;
    }       
    public function getDescricao(){
        return $this->descricao;
    }
    public function getValor(){
        return $this->valor;
    }


    function listar($sql) {

        $objList = new modelParametros();
        return $lista = $objList->listar($sql);
    }


}
