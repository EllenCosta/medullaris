<?php
#include '../../model/modelHorario.php';

class ControlHorario {

    public $idHorarioLogin;
    public $diaSem; 
    public $horaIni;    
    public $horaFim;    
    public $idUsuario;  
    
    
    public function setIdHorarioLogin( $idHorarioLogin ){
        $this->idHorarioLogin = $idHorarioLogin;
    }
    public function setDiaSem( $diaSem ){
        $this->diaSem = $diaSem;
    }
    public function setHoraIni( $horaIni ){
        $this->horaIni = $horaIni;
    }
    public function setHoraFim( $horaFim ){
        $this->horaFim = $horaFim;
    }
    public function setIdUsuario( $idUsuario ){
        $this->idUsuario = $idUsuario;
    }
        
    public function getIdHorarioLogin(){
        return $this->idHorarioLogin;
    }       
    public function getDiaSem(){
        return $this->diaSem;
    }
    public function getHoraIni(){
        return $this->horaIni;
    }
    public function getHoraFim(){
        return $this->horaFim;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }
}

?>