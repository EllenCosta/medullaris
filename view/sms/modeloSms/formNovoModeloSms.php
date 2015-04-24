<?php
require "../controlaSessao.php";
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
		<link href="../css/main.css" rel="stylesheet" type="text/css" />
		<link href="../css/rodape.css" rel="stylesheet" type="text/css" />			

		<script type="text/javascript" src="../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
		
		<script>			
			$(function() {				
				// Chamada da funcao upperText(); ao carregar a pagina
				upperText();
				// Funcao que faz o texto ficar em uppercase
				function upperText() {
					// Para tratar o colar
					$(".maiusculo").bind('paste', function(e) {
						var el = $(this);
						setTimeout(function() {
							var text = $(el).val();
							el.val(text.toUpperCase());
						}, 1);
					});
 
					// Para tratar quando é digitado
					$(".maiusculo").keypress(function() {
						var el = $(this);
						setTimeout(function() {
							var text = $(el).val();
							el.val(text.toUpperCase());
						}, 1);
					});
				}
			});
		</script>
		
		<script>			
			$(function() {	
					
			});
		</script>
  </head>

   <body>						
		<div id="tudo">
			<div id="conteudo">
				<div id="topo">
					<?php include("../menu.php"); ?>
				</div>
				<div id="main">	
					<div id="conteiner">		
						<div class="bg_area_login" align="center">
							<h2>Novo Modelo de SMS</h2>
			
							<form action="gravaModeloSms.php" method="post">																
								<table width="70%">
									<tr>
										<td colspan="2"> &nbsp; </td>
									</tr>															
									<tr>
										<td align="right" width="50%">Descrição</td>
										<td align="left"><input type="text" name="nome" width="50%" class="maiusculo"/></td>
									</tr>									
									<tr>
										<td align="right" width="50%">Texto</td>
										<td align="left">
											<textarea name="texto" width="50%" cols="20" rows="5" maxlength="100"></textarea>
										</td>
									</tr>																		
									<tr>
										<td colspan="2" align="center">
											<div align="center">
												<input type="submit" value = "Gravar" class="botao"/>
												<input type="reset" value = "Novo"  class="botao"/>
												<input type="button" value = "Pesquisar"  onclick="location. href= 'formPesquisaSms.php?ex=true'"  class="botao"/>
											<div align="center">
										</div>																			
									</tr>
								</table>										
							</form>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div  id="bg_rodape">
				<?php include("../rodape.php"); ?>
			</div>
		</div>			
   </body>

</html>
