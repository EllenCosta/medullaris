<?php
require "../../controlaSessao.php";
@require("../../control/controlPaciente.php");
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

$cp = new ControlPaciente();

$nome = $cp->alterar($_POST["id"],utf8_decode($_POST["nome"]),$_POST["cpf"],$_POST["tel"],$_POST["status"]);
echo $nome;
?>