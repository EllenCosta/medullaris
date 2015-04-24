<?php
date_default_timezone_set('America/Sao_Paulo');
require "../../../controlaSessao.php";
session_start();
require "../../../control/controlUser.php";
require "../../../model/MensagensDao.class.php";
//@require($_SERVER['DOCUMENT_ROOT']."/medullaris/control/controlUsuario.php");
//@require($_SERVER['DOCUMENT_ROOT']."/medullaris/model/MensagensDao.class.php");

	$usuarioDao = new ControlUsuario();
	$mensagensDao = new MensagensDao();	
	
	$acao = $_POST['acao'];	
	
	switch($acao){
		case 'inserir':
		
			$nome = "";
			foreach($usuarioDao->listar("select nome from usuario where id_usuario = '".$_SESSION['id_user']."' ") as $usu){
				$nome = $usu['nome'];
			}
			$para = $_POST['para'];
			$mensagem = strip_tags($_POST['mensagem']);
			
			if($_POST['para'] == "0"){ // broadcast
				$id_grupo = $_POST['id_grupo'];
				if($id_grupo == ""){
					foreach($usuarioDao->listar() as $u){
						$mensagensDao->listar("INSERT INTO `mensagens` (id_de, id_para, data, mensagem, lido) VALUES('".$_SESSION['id_user']."','".$u['id_usuario']."',NOW(),'$mensagem','0')");
					}
				}else{
					foreach($usuarioDao->listar("select id_usuario from usuario where id_grupo = '$id_grupo'") as $u){
						$mensagensDao->listar("INSERT INTO `mensagens` (id_de, id_para, data, mensagem, lido) VALUES('".$_SESSION['id_user']."','".$u['id_usuario']."',NOW(),'$mensagem','0')");
					}
				}								
			}else{//mensagem para um destinatario
				$mensagensDao->listar("INSERT INTO `mensagens` (id_de, id_para, data, mensagem, lido) VALUES('".$_SESSION['id_user']."','$para',NOW(),'$mensagem','0')");
				echo '<li><span><strong>'.$nome.' disse:</strong></span><p>'.$mensagem.'</p></li>';
			}			
			
		break;
		
		case 'verificar':
			$ids = (isset($_POST['ids'])) ? $_POST['ids'] : '';
			$users = (isset($_POST['users'])) ? $_POST['users'] : '';
			$retorno = array();

			if($users != ''){
				foreach($users as $indice => $id_u){
					$atual = date('Y-m-d H:i:s');
					$mais1 = date('Y-m-d H:i:s', strtotime('+1 min'));
					
					foreach($usuarioDao->listar("SELECT horario, limite, chat_ativo FROM usuario WHERE id_usuario = '$id_u'") as $usu ){						

						if($id_u == $_SESSION['id_user']){
							$usuarioDao->listar("UPDATE usuario SET limite = '$mais1' WHERE id_usuario = '$id_u'");
						}

						if($atual >= $usu['limite']){
							$retorno['useronoff'][$id_u] = 'off';
						}else{
							if($usu['chat_ativo'] == "S"){
								$retorno['useronoff'][$id_u] = 'on';
							}else{
								$retorno['useronoff'][$id_u] = 'aus';
							}
						}
					}
				}
			}
			
			if($ids == ''){
				if(isset($retorno['mensagens']))
					$retorno['mensagens'] == '';
			}else{
				foreach($ids as $indice => $id){
					$mensagem = '';
					//foreach($mensagensDao->listar("SELECT * FROM `mensagens` WHERE id_de = '".$_SESSION['id_user']."' AND id_para = '$id' OR id_de = '$id' AND id_para = '".$_SESSION['id_user']."' ") as $msg){
					foreach($mensagensDao->listar("SELECT id_de, data, mensagem FROM `mensagens` WHERE id_de = '".$_SESSION['id_user']."' AND id_para = '$id' OR id_de = '$id' AND id_para = '".$_SESSION['id_user']."' ") as $msg){
						$nome="";
						foreach($usuarioDao->listar("SELECT nome FROM usuario WHERE id_usuario = '".$msg['id_de']."'") as $usu){
							$nome = $usu['nome'];
						}
						$data_mysql = $msg['data'];
						$timestamp = strtotime($data_mysql); // Gera o timestamp de $data_mysql
						//echo date('H:m', $timestamp); // Resultado: 12/03/2009
						$mensagem .= '<li><span><strong>'.$nome.' disse as '.date('H:i', $timestamp).':</strong></span><p>'.$msg['mensagem'].'</p></li>';
					}
					$retorno['mensagens'][$id] = $mensagem;
					$retorno['last_msg'][$id] = $msg['mensagem'];
				}
			}
			
			$cont = 0;
			//$hoje = date('Y-m-d H:i:s');
			foreach($mensagensDao->listar("SELECT id_de FROM `mensagens` WHERE id_para = '".$_SESSION['id_user']."' AND lido = '0' GROUP BY id_de") as $msg){
				$cont ++;
			}
			
			if($cont == 0){
				if(isset($retorno['nao_lidos'])){
					$retorno['nao_lidos'] == '';
				}
			}else{
				foreach($mensagensDao->listar("SELECT id_de FROM `mensagens` WHERE id_para = '".$_SESSION['id_user']."' AND lido = '0' GROUP BY id_de") as $msg){
					$retorno['nao_lidos'][] = $msg['id_de'];
					foreach($usuarioDao->listar("select nome from usuario where id_usuario = '".$msg['id_de']."'") as $u){
						$retorno['enviado_por'] = $u['nome'];
					}
				}
			}
			$retorno = json_encode($retorno);
			echo $retorno;
		break;
		
		case 'mudar_status':			
			$user = $_POST['user'];
			$usuarioDao->listar("UPDATE `mensagens` SET lido = '1' WHERE id_de = '$user' AND id_para = '".$_SESSION['id_user']."'");
		break;
	}
?>