<style type="text/css">
.pgoff {font-family: Verdana, Arial, Helvetica; font-size: 11px; color: #FF0000; text-decoration: none}
a.pg {font-family: Verdana, Arial, Helvetica; font-size: 11px; color: #000000; text-decoration: none}
a:hover.pg {font-family: Verdana, Arial, Helvetica; font-size: 11px; color: #000000; text-decoration:underline}
</style>
<?php
        $quant_pg = ceil($quantreg/$numreg);
        $quant_pg++;
		$pg = $_GET['pg']+1;
        
        // Verifica se esta na primeira p�gina, se nao estiver ele libera o link para anterior
        if (  $_GET['pg']  > 0) { 			
            echo '<a href="#" class=pg onclick="paginacao('.($_GET['pg'] -1).')"><b>&laquo; anterior </b></a>';
        } else {
            echo "<font color=#CCCCCC>&laquo; anterior </font>";
        }
		if (  $_GET['pg']  > 3) {            
			echo '<a href="#" class=pg onclick="paginacao(0)"><b>1</b></a> ... ';
		}
        
		// Faz aparecer os numeros das p�gina entre o ANTERIOR e PROXIMO
        for($i_pg=$pg;$i_pg<$quant_pg;$i_pg++) {
				//imprindo o bot�o da p�gina antes da atual, ela necessita ser diferente da primeira p�gina				
				if (($i_pg - 1) == ($pg - 1) and ($i_pg - 1) != 0 and ($i_pg != 0) and ($i_pg > 3)) {
					echo '&nbsp;<a href="#" class=pg onclick="paginacao('.($i_pg-4).')"><b>'.($i_pg-3).'</b></a>&nbsp;';													
				}
				if (($i_pg - 1) == ($pg - 1) and ($i_pg - 1) != 0 and ($i_pg != 0) and ($i_pg > 2)) {
					echo '&nbsp;<a href="#" class=pg onclick="paginacao('.($i_pg-3).')"><b>'.($i_pg-2).'</b></a>&nbsp;';										
				}
				if (($i_pg - 1) == ($pg - 1) and ($i_pg - 1) != 0 and ($i_pg != 0) and ($i_pg > 1)) {
					echo '&nbsp;<a href="#" class=pg onclick="paginacao('.($i_pg-2).')"><b>'.($i_pg-1).'</b></a>&nbsp;';
				}
                // Verifica se a p�gina que o navegante esta e retira o link do n�mero para identificar visualmente
                if ( $_GET['pg']  == ($i_pg-1)) { 
                    echo "&nbsp;<span class=pgoff>[$i_pg]</span>&nbsp;";
                }
				//imprimindo a p�gina ap�s a p�gina atual
				if (($i_pg -1 < $pg) and ($pg != ($quant_pg-1))) {
					echo '&nbsp;<a href="#" class=pg onclick="paginacao('.$i_pg.')"><b>'.($i_pg+1).'</b></a>&nbsp;';
				}
				if (($i_pg -1< $pg) and ($pg <= ($quant_pg-3))) {
					echo '&nbsp;<a href="#" class=pg onclick="paginacao('.($i_pg+1).')"><b>'.($i_pg+2).'</b></a>&nbsp;';
				}
				if (($i_pg -1 < $pg) and ($pg <= ($quant_pg-4))) {
					echo '&nbsp;<a href="#" class=pg onclick="paginacao('.($i_pg+2).')"><b>'.($i_pg+3).'</b></a>&nbsp;';
				}
        }	
        //mostra a ultima pagina se n�o estiver na penultima
		if (( $_GET['pg'] + 5) < $quant_pg) {
			echo ' ... <a href="#" class=pg onclick="paginacao('.($quant_pg-2).')"><b>'.($quant_pg-1).'</b></a>';
		}
        // Verifica se esta na ultima p�gina, se nao estiver ele libera o link para pr�xima
        if (( $_GET['pg'] +2) < $quant_pg) { 
                echo '<a href="#" class=pg onclick="paginacao('.($_GET['pg'] +1).')"><b> pr�ximo &raquo;</b></a>';
        } else { 
                echo "<font color=#CCCCCC> pr�ximo &raquo;</font>";                
        }		
?>