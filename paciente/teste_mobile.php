<?php
include('mobile_device_detect.php');
mobile_device_detect(true,true,true,true,true,true,'mobile.html',false);
@require("PDOConnectionFactory.class.php");

?>
<html>
	<head>
		<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="jquery/jquery.animateSprite.min.js"></script>
		<style type="text/css">
			.face {
				height: 53px;
				width: 68px;
				background-image: url(images/carinhas.jpg);
			}
		</style>
		<script>
			$(function(){								
				$(".face").animateSprite({
					fps: 12,
					animations: {
						anim: [0,1,2,3,4,5,6,7,8,9,10]						
					},
					loop: true,
				});
				
				$( "#goto" ).on('click', function(){
					$(".face").animateSprite('frame', 5);
				})
			});
		</script>
	</head>

	<body>
		<div id="face" class="face">
			<div data-role="page" data-theme="a">
				<div data-role="header" data-position="inline">
					<h1>Informe os Dados</h1>
				</div>
				<div data-role="content" data-theme="a">
					<!-- <p>Site Mobile</p> -->
					<form>
						<label for="nome" >Nome:</label>
						<input type="text" id="nome" name="nome" value=""/>
						<label for="cpf" >CPF:</label>
						<input type="text" id="cpf" name="cpf" value=""/>
						<div id="div-slider">
							<label for="slider1">Dor:</label>
							<input type="range" name="slider1" id="slider1" value="0" min="0" max="10" data-theme="a" readonly />
						</div>
						<div align="center">
							<div id="face" class="face"></div>
						</div>
						<input type="submit" value="Salvar" />				
					</form>
				</div>
			</div>
		</div>
	</body>
		
</html>
			
		</div>