<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
$_SESSION['inclui'] = "n";
include_once '../../control/controlUsuario.php';
include_once '../../control/controlGrupoUsuario.php';

header("Content-Type: text/html;  charset=ISO-8859-1",true);

$imprime = 0;
$grupoUsuario= new ControlGrupoUsuario() ;
$usuario = new ControlUsuario();
$sql = null;
$imp = true;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">	
		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery.maskedinput.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery.ui.touch-punch.min.js"></script>
		
		<link href="../../jquery/css/main.css" rel="stylesheet" type="text/css" />
		<link href="../../jquery/css/screen.css" rel="stylesheet" type="text/css"/>
		<link href="../../jquery/css/rodape.css" rel="stylesheet" type="text/css" />			
		<link type="text/css" href="../../jquery/css/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
	
		
		
<script>
	$(function() {
		$("#hora_ini, #hora_fim, #hora_ini_alt, #hora_fim_alt").mask("99:99");
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

			// Pdfdfara tratar quando é digitado
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

				listaUsuario();		//ao clicar no botão pesquisar
		});


		$( "#novo" ).click(function() {

			$( "#novo-usuario" ).dialog( "open" );		// ao clicar no botão novo
		});

		$(document).on("click", "#excluir", function(){

		
			$( "#exclui-usuario" ).dialog( "open" );
				
		});

		$(document).on("click", "#alterar", function(){

			verUsuario();	
		});

		$(document).on("click", "#pesq-horarios", function(){

			$( "#form-horarios" ).dialog( "open" );	
		});



		$("#usuario").bind('keypress', function(e){
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == '13'){
				listaUsuario();
			}
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

		$( "#usuario" ).dialog({
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
							limpaTabela("tabela");
							document.getElementById("nome").value = "";
							document.getElementById("id_grupo").value = "";
							document.getElementById("status").value = "";
							$('#imprime').attr('disabled', 'disabled');
						}
								
			},

		});	

		$( "#novo-usuario" ).dialog({
			autoOpen: false,
			height: 300,
			width: 500,
			modal: true,
			resizable: true,

			show:  {effect: "fade", duration: 200}, 
			hide:  {effect: "fade", duration: 200},

			
			buttons: {
				
				"gravar":function(){
							var erros = 0;
							$("#novo-usuario input").each(function(){
								$(this).val() == "" ? erros++ : "";
							});
							if(erros != 0 ){
								document.getElementById("msg").innerHTML = "Preencha todos os campos.";
								$( "#confirma" ).dialog( "open" );
							}else{

								gravaNovo();
							}	
					},	

				"Limpar":function(){

						document.getElementById("nomeU").value = ""; 
						document.getElementById("login").value = "";
						document.getElementById("master").checked= ""; 
						document.getElementById("senha").value = "";
						document.getElementById("id_grupo").value = "";
						document.getElementById("statusU").checked= "";
						document.getElementById("generico").checked= "";
						

						},

				"Fechar":function() {
						$( this ).dialog( "close" );
							
						}
					
			},

		});	

		$( "#exclui-usuario" ).dialog({
					modal: true,
					autoOpen: false,
					resizable: false,
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"Sim": function() {
							$.ajax({
								type: 'POST',
								url: "excluiUsuario.php",
								data: {id:document.getElementById("id").value},
								success: function(html){
									if(html == 1){
										paginacao(page);
										document.getElementById("msg").innerHTML = "Usuário excluido com sucesso!";
										$( "#confirma" ).dialog( "open" );
										$( "#ver" ).dialog( "close" );
										carregaUsuario("");
										listaUsuario();	
									}else{
										document.getElementById("msg").innerHTML = "Usuário não pode ser excluido!";
										$( "#confirma" ).dialog( "open" );
										listaUsuario();	
									}
									
								}
							});

							$( this ).dialog( "close" );
						},
						"Não": function() {
							$( this ).dialog( "close" );
						},
					},
					
					close: function(){
						
					}
		});

		$( "#abre-usuario" ).dialog({
			modal: true,
			autoOpen: false,
			height: 400,
			width: 500,
			resizable: false,
			show:  {effect: "fade", duration: 200}, 
			hide:  {effect: "fade", duration: 200},
			
			buttons: {
				"alterar": function() {
					alteraUsuario();
					
				},
				"fechar": function() {
					$( this ).dialog( "close" );
				},
			},
			
			close: function(){
				
			}
		});

		$( "#form-horarios" ).dialog({
			height: 340,
			width: 600,
			modal: true,
			autoOpen: false,
			resizable: false,
			show:  {effect: "fade", duration: 200}, 
			hide:  {effect: "fade", duration: 200},
			
			buttons: {	

				"Pesquisar": function(){
					id_selecao = "";
					pesquisaHorario();							
				},
				
								
				"Novo": function() {
					$( "#form-novo_horario" ).dialog( "open" );
				},
				
				"Alterar":function() {
					if(id_selecao == ""){
						document.getElementById("msg").innerHTML="Selecione um Horário";
						$( "#confirma" ).dialog( "open" );
					}else{
						buscaHorario(id_selecao);								
					}
				},
				
				"Excluir": function(){
					if(id_selecao == ""){
						document.getElementById("msg").innerHTML="Selecione um Horário";
						$( "#confirma" ).dialog( "open" );
					}else{
					excluiHorario(id_selecao);
					}
				}
				
			},
			
			close: function(){
				
			}
		});

		$( "#form-novo_horario" ).dialog({
			height: 240,
			width: 500,
			modal: true,
			autoOpen: false,
			resizable: false,
			show:  {effect: "fade", duration: 200}, 
			hide:  {effect: "fade", duration: 200},
			
			buttons: {						
				"Gravar": function() {
					gravaHorario();
					$( this ).dialog( "close" );
				},
				
				"Cancelar":function() {
					$( this ).dialog( "close" );
				},											
			},
			
			close: function(){
			 	document.getElementById("hora_ini").value="";
				document.getElementById("hora_fim").value="";
			}
		});

		$( "#form-altera_horario" ).dialog({
			height: 240,
			width: 500,
			modal: true,
			autoOpen: false,
			resizable: false,
			show:  {effect: "fade", duration: 200}, 
			hide:  {effect: "fade", duration: 200},
			
			buttons: {						
				"Alterar": function() {
					alteraHorario();
					$( this ).dialog( "close" );
				},
				
				"Cancelar":function() {
					$( this ).dialog( "close" );
				},											
			},
			
			close: function(){
				document.getElementById("hora_ini_alt").value="";
				document.getElementById("hora_fim_alt").value="";
			}
		});

	});				
