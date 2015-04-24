<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

@require("../../control/controlPaciente.php");
$cp = new ControlPaciente();
$lista = $cp->dataSMS($_POST['id']);

?>