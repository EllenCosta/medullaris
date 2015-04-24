<?php
require "../controlaSessao.php";

header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();

if(!isset($_SESSION['id_usuario'])) {
	header("Location: ../".$_SESSION['cliente']."/index.php");
}

@require("../DAO/PDOConnectionFactory.class.php");
@require("../DAO/EmpresaDao.class.php");
@require("../DAO/ParametrosDao.class.php");
@require("../DAO/AcessosDao.class.php");
@require("../DAO/ModeloSmsDao.class.php");
@require("../DAO/SalasDao.class.php");
@require("../DAO/AgendaDao.class.php");
@require("../entidades/Acessos.class.php");

$empresaDao = new EmpresaDao();
$parametrosDao = new ParametrosDao();
$salasDao = new SalasDao();
$modeloSmsDao = new ModeloSmsDao();
$agendaDao = new AgendaDao();

$id_agenda = $_POST['agenda'];
$modelo_sms = $_POST['modelo_sms'];
$dia = implode("-",array_reverse(explode("/",$_POST['ini'])));

$nomeAgenda = "";
foreach($salasDao->listar("select desc_sal from salas where id_salas = '$id_agenda'") as $ag){
	$nomeAgenda = $ag['desc_sal'];
}

$nome_clinica = "";
$tel = "";
$sqlE = "select desc_imp, telefone from empresa where id_empresa = '".$_SESSION['empresa']."'";
foreach($empresaDao->listar($sqlE) as $e){
	$nome_clinica = $e['desc_imp'];
	$tel = $e['telefone'];
}

$chave = "";
foreach($parametrosDao->listar("select valor from parametros where descricao = 'Chave_sms'") as $param){
	$chave = $param['valor'];
}

function post_to_url($url, $data) {
   $fields = http_build_query($data);
   $post = curl_init();

   $url = $url.'?'.$fields;

   curl_setopt($post, CURLOPT_URL, $url);
   curl_setopt($post, CURLOPT_POST, 1);
   curl_setopt($post, CURLOPT_POSTFIELDS, $fields);

   $result = curl_exec($post);

   if($result == false){
       //die('Curl error: ' . curl_error($post));
       die('Houve um erro ao enviar');
   }

   curl_close($post);
}
$sql = "select paciente, celular, dia, hora from agenda where dia = '$dia' and id_sala = '$id_agenda' and (exc <> 'S' or exc is null) and (celular != ''  or celular is not null) and situacao = 'Marcado' ";
//echo $sql;
$cont = 0;
foreach($agendaDao->listar($sql) as $agenda){
	$content = $_POST['conteudo_sms'];
	$content = str_replace("{dia}", implode("/",array_reverse(explode("-",$agenda['dia']))), $content);
	$content = str_replace("{hora}", $agenda['hora'], $content);
	$content = str_replace("{paciente}", $agenda['paciente'], $content);
	$content = str_replace("\r","",$content);
	$content = str_replace("\n","",$content);
	$paciente = $agenda['paciente'];
	$sender = $nome_clinica;
	$receiver = $agenda['celular'];// numero
	$numero = $receiver; 
	$receiver = str_replace("-","",$receiver);
	$receiver = str_replace(" ","",$receiver);
	$receiver = str_replace("(","",$receiver);
	$receiver = str_replace(")","",$receiver);

	$url = "https://sms.comtele.com.br/Api/".$chave."/SendMessage";
	$data = array(
			'content' => $content,
			'sender' => $sender,
			'receivers' => $receiver
	);

	post_to_url($url, $data);
	$cont++;
	//echo $content."<br><br>";
}
$obs = "";

if($modelo_sms == ""){
	$obs = "Enviado com texto manual.";
}else{
	$obs = "Enviado com o modelo $modelo_sms";
}
/////////acessos///////////////
$acessosDao = new AcessosDao();
$acessos = new Acessos();
$acessos->setIdUsuario($_SESSION['id_usuario']);
$acessos->setComando("INC");
$acessos->setArquivo("Sms");
$acessos->setObservacao("SMS enviado para $cont paciente(s) da agenda $nomeAgenda do dia ".$_POST['ini'].". ".$obs);
$acessosDao->inserir($acessos);
//////////acessos/////////////////

//echo("<script type='text/javascript'> alert('SMS\'s enviados com sucesso'); location.href='formEnviaSms.php';</script>");
//echo "SMS\'s enviados com sucesso";
?>









