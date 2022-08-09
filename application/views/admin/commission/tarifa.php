<div class="modal fade" id="mTarifa" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('commissions/tarifa'), array('id'=>'tarifa-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('tarifa_edit'); ?></span>
                  <span class="add-title"><?php echo _l('new_tarifa'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div id="additional">
                	<input name="module_id" type="text" class="hidden">
                	<input name="country_id" type="text" class="hidden">
                </div>
                <?php echo render_input('descripcion', 'tarifa_descripcion'); ?>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
              <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
          </div>
      </div><!-- /.modal-content -->
      <?php echo form_close(); ?>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>

  window.addEventListener('load',function()  {
    _validate_form($('#tarifa-form'), {	descripcion:'required' }, manage_tarifa);
    $('#mTarifa').on('hidden.bs.modal', function(event) 
    {
      $('#additional').html('');
      $('#mTarifa input[name="descripcion"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
	function manage_tarifa(form) {
		var country_id = $('#mTarifa input[name="country_id"]').val();
		if (country_id=='' || country_id=='0') {
			alert_float('success','Seleccione el pais');
			return false;
		}
		var module_id = $('#mTarifa input[name="module_id"]').val();
		if (module_id=='' || module_id=='0') {
			alert_float('success','Seleccione el módulo');
			return false;
		}

  	var data = $(form).serialize();
  	var url = form.action;
  	$.post(url, data).done(function(response) {
    	response = JSON.parse(response);
      if(response.success == true) {
        alert_float('success',response.message);
        if($('body').hasClass('contract') && typeof(response.id) != 'undefined') {
          var ctarifa = $('#tarifa');
          ctarifa.find('option:first').after('<option value="'+response.id+'">'+response.descripcion+'</option>');
          ctarifa.selectpicker('val',response.id);
          ctarifa.selectpicker('refresh');
        }
      }
      if($.fn.DataTable.isDataTable('.table-rate')) {
      	$('.table-rate').DataTable().ajax.reload();
      }
      $('#mTarifa').modal('hide');
  	});
  	
  	return false;
	}
	
	function new_tarifa() {
		var country_id = $('#country_id').val();
		if (country_id=='' || country_id=='0') {
			alert_float('success','Seleccione el pais');
			return false;
		}
		var module_id = $('#module_id').val();
		if (module_id=='' || module_id=='0') {
			alert_float('success','Seleccione el módulo');
			return false;
		}
		
		$('#mTarifa input[name="module_id"]').val(module_id);
		$('#mTarifa input[name="country_id"]').val(country_id);
		
   	$('#mTarifa').modal('show');
   	$('.edit-title').addClass('hide');
	}
	
	function edit_tarifa(invoker,id) {
		var country_id = $('#country_id').val();
		if (country_id=='' || country_id=='0') {
			alert_float('success','Seleccione el pais');
			return false;
		}
		var module_id = $('#module_id').val();
		if (module_id=='' || module_id=='0') {
			alert_float('success','Seleccione el módulo');
			return false;
		}
		
		$('#mTarifa input[name="module_id"]').val(module_id);
		$('#mTarifa input[name="country_id"]').val(country_id);
		
  	var descripcion = $(invoker).data('name');
  	$('#additional').append(hidden_input('id',id));
  	$('#mTarifa input[name="descripcion"]').val(descripcion);
  	$('#mTarifa').modal('show');
  	$('.add-title').addClass('hide');
	}
	
	///// Obtiene cambio en el tipo.
	function change(id) {
		$('#mTarifa input[name="module"]').val(id);
	}
	
</script>