<?php init_head(); ?>
	<div id="wrapper">
  	<div class="content">
    	<div class="row">
      	<div class="col-md-7">
        	<?php if($email_exist_as_staff){ ?>
          <div class="alert alert-danger">
            Some of the general map email is used as staff member email, according to the docs, the support general map email must be unique email in the system, you must change the staff email or the support general map email in order all the features to work properly.
          </div>
          <?php } ?>
          <div class="panel_s">
            <div class="panel-body">
            	<div class="row">
              	<div class="col-md-6 _buttons">
									<a onclick="new_commission_plan();" class="btn btn-info pull-left display-block"><?php echo _l('new_plan'); ?></a>   
              		<div class="col-md-3 hidden"><p id="url_admin"><?php echo admin_url(); ?></p></div>
                </div>
							</div>
	            <br />
					    <div class="row">
					    	<?php echo form_open(admin_url('commission_plans/filtrar'), array('id'=>'consultar-form')); ?>
					        <div class="form-group select-placeholder col-md-4">
					          <?php $selected = (isset($country) ? $country : ''); ?>
					          <?php echo render_select('country_id',$countries,array('country_id','short_name'),'settings_sales_country_code',$selected); ?>
					        </div>
		            	<div class="form-group select-placeholder col-md-5">
		            		<?php $selected = (isset($module) ? $module : ''); ?>
		            		<?php echo render_select('module_id',$modules,array('id','name'),'module',$selected); ?>
		            	</div>
					        <div class="col-md-3" style="padding-top: 25px;">
					        	<button type="submit" class="btn btn-default">Actualizar</button>
					        </div>
					      <?php echo form_close(); ?>
						  </div>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
              <div class="clearfix"></div>
              	<?php render_datatable(array(
						    	_l('commission_marketer'),
						    	_l('commission_customer_type'),
						    	_l('commission_rate'),
						    	_l('settings_sales_country_code'),
						    	_l('options')
              	),'commission-plan'); ?>
            </div>
            <input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
          </div>
        </div>
        <!-- Mostrar consumos. -->
      	<div id="consumos" class="col-md-5" style="display: none;">
        	<?php if($email_exist_as_staff){ ?>
          <div class="alert alert-danger">
            Some of the general map email is used as staff member email, according to the docs, the support general map email must be unique email in the system, you must change the staff email or the support general map email in order all the features to work properly.
          </div>
          <?php } ?>
          <div class="panel_s">
            <div class="panel-body">
              <div class="_buttons">
              	<div class="row">
              		<div class="col-md-3">
										<a onclick="new_commission_consumo();" class="btn btn-success pull-left display-block"><?php echo _l('new_consumo'); ?></a> 									</div>
                </div>
                <br />
              	<div class="row">
              		<div class="col-md-4 text-right"><p><?php echo _l('commission_plan_title'); ?>:</p></div>
              		<div class="col-md-2 text-center"><p id="id_comer">ALDRO</p></div>
              		<div class="col-md-2 text-center"><p id="id_tipo">Distribuidor</p></div>
              		<div class="col-md-4 text-center"><p id="id_tarifa">INDEXADA</p></div>
                </div>
              	<div class="row hidden">
              		<div class="col-md-4 text-right"><p>ids:</p></div>
              		<div class="col-md-2 text-center"><p id="idcomer">0</p></div>
              		<div class="col-md-2 text-center"><p id="idcatcom">0</p></div>
              		<div class="col-md-4 text-center"><p id="idtarifa">0</p></div>
                </div>
							</div>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
              <div class="clearfix"></div>
              <div class="">
								<table id="tab_consumos" class="table table-commission-consumos dataTable no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
									<thead><tr role="row">
										<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="ComercializadorActivar para ordenar la columna descendente">A</th>
										<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Tipo de clienteActivar para ordenar la columna ascendente">M</th>
										<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="TarifaActivar para ordenar la columna ascendente">Inferior</th>
										<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="TarifaActivar para ordenar la columna ascendente">Superior</th>
										<th class="sorting_disabled not-export" rowspan="1" colspan="1" aria-label="Opciones">Opciones</th>
									</tr></thead>
									<tbody></tbody>
								</table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
  <?php $this->load->view('admin/commission_plan/commission_plan'); ?>
  <?php $this->load->view('admin/commission_plan/commission_consumo'); ?>
  <?php $this->load->view('admin/commission_plan/commission_costo'); ?>
  <?php init_tail(); ?>
  <script>
  	var decimal_separator = '<?php echo $decimal_separator; ?>';
  	
	  $(function() {
	    initDataTable('.table-commission-plan', window.location.href, [3], [3]);
	    
	    _validate_form($('form'),{
	    	comercializador: 'required', 
	    	tipo_cliente: 'required',
	    	country_id: 'required',
	    	tarifa: 'required'
	    }, manage_commission_plan);
	    
	    $('#mCommissionPlans').on('hidden.bs.modal', function(event) {
	      $('#additional').html('');
	      $('.add-title').removeClass('hide');
	      $('.edit-title').removeClass('hide');
	    });
		});
		
	  function manage_commission_plan(form) {
	    var data = $(form).serialize();
	    var url = form.action;
	    
	    $.post(url, data).done(function(response) {
	      response = JSON.parse(response);
	      if(response.success == true) {
	        alert_float('success',response.message);
	      }
	      $('.table-commission-plan').DataTable().ajax.reload();
	      $('#mCommissionPlans').modal('hide');
	    }).fail(function(data){
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });

	    return false;
		}
		
		function new_commission_plan() {
			var country_id = $('#country_id').val();
			var module_id = $('#module_id').val();
			$('#additional').append(hidden_input('country_id',country_id));
			$('#additional').append(hidden_input('module_id',module_id));
			
	    // Se asigna valor de la tarifa.
			var url = $('#adminurl').val()+'/commissions/filtrar_tarifa/'+country_id+'/'+module_id;
	    $.post(url).done(function (response) {
	    	response = JSON.parse(response);
				$('#tarifa').children('option:not(:first)').remove();
				for (var i=0; i < response.length; i++) {
					$('#tarifa').append('<option value="'+response[i].id+'">'+response[i].descripcion+'</option>');
				}
				var soTarifa = $('#tarifa');
				soTarifa.selectpicker('refresh');
	    });

	    // Se asigna valor de la categoria comercial.
			var url = $('#adminurl').val()+'/commissions/filtrar_categoria_comercial/'+country_id+'/'+module_id;
	    $.post(url).done(function (response) {
	    	response = JSON.parse(response);
				$('#categoria_comercial').children('option:not(:first)').remove();
				for (var i=0; i < response.length; i++) {
					$('#categoria_comercial').append('<option value="'+response[i].id+'">'+response[i].detalle+'</option>');
				}
				var soTarifa = $('#categoria_comercial');
				soTarifa.selectpicker('refresh');
	    });
			
	    $('#mCommissionPlans').modal('show');
	    $('.edit-title').addClass('hide');
		}
		
		function edit_commission_plan(invoker,id) {
	    var detalle = $(invoker).data('detalle');
			var country_id = $('#country_id').val();
			var module_id = $('#module_id').val();
			$('#additional').append(hidden_input('country_id',country_id));
			$('#additional').append(hidden_input('module_id',module_id));
	    $('#additional').append(hidden_input('id',id));
	    $('#mCommissionPlans input[name="nombre"]').val(detalle);
	    
	    $('#mCommissionPlans').modal('show');
	    $('.add-title').addClass('hide');
		}
		
		///// Cuando cambia el comercializador.
		$('#mCommissionPlans #country_id').change(function(Event) {
			// Filtra las tarifas
			var country_id =  $('#mCommissionPlans #country_id option:selected').val();
			var url = $('#mCommissionPlans #adminurl').val()+'/commissions/filtrar_tarifa/'+country_id;
	    $.post(url).done(function (response) {
	    	response = JSON.parse(response);
				$('#mCommissionPlans #tarifa').children('option:not(:first)').remove();
				for (var i=0; i < response.length; i++) {
					$('#mCommissionPlans #tarifa').append('<option value="'+response[i].id+'">'+response[i].descripcion+'</option>');
				}
				var soTarifa = $('#mCommissionPlans #tarifa');
				soTarifa.selectpicker('refresh');
	    });
		});

