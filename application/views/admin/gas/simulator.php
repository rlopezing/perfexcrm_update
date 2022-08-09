<?php init_head(); ?>
<div id="wrapper">
  	<div class="content">
    	<div class="row">
      	<div class="col-md-8 left-column">
        		<div class="panel_s">
               <div class="panel-body">
                  <div class="row">
	                  <div class="col-md-12 pull-right" style="padding-bottom: 5px;">
	                  	<a class="text-uppercase pull-left text-center"><h3><strong><?php echo _l('simulator_rate_gas'); ?>:</strong></h3></a>
	                  </div>
	                  <div class="col-md-12 pull-right" style="padding-bottom: 5px;">
	                  	<a class="text-uppercase pull-left text-center"><h5><?php echo _l('simulator_datos_punto_suministro'); ?>: </h5></a>
	                  </div>
               		</div>
                  <?php echo form_open($this->uri->uri_string(),array('id'=>'simulator-form')); ?>
                  <div class="row">
	                  <div class="form-group select-placeholder col-md-6">
	                  	<label for="clientid" class="control-label">
	                    <span class="text-danger">* </span><?php echo _l('contract_client_string'); ?>
	                    </label>
	                    <select id="clientid" name="client" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
	                    <?php $selected = (isset($simulator) ? $simulator->client : '');
                        if($selected == ''){
                         	$selected = (isset($customer_id) ? $customer_id: '');
                        }
                        if($selected != ''){
                        	$rel_data = get_relation_data('customer', $selected);
                        	$rel_val = get_relation_values($rel_data,'customer');
                        	echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                        } ?>
	                    </select>
	                  </div>
                    <div class="col-md-6">
	                  	<?php $selected = (isset($simulator) ? $simulator->supply_points : ''); ?>
	                  	<?php log_message('debug', "selected: ".print_r($selected, TRUE)); ?>
	                    <?php echo render_select('supply_points',$supply_points,array('id','address'),'supply_points',$selected); ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                     	<?php $value = (isset($simulator) ? $simulator->nif : ''); ?>
                      <?php echo render_input('nif','contract_nif',$value); ?>
                    </div>
                    <div class="col-md-4">
                     	<?php $value = (isset($simulator) ? $simulator->cups : ''); ?>
                  		<?php echo render_input('cups','simulator_gas_cups',$value); ?>
                    </div>
	                  <div class="form-group select-placeholder col-md-4">
	                  	<?php
	                     	$selected = (isset($simulator) ? $simulator->rate : '');
	                     	echo render_select('rate',$rate,array('id','descripcion'),'simulator_rates_upper',$selected);
	                     ?>
	                  </div>
	               </div>
	               <div class="row">
                  	<div class="col-md-6" style="padding-bottom: 5px;">
                  		<a class="pull-left text-center"><h5><?php echo _l('simulator_fixed_term'); ?>: </h5></a>
                  	</div>
	                  <div class="col-md-6" style="padding-bottom: 5px;">
	                  	<a class="pull-left text-center"><h5><?php echo _l('simulator_variable_term'); ?>: </h5></a>
	                  </div>
	               </div>
	               <div class="row" style="padding: 0px;">
	               	<!-- 
	               	DÍAS AÑO DE CONSUMO CONTRATADOS EN TERMINO FIJO.
	               		-->
	               	<div class="col-md-3" style="padding: 0px;">
	                  	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
	                  		<h5><?php echo _l('simulator_yearday'); ?></h5>
	                  	</div>
		                  <div class="form-group col-md-12">
		                    	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
		                    		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
		                      	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_potencia1" value="<?php if(isset($simulator)){print_r($simulator->consumo_potencia1); }?>" disabled>
		                    	</div>
			               </div>
	               	</div>
	               	<!-- 
	               	PRECIOS CONTRATADOS DE DIAS AÑO EN TERMINO FIJO.
	               		-->
	               	<div class="col-md-3" style="padding: 0px;">
	                  	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
	                  		<h5><?php echo _l('simulator_price'); ?> (<?php echo $base_currency->symbol; ?>)</h5>
	                  	</div>
		                  <div class="form-group col-md-12">
		                    	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
		                    		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
		                      	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_potencia1" value="<?php if(isset($simulator)){print_r($simulator->precio_potencia1); }?>" disabled>
		                    	</div>
			               </div>
	               	</div>
	               	<!-- 
	               	CONSUMOS CONTRATADOS EN TERMINO VARIABLE.
	               		-->
	               	<div class="col-md-3" style="padding: 0px;">
	                  	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
	                  		<h5><?php echo _l('simulator_consumption'); ?> (kWh)</h5>
	                  	</div>
		                  <div class="form-group col-md-12">
		                    	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
		                    		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
		                      	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_energia1" value="<?php if(isset($simulator)){print_r($simulator->consumo_energia1); }?>" disabled>
		                    	</div>
			               </div>
	               	</div>
	               	<!-- 
	               	PRECIOS CONTRATADOS EN TERMINO VARIABLE.
	               		-->
	               	<div class="col-md-3" style="padding: 0px;">
	                  	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
	                  		<h5><?php echo _l('simulator_price'); ?> (<?php echo $base_currency->symbol; ?>)</h5>
	                  	</div>
		                  <div class="form-group col-md-12">
		                    	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
		                    		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
		                      	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_energia1" value="<?php if(isset($simulator)){print_r($simulator->precio_energia1); }?>" disabled>
		                    	</div>
			               </div>
	               	</div>
				      </div>
				      <div class="col-md-12"><hr></div>
                  <div class="row">
	                  <div class="col-md-4 pull-left" style="padding-bottom: 5px;">
	                  	<a class="text-uppercase pull-left text-center"><h5><?php echo _l('simulator_comparativa_tarifas'); ?>: </h5></a>
	                  </div>
	                  <div class="form-group col-md-2 text-left">
	                  	<button type="button" class="btnCalcular btn btn-warning" onclick="mejor_tarifa(); return false;" disabled>
	                  		<?php echo _l('simulator_calculate'); ?>
	                  	</button>
	                  </div>
	                  <div class="col-md-12 text-left"><p class="message text-uppercase"></p></div>
               	</div>
	               <div class="row">
	                  <div class="col-md-6 text-left" style="padding-bottom: 5px;">
	                  	<h5><?php echo _l('simulator_price_fixed_term'); ?>: </h5>
	                  </div>
	                  <div class="col-md-6 text-left" style="padding-bottom: 5px;">
	                  	<h5><?php echo _l('simulator_price_variable_term'); ?>: </h5>
	                  </div>
	               </div>
						<div class="row">
							<div class="col-md-12" style="padding: 0px;">
		                  <div class="form-group col-md-3 text-right">
		                     <label for="contract_value">
		                     	<p class="text-uppercase"><?php echo _l('simulator_savings'); ?> (<?php echo $base_currency->symbol; ?>): </p>
		                     </label>
		                  </div>
		                  <div class="form-group col-md-3 text-right">
	                     	<?php $value = format_money((isset($simulator) ? $simulator->savings_potency : '')); ?>
	                  		<?php echo render_input('savings_potency','',$value,'',['readonly'=>'true']); ?>
		                  </div>
		                  <div class="form-group col-md-3 text-right">
		                     <label for="contract_value">
		                     	<p class="text-uppercase"><?php echo _l('simulator_savings'); ?> (<?php echo $base_currency->symbol; ?>): </p>
		                     </label>
		                  </div>
		                  <div class="form-group col-md-3 text-right">
	                     	<?php $value = format_money((isset($simulator) ? $simulator->savings_energy : '')); ?>
	                  		<?php echo render_input('savings_energy','',$value,'',['readonly'=>'true']); ?>
		                  </div>
		               	</div>
	               	</div>
									<div class="row">
										<div class="col-md-12" style="padding: 0px;">
		                  <div class="form-group col-md-3 text-right">
		                     <label for="contract_value">
		                     	<p class="text-uppercase"><?php echo _l('simulator_total_savings'); ?> (<?php echo $base_currency->symbol; ?>): </p>
		                     </label>
		                  </div>
		                  <div class="form-group col-md-3 text-right">
	                     	<?php $value = format_money((isset($simulator) ? $simulator->total_savings : '')); ?>
	                  		<?php echo render_input('total_savings','',$value,'',['readonly'=>'true']); ?>
		                  </div>
		                  <div class="form-group col-md-3 text-right">
		                     <label for="contract_value"><p class="text-uppercase"><?php echo _l('commission_marketer'); ?>: </p></label>
		                  </div>
		                  <div class="form-group col-md-3 text-right">
	                     	<?php $value = (isset($simulator) ? $simulator->marketer_savings : ''); ?>
	                  		<?php echo render_input('marketer_savings','',$value,'',['readonly'=>'true']); ?>
		                  </div>
		               	</div>
	               	</div>
									<div class="row">
										<div class="col-md-12 hidden" style="padding: 0px;">
		                  <div class="form-group col-md-3 text-right">
	                     	<?php $value = 1; ?>
	                  		<?php echo render_input('gas','',$value,'',['readonly'=>'true']); ?>
		                  </div>
		              	</div>
	               	</div>
                  <?php $rel_id = (isset($simulator) ? $simulator->id : false); ?>
                  <?php echo render_custom_fields('contracts', $rel_id); ?>
									<div class="btn-bottom-toolbar text-right">
                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                  </div>
                  <?php echo form_close(); ?>
                  <input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
                  <input id="base_currency"class="hidden" type="text" value="<?php echo $base_currency->symbol; ?>">
               </div>
         	</div>
      	</div>
	    	<?php if(isset($simulator)) { ?>
	        <div class="col-md-4 right-column">
	          <div class="panel_s">
	            <div class="panel-body">
	              <h4 class="no-margin"><?php echo $simulator->id; ?></h4>
	              <a href="<?php echo site_url('contract/'.$simulator->id.'/'.$simulator->hash); ?>" target="_blank">
	              	<?php echo _l('view_simulator'); ?>
	              </a>
	              <hr class="hr-panel-heading" />
	              <?php if($contract->trash > 0) echo '<div class="ribbon default"><span>'._l('contract_trash').'</span></div>'; ?>
	              <div class="horizontal-scrollable-tabs preview-tabs-top">
	                <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
	                <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
	                <div class="horizontal-tabs">
	                  <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
	                    <li role="presentation" class="<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo 'active';} ?>">
	                      <a href="#tab_content" aria-controls="tab_content" role="tab" data-toggle="tab"><?php echo _l('simulation_content'); ?></a>
	                    </li>
	                  </ul>
	                </div>
	              </div>
	              <div class="tab-content">
	                <div role="tabpanel" class="tab-pane<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo ' active';} ?>" id="tab_content">
	                  <div class="row">
	                    <?php if($simulator->signed == 1){ ?>
	                      <div class="col-md-12">
	                      	<div class="alert alert-success">
	                          <?php echo _l('document_signed_info',array(
	                            '<b>'.$simulator->acceptance_firstname . ' ' . $simulator->acceptance_lastname . '</b> (<a href="mailto:'.$simulator->acceptance_email.'">'.$simulator->acceptance_email.'</a>)',
	                            '<b>'. _dt($simulator->acceptance_date).'</b>',
	                            '<b>'.$simulator->acceptance_ip.'</b>')
	                          ); ?>
	                        </div>
	                      </div>
	                    <?php } ?>
	                    <div class="col-md-12 text-right _buttons">
	                      <div class="btn-group">
	                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                        	<i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span>
	                        </a>
	                        <ul class="dropdown-menu dropdown-menu-right">
	                          <li class="hidden-xs"><a href="<?php echo admin_url('simulators/pdf/'.$simulator->id.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
	                          <li class="hidden-xs"><a href="<?php echo admin_url('simulators/pdf/'.$simulator->id.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
	                          <li><a href="<?php echo admin_url('simulators/pdf/'.$simulator->id); ?>"><?php echo _l('download'); ?></a></li>
	                          <li>
	                            <a href="<?php echo admin_url('simulators/pdf/'.$simulator->id.'?print=true'); ?>" target="_blank">
	                            	<?php echo _l('print'); ?>
	                            </a>
	                          </li>
	                        </ul>
	                      </div>
	                      <div class="btn-group">
	                        <button type="button" class="btn btn-default pull-left dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                          <?php echo _l('more'); ?> <span class="caret"></span>
	                        </button>
	                        <ul class="dropdown-menu dropdown-menu-right">
	                          <?php if(has_permission('contracts','','delete')){ ?>
		                          <li>
		                             <a href="<?php echo admin_url('simulators/delete/'.$contract->id); ?>" class="_delete">
		                             <?php echo _l('delete'); ?></a>
		                          </li>
	                          <?php } ?>
	                      	</ul>
	                      </div>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      <?php } ?>
      </div>
   </div>
 </div>
