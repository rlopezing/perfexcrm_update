<div class="modal fade" id="mCommercialCategory" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('commissions/commercial_category'), array('id'=>'commercial-category-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('commercial_category_edit'); ?></span>
                  <span class="add-title"><?php echo _l('new_commercial_category'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      <div id="additional"></div>
                      <?php echo render_input('detalle', 'commercial_category_detalle'); ?>
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
  window.addEventListener('load', function() {
    _validate_form($('#commercial-category-form'), {
    	detalle:'required'
    }, manage_commercial_category);
    
    $('#mCommercialCategory').on('hidden.bs.modal', function(event) {
      $('#additional').html('');
      $('#mCommercialCategory input[name="detalle"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_commercial_category(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      if(response.success == true) {
        alert_float('success',response.message);
        if($('body').hasClass('contract') && typeof(response.id) != 'undefined') {
          var ccc = $('#categoria_comercial');
          ccc.find('option:first').after('<option value="'+response.id+'">'+response.detalle+'</option>');
          ccc.selectpicker('val',response.id);
          ccc.selectpicker('refresh');
        }
      }
      if($.fn.DataTable.isDataTable('.table-commercial-category')) {
        $('.table-commercial-category').DataTable().ajax.reload();
      }
      $('#mCommercialCategory').modal('hide');
    });
    
    return false;
	}
	
	function new_commercial_category() {
		var country_id = $('#country_id').val();
		$('#additional').append(hidden_input('country_id',country_id));
    $('#mCommercialCategory').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_commercial_category(invoker,id) {
    var detalle = $(invoker).data('name');
		var country_id = $('#country_id').val();
		$('#additional').append(hidden_input('country_id',country_id));
    $('#additional').append(hidden_input('id',id));
    $('#mCommercialCategory input[name="detalle"]').val(detalle);
    $('#mCommercialCategory').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
