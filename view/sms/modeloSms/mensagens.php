<?php
//require "../controlaSessao.php";
include_once '../../control/controlParametros.php';
//session_start();

//if(!isset($_SESSION['id_usuario'])) {
//	header("Location: ../".$_SESSION['cliente']."/index.php");
//}

//@require("../DAO/PDOConnectionFactory.class.php");
//@require("../DAO/ParametrosDao.class.php");

$parametros = new ControlParametros();

$ini = implode("-",array_reverse(explode("/",$_GET['ini'])));
$fim = implode("-",array_reverse(explode("/",$_GET['fim'])));

$chave = "";
foreach($parametros->listar("select valor from parametros where descricao = 'Chave_sms'") as $param){
	$chave = $param['valor'];
}
$result = "";
try{
	$result = file_get_contents("https://sms.comtele.com.br/api/$chave/detailedreport?startDate=$ini&endDate=$fim"); 
}catch(Exception $e){
	echo 'Aviso: ', $e->getMessage(), "\n";
}
//echo "https://sms.comtele.com.br/api/$chave/detailedreport?startDate=$ini&endDate=$fim";
echo $result;

?>