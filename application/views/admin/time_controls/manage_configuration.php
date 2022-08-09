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
              		<div class="col-md-3">
              			<a class="text-uppercase pull-left"><h3><strong><?php echo $title; ?></strong></h3></a>
									</div>
								</div>
								<div class="row">
									<?php echo form_open(admin_url('time_controls/configuration'), array('id'=>'configuration-form')); ?>
			            	<div class="col-md-8">
			            		<hr class="hr" />
		            			<div class="col-md-6">
			                	<?php $value = (isset($schedule) ? $schedule->name : ''); ?>
				                <?php echo render_input('name','schedule_name',$value); ?>
			                </div>
		                  <div class="form-group select-placeholder col-md-6">
		                  	<?php $selected = (isset($schedule) ? $schedule->modalityid : ''); ?>
												<?php echo render_select_with_input_group('modalityid',$modalitys,array('modalityid','name'),'schedule_modality',$selected); ?>
											</div>
		                  <div class="form-group col-md-3">
		                  	<label for="entry_time" class="control-label"><?php echo _l('timecontrol_entry'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a href="#" onclick="fichar('entry_time'); return false;"><i class="fa fa-check"></i></a>
	                        </span>
	                        <?php $value = (isset($schedule) ? $schedule->entry_time : '00:00:00'); ?>
	                        <input type="text" class="form-control text-center" name="entry_time" value="<?php echo $value; ?>">
	                     	</div>
		                  </div>
			                <div class="form-group col-md-3">
		                  	<label for="deaperture_time" class="control-label"><?php echo _l('timecontrol_departure'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a href="#" onclick="fichar('departure_time'); return false;"><i class="fa fa-check"></i></a>
	                        </span>
	                        <?php $value = (isset($schedule) ? $schedule->departure_time : '00:00:00'); ?>
	                        <input type="text" class="form-control text-center" name="departure_time" value="<?php echo $value; ?>">
	                     	</div>
			                </div>
											<div class="form-group col-md-3">
		                  	<label for="rest_start" class="control-label"><?php echo _l('timecontrol_rest_start'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a href="#" onclick="fichar('rest_start'); return false;"><i class="fa fa-check"></i></a>
	                        </span>
	                        <?php $value = (isset($schedule) ? $schedule->rest_start : '00:00:00'); ?>
	                        <input type="text" class="form-control text-center" name="rest_start" value="<?php echo $value; ?>">
	                     	</div>
											</div>
			                <div class="form-group col-md-3">
		                  	<label for="end_rest" class="control-label"><?php echo _l('timecontrol_end_rest'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a href="#" onclick="fichar('end_rest'); return false;"><i class="fa fa-check"></i></a>
	                        </span>
	                        <?php $value = (isset($schedule) ? $schedule->end_rest : '00:00:00'); ?>
	                        <input type="text" class="form-control text-center" name="end_rest" value="<?php echo $value; ?>">
	                     	</div>
			                </div>
			                <div class="form-group col-md-12">
			                	<br />
			                	<div class="form-group col-md-12" style="padding: 0px;">
			                		<label class="control-label"><?php echo _l('schedule_weekly_holidays'); ?></label>
			                	</div>
			                	<?php	
											  	$wh = array("schedule_monday"=>0,
											  							"schedule_tuesday"=>0,
											  							"schedule_wednesday"=>0,
											  							"schedule_thursday"=>0,
											  							"schedule_friday"=>0,
											  							"schedule_saturday"=>0,
											  							"schedule_sunday"=>0);
			                		$weekly_holidays = (isset($schedule) ? json_decode($schedule->weekly_holidays) : json_decode(json_encode($wh))); 
			                	?>
	                     	<div class="checkbox checkbox-primary no-mtop checkbox-inline">
	                        <input type="checkbox" id="schedule_monday" name="schedule_monday"<?php if($weekly_holidays->{'schedule_monday'} == 1){echo ' checked';} ?>>
	                        <label for="schedule_monday"><?php echo _l('schedule_monday'); ?></label>
	                     	</div>
	                     	<div class="checkbox checkbox-primary checkbox-inline">
	                        <input type="checkbox" name="schedule_tuesday" id="schedule_tuesday" <?php if($weekly_holidays->{'schedule_tuesday'} == 1){echo 'checked';} ?>>
	                        <label for="schedule_tuesday"><?php echo _l('schedule_tuesday'); ?></label>
	                     	</div>
	                     	<div class="checkbox checkbox-primary checkbox-inline">
	                        <input type="checkbox" name="schedule_wednesday" id="schedule_wednesday" <?php if($weekly_holidays->{'schedule_wednesday'} == 1){echo 'checked';} ?>>
	                        <label for="schedule_wednesday"><?php echo _l('schedule_wednesday'); ?></label>
	                     	</div>
	                     	<div class="checkbox checkbox-primary checkbox-inline">
	                        <input type="checkbox" name="schedule_thursday" id="schedule_thursday" <?php if($weekly_holidays->{'schedule_thursday'} == 1){echo 'checked';} ?>>
	                        <label for="schedule_thursday"><?php echo _l('schedule_thursday'); ?></label>
	                     	</div>
	                     	<div class="checkbox checkbox-primary checkbox-inline">
	                        <input type="checkbox" name="schedule_friday" id="schedule_friday" <?php if($weekly_holidays->{'schedule_friday'} == 1){echo 'checked';} ?>>
	                        <label for="schedule_friday"><?php echo _l('schedule_friday'); ?></label>
	                     	</div>
	                     	<div class="checkbox checkbox-primary checkbox-inline">
	                        <input type="checkbox" name="schedule_saturday" id="schedule_saturday" <?php if($weekly_holidays->{'schedule_saturday'} == 1){echo 'checked';} ?>>
	                        <label for="schedule_saturday"><?php echo _l('schedule_saturday'); ?></label>
	                     	</div>
	                     	<div class="checkbox checkbox-primary checkbox-inline">
	                        <input type="checkbox" name="schedule_sunday" id="schedule_sunday" <?php if($weekly_holidays->{'schedule_sunday'} == 1){echo 'checked';} ?>>
	                        <label for="schedule_sunday"><?php echo _l('schedule_sunday'); ?></label>
	                     	</div>
	                     	<?php $value = (isset($schedule) ? $schedule->weekly_holidays : ''); ?>
	                     	<input type="text" class="form-control text-center hidden" name="weekly_holidays" value="<?php echo $value; ?>">
			                </div>
							        <div class="col-md-12 text-right">
			                	<div class="additional hidden">
			                		<?php echo(isset($schedule) ? render_input('scheduleid', '',$schedule->scheduleid,'') : '');	?>
			                	</div>
							        	<hr class="hr" />
							        	<button type="submit" class="btn btn-info"><?php echo _l('schedule_save'); ?></button>
							        </div>
						        </div>
                	<?php echo form_close(); ?>
                	<hr class="hr" />
                	<div class="col-md-4 text-left pre-scrollable" style="height: 330px;">
	                	<div class="form-group col-md-12" style="padding: 0px;">
	                		<div class="col-md-4">
	                			<a class="text-uppercase pull-left"><h4><?php echo _l('schedule_holidays'); ?></h4></a>
	                		</div>
	                		<?php if (isset($schedule)) { ?>
		                		<div class="col-md-8 text-right">
		                			<button type="button" class="btn btn-info" onclick="new_holiday_associate();"><?php echo _l('schedule_associate'); ?></button>
		                		</div>
	                		<?php } ?>
	                	</div>
					          <table class="table table-holidays-schedule">
					            <thead><tr>
				                <th><?php echo _l('timecontrol_date_add'); ?></th>
				                <th><?php echo _l('timecontrol_reason'); ?></th>
				                <th><?php echo _l('schedule_opc'); ?></th>
					            </tr></thead>
					            <?php if (isset($schedule)) { ?>
					            <tbody>
					              <?php foreach($schedule_holidays as $c_admin) { ?>
					              <tr>
					                <td data-order="<?php echo $c_admin['holiday_date']; ?>">
					                	<?php echo _d(date("d-m-Y", strtotime($c_admin['holiday_date']))); ?>
					                </td>
					                <td data-order="<?php echo $c_admin['holiday_reason']; ?>">
					                	<?php echo $c_admin['holiday_reason']; ?>
					                </td>
					                <td>
					                  <a href="<?php echo admin_url('time_controls/delete_holiday_associate/'.$c_admin['scheduleholidayid'].'/'.$c_admin['scheduleid']); ?>" class="btn btn-danger _delete btn-icon"><i class="fa fa-remove"></i></a>
													</td>
					              </tr>
					              <?php } ?>
					            </tbody>
					            <?php } ?>
					          </table>
                	</div>
								</div>
							</div>
          	</div>
          </div>
          <div class="panel_s">
            <div class="panel-body">
              <?php render_datatable(array(
						    '#',
						    _l('schedule'),
						    _l('schedule_modality'),
						    _l('timecontrol_entry'),
						    _l('timecontrol_departure'),
						    _l('timecontrol_rest_start'),
						    _l('timecontrol_end_rest'),
              ),'configurations'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>    
  <?php init_tail(); ?>
  <?php if(isset($schedule)) { ?>
  <?php $this->load->view('admin/time_controls/holiday_associate'); ?>
  <?php } ?>
  <script>
		$(function() {
			initDataTable('.table-configurations', window.location.href, [3], [3]);
	 	});
  	  
	  $("#configuration-form").on('submit', function(evt) {
	  	if ($('#name').val() == "") {
				alert_float('success',"Introduzca un nombre");
				evt.preventDefault();
			}
	  	if ($('#modalityid option:selected').val().trim() == "") {
				alert_float('success',"Seleccione una modalidad");
				evt.preventDefault();
			}
	  	if ($('input[name=entry_time]').val() == "00:00:00") {
				alert_float('success',"Introduzca hora de entrada");
				evt.preventDefault();
			}
	  	if ($('input[name=departure_time]').val().trim() == "00:00:00") {
				alert_float('success',"Introduzca hora de salida");
				evt.preventDefault();
			}
	  	if ($('input[name=rest_start]').val().trim() == "00:00:00") {
				alert_float('success',"Introduzca inicio del descanso");
				evt.preventDefault();
			}
	  	if ($('input[name=end_rest]').val().trim() == "00:00:00") {
				alert_float('success',"Introduzca fin del descanso");
				evt.preventDefault();
			}
		});
	  
  </script>
</body>
</html>