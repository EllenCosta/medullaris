<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
$_SESSION['inclui'] = "u";
include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
		<link href="../../jquery/css/main.css" rel="stylesheet" type="text/css" />
		<link href="../../jquery/css/screen.css" rel="stylesheet" type="text/css"/>
		<link href="../../jquery/css/rodape.css" rel="stylesheet" type="text/css" />		

		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../../jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
		
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

				
				$('#imprime').attr('disabled', 'disabled');

				$( "#pesq" ).click(function() {

					listaGrupo();		//ao clicar no botão pesquisar
				});

				$(document).on("click", "#alterar", function(){

					verGrupo();
				});

				$(document).on("click", "#excluir", function(){

					$( "#exclui-grupo" ).dialog( "open" );
				
				});

				$( "#novo" ).click(function() {

					$( "#novo-grupo" ).dialog( "open" );		// ao clicar no botão novo
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

				$( "#grupoUsuario" ).dialog({
						autoOpen: true,
						height: 450,
						width: 850,
						modal: false,
						resizable: false,
						closeOnEscape: false,
						position: ['center',160],
						show:  {effect: "fade", duration: 200},
						hide:  {effect: "fade", duration: 200},
						
						buttons: {
							
							"Cancelar": function() {
										limpaTabela("retorno");
										document.getElementById("nome").value = "";
										$('#imprime').attr('disabled', 'disabled');
									}
											
						},

				});

				$( "#grupo" ).dialog({
					modal: true,
					autoOpen: false,
					height: 200,
					width: 400,
					resizable: false,
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"alterar": function() {
							alteraGrupo();
							
						},
						"fechar": function() {
							$( this ).dialog( "close" );
						},
					},
					
					close: function(){
						
					}
				});

				$( "#exclui-grupo" ).dialog({
					modal: true,
					autoOpen: false,
					resizable: false,
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"Sim": function() {
							excluiGrupo();
							$( this ).dialog( "close" );
						},
						"Não": function() {
							$( this ).dialog( "close" );
						},
					},
					
					close: function(){
						
					}
				});

				$( "#novo-grupo" ).dialog({
					autoOpen: false,
					height: 150,
					width: 400,
					modal: true,
					resizable: false,

					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						
						"gravar":function(){
									var erros = 0;
									$("#novo-grupo input").each(function(){
										$(this).val() == "" ? erros++ : "";
									});
									if(erros != 0 ){
										document.getElementById("msg").innerHTML = "Digite a descrição do grupo.";
										$( "#confirma" ).dialog( "open" );
									}else{

										gravaNovoGrupo();
									}	
							},	

						"Limpar":function(){

								document.getElementById("descricao").value = ""; 
								},

						"Fechar":function() {
								$( this ).dialog( "close" );
									
								}
							
					},

				});	


			});
		</script>	
			
		<script>
			page = 0;
			id_selecao = "";

            function confirmacao(){
                if (confirm("Tem Certeza que Deseja Excluir?")){                    
                    return true;
                }else{
                    return false;
                }
            }

            function limpaTabela(tabela){
				var tab = document.getElementById(tabela);
				while(tab.rows.length > 0){
					tab.deleteRow(0);
				}
			}

			function paginacao(p){
				page = p;
				listaGrupo();
			}

			function carregaGrupo(idGrupo){

				document.getElementById("id").value = idGrupo;

			}

			function pesquisaGrupo(idGrupo){

				document.getElementById("id").value = idGrupo;
				verGrupo();

			}
			function listaGrupo(){
			    	$.ajax({
							type: 'POST',
							url: "listaGrupo.php?pg="+page,
							data:{nome:document.getElementById("nome").value},
							success: function(html){
								document.getElementById("retorno").innerHTML = html;
								
								$('#imprime').removeAttr('disabled');
						
							}
					});
		    }   

		    function verGrupo(){
		    	$.ajax({
					type: 'POST',
					url: "formAlteraGrupo.php?pg="+page,
					data:{id:document.getElementById("id").value},
					success: function(html){
						document.getElementById("grupo").innerHTML = html;
						$( "#grupo" ).dialog( "open" );
					}
				});		
		    }

		    function alteraGrupo(){
				$.ajax({
					type: 'POST',
					url: "alteraGrupo.php",
					data:{id_grupo:document.getElementById("id").value, descricao:document.getElementById("descricao").value},
					success: function(html){
						if(html == 1){
							document.getElementById("msg").innerHTML = "Grupo alterado com sucesso!";
							$( "#confirma" ).dialog( "open" );
							listaGrupo();
							$( "#grupo" ).dialog( "close" );
						}else{
							document.getElementById("confirma").innerHTML = "Erro ao alterar";
							$( "#confirma" ).dialog( "open" );
						}
						
					}
				});	
    		} 
		
			function excluiGrupo(){
				$.ajax({
					type: 'POST',
					url: "excluiGrupo.php",
					data: {id:document.getElementById("id").value},
					success: function(html){
						if(html == 1){
							paginacao(page);
							document.getElementById("msg").innerHTML = "Grupo excluido com sucesso!";
							$( "#confirma" ).dialog( "open" );
							$( "#exclui-grupo" ).dialog( "close" );
							carregaUsuario("");
							listaUsuario();	
						}else{
							document.getElementById("msg").innerHTML = "Não foi possivel excluir o grupo. Verifique se existe usuarios associados ao grupo.";
							$( "#confirma" ).dialog( "open" );
							listaUsuario();
						}
						
					}
				});
			}

			function gravaNovoGrupo(){
				$.ajax({
					type: 'POST',
					url: "gravaGrupo.php",
					data:{descricao:document.getElementById("descricao").value},
					success: function(html){
						if(html == 1){
							document.getElementById("msg").innerHTML = "Grupo cadastrado com sucesso!";
							$( "#confirma" ).dialog( "open" );
							document.getElementById("descricao").value = ""; 
							listaGrupo();
						}else{
							document.getElementById("msg").innerHTML = "Erro ao cadastrar.";
							$( "#confirma" ).dialog( "open" );
							document.getElementById("descricao").value = ""; 
						}
						

					}
				});	
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
						
						<form id="grupoUsuario" title="Grupo Usuário" align="center">		
							<input type="hidden" name="id" id="id" />					
							Nome <input type="text" size="60" maxlength="40" id="nome" name="nome" class="maiusculo" />
							<input type ="button" value="Pesquisar" name="pesq" id="pesq"class="botao" /> 
							<input type ="button" value="Novo" class="botao" name="novo" id="novo"/> 							
							<input type ="button" value="Imprimir" id="imprime" onclick="window.open('imprimePdf.php','Impressão');" class="botao" />
							<h4>&nbsp;</h4>

							<table id="retorno" width="100%">

								
							</table>
		
						</form>

						<div id="grupo" title="Editar Grupo">
														
						</div>

						<div id="novo-grupo" title="Novo Grupo">
							<table width="100%">
								<tr>
									<td colspan="2"> &nbsp; </td>
								</tr>						
								<tr>
									<td align="right" ><h5>Descrição:</h5></td>
									<td align="left" width="90%"><input type="text" name="descricao" id="descricao" class="maiusculo" width="100%"/></td>
								</tr>
								<tr>
									<td colspan="2"> &nbsp; </td>
								</tr>

	
							</table>		
						</div>

						<div id="exclui-grupo" title="Atenção">
							<p>						
								<h3>Deseja Excluir este grupo?</h3>
							</p>					
						</div>

					</div>					
				</div>	
			</div>	
			<div class="clear"></div>	
		</div>
		<div id="bg_rodape">
			<?php include("../rodape.php"); ?>
		</div>	
	</div>
</body>

</html>
