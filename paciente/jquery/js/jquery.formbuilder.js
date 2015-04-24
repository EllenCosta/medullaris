/**
 * jQuery Form Builder Plugin
 * Copyright (c) 2009 Mike Botsko, Botsko.net LLC (http://www.botsko.net)
 * http://www.botsko.net/blog/2009/04/jquery-form-builder-plugin/
 * Originally designed for AspenMSM, a CMS product from Trellis Development
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * Copyright notice and license must remain intact for legal use
 */
(function ($) {
	$.fn.formbuilder = function (options) {
		// Extend the configuration options with user-provided
		var defaults = {
			save_url: false,
			load_url: false,
			control_box_target: false,
			serialize_prefix: 'frmb',
			css_ol_sortable_class : 'ol_opt_sortable',
			messages: {
				save				: "Salvar",
				add_new_field		: "Adicionar novo campo ...",
				label_t				: "Texto Simples",
				label_title			: "Texto Simples",
				text				: "Campo de Texto",
				title				: "T�tulo",
				paragraph			: "Par�grafo",
				checkboxes			: "Checkboxes",
				radio				: "Radio",
				select				: "Lista",
				text_field			: "Campo de Texto",
				label				: "Texto",
				paragraph_field		: "Campo de Par�grafo",
				select_options		: "Op��es de Sele��o",
				add					: "Adicionar",
				checkbox_group		: "Grupo de Checkbox",
				remove_message		: "Tem certeza de que deseja remover este elemento?",
				remove				: "Remover",
				radio_group			: "Grupo de Radio",
				selections_message	: "Permitir multiplas sele��es",
				hide				: "Ocultar",
				required			: "Obrigat�rio",
				show				: "Mostrar"
			},
			loaded: function() {},
			saving: function() {},
			saved: function() {}
		};
		var opts = $.extend(defaults, options);
		var frmb_id = 'frmb-' + $('ul[id^=frmb-]').length++;
		return this.each(function () {
			var ul_obj = $(this).append('<ul id="' + frmb_id + '" class="frmb"></ul>').find('ul').sortable();
			var field = '', field_type = '', last_id = 1, help, form_db_id;
			// Add a unique class to the current element
			ul_obj.addClass(frmb_id);
			// load existing form data
			if (opts.load_url) {
				$.getJSON(opts.load_url, function(json) {
					form_db_id = json.form_id;
					fromJson(json.form_structure);
					opts.loaded(json);
					var controlBox = setupControlBox(opts.control_box_target);
				});
			} else {
				var controlBox = setupControlBox(opts.control_box_target);
			}
			// Create form control select box and add into the editor
			var setupControlBox = function (target) {
					var select = '';
					var box_content = '';
					var save_button = '';
					var box_id = frmb_id + '-control-box';
					var save_id = frmb_id + '-save-button';
					// Add the available options
					select += '<option value="0" disabled selected>' + opts.messages.add_new_field + '</option>';
					select += '<option value="label">' + opts.messages.label_t + '</option>';
					select += '<option value="input_text">' + opts.messages.text + '</option>';
					select += '<option value="textarea">' + opts.messages.paragraph + '</option>';
					select += '<option value="checkbox">' + opts.messages.checkboxes + '</option>';
					select += '<option value="radio">' + opts.messages.radio + '</option>';
					select += '<option value="select">' + opts.messages.select + '</option>';
					// Build the control box and search button content
					box_content = '<select id="' + box_id + '" class="frmb-control form-control">' + select + '</select>';
					save_button = '<button type="submit" id="' + save_id + '" class="frmb-submit btn btn-primary" onClick="$( \'#form_novo_form\' ).dialog( \'close\' );">' + opts.messages.save + '</button>';
					// Insert the control box into page
					if (!target) {
						$(ul_obj).before(box_content);
					} else {
						$(target).append(box_content);
					}
					// Insert the search button
					$(ul_obj).after(save_button);
					// Set the form save action
					$('#' + save_id).click(function () {
						opts.saving.call(this);
						save.call(this);
						//return false;
					});
					// Add a callback to the select element
					$('#' + box_id).change(function () {
						appendNewField($(this).val());
						$(this).val(0).blur();
						// This solves the scrollTo dependency
						$('html, body').animate({
							scrollTop: $('#frm-' + (last_id - 1) + '-item').offset().top
						}, 500);
						return false;
					});
				};
			// Json parser to build the form builder
			var fromJson = function (json) {
					var values = '';
					var options = false;
					// Parse json
					$(json).each(function () {
						// checkbox type
						if (this.cssClass === 'checkbox') {
							options = [this.title];
							values = [];
							$.each(this.values, function () {
								values.push([this.value, this.baseline]);
							});
						}
						// radio type
						else if (this.cssClass === 'radio') {
							options = [this.title];
							values = [];
							$.each(this.values, function () {
								values.push([this.value, this.baseline]);
							});
						}
						// select type
						else if (this.cssClass === 'select') {
							options = [this.title, this.multiple];
							values = [];
							$.each(this.values, function () {
								values.push([this.value, this.baseline]);
							});
						}
						// label
						else if (this.cssClass === 'label') {
							options = [this.tam, this.negr, this.ital, this.subl, this.alin];
							values = [this.values];
						}
						//input_text
						else if(this.cssClass === 'input_text'){
							options = [this.tam, this.mask];
							values = [this.values];
						}
						
						else {
							values = [this.values];
						}
						appendNewField(this.cssClass, values, options, this.required);
					});
				};
			// Wrapper for adding a new field
			var appendNewField = function (type, values, options, required) {
					field = '';
					field_type = type;
					if (typeof (values) === 'undefined') {
						values = '';
					}
					switch (type) {
					case 'label':
						appendLabel(values, options, required);
						break;
					case 'input_text':
						appendTextInput(values, options, required);
						break;
					case 'textarea':
						appendTextarea(values, required);
						break;
					case 'checkbox':
						appendCheckboxGroup(values, options, required);
						break;
					case 'radio':
						appendRadioGroup(values, options, required);
						break;
					case 'select':
						appendSelectList(values, options, required);
						break;
					}
				};
			// label
			var appendLabel = function (values, options, required) {
					var tam = '';
					var negr = false;
					var ital = false;
					var subl = false;
					var alin = '';
					if (typeof (options) === 'object') {
						tam = options[0];
						negr = options[1] === 'true' || options[1] === 'checked' ? true : false;
						ital = options[2] === 'true' || options[2] === 'checked' ? true : false;
						subl = options[3] === 'true' || options[3] === 'checked' ? true : false;
						alin = options[4];
					}
					field += '<div class="frm-fld"><label>Tamanho da Fonte</label>';
					field += '<select class="fld-font" id="font-' + last_id + '" >';
					field += '<option' + (tam == '12' ? ' selected ' : '') + '>12</option>';
					field += '<option' + (tam == '16' ? ' selected ' : '') + '>16</option>';
					field += '<option' + (tam == '18' ? ' selected ' : '') + '>18</option>';
					field += '<option' + (tam == '20' ? ' selected ' : '') + '>20</option>';
					field += '<option' + (tam == '24' ? ' selected ' : '') + '>24</option>';
					field += '<option' + (tam == '26' ? ' selected ' : '') + '>26</option>';
					field += '</select></div>';
					
					field += '<div class="frm-fld">'
					field += '<label for="negr-' + last_id + '">Negrito</label>';
					field += '<input type="checkbox" class="fld-negr" id="negr-' + last_id + '" name="negr-' + last_id + '" value="1" ' + (negr ? 'checked="checked"' : '') + '></div>';
					field += '<div class="frm-fld">'
					field += '<label for="ital-' + last_id + '">It�lico</label>';
					field += '<input type="checkbox" class="fld-ital" id="ital-' + last_id + '" name="ital-' + last_id + '" value="1" ' + (ital ? 'checked="checked"' : '') + '></div>';
					field += '<div class="frm-fld">'
					field += '<label for="subl-' + last_id + '">Sublinhado</label>';
					field += '<input type="checkbox" class="fld-subl" id="subl-' + last_id + '" name="subl-' + last_id + '" value="1" ' + (subl ? 'checked="checked"' : '') + '>';
					field += '</div>';
					
					field += '<div class="frm-fld"><label>Alinhamento</label>';
					field += '<select class="fld-alin" id="alinh-' + last_id + '" >';
					field += '<option' + (alin == 'Direita' ? ' selected ' : '') + '>Esquerda</option>';
					field += '<option' + (alin == 'Esquerda' ? ' selected ' : '') + '>Direita</option>';
					field += '<option' + (alin == 'Centralizado' ? ' selected ' : '') + '>Centralizado</option>';
					field += '</select></div>';
						
					field += '<label>' + opts.messages.label + '</label>';
					field += '<input class="fld-title form-control" id="title-' + last_id + '" type="text" value="' + values + '" />';
					help = '';
					appendFieldLi(opts.messages.label_title, field, required, help);
				};
			// single line input type="text"
			var appendTextInput = function (values, options, required) {
					tam = '';
					mask = '';
					if (typeof (options) === 'object') {
						tam = options[0];
						mask = options[1];
					}
					field += '<div class="frm-fld">';
					field += '<label for="tam-' + last_id + '">Tamanho</label>';
					field += '<input class="input_size" type="text" id="tam-' + last_id + '" value="' + tam + '"/>';
					field += '</div>';
					field += '<div class="frm-fld">';
					field += '<label for="mask-' + last_id + '">M�scara</label>';
					field += '<input class="input_mask" type="text" id="mask-' + last_id + '" value="' + mask + '" title="Ex: 99/99/9999"/>';
					field += '</div>';
					field += '<label>' + opts.messages.label + '</label>';
					field += '<input class="input_value" id="title-' + last_id + '" type="text" value="' + values + '" size="'+tam+'"/>';
					help = '';
					appendFieldLi(opts.messages.text, field, required, help);
				};
			// multi-line textarea
			var appendTextarea = function (values, required) {
					field += '<label>' + opts.messages.label + '</label>';
					field += '<input type="text" class="form-control" value="' + values + '" />';
					help = '';
					appendFieldLi(opts.messages.paragraph_field, field, required, help);
				};
			// adds a checkbox element
			var appendCheckboxGroup = function (values, options, required) {
					var title = '';
					if (typeof (options) === 'object') {
						title = options[0];
					}
					field += '<div class="chk_group">';
					field += '<div class="frm-fld"><label>' + opts.messages.title + '</label>';
					field += '<input type="text" name="title" class="form-control" value="' + title + '" /></div>';
					field += '<div class="false-label">' + opts.messages.select_options + '</div>';
					field += '<div class="fields">';

					field += '<div><ol class="' + opts.css_ol_sortable_class + '">';

					if (typeof (values) === 'object') {
						for (i = 0; i < values.length; i++) {
							field += checkboxFieldHtml(values[i]);
						}
					}
					else {
						field += checkboxFieldHtml('');
					}

					field += '<li class="add-area"><a href="#" class="add add_ck">' + opts.messages.add + '</a></li>';
					field += '</ol></div>';
					field += '</div>';
					field += '</div>';
					help = '';
					appendFieldLi(opts.messages.checkbox_group, field, required, help);

					$('.'+ opts.css_ol_sortable_class).sortable(); // making the dynamically added option fields sortable.
				};
			// Checkbox field html, since there may be multiple
			var checkboxFieldHtml = function (values) {
					var checked = false;
					var value = '';
					if (typeof (values) === 'object') {
						value = values[0];
						checked = ( values[1] === 'false' || values[1] === 'undefined' ) ? false : true;
					}
					field = '<li>';
					field += '<div>';
					field += '<input type="checkbox"' + (checked ? ' checked="checked"' : '') + ' />';
					field += '<input type="text" class="form-control" value="' + value + '" />';
					field += '<a href="#" class="remove" title="' + opts.messages.remove_message + '">' + opts.messages.remove + '</a>';
					field += '</div></li>';
					return field;
				};
			// adds a radio element
			var appendRadioGroup = function (values, options, required) {
					var title = '';
					if (typeof (options) === 'object') {
						title = options[0];
					}
					field += '<div class="rd_group">';
					field += '<div class="frm-fld"><label>' + opts.messages.title + '</label>';
					field += '<input type="text" class="form-control" name="title" value="' + title + '" /></div>';
					field += '<div class="false-label">' + opts.messages.select_options + '</div>';
					field += '<div class="fields">';

					field += '<div><ol class="' + opts.css_ol_sortable_class + '">';

					if (typeof (values) === 'object') {
						for (i = 0; i < values.length; i++) {
							field += radioFieldHtml(values[i], 'frm-' + last_id + '-fld');
						}
					}
					else {
						field += radioFieldHtml('', 'frm-' + last_id + '-fld');
					}

					field += '<div class="add-area"><a href="#" class="add add_rd">' + opts.messages.add + '</a></div>';
					field += '</ol></div>';
					field += '</div>';
					field += '</div>';
					help = '';
					appendFieldLi(opts.messages.radio_group, field, required, help);

					$('.'+ opts.css_ol_sortable_class).sortable(); // making the dynamically added option fields sortable. 
				};
			// Radio field html, since there may be multiple
			var radioFieldHtml = function (values, name) {
					var checked = false;
					var value = '';
					if (typeof (values) === 'object') {
						value = values[0];
						checked = ( values[1] === 'false' || values[1] === 'undefined' ) ? false : true;
					}
					field = '<li>'; 
					field += '<div>';
					field += '<input type="radio"' + (checked ? ' checked="checked"' : '') + ' name="radio_' + name + '" />';
					field += '<input type="text" class="form-control" value="' + value + '" />';
					field += '<a href="#" class="remove" title="' + opts.messages.remove_message + '">' + opts.messages.remove + '</a>';
					field += '</div></li>';

					return field;
				};
			// adds a select/option element
			var appendSelectList = function (values, options, required) {
					var multiple = false;
					var title = '';
					if (typeof (options) === 'object') {
						title = options[0];
						multiple = options[1] === 'true' || options[1] === 'checked' ? true : false;
					}
					field += '<div class="opt_group">';
					field += '<div class="frm-fld"><label>' + opts.messages.title + '</label>';
					field += '<input type="text" class="form-control" name="title" value="' + title + '" /></div>';
					field += '';
					field += '<div class="false-label">' + opts.messages.select_options + '</div>';
					field += '<div class="fields">';
					field += '<input type="checkbox" name="multiple"' + (multiple ? 'checked="checked"' : '') + '>';
					field += '<label class="auto">' + opts.messages.selections_message + '</label>';

					field += '<div><ol class="' + opts.css_ol_sortable_class + '">';

						if (typeof (values) === 'object') {
							for (i = 0; i < values.length; i++) {
								field += selectFieldHtml(values[i], multiple);
							}
						}
						else {
							field += selectFieldHtml('', multiple);
						}

					field += '<div class="add-area"><a href="#" class="add add_opt">' + opts.messages.add + '</a></div>';
					field += '</ol></div>';
					field += '</div>';
					field += '</div>';
					help = '';
					appendFieldLi(opts.messages.select, field, required, help);

					$('.'+ opts.css_ol_sortable_class).sortable(); // making the dynamically added option fields sortable.  
				};
			// Select field html, since there may be multiple
			var selectFieldHtml = function (values, multiple) {
					return (multiple ? checkboxFieldHtml(values) : radioFieldHtml(values));
				};
			// Appends the new field markup to the editor
			var appendFieldLi = function (title, field_html, required, help) {
					if (required) {
						required = required === 'true' ? true : false;
					}
					var li = '';
					li += '<li id="frm-' + last_id + '-item" class="' + field_type + '">';
					li += '<div class="legend">';
					li += '<a id="frm-' + last_id + '" class="toggle-form" href="#">' + opts.messages.hide + '</a> ';
					li += '<a id="del_' + last_id + '" class="del-button delete-confirm" href="#" title="' + opts.messages.remove_message + '"><span>' + opts.messages.remove + '</span></a>';
					li += '<strong id="txt-title-' + last_id + '">' + title + '</strong></div>';
					li += '<div id="frm-' + last_id + '-fld" class="frm-holder">';
					li += '<div class="frm-elements">';
					if(field_type != "label"){//n�o mostra o required para label
						li += '<div class="frm-fld"><label for="required-' + last_id + '">' + opts.messages.required + '</label>';					
						li += '<input class="required" type="checkbox" value="1" name="required-' + last_id + '" id="required-' + last_id + '"' + (required ? ' checked="checked"' : '') + ' /></div>';
					}
					if(field_type == "label"){
						
					}
					
					li += field;
					li += '</div>';
					li += '</div>';
					li += '</li>';
					$(ul_obj).append(li);
					$('#frm-' + last_id + '-item').hide();
					$('#frm-' + last_id + '-item').animate({
						opacity: 'show',
						height: 'show'
					}, 'slow');
					last_id++;
				};
			// handle field delete links
			ul_obj.on('click', '.remove', function(event){
				event.preventDefault();
				$(this).parents('li:eq(0)').animate({
					opacity: 'hide',
					height: 'hide',
					marginBottom: '0px'
				}, 'fast', function () {
					$(this).remove();
				});
				return false;
			});
			// handle field display/hide
			ul_obj.on('click', '.toggle-form', function(event){
				event.preventDefault();
				var holder = $(this).parents('li:eq(0)').find('.frm-holder');
				if( holder.is(':visible') ){
					$(this).removeClass('open').addClass('closed').html(opts.messages.show);
					holder.animate({
						opacity: 'hide',
						height: 'hide'
					}, 'slow');
				} else {
					$(this).removeClass('closed').addClass('open').html(opts.messages.hide);
					holder.animate({
						opacity: 'show',
						height: 'show'
					}, 'slow');
				}
				return false;
			});
			// handle delete confirmation
			ul_obj.on('click', '.delete-confirm', function(event){
				event.preventDefault();
				if (confirm($(this).attr('title'))) {
					$(this).parents('li:eq(0)').animate({
						opacity: 'hide',
						height: 'hide',
						marginBottom: '0px'
					}, 'slow', function () {
						$(this).remove();
					});
				}
				return false;
			});
			// Attach a callback to add new checkboxes
			ul_obj.on('click', '.add_ck', function(event){
				event.preventDefault();
				$(this).parent().before(checkboxFieldHtml());
				return false;
			});
			// Attach a callback to add new options
			ul_obj.on('click', '.add_opt', function(event){
				event.preventDefault();
				$(this).parent().before(selectFieldHtml('', false));
				return false;
			});
			// Attach a callback to add new radio fields
			ul_obj.on('click', '.add_rd', function(event){
				event.preventDefault();
				$(this).parent().before(radioFieldHtml(false, $(this).parents('.frm-holder').attr('id')));
				return false;
			});
			// saves the serialized data to the server
			var save = function(){
				var self = this;
					if (opts.save_url) {
						$.ajax({
							type: "POST",
							url: opts.save_url,
							data: $(ul_obj).serializeFormList({
								prepend: opts.serialize_prefix
							}) + "&form_id=" + form_db_id,
							success: function () {
								opts.saved.call(self);
							}
						});
					}
				};
		});
	};
})(jQuery);
/**
 * jQuery Form Builder List Serialization Plugin
 * Copyright (c) 2009 Mike Botsko, Botsko.net LLC (http://www.botsko.net)
 * Originally designed for AspenMSM, a CMS product from Trellis Development
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * Copyright notice and license must remain intact for legal use
 * Modified from the serialize list plugin
 * http://www.botsko.net/blog/2009/01/jquery_serialize_list_plugin/
 */
