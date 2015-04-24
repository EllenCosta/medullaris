<?php
header("Content-Type: text/html;  charset=ISO-8859-1",true);
//session_start();

@require("model/PDOConnectionFactory.class.php");
@require("model/EmpresaDao.class.php");


//$_SESSION['cliente'] = "sgp";
//$_SESSION['host'] = "admed.cqxuennp4oyg.sa-east-1.rds.amazonaws.com";
//$_SESSION['host'] ="localhost";'	'
$empresaDao = new EmpresaDao();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">				
		<link href="jquery/css/main.css" rel="stylesheet" type="text/css" />		
		<link href="jquery/css/rodape.css" rel="stylesheet" type="text/css"/>
		<link href="jquery/css/login.css" rel="stylesheet" type="text/css"/>
		<title>Admed Sistemas</title>
		<script>
			function foco(){
				document.getElementById("login").focus();
			}
		</script>
  </head>

   <body onload="foco();">
   <div id="tudo">
		<div id="conteudo">
			<div id="topo">	
				<div id="branco_top">
					<div id="logo">
						<img src="jquery/css/images/logo.jpg"  width="400" height="100"/>
					</div>
				</div>
			</div>
									
			<div class="conteudo_login">
				<form method="post" action="login.php" >
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p><div><h2 align="center">Acesso ao Sistema</h2></div></p>
					
					<table align="center" width="70%">						
						<tr>
							<td> &nbsp; </td>
							<td> &nbsp; </td>
						<tr>
						<tr>
							<td>Nome</td>
							<td><input type="text" name="login" id="login" autocomplete="off"/></td>
						<tr>
						<tr>
							<td>Senha</td>
							<td><span class="texto_fora"><input type="password" name="senha" id="senha"/></span></td>
						<tr>
						<tr>
							<td>Unidade</td>
							<td><span class="texto_fora">
								<select name="id_empresa" id="id_empresa">
									<?php foreach($empresaDao->listar() as $empresa){?>
										<option value="<?php echo $empresa['id_empresa'] ?>" ><?php echo $empresa['nome'] ?></option>
									<?php } ?>
								</select>
							</span>
						</td>
						</tr>
						<tr>
							<td colspan="2"><div align="center"><input type="submit" value="Login" class="botao"/></div></td>
						</tr>							
					</table>						
				</form>						
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div id="bg_rodape">
			<div id="assinatura">
				<div id="left">© 2013 ADMED Sistemas - Todos direitos reservados</div>
			</div>			
		</div>
		
	</div>
   </body>

</html>