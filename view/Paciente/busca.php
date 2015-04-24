<?php
require "../../controlaSessao.php";
@require("../../control/controlPaciente.php");
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

$cp = new ControlPaciente();

$id = $cp->busca($_POST["cpf"]);
echo $id;


?>