<div class="modal fade" id="mHoliday" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('time_controls/holiday'), array('id'=>'holiday-form')); ?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">
            <span class="edit-title"><?php echo _l('schedule_holiday_edit'); ?></span>
            <span class="add-title"><?php echo _l('schedule_new_holiday'); ?></span>
          </h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <?php echo render_date_input('holiday_date','timecontrol_date_add'); ?>
            </div>
            <div class="col-md-6">
              <div id="additional"></div>
              <?php echo render_input('holiday_reason', 'schedule_holiday_detail'); ?>
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
    _validate_form($('#holiday-form'), {
    	holiday_date:'required',
    	holiday_reason:'required'
    }, manage_holiday);
    
    $('#mHoliday').on('hidden.bs.modal', function(event) {
      $('#additional').html('');
      $('#mHoliday input[name="holiday_reason"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_holiday(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      if(response.success == true) alert_float('success',response.message);
      if($.fn.DataTable.isDataTable('.table-holidays')) $('.table-holidays').DataTable().ajax.reload();
      $('#mHoliday').modal('hide');
    });
    
    return false;
	}
	
	function new_holiday() {
    $('#mHoliday').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_holiday(invoker,id) {
    var data_name = $(invoker).data('name');
    var holiday_date = data_name.split('*_*')[0]
    var holiday_reason = data_name.split('*_*')[1];
    $('#additional').append(hidden_input('id',id));
    $('#mHoliday input[name="holiday_date"]').val(holiday_date);
    $('#mHoliday input[name="holiday_reason"]').val(holiday_reason);
    $('#mHoliday').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
