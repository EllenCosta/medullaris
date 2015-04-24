<?php
require "../../controlaSessao.php";
require "../../control/controlUsuario.php";
header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
//@require("../../control/controlUsuario");

$id_usuario = $_SESSION['id_usuario'];
$empresa = $_SESSION['nome_empresa'];
$senha_atual = MD5($_POST['senha_atual']);
$nova_senha = MD5($_POST['nova_senha']);
$conf_nova_senha = MD5($_POST['conf_nova_senha']);
$senhaBanco = "";
$usuario = new ControlUsuario();

$res = $usuario->alteraSenha($id_usuario, $senha_atual, $nova_senha, $conf_nova_senha);


if($res == "senha"){
	
	echo "A senha atual não confere";

}elseif ($res == "nao") {
	
	echo "A nova senha não confere";

}else{
	
	$_SESSION['id_usuario'] = $id_usuario;
	$_SESSION['nome'] = utf8_encode($res);
	$_SESSION['nome_empresa'] = $empresa;
	echo "Senha alterada com sucesso!";
}

?>