<?php init_tail(); ?>
<script>
	var decimal_separator = '<?php echo $decimal_separator; ?>';
	var accion = '<?php echo $accion; ?>';

	function config_rates(rate) {
		if (rate != '') {
			$('input[name=consumo_potencia1]').prop('disabled',false);
			$('input[name=precio_potencia1]').prop('disabled', false);
			$('input[name=precio_energia1]').prop('disabled',false);
			$('input[name=consumo_energia1]').prop('disabled', false);
			$('.btnCalcular').prop('disabled', false);
    	}
		}

  	var simulator_id = '<?php echo $simulator->id; ?>';
  	if (simulator_id!='') {
			var rate = '<?php echo $simulator->rate; ?>';
			config_rates(rate);
			
			// Filtra los puntos de suministro
			var supply_points = '<?php echo $simulator->supply_points; ?>';
			var cliente_id = '<?php echo $simulator->client; ?>';
			var module_id = 4;
			var url = $('#adminurl').val()+'/simulators/get_supply_points/'+cliente_id+'/'+module_id;
	  	$.get(url).done(function (response) {
	  		response = JSON.parse(response);
				$('#supply_points').children('option:not(:first)').remove();
				for (var i=0; i < response.length; i++) {
					$('#supply_points').append('<option value="'+response[i].id+'">'+response[i].address+'</option>');
				}
				var soSupplypoints = $('#supply_points');
				soSupplypoints.selectpicker('val',supply_points);
				soSupplypoints.selectpicker('refresh');
			});
			
			var cliente_id = '<?php echo $simulator->client; ?>';
		}
  
  	Dropzone.autoDiscover = false;
      
  	$(function () {
    	if ($('#contract-attachments-form').length > 0) {
     		new Dropzone("#contract-attachments-form", $.extend({}, _dropzone_defaults(), {
      		success: function (file) {
         		if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
          			var location = window.location.href;
          			window.location.href = location.split('?')[0] + '?tab=attachments';
         		}
      		}
     		}));
  		}

	  	// In case user expect the submit btn to save the contract content
	  	$('#contract-form').on('submit', function () {
	     	$('#inline-editor-save-btn').click();
	     	return true;
	  	});

		if (typeof (Dropbox) != 'undefined' && $('#dropbox-chooser').length > 0) {
		  document.getElementById("dropbox-chooser").appendChild(Dropbox.createChooseButton({
				success: function (files) {
				  $.post(admin_url + 'commissions/add_external_attachment', {
				    files: files,
				    simulator_id: simulator_id,
				    external: 'dropbox'
				  }).done(function () {
				    var location = window.location.href;
				    window.location.href = location.split('?')[0] + '?tab=attachments';
				  });
				},
				linkType: "preview",
				extensions: app_allowed_files.split(','),
		  }));
		}

	  	_validate_form($('#contract-form'), {
	     	client: 'required',
	     	cups: 'required',
	     	rate: 'required',
	     	consumo_potencia1: 'required',
	     	precio_potencia1: 'required',
	     	consumo_energia1: 'required',
	     	precio_energia1: 'required',
	     	savings_energy: 'required',
	     	savings_potency: 'required',
	     	total_savings: 'required',
	     	marketer_savings: 'required'
	  	});
    	
	  	_validate_form($('#renew-contract-form'), {
	     	new_start_date: 'required'
	  	});

	  	var _templates = [];
	  	$.each(contractsTemplates, function (i, template) {
	     	_templates.push({
	      	url: admin_url + 'commissions/get_template?name=' + template,
	      	title: template
	     	});
	  	});

	  	var editor_settings = {
	     	selector: 'div.editable',
	     	inline: true,
	     	theme: 'inlite',
	     	relative_urls: false,
	     	remove_script_host: false,
	     	inline_styles: true,
	     	verify_html: false,
	     	cleanup: false,
	     	apply_source_formatting: false,
	     	valid_elements: '+*[*]',
	     	valid_children: "+body[style], +style[type]",
	     	file_browser_callback: elFinderBrowser,
	     	table_default_styles: {
	        width: '100%'
	     	},
	     	fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
	     	pagebreak_separator: '<p pagebreak="true"></p>',
	     	plugins: [
	      	'advlist pagebreak autolink autoresize lists link image charmap hr',
	      	'searchreplace visualblocks visualchars code',
	      	'media nonbreaking table contextmenu',
	      	'paste textcolor colorpicker'
	     	],
	     	autoresize_bottom_margin: 50,
	     	insert_toolbar: 'image media quicktable | bullist numlist | h2 h3 | hr',
	     	selection_toolbar: 'save_button bold italic underline superscript | forecolor backcolor link | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect h2 h3',
	     	contextmenu: "image media inserttable | cell row column deletetable | paste pastetext searchreplace | visualblocks pagebreak charmap | code",
	     	setup: function (editor) {
	      	editor.addCommand('mceSave', function () {
	      		alert('mceSave');
	         	save_contract_content(true);
	      	});

	      	editor.addShortcut('Meta+S', '', 'mceSave');

	      	editor.on('MouseLeave blur', function () {
	         	if (tinymce.activeEditor.isDirty()) {
	            save_contract_content();
	         	}
	      	});

	      	editor.on('MouseDown ContextMenu', function () {
	         	if (!is_mobile() && !$('.left-column').hasClass('hide')) {
	            contract_full_view();
	         	}
	      	});

	      	editor.on('blur', function () {
	         	$.Shortcuts.start();
	      	});

	      	editor.on('focus', function () {
	         	$.Shortcuts.stop();
	      	});
	     	}
	  	}

	  	if (_templates.length > 0) {
	     	editor_settings.templates = _templates;
	     	editor_settings.plugins[3] = 'template ' + editor_settings.plugins[3];
	     	editor_settings.contextmenu = editor_settings.contextmenu.replace('inserttable', 'inserttable template');
	  	}

	   if(is_mobile()) {
	      editor_settings.theme = 'modern';
	      editor_settings.mobile    = {};
	      editor_settings.mobile.theme = 'mobile';
	      editor_settings.mobile.toolbar = _tinymce_mobile_toolbar();

	      editor_settings.inline = false;
	      window.addEventListener("beforeunload", function (event) {
	        	if (tinymce.activeEditor.isDirty()) {
	          	save_contract_content();
	        	}
	      });
	   }

	  	tinymce.init(editor_settings);
 	});
	
	///// Cuando selecciona un cliente.
	$('#clientid').change(function(Event) {
		var cliente_id =  $('#clientid option:selected').val();
		if (cliente_id != '') {
			var url = $('#adminurl').val()+'commissions/dat_cliente/'+cliente_id;
	    $.post(url).done(function (response) {
	      response = JSON.parse(response);
	      if (response.length>0) $('#nif').val(response[0].vat);
	    });
	    
			// Filtra los puntos de suministro
			var module_id = 4;
			var url = $('#adminurl').val()+'/simulators/get_supply_points/'+cliente_id+'/'+module_id;
	  	$.post(url).done(function (response) {
	  		response = JSON.parse(response);
				$('#supply_points').children('option:not(:first)').remove();
				for (var i=0; i < response.length; i++) {
					$('#supply_points').append('<option value="'+response[i].id+'">'+response[i].address+'</option>');
				}
				var soSupplypoints = $('#supply_points');
				soSupplypoints.selectpicker('refresh');
			});
    }
	});
	
	///// Cuando selecciona un cliente.
	$('#supply_points').change(function(Event) {
		var id = $('#supply_points option:selected').val();
		var cliente_id = $('#clientid option:selected').val();
		
		// Filtra los puntos de suministro
		var module_id = 4;
		var url = $('#adminurl').val()+'/simulators/get_supply_points/'+cliente_id+'/'+module_id+'/'+id;
  	$.post(url).done(function (response) {
  		response = JSON.parse(response);
  		
			$('#rate option:selected').val(response[0].rate);
			var soRate = $('#rate');
			soRate.selectpicker('val',response[0].rate);
			soRate.selectpicker('refresh');
			config_rates(response[0].rate);
			
			$('input[name=cups]').val(response[0].cups);
			$('input[name=consumo_energia1]').val(response[0].consumo_energia1);
			$('input[name=consumo_potencia1]').val(response[0].consumo_potencia1);
			$('input[name=precio_energia1]').val(response[0].precio_energia1);
			$('input[name=precio_potencia1]').val(response[0].precio_potencia1);
		});
	});

	///// Cuando se selecciona una tarifa.
	$('#tarifa').change(function(Event) {
		var tarifa =  $('#tarifa option:selected').val();
	});
	
	///// Inicializa valor para la mejor tarifa.
	function inic_mejor_tarifa(){
		if (accion != 'edicion') {
			$('input[name=consumo_potencia1]').val('0');
			$('input[name=precio_potencia1]').val('0');
			$('input[name=consumo_energia1]').val('0');
			$('input[name=precio_energia1]').val('0');
		}
	} inic_mejor_tarifa();

	///// Responde a la selección de la tarifa.
	$('#rate').change(function(Event) {
		var rate =  $('#rate option:selected').val();
		config_rates(rate);
	});
	
	///// Proceso de calculo de la mejor tarifa.
	function mejor_tarifa() {
		// Validaciones de los consumos en potencia
		if (!$('input[name=consumo_potencia1]').is(":disabled")){
			if ($('input[name=consumo_potencia1]').val()=="" || parseFloat($('input[name=consumo_potencia1]').val())==0){
				alert_float('success',"Introduzca los días/año en termino fijo contratados");	
				$('input[name=consumo_potencia1]').focus();
				return false;
			}
		}
		// Validaciones de los precios en potencia
		if (!$('input[name=precio_potencia1]').is(":disabled")){
			if ($('input[name=precio_potencia1]').val()=="" || parseFloat($('input[name=precio_potencia1]').val())==0){
				alert_float('success',"Introduzca precio de los días/año contratado en termino fijo");	
				$('input[name=precio_potencia1]').focus();
				return false;
			}
		}
		// Validaciones de los consumos en energia
		if (!$('input[name=consumo_energia1]').is(":disabled")){
			if ($('input[name=consumo_energia1]').val()=="" || parseFloat($('input[name=consumo_energia1]').val())==0){
				alert_float('success',"Introduzca consumo contratado en termino variable");	
				$('input[name=consumo_energia1]').focus();
				return false;
			}
		}
		// Validaciones de los precios en energia
		if (!$('input[name=precio_energia1]').is(":disabled")){
			if ($('input[name=precio_energia1]').val()=="" || parseFloat($('input[name=precio_energia1]').val())==0){
				alert_float('success',"Introduzca precio contratado en termino variable");	
				$('input[name=precio_energia1]').focus();
				return false;
			}
		}
		
		var total_termino_fijo = 0;
		if (parseFloat($('input[name=consumo_potencia1]').val())>0) 
			total_termino_fijo += parseFloat($('input[name=consumo_potencia1]').val()) * parseFloat($('input[name=precio_potencia1]').val());
		
		var total_termino_variable = 0;
		if (parseFloat($('input[name=consumo_energia1]').val())>0) 
			total_termino_variable += parseFloat($('input[name=consumo_energia1]').val()) * parseFloat($('input[name=precio_energia1]').val());
		
		var data = {
			'rate' : $('#rate option:selected').val(),
			'dias_ano' : $('input[name=consumo_potencia1]').val(),
			'consumo' : $('input[name=consumo_energia1]').val(),
			'total_termino_fijo' : total_termino_fijo,
			'total_termino_variable' : total_termino_variable
		}
		
		var url = $('#adminurl').val()+'gass/get_best_rate/';
    $.post(url,data).done(function (response) {
			response = JSON.parse(response);
			
			$('.message').html(response.message);
			$('input[name=savings_potency]').val(response.savings_fijo);
			$('input[name=savings_energy]').val(response.savings_variable);
			$('input[name=total_savings]').val(response.total_savings);
			$('input[name=marketer_savings]').val(response.marketer_savings);
		});
	}
	
	function val_numbers(e) {
		var cod = 0;
		if (decimal_separator==',') cod = 44;
		if (decimal_separator=='.') cod = 46;
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == cod)) return true;
    return /\d/.test(String.fromCharCode(keynum));
  }
  
  
	
</script>
</body>
</html>
