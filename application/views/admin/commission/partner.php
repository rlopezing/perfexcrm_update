<div class="modal fade" id="mPartner" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('commissions/partner'), array('id'=>'partner-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('partner_edit'); ?></span>
                  <span class="add-title"><?php echo _l('new_partner'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
              <div class="row">
			          <div class="form-group select-placeholder col-md-6">
			          	<?php
			             	$selected = (isset($plan) ? $plan->categoria_comercial : '');
			             	echo render_select('categoria_comercial',$commercial_category,array('id','detalle'),'commercial_category',$selected);
			            ?>
			          </div>
                <div class="col-md-6">
                    <div id="additional"></div>
                    <?php echo render_input('nombre', 'partner_name'); ?>
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
    _validate_form($('#partner-form'), {nombre:'required',categoria_comercial:'required'}, manage_partner);
    $('#mPartner').on('hidden.bs.modal', function(event) 
    {
      $('#additional').html('');
      $('#mPartner input[name="nombre"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_partner(form)
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
          var ccc = $('#socio');
          ccc.find('option:first').after('<option value="'+response.id+'">'+response.nombre+'</option>');
          ccc.selectpicker('val',response.id);
          ccc.selectpicker('refresh');
        }
      }
      
      if($.fn.DataTable.isDataTable('.table-contract-types'))
      {
        $('.table-contract-types').DataTable().ajax.reload();
      }
      
      $('#mPartner').modal('hide');
    });
    return false;
	}
	
	function new_partner()
	{
        $('#mPartner').modal('show');
        $('.edit-title').addClass('hide');
	}
	
	function edit_partner(invoker,id)
	{
    var detalle = $(invoker).data('detalle');
    $('#additional').append(hidden_input('id',id));
    $('#mPartner input[name="nombre"]').val(detalle);
    $('#mPartner').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