//////////////////////////////////////
///// CONSUMOS:

		function commission_consumos(invoker,id){
			$('#plano').val(id);
			var datos = invoker.name.split('=/=');
			url = datos[0] + "/" + id;
			$('#id_comer').text(datos[1]);
			$('#id_tipo').text(datos[2]);
			$('#id_tarifa').text(datos[3]);
			
			var ids = datos[4].split(' ');
  		$('#idcomer').text(ids[0]);
  		$('#idcatcom').text(ids[1]);
  		$('#idtarifa').text(ids[2]);
			
	    $.post(url).done(function(response) {
	      response = JSON.parse(response);
	      $('#tab_consumos tbody tr').remove();
	      if (response.aaData.length > 0) {
	      	var html_ok_a = '';
	      	var html_ok_m = '';
	      	
	      	for (var i = 0; i < response.aaData.length; i++) {
	      		if (response.aaData[i][2]==1) html_ok_a = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; else html_ok_a = '';
	      		if (response.aaData[i][3]==1) html_ok_m = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; else html_ok_m = '';
	      			
			      var htmlTags = '\
							<tr>\
								<td>' + html_ok_a + '</td>\
								<td>' + html_ok_m + '</td>\
								<td>' + response.aaData[i][4] + '</td>\
								<td>' + response.aaData[i][5] + '</td>\
								<td>' + response.aaData[i][6] + '</td>\
							</tr>\
			      ';
			      $('#tab_consumos tbody').append(htmlTags);
					}
				}
				
	      $("#consumos").show();
	    }).fail(function(data){
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });
      
	    return false;
		}
		
		function new_commission_consumo() {
	    $('#mCommissionConsumo').modal('show');
	    $('.edit-title').addClass('hide');
		}
		
		function save_commission_consumo() {
			if ($('#mCommissionConsumo input[name="anual"]').val()=='') {
				alert_float('success','Seleccione Anual o mensual');
				return false;
			}
			if ($('#mCommissionConsumo input[name="limite_inferior"]').val()=='') {
				alert_float('success','Introduzca el limite inferior');
				return false;
			}
			if ($('#mCommissionConsumo input[name="limite_superior"]').val()=='') {
				alert_float('success','Introduzca el limite superior');
				return false;
			}
			
	    $('#mCommissionConsumo').modal('hide');
	    $('.edit-title').addClass('hide');
	    var data = $('#commission-consumo-form').serialize();
	    var url = $('#commission-consumo-form').attr('action');
	    $.post(url, data).done(function(response) {
	    	response = JSON.parse(response);
	      if(response.success == true) {
	        alert_float('success',response.message);
	      }
	      
		    $.post(response.url).done(function(response1) {
		      response1 = JSON.parse(response1);
		      $('#tab_consumos tbody tr').remove();
		      if (response1.aaData.length > 0) {
		      	var html_ok_a = '';
		      	var html_ok_m = '';
		      	
		      	for (var i = 0; i < response1.aaData.length; i++) {
		      		if (response1.aaData[i][2]==1) html_ok_a = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; 
		      			else html_ok_a = '';
		      		if (response1.aaData[i][3]==1) html_ok_m = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; 
		      			else html_ok_m = '';
		      			
				      var htmlTags = '\
								<tr>\
									<td>' + html_ok_a + '</td>\
									<td>' + html_ok_m + '</td>\
									<td>' + response1.aaData[i][4] + '</td>\
									<td>' + response1.aaData[i][5] + '</td>\
									<td>' + response1.aaData[i][6] + '</td>\
								</tr>\
				      ';
				      $('#tab_consumos tbody').append(htmlTags);
						}
					}
					
		      $("#consumos").show();
		    }).fail(function(data){
	        var error = JSON.parse(data.responseText);
	        alert_float('danger',error.message);
	      });
	      
	    }).fail(function(data){
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });
      
	    return false;
		}
		
		function delete_commission_consumo(invoker,id) {
			var name = invoker.name;
			var datos = name.split('=/=');
			
			url = datos[0]+'/delete_consumo/'+id+'/'+datos[1];
	    $.post(url).done(function(response) {
	    	response = JSON.parse(response);
	      if(response.success == true) {
	        alert_float('success',response.message);
	      }
	      
		    $.post(response.url).done(function(response1) {
		      response1 = JSON.parse(response1);
		      $('#tab_consumos tbody tr').remove();
		      if (response1.aaData.length > 0) {
		      	var html_ok_a = '';
		      	var html_ok_m = '';
		      	
		      	for (var i = 0; i < response1.aaData.length; i++) {
		      		if (response1.aaData[i][2]==1) html_ok_a = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; 
		      			else html_ok_a = '';
		      		if (response1.aaData[i][3]==1) html_ok_m = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; 
		      			else html_ok_m = '';
		      			
				      var htmlTags = '\
								<tr>\
									<td>' + html_ok_a + '</td>\
									<td>' + html_ok_m + '</td>\
									<td>' + response1.aaData[i][4] + '</td>\
									<td>' + response1.aaData[i][5] + '</td>\
									<td>' + response1.aaData[i][6] + '</td>\
								</tr>\
				      ';
				      $('#tab_consumos tbody').append(htmlTags);
						}
					}
					
		      $("#consumos").show();
		    }).fail(function(data){
	        var error = JSON.parse(data.responseText);
	        alert_float('danger',error.message);
	      });
	    }).fail(function(data){
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });
      
	    return false;
		}
		
		///// Obtiene cambio en el tipo.
		function change(valores) {
			var cond = valores.split('=/=');
			$('#mCommissionConsumo input[name="anual"]').val(cond[0]);
			$('#mCommissionConsumo input[name="mensual"]').val(cond[1]);
		}
		
		///// Valida solo numeros.
		function val_numbers(e) {
			var cod = 0;
			if (decimal_separator==',') cod = 44;
			if (decimal_separator=='.') cod = 46;
	    var keynum = window.event ? window.event.keyCode : e.which;
	    if ((keynum == 8) || (keynum == cod)) return true;
	    
	    return /\d/.test(String.fromCharCode(keynum));
  	}
		
