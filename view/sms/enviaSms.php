<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlParametros.php';
//require "../controlaSessao.php";

//header("Content-Type: text/html;  charset=ISO-8859-1",true);
//ession_start();

//if(!isset($_SESSION['id_usuario'])) {
	//header("Location: ../".$_SESSION['cliente']."/index.php");
//}

$parametros = new controlParametros();


$nome_clinica = "medullaris";

$content = $_POST['texto'];
$content = str_replace("\r","",$content);
$content = str_replace("\n","",$content);
$dia = $_POST['dia'];
$paciente = $_POST['paciente'];
$sender = $nome_clinica;
$receiver = $_POST['fone'];
$numero = $receiver; 
$receiver = str_replace("-","",$receiver);
$receiver = str_replace(" ","",$receiver);
$receiver = str_replace("(","",$receiver);
$receiver = str_replace(")","",$receiver);


function post_to_url($url, $data) {
   $fields = http_build_query($data);
   $post = curl_init();

   $url = $url.'?'.$fields;

   curl_setopt($post, CURLOPT_URL, $url);
   curl_setopt($post, CURLOPT_POST, 1);
   curl_setopt($post, CURLOPT_POSTFIELDS, $fields);

   $result = curl_exec($post);

   if($result == false){
       die('Curl error: ' . curl_error($post));
   }

   curl_close($post);
}

$chave = "";
foreach($parametros->listar("select valor from parametros where descricao = 'Chave_sms'") as $param){
	$chave = $param['valor'];
}

$url = "https://sms.comtele.com.br/Api/".$chave."/SendMessage";
$data = array(
        'content' => $content,
        'sender' => $sender,
        'receivers' => $receiver
);

post_to_url($url, $data);
?>