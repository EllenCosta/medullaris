<?php
require "controlaSessao.php";

header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();

session_destroy();
header("Location: index.php");
?>
