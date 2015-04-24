<?php
require "controlaSessao.php";
date_default_timezone_set('America/Sao_Paulo');
header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();

@require("model/PDOConnectionFactory.class.php");
@require("model/EmpresaDao.class.php");
@require("model/modelUsuarioL.php");
@require("model/modelParametrosL.php");
@require("model/modelHorarioL.php");


if(isset($_POST["login"])){
$login = $_POST["login"];	
}

if(isset($_POST['senha'])){
$senha = md5($_POST['senha']);	
}

if(isset($_POST['id_empresa'])){
$id_empresa = $_POST['id_empresa'];	
}

$agora = date('H:i:s');
$limiteInicio = "05:00:00";
$limiteFim = "01:00:00";
$dataLogin = date("d/m/Y H:i:s");
$horaLogin = date('H:i');


$query = "select * from usuario where login = '$login' and senha = '$senha'";


$empresa = new EmpresaDao();
$nomeEmpresa = "";
$nomeEmpresaImp = "";
foreach($empresa->listar("select nome, desc_imp from empresa where id_empresa = ".$id_empresa) as $e){
	$nomeEmpresa = $e['nome'];
	$nomeEmpresaImp = $e['desc_imp'];
}

$horarioLogin = new modelHorario();

$DAO = new modelUsuario();
$count = 0;
foreach ($DAO->listar($query) as $row){
	$count ++;
}

$parametros = new modelParametros();
$valor = "";
foreach($parametros->listar("select valor from parametros where descricao = 'Ip_fixo'") as $param){
	$valor = $param['valor'];
}
$horario_login = "N";
foreach($parametros->listar("select valor from parametros where descricao = 'Usa_horario_login'") as $param){
	$horario_login = $param['valor'];
}

///verifica acesso externo
if($login != "admin"){
	$bloqueia_acesso = "N";
}else{
	$bloqueia_acesso = "S";
	$ip = "";

	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	//$ip = $_SERVER['REMOTE_ADDR'];

	if($valor != ""){
		$hosts = explode(";",$valor);	
		foreach($hosts as $pc){
			if($pc == $ip){
				$bloqueia_acesso = "N";			
			}
		}
	}else{
		$bloqueia_acesso = "N";	
	}
	//////////////////////////
}

if($count > 0){
	if($row['status'] == "I"){

		echo("<script type='text/javascript'> alert('Este usuário esta inativo !!!'); location.href='index.php';</script>");
	}else{
		if($row['master'] == "N"){//se não for master
			//verifico o parametro de horario_login $horaLogin
			if($horario_login == "S"){//se for sim verifico os horarios cadastrados
				$diasemana = date("w", mktime(0,0,0,date('m'),date('d'),date('Y')) );
				$diasemana++;
				$liberaLogin = false;
				foreach($horarioLogin->listar("select * from horario_login where id_usuario = '".$row['id_usuario']."' and dia_sem = '$diasemana'") as $h){
					if($horaLogin >= $h['hora _ini'] && $horaLogin <= $h['hora_fim']){//libera o login
						$_SESSION['hora_fim'] = $h['hora_fim'];
						$liberaLogin = true;
						break;
					}
				}
				
				if($liberaLogin){
					$_SESSION['login'] = $row['login'];
					$_SESSION['id_user'] = $row['id_usuario'];
					$_SESSION['foto_pac'] = "";	
					$_SESSION['id_usuario'] = $row['id_usuario'];	
					$_SESSION['nome'] = utf8_encode($row['nome']);
					$_SESSION['id_grupo'] = $row['id_grupo'];
					$_SESSION['empresa'] = $id_empresa;
					$_SESSION['nome_empresa'] = utf8_encode($nomeEmpresa);
					$_SESSION['nome_medico'] = "";
					$_SESSION['id_medico'] = "";
					$_SESSION['master'] = $row['master'];
					$_SESSION['generico'] = $row['generico'];
					
					//$atual = date('Y-m-d H:i:s');
					//$expira = date('Y-m-d H:i:s', strtotime('+1 min'));					
					//$DAO->listar("update usuario set horario = '$atual', limite = '$expira', chat_ativo = 'S' where id_usuario = '".$row['id_usuario']."' ");
					
					$contMed = 0;
					echo "logou";
					break;

					header("Location: view/user.php");
					
				}else{
					echo("<script type='text/javascript'> alert('Horário de Login não permitido'); location.href='index.php';</script>");
				}
			}else{//senao loga normal
				$_SESSION['login'] = $row['login'];
				$_SESSION['id_user'] = $row['id_usuario'];
				$_SESSION['foto_pac'] = "";	
				$_SESSION['id_usuario'] = $row['id_usuario'];	
				$_SESSION['nome'] = utf8_encode($row['nome']);
				$_SESSION['id_grupo'] = $row['id_grupo'];
				$_SESSION['empresa'] = $id_empresa;
				$_SESSION['nome_empresa'] = utf8_encode($nomeEmpresa);
				$_SESSION['nome_medico'] = "";
				$_SESSION['id_medico'] = "";
				$_SESSION['master'] = $row['master'];
				$_SESSION['generico'] = $row['generico'];
				
				//$atual = date('Y-m-d H:i:s');
				//$expira = date('Y-m-d H:i:s', strtotime('+1 min'));					
				//$DAO->listar("update usuario set horario = '$atual', limite = '$expira', chat_ativo = 'S' where id_usuario = '".$row['id_usuario']."' ");
				
		
				
				
				header("Location: view/user.php");			
			}
		}else{//se for master libera o login
			$_SESSION['login'] = $row['login'];
			$_SESSION['id_user'] = $row['id_usuario'];
			$_SESSION['foto_pac'] = "";	
			$_SESSION['id_usuario'] = $row['id_usuario'];	
			$_SESSION['nome'] = utf8_encode($row['nome']);
			$_SESSION['id_grupo'] = $row['id_grupo'];
			$_SESSION['empresa'] = $id_empresa;
			$_SESSION['nome_empresa'] = utf8_encode($nomeEmpresa);
			$_SESSION['nome_medico'] = "";
			$_SESSION['id_medico'] = "";
			$_SESSION['master'] = $row['master'];
			$_SESSION['generico'] = $row['generico'];
			
			//$atual = date('Y-m-d H:i:s');
			//$expira = date('Y-m-d H:i:s', strtotime('+1 min'));					
			//$DAO->listar("update usuario set horario = '$atual', limite = '$expira', chat_ativo = 'S' where id_usuario = '".$row['id_usuario']."' ");
			
			
			header("Location: view/user.php");
		}

	}

	
		
}else{
	echo("<script type='text/javascript'> alert('Usuário ou senha Inválidos !!!'); location.href='index.php';</script>");
}
?>