<div class="modal fade" id="mHoliday_associate" role="dialog">
	<div class="modal-dialog">
    <?php echo form_open(admin_url('time_controls/holiday_associate'), array('id'=>'holiday-associate-form')); ?>
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
              <?php echo render_select('holidayid',$holidays,array('holidayid','holiday_reason'),'schedule_holidays'); ?>
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
    _validate_form($('#holiday-associate-form'), {
    	holidayid : 'required'
    }, manage_holiday_associate);
    
    $('#mHoliday_associate').on('hidden.bs.modal', function(event) {
      $('#additional').html('');
      $('#mHoliday_associate input[name="holidayid"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_holiday_associate(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      if(response.success == true) {
      	alert_float('success',response.message);
			}
      if($.fn.DataTable.isDataTable('.table-holidays-schedule')) $('.table-holidays-schedule').DataTable().ajax.reload();
      $('#mHoliday_associate').modal('hide');
      location.reload();
    });
    
    return false;
	}
	
	function new_holiday_associate() {
		var scheduleid = $('#scheduleid').val();
		$('#additional').append(hidden_input('scheduleid',scheduleid));
    $('#mHoliday_associate').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_holiday_associate(invoker,id) {
    var holidayid = $(invoker).data('name');
		var scheduleid = $('#scheduleid').val();
		$('#additional').append(hidden_input('scheduleid',scheduleid));
    $('#mHoliday_associate input[name="holidayid"]').val(holidayid);
    $('#mHoliday_associate').modal('show');
    $('.add-title').addClass('hide');
	}
</script>
