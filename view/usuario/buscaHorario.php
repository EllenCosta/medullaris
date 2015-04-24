<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
include '../../model/modelHorario.php';
include '../../control/controlHorario.php';

header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$id = $_GET['id'];

$sql = "select * from horario_login where id_horario_login = $id";
$horario = new modelHorario();
$cont = 0;

echo "<?xml version='1.0' encoding='iso-8859-1'?>";
echo "<horario>";
	
foreach ($horario->listar($sql) as $h){
	echo "<hora_ini>".$h['hora_ini']."</hora_ini>";
	echo "<hora_fim>".$h['hora_fim']."</hora_fim>";
	echo "<dia_semana>".$h['dia_sem']."</dia_semana>";
}
echo "</horario>";
?>