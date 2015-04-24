<?php
require "controlaSessao.php";

header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();
$cliente = $_SESSION['cliente'];
session_destroy();
//header("Location: ../".$_SESSION['cliente']."/index.php");

session_start();
$_SESSION['cliente'] = $cliente;

?>
