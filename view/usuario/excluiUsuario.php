<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
include_once '../../control/controlUsuario.php';
include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$id_usuario = $_POST['id'];
$usuario = new ControlUsuario();

$user = $usuario->excluir($id_usuario);
echo $user;
/*
if($user == 1){
	echo("<script type='text/javascript'> alert('Usuário excluido com sucesso !!!'); location.href='PesquisaUsuario.php?ex=true';</script>");
}else{
	echo("<script type='text/javascript'> alert('Houve um erro ao excluir !!!'); location.href='PesquisaUsuario.php?ex=true';</script>");
}
*/
?>