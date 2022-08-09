<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper" class="customer_profile">
   <div class="content">
      <div class="row">
        <div class="col-md-<?php if(isset($client)){echo 12;} else {echo 12;} ?>">
          <div class="panel_s">
            <div class="panel-body">
              <?php if(isset($client)){ ?>
              	<?php echo form_hidden('isedit'); ?>
              	<?php echo form_hidden('userid', $client->userid); ?>
              	<div class="clearfix"></div>
              <?php } ?>
            	<div>
                <div class="tab-content">
                  <?php $this->load->view((isset($tab) ? $tab['view'] : 'admin/commercial_visit/profile')); ?>
                </div>
            	</div>
            </div>
          </div>
        </div>
      </div>
      <?php if($group == 'profile'){ ?>
         <div class="btn-bottom-pusher"></div>
      <?php } ?>
      <input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
   </div>
</div>
<?php init_tail(); ?>
<?php if(isset($client)) { ?>
<script>
	var decimal_separator = '<?php echo $decimal_separator; ?>';
	var accion = '<?php echo $accion; ?>';

	$('#supply_points_modal #module_id').val(2);
	var soModule_id = $('#supply_points_modal #module_id');
	soModule_id.selectpicker('refresh');

  $(function() {
    init_rel_tasks_table(<?php echo $client->userid; ?>,'customer');
  });
  
  $(function() {
    _validate_form($('form'), {
    	module_id: 'required', 
    	cups: 'required',
    	address: 'required',
    	zip: 'required',
    	city: 'required',
    	state: 'required',
    	country: 'required',
    	rate: 'required'
    }, manage_supply_points);
	});
	
  function manage_supply_points(form) {
  	var id = '';
  	
  	if (form.name == "supply-points-form") {
			// Validaciones de los consumos en potencia
			if (!$('input[name=consumo_potencia1]').is(":disabled")){
				if ($('input[name=consumo_potencia1]').val()=="" || parseFloat($('input[name=consumo_potencia1]').val())==0){
					alert_float('success',"Introduzca consumo de potencia 1");	
					$('input[name=consumo_potencia1]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_potencia2]').is(":disabled")){
				if ($('input[name=consumo_potencia2]').val()=="" || parseFloat($('input[name=consumo_potencia2]').val())==0){
					alert_float('success',"Introduzca consumo de potencia 2");	
					$('input[name=consumo_potencia2]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_potencia3]').is(":disabled")){
				if ($('input[name=consumo_potencia3]').val()=="" || parseFloat($('input[name=consumo_potencia3]').val())==0){
					alert_float('success',"Introduzca consumo de potencia 3");	
					$('input[name=consumo_potencia3]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_potencia4]').is(":disabled")){
				if ($('input[name=consumo_potencia4]').val()=="" || parseFloat($('input[name=consumo_potencia4]').val())==0){
					alert_float('success',"Introduzca consumo de potencia 4");	
					$('input[name=consumo_potencia4]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_potencia5]').is(":disabled")){
				if ($('input[name=consumo_potencia5]').val()=="" || parseFloat($('input[name=consumo_potencia5]').val())==0){
					alert_float('success',"Introduzca consumo de potencia 5");	
					$('input[name=consumo_potencia5]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_potencia6]').is(":disabled")){
				if ($('input[name=consumo_potencia6]').val()=="" || parseFloat($('input[name=consumo_potencia6]').val())==0){
					alert_float('success',"Introduzca consumo de potencia 6");	
					$('input[name=consumo_potencia6]').focus();
					return false;
				}
			}
			// Validaciones de los precios en potencia
			if (!$('input[name=precio_potencia1]').is(":disabled")){
				if ($('input[name=precio_potencia1]').val()=="" || parseFloat($('input[name=precio_potencia1]').val())==0){
					alert_float('success',"Introduzca precio de potencia 1");	
					$('input[name=precio_potencia1]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_potencia2]').is(":disabled")){
				if ($('input[name=precio_potencia2]').val()=="" || parseFloat($('input[name=precio_potencia2]').val())==0){
					alert_float('success',"Introduzca precio de potencia 2");	
					$('input[name=precio_potencia2]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_potencia3]').is(":disabled")){
				if ($('input[name=precio_potencia3]').val()=="" || parseFloat($('input[name=precio_potencia3]').val())==0){
					alert_float('success',"Introduzca precio de potencia 3");	
					$('input[name=precio_potencia3]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_potencia4]').is(":disabled")){
				if ($('input[name=precio_potencia4]').val()=="" || parseFloat($('input[name=precio_potencia4]').val())==0){
					alert_float('success',"Introduzca precio de potencia 4");	
					$('input[name=precio_potencia4]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_potencia5]').is(":disabled")){
				if ($('input[name=precio_potencia5]').val()=="" || parseFloat($('input[name=precio_potencia5]').val())==0){
					alert_float('success',"Introduzca precio de potencia 5");	
					$('input[name=precio_potencia5]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_potencia6]').is(":disabled")){
				if ($('input[name=precio_potencia6]').val()=="" || parseFloat($('input[name=precio_potencia6]').val())==0){
					alert_float('success',"Introduzca precio de potencia 6");	
					$('input[name=precio_potencia6]').focus();
					return false;
				}
			}
			// Validaciones de los consumos en energia
			if (!$('input[name=consumo_energia1]').is(":disabled")){
				if ($('input[name=consumo_energia1]').val()=="" || parseFloat($('input[name=consumo_energia1]').val())==0){
					alert_float('success',"Introduzca consumo en energia 1");	
					$('input[name=consumo_energia1]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_energia2]').is(":disabled")){
				if ($('input[name=consumo_energia2]').val()=="" || parseFloat($('input[name=consumo_energia2]').val())==0){
					alert_float('success',"Introduzca consumo en energia 2");	
					$('input[name=consumo_energia2]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_energia3]').is(":disabled")){
				if ($('input[name=consumo_energia3]').val()=="" || parseFloat($('input[name=consumo_energia3]').val())==0){
					alert_float('success',"Introduzca consumo en energia 3");	
					$('input[name=consumo_energia3]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_energia4]').is(":disabled")){
				if ($('input[name=consumo_energia4]').val()=="" || parseFloat($('input[name=consumo_energia4]').val())==0){
					alert_float('success',"Introduzca consumo en energia 4");	
					$('input[name=consumo_energia4]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_energia5]').is(":disabled")){
				if ($('input[name=consumo_energia5]').val()=="" || parseFloat($('input[name=consumo_energia5]').val())==0){
					alert_float('success',"Introduzca consumo en energia 5");	
					$('input[name=consumo_energia5]').focus();
					return false;
				}
			}
			if (!$('input[name=consumo_energia6]').is(":disabled")){
				if ($('input[name=consumo_energia6]').val()=="" || parseFloat($('input[name=consumo_energia6]').val())==0){
					alert_float('success',"Introduzca consumo en energia 6");	
					$('input[name=consumo_energia6]').focus();
					return false;
				}
			}
			// Validaciones de los precios en energia
			if (!$('input[name=precio_energia1]').is(":disabled")){
				if ($('input[name=precio_energia1]').val()=="" || parseFloat($('input[name=precio_energia1]').val())==0){
					alert_float('success',"Introduzca precio en energia 1");	
					$('input[name=precio_energia1]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_energia2]').is(":disabled")){
				if ($('input[name=precio_energia2]').val()=="" || parseFloat($('input[name=precio_energia2]').val())==0){
					alert_float('success',"Introduzca precio en energia 2");	
					$('input[name=precio_energia2]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_energia3]').is(":disabled")){
				if ($('input[name=precio_energia3]').val()=="" || parseFloat($('input[name=precio_energia3]').val())==0){
					alert_float('success',"Introduzca precio en energia 3");	
					$('input[name=precio_energia3]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_energia4]').is(":disabled")){
				if ($('input[name=precio_energia4]').val()=="" || parseFloat($('input[name=precio_energia4]').val())==0){
					alert_float('success',"Introduzca precio en energia 4");	
					$('input[name=precio_energia4]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_energia5]').is(":disabled")){
				if ($('input[name=precio_energia5]').val()=="" || parseFloat($('input[name=precio_energia5]').val())==0){
					alert_float('success',"Introduzca precio en energia 5");	
					$('input[name=precio_energia5]').focus();
					return false;
				}
			}
			if (!$('input[name=precio_energia6]').is(":disabled")){
				if ($('input[name=precio_energia6]').val()=="" || parseFloat($('input[name=precio_energia6]').val())==0){
					alert_float('success',"Introduzca precio en energia 6");	
					$('input[name=precio_energia6]').focus();
					return false;
				}
			}
			
			if (accion == 'edicion') id = $('#supply_points_modal input[name=id]').val();
		}
		
		if (form.name == "supply-points-gas-form") {
			// Validaciones de los consumos en potencia
			if (!$('#supply_points_gas_modal input[name=consumo_potencia1]').is(":disabled")){
				if ($('#supply_points_gas_modal input[name=consumo_potencia1]').val()=="" || parseFloat($('#supply_points_gas_modal input[name=consumo_potencia1]').val())==0){
					alert_float('success',"Introduzca los días/año en termino fijo contratados");	
					$('#supply_points_gas_modal input[name=consumo_potencia1]').focus();
					return false;
				}
			}
			// Validaciones de los precios en potencia
			if (!$('#supply_points_gas_modal input[name=precio_potencia1]').is(":disabled")){
				if ($('#supply_points_gas_modal input[name=precio_potencia1]').val()=="" || parseFloat($('#supply_points_gas_modal input[name=precio_potencia1]').val())==0){
					alert_float('success',"Introduzca precio de los días/año contratado en termino fijo");	
					$('#supply_points_gas_modal input[name=precio_potencia1]').focus();
					return false;
				}
			}
			// Validaciones de los consumos en energia
			if (!$('#supply_points_gas_modal input[name=consumo_energia1]').is(":disabled")){
				if ($('#supply_points_gas_modal input[name=consumo_energia1]').val()=="" || parseFloat($('#supply_points_gas_modal input[name=consumo_energia1]').val())==0){
					alert_float('success',"Introduzca consumo contratado en termino variable");	
					$('#supply_points_gas_modal input[name=consumo_energia1]').focus();
					return false;
				}
			}
			// Validaciones de los precios en energia
			if (!$('#supply_points_gas_modal input[name=precio_energia1]').is(":disabled")){
				if ($('#supply_points_gas_modal input[name=precio_energia1]').val()=="" || parseFloat($('#supply_points_gas_modal input[name=precio_energia1]').val())==0){
					alert_float('success',"Introduzca precio contratado en termino variable");	
					$('#supply_points_gas_modal input[name=precio_energia1]').focus();
					return false;
				}
			}
			
			if (accion == 'edicion') id = $('#supply_points_gas_modal input[name=id]').val();
		}
  	
    var data = $(form).serialize();
    var url = form.action+"/"+id;
    $.post(url, data).done(function() {
      $('#supply_points_modal').modal('hide');
      window.location.reload(true);
    }).fail(function(data) {
      var error = JSON.parse(data.responseText);
      alert_float('danger',error.message);
    });

    return false;
	}
   
	///// Inicializa valor para la mejor tarifa.
	function inic_mejor_tarifa(accion_)
	{
		if (accion_ != 'edicion') 
		{
			$('input[name=consumo_potencia1]').val('0');
			$('input[name=consumo_potencia2]').val('0');
			$('input[name=consumo_potencia3]').val('0');
			$('input[name=consumo_potencia4]').val('0');
			$('input[name=consumo_potencia5]').val('0');
			$('input[name=consumo_potencia6]').val('0');

			$('input[name=precio_potencia1]').val('0');
			$('input[name=precio_potencia2]').val('0');
			$('input[name=precio_potencia3]').val('0');
			$('input[name=precio_potencia4]').val('0');
			$('input[name=precio_potencia5]').val('0');
			$('input[name=precio_potencia6]').val('0');
			
			$('input[name=consumo_energia1]').val('0');
			$('input[name=consumo_energia2]').val('0');
			$('input[name=consumo_energia3]').val('0');
			$('input[name=consumo_energia4]').val('0');
			$('input[name=consumo_energia5]').val('0');
			$('input[name=consumo_energia6]').val('0');
			
			$('input[name=precio_energia1]').val('0');
			$('input[name=precio_energia2]').val('0');
			$('input[name=precio_energia3]').val('0');
			$('input[name=precio_energia4]').val('0');
			$('input[name=precio_energia5]').val('0');
			$('input[name=precio_energia6]').val('0');
		}
	} inic_mejor_tarifa(accion);
	
	function config_rates(rate) {
		if (rate != '') {
			var url = '';
			
			// Termino de potencia.
			url = $('#adminurl').val()+'simulators/get_detail_rate/'+rate+'/1';
	   	$.post(url).done(function (response) 
	   	{
				response = JSON.parse('['+response+']');
				if (response[0]!=null) {
					if (parseFloat(response[0].columnprice1)>0){
						$('input[name=consumo_potencia1]').prop('disabled',false);
						$('input[name=precio_potencia1]').prop('disabled', false);
					}else{
						$('input[name=consumo_potencia1]').prop('disabled',true);
						$('input[name=precio_potencia1]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice2)>0){
						$('input[name=consumo_potencia2]').prop('disabled',false);
						$('input[name=precio_potencia2]').prop('disabled', false);
					}else{ 
						$('input[name=consumo_potencia2]').prop('disabled',true);
						$('input[name=precio_potencia2]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice3)>0){
						$('input[name=consumo_potencia3]').prop('disabled',false);
						$('input[name=precio_potencia3]').prop('disabled', false);
						
					}else{
						$('input[name=consumo_potencia3]').prop('disabled',true);
						$('input[name=precio_potencia3]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice4)>0){
						$('input[name=consumo_potencia4]').prop('disabled',false);
						$('input[name=precio_potencia4]').prop('disabled', false);
					}else{
						$('input[name=consumo_potencia4]').prop('disabled',true);
						$('input[name=precio_potencia4]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice5)>0){
						$('input[name=consumo_potencia5]').prop('disabled',false);
						$('input[name=precio_potencia5]').prop('disabled', false);
					}else{
						$('input[name=consumo_potencia5]').prop('disabled',true);
						$('input[name=precio_potencia5]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice6)>0){
						$('input[name=consumo_potencia6]').prop('disabled',false);
						$('input[name=precio_potencia6]').prop('disabled', false);
					}else{
						$('input[name=consumo_potencia6]').prop('disabled',true);
						$('input[name=precio_potencia6]').prop('disabled', true);
					}
				} else {
					$('input[name=consumo_potencia1]').prop('disabled', true);
					$('input[name=consumo_potencia2]').prop('disabled', true);
					$('input[name=consumo_potencia3]').prop('disabled', true);
					$('input[name=consumo_potencia4]').prop('disabled', true);
					$('input[name=consumo_potencia5]').prop('disabled', true);
					$('input[name=consumo_potencia6]').prop('disabled', true);
					$('input[name=precio_potencia1]').prop('disabled', true);
					$('input[name=precio_potencia2]').prop('disabled', true);
					$('input[name=precio_potencia3]').prop('disabled', true);
					$('input[name=precio_potencia4]').prop('disabled', true);
					$('input[name=precio_potencia5]').prop('disabled', true);
					$('input[name=precio_potencia6]').prop('disabled', true);
				}
	    	});
	    	
			// Termino de energia.
			url = $('#adminurl').val()+'simulators/get_detail_rate/'+rate+'/2';
	   	$.post(url).done(function (response) 
	   	{
				response = JSON.parse('['+response+']');
				if (response[0]!=null) {
					if (parseFloat(response[0].columnprice1)>0){
						$('input[name=precio_energia1]').prop('disabled',false);
						$('input[name=consumo_energia1]').prop('disabled', false);
					}else{
						$('input[name=precio_energia1]').prop('disabled',true);
						$('input[name=consumo_energia1]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice2)>0){
						$('input[name=precio_energia2]').prop('disabled',false);
						$('input[name=consumo_energia2]').prop('disabled', false);
					}else{ 
						$('input[name=precio_energia2]').prop('disabled',true);
						$('input[name=consumo_energia2]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice3)>0){
						$('input[name=precio_energia3]').prop('disabled',false);
						$('input[name=consumo_energia3]').prop('disabled', false);
						
					}else{
						$('input[name=precio_energia3]').prop('disabled',true);
						$('input[name=consumo_energia3]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice4)>0){
						$('input[name=precio_energia4]').prop('disabled',false);
						$('input[name=consumo_energia4]').prop('disabled', false);
					}else{
						$('input[name=precio_energia4]').prop('disabled',true);
						$('input[name=consumo_energia4]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice5)>0){
						$('input[name=precio_energia5]').prop('disabled',false);
						$('input[name=consumo_energia5]').prop('disabled', false);
					}else{
						$('input[name=precio_energia5]').prop('disabled',true);
						$('input[name=consumo_energia5]').prop('disabled', true);
					}
					if (parseFloat(response[0].columnprice6)>0){
						$('input[name=precio_energia6]').prop('disabled',false);
						$('input[name=consumo_energia6]').prop('disabled', false);
					}else{
						$('input[name=precio_energia6]').prop('disabled',true);
						$('input[name=consumo_energia6]').prop('disabled', true);
					}
				} else {
					$('input[name=precio_energia1]').prop('disabled', true);
					$('input[name=precio_energia2]').prop('disabled', true);
					$('input[name=precio_energia3]').prop('disabled', true);
					$('input[name=precio_energia4]').prop('disabled', true);
					$('input[name=precio_energia5]').prop('disabled', true);
					$('input[name=precio_energia6]').prop('disabled', true);
					$('input[name=consumo_energia1]').prop('disabled', true);
					$('input[name=consumo_energia2]').prop('disabled', true);
					$('input[name=consumo_energia3]').prop('disabled', true);
					$('input[name=consumo_energia4]').prop('disabled', true);
					$('input[name=consumo_energia5]').prop('disabled', true);
					$('input[name=consumo_energia6]').prop('disabled', true);
				}
	    	});
    	}
	}
	
	///// Responde a la selección de la tarifa.
	$('#supply_points_modal #rate').change(function(Event) {
		var rate =  $('#rate option:selected').val();
		if (accion == 'edicion') inic_mejor_tarifa('nuevo');
		config_rates(rate);
	});
	
	$('#supply_points_modal').on('hidden.bs.modal', function () {
		$('#supply_points_modal input[name=id]').remove();
	  $('#supply_points_modal form')[0].reset();
	});	
	
	function val_numbers(e) {
		var cod = 0;
		if (decimal_separator==',') cod = 44;
		if (decimal_separator=='.') cod = 46;
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == cod)) return true;
    return /\d/.test(String.fromCharCode(keynum));
  }
  
  function edit_supply_points(cliente, id) {
		url = $('#adminurl').val()+'clients/get_supply_points/'+cliente+'/'+id;
	  $.post(url).done(function (response) {
			response = JSON.parse('['+response+']');
			
			$('#supply_points_modal #module_id').val(response[0][0].module_id);
			var soModule_id = $('#supply_points_modal #module_id');
			soModule_id.selectpicker('refresh');
			
			$('#supply_points_modal input[name=cups]').val(response[0][0].cups);
			$('#supply_points_modal input[name=address]').val(response[0][0].address);
			$('#supply_points_modal input[name=zip]').val(response[0][0].zip);
			$('#supply_points_modal input[name=city]').val(response[0][0].city);
			$('#supply_points_modal input[name=state]').val(response[0][0].state);
			
			$('#supply_points_modal #country').val(response[0][0].country);
			var soCountry = $('#supply_points_modal #country');
			soCountry.selectpicker('refresh');
			
			$('#supply_points_modal #rate').val(response[0][0].rate);
			var soRate = $("#supply_points_modal #rate");
			soRate.selectpicker('refresh');
			config_rates(response[0][0].rate);
			
			$('#supply_points_modal input[name=consumo_energia1]').val(response[0][0].consumo_energia1);
			$('#supply_points_modal input[name=consumo_energia2]').val(response[0][0].consumo_energia2);
			$('#supply_points_modal input[name=consumo_energia3]').val(response[0][0].consumo_energia3);
			$('#supply_points_modal input[name=consumo_energia4]').val(response[0][0].consumo_energia4);
			$('#supply_points_modal input[name=consumo_energia5]').val(response[0][0].consumo_energia5);
			$('#supply_points_modal input[name=consumo_energia6]').val(response[0][0].consumo_energia6);
			
			$('#supply_points_modal input[name=consumo_potencia1]').val(response[0][0].consumo_potencia1);
			$('#supply_points_modal input[name=consumo_potencia2]').val(response[0][0].consumo_potencia2);
			$('#supply_points_modal input[name=consumo_potencia3]').val(response[0][0].consumo_potencia3);
			$('#supply_points_modal input[name=consumo_potencia4]').val(response[0][0].consumo_potencia4);
			$('#supply_points_modal input[name=consumo_potencia5]').val(response[0][0].consumo_potencia5);
			$('#supply_points_modal input[name=consumo_potencia6]').val(response[0][0].consumo_potencia6);
			
			$('#supply_points_modal input[name=precio_energia1]').val(response[0][0].precio_energia1);
			$('#supply_points_modal input[name=precio_energia2]').val(response[0][0].precio_energia2);
			$('#supply_points_modal input[name=precio_energia3]').val(response[0][0].precio_energia3);
			$('#supply_points_modal input[name=precio_energia4]').val(response[0][0].precio_energia4);
			$('#supply_points_modal input[name=precio_energia5]').val(response[0][0].precio_energia5);
			$('#supply_points_modal input[name=precio_energia6]').val(response[0][0].precio_energia6);
			
			$('#supply_points_modal input[name=precio_potencia1]').val(response[0][0].precio_potencia1);
			$('#supply_points_modal input[name=precio_potencia2]').val(response[0][0].precio_potencia2);
			$('#supply_points_modal input[name=precio_potencia3]').val(response[0][0].precio_potencia3);
			$('#supply_points_modal input[name=precio_potencia4]').val(response[0][0].precio_potencia4);
			$('#supply_points_modal input[name=precio_potencia5]').val(response[0][0].precio_potencia5);
			$('#supply_points_modal input[name=precio_potencia6]').val(response[0][0].precio_potencia6);
			
			$('#supply_points_modal #additional').append(hidden_input('id',id));
			$('#supply_points_modal').modal('show');
		});
	}
	
	
	// $$$$$$ MODULO DE GAS
	
	$('#supply_points_gas_modal #module_id').val(4);
	var soModule_id = $('#supply_points_gas_modal #module_id');
	soModule_id.selectpicker('refresh');
	
	function config_rates_gas(rate) {
		if (rate != '') {
			$('#supply_points_gas_modal input[name=consumo_potencia1]').prop('disabled',false);
			$('#supply_points_gas_modal input[name=precio_potencia1]').prop('disabled', false);
			$('#supply_points_gas_modal input[name=precio_energia1]').prop('disabled',false);
			$('#supply_points_gas_modal input[name=consumo_energia1]').prop('disabled', false);
    }
	}
	
	///// Inicializa valor para la mejor tarifa.
	function inic_mejor_tarifa_gas(){
		if (accion != 'edicion') {
			$('#supply_points_gas_modal input[name=consumo_potencia1]').val('0');
			$('#supply_points_gas_modal input[name=precio_potencia1]').val('0');
			$('#supply_points_gas_modal input[name=consumo_energia1]').val('0');
			$('#supply_points_gas_modal input[name=precio_energia1]').val('0');
		}
	} inic_mejor_tarifa_gas();
	
	///// Responde a la selección de la tarifa.
	$('#supply_points_gas_modal #rate').change(function(Event) {
		var rate =  $('#supply_points_gas_modal #rate option:selected').val();
		if (accion == 'edicion') inic_mejor_tarifa_gas('nuevo');
		config_rates_gas(rate);
	});

  function edit_supply_points_gas(cliente, id) {
		url = $('#adminurl').val()+'clients/get_supply_points/'+cliente+'/'+id;
	  $.post(url).done(function (response) {
			response = JSON.parse('['+response+']');
			
			$('#supply_points_gas_modal #module_id').val(response[0][0].module_id);
			var soModule_id = $('#supply_points_modal #module_id');
			soModule_id.selectpicker('refresh');
			
			$('#supply_points_gas_modal input[name=cups]').val(response[0][0].cups);
			$('#supply_points_gas_modal input[name=address]').val(response[0][0].address);
			$('#supply_points_gas_modal input[name=zip]').val(response[0][0].zip);
			$('#supply_points_gas_modal input[name=city]').val(response[0][0].city);
			$('#supply_points_gas_modal input[name=state]').val(response[0][0].state);
			
			$('#supply_points_gas_modal #country').val(response[0][0].country);
			var soCountry = $('#supply_points_gas_modal #country');
			soCountry.selectpicker('refresh');
			
			$('#supply_points_gas_modal #rate').val(response[0][0].rate);
			var soRate = $("#supply_points_gas_modal #rate");
			soRate.selectpicker('refresh');
			config_rates_gas(response[0][0].rate);
			
			$('#supply_points_gas_modal input[name=consumo_energia1]').val(response[0][0].consumo_energia1);
			$('#supply_points_gas_modal input[name=consumo_potencia1]').val(response[0][0].consumo_potencia1);
			$('#supply_points_gas_modal input[name=precio_energia1]').val(response[0][0].precio_energia1);
			$('#supply_points_gas_modal input[name=precio_potencia1]').val(response[0][0].precio_potencia1);
			
			$('#supply_points_gas_modal #additional').append(hidden_input('id',id));
			$('#supply_points_gas_modal').modal('show');
		});
	}
  
</script>
<?php } ?>
<?php $this->load->view('admin/clients/client_js'); ?>
</body>
</html>
