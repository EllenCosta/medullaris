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

$id = $_POST['id_modelo_sms'];
$nome = $_POST['nome'];
$texto = $_POST['texto'];

$m = new ModeloSms();
$m->setIdModeloSms($id);
$m->setDescricao($nome);
$m->setTexto($texto);

$modeloSmsDao = new ModeloSmsDao();
$modeloSmsDao->alterar($m);

/////////acessos///////////////
$acessosDao = new AcessosDao();
$acessos = new Acessos();
$acessos->setIdUsuario($_SESSION['id_usuario']);
$acessos->setComando("ALT");
$acessos->setArquivo("Modelo de SMS");
$acessos->setObservacao("Modelo de SMS ".$m->getDescricao()." alterado");
$acessosDao->inserir($acessos);
//////////acessos/////////////////

echo("<script type='text/javascript'> alert('Modelo de SMS alterado com sucesso !!!'); location.href='formPesquisaSms.php?ex=true';</script>");

?>