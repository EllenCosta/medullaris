<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
include_once '../../control/controlUsuario.php';
include_once '../../control/controlGrupoUsuario.php';

header("Content-Type: text/html;  charset=ISO-8859-1",true);


$grupoUsuario= new ControlGrupoUsuario() ;
$sql = null;$usuario = new ControlUsuario();


$numreg = 10;
$totalLinhas = 0;
$imp = true;

if (!isset($_GET['pg'])) {
    $_GET['pg'] = 0;	
}
$inicial =  $_GET['pg'] * $numreg;

$sql = "select * from usuario,grupo where usuario.id_grupo = grupo.id_grupo ";
if(isset($_POST["nome"])){
	$nome = $_POST["nome"];	
}
if(!empty($nome)) { 
	$sql = $sql." and usuario.nome like '%$nome%' ";
}
if(isset($_POST['status'])){
	$status = $_POST['status'];
}
if(!empty($status)) {
	$sql = $sql." and usuario.status = '$status' ";
}
if(isset($_POST['id_grupo'])){
	$id_grupo = $_POST['id_grupo'];	
}
if(!empty($id_grupo)) { 
	$sql = $sql." and usuario.id_grupo = '$id_grupo' ";
}

$quantreg = $usuario->contar($sql);
$totalLinhas = $quantreg;
$sql = $sql." order by nome ";
$_SESSION['consulta'] = $sql;
$imp = true;
$sql = $sql. "LIMIT $inicial, $numreg";

?>
<table width="100%">
	<thead>
		<tr>
			<th><Strong>Codigo</Strong></th>
			<th><Strong>Nome</Strong></th>
			<th><Strong>Master</Strong></th>
			<th><Strong>Grupo</Strong></th>
			<th><Strong>Status</Strong></th>
			<th><Strong>Alterar</Strong></th>
			<th><Strong>Excluir</Strong></th>
		</tr>
	</thead>
	<tbody>
	<?php 
		//if(isset($_POST["pesq"])){
			$cor = "CCCCCC";
			foreach ($usuario->listar($sql) as $usuario){
				if ($cor == "CCCCCC"){ $cor = "EEF0EE";}else{ $cor = "CCCCCC";}	
		?>
	<tr style="cursor:pointer;" onMouseOver="javascript:this.style.backgroundColor='#87CEFA'" onmouseout="javascript:this.style.backgroundColor=''"  onDblClick="pesquisaUsuario('<?php echo $usuario['id_usuario'] ?>')" bgcolor="<?php echo $cor ?>" >
		<td><?php echo $usuario['id_usuario'] ?></td>
		<td><?php echo $usuario['nome'] ?></td>
		<td><?php if($usuario['master'] == "S"){ echo "Sim";} else { echo "Não"; } ?></td>
		<td><?php echo $usuario['descricao'] ?></td>
		<td><?php if($usuario['status'] == "A"){echo "Ativo";}else{ echo "Inativo"; } ?></td>
		<td align="center">
			
				<a id ="alterar" href="#" >
					<img src="../../jquery/css/images/alterar.png" alt="Alterar" title="Alterar" width="23" height="22" border="0" onClick="carregaUsuario('<?php echo $usuario['id_usuario'] ?>');">
				</a>
			
		</td>
		<td align="center">
		
				<a id="excluir" href="#" >
					<img src="../../jquery/css/images/excluir.png" alt="Excluir" title="Excluir" width="23" height="22" border="0" onClick="carregaUsuario('<?php echo $usuario['id_usuario'] ?>');">
				</a>
			
		</td>
	</tr>
	<?php }  ?>
	</tbody>
	<tfoot>
		<th	colspan="7"  cellspacing="0" cellpadding="0">
			<?php include("paginacaoAjax.php"); ?>									
		</th>
	</tfoot>
</table>