<?php header("Content-Type: text/html;  charset=ISO-8859-1", true);

 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
  <head>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script type="text/javascript" src="../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="../jquery/js/SpryMenuBar.js" type="text/javascript"></script>
		<script type="text/javascript" src="../jquery/js/jquery.form.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery.maskedinput.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery.ui.touch-punch.min.js"></script>

		<link rel="stylesheet" type="text/css" href="../jquery/css/skin.css" id="css_editor">
		<link href="../jquery/css/main.css" rel="stylesheet" type="text/css" />
		<link href="../jquery/css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
		<link href="../jquery/css/screen.css" rel="stylesheet" type="text/css"/>
		<link type="text/css" href="../jquery/css/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
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
  		x = "";
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
					var url = "chat_on/chatAtivo.php?ativo=S";
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
				$.post('chat_on/sys/chat.php',{
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

  		function paginacao(p){
				pagina = p;
				pesquisaPaciente();
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
		
		function gravaPaciente(){	

			var erros = validaNovo();

			
			if(erros){
					var res = validaCPF(document.getElementById("cpf_pac").value);
				if(res){
					var res = validaTel(document.getElementById("tel").value);
					if(res){
						$.ajax({
							type: 'POST',
							url: "Paciente/gravaPaciente.php?",
							data:{nome:document.getElementById("nome_pac").value, cpf:document.getElementById("cpf_pac").value, tel:document.getElementById("tel").value},
							success: function(retorno){
								if(retorno == 0){
									$.ajax({
										type: 'POST',
										url: "Paciente/busca.php?",
										data:{cpf:document.getElementById("cpf_pac").value},
										success: function(num){
												document.getElementById("msg").innerHTML = "Este cpf já esta cadastrado.";
												$( "#confirma" ).dialog( "open" );
												setTimeout(function(){ 
													abrePaciente(num);
													document.getElementById("cpf_pac").value ="";
												}, 2000);


												
												
										}
									});	
								}else{
									//paginacao(pagina);
									//document.getElementById("msg").innerHTML = "Paciente cadastrado com sucesso!!!";
									$( "#enviar" ).dialog( "open" );
									pesquisaPaciente();
									carregaPaciente(retorno);

								}
							}
						});		
					}else{
						document.getElementById("tel").value = "";
						document.getElementById("tel").focus();	
						document.getElementById("msg").innerHTML = "Digite um telefone válido.";
						$( "#confirma" ).dialog( "open" );
					}

				}else{
					document.getElementById("cpf_pac").value = "";
					document.getElementById("cpf_pac").focus();
					document.getElementById("msg").innerHTML = "Digite um CPF válido.";
					$( "#confirma" ).dialog( "open" );
					
					
				}

			}

		}

		function pesquisaPaciente(){	
			$.ajax({
				type: 'POST',
				url: "Paciente/Pesquisapaciente.php?pg="+pagina+"&ex=1",
				data: {pg:pagina, nome:document.getElementById("nome").value, cpf:document.getElementById("cpf").value, status:document.getElementById("status").value},
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

			var x =validaFormVer();
			var status;

			if(x){
				if($("#status-paci").is(':checked') == true){ status = "I";}
	    		else{ status = "A"; }

	    		var res = validaCPF(document.getElementById("cpf1").value);
	    		if(res){//se o cpf for valido
	    			var res = validaTel(document.getElementById("telefone").value);
	    			if(res){//se o telefone for valido
	    				$.ajax({
							type: 'POST',
							url: "Paciente/alteraPaciente.php",
							data: {id:id, nome:nome, cpf:cpf, tel:tel, status:status},
							success: function(html){
								if(html == 0){
									document.getElementById("msg").innerHTML = "Paciente alterado com sucesso!";
									$( "#confirma" ).dialog( "open" );
									pesquisaPaciente();
									document.getElementById("id_selecao").value = "";
									$( "#ver" ).dialog( "close" );
								}else{
									document.getElementById("msg").innerHTML = "Este CPF esta cadastrado com o nome: '"+html+"'";
									$( "#confirma" ).dialog( "open" );

									document.getElementById("cpf1").value ="";	
								}
								
							}
						});

	    			}
	    			else{
	    				document.getElementById("msg").innerHTML = "Digite um telefone válido.";
						$( "#confirma" ).dialog( "open" );
						document.getElementById("telefone").style.borderColor='blue';
						document.getElementById("telefone").value ="";
						document.getElementById("telefone").focus;
	    			}

	    		}
	    		else{
	    			document.getElementById("msg").innerHTML = "Digite um CPF válido.";
					$( "#confirma" ).dialog( "open" );
					document.getElementById("cpf1").style.borderColor='blue';
					document.getElementById("cpf1").value = "";
					document.getElementById("cpf1").focus;
	    		}
			}

	    	
	    
				
		}

		function enviaSms(){
			
			$.ajax({
				type: 'POST',
				url: "sms/enviaSms.php?",
				data:{paciente:document.getElementById("paciente").value, fone:document.getElementById("fone").value, texto:document.getElementById("conteudo_sms").value, dia:document.getElementById("dia").value},
				success: function(html){
					document.getElementById("msg").innerHTML = html;
					$( "#confirma" ).dialog( "open" );
					jQuery(".ui-dialog-buttonset button:contains('Enviar')").removeAttr("disabled").removeClass("ui-state-disabled").addClass('ui-state-default');
					$.ajax({
						type: 'POST',
						url: "Paciente/atualizaDataSMS.php",
						data:{id:document.getElementById("id_selecao").value},
						sucess: function(html){
							document.getElementById("form3").reset();
						}
					});
					
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
											
			window.location.href = '../logoff.php';

		}

		function marcaRadioPaciente(id, idPaciente){
			document.getElementById("id_"+id).checked = true;
			carregaPaciente(idPaciente);
		}	

		function validaCPF(num){

			var cpf = num ;
			var i = 0;
			var Soma = 0;
			var Resto = 0;
			
			
			while(i < cpf.length) 
			{
				cpf = cpf.replace(".","");
				cpf = cpf.replace("-","");
				i = i + 1;
			}

			 if(cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" 
			 	|| cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" 
			 	|| cpf == "66666666666" || cpf == "77777777777"|| cpf == "88888888888" || cpf == "99999999999"){
			 	return false;
			 }else{
			
			 	
			 	for (i=1; i<=9; i++){
			 		Soma = Soma + parseInt(cpf.substring(i-1, i)) * (11 - i);
			 	}

			 	Resto = (Soma * 10) % 11;
			 	

			 	if ((Resto == 10) || (Resto == 11)){ Resto = 0; } 

			 	if (Resto != parseInt(cpf.substring(9, 10)) ) { return false;}

			 	Soma = 0; 

			 	for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i-1, i)) * (12 - i); 

			 	Resto = (Soma * 10) % 11; 

			 	if ((Resto == 10) || (Resto == 11)) {Resto = 0; }

			 	if (Resto != parseInt(cpf.substring(10, 11) ) ) { return false;} 
			 	return true;

			 }

		}

		function validaTel(num){
			var i = 0;
			var digito;
			var fone = num;

			while(i < fone.length) 
			{
				fone = fone.replace("(","");
				fone = fone.replace(")","");
				fone = fone.replace("-","");
				i = i + 1;
			}

			digito = fone.substring(2,3);

			if(digito < 7 || digito > 9){
				document.getElementById("msg").innerHTML = "Digite um telefone válido.";
				$( "#confirma" ).dialog( "open" );
			}else{
				return true;
			}

		}

		function validaFormVer(){
			if(document.getElementById("nome1").value == ""){
				document.getElementById("msg").innerHTML = "Digite o nome do paciente";
				document.getElementById("nome1").style.borderColor='blue';
				$( "#confirma" ).dialog( "open" );
				document.getElementById("nome1").focus;
			}else{
				if(document.getElementById("cpf1").value == ""){
					document.getElementById("msg").innerHTML = "Digite o cpf do paciente";
					document.getElementById("cpf1").style.borderColor='blue';
					$( "#confirma" ).dialog( "open" );
					document.getElementById("cpf1").focus;
				}else{
					if(document.getElementById("telefone").value == ""){
						document.getElementById("msg").innerHTML = "Digite o celular do paciente";
						document.getElementById("telefone").style.borderColor='blue';
						$( "#confirma" ).dialog( "open" );
						document.getElementById("telefone").focus;
					}else{
						return true;
					}
				}
			}
		}

		function validaNovo(){

			if(document.getElementById("nome_pac").value == ""){
				document.getElementById("nome_pac").focus();
				document.getElementById("nome_pac").style.borderColor='blue';
				document.getElementById("msg").innerHTML = "Digite o nome do paciente";
				$( "#confirma" ).dialog( "open" );
			}else{
				if(document.getElementById("cpf_pac").value == ""){
					document.getElementById("cpf_pac").focus();
					document.getElementById("cpf_pac").style.borderColor='blue';
					document.getElementById("msg").innerHTML = "Digite o cpf do paciente";
					$( "#confirma" ).dialog( "open" );
				}else{
					if(document.getElementById("tel").value == ""){
						document.getElementById("tel").focus();
						document.getElementById("tel").style.borderColor='blue';
						document.getElementById("msg").innerHTML = "Digite o celular do paciente";
						$( "#confirma" ).dialog( "open" );
						
					}else{
						return true;
					}
				}
			}
		}

		function titleize(text) {
		    var loweredText = text.toLowerCase();
		    var words = loweredText.split(" ");
		    for (var a = 0; a < words.length; a++) {
		        var w = words[a];

		        var firstLetter = w[0];
		        w = firstLetter.toUpperCase() + w.slice(1);

		        words[a] = w;
		    }
		    return words.join(" ");
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
			
		function bloqueia(){
			document.getElementById("id_emp_login").value = '<?php echo $_SESSION['empresa']; ?>';
			document.getElementById("usuario").value = '<?php echo $_SESSION['login']; ?>';
			var url = "../bloqueio.php";
			sendRequest(url, ajaxBloqueia);
		}
			
		function ajaxBloqueia(){}

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
				
			$("#cpf, #cpf_pac").mask("999.999.999-99");
			
			$("#tel").mask("(99)9999-9999?9");
			document.getElementById("nome").focus();

			$("#nome_pac").click(function(e){
				document.getElementById("nome_pac").style.borderColor='white';
			});

			$("#cpf_pac").click(function(e){
				document.getElementById("cpf_pac").style.borderColor='white';
			});

			$("#tel").click(function(e){
				document.getElementById("tel").style.borderColor='white';
			});



			$(document).on("click", "#cpf1", function(){
				$("#cpf1").mask("999.999.999-99");
				$("#cpf1").click(function(){
					document.getElementById("cpf1").style.borderColor='white';
				});

			});
			$(document).on("click", "#telefone", function(){
				$("#telefone").mask("(99)9999-9999?9");
				$("#telefone").click(function(){
					document.getElementById("telefone").style.borderColor='white';
				});
				
			});

			$(document).on("click", "#nome1", function(){
				$("#nome1").click(function(){
					document.getElementById("nome1").style.borderColor='white';
				});

			});

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
								carregaPaciente(x);
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
											
												pesquisaPaciente();
										},
						
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
										$( this ).dialog( "close" );
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

							"Limpar":function() {
										document.getElementById("nome_pac").value = "";
										document.getElementById("cpf_pac").value = "";
										document.getElementById("tel").value = "";
									},


							"Fechar":function() {
										document.getElementById("nome_pac").value = "";
										document.getElementById("cpf_pac").value = "";
										document.getElementById("tel").value = "";
										$(".ui-dialog-buttonpane button:contains('gravar')").button("enable");
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
					height: 350,
					width: 500,
					modal: true,
					resizable: false,
					closeOnEscape: true,
					position: ['center',160],
					show:  {effect: "fade", duration: 200},
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
	
						"Gravar": function() {
							$(".ui-dialog-buttonpane button:contains('gravar')").button("disable");
							alteraPaciente(document.getElementById("id1").value, document.getElementById("nome1").value, document.getElementById("cpf1").value, document.getElementById("telefone").value);
							setTimeout(function(){ 
								$(".ui-dialog-buttonpane button:contains('gravar')").button("enable");
							}, 2000);		 		
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
							document.getElementById("id_selecao").value = "";

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
										document.getElementById("id_selecao").value = "";
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

			
			$( "#enviar" ).dialog({
					modal: true,
					autoOpen: false,
					resizable: false,
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"Sim": function() {
							sms(document.getElementById("id_selecao").value);
							$( this ).dialog( "close" );
						},
						"Não": function() {
							carregaPaciente("");
							document.getElementById("nome_pac").value = "", 
							document.getElementById("cpf_pac").value = "", 
							document.getElementById("tel").value = "",
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
                    <img src="../jquery/css/images/logo.jpg" width="400" height="100"/>
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
									<li><a  href="user.php">Pacientes</a></li>
									<li><a  href="#">Usuário</a>
										<ul>
											<li><a  href="usuario/PesquisaUsuario.php">Cadastro de Usuário</a></li>
											<li><a  href="grupoUsuario/PesquisaGrupo.php">Grupo de Usuário</a></li>
										</ul>
									</li>
									<li><a  href="#">SMS</a>
										<ul>
											<li><a  href="sms/formRelSms.php">Créditos</a></li>
											<li><a  href="sms/relMensagens.php">Mensagens Enviadas</a></li>
										</ul>
									</li>
									<li><a  href="usuario/formAlteraSenha.php">Alterar Senha</a></li>
									<li><a  href="Parametros/parametros.php">Parâmetros</a></li>
								</ul>
							</li>

							<li><a class="MenuBarItemSubmenu" href="#"><strong>Relatórios</strong></a>
								<ul>
									<li><a  href="relatorio/relatorio.php">Avaliação da dor</a></li>
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

		<div id="form-pesq-paciente" align="center">
			<input type="hidden" name="id_selecao" id="id_selecao" />
			Nome: <input type="text" size="50" maxlength="50" name="nome" id="nome" class="maiusculo" /> 
			CPF: <input type="text" name="cpf" id="cpf" size="16" maxlength="14"/>
			STATUS:<select id="status" name = "status">								
						<option value="">TUDO</option>
						<option value="A">ATIVO</option>								
						<option value="I">INATIVO</option>								
					</select>						
			<h4>&nbsp;</h4>						
			<table width="100%" id="retorno"></table>
		</br>	
		</div>

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
						<td><input type="text" name="tel" id="tel" size="45"  pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" /></td>							
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

		<div id="enviar" title="Atenção">
			<p>	
				<h2>Paciente cadastrado com sucesso.</h2>					
				<h3>Deseja enviar sms a este paciente??</h3>
			</p>					
		</div>

		<div id="chat" title="Chat">
			<div align="left" id="chat2">				
				<?php include 'chat_on/listaContatos.php';?>
			</div>
		</div>

		<div id="broadcast" title="broadcast">
			<p><div><h3 align="center">Mensagem em Massa</h3></div></p>
			<table align="center" width="100%">												
				<tr>
					<td align="right">Grupo</td>
					<td>
						<select id="grupo_broad" title="Selecione um grupo ou em branco para todos"/>
							<option value="" ></option>
							<?php
								foreach($grupoDao->listar

									("select * from grupo") as $g){ ?>
								<option value="<?php echo $g['id_grupo']; ?>" ><?php echo $g['descricao']; ?></option>	
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Mensagem</td>
					<td>
						<textarea id="mensagem_broad" rows="10" cols="65"></textarea>
					</td>
				</tr>
			</table>
		</div>

		<div id="confirma_broad" title="Atenção">
			<p>						
				<h3><label id="msg_b"/></h3>
			</p>					
		</div>

		<div id="janelas"></div>

		<audio id="audio">
			<source src="../jquery/chat.mp3" type="audio/mpeg">
		</audio>

	</body>
</html>

	
	