//////////////////////////////////////
///// COSTOS DE COMISIÓN:
		
		function costos(invoker,id) {
	    $('.edit-title').addClass('hide');
	    
			var datos = invoker.name.split('=/=');
			url = datos[0] + "/costos/" + id;
			var anual = datos[2];
			var mensual = datos[3];
			var limInferior = datos[4];
			var limSuperior = datos[5];
			
			$('#id_anual').text(anual);
			$('#id_mensual').text(mensual);
			$('#id_inferior').text(limInferior);
			$('#id_superior').text(limSuperior);
			$('#consumo').text(id);
			$('#consumo').val(id);
			
	    $.post(url).done(function(response) {
	      response = JSON.parse(response);
	      $('#tab_costos tbody tr').remove();
	      if (response.aaData.length > 0) {
	      	for (var i = 0; i < response.aaData.length; i++) {
			      var htmlTags = '\
							<tr>\
								<td>' + response.aaData[i][3] + '</td>\
								<td>' + response.aaData[i][4] + '</td>\
								<td>' + response.aaData[i][5] + '</td>\
							</tr>\
			      ';
			      $('#tab_costos tbody').append(htmlTags);
					}
				}
				
				$('#id_comer_c').text($('#id_comer').text());
				$('#id_tipo_c').text($('#id_tipo').text());
				$('#id_tarifa_c').text($('#id_tarifa').text());
				
	      $('#mCommissionCostos').modal('show');
	    }).fail(function(data){
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });
      
			// Filtra los niveles de precios
			var country_id = $('#country_id').val();
			var module_id = $('#module_id').val();
			var comercializador = $('#idcomer').text();
			var tarifa = $('#idtarifa').text();
			var url = $('#url_admin').text()+'commissions/filtrar_precios/'+comercializador+'/'+tarifa+'/'+country_id+'/'+module_id;
	  	$.post(url).done(function (response){
	  		response = JSON.parse(response);
	  		console.log(response);
	  		$('#nivel_precio').children('option:not(:first)').remove();
	  		if (response.length > 0){
					for (var i=0; i < response.length; i++) {
						$('#nivel_precio').append('<option value="'+response[i].id+'">'+response[i].detalle+'</option>');
					}
				}
				var soNivelPrecio = $('#nivel_precio');
				soNivelPrecio.selectpicker('refresh');
			});
      
	    return false;
		}
		
		function commission_costos() {
			console.log($("#nivel_precio option:selected").val());
			
			if ($("#nivel_precio option:selected").val()=='' || typeof($("#nivel_precio option:selected").val())=='undefined') {
				alert_float('success','Seleccione un nivel de precios.');
				return false;
			}
			if ($("#comision").val() == '') {
				alert_float('success','Introduzca un costo.');
				return false;
			}
			
	    $('.edit-title').addClass('hide');
			var data = $('#commission-costos-form').serialize();
			var url = $('#commission-costos-form').attr('action');
			
	    $.post(url,data).done(function(response) {
	      response = JSON.parse(response);
	      url = response.url;
		    $.post(url).done(function(response) {
		      response = JSON.parse(response);
		      $('#tab_costos tbody tr').remove();
		      if (response.aaData.length > 0) {
		      	for (var i = 0; i < response.aaData.length; i++) {
				      var htmlTags = '\
								<tr>\
									<td>' + response.aaData[i][3] + '</td>\
									<td>' + response.aaData[i][4] + '</td>\
									<td>' + response.aaData[i][5] + '</td>\
								</tr>\
				      ';
				      $('#tab_costos tbody').append(htmlTags);
						}
					}
		    }).fail(function(data){
	        var error = JSON.parse(data.responseText);
	        alert_float('danger',error.message);
	      });
	      
	      
	    }).fail(function(data){
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });
      
	    return false;
		}

		function delete_commission_costo(invoker,id) {
	    $('.edit-title').addClass('hide');
			var name = invoker.name;
			var datos = name.split('=/=');
			url = datos[0]+'/delete_costo/'+id+'/'+datos[1];			
	    $.post(url).done(function(response) {
	      response = JSON.parse(response);
	      url = response.url;
		    $.post(url).done(function(response) {
		      response = JSON.parse(response);
		      $('#tab_costos tbody tr').remove();
		      if (response.aaData.length > 0) {
		      	for (var i = 0; i < response.aaData.length; i++) {
				      var htmlTags = '\
								<tr>\
									<td>' + response.aaData[i][3] + '</td>\
									<td>' + response.aaData[i][4] + '</td>\
									<td>' + response.aaData[i][5] + '</td>\
								</tr>\
				      ';
				      $('#tab_costos tbody').append(htmlTags);
						}
					}
		    }).fail(function(data){
	        var error = JSON.parse(data.responseText);
	        alert_float('danger',error.message);
	      });
	      
	      
	    }).fail(function(data){
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });
      
	    return false;
		}

  </script>
</body>
</html>