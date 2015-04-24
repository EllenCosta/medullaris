<?php
require "../../controlaSessao.php";
header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();
if(!isset($_SESSION['id_usuario'])) {
	header("Location: ../".$_SESSION['cliente']."/index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
		<link href="../../jquery/css/main.css" rel="stylesheet" type="text/css" />			 	
		<link href="../../jquery/css/rodape.css" rel="stylesheet" type="text/css" />			 	
		<link href="../../jquery/css/screen.css" rel="stylesheet" type="text/css"/>
		

		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../../jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
  </head>

   <body>   
		<div id="tudo">
			<div id="conteudo">
			
				<div id="topo">
					<?php include("../menu/menu.php"); ?>					
				</div>									
					
				<div class="conteudo_login">
						
				</div>
				
				<div class="clear"></div>
				
			</div>
			
			<div id="bg_rodape">
				<?php include("../rodape.php"); ?>				
			</div>
		</div>			
   </body>

</html>
