<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlParametros.php';
include_once '../../model/modelParametros.php';

header("Content-Type: text/html;  charset=ISO-8859-1",true);


$parametrosDao = new modelParametros();

$par_Obriga_profissional_na_agenda = $_POST['par_Obriga_profissional_na_agenda'];
$par_Endereco_empresa = $_POST['par_Endereco_empresa'];
$par_Ip_fixo = $_POST['par_Ip_fixo'];
$par_Email_envio = $_POST['par_Email_envio'];
$par_Senha_email = $_POST['par_Senha_email'];
$par_Servidor_email = $_POST['par_Servidor_email'];
$par_Porta_servidor = $_POST['par_Porta_servidor'];
$par_Imprime_nome_empresa = $_POST['par_Imprime_nome_empresa'];
$par_mensagem_SMS = $_POST['par_mensagem'];
$par_Usa_sms = $_POST['par_Usa_sms'];
$par_Chave_sms = $_POST['par_Chave_sms'];
$par_Usa_horario_login = $_POST['par_Usa_horario_login'];


$parametros = new ControlParametros();
$parametros->setDescricao("Obriga_profissional_na_agenda");
$parametros->setValor($par_Obriga_profissional_na_agenda);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Endereco_empresa");
$parametros->setValor($par_Endereco_empresa);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Ip_fixo");
$parametros->setValor($par_Ip_fixo);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Email_envio");
$parametros->setValor($par_Email_envio);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Senha_email");
$parametros->setValor(base64_encode($par_Senha_email));
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Servidor_email");
$parametros->setValor($par_Servidor_email);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Porta_servidor");
$parametros->setValor($par_Porta_servidor);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Imprime_nome_empresa");
$parametros->setValor($par_Imprime_nome_empresa);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("mensagem");
$parametros->setValor($par_mensagem_SMS);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Usa_sms");
$parametros->setValor($par_Usa_sms);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Chave_sms");
$parametros->setValor($par_Chave_sms);
$parametrosDao->alterar($parametros);

$parametros = new ControlParametros();
$parametros->setDescricao("Usa_horario_login");
$parametros->setValor($par_Usa_horario_login);
$parametrosDao->alterar($parametros);



echo("<script type='text/javascript'> alert('Alterado com sucesso !!!'); location.href='parametros.php';</script>");

?>