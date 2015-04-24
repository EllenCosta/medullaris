<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
  <head>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="../../jquery/js/SpryMenuBar.js" type="text/javascript"></script>
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery.maskedinput.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery.ui.touch-punch.min.js"></script>

		<link rel="stylesheet" type="text/css" href="../../jquery/css/skin.css" id="css_editor">
		<link href="../../jquery/css/main.css" rel="stylesheet" type="text/css" />
		<link href="../../jquery/css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
		<link href="../../jquery/css/screen.css" rel="stylesheet" type="text/css"/>
		<link type="text/css" href="../../jquery/css/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
		<title>Admed Sistemas</title>
		<style type="text/css">
			.sair {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				font-style: normal;
				text-transform: none;
				color: #ffffff;
				text-decoration: none;
			}
		</style>

  </head>
   <script>

  		pagina = 0;
  		permite = true;
  		var cad = false;
		sair_interval = "";
		ativo_interval = "";
		ativo = "S";
		window.onmouseover = mouseover;
		window.onkeypress = tecla;

		function mouseover(){
				//console.log("Moveu");				
				if(ativo == "N"){
					var url = "../chat_on/chatAtivo.php?ativo=S";
					sendRequest(url, ajaxChatAtivo);
				}
				ativo = "S";
		}

		function tecla(){
			//console.log("Tecla Pressionada");
			ativo = "S";
		}

		function abreChat(){

			$( "#chat" ).dialog( "open" );
		}

		function enviarBroadcast(){
			if($( "#mensagem_broad" ).val() != ''){
				$.post('../chat_on/sys/chat.php',{
					acao: 'inserir',
					mensagem: $( "#mensagem_broad" ).val(),
					para: "0",
					id_grupo: $( "#grupo_broad" ).val(),
				}, function(retorno){
					document.getElementById("msg_b").innerHTML="Mensagem Enviada";
					$( "#confirma_broad" ).dialog( "open" );
				});
			}
		}

		function tecla(){
			if(event.keyCode == "2"){
				bloqueia();
				$("#login").dialog("open");
				document.getElementById("senha").focus();
			}
		}

		function ajaxChatAtivo(){
			
		}

		$(function() {
		
			$( document ).tooltip({
				track: true
			});
			
			$( "#chat" ).dialog({
				modal: false,
				autoOpen: false,
				resizable: true,
				height: 500,
				width: 200,
				buttons: {
					"Broadcast": function() {
						$( "#broadcast" ).dialog( "open" );
					},
					"Fechar": function() {
						$( this ).dialog( "close" );
					},											
				},
				
				close: function(){						
					
				}
			});

			$( "#broadcast" ).dialog({
					modal: false,
					autoOpen: false,
					resizable: true,
					height: 320,
					width: 500,
					buttons: {
						"Enviar": function() {
							$( this ).dialog( "close" );
							enviarBroadcast();
						},
						"Fechar": function() {
							$( this ).dialog( "close" );
						},											
					},
					
					close: function(){						
						
					}
			});

			$( "#confirma_broad" ).dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				show:  {effect: "fade", duration: 200}, 
				hide:  {effect: "fade", duration: 200},
				
				buttons: {
					"Ok": function() {							
						$( this ).dialog( "close" );
					}											
				},
				
				close: function(){
					
				}
			});

			$('input').attr('autocomplete','off');

		});

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
		
		function gravaPaciente(){

			if(document.getElementById("nome_pac").value == ""){
				document.getElementById("msg").innerHTML = "Digite o nome do paciente";
				$( "#confirma" ).dialog( "open" );
				document.getElementById("nome_pac").focus;
			}else{
				if(document.getElementById("cpf_pac").value == ""){
					document.getElementById("msg").innerHTML = "Digite o cpf do paciente";
					$( "#confirma" ).dialog( "open" );
					document.getElementById("cpf_pac").focus;
				}else{
					if(document.getElementById("tel").value == ""){
						document.getElementById("msg").innerHTML = "Digite o celular do paciente";
						$( "#confirma" ).dialog( "open" );
						document.getElementById("tel").focus;
					}else{
						
						$.ajax({
							type: 'POST',
							url: "Paciente/gravaPaciente.php?",
							data:{nome:document.getElementById("nome_pac").value, cpf:document.getElementById("cpf_pac").value, tel:document.getElementById("tel").value},
							success: function(retorno){
								if(retorno == 1){
									//paginacao(pagina);
									document.getElementById("msg").innerHTML = "Paciente cadastrado com sucesso!!!";
									$( "#confirma" ).dialog( "open" );
									document.getElementById("nome_pac").value = "";
									document.getElementById("cpf_pac").value = "";
									document.getElementById("tel").value = "";
									pesquisaPaciente();
								}else{
									document.getElementById("msg").innerHTML = "Paciente já existe!!!";
									$( "#confirma" ).dialog( "open" );
									pesquisaPaciente();

								}
							}
						});	
					}
				}
			}

		}

		function pesquisaPaciente(){
				
				$.ajax({
					type: 'POST',
					url: "Paciente/Pesquisapaciente.php?pg="+pagina+"&ex=1",
					data: {pg:pagina, nome:document.getElementById("nome").value, cpf:document.getElementById("cpf").value},
					success: function(html){
						//document.getElementById("id_selecao").value="";
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

		function abrePaciente(id){
				
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

		function alteraPaciente(id, nome, cpf, tel){
				
				$.ajax({
					type: 'POST',
					url: "Paciente/alteraPaciente.php",
					data: {id:id, nome:nome, cpf:cpf, tel:tel},
					success: function(html){
						if(html == 1){
							document.getElementById("msg").innerHTML = "Paciente alterado com sucesso!";
							$( "#confirma" ).dialog( "open" );
							pesquisaPaciente();
							$( "#ver" ).dialog( "close" );
						}else{
							document.getElementById("msg").innerHTML = "Erro ao alterar.";
							$( "#confirma" ).dialog( "open" );
						}
						
					}
				});
		}

		function enviaSms(){
			var _data= $('#form3').serialize();
			$.ajax({
				type: 'POST',
				url: "sms/enviaSms.php?",
				data:{paciente:document.getElementById("paciente").value, fone:document.getElementById("fone").value, texto:document.getElementById("conteudo_sms").value, dia:document.getElementById("dia").value},
				success: function(html){
					document.getElementById("msg").innerHTML = html;
					$( "#confirma" ).dialog( "open" );
					jQuery(".ui-dialog-buttonset button:contains('Enviar')").removeAttr("disabled").removeClass("ui-state-disabled").addClass('ui-state-default');
					document.getElementById("form3").reset();
					//document.getElementById("ini").value = "";						
				}
			});							
				//$( "#form-sms" ).dialog( "close" );
		}

		function sms(id){
				
				$.ajax({
					type: 'POST',
					url: "sms/paciSMS.php",
					data: {id:id},
					success: function(html){
						document.getElementById("form-sms").innerHTML=html;
						$( "#form-sms" ).dialog( "open" );
						
					}
				});
			
		}	

		function logoff(){
											
			window.location.href = '../../logoff.php';

		}

		function marcaRadioPaciente(id, idPaciente){
			document.getElementById("id_"+id).checked = true;
			carregaPaciente(idPaciente);
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

        function initXHR50(){
            if(window.XMLHttpRequest){
                xhr50 = new XMLHttpRequest();
            }else if (window.ActiveXObject){
                xhr50 = new ActiveXObject("Microsoft.XMLHttp");
            }
        }

        function sendRequest50(url, handler){
            initXHR50();
            xhr50.onreadystatechange = handler;
            xhr50.open("GET", url, true);
            xhr50.send(null);
        }

        function tecla(){
			if(event.keyCode == "2"){
				bloqueia();
				$("#login").dialog("open");
				document.getElementById("senha").focus();
			}
		}

		function playChat(){
		   if(this.currentTime < 12){this.currentTime = 12;}
		   document.getElementById("audio").play();			   
		}
		
		function stopChat(){
			document.getElementById("audio").pause();
			document.getElementById("audio").currentTime = 0;
		}

	

  </script>
   <script>
  		$(function() {
				
			$("#cpf, #cpf_pac").mask("999.999.999-99");
			$("#tel").mask("(99)9999-9999");
			document.getElementById("nome").focus();
			//enter

			$("#form-pesq-paciente").bind('keypress', function(e){
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == '13'){
					pesquisaPaciente();
				}
			});

			$("#form-novo-paciente").bind('keypress', function(e){
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == '13'){
					gravaPaciente();
				}
			});
  				
			$("#ver").bind('keypress', function(e){
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == '13'){
					alteraPaciente(document.getElementById("id1").value, document.getElementById("nome1").value, document.getElementById("cpf1").value, document.getElementById("telefone").value);
				}
			});


			$("#form-sms").bind('keypress', function(e){
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == '13'){
					if(document.getElementById("paciente").value == ""){
						document.getElementById("msg").innerHTML = "Selecione um paciente";
						$( "#confirma" ).dialog( "open" );
					}else{
						if(document.getElementById("fone").value == ""){
							document.getElementById("msg").innerHTML = "digite um telefone";
							$( "#confirma" ).dialog( "open" );
						}else{
									
								enviaSms();
						}
					}
				}
			});

			$("#exclui-paciente").bind('keypress', function(e){
				var code = (e.keyCode ? e.keyCode : e.which);
				if(code == '13'){
					$.ajax({
						type: 'POST',
						url: "Paciente/excluirPaciente.php",
						data: {id:document.getElementById("id_selecao").value},
						success: function(html){
							if(html == 1){
								paginacao(pagina);
								document.getElementById("msg").innerHTML = "Paciente excluido com sucesso!";
								$( "#confirma" ).dialog( "open" );
										//$( "#ver" ).dialog( "close" );
								pesquisaPaciente();
							}else{
								document.getElementById("msg").innerHTML = "Paciente não pode ser excluido!";
								$( "#confirma" ).dialog( "open" );
								pesquisaPaciente();
							}
									
						}
					});
					$("#exclui-paciente").dialog( "close" );
				}
			});


			//forms
			$( "#form-pesq-paciente" ).dialog({
					autoOpen: false,
					height: 400,
					width: 850,
					modal: false,
					resizable: false,
					closeOnEscape: false,
					position: ['center',160],
					show:  {effect: "fade", duration: 200},
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						
						//pesquisa paciente:
						"Pesquisar": function() {
											
												pesquisaPaciente();
										},
						//##############################################
						//novo paciente:
						"Novo": function() {
										$( "#form-novo-paciente" ).dialog( "open" );
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
								
								abrePaciente(document.getElementById("id_selecao").value);
								permite = true;
							}
							
						},
						"Alterar": function() {
							if(document.getElementById("id_selecao").value == ""){
								document.getElementById("msg").innerHTML="Selecione um Paciente";
								$( "#confirma" ).dialog( "open" );
							}else{
								abrePaciente(document.getElementById("id_selecao").value);
								permite = false;

							}
						},

						"Excluir": function() {
							if(document.getElementById("id_selecao").value == ""){
								document.getElementById("msg").innerHTML="Selecione um Paciente";
								$( "#confirma" ).dialog( "open" );
							}else{

								$( "#exclui-paciente" ).dialog( "open" );
								
							}
						},

						"Enviar SMS": function() {
							if(document.getElementById("id_selecao").value == ""){
								document.getElementById("msg").innerHTML="Selecione um Paciente";
								$( "#confirma" ).dialog( "open" );
							}else{
								sms(document.getElementById("id_selecao").value);
							}
						},

						"Fechar": function() {
										$( this ).dialog( "close" );
								},
										
					},
		
			});

			$( "#form-sms" ).dialog({
					autoOpen: false,
					height: 340,
					width: 800,
					modal: false,
					resizable: false,
					position: ['center',160],
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"Enviar": function() {							
							if(document.getElementById("paciente").value == ""){
								document.getElementById("msg").innerHTML = "Selecione um paciente";
								$( "#confirma" ).dialog( "open" );
							}else{
								if(document.getElementById("fone").value == ""){
									document.getElementById("msg").innerHTML = "digite um telefone";
									$( "#confirma" ).dialog( "open" );
								}else{
									
										enviaSms();
								}
							}
						},
						
						"Cancelar": function() {
							$( this ).dialog( "close" );
						}
					},
	  
					open: function() {
						
					},
					
					close: function() {						
						document.getElementById("form3").reset();
						jQuery(".ui-dialog-buttonset button:contains('Enviar')").removeAttr("disabled").removeClass("ui-state-disabled").addClass('ui-state-default');
					}
			});

			$("#form-sms").keyup(function() {
					var total = 156;
					var tamanho = $("#conteudo_sms").val().length;
					var restante = total - tamanho;
					$("#qtd_char_sms").html(restante);
			});

			$( "#form-novo-paciente" ).dialog({
					autoOpen: false,
					height: 200,
					width: 500,
					modal: true,
					resizable: true,

					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
							"gravar":function(){

									gravaPaciente();

									},
							"Fechar":function() {
										$( this ).dialog( "close" );
									}
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


			$( "#ver" ).dialog({
					autoOpen: false,
					height: 250,
					width: 500,
					modal: true,
					resizable: false,
					closeOnEscape: true,
					position: ['center',160],
					show:  {effect: "fade", duration: 200},
					hide:  {effect: "fade", duration: 200},
					
					buttons: {

						
						"Gravar": function() {
							alteraPaciente(document.getElementById("id1").value, document.getElementById("nome1").value, document.getElementById("cpf1").value, document.getElementById("telefone").value);
							
						},

						"Excluir": function() {
							if(document.getElementById("id_selecao").value == ""){
								document.getElementById("msg").innerHTML="Selecione um Paciente";
								$( "#confirma" ).dialog( "open" );
							}else{

								$( "#exclui-paciente" ).dialog( "open" );
								
							}
						},

						"Envia SMS": function() {
							
								if(permite){
									if(document.getElementById("id_selecao").value == ""){
										document.getElementById("msg").innerHTML="Selecione um Paciente";
										$( "#confirma" ).dialog( "open" );
									}else{
										sms(document.getElementById("id_selecao").value);
									}
								}
								else{$(".ui-dialog-buttonpane button:contains('Envia SMS')").button("disable");}
								
						},

						"Fechar": function() {
							document.getElementById("id_selecao").value = ""
							$(".ui-dialog-buttonpane button:contains('Envia SMS')").button("enable");
							$( this ).dialog( "close" );

						},

					},
							
			});

			$( "#exclui-paciente" ).dialog({
					modal: true,
					autoOpen: false,
					resizable: false,
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"Sim": function() {
							$.ajax({
								type: 'POST',
								url: "Paciente/excluirPaciente.php",
								data: {id:document.getElementById("id_selecao").value},
								success: function(html){
									if(html == 1){
										paginacao(pagina);
										document.getElementById("msg").innerHTML = "Paciente excluido com sucesso!";
										$( "#confirma" ).dialog( "open" );
										$( "#ver" ).dialog( "close" );
										pesquisaPaciente();
									}else{
										document.getElementById("msg").innerHTML = "Paciente não pode ser excluido!";
										$( "#confirma" ).dialog( "open" );
										pesquisaPaciente();
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
			

  	}); 
  </script>
		
   <body>
		<div id="conteiner">
			<div id="branco_top">
                <div id="logo">
                    <img src="../../jquery/css/images/logo.jpg" width="400" height="100"/>
                </div>
                <div id="logoff">					
					<label id="desc_empresa">Unidade <?php echo utf8_decode($_SESSION['nome_empresa']) ?></label></br>
					<label>Bem vindo 
					<?php 
						$nomeAbrev = explode(' ',$_SESSION['nome']);		
						if(count($nomeAbrev) > 1){
							$nome = $nomeAbrev[0]. " ". $nomeAbrev[1];
						}else{
							$nome = utf8_decode($_SESSION['nome']);
						}
						echo $nome;
					?> 
					</br> 
					</label><a href="#" onClick="logoff();" class="sair">Sair</a>					
				</div>
			</div>
        </div>
			
		<div align="center">
			<table width="37%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">							
						<ul id="MenuBar1" class="MenuBarHorizontal">
							<li><a class="MenuBarItemSubmenu" href="#" ><strong>Arquivos</strong></a>
								<ul>
									<li><a  href="../user.php">Pacientes</a></li>
									<li><a  href="#">Usuário</a>
										<ul>
											<li><a  href="../usuario/PesquisaUsuario.php">Cadastro de Usuário</a></li>
											<li><a  href="../grupoUsuario/PesquisaGrupo.php">Grupo de Usuário</a></li>
										</ul>
									</li>
									<li><a  href="#">SMS</a>
										<ul>
											<li><a  href="../sms/formRelSms.php">Créditos</a></li>
											<li><a  href="../sms/relMensagens.php">Mensagens Enviadas</a></li>
										</ul>
									</li>
									<li><a  href="../usuario/formAlteraSenha.php">Alterar Senha</a></li>
									<li><a  href="../Parametros/parametros.php">Parâmetros</a></li>
								</ul>
							</li>

							<li><a class="MenuBarItemSubmenu" href="#"><strong>Relatórios</strong></a>
								<ul>
									<li><a  href="../relatorio/relatorio.php">Avaliação da dor</a></li>
								</ul>
							</li>
								
							<li><a class="MenuBarItemSubmenu" href="#"><strong>Ajuda</strong></a>
								<ul>
									<li><a href="#">Sobre</a></li>
									<li><a href="#" target="_blank">Manual</a></li>
									<li><a href="javascript:abreChat();" >Chat</a></li>
								</ul>
							</li>
						</ul>		
					</td>
				</tr>
			</table>
			<div align="center">
				<script type="text/javascript">
					<!--
					var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"", imgRight:""});
					//-->
				</script>
			</div>

			
		</div>
		<div id="form-pesq-paciente" align="center" >
			<input type="hidden" name="id_selecao" id="id_selecao" />
			Nome: <input type="text" size="50" maxlength="50" name="nome" id="nome" class="maiusculo" /> 
			CPF: <input type="text" name="cpf" id="cpf" size="16" maxlength="14"/></br>							
			<h4>&nbsp;</h4>						
			<table width="100%" id="retorno"></table
>		</div>

		<div id="form-novo-paciente" align="center" title="Cadastro de Paciente">
			<form id="form3"> 
				
				<table width="100%" border="0">
					<tr>
						<td align="center"><label>Nome:</label></td>
						<td><input type="text" name="nome_pac" id="nome_pac" size="45" class="maiusculo"/></td></td>
						
					<tr>
						<td align="center" nowrap><label>CPF:</label></td>
						<td><input type="text" size="45" name="cpf_pac" id="cpf_pac" size="15" /></td>													
					</tr>
					<tr>
						<td align="center"><label>Celular:</label> </td>
						<td><input type="text" name="tel" id="tel" size="45" /></td>							
					</tr>
				</table>
			</form>
		</div>	
		
		<div id="ver" title="Cadastro de Pacientes">


		</div>

		<div id="form-sms" class="bg_area_login" align="center">
			
		</div>

		<div id="confirma" title="Atencão">
			<p>						
				<h3><label id="msg" /></h3>
			</p>					
		</div>

		<div id="exclui-paciente" title="Atenção">
			<p>						
				<h3>Deseja Excluir este Paciente?</h3>
			</p>					
		</div>

		<div id="chat" title="Chat">
			<div align="left" id="chat2">				
				<?php include '../chat_on/Contatos.php';?>
			</div>
		</div>

		<div id="confirma_broad" title="Atenção">
			<p>						
				<h3><label id="msg_b"/></h3>
			</p>					
		</div>

		<div id="janelas"></div>

		<audio id="audio">
			<source src="../../jquery/chat.mp3" type="audio/mpeg">
		</audio>

	</body>
</html>

	
	