<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
$_SESSION['inclui'] = "n";
include_once '../../control/controlUsuario.php';
include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

$id = $_POST['id'];

$sql = "select * from usuario,grupo where usuario.id_grupo = grupo.id_grupo and usuario.id_usuario = '$id'";
$sql2 = "select * from grupo order by id_grupo";

$usuario = new ControlUsuario();
$grupoUsuario = new ControlGrupoUsuario();

?>

<div>
	<div class="bg_area_login" align="center">
		<h2>Edição de Usuário</h2>

		<div>
			<?php foreach ($usuario->listar($sql) as $usuario){ ?>
			<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario['id_usuario'];?>" />
			<table width="100%">
				<tr>
					<td colspan="2"> &nbsp; </td>
				</tr>										
				<tr>
					<td align="right" width="30%">Nome Usuário</td>
					<td align="left"><input width="80%" type="" name="nome-alt" id="nome-alt" value = "<?php echo $usuario['nome'] ?>" class="maiusculo"/></td>
				</tr>
				<tr>
					<td align="right">Login</td>
					<td align="left"><input type="text" name="login-alt" id="login-alt" value = "<?php echo $usuario['login'] ?>" class="maiusculo" onblur="verificaDisp();"/></td>
				</tr>
				<tr>
					<td align="right">Master</td>
					<?php if($usuario['master'] == "S"){ ?>
						<td align="left"><input type="checkbox" name="master" id="master-alt" value="S" checked="yes"/></td>
					<?php } else { ?>
						<td align="left"><input type="checkbox" name="master" id="master-alt" value="S"/></td>
					<?php } ?>
				</tr>
				<tr>
					<td align="right">Senha</td>
					<td align="left">
						
					<input type="password" name ="senha-alt" id="senha-alt" disabled />
					Alterar Senha<input type="checkbox" name="altera" id="altera" value="S" onclick="bloqueiaSenha();"/>
						
					</td>
				</tr>
				<tr>
					<td align="right">Grupo</td>
					<td align="left">
						<select name = "id_grupo_alt" id="id_grupo_alt">
							<?php foreach ($grupoUsuario->listar($sql2) as $grupo){
								if($grupo['id_grupo'] == $usuario['id_grupo']){	?>
									<option value="<?php echo $grupo['id_grupo'] ?>" selected><?php echo $grupo['descricao'] ?></option>
							<?php }else {?>
									<option value="<?php echo $grupo['id_grupo'] ?>"><?php echo $grupo['descricao'] ?></option>
							<?php } } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Desativado</td>
					<?php if($usuario['status'] == "I"){ ?>
						<td align="left"><input type="checkbox" name="status-alt" id="status-alt" value="I" checked="yes"/></td>
					<?php } else { ?>
						<td align="left"><input type="checkbox" name="status-alt" id="status-alt" value="I"/></td>
					<?php } ?>
				</tr>
				<tr>
					<td align="right">Usuário Genérico</td>
					<?php if($usuario['generico'] == "S"){ ?>
						<td align="left"><input type="checkbox" name="generico_alt" id="generico_alt" value="S" checked="yes"/></td>
					<?php } else { ?>
						<td align="left"><input type="checkbox" name="generico_alt" id="generico_alt" value="S"/></td>
					<?php } ?>
				</tr>
				<tr>
					<td align="right">Horários de Login</td>
					<td align="left">
						<input type="button" name="pesq-horarios" id="pesq-horarios" value="..." title="Horários de Login"/>
					</td>
				</tr>
				<?php } ?>
			</table>											
		</div>
	</div>
</div>
	