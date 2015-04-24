<?php
require "../controlaSessao.php";
header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();

if(!isset($_SESSION['id_usuario'])) {
	header("Location: ../".$_SESSION['cliente']."/index.php");
}
@require("../DAO/PDOConnectionFactory.class.php");
@require("../DAO/ModeloSmsDao.class.php");
@require("../entidades/ModeloSms.class.php");
@require("../DAO/GrupoXProgramasDao.class.php");

$gDao = new GrupoXProgramasDao();
if($_SESSION['master'] == "S"){
	$inc = true;
	$alt = true;
	$exc = true;
	$imp = true;
}else{
	$inc = false;
	$alt = false;
	$exc = false;
	$imp = false;
	foreach($gDao->listar("select * from grupoxprogramas where programas = 'Modelo_sms' and id_grupo = ". $_SESSION['id_grupo'] ) as $acesso){
		if($acesso['inc'] == "S"){ $inc = true; }
		if($acesso['alt'] == "S"){ $alt = true; }
		if($acesso['exc'] == "S"){ $exc = true; }	
	}
}
$modeloSmsDao = new ModeloSmsDao();
$sql = null;

$numreg = 10;
$totalLinhas = 0;

if (!isset($_GET['pg'])) {
    $_GET['pg'] = 0;	
}
$inicial =  $_GET['pg'] * $numreg;

if(isset($_GET['ex'])){		
	$sql = $_SESSION['consulta_sms'];
	$quantreg = $modeloSmsDao->contar();
	$totalLinhas = $quantreg;
	$_POST['pesq'] = "a";
	$_GET['ex'] = null;	
}else{
	if(isset($_POST["pesq"])){
		$sql = "select * from modelo_sms where 1=1 ";
		if(isset($_POST["nome"])){
			$nome = $_POST["nome"];	
		}
		if(isset($_POST['parte'])){
			$nome = "%" . $nome . "%";
		}
		if(!empty($nome)) { 
			$sql = $sql." and nome like '$nome%' ";
		}
				
		$quantreg = $modeloSmsDao->contar();
		$totalLinhas = $quantreg;
		
		$_SESSION['consulta_sms'] = $sql;
	}
}
$sql = $sql. "LIMIT $inicial, $numreg";
//echo $sql;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
		<link href="../css/main.css" rel="stylesheet" type="text/css" />
		<link href="../css/screen.css" rel="stylesheet" type="text/css"/>
		<link href="../css/rodape.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript" src="../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
		
		<script>			
			$(function() {
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
 
					// Para tratar quando é digitado
					$(".maiusculo").keypress(function() {
						var el = $(this);
						setTimeout(function() {
							var text = $(el).val();
							el.val(text.toUpperCase());
						}, 1);
					});
				}
				
			});				
		</script>
		
		<script type="text/javascript">
            function confirmacao(){
                if (confirm("Tem Certeza que Deseja Excluir?")){
                    return true;
                }else{
                    return false;
                }
            }
        </script>
		<script>
			$(function() {				
			
				$( document ).tooltip({
					track: true
				});
			})
		</script>
  </head>

<body>				
	<div id="tudo">
		<div id="conteudo">
			<div id="topo">
				<?php include("../menu.php"); ?>
			</div>			
			<div id="main">	
				<div id="conteiner">							
					<div class="bg_area_login" align="center">
						<h2>Modelos de SMS</h2>
						
						<form action="formPesquisaSms.php" method="post">							
							Descrição <input type="text" size="40" maxlength="40" name="nome" class="maiusculo" /> 
							Buscar Parte <input type="checkbox" name="parte" value="S" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;							
							<input type ="submit" value="Pesquisar" name="pesq" class="botao" />
							<input type ="button" value="Novo" class="botao" onclick="location. href= 'formNovoModeloSms.php'" <?php if(! $inc ){?> disabled <?php } ?>/>							
							<h4>&nbsp;</h4>
							<?php if(isset($_POST["pesq"])){ ?>
							<table width="70%">
								<thead>
									<tr>
										<th><Strong>Código</Strong></th>
										<th><Strong>Descrição</Strong></th>
										<th><Strong>Alterar</Strong></th>
										<th><Strong>Excluir</Strong></th>
									</tr>
								</thead>
								<tbody>
								<?php 
									if(isset($_POST["pesq"])){
										$cor = "CCCCCC";
										foreach ($modeloSmsDao->listar($sql) as $p){
											if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";}	
									?>
								<tr style="cursor:pointer;" onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''"  bgcolor="<?php echo $cor ?>" >
									<td><?php echo $p['id_modelo_sms'] ?></td>
									<td><?php echo $p['descricao'] ?></td>
									<td align="center">
										<?php if($alt){?>
											<a href="formAlteraModeloSms.php?id=<?php echo $p['id_modelo_sms'] ?>" >
												<img src="../images/alterar.png" alt="Alterar" title="Alterar" width="26" height="28" border="0">
											</a>
										<?php } else { ?>
											<a href="#" >
												<img src="../images/alterar_a.png" alt="Alterar" title="Alterar" width="26" height="28" border="0">
											</a>									
										<?php } ?>
									</td>
									<td align="center">
										<?php if($exc){?>
											<a href="excluiModeloSms.php?id_modelo_sms=<?php echo $p['id_modelo_sms'] ?>" >
												<img src="../images/excluir.png" alt="Excluir" title="Excluir" width="26" height="28" border="0" onclick="return confirmacao();">
											</a>
										<?php } else { ?>
											<a href="#" >
												<img src="../images/excluir_a.png" alt="Excluir" title="Excluir" width="26" height="28" border="0" >
											</a>
										<?php } ?>
									</td>
								</tr>
								<?php } } ?>
								</tbody>
								<tfoot>
									<th	colspan="7"  cellspacing="0" cellpadding="0">
										<?php include("../paginacao.php"); ?>												
									</th>
								</tfoot>
							</table>
							<?php } ?>	
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
