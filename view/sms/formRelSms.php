<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlParametros.php';


header("Content-Type: text/html;  charset=ISO-8859-1",true);
$_SESSION['inclui'] = "t";

$parametros = new ControlParametros();
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
		
		<script language="javascript" type="text/javascript">
			function initXHR(){
                if(window.XMLHttpRequest){
                    xhr = new XMLHttpRequest();
                }else if (window.ActiveXObject){
                    xhr = new ActiveXObject("Microsoft.XMLHttp");
                }
            }
			
			function sendRequest(url, handler){				
                initXHR();				
                xhr.onreadystatechange = handler;
                xhr.open("GET", url, true);
                xhr.send(null);
            }
			
			function buscaCreditosSms(){				
				var url = "creditos.php";
				sendRequest(url, ajaxBuscaCreditosSms);
			}
			
			function ajaxBuscaCreditosSms(){				
				if(xhr.readyState==4 || xhr.readyState=="complete"){					
					xmlDoc=xhr.responseXML;
					try{
						document.getElementById("qtd").value = xmlDoc.getElementsByTagName("creditos")[0].childNodes[0].nodeValue;
					}catch(e){
						alert("Erro");
					}
				}
            }
			
		</script>
		<script>
		$(function() {

			$( "#sms" ).dialog({
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
						
					},
					
			});

		});
		</script>		
  </head>

   <body onload="buscaCreditosSms();">						
		<div id="tudo">
			<div id="conteudo">
				<div id="topo">
					<?php include("../menu/menu.php"); ?>
				</div>
				<div id="sms">
					<h2>Créditos de SMS</h2>										
					<table width="100%" height="50%">							
						<tr>
							<td align="right" width="50%"><h3>Quantidade</h3></td>
							<td align="left">
								<input type="text" name="qtd" id="qtd" readonly />
							</td>
						</tr>
					</table>							
				</div>
				
				<div class="clear"></div>
			</div>
			<div  id="bg_rodape">
				<?php include("../rodape.php"); ?>
			</div>
		</div>			
   </body>

</html>
