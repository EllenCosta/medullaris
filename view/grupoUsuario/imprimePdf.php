<?php
require "../../controlaSessao.php";
session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}

include_once '../../control/controlGrupoUsuario.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

require('../fpdf16/fpdf.php');

class PDF extends FPDF{

function LoadData(){	
	$grupoUsuario = new ControlGrupoUsuario();

    $data=array();	
    foreach ($grupoUsuario->listar("select * from grupo") as $u){  					
        $data[]=explode(';',chop($u['id_grupo'].";".$u['descricao']));        
	}
    return $data;
}

function Header(){    
    //$this->Image('images/logo_admed4.png',10,8,33);    
    $this->SetFont('Arial','B',12);        
    $this->Cell(192,10,'Lista de Grupos de Usuários',1,0,'C');    
    $this->Ln(20);
}

function geraTabela($header,$data){
    
    $this->SetFillColor(255,255,255);
    //$this->SetTextColor(255);
    //$this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('Arial','B',10);
    
    $w=array(20,172);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    
    $fill=false;
    foreach($data as $row){
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        //$this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
        //$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}

function Footer(){
    $this->SetY(-15);    
    $this->SetFont('Arial','I',8);    
    $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'R');
}
}

$pdf=new PDF();

$header=array('Código','Descrição');

$data=$pdf->LoadData();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->geraTabela($header,$data);
$pdf->Output();

?>