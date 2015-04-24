<?php
header("Content-Type" . "text/plain");
include 'dao/controlPaciente.php';
//@require("");
$cp = new ControlPaciente();
$data = $cp->note($_POST["cpf"]);
//$nome = $_POST["cpf"];
echo $data;


?>