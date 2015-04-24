<?php
require "../../controlaSessao.php";

session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);
$_SESSION['inclui'] = "u";
$id = $_POST['id'];

$sql = "select * from grupo where id_grupo = '$id'";


$grupoUsuario = new ControlGrupoUsuario();

?>
<div>
		<?php foreach ($grupoUsuario->listar($sql) as $grupo){ ?>
		<input type="hidden" name="id_grupo" value="<?php echo $grupo['id_grupo'];?>" />
		<table width="100%">
			<tr>
				<td colspan="2"> &nbsp; </td>
			</tr>	
			<br>									
			<tr>
				<td align="right" width="50%"><h5>Descrição</h5></td>
				<td align="left"><input type="text" id="descricao" name="descricao" value = "<?php echo $grupo['descricao']  ?>" class="maiusculo"/></td>
			</tr>
			<tr>
				<td colspan="2"> &nbsp; </td>
			</tr>	
			<?php } ?>
		</table>											
</div>
