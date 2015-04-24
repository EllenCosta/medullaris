<?php
require "../../controlaSessao.php";
@require("../../control/controlPaciente.php");
@require("../../control/controlParametros.php");
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
$texto;
$param = new ControlParametros();
$msg = $param->listar("select * from parametros where id_parametros = 17");
foreach($msg as $p){
	$texto = utf8_decode($p['valor']);
}

//$texto = utf8_decode("clique no link para ser avaliado - http://admedsistemas.com.br/clinica/medullaris/paciente/");
$cp = new ControlPaciente();
$lista = $cp->listar($_POST['id'],null,null,null,null);

?>

<table width="100%" border = "0" >

<?php
foreach($lista as $c ){
	
?>
<div width="450" heigth="600" id="sms">
		<h2>Envio de SMS</h2>
		<?php $hoje = date('d-m-Y'); ?>

		<table width="100%">
			<tr>
				<td colspan="2"> &nbsp; </td>
			</tr>

			<tr>
				<td align="right" width="50%">Paciente:</td>
				<td align="left">
					<input type="text" name="paciente" id="paciente" value =<?php echo $c['nome']; ?>>
				</td>
			</tr>

			<tr>
				<td align="right" width="50%">Telefone:</td>
				<td align="left">
					<input type="text" name="fone" id="fone" value =<?php echo $c['telefone']; ?> />
				</td>
			</tr>

			<tr>
				<td colspan="2" align="center">
				<textarea id="conteudo_sms" name="conteudo_sms" cols="32" rows="5" maxlength="156" ><?php echo (ltrim($texto));?></textarea>
				</td>
			</tr>

			<tr>
				<td colspan="2" align="center" nowrap>
					Caracteres restantes <div id="qtd_char_sms" ></div>
				</td>
			</tr>
			<tr>
				<td align="left">
					<input type="hidden" name="dia" id="dia" value="<?php echo $hoje; ?>"/>
				</td>
			</tr>
		</table>

</div>
	

<?php 

} ?>
</table>