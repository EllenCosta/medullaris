<?php
require "../../controlaSessao.php";

$inclui;
if(isset($_SESSION['inclui'])){

	if($_SESSION['inclui'] == "u"){
		require "../../control/controlUsuario.php";
	}
	if($_SESSION['inclui'] == "t"){
		require "../../control/controlUsuario.php";
		require "../../control/controlGrupoUsuario.php";

	}
	if($_SESSION['inclui'] == "g"){
		require "../../control/controlGrupoUsuario.php";
	}
}


$usuarioDao = new ControlUsuario();
$grupoDao = new ControlGrupoUsuario();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../view/chat_on/css/estilo.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../view/chat_on/js/functions2.js"></script>
<script type="text/javascript" src="../../view/chat_on/js/chat2.js"></script>
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
			echo '<span align="center"><p>Sem contatos!</p><span>';
		}else{
			foreach($grupoDao->listar("select * from grupo") as $g){?>
				<span align="left"><h3><?php echo $g['descricao']; ?></h3></span>
				<?php
				foreach($usuarioDao->listar("select * from usuario where id_usuario != '$id' and id_grupo = '".$g['id_grupo']."'  and status = 'A' order by nome") as $usu){ ?>
					<li><span class="type" id="<?php echo $usu['id_usuario'];?>"></span>
					<a href="javascript:void(0);" nome="<?php echo $usu['nome'];?>" id="<?php echo $usu['id_usuario'];?>" class="comecar"><?php echo $usu['nome'];?></a></li>
				<?php }
			}			
		}?>
	</ul>
	<div id="janelas"></div>

</div>
</body>
</html>