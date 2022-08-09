<div class="modal fade" id="mStaffassign" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('commissions/staff_assign'), array('id'=>'staffassign-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('commissions_assign_new'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div id="additional1"></div>
                <label class="control-label"><?php echo _l('commissions_staff'); ?></label>
                <h4 id="name" style="color: #07a4f8"></h4>
              </div>
              <div class="col-md-6">
                <div id="additional2"></div>
                <label class="control-label"><?php echo _l('commissions_email'); ?></label>
                <h4 id="email" style="color: #07a4f8"></h4>
              </div>
            </div>
            <br />
            <div class="row">
					    <div class="form-group select-placeholder col-md-6">
			        	<?php echo render_select('commercial_category',$commercial_category,array('id','detalle'),'commissions_commercial_category'); ?>
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
    _validate_form($('#staffassign-form'), {commercial_category:'required'}, manage_staff_assign);
    $('#mStaffassign').on('hidden.bs.modal', function(event) {
      $('#additional1').html('');
      $('#additional2').html('');
      $('#email').html('');
      $('#name').html('');
      $('#mStaffassign input[name="commercial_category"]').val('');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_staff_assign(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);

      if($.fn.DataTable.isDataTable('.table-staff-assign')) {
        $('.table-staff-assign').DataTable().ajax.reload();
      }
      $('#mStaffassign').modal('hide');
    });
    
    return false;
	}
	
	function staff_assign(invoker,id) {
    var data = $(invoker).data('name').split('*/*');
    var email = data[0];
    var name = data[1]
    var commercial_category = data[2];
    var staff = data[3];
    
    if (typeof(id) != 'undefined') $('#additional1').append(hidden_input('id',id));
    $('#email').html(email);
    $('#additional2').append(hidden_input('staff',staff));
    $('#name').html(name);
    $('#mStaffassign input[name="commercial_category"]').val(commercial_category);
    
    $('#mStaffassign').modal('show');
	}
	
</script>