(function ($) {
	$.fn.serializeFormList = function (options) {
		// Extend the configuration options with user-provided
		var defaults = {
			prepend: 'ul',
			is_child: false,
			attributes: ['class']
		};
		var opts = $.extend(defaults, options);
		if (!opts.is_child) {
			opts.prepend = '&' + opts.prepend;
		}
		var serialStr = '';
		// Begin the core plugin
		this.each(function () {
			var ul_obj = this;
			var li_count = 0;
			var c = 1;
			$(this).children().each(function () {
				for (att = 0; att < opts.attributes.length; att++) {
					var key = (opts.attributes[att] === 'class' ? 'cssClass' : opts.attributes[att]);
					serialStr += opts.prepend + '[' + li_count + '][' + key + ']=' + encodeURIComponent($(this).attr(opts.attributes[att]));
					// append the form field values
					if (opts.attributes[att] === 'class') {
						serialStr += opts.prepend + '[' + li_count + '][required]=' + encodeURIComponent($('#' + $(this).attr('id') + ' input.required').is(':checked'));
						switch ($(this).attr(opts.attributes[att])) {
						case 'label':
							serialStr += opts.prepend + '[' + li_count + '][values]=' + encodeURIComponent($('#' + $(this).attr('id') + ' input[type=text]').val());
							serialStr += opts.prepend + '[' + li_count + '][tam]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .fld-font').val());
							serialStr += opts.prepend + '[' + li_count + '][negr]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .fld-negr').is(':checked'));
							serialStr += opts.prepend + '[' + li_count + '][ital]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .fld-ital').is(':checked'));
							serialStr += opts.prepend + '[' + li_count + '][subl]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .fld-subl').is(':checked'));
							serialStr += opts.prepend + '[' + li_count + '][alin]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .fld-alin').val());
							break;
						case 'input_text':
							serialStr += opts.prepend + '[' + li_count + '][values]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .input_value').val());
							serialStr += opts.prepend + '[' + li_count + '][tam]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .input_size').val());
							serialStr += opts.prepend + '[' + li_count + '][mask]=' + encodeURIComponent($('#' + $(this).attr('id') + ' .input_mask').val());
							break;
						case 'textarea':
							serialStr += opts.prepend + '[' + li_count + '][values]=' + encodeURIComponent($('#' + $(this).attr('id') + ' input[type=text]').val());
							break;
						case 'checkbox':
							c = 1;
							$('#' + $(this).attr('id') + ' input[type=text]').each(function () {
								if ($(this).attr('name') === 'title') {
									serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent($(this).val());
								}
								else {
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][value]=' + encodeURIComponent($(this).val());
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + $(this).prev().is(':checked');
								}
								c++;
							});
							break;
						case 'radio':
							c = 1;
							$('#' + $(this).attr('id') + ' input[type=text]').each(function () {
								if ($(this).attr('name') === 'title') {
									serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent($(this).val());
								}
								else {
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][value]=' + encodeURIComponent($(this).val());
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + $(this).prev().is(':checked');
								}
								c++;
							});
							break;
						case 'select':
							c = 1;
							serialStr += opts.prepend + '[' + li_count + '][multiple]=' + $('#' + $(this).attr('id') + ' input[name=multiple]').is(':checked');
							$('#' + $(this).attr('id') + ' input[type=text]').each(function () {
								if ($(this).attr('name') === 'title') {
									serialStr += opts.prepend + '[' + li_count + '][title]=' + encodeURIComponent($(this).val());
								}
								else {
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][value]=' + encodeURIComponent($(this).val());
									serialStr += opts.prepend + '[' + li_count + '][values][' + c + '][baseline]=' + $(this).prev().is(':checked');
								}
								c++;
							});
							break;
						}
					}
				}
				li_count++;
			});
		});
		return (serialStr);
	};
})(jQuery);
