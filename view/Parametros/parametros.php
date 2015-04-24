<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
$_SESSION['inclui'] = "t";
include_once '../../control/controlParametros.php';

header("Content-Type: text/html;  charset=ISO-8859-1",true);

$cp = new ControlParametros();
$lista = $cp->listar(null);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../../jquery/css/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
		<script type="text/javascript" src="../../jquery/js/jquery.maskedinput.js"></script>
		<link href="../../jquery/css/rodape.css" rel="stylesheet" type="text/css" />

		
		
  </head>
  <script>
	$(function() {
		$( document ).tooltip({
			track: true
		});
	});
  </script>

<body>				
	<div id="tudo">
		<div id="conteudo">
			<div id="topo">
				<?php include("../menu/menu.php"); ?>
			</div>			
			<div id="main">	
				<div id="conteiner">							
					<div class="bg_area_login" align="center">
						<br />
						<br />
						<h2>Parâmetros</h2>
						
						<form action="gravaParametros.php" method="post">
							<table width="50%">
								<thead>
									<tr>
										<td>Descrição</td>
										<td>Valor</td>
									</tr>
								</thead>
								</tbody>
									<?php 
									$cor = "CCCCCC";
									if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";}
									foreach($lista as $p){ ?>					
									<tr onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''"  bgcolor="<?php echo $cor ?>" title="<?php echo $p['detalhes'] ?>">
										<td><?php echo $p['descricao']; ?></td>
										<td>
														<?php if($p['tipo'] == "T"){ ?>
															<input type="text" name="par_<?php echo $p['descricao']; ?>" id="par_<?php echo $p['descricao']; ?>" value="<?php echo $p['valor']; ?>" size="80">
														<?php } ?>
														<?php if($p['tipo'] == "L"){ ?>
															<select name="par_<?php echo $p['descricao'] ?>" id="par_<?php echo $p['descricao'] ?>">
																<?php 
																if ($p['valor'] == "S"){ ?>
																	<option value="S" selected >Sim</option>
																	<option value="N" >Não</option>
																<?php } else {?>
																	<option value="S" >Sim</option>
																	<option value="N" selected >Não</option>
																<?php } ?>
															</select>													
														<?php } ?>
														<?php if($p['tipo'] == "LT"){ ?>
															<textarea rows="5" cols="75" name="par_<?php echo $p['descricao']; ?>" id="par_<?php echo $p['descricao']; ?>" ><?php echo $p['valor']; ?></textarea>													
														<?php } ?>
														<?php if($p['tipo'] == "P"){ ?>
															<input type="password" name="par_<?php echo $p['descricao']; ?>" id="par_<?php echo $p['descricao']; ?>" value="<?php echo base64_decode($p['valor']); ?>" size="80">
														<?php } ?>
													</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							</br>
							<input type="submit" class="botao" value="Gravar" />
						</form>
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
