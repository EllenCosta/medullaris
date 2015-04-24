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
$id_usuario = $_GET['id_usuario'];
$dia_semana = utf8_decode($_GET['dia_semana']);
$hora_ini = $_GET['hora_ini'];
$hora_fim = $_GET['hora_fim'];

$horario = new modelHorario();
$h = new controlHorario();

$h->setIdHorarioLogin($id);
$h->setDiaSem($dia_semana);
$h->setHoraIni($hora_ini);
$h->setHoraFim($hora_fim);
$h->setIdUsuario($id_usuario);

$horario->alterar($h);

echo "Alterado com Sucesso";
?>