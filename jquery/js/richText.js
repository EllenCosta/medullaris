var myEditor = new YAHOO.widget.Editor('texto', {
	height: '200px',
	width: '100%px',
	dompath: false,
	animate: true,
	
	toolbar: {		
		draggable: false,
		buttonType: 'advanced',
		buttons: [
			{ group: 'fontstyle', label: 'Nome da Fonte e Tamanho',
				buttons: [
					{ type: 'select', label: 'Arial', value: 'fontname', disabled: true,
						menu: [
							{ text: 'Arial', checked: true },
							{ text: 'Arial Black' },
							{ text: 'Comic Sans MS' },
							{ text: 'Courier New' },
							{ text: 'Lucida Console' },
							{ text: 'Tahoma' },
							{ text: 'Times New Roman' },
							{ text: 'Trebuchet MS' },
							{ text: 'Verdana' }
						]
					},
					{ type: 'spin', label: '13', value: 'fontsize', range: [ 9, 75 ], disabled: true }
				]
			},
			{ type: 'separator' },
			{ group: 'textstyle', label: 'Estilo da Fonte',
				buttons: [
					{ type: 'push', label: 'Negrito CTRL + SHIFT + B', value: 'bold' },
					{ type: 'push', label: 'Italico CTRL + SHIFT + I', value: 'italic' },
					{ type: 'push', label: 'Sublinhado CTRL + SHIFT + U', value: 'underline' },
					{ type: 'push', label: 'Tachado CTRL + SHIFT + S', value: 'strikethrough' },
					{ type: 'separator' },
					{ type: 'push', label: 'Subscrito', value: 'subscript', disabled: true },
					{ type: 'push', label: 'Sobrescrito', value: 'superscript', disabled: true },
					{ type: 'separator' },
					{ type: 'color', label: 'Cor da Fonte', value: 'forecolor', disabled: true },
					{ type: 'color', label: 'Cor de Fundo', value: 'backcolor', disabled: true },
					{ type: 'separator' }            
				]
			},
			{ type: 'separator' },
			{ group: 'alignment', label: 'Alinhamento',
				buttons: [
					{ type: 'push', label: 'Alinhar Texto à Esquerda CTRL + SHIFT + [', value: 'justifyleft' },
					{ type: 'push', label: 'Centralizar CTRL + SHIFT + |', value: 'justifycenter' },
					{ type: 'push', label: 'Alinhar Texto à Direita CTRL + SHIFT + ]', value: 'justifyright' },
					{ type: 'push', label: 'Justificar', value: 'justifyfull' }
				]
			},
			{ type: 'separator' },
			{ group: 'parastyle', label: 'Estilo do Paragrafo',
				buttons: [
					{ type: 'select', label: 'Normal', value: 'heading', disabled: true,
						menu: [
							{ text: 'Normal', value: 'none', checked: true },
							{ text: 'Header 1', value: 'h1' },
							{ text: 'Header 2', value: 'h2' },
							{ text: 'Header 3', value: 'h3' },
							{ text: 'Header 4', value: 'h4' },
							{ text: 'Header 5', value: 'h5' },
							{ text: 'Header 6', value: 'h6' }
						]
					}
				]
			},
			{ type: 'separator' },
			{ group: 'indentlista', label: 'Recuo e Lista',
				buttons: [
					{ type: 'push', label: 'Almentar Recuo', value: 'indent', disabled: true },
					{ type: 'push', label: 'Diminuir Recuo', value: 'outdent', disabled: true },
					{ type: 'push', label: 'Marcador', value: 'insertunorderedlist' },
					{ type: 'push', label: 'Numeração', value: 'insertorderedlist' }
				]
			},
			{ type: 'separator' },
			{ group: 'img', label: 'Imagens',
				buttons: [
					{ type: 'push', label: 'Inserir Imagem', value: 'insertimage', disabled: false }
				]
			},
		]
	}
});			

myEditor.render();

