<?php
include 'dao/controlPaciente.php';
//@require("");
$cp = new ControlPaciente();
$nome = $cp->buscar($_POST["cpf"]);
//$nome = $_POST["cpf"];
echo utf8_encode($nome);

?>