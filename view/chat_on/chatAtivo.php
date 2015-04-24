<?php
//require "controlaSessao.php";
date_default_timezone_set('America/Sao_Paulo');
header("Content-Type: text/html; charset=ISO-8859-1", true);

@require($_SERVER['DOCUMENT_ROOT']."/medullaris/control/controlUsuario.php");

$usuarioDao = new ControlUsuario();

$ativo = $_GET['ativo'];

$usuarioDao->listar("update usuario set chat_ativo = '$ativo' where id_usuario = '".$_SESSION['id_usuario']."'")

?>