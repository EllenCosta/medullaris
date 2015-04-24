<?php
require "../../controlaSessao.php";
include_once '../../control/controlParametros.php';
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}


$parametros = new ControlParametros();

$chave = "";

foreach($parametros->listar("select valor from parametros where descricao = 'Chave_sms'") as $param){
	$chave = $param['valor'];
}

$result = file_get_contents("https://sms.comtele.com.br/api/$chave/balance"); 
echo "<?xml version='1.0' encoding='iso-8859-1'?>";
echo "<creditos>".$result."</creditos>";
?>