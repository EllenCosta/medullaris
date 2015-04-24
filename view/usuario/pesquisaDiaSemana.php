<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include '../../control/controlHorario.php';
include '../../model/modelHorario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$horario = new modelHorario();
$cor = "CCCCCC";
$contRadio = 1;
$dia_semana = $_GET['dia_semana'];
$id_usuario = $_GET['id_usuario'];
$sql = "select * from horario_login where id_usuario = '$id_usuario' ";
if($dia_semana != ""){
	$sql = $sql . " and dia_sem = '$dia_semana' ";
}
$sql = $sql." order by dia_sem ";
//echo $sql;
?>
<table width="100%" border = "0">
<tr>
	<td width="20px"> &nbsp; </td>	
	<td><Strong>Dia da Semana</Strong></td>
	<td><Strong>Hora Inicial</Strong></td>	
	<td><Strong>Hora Final</Strong></td>	
</tr>
<?php
//echo "&nbsp;";

foreach ($horario->listar($sql) as $h ) {
	if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";}
	$dia_sem = "";
	if($h['dia_sem'] == "1"){
		$dia_sem = "Domingo";
	}
	if($h['dia_sem'] == "2"){
		$dia_sem = "Segunda";
	}
	if($h['dia_sem'] == "3"){
		$dia_sem = "Terça";
	}
	if($h['dia_sem'] == "4"){
		$dia_sem = "Quarta";
	}
	if($h['dia_sem'] == "5"){
		$dia_sem = "Quinta";
	}
	if($h['dia_sem'] == "6"){
		$dia_sem = "Sexta";
	}
	if($h['dia_sem'] == "7"){
		$dia_sem = "Sabado";
	}
?>
<tr style="cursor:pointer;" onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''" bgcolor="<?php echo $cor ?>" onclick="marcaRadioHorario('<?php echo $contRadio; ?>','<?php echo $h['id_horario_login']; ?>');" >
	<td>
		<div align="center">
			<input type="radio" id="sel<?php echo $contRadio; ?>" name="sel" value="<?php echo $h['id_horario_login']; ?>" onClick="carregaHorario('<?php echo $h['id_horario_login']; ?>');"/>
		</div>
	</td>
	<td><?php echo $dia_sem; ?></td>	
	<td><?php echo $h['hora_ini']; ?></td>	
	<td><?php echo $h['hora_fim']; ?></td>	
</tr>
<?php 
$contRadio ++;
} ?>

</table>

