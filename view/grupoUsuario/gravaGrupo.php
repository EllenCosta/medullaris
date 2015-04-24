<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlGrupoUsuario.php';
include_once '../../model/modelGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$descricao = utf8_decode($_POST['descricao']);

$grupo = new controlGrupoUsuario();
$res = $grupo->inserir($descricao);

echo $res;
?>