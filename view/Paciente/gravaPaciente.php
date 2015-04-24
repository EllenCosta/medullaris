<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

@require("../../control/controlPaciente.php");
$cp = new ControlPaciente();
$return = $cp->inserir(utf8_decode($_POST["nome"]),$_POST["cpf"],$_POST["tel"]);
echo $return;
 
?>