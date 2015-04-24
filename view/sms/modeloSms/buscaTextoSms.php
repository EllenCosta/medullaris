<?php
require "../controlaSessao.php";
session_start();
header("Content-Type: text/html;  charset=ISO-8859-1",true);
@require("../DAO/PDOConnectionFactory.class.php");
@require("../DAO/ModeloSmsDao.class.php");
@require("../DAO/EmpresaDao.class.php");

$id_modelo = $_GET['id_modelo'];

$modeloSmsDao = new ModeloSmsDao();
$sql = "select texto from modelo_sms where id_modelo_sms= '$id_modelo'";
$texto = "";
foreach($modeloSmsDao->listar($sql) as $m){
	$texto = $m['texto'];
}

$nome_clinica = "";
$tel = "";
$sqlE = "select desc_imp, telefone from empresa where id_empresa = '".$_SESSION['empresa']."'";
$empresaDao = new EmpresaDao();
foreach($empresaDao->listar($sqlE) as $e){
	$nome_clinica = $e['desc_imp'];
	$tel = $e['telefone'];
}

$texto = str_replace("{unidade}", $nome_clinica, $texto);
$texto = str_replace("{tel}", $tel, $texto);
echo $texto;
?>