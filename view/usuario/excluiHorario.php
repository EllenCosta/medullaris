<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
include '../../model/modelHorario.php';
include '../../control/controlHorario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$id = $_GET['id'];

$horarioDao = new modelHorario();
$horarioDao->excluir($id);

echo "Excluido com Sucesso";
?>