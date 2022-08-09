<div class="modal fade" id="mStresslevel" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('commissions/stress_level'), array('id'=>'stresslevel-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('stress_level_edit'); ?></span>
                  <span class="add-title"><?php echo _l('new_stress_level'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      <div id="additional"></div>
                      <?php echo render_input('nombre', 'stress_level_name'); ?>
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
    _validate_form($('#stresslevel-form'), {nombre:'required'}, manage_stress_level);
    $('#mStresslevel').on('hidden.bs.modal', function(event) 
    {
      $('#additional').html('');
      $('#mStresslevel input[name="nombre"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_stress_level(form)
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
          var ccc = $('#nivel_tension');
          ccc.find('option:first').after('<option value="'+response.id+'">'+response.nombre+'</option>');
          ccc.selectpicker('val',response.id);
          ccc.selectpicker('refresh');
        }
      }
      if($.fn.DataTable.isDataTable('.table-stress-level'))
      {
        $('.table-stress-level').DataTable().ajax.reload();
      }
      $('#mStresslevel').modal('hide');
    });
    return false;
	}
	
	function new_stress_level()
	{
    $('#mStresslevel').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_stress_level(invoker,id)
	{
    var nombre = $(invoker).data('name');
    $('#additional').append(hidden_input('id',id));
    $('#mStresslevel input[name="nombre"]').val(nombre);
    $('#mStresslevel').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
