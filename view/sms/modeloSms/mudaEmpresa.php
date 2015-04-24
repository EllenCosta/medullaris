<?php
require "../controlaSessao.php";

header("Content-Type: text/html;  charset=ISO-8859-1",true);
session_start();

if(!isset($_SESSION['id_usuario'])) {
	header("Location: ../".$_SESSION['cliente']."/index.php");
}
@require("../DAO/PDOConnectionFactory.class.php");
@require("../DAO/SalasDao.class.php");

$salasDao = new SalasDao();

$id_empresa = $_GET['idEmpresa'];
$sql = "select * from salas where id_empresa = '$id_empresa'"; 

foreach($salasDao->listar($sql) as $ag){ ?>
	<option value="<?php echo $ag['id_salas']; ?>"><?php echo $ag['desc_sal']; ?></option>
<?php } ?>