function save(){
	myEditor.saveHTML();				
}

var myEditor2 = new YAHOO.widget.Editor('texto2', {
	height: '400px',
	width: '100%px',
	dompath: false,
	animate: true,
	toolbar: {		
		draggable: false,
		buttonType: 'advanced',
		buttons: [
			{ group: 'fontstyle', label: 'Nome da Fonte e Tamanho',
				buttons: [
					{ type: 'select', label: 'Arial', value: 'fontname', disabled: true,
						menu: [
							{ text: 'Arial', checked: true },
							{ text: 'Arial Black' },
							{ text: 'Comic Sans MS' },
							{ text: 'Courier New' },
							{ text: 'Lucida Console' },
							{ text: 'Tahoma' },
							{ text: 'Times New Roman' },
							{ text: 'Trebuchet MS' },
							{ text: 'Verdana' }
						]
					},
					{ type: 'spin', label: '13', value: 'fontsize', range: [ 9, 75 ], disabled: true }
				]
			},
			{ type: 'separator' },
			{ group: 'textstyle', label: 'Estilo da Fonte',
				buttons: [
					{ type: 'push', label: 'Negrito CTRL + SHIFT + B', value: 'bold' },
					{ type: 'push', label: 'Italico CTRL + SHIFT + I', value: 'italic' },
					{ type: 'push', label: 'Sublinhado CTRL + SHIFT + U', value: 'underline' },
					{ type: 'push', label: 'Tachado CTRL + SHIFT + S', value: 'strikethrough' },
					{ type: 'separator' },
					{ type: 'push', label: 'Subscrito', value: 'subscript', disabled: true },
					{ type: 'push', label: 'Sobrescrito', value: 'superscript', disabled: true },
					{ type: 'separator' },
					{ type: 'color', label: 'Cor da Fonte', value: 'forecolor', disabled: true },
					{ type: 'color', label: 'Cor de Fundo', value: 'backcolor', disabled: true },
					{ type: 'separator' }            
				]
			},
			{ type: 'separator' },
			{ group: 'alignment', label: 'Alinhamento',
				buttons: [
					{ type: 'push', label: 'Alinhar Texto à Esquerda CTRL + SHIFT + [', value: 'justifyleft' },
					{ type: 'push', label: 'Centralizar CTRL + SHIFT + |', value: 'justifycenter' },
					{ type: 'push', label: 'Alinhar Texto à Direita CTRL + SHIFT + ]', value: 'justifyright' },
					{ type: 'push', label: 'Justificar', value: 'justifyfull' }
				]
			},
			{ type: 'separator' },
			{ group: 'parastyle', label: 'Estilo do Paragrafo',
				buttons: [
					{ type: 'select', label: 'Normal', value: 'heading', disabled: true,
						menu: [
							{ text: 'Normal', value: 'none', checked: true },
							{ text: 'Header 1', value: 'h1' },
							{ text: 'Header 2', value: 'h2' },
							{ text: 'Header 3', value: 'h3' },
							{ text: 'Header 4', value: 'h4' },
							{ text: 'Header 5', value: 'h5' },
							{ text: 'Header 6', value: 'h6' }
						]
					}
				]
			},
			{ type: 'separator' },
			{ group: 'indentlista', label: 'Recuo e Lista',
				buttons: [
					{ type: 'push', label: 'Almentar Recuo', value: 'indent', disabled: true },
					{ type: 'push', label: 'Diminuir Recuo', value: 'outdent', disabled: true },
					{ type: 'push', label: 'Marcador', value: 'insertunorderedlist' },
					{ type: 'push', label: 'Numeração', value: 'insertorderedlist' }
				]
			},
			{ type: 'separator' },
			{ group: 'img', label: 'Imagens',
				buttons: [
					{ type: 'push', label: 'Inserir Imagem', value: 'insertimage', disabled: false }
				]
			},
		]
	}
});
myEditor2.render();

function save(){
	myEditor2.saveHTML();				
}