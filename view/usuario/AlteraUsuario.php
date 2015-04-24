<?php
include_once '../../control/controlUsuario.php';
include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);


$id_usuario = $_POST['id_usuario'];
$login = $_POST['login'];

if(isset($_POST['senha'])){
	$senha = MD5(utf8_decode($_POST['senha']));
}else{
	$senha = "";
}
$nome = utf8_decode($_POST['nome']);
if(isset($_POST['status'])){
	$status = $_POST['status'];
}else{
	$status = "A";
}
$id_grupo = $_POST['id_grupo'];
if(isset($_POST['master'])){
	$master = $_POST['master'];
}else{
	$master = "N";
}
if(isset($_POST['generico'])){
	$generico = $_POST['generico'];
}else{
	$generico = "N";
}

$usuario = new ControlUsuario();
$resp = $usuario->alterar($id_usuario, $login, $senha, $nome, $status, $id_grupo, $master, $generico);


echo $resp;



?>