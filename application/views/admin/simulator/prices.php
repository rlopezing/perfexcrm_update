<div class="modal fade" id="mPrices" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('simulators/prices'), array('id'=>'prices-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('simulator_finished_edit'); ?></span>
                  <span class="add-title"><?php echo _l('simulator_finished_new'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      <div id="additional"></div>
                      <?php echo render_input('detalle', 'simulator_detail'); ?>
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
    _validate_form($('#prices-form'), {	detalle:'required' }, manage_prices);
    $('#mPrices').on('hidden.bs.modal', function(event) 
    {
      $('#additional').html('');
      $('#mPrices input[name="detalle"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_prices(form)
  {
    var data = $(form).serialize();
    var url = form.action;
    console.log(url);
    console.log(data);
    $.post(url, data).done(function(response)
    {
      response = JSON.parse(response);
      console.log(response);
      if(response.success == true)
      {
        alert_float('success',response.message);
        if($('body').hasClass('contract') && typeof(response.id) != 'undefined')
        {
          var ctarifa = $('#tarifa');
          ctarifa.find('option:first').after('<option value="'+response.id+'">'+response.descripcion+'</option>');
          ctarifa.selectpicker('val',response.id);
          ctarifa.selectpicker('refresh');
        }
      }
      if($.fn.DataTable.isDataTable('.table-prices'))
      {
        $('.table-prices').DataTable().ajax.reload();
      }
      $('#mPrices').modal('hide');
    });
    return false;
	}
	
	function new_prices()
	{
    $('#mPrices').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_prices(invoker,id)
	{
		var detalle = $(invoker).data('name');
    $('#additional').append(hidden_input('id',id));
    $('#mPrices input[name="detalle"]').val(detalle);
    $('#mPrices').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
