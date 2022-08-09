<?php init_head(); ?>
	<div id="wrapper">
  	<div class="content">
    	<div class="row">
      	<div class="col-md-12">
        	<?php if($email_exist_as_staff) { ?>
	          <div class="alert alert-danger">
	            Some of the general map email is used as staff member email, according to the docs, the support general map email must be unique email in the system, you must change the staff email or the support general map email in order all the features to work properly.
	          </div>
          <?php } ?>
          <div class="panel_s">
            <div class="panel-body">
              <div class="_buttons">
              	<div class="row">
              		<div class="col-md-6">
              			<a class="text-uppercase pull-left"><h3><strong><?php echo $title; ?></strong></h3></a>
									</div>
								</div>
              	<div class="row">
									<?php echo form_open(admin_url('time_controls/assignment'), array('id'=>'assignment-form')); ?>
	                  <div class="form-group select-placeholder col-md-4">
	                  	<?php $selected = (isset($assign) ? $assign->staffid : ''); ?>
		                  <?php echo render_select_with_input_group('staffid',$staff_members,array('staffid','full_name'),'timecontrol_staff',$selected); ?>
	                  </div>
	                  <div class="form-group select-placeholder col-md-4">
	                  	<?php $selected = (isset($assign) ? $assign->scheduleid : ''); ?>
		                  <?php echo render_select_with_input_group('scheduleid',$schedules,array('scheduleid','name'),'schedule',$selected); ?>
	                  </div>
		                <div class="col-md-2">
		                	<?php $value = (isset($assign) ? date('d-m-Y', strtotime($assign->start_date)) : _d(date('Y-m-d'))); ?>
			                <?php echo render_date_input('start_date','schedule_contract_start',$value); ?>
		                </div>
		                <div class="col-md-2">
		                	<?php $value = (isset($assign) ? date('d-m-Y', strtotime($assign->end_date)) : _d(date('Y-m-d'))); ?>
			                <?php echo render_date_input('end_date','schedule_contract_end',$value); ?>
		                </div>
		                <div class="col-md-2">
		                	<div class="additional hidden">
		                		<?php echo(isset($assign) ? render_input('scheduleassignmentid', '',$assign->scheduleassignmentid,'') : '');	?>
		                	</div>
		                	<button type="submit" class="btn btn-info"><?php echo(isset($assign) ? _l('schedule_save') : _l('schedule_assign')); ?></button>
		                </div>
	                <?php echo form_close(); ?>
                </div>
							</div>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
              <div class="clearfix"></div>
              <?php render_datatable(array(
						    _l('#'),
						    _l('timecontrol_staff'),
						    _l('schedule'),
						    _l('schedule_modality'),
						    _l('schedule_contract_start'),
						    _l('schedule_contract_end')
              ),'assignments'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>    
  <?php init_tail(); ?>
  <script>
  
		$(function() {
			initDataTable('.table-assignments', window.location.href, [3], [3]);
	 	});
  		
  </script>
</body>
</html>