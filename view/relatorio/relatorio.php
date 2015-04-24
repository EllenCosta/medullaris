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
		<link href="../../jquery/css/screen.css" rel="stylesheet" type="text/css"/>

		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../../jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
  </head>
<script>

  		pagina = 0;
  		pg = 0;
  		permite = true;
  		function paginacao(p){
				pagina = p;
				pesquisaDados();
		}

		function pag(p){
				pg = p;
				verPaciente(document.getElementById("id_selecao").value);
				//console.log(document.getElementById("id_selecao").value);
		}

		function pesquisa(){
				$.ajax({
					type: 'POST',
					url: "Paciente/Pesquisapaciente.php?ex=true&pg="+pagina,
					//data: {nome:document.getElementById("nome_banco").value, parte:parte_p},
					success: function(html){
						document.getElementById("id_selecao").value="";
						document.getElementById("retorno").innerHTML=html;						
					}
				});
		}

		function pesquisaDados(){
				
				$.ajax({
					type: 'POST',
					url: "abreDados.php?pg="+pagina+"&ex=1",
					data: {pg:pagina, nome:document.getElementById("nome").value, cpf:document.getElementById("cpf").value},
					success: function(html){
						document.getElementById("retorno").innerHTML=html;
					}
				});	
		}

		function limpaTabela(tabela){
				var tab = document.getElementById(tabela);
				while(tab.rows.length > 0){
					tab.deleteRow(0);
				}
		}

		function abreDados(id){
				
				$.ajax({
					type: 'POST',
					url: "Paciente/abrePaciente.php",
					data: {id:id},
					success: function(html){
						document.getElementById("ver").innerHTML=html;
						$( "#ver" ).dialog( "open" );
						
					}
				});
			
		}				
			
		function carregaPaciente(idPaciente){

			document.getElementById("id_selecao").value = idPaciente;

		}

		function verPaciente(id){
			
			$.ajax({
				type: 'POST',
				url: "verPaciente.php?pg="+pg,
				data: {id:id},
				success: function(html){
					document.getElementById("div").innerHTML=html;
					$( "#div" ).dialog( "open" );
					
				}
			});
			
		}			


		function marcaRadioPaciente(id, idPaciente){
			document.getElementById("id_"+id).checked = true;
			carregaPaciente(idPaciente);
		}	



	

  </script>
  <script>

  		$(function() {
				
			document.getElementById("nome").focus();
			

			$( "#data" ).datepicker({
					dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
					yearRange: "-100:+0",
					dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
					dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
					monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
					nextText: 'Próximo',
					prevText: 'Anterior'
			});

			//captura enter
			$("#dados").bind('keypress', function(e){
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == '13'){
					pesquisaDados();
				}
			});

			//forms
			$( "#dados" ).dialog({
					autoOpen: true,
					height: 400,
					width: 850,
					modal: false,
					resizable: false,
					closeOnEscape: false,
					position: ['center',160],
					show:  {effect: "fade", duration: 200},
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						
					
						"Pesquisar": function() {
											
											 pesquisaDados();
										},

						"Cancelar": function() {
							limpaTabela("retorno");
							document.getElementById("nome").value = "";
							document.getElementById("cpf").value = "";
						},

						"Vizualizar": function() {
							if(document.getElementById("id_selecao").value == ""){
								document.getElementById("msg").innerHTML="Selecione um Paciente";
								$( "#confirma" ).dialog( "open" );
							}else{
								
								verPaciente(document.getElementById("id_selecao").value);
								permite = true;
							}
							
						},

						"Fechar": function() {
										$( this ).dialog( "close" );
								},
										
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

			$( "#div" ).dialog({
					autoOpen: false,
					height: 330,
					width: 600,
					modal: false,
					resizable: false,
					closeOnEscape: true,
					position: ['center',160],
					show:  {effect: "fade", duration: 200},
					hide:  {effect: "fade", duration: 200},
					
					buttons: {

						
						"Fechar": function() {
							
							$( this ).dialog( "close" );

						},

					},
							
			});


  	}); 
  </script>

   <body>   
		<div id="tudo">
			<div id="conteudo">
			
				<div id="topo">
					<?php include("../menu/menu.php"); ?>					
				</div>		

				<div id="dados" align="center" title="Dados Pacientes">
					<input type="hidden" name="id_selecao" id="id_selecao" />
					Nome: <input type="text" size="50" maxlength="50" name="nome" id="nome" class="maiusculo" /> 
					CPF: <input type="text" name="cpf" id="cpf" size="16" maxlength="14"/>						
					<h4>&nbsp;</h4>						
					<table width="100%" id="retorno"></table>
				</div>
					
				<div id="div">
					<table id="ver-paciente" width="100%"></table>	
				</div
					
					
			
				<div class="clear"></div>
				
			</div>
			
			<div id="bg_rodape">
				<?php include("../rodape.php"); ?>				
			</div>
		</div>			
   </body>

</html>
