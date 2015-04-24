<?php
require "../controlaSessao.php";
header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();

@require("../DAO/PDOConnectionFactory.class.php");
@require("../DAO/AcessosDao.class.php");
@require("../DAO/ModeloSmsDao.class.php");
@require("../entidades/ModeloSms.class.php");
@require("../entidades/Acessos.class.php");

$id_modelo_sms = $_GET['id_modelo_sms'];
$modeloSmsDao = new ModeloSmsDao();

$modelo = "";
foreach($modeloSmsDao->listar("select * from modelo_sms where id_modelo_sms = $id_modelo_sms") as $tip){
	$modelo = $tip['descricao'];	
}

if($modeloSmsDao->excluir($id_modelo_sms) > 0){
	/////////acessos////////////////
	$acessosDao = new AcessosDao();
	$acessos = new Acessos();
	$acessos->setIdUsuario($_SESSION['id_usuario']);
	$acessos->setComando("EXC");
	$acessos->setArquivo("Modelo de SMS");
	$acessos->setObservacao("Modelo de SMS ".$modelo." excluido");
	$acessosDao->inserir($acessos);
	//////////acessos/////////////////
	echo("<script type='text/javascript'> alert('Modelo de SMS excluido com sucesso !!!'); location.href='formPesquisaSms.php?ex=true';</script>");
}else{
	echo("<script type='text/javascript'> alert('Houve um erro ao excluir !!!'); location.href='formPesquisaSms.php?ex=true';</script>");
}

?>