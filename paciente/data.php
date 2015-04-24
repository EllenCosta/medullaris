<?php
include 'dao/controlPaciente.php';
//@require("");
$cp = new ControlPaciente();
$data = $cp->alerta($_POST["cpf"]);
//$nome = $_POST["cpf"];
echo utf8_encode($data);

?>