</script>
<script>
	page = 0;
	id_selecao = "";

	function verificaDisp(){
		var login = document.getElementById("login").value;
		var id_usuario = document.getElementById("id_usuario").value;
		if(login.toUpperCase() == "ADMIN"){
			document.getElementById("msg").innerHTML = "O Login ADMIN não pode ser usado";
			$( "#confirma" ).dialog( "open" );
			document.getElementById("login").value = "";
		}else{
			if(login != ""){
				var url = "verificaDisp.php?login="+login+"&acao=A"+"&id_usuario="+id_usuario;
				sendRequest(url, ajaxVerificaDisp);
			}
		}				
	}
			
	function ajaxVerificaDisp(){
		if(xhr.readyState === 4) {
            if(xhr.status === 200){
                var retorno = xhr.responseText;
				if(retorno == "1"){
					var login = document.getElementById("loginU");
					document.getElementById("msg").innerHTML = "O Login "+login.value+" Já Está Sendo Usado";
					$( "#confirma" ).dialog( "open" );
					login.value = "";
				}
			}
		}
	}

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
		var login = document.getElementById("loginU").value;
		var id_usuario = document.getElementById("id").value;
		if(login.toUpperCase() == "ADMIN"){
			document.getElementById("msg").innerHTML = "O Login ADMIN não pode ser usado";
			$( "#confirma" ).dialog( "open" );
			document.getElementById("loginU").value = "";
		}else{
			if(login != ""){
				var url = "verificaDisp.php?login="+login+"&acao=A"+"&id_usuario="+id_usuario;
				sendRequest(url, ajaxVerificaDisp);
			}
		}				
	}

  

    function paginacao(p){
		page = p;
		listaUsuario();
	}

    function listaUsuario(){
    	
    	$.ajax({
				type: 'POST',
				url: "listaUsuario.php?pg="+page,
				data:{nome:document.getElementById("nome").value, id_grupo:document.getElementById("id_grupo").value, status:document.getElementById("status").value},
				success: function(html){
					document.getElementById("tabela").innerHTML = html;
					
					$('#imprime').removeAttr('disabled');
			
				}
		});
    }   

    function verUsuario(){
    	$.ajax({
				type: 'POST',
				url: "formAlteraUsuario.php?pg="+page,
				data:{id:document.getElementById("id").value},
				success: function(html){
					document.getElementById("abre-usuario").innerHTML = html;
					$( "#abre-usuario" ).dialog( "open" );
				}
		});		
    }   

    function alteraUsuario(){

    	var master;
    	var status;
    	var generico;
    	var senha;
    	if ($("#master-alt").is(':checked')){master = "S";}
    	else{master = "N";}

    	if($("#status-alt").is(':checked') == true){ status = "I";}
    	else{ status = "A"; }


    	if($("#generico-alt").is(':checked') == true){ generico = "S";}
    	else{ generico = "N";}

    	if(document.getElementById("senha-alt").value == ""){
    		senha = "0";
    	}
    	else{
    		senha = document.getElementById("senha-alt").value;
    	} 
    	$.ajax({
				type: 'POST',
				url: "AlteraUsuario.php",
				data:{id_usuario:document.getElementById("id").value, login:document.getElementById("login-alt").value, senha:senha, nome:document.getElementById("nome-alt").value, status:status, id_grupo:document.getElementById("id_grupo_alt").value, master:master, generio:generico},
				success: function(html){
					if(html == 1){
						document.getElementById("msg").innerHTML ="Usuário alterado com sucesso!";
						$( "#confirma" ).dialog( "open" );
						listaUsuario();
						$( "#abre-usuario" ).dialog( "close" );
					}else{
						document.getElementById("confirma").innerHTML ="Erro ao alterar";
						$( "#confirma" ).dialog( "open" );
					}
					
				}
		});
    } 

    function gravaNovo(){
    	var master;
    	var status;
    	var generico;
    	if ($("#masterU").is(':checked')){master = "S";}
    	else{master = "N";}

    	if($("#statusU").is(':checked')){ status = "I";}
    	else{ status = "A" }

    	if($("#genericoU").is(':checked')){ generico = "S";}
    	else{ generico = "N"}

    	
    	$.ajax({
				type: 'POST',
				url: "gravaUsuario.php",
				data:{nome:document.getElementById("nomeU").value, login:document.getElementById("loginU").value, master:master, senha:document.getElementById("senhaU").value, id_grupo:document.getElementById("id_grupoU").value, status:status, generico:generico},
				success: function(html){
					if(html == 1){
						document.getElementById("msg").innerHTML = "Usuário cadastrado com sucesso!";
						$( "#confirma" ).dialog( "open" );
						//jQuery(".ui-dialog-buttonset button:contains('Enviar')").removeAttr("disabled").removeClass("ui-state-disabled").addClass('ui-state-default');
						document.getElementById("nomeU").value = ""; 
						document.getElementById("loginU").value = "";
						document.getElementById("masterU").checked= false; 
						document.getElementById("senhaU").value = "";
						document.getElementById("id_grupoU").value = "";
						document.getElementById("statusU").checked= false;
						document.getElementById("genericoU").checked= false;
						listaUsuario();
					}else{
						document.getElementById("msg").innerHTML = "Erro ao cadastrar.";
						$( "#confirma" ).dialog( "open" );
						document.getElementById("nomeU").value = ""; 
						document.getElementById("loginU").value = "";
						document.getElementById("masterU").checked= false;
						document.getElementById("senhaU").value = "";
						document.getElementById("id_grupoU").value = "";
						document.getElementById("statusU").checked= false;
						document.getElementById("genericoU").checked= false;
					}
					

				}
		});	
    }

    function limpaTabela(tabela){
		var tab = document.getElementById(tabela);
		while(tab.rows.length > 0){
			tab.deleteRow(0);
		}
	}

	function carregaUsuario(idUsuario){

		document.getElementById("id").value = idUsuario;

	}

	function pesquisaUsuario(idUsuario){

		document.getElementById("id").value = idUsuario;
		verUsuario();

	}

	function bloqueiaSenha(){
		if(document.getElementById("altera").checked){
			document.getElementById("senha-alt").disabled = false;
		}else{
			document.getElementById("senha-alt").disabled = true;
		}
	}

	function pesquisaHorario(){
		var dia_semana = document.getElementById("dia_semana").value;
		var id_usuario = document.getElementById("id").value;
		var url = "pesquisaDiaSemana.php?dia_semana="+dia_semana+"&id_usuario="+id_usuario;
		sendRequest(url, ajaxPesquisaHorario);
	}

	function ajaxPesquisaHorario(){
		if(xhr.readyState === 4) {
            if(xhr.status === 200){
                var retorno = xhr.responseText;
				document.getElementById("tab_hora").innerHTML=retorno;
			}
		}
	}

	function gravaHorario(){
		var dia_semana = document.getElementById("novo_dia_semana").value;
		var id_usuario = document.getElementById("id").value;
		var hora_ini = document.getElementById("hora_ini").value;
		var hora_fim = document.getElementById("hora_fim").value;
		var url = "gravaHorario.php?dia_semana="+dia_semana+"&id_usuario="+id_usuario+"&hora_ini="+hora_ini+"&hora_fim="+hora_fim;
		sendRequest(url, ajaxGravaHorario);
	}

	function ajaxGravaHorario(){
		if(xhr.readyState === 4) {
            if(xhr.status === 200){
                var retorno = xhr.responseText;
				document.getElementById("msg").innerHTML=retorno;
				$( "#confirma" ).dialog( "open" );
				pesquisaHorario();
			}
		}
	}

	function alteraHorario(){
		var dia_semana = document.getElementById("altera_dia_semana").value;
		var id_usuario = document.getElementById("id").value;
		var hora_ini = document.getElementById("hora_ini_alt").value;
		var hora_fim = document.getElementById("hora_fim_alt").value;
		var url = "alteraHorario.php?dia_semana="+dia_semana+"&id_usuario="+id_usuario+"&hora_ini="+hora_ini+"&hora_fim="+hora_fim+"&id="+id_selecao;
		sendRequest(url, ajaxAlteraHorario);
	}

	function ajaxAlteraHorario(){
		if(xhr.readyState === 4) {
            if(xhr.status === 200){
                var retorno = xhr.responseText;
				document.getElementById("msg").innerHTML=retorno;
				$( "#confirma" ).dialog( "open" );
				pesquisaHorario();
			}
		}
	}

	function excluiHorario(){
		var url = "excluiHorario.php?id="+id_selecao;
		sendRequest(url, ajaxExcluiHorario);
	}

	function ajaxExcluiHorario(){
		if(xhr.readyState === 4) {
            if(xhr.status === 200){
                var retorno = xhr.responseText;
				document.getElementById("msg").innerHTML=retorno;
				$( "#confirma" ).dialog( "open" );
				pesquisaHorario();
			}
		}
	}

	function marcaRadioHorario(id, id_horario){
		document.getElementById("sel"+id).checked = true;
		carregaHorario(id_horario);
	}

	function carregaHorario(id_horario){

		id_selecao = id_horario;
	}

	function buscaHorario(id){
		var url="buscaHorario.php?id="+id;
		sendRequest(url, ajaxBuscaHorario);
	}

	function ajaxBuscaHorario(){
		if (xhr.readyState==4 || xhr.readyState=="complete"){
			xmlDoc=xhr.responseXML;
			try{
				document.getElementById("hora_ini_alt").value = xmlDoc.getElementsByTagName("hora_ini")[0].childNodes[0].nodeValue;
			}catch(e){}
			try{
				document.getElementById("hora_fim_alt").value = xmlDoc.getElementsByTagName("hora_fim")[0].childNodes[0].nodeValue;
			}catch(e){}
			try{
				var dia_semana = xmlDoc.getElementsByTagName("dia_semana")[0].childNodes[0].nodeValue;
				var comboe = document.getElementById("altera_dia_semana");
				comboe.options[0].selected = "true";
				for (var i = 0; i < comboe.options.length; i++){
					if (comboe.options[i].value == dia_semana){
						comboe.options[i].selected = "true";
						break;
					}
				}
			}catch(e){}
			$( "#form-altera_horario" ).dialog( "open" );
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
						
						<form id="usuario" title = "Usuários">			
							<input type="hidden" name="id" id="id" />				
							Nome: <input type="text" size="40" maxlength="40" id="nome" name="nome" class="maiusculo"/> 
							
							Grupo: 	<select id="id_grupo" name= "id_grupo">
										<option value=""></option>
										<?php foreach ($grupoUsuario->listar() as $grupo){?>
											<option value="<?php echo $grupo['id_grupo'] ?>"><?php echo $grupo['descricao'] ?></option>
										<?php } ?>
									</select>
							Status: 	<select id="status" name = "status">								
										<option value=""></option>
										<option value="A">ATIVO</option>								
										<option value="I">INATIVO</option>								
									</select>
							<input type ="button" value="Pesquisar" id="pesq" name="pesq" class="botao" /> 
							<input type ="button" value="Novo" id="novo" class="botao"/>
							<input type ="button" value="Imprimir" id="imprime" onclick="window.open('imprimePdf.php','Impressão');" class="botao" />
							<br>
							<h4>&nbsp;</h4>
							<table id="tabela" width="100%">
							<input type="hidden" name="id_usuario" id="id_usuario" />
							</table>
							
						</form>
							
			
						<div id="novo-usuario" align="center" title="Cadastro de Usuário" >																
							<table width="80%">
								<tr>
									<td colspan="2"> &nbsp; </td>
								</tr>						
								<tr>
									<td align="right" width="50%">Nome Usuário</td>
									<td align="left"><input type="text" id="nomeU" name="nomeU"  width="50%" class="maiusculo"/></td>
								</tr>
								<tr>
									<td align="right">Login</td>
									<td align="left"><input type="text" id="loginU" name="loginU" class="maiusculo" onblur="verificaDisp();"/></td>
								</tr>
								<tr>
									<td align="right">Master</td>
									<td align="left"><input type="checkbox" id="masterU" name="masterU" /></td>
								</tr>
								<tr>
									<td align="right">Senha</td>
									<td align="left"><input type="password" id="senhaU" name ="senhaU" /></td>
								</tr>
								<tr>
									<td align="right">Grupo</td>
									<td align="left">
										<select id= "id_grupoU" name = "id_grupoU">
											<?php foreach ($grupoUsuario->listar("select id_grupo, descricao from grupo") as $grupo){ ?>
												<option value="<?php echo $grupo['id_grupo'] ?>"><?php echo $grupo['descricao'] ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td align="right">Desativado</td>
									<td align="left"><input type="checkbox" id="statusU" name="statusU" /></td>
								</tr>
								<tr>
									<td align="right">Usuário Genérico</td>
									<td align="left"><input type="checkbox" id="genericoU" name="genericoU" /></td>
								</tr>
								
							</table>										
						</div>

						<div id="confirma" title="Atencão">
							<p>						
								<h3><label id="msg" /></h3>
							</p>					
						</div>

						<div id="exclui-usuario" title="Atenção">
							<p>						
								<h3>Deseja Excluir este usuário?</h3>
							</p>					
						</div>

						<div id="abre-usuario" title="Alterar Usuário">
							
								
						</div>

						<div id="form-horarios" align="center">
							<h2>Horários de Login</h2>
							Dia da Semana: 	<select id="dia_semana" name="dia_semana">
												<option value="">Todos</option>
												<option value="1">Domingo</option>
												<option value="2">Segunda</option>
												<option value="3">Terça</option>
												<option value="4">Quarta</option>
												<option value="5">Quinta</option>
												<option value="6">Sexta</option>
												<option value="7">Sabado</option>
											</select>
											<br>
											<br />
							<table id="tab_hora" width="100%">
							
							</table>
						</div>
							
						<div align="center" id="form-novo_horario">
							<h2>Novo Horário de Login</h2>
							<table width="100%">
								<tr>
									<td align="right">Dia da Semana</td>
									<td align="left">
										<select id="novo_dia_semana" name="novo_dia_semana">
											<option value="1">Domingo</option>
											<option value="2">Segunda</option>
											<option value="3">Terça</option>
											<option value="4">Quarta</option>
											<option value="5">Quinta</option>
											<option value="6">Sexta</option>
											<option value="7">Sabado</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="right">Hora Inicial</td>
									<td align="left"><input type="text" name="hora_ini" id="hora_ini" title="Multiplos de Cinco"/></td>
								</tr>							
								<tr>
									<td align="right">Hora Final</td>
									<td align="left"><input type="text" name="hora_fim" id="hora_fim" title="Multiplos de Cinco"/></td>
								</tr>
							</table>
						</div>
						
						<div align="center" id="form-altera_horario">
							<h2>Edição de Horário de Login</h2>
							<table width="100%">
								<tr>
									<td align="right">Dia da Semana</td>
									<td align="left">
										<select id="altera_dia_semana" name="altera_dia_semana">
											<option value="1">Domingo</option>
											<option value="2">Segunda</option>
											<option value="3">Terça</option>
											<option value="4">Quarta</option>
											<option value="5">Quinta</option>
											<option value="6">Sexta</option>
											<option value="7">Sabado</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="right">Hora Inicial</td>
									<td align="left"><input type="text" name="hora_ini_alt" id="hora_ini_alt" title="Multiplos de Cinco"/></td>
								</tr>							
								<tr>
									<td align="right">Hora Final</td>
									<td align="left"><input type="text" name="hora_fim_alt" id="hora_fim_alt" title="Multiplos de Cinco"/></td>
								</tr>
							</table>
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
