<?php
	require "../controlaSessao.php";
	
	session_start();
	
	@require($_SERVER['DOCUMENT_ROOT']."/medullaris/control/controlUsuario.php");

	
	$usuarioDao = new ControlUsuario();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bem vindo ao chat</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

		
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
</head>

<body>
<div id="contatos">
<span class="online" id="<?php echo $_SESSION['id_user'];?>"></span>
	<ul>
	<?php
		$id = $_SESSION['id_user'];
		$cont = 0;
		foreach($usuarioDao->listar("select * from usuario where id_usuario != '$id' and status = 'A'") as $usu){
			$cont ++;
		}
		if($cont <= 0){
			echo '<p>Desculpla, não há contatos ainda!</p>';
		}else{
			foreach($usuarioDao->listar("select * from usuario where id_usuario != '$id' and status = 'A'") as $usu){ ?>
				<li><span class="type" id="<?php echo $usu['id_usuario'];?>"></span>
				<a href="javascript:void(0);" nome="<?php echo $usu['nome'];?>" id="<?php echo $usu['id_usuario'];?>" class="comecar"><?php echo $usu['nome'];?></a></li>
			<?php }
		}?>
	</ul>
</div>
<div style="position:absolute; top:0; right:0;" id="retorno"><div>
<div id="janelas"></div>
</body>
</html>