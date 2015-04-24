<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
include_once '../../control/controlUsuario.php';
include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$grupoUsuario = new ControlGrupoUsuario();
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
		<link type="text/css" href="../../jquery/css/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
		
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

				$( "#confirma" ).dialog({
					modal: true,
					autoOpen: false,
					resizable: false,
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
			
			function verificaDisp(){
				var login = document.getElementById("login").value;
				if(login.toUpperCase() == "ADMIN"){
					document.getElementById("msg").innerHTML = "O Login ADMIN não pode ser usado";
					$( "#confirma" ).dialog( "open" );
					document.getElementById("login").value = "";
				}else{
					if(login != ""){
						var url = "verificaDisp.php?login="+login+"&acao=I";
						sendRequest(url, ajaxVerificaDisp);
					}
				}				
			}
			
			function ajaxVerificaDisp(){
				if(xhr.readyState === 4) {
                    if(xhr.status === 200){
                        var retorno = xhr.responseText;
						if(retorno == "1"){
							var login = document.getElementById("login");
							document.getElementById("msg").innerHTML = "O Login "+login.value+" Já Está Sendo Usado";
							$( "#confirma" ).dialog( "open" );
							login.value = "";
						}
					}
				}
			}

			function validar() { 
				
				if(form1.nome.value == ""){

					alert("Preencha o nome do usuário");
					form1.nome.focus();
					return false;

				}

				if(form1.login.value == ""){
					alert("Preencha o Login do usuário");
					form1.login.focus();
					return false;

				}
				
				if(form1.senha.value == ""){
					alert("digite uma senha");
					form1.senha.focus();
					return false;

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
				<div id="main">	
					<div id="conteiner">		
						<div class="bg_area_login" align="center">
							<h2>Novo Usuário</h2>
			
							<form name="form1" action="gravaUsuario.php" method="post">																
								<table width="70%">
									<tr>
										<td colspan="2"> &nbsp; </td>
									</tr>						
									<tr>
										<td align="right" width="50%">Nome Usuário</td>
										<td align="left"><input type="text" name="nome"  width="50%" class="maiusculo"/></td>
									</tr>
									<tr>
										<td align="right">Login</td>
										<td align="left"><input type="text" id="login" name="login" class="maiusculo" onblur="verificaDisp();"/></td>
									</tr>
									<tr>
										<td align="right">Master</td>
										<td align="left"><input type="checkbox" name="master" value="S"/></td>
									</tr>
									<tr>
										<td align="right">Senha</td>
										<td align="left"><input type="password" name ="senha" /></td>
									</tr>
									<tr>
										<td align="right">Grupo</td>
										<td align="left">
											<select name = "id_grupo">
												<?php foreach ($grupoUsuario->listar("select id_grupo, descricao from grupo") as $grupo){ ?>
													<option value="<?php echo $grupo['id_grupo'] ?>"><?php echo $grupo['descricao'] ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="right">Desativado</td>
										<td align="left"><input type="checkbox" name="status" value="I"/></td>
									</tr>
									<tr>
										<td align="right">Usuário Genérico</td>
										<td align="left"><input type="checkbox" name="generico" value="S"/></td>
									</tr>
									<tr>
										<td colspan="2" align="center">
											<div align="center">
												<input type="submit" value="Gravar" class="botao" onclick="return validar()"/>
												<input type="reset" value="Novo" class="botao"/>
												<input type="button" value="Pesquisar"  onclick="location. href= 'PesquisaUsuario.php?ex=true'"  class="botao"/>
											<div align="center">
										</div>																			
									</tr>
								</table>										
							</form>
						</div>
					</div>
					
					<div id="confirma" title="Atenção">
						<p>						
							<h3><label id="msg" value=""/></h3>
						</p>					
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
