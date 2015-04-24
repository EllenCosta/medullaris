<?php
require "../../controlaSessao.php";
header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
$_SESSION['inclui'] = "t";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
		<link href="../../jquery/css/main.css" rel="stylesheet" type="text/css" />
		<link href="../../jquery/css/rodape.css" rel="stylesheet" type="text/css" />

		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../../jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>

<script>
	$(function() {

		$( "#senha" ).dialog({
			autoOpen: true,
			height: 200,
			width: 500,
			modal: false,
			resizable: false,
			closeOnEscape: false,
			position: ['center',160],
			show:  {effect: "fade", duration: 200},
			hide:  {effect: "fade", duration: 200},
			
			buttons: {
				
				"gravar": function(){

					alteraSenha();
					},

				"Limpar": function() {
							document.getElementById("senha_atual").value = ""; 
							document.getElementById("nova_senha").value = "";
							document.getElementById("conf_nova_senha").value = "";
						}
								
			},

		});	

		$( "#confirma" ).dialog({
					modal: true,
					autoOpen: false,
					resizable: true,
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"Ok": function() {
							$( this ).dialog( "close" );
						},
					},
					
					close: function(){
						
					}
		});
	});
</script>
<script>
	function alteraSenha(){

		var erros = 0;
		$("#senha input").each(function(){
			$(this).val() == "" ? erros++ : "";
		});
		if(erros != 0 ){
			document.getElementById("msg").innerHTML = "Preencha todos os campos.";
			$( "#confirma" ).dialog( "open" );
		}else{
			$.ajax({
				type: 'POST',
				url: "alteraSenha.php",
				data: {senha_atual:document.getElementById("senha_atual").value, nova_senha:document.getElementById("nova_senha").value, conf_nova_senha:document.getElementById("conf_nova_senha").value},
				success: function(html){
						document.getElementById("msg").innerHTML = html;
						$( "#confirma" ).dialog( "open" );
						document.getElementById("senha_atual").value = ""; 
						document.getElementById("nova_senha").value = "";
						document.getElementById("conf_nova_senha").value = "";
				}
			});
		}	

		
	}
</script>
  </head>

   <body>						
		<div id="tudo">
			<div id="conteudo">
				<div id="topo">
					<?php include("../menu/menu.php"); ?>
				</div>
				<div id="senha" title="Alteração de Senha">																
					<table width="100%">
						<tr>
							<td colspan="2"> &nbsp; </td>
						</tr>						
						<tr>
							<td align="right" width="25%" height="30%"><h4>Senha Atual</h4></td>
							<td align="left" ><input type="password" id="senha_atual" name="senha_atual"/></td>
						</tr>
						<tr>
							<td align="right"><h4>Nova Senha</h4></td>
							<td align="left"><input type="password" id="nova_senha" name="nova_senha" /></td>
						</tr>
						<tr>
							<td align="right"><h4>Confirma Nova Senha</h4></td>
							<td align="left"><input type="password" id="conf_nova_senha" name="conf_nova_senha"  /></td>
						</tr>
						<tr>
							<td colspan="2"> &nbsp; </td>
						</tr>
					</table>										
				</div>

				<div id="confirma" title="Atencão">
					<p>						
						<h3><label id="msg" /></h3>
					</p>					
				</div>

				<div class="clear"></div>
			</div>
			<div  id="bg_rodape">
				<?php include("../rodape.php"); ?>
			</div>
		</div>			
   </body>

</html>
