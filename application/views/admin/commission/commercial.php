<div class="modal fade" id="mCommercial" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('commissions/commercial'), array('id'=>'commercial-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('commercial_edit'); ?></span>
                  <span class="add-title"><?php echo _l('new_commercial'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      <div id="additional"></div>
                      <?php echo render_input('nombre', 'commercial_detalle'); ?>
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
  window.addEventListener('load',function()
  {
    _validate_form($('#commercial-form'), {nombre:'required'}, manage_commercial);
    $('#mCommercial').on('hidden.bs.modal', function(event) 
    {
      $('#additional').html('');
      $('#mCommercial input[name="nombre"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_commercial(form)
  {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response)
    {
      response = JSON.parse(response);
      if(response.success == true)
      {
        alert_float('success',response.message);
        if($('body').hasClass('contract') && typeof(response.id) != 'undefined')
        {
          var ccc = $('#comercial');
          ccc.find('option:first').after('<option value="'+response.id+'">'+response.nombre+'</option>');
          ccc.selectpicker('val',response.id);
          ccc.selectpicker('refresh');
        }
      }
      if($.fn.DataTable.isDataTable('.table-contract-types'))
      {
        $('.table-contract-types').DataTable().ajax.reload();
      }
      $('#mCommercial').modal('hide');
    });
    return false;
	}
	
	function new_commercial()
	{
    $('#mCommercial').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_commercial(invoker,id)
	{
    var detalle = $(invoker).data('detalle');
    $('#additional').append(hidden_input('id',id));
    $('#mCommercial input[name="nombre"]').val(detalle);
    $('#mCommercial').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
