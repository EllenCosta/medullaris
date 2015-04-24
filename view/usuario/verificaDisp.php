<?php
header("Content-Type: text/html;  charset=ISO-8859-1",true);
include_once '../../control/controlUsuario.php';

$login = $_GET['login'];
$acao = $_GET['acao'];
$id_usuario = "";
if($acao == "A"){
	$id_usuario = $_GET['id_usuario'];
}

$usuarioDao = new controlUsuario();

if($acao == "I"){
	$sql = "select count(id_usuario)as qtd from usuario where login = '$login' ";
}else{
	$sql = "select count(id_usuario)as qtd from usuario where login = '$login' and id_usuario <> '$id_usuario'";
}

$qtd = 0;
foreach($usuarioDao->listar($sql) as $u){
	$qtd = $u['qtd'];
}

if($qtd > 0){
	echo "1";
}else{
	echo "0";
}
?>