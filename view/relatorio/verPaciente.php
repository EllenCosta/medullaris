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


if (isset($_POST['id'])) {
   	$id = $_POST['id'];
}


if (isset($_GET['id'])) {
   	$id = $_GET['id'];
}

if (!isset($_GET['pg'])) {
    $_GET['pg'] = 0;	
}
$inicial =  $_GET['pg'] * $numreg;

if(isset($_GET['ex'])){
	//$sql = $_SESSION['consulta'];
	$quantreg = $cp->conte("select * from paciente,dados where paciente.id_paciente=dados.id_Paci and paciente.id_paciente = ".$id);
	$totalLinhas = $quantreg;
	$_GET['ex'] = null;
}else{
	$quantreg = $cp->conte("select * from paciente,dados where paciente.id_paciente=dados.id_Paci and paciente.id_paciente = ".$id);
	$totalLinhas = $quantreg;

	//$_SESSION['consulta'] = $sql;
}

$sql = "LIMIT $inicial, $numreg";

$cor = "CCCCCC";

$lista = $cp->listar($id,null,null,$sql);

?>


<table width="100%" cellspacing="2" cellpadding="10">

	<tr align="center">
		<td width="10%" height="25%"><Strong>Cod:</Strong></td>
		<td width="15%"><Strong>NOME:</Strong></td>
		<td width="15%"><Strong>CPF:</Strong></td>
		<td width="15%"><Strong>N° AVALIAÇÃO:</Strong></td>
		<td width="15%"><Strong>DOR:</Strong></td>
		<td width="15%"><Strong>DATA DA AVALIAÇÃO:</Strong></td>
	</tr>
	<br>


<?php
foreach($lista as $c ){
	if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";} //#FFA07A
?>

	<tr align="center" style="cursor:pointer;" onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''" bgcolor="<?php echo $cor ?>">

		<td width="10%" height="25%"><?php echo $c['id_dados']; ?></td>
		<td width="15%"><?php echo $c['nome']; ?></td>
		<td width="15%"><?php echo $c['cpf']; ?></td>	
		<td width="15%"><?php echo $c['avaliacao']; ?></td>	
		<td width="15%"><?php echo $c['dor']; ?></td>
		<td width="15%"><?php echo implode("/",array_reverse(explode("-",$c['data']))); ?></td>
	</tr>


<?php 
$contRadio ++;
} ?>
</tbody>
	<tfoot>
		<th	colspan="9"  cellspacing="0" cellpadding="0">
			<?php include("paginacao.php"); ?>										
		</th>
	</tfoot>
</table>