<?php
include 'dao/controlPaciente.php';

$cp = new ControlPaciente();
$avaliacao = $cp->avaliacao($_POST["cpf"],$_POST['dor']);
if($avaliacao == 1){
	echo "<font color='#228B22'>Avaliação realizada com sucesso!!!</font>";
}

else{
	echo "<font color='#B22222'>Próxima avaliação: ".$avaliacao."</font>";
	
}

?>