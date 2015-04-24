<?php
require "../controlaSessao.php";
header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();

if(!isset($_SESSION['id_usuario'])) {
	header("Location: ../".$_SESSION['cliente']."/index.php");
}
@require("../DAO/PDOConnectionFactory.class.php");
@require("../DAO/AcessosDao.class.php");
@require("../DAO/ModeloSmsDao.class.php");
@require("../entidades/ModeloSms.class.php");
@require("../entidades/Acessos.class.php");

$nome = $_POST['nome'];
$texto = $_POST['texto'];

$m = new ModeloSms();
$m->setDescricao($nome);
$m->setTexto($texto);

$modeloSmsDao = new ModeloSmsDao();
$modeloSmsDao->inserir($m);

/////////acessos///////////////
$acessosDao = new AcessosDao();
$acessos = new Acessos();
$acessos->setIdUsuario($_SESSION['id_usuario']);
$acessos->setComando("INC");
$acessos->setArquivo("Modelo de Sms");
$acessos->setObservacao("Modelo de SMS ".$m->getDescricao()." adicionado");
$acessosDao->inserir($acessos);
//////////acessos/////////////////

echo("<script type='text/javascript'> alert('Modelo de SMS cadastrado com sucesso !!!'); location.href='formPesquisaSms.php?ex=true';</script>");

?>