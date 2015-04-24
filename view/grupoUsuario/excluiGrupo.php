<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlGrupoUsuario.php';
include_once '../../control/controlUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);


$id_grupo = $_POST['id'];
$grupo = new ControlGrupoUsuario();
$descricao = "";

foreach($grupo->listar("select * from grupo where id_grupo = $id_grupo") as $usu){
	$descricao = $usu['descricao'];
}

$usuario = new ControlUsuario();
$ct = 0;
foreach($usuario->listar("select count(id_usuario) as qtd from usuario where id_grupo = '$id_grupo'") as $u){
	$ct = $u['qtd'];
}

if($ct > 0){
	echo 0;
}else{
		$res = $grupo->excluir($id_grupo);
		if($res == 1){
			echo 1;
		}else
		{
			echo 0;
		}
	
}
?>