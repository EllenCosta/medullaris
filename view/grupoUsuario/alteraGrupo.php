<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$grupo = new ControlGrupoUsuario();

$res = $grupo->alterar($_POST['id_grupo'], utf8_decode($_POST['descricao']));

echo $res;

?>