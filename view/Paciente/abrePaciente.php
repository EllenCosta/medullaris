<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

@require("../../control/controlPaciente.php");
$cp = new ControlPaciente();
$lista = $cp->listar($_POST['id'],null,null,null,null);

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script type="text/javascript" src="../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery.form.js"></script>
		<script type="text/javascript" src="../jquery/js/jquery.maskedinput.js"></script>
		<title>paciente</title>
	<style>
		#see{
			border: solid 1px;
			/*margin: 22px;*/
		}
		#box{
			
			/*margin: 20px;*/
		}
		.rotulo{
			padding: 1px;
			margin-left:5px;
			font-family: Verdana, Arial, "Times New";
			position:absolute;
		}
		.rot{
			padding: 1px;
			margin-left:5px;
			font-family: Arial, "Times New";
			font-size: 12px;
			position:absolute;
		}
		.campos_formulario{
			width: 270px;
		    margin-left:120px;
		    float:left;
		    position: absolute;
		}
		.campos{
			width: 35%;
		    margin-left:1%;
		    margin-top: 0%;
		    float:left;
		    position: absolute;
		}

	</style>
	</head>
	<body>
		<form >
			<?php
			foreach($lista as $c ){
				$nome = $c['nome'];
			?>

			<div id="see" aling="center" width="450" heigth="600">

				<div id="box">
					
					<p>	
						<br>
						<label for="id1" class="rotulo">Cod:</label>
						<input type="text" name="id1" id="id1" class="campos_formulario" readonly value ="<?php echo $c['id_paciente']; ?>" >
						<br>
					</p>
					
					<p>
						<br>
						<label for="nome1" class="rotulo">Nome:</label>
						<input type="text" name="nome1" id="nome1" class="campos_formulario" value ="<?php echo $c['nome']; ?>">
						<br>
					</p>
					
					<p>
						<br>
						<label for="cpf1" class="rotulo">CPF:</label>
						<input type="text" name="cpf1" id="cpf1" class="campos_formulario" maxlength="14" value ="<?php echo $c['cpf']; ?>">
						<br>
					</p>
					
					<p>
						<br>
						<label for="telefone" class="rotulo">Telefone:</label>
						<input type="text" name="telefone" id="telefone" maxlength="14"  class="campos_formulario" value ="<?php echo $c['telefone']; ?>">
						<br>
					</p>
					
					<p>
						<br>
						<label for="psms" class="rotulo">Data Primeiro SMS:</label>			
						<input type="text" name="psms" id="psms" class="campos_formulario" readonly value ="<?php echo implode("/",array_reverse(explode("-",$c['pSMS']))); ?> ">
						<br>
					</p>
					
					<p>
						<br>
						<label for="usms" class="rotulo">Data Ultimo SMS:</label>				
						<input type="text" name="usms" class="campos_formulario" readonly id="usms" value ="<?php echo implode("/",array_reverse(explode("-",$c['uSMS']))); ?>" >		
						<br>
					</p>
					<br>
					
					<p>
						
						<br>
						<label for="status" class="rot"><strong>Desativado:</strong></label>
						<?php if($c['status'] == "I"){ ?>
						<input type="checkbox" name="status-paci" id="status-paci" maxlength="14" class="campos" value ="I" checked="yes">
						<?php } else { ?>
						<input type="checkbox" name="status-paci" id="status-paci" maxlength="14" class="campos" value ="I" >
						<?php } ?>
						<br>
						<br>
					</p>

				</div>
				

			</div>	

			<?php 

			} ?>
		</form>
	</body>
</html>
