<?php
require "../../controlaSessao.php";
require "../../control/controlRelatorio.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

header("Content-Type: text/html;  charset=ISO-8859-1", true);
$cp = new controlRelatorio();

$numreg = 10;
$totalLinhas = 0;
$quantreg = 0;
$contRadio = 1;

if (!isset($_GET['pg'])) {
    $_GET['pg'] = 0;	
}
$inicial =  $_GET['pg'] * $numreg;

if(isset($_GET['ex'])){
	//$sql = $_SESSION['consulta'];
	$quantreg = $cp->contar($_POST['nome'],$_POST['cpf']);
	$totalLinhas = $quantreg;
	$_GET['ex'] = null;
}else{
	$quantreg = $cp->contar($_POST['nome'],$_POST['cpf']);
	$totalLinhas = $quantreg;
	//$_SESSION['consulta'] = $sql;
}

$sql = "LIMIT $inicial, $numreg";
$cor = "CCCCCC";


$lista = $cp->listar(null,$_POST['nome'],$_POST['cpf'],$sql);

?>

<table width="80%" border = "1px" >
<tr>
	<td width="15px"> &nbsp; </td>	
	<td width="10px"><Strong>Cod:</Strong></td>
	<td><Strong>NOME:</Strong></td>
	<td><Strong>CPF:</Strong></td>
	<td><Strong>DATA ÚLTIMA AVALIAÇÃO:</Strong></td>
	
</tr>
<?php
foreach($lista as $c ){
	if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";} //#FFA07A


	
?>
<tr style="cursor:pointer;" onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''" bgcolor="<?php echo $cor ?>" onclick="marcaRadioPaciente('<?php echo $contRadio; ?>','<?php echo $c['id_Paci']; ?>');" onDblClick="verPaciente('<?php echo $c['id_Paci']; ?>')">

	<td>
		<div align="center">
			<input type="radio" id="id_<?php echo $contRadio; ?>" name="paciente" value="<?php echo $c['id_Paci']; ?>" onClick="carregaPaciente('<?php echo $c['id_Paci']; ?>');"/>
		</div>
	</td>
	<td width="10px"><?php echo $c['id_Paci']; ?></td>
	<td><?php echo $c['nome']; ?></td>
	<td><?php echo $c['cpf']; ?></td>	
	<td><?php echo implode("/",array_reverse(explode("-",$c['data']))); ?></td>
</tr>
<?php 
$contRadio ++;
} ?>
</tbody>
	<tfoot>
		<th	colspan="9"  cellspacing="0" cellpadding="0">
			<?php include("paginacaoAjax.php"); ?>											
		</th>
	</tfoot>
</table>