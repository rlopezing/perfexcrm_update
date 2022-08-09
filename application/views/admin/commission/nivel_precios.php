<div class="modal fade" id="mNivelPrecios" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('commissions/price_level'), array('id'=>'nivel-precios-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="edit-title"><?php echo _l('price_level_edit'); ?></span>
          <span class="add-title"><?php echo _l('new_price_level'); ?></span>
        </h4>
      </div>
        <div class="modal-body">
            <div class="row">
		          <div class="form-group select-placeholder col-md-6">
		          	<?php
		             	$selected = (isset($plan) ? $plan->comercializador : '');
		             	echo render_select('comercializador',$comercializador,array('id','nombre'),'commission_marketer',$selected);
		            ?>
		          </div>
		          <div class="form-group select-placeholder col-md-6">
		          	<?php
		             	$selected = (isset($plan) ? $plan->tarifa : '');
		             	echo render_select('tarifa',$tarifa,array('id','descripcion'),'contract_rate',$selected);
		            ?>
		          </div>
		        </div>
		        <div class="row">
              <div class="col-md-8">
                  <div id="additional"></div>
                  <?php echo render_input('detalle', 'price_level_detalle'); ?>
              </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
        </div>
    </div><!-- /.modal-content -->
    <?php echo form_close(); ?>
    <input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  window.addEventListener('load',function() {
    _validate_form($('#nivel-precios-form'), {
    		tarifa:'required', 
    		comercializador:'required', 
    		detalle:'required'
    }, manage_nivel_precios);
    
    $('#mNivelPrecios').on('hidden.bs.modal', function(event) {
      $('#additional').html('');
      $('#mNivelPrecios input[name="detalle"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
    
		///// Cuando cambia el comercializador.
		$('#comercializador').on('change', function(e) {
			var country_id = $('#country_id').val();
			var module_id = $('#module_id').val();
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
		});
  });
  
  function manage_nivel_precios(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      if(response.success == true) {
        alert_float('success',response.message);
        if($('body').hasClass('contract') && typeof(response.id) != 'undefined') {
          var cnp = $('#nivel_precios');
          cnp.find('option:first').after('<option value="'+response.id+'">'+response.detalle+'</option>');
          cnp.selectpicker('val',response.id);
          cnp.selectpicker('refresh');
        }
      }
      if($.fn.DataTable.isDataTable('.table-price-level')) {
        $('.table-price-level').DataTable().ajax.reload();
      }
      $('#mNivelPrecios').modal('hide');
    });
    return false;
	}
	
	function new_nivel_precios() {
		var country_id = $('#country_id').val();
		var module_id = $('#module_id').val();
		$('#additional').append(hidden_input('country_id',country_id));
		$('#additional').append(hidden_input('module_id',module_id));
    $('#mNivelPrecios').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_nivel_precios(invoker,id) {
    var datos = $(invoker).data('name').split('=/=');
    var detalle = datos[0];
    var comercializador = datos[1];
    var tarifa = datos[2];
		var country_id = $('#country_id').val();
		var module_id = $('#module_id').val();
		$('#additional').append(hidden_input('country_id',country_id));
		$('#additional').append(hidden_input('module_id',module_id));
    $('#additional').append(hidden_input('id',id));
    // Se asigna valor del comercializador.
    $('#comercializador').val(comercializador);
		var soComercializador = $('#comercializador');
		soComercializador.selectpicker('refresh');
    // Se asigna valor de la tarifa.
		var url = $('#adminurl').val()+'/commissions/filtrar_tarifa/'+country_id+'/'+module_id;
    $.post(url).done(function (response) {
    	response = JSON.parse(response);
			$('#tarifa').children('option:not(:first)').remove();
			for (var i=0; i < response.length; i++) {
				$('#tarifa').append('<option value="'+response[i].id+'">'+response[i].descripcion+'</option>');
			}
			$('#tarifa').val(tarifa);
			var soTarifa = $('#tarifa');
			soTarifa.selectpicker('refresh');
    });
    // Asigna valor de detalle.
    $('#mNivelPrecios input[name="detalle"]').val(detalle);
    $('#mNivelPrecios').modal('show');
    $('.add-title').addClass('hide');
	}
	
</script>
