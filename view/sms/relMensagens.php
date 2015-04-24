<?php
require "../../controlaSessao.php";
include_once '../../control/controlParametros.php';
header("Content-Type: text/html;  charset=ISO-8859-1",true);

session_start();
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
}
$_SESSION['inclui'] = "t";

$parametros = new ControlParametros();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
		<link href="../../jquery/css/main.css" rel="stylesheet" type="text/css" />
		<link href="../../jquery/css/rodape.css" rel="stylesheet" type="text/css" />	

		<script type="text/javascript" src="../../jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>		
		<script type="text/javascript" src="../../jquery/js/jquery.form.js"></script>
		<link type="text/css" href="../../jquery/css/redmond/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

		<script language="javascript" type="text/javascript">
			google.load("visualization", "1", { packages: ["corechart"] });

			$(function() {
				$( "#ini, #fim" ).datepicker({
					dateFormat: 'dd/mm/yy',
					dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
					dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
					monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
					nextText: 'Próximo',
					prevText: 'Anterior'
				});
				
				function pesquisa(){
					var ini = document.getElementById("ini").value;
					//split = ini.split('/');
					//novaIni = split[1] + "-" +split[0]+"-"+split[2];
					
					var fim = document.getElementById("fim").value;
					//split2 = fim.split('/');
					//novaFim = split2[1] + "-" +split2[0]+"-"+split2[2];
					
					$.ajax({
						url: "mensagens.php?ini="+ini+"&fim="+fim,
						dataType: 'json',
					})
					.done(function( data ) {
						//console.log(data);						
						var html = "";
						var cor = 'CCCCCC';
						var qtd = 0;
						var dataAtual = "";
						var qtdDia = 1;
						var successData = '[["Dia","Total"]'; //,["Dia 1",0]
						html += "<table><tr><td height='25px'><strong>Para</strong></td><td><strong>Mensagem</strong></td><td><strong>Status</strong></td><td><strong>Data/Hora</strong></td>";
						$(jQuery.parseJSON(JSON.stringify(data))).each(function() {
							qtd++;
							if(cor == 'CCCCCC'){ cor = 'EEF0EE'; }else{	cor = 'CCCCCC';	}
							/////calcula o grafico							
							if(dataAtual == this.RequestDate.substring(8,10)+"/"+this.RequestDate.substring(5,7) && this.Status == 1){
								qtdDia++;								
							}else{
								if(dataAtual != "" && this.Status == 1){
									successData = successData + ',["Dia '+dataAtual+'",'+qtdDia+']';
								}
								dataAtual = this.RequestDate.substring(8,10)+"/"+this.RequestDate.substring(5,7); // 01/01
								if(this.Status == 1){
									qtdDia = 1;
								}								
							}							
							/////////
							var dt = this.RequestDate.substring(8,10)+"/"+this.RequestDate.substring(5,7)+"/"+this.RequestDate.substring(0,4)+" "+this.RequestDate.substring(11,19);
							html += "<tr bgcolor='"+cor+"'><td>"+this.Receiver+"</td><td>"+this.Content+"</td><td>"+this.SystemMessage+"</td><td>"+dt+"</td></tr>";
							//console.log(this.Status);
						});	
						//finaliza o ultmo dia do grafico
						if(qtdDia != ""){
							successData = successData + ',["Dia '+dataAtual+'",'+qtdDia+']';
						}
						
						html += "<tr><td colspan='4' align='left' height='25px'><strong>Total "+qtd+"</strong></td></tr>";
						html += "</table>";
						document.getElementById("retorno").innerHTML=html;
						
						//gera o grafico
						successData = successData + ']';
						var obj = $.parseJSON(successData);
						//console.log(successData);
						var chartData = google.visualization.arrayToDataTable(obj);
						var view = new google.visualization.DataView(chartData);
						view.setColumns([0, 1,
								   { calc: "stringify",
									 sourceColumn: 1,
									 type: "string",
									 role: "annotation" }]);
						chart = new google.visualization.ColumnChart($("#SentByDayChart")[0]);
						var options = {
							series: { 1: { type: "line" } },
							legend: {position: "none"},
							bar: {groupWidth: "60%"},
							height: 300
						};
						
						chart.draw(view, options);
						
					})
					.fail(function( msg ) {
						//console.log(msg.responseText);
						//alert( "Aguarde 30 segundos para a proxima consulta<br>"+msg.responseText);
						document.getElementById("msg").innerHTML="Não foi possivel fazer a pesquisa. Verifique se o intervalo não ultrapassa 45 dias ou se a última pesquisa foi realizada em menos de 30 segundos.";
						$( "#confirma" ).dialog( "open" );
					});
				}
				
				$( "#pesq" ).button().click(function(){
					if(document.getElementById("ini").value == "" || document.getElementById("fim").value == ""){						
						//alert("Preencha as datas inicial e final");
						document.getElementById("msg").innerHTML="Preencha as datas inicial e final";
						$( "#confirma" ).dialog( "open" );
					}else{
						pesquisa();
					}
				});
				
				$( "#confirma" ).dialog({
					modal: true,
					autoOpen: false,
					resizable: false,
					show:  {effect: "fade", duration: 200}, 
					hide:  {effect: "fade", duration: 200},
					
					buttons: {
						"Ok": function() {
							$( this ).dialog( "close" );
						},											
					},
					
					close: function(){
						
					}
				});
				
			});
		</script>		
  </head>

   <body>						
		<div id="tudo">
			<div id="conteudo">
				<div id="topo">
					<?php include("../menu/menu.php"); ?>
				</div>
				<div id="main">	
					<div id="conteiner">		
						<div class="bg_area_login" align="center">
							<h2>Lista de SMS enviados</h2>
							<div class="tabelaSimples">
								<table width="70%">
									<tr>
										<td>Data Inicial <input type="text" name="ini" id="ini" readonly /></td>
										<td>Data Final <input type="text" name="fim" id="fim" readonly /></td>
										<td><input type="button" name="pesq" id="pesq" value="Pesquisar" /></td>
									</tr>
								</table>
								<table width="70%" id="retorno">
									
								</table>
							</div>
							
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<strong>Envios Por Dia (Este M&#234;s)</strong>
										</div>
										<div id="SentByDayChart" class="panel-body"></div>                                
									</div>
								</div>
							</div> 

						</div>
					</div>
					
					<div id="confirma" title="Atenção">
						<p>						
							<h3><label id="msg" value=""/></h3>
						</p>					
					</div>
					
				</div>
				<div class="clear"></div>
			</div>
			<div  id="bg_rodape">
				<?php include("../rodape.php"); ?>
			</div>
		</div>			
   </body>

</html>
