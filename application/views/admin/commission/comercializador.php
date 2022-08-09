<div class="modal fade" id="mComercializador" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('commissions/comercializador'), array('id'=>'comercializador-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('comercializador_edit'); ?></span>
                  <span class="add-title"><?php echo _l('new_comercializador'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <div id="additional"></div>
                    <?php echo render_input('nombre', 'comercializador_name'); ?>
                  </div>
                  <div class="form-group select-placeholder col-md-6">
	                  <?php
	                  	$url_client = admin_url('clients/client');
	                    echo render_select_with_input_group('cliente',$clients,array('userid','company'),'general_map_client',$selected,'<a href="'.$url_client.'"><i class="fa fa-plus"></i></a>');
	                  ?>
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

  window.addEventListener('load',function() {
    _validate_form($('#comercializador-form'), {nombre:'required'}, manage_comercializador);
    $('#mComercializador').on('hidden.bs.modal', function(event) {
      $('#additional').html('');
      $('#mComercializador input[name="nombre"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_comercializador(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      if(response.success == true) {
        alert_float('success',response.message);
        if($('body').hasClass('contract') && typeof(response.id) != 'undefined') {
          var ctype = $('#comercializador');
          ctype.find('option:first').after('<option value="'+response.id+'">'+response.name+'</option>');
          ctype.selectpicker('val',response.id);
          ctype.selectpicker('refresh');
        }
      }
      if($.fn.DataTable.isDataTable('.table-marketer')) {
        $('.table-marketer').DataTable().ajax.reload();
      }
      $('#mComercializador').modal('hide');
    });
    return false;
	}
	
	function new_comercializador() {
    $('#mComercializador').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_comercializador(invoker,id) {
    var nombre = $(invoker).data('name').split("*/*")[0];
    var valida = $(invoker).data('name').split("*/*")[1];
    
    $('#additional').append(hidden_input('id',id));
    $('#mComercializador input[name="nombre"]').val(nombre);
    if (valida!="") $('#mComercializador input[name="nombre"]').attr(valida, true);
    $('#mComercializador').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
