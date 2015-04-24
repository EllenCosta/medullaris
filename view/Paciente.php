<!DOCTYPE html>
<?php
require "../controlaSessao.php"
if(!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php");
}
include_once '../control/controlPaciente.php';
$cp = new ControlPaciente();
$cp->inserir($_POST["nome"],$_POST["cpf"],$_POST["dor"]);
?>

<html>
    <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width-device-width, initial-scale=1">
            <link rel="stylesheet" href="../jquery/css/jquery.mobile-1.4.5.min.css">
            <link rel="stylesheet" href="../jquery/css-mobile/themes/mobile.min.css" />
            <link rel="stylesheet" href="../jquery/css-mobile/themes/jquery.mobile.icons.min.css" />
            <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile.structure-1.4.2.min.css" />
            <script type="text/javascript" src="../jquery/js/jquery-1.9.1.js"></script>
            <script type="text/javascript" src="../jquery/js/jquery-ui-1.9.2.custom.min.js"></script>
            <script type="text/javascript" src="../jquery/js/jquery.mobile-1.4.5.min.js"></script>
            <script type="text/javascript" src="../jquery/js/jquery.animateSprite.min.js"></script>
            <script type="text/javascript" src="../jquery/js/jquery.maskedinput.js"></script>
        <title> Clinica </title>

        <style type="text/css">
            .face {
                height: 91px;
                width: 75px;
                background-image:url(face.jpg);
            }
            .botao{
                height: 69px;
                width: 69px;

            }
        </style>

        <script>
            $(function(){

                $("#cpf").mask("999.999.999-99");

                $(".face").animateSprite({
                    fps: 10,
                    animations: {
                        anim: [0]                       
                    },
                    loop: false,
                });
            
               
               $("#div-slider").change(function() {
                    var slider_value = $("#dor").val();
                    $(".face").animateSprite('frame', slider_value);
                });

                $( '#ok' ).click( function(){

                    if(document.getElementById("cpf").value == ""){

                        alert("digite seu cpf!");
                        document.getElementById("cpf").focus();

                    }else{
                        $.ajax({
                            type: 'POST',
                            url: "requisicao.php?",
                            data: {cpf : $( '#cpf' ).val()},
                            success: function(retorno){
                                if(retorno != ""){
                                    $( '#nome' ).val( retorno );
                                    document.getElementById('nome').setAttribute('readonly',true);
                                }else{
                                    $( '#nome' ).val( retorno );
                                    //document.getElementById('nome').setAttribute('readonly',false);
                                }
                            }
                        });
                    }
                        
                 });

                   $( '#salvar' ).click( function(){

                     if(document.getElementById("nome").value == "" || document.getElementById("dor").value == "0"){

                        alert("todos os campos devem ser prenchidos");

                        }else{

                            $.ajax({
                                type: 'POST',
                                url: "inserirPaciente.php?",
                                data: {nome : $( '#nome' ).val(), cpf : $( '#cpf' ).val(), dor : $( '#dor' ).val()},
                                success: function(retorno){
                                    //document.getElementById("msg").innerHTML = "Operacao realizada com sucesso!";
                                   // $( "#confirma" ).dialog( "open" );
                                    alert("Operacao realizada com sucesso!");
                                    document.getElementById('nome').value = "";
                                    document.getElementById('cpf').value = "";
                                    document.getElementById('dor').value =0;
                                }
                            });
                        }
                    });


                 $( '#nome' ).click( function(){
                    if(document.getElementById("cpf").value == ""){
                        alert("Digite seu cpf");
                        document.getElementById("cpf").focus();
                    }
                 });

                $( "#confirma" ).dialog({
                    modal: true,
                    autoOpen: false,
                    resizable: false,
                    show:  {effect: "fade", duration: 200}, 
                    hide:  {effect: "fade", duration: 200},
                    
                    buttons: {
                        "salvar": function() {
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


            <div data-role="page" data-theme="a">

                <div data-role="header" data-position="inline">
                    <h2>INFORME OS DADOS</h2>
                </div>

                <div data-role="content" data-theme="a">

                    <form id="form1" name="form1">
                        
                        <table>
                            <tr>
                              CPF:  <td width="970px"><input id="cpf" name="cpf" type="text" title="Qual seu CPF?" maxlength="14"></td>
                                <td width="80px">
                                    <div align="right">
                                        <div id="botao" class="botao">
                                            <label>
                                                <input type="button" name="ok" id="ok" value="OK" data-role="button" data-inline="true" data-position="center" />
                                            </label> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                            
                            
                             
                        <p>Nome: 
                            <label for="nome">
                                <input type="text" name="nome" id="nome"/>
                            </label>
                        </p>

                        <p>
                            <div align="center">
                                <div id="face" class="face"></div>
                            </div>

                            <div id="div-slider">
                                <label for="dor">Dor:</label>
                                <input type="range" name="dor" id="dor" min="0" max="10" data-theme="a" readonly />
                            </div>

                            <label>
                                <input type="button" name="salvar" id="salvar" value="Salvar" />
                            </label>
                        </p>
                    

                       

                    </form>
                        <div id="confirma" title="Atencao">
                            <p>                     
                                <h3><label id="msg" /></h3>
                            </p>                    
                        </div>  
                </div>

            </div>
            

        
    </body>
</html>
