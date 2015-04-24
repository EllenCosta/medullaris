<?php
include 'dao/controlPaciente.php';
$cp = new ControlPaciente();
$nome = $cp->nome($_POST["cpf"]);
echo $nome;

?>