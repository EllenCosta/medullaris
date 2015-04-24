<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

	$inc = true;
	$alt = true;
	$exc = true;
	$imp = true;

$grupoUsuario = new controlGrupoUsuario();
$sql = null;

$numreg = 10;
$totalLinhas = 0;

if (!isset($_GET['pg'])) {
    $_GET['pg'] = 0;	
}
$inicial =  $_GET['pg'] * $numreg;

if(isset($_GET['ex'])){
	echo "ta no if";
	break;
	$sql = $_SESSION['consulta'];
	$quantreg = $grupoUsuario->contar($sql);
	$totalLinhas = $quantreg;
	$_POST['pesq'] = "a";
	$_GET['ex'] = null;	
}else{
	
	$sql = "select * from grupo ";
	if(isset($_POST["nome"])){
		$nome = $_POST["nome"];	
	}

	if(!empty($nome)) { 
		$sql = $sql." where grupo.descricao like '%$nome%' ";
	}
	
	$quantreg = $grupoUsuario->contar($sql);
	$totalLinhas = $quantreg;
	$sql = $sql." order by id_grupo ";
	$_SESSION['consulta'] = $sql;
	$imp = true;

	
}
$sql = $sql. "LIMIT $inicial, $numreg";

?>
<table width="100%">
	<thead>
		<tr>
			<th><Strong>Codigo</Strong></th>
			<th><Strong>Nome</Strong></th>										
			<th><Strong>Alterar</Strong></th>
			<th><Strong>Excluir</Strong></th>
		</tr>
	</thead>
	<tbody>
	<?php 
			$cor = "CCCCCC";
			foreach ($grupoUsuario->listar($sql) as $grupo){

				if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";}	
		?>
	<tr style="cursor:pointer;" onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''" onDblClick="pesquisaGrupo('<?php echo $grupo['id_grupo'] ?>')" bgcolor="<?php echo $cor ?>" >
		<td><?php echo $grupo['id_grupo'] ?></td>
		<td><?php echo $grupo['descricao'] ?></td>									
		<td align="center">
			
				<a href="#" >
					<img src="../../jquery/css/images/alterar.png" alt="Alterar" id="alterar" title="Alterar" width="23" height="22" border="0" onClick="carregaGrupo('<?php echo $grupo['id_grupo'] ?>');">
				</a>
		
		</td>
		<td align="center">
		
				<a href="#" >
					<img src="../../jquery/css/images/excluir.png" alt="Excluir" id="excluir" title="Excluir" width="23" height="22" border="0" onClick="carregaGrupo('<?php echo $grupo['id_grupo'] ?>');">
				</a>
			
		</td>
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<th	colspan="7"  cellspacing="0" cellpadding="0">
			<?php include("paginacaoAjax.php"); ?>										
		</th>
	</tfoot>
</table>