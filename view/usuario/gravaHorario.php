<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
include '../../control/controlHorario.php';
include '../../model/modelHorario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$id_usuario = $_GET['id_usuario'];
$dia_semana = $_GET['dia_semana'];
$hora_ini = $_GET['hora_ini'];
$hora_fim = $_GET['hora_fim'];

$horario = new modelHorario();
$h = new ControlHorario();

$h->setDiaSem($dia_semana);
$h->setHoraIni($hora_ini);
$h->setHoraFim($hora_fim);
$h->setIdUsuario($id_usuario);

$horario->inserir($h);

echo "Salvo com Sucesso";
?>