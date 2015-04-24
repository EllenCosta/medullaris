<?php
require "../controlaSessao.php";
session_start();
header("Content-Type: text/html;  charset=ISO-8859-1",true);
@require("../DAO/PDOConnectionFactory.class.php");
@require("../DAO/ImpressosDao.class.php");

$contRadio = 1;
$sql = "select * from modelo_sms";

//echo $sql;
$impressosDao = new ImpressosDao();
$cor = "CCCCCC";
?>

<table width="100%" border = "0">
<tr>
	<td width="20px"> &nbsp; </td>	
	<td><Strong>Descri&ccedil;&atilde;o</Strong></td>
</tr>
<?php

foreach ($impressosDao->listar($sql) as $m ) {
	if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";} //#FFA07A	
?>
<tr style="cursor:pointer;" onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''" bgcolor="<?php echo $cor ?>" onclick="marcaRadio2('<?php echo $contRadio; ?>','<?php echo $m['descricao']; ?>','<?php echo $m['id_modelo_sms'] ?>');" onDblClick="$( '#form-pesq-imp' ).dialog( 'close' );" >
	<td>
		<div align="center">
			<input type="radio" id="sel2<?php echo $contRadio; ?>" name="sel2" value="<?php echo $m['descricao']; ?>" onClick="carregaImp('<?php echo $m['descricao']; ?>','<?php echo $m['id_modelo_sms'] ?>');"/>
		</div>
	</td>
	<td><?php echo $m['descricao']; ?></td>
</tr>
<?php 
$contRadio ++;
} ?>

</table>

