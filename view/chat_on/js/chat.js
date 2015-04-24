$(function(){
	$('body').delegate('.mensagem', 'keydown', function(e){
		var campo = $(this);
		var mensagem = campo.val();
		var to = $(this).attr('id');
		
		if(e.keyCode == 13){
			if(mensagem != ''){
				$.post('chat_on/sys/chat2.php',{
					acao: 'inserir',
					mensagem: mensagem,
					para: to,
				}, function(retorno){
					//$('#jan_'+to+' ul.listar').append(retorno);
					$('#jan_'+to+' ul.listar').append(retorno).animate({scrollTop:$('#jan_'+to+' ul.listar').height()*1000}, 500);
					campo.val('');
				});
				
			}
		}
	})
});