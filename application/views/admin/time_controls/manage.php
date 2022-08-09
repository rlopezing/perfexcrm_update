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
              		<div class="col-md-4">
              			<a class="text-uppercase pull-left"><h3><strong><?php echo $title; ?></strong></h3></a>
									</div>
								</div>
              	<div class="row">
									<?php echo form_open(admin_url('time_controls/filter'), array('id'=>'form-filter')); ?>
										<?php if (has_permission('time_controls','','filter')) { ?>
		                  <div class="form-group select-placeholder col-md-4">
		                  	<?php $selected = (isset($staffid) ? $staffid : ""); ?>
		                  	<?php if ($selected == "") $selected = (isset($time_control) ? $time_control['staffid'] : ""); ?>
			                  <?php echo render_select_with_input_group('staffid',$staff_members,array('staffid','full_name'),'timecontrol_staff',$selected); ?>
		                  </div>
	                  <?php } ?>
										<div class="col-md-3">
											<?php $value = (isset($date_from) ? $date_from : _d(date('Y-m-d'))); ?>
											<?php echo render_date_input('date_from','general_map_date_from',$value); ?>
										</div>
		                <div class="col-md-3">
		                	<?php $value = (isset($date_up) ? $date_up : _d(date('Y-m-d'))); ?>
		                	<?php echo render_date_input('date_up','general_map_date_up',$value); ?>
		                </div>
		                <div class="col-md-2" style="padding-top: 25px;">
		                	<button type="submit" class="btn btn-info"><?php echo _l('timecontrol_filter'); ?></button>
		                </div>
	                <?php echo form_close(); ?>
                </div>
	              <div class="clearfix"></div>
	              <hr class="hr-panel-heading" />
	              <div class="clearfix"></div>
                <div class="panel-body">
	            		<div class="row">
	            			<?php
	            				if (!is_admin()) {
		            				if (is_null($time_control['entry_time'])) {
			            				$entry_time = "enabled";
			            				$departure_time = $rest_start = $end_rest = "disabled";
												} else {
			            				$entry_time = "disabled";
			            				$departure_time = $rest_start = $end_rest = "enabled";
												}
												if (is_null($time_control['rest_start']) || $time_control['rest_start'] == '00:00:00') {
													$rest_start = "enabled";
													$end_rest = "disabled";
												} else {
													$rest_start = "disabled";
													$end_rest = "enabled";
												}
												if (!is_null($time_control['departure_time']) && $time_control['departure_time'] != '00:00:00') {
													$entry_time = $departure_time = $rest_start = $end_rest = "disabled";
												}
												$readonly = "readonly";
											} else {
												$readonly = "";
												$entry_time = $departure_time = $rest_start = $end_rest = "";
											}
											
											$rest = json_decode($time_control['rest']);
											//log_message('debug', "rest: ".print_r($rest, TRUE));
											if (count($rest) == 6) $rest_start = $end_rest = "disabled";
	            			?>
	            			<div class="col-md-12"><h4><?php echo _l('timecontrol_signing'); ?>: </h4></div>
										<?php echo form_open(admin_url('time_controls/signing/edit'), array('id'=>'form-signing')); ?>
		                  <div class="form-group col-md-2">
		                  	<label for="entry_time" class="control-label"><?php echo _l('timecontrol_entry'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a class="<?php echo $entry_time; ?>" href="<?php echo admin_url('time_controls/signing/entry_time'); ?>"><i class="fa fa-check"></i></a>
	                        </span>
	                        <?php $value = (isset($time_control) ? $time_control['entry_time'] : '00:00:00'); ?>
	                        <?php if ($value == "") $value = '00:00:00'; ?>
	                        <input type="text" class="form-control" name="entry_time" value="<?php echo $value; ?>" style="text-align: center;" <?php echo $readonly; ?> <?php echo $entry_time; ?>>
	                     	</div>
		                  </div>
			                <div class="form-group col-md-2">
		                  	<label for="deaperture_time" class="control-label"><?php echo _l('timecontrol_departure'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a class="<?php echo $departure_time; ?>" href="<?php echo admin_url('time_controls/signing/departure_time'); ?>" <?php echo $departure_time; ?>><i class="fa fa-check"></i></a>
	                        </span>
	                        <?php $value = (isset($time_control) ? $time_control['departure_time'] : '00:00:00'); ?>
	                        <?php if ($value == "") $value = '00:00:00'; ?>
	                        <input type="text" class="form-control" name="departure_time" value="<?php echo $value; ?>" style="text-align: center;" <?php echo $readonly; ?> <?php echo $departure_time; ?>>
	                     	</div>
			                </div>
											<div class="form-group col-md-2">
		                  	<label for="rest_start" class="control-label"><?php echo _l('timecontrol_rest_start'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a class="<?php echo $rest_start; ?>" href="<?php echo admin_url('time_controls/signing/rest_start'); ?>">
	                        		<i class="fa fa-check"></i>
	                        	</a>
	                        </span>
	                        <?php $value = (isset($time_control) ? $time_control['rest_start'] : '00:00:00'); ?>
	                        <?php if ($value == "") $value = '00:00:00'; ?>
	                        <input type="text" class="form-control" name="rest_start" value="<?php echo $value; ?>" style="text-align: center;" <?php echo $readonly; ?> <?php echo $rest_start; ?>>
	                     	</div>
											</div>
			                <div class="form-group col-md-2">
		                  	<label for="end_rest" class="control-label"><?php echo _l('timecontrol_end_rest'); ?></label>
	                     	<div class="input-group">
	                        <span class="input-group-addon">
	                        	<a class="<?php echo $end_rest; ?>" href="<?php echo admin_url('time_controls/signing/end_rest'); ?>">
	                        		<i class="fa fa-check"></i></a>
	                        </span>
	                        <?php $value = (isset($time_control) ? $time_control['end_rest'] : '00:00:00'); ?>
	                        <?php if ($value == "") $value = '00:00:00'; ?>
	                        <input type="text" class="form-control" name="end_rest" value="<?php echo $value; ?>" style="text-align: center;" <?php echo $readonly; ?> <?php echo $end_rest; ?>>
	                     	</div>
			                </div>
			                <div class="form-group col-md-4" style="padding-top: 25px;">
				                <?php  if (is_admin()) { ?>
				                	<?php  if (isset($operation)) { ?>
				                		<?php $value = (isset($time_control) ? $time_control['timecontrolid'] : ''); ?>
				                		<input name="timecontrolid" class="hidden" type="text" value="<?php echo $value; ?>">
				                		<?php $value = (isset($time_control) ? $time_control['staffid'] : ''); ?>
				                		<input name="staffid" class="hidden" type="text" value="<?php echo $value; ?>">
				                		<?php $value = (isset($time_control) ? $time_control['rest'] : ''); ?>
				                		<input name="rest" class="hidden" type="text" value="<?php echo $value; ?>">
						            		<a href="<?php echo admin_url('time_controls'); ?>" class="btn btn-success pull-left display-block">
						            			<?php echo _l('schedule_cancel'); ?>
						            		</a>
				                		<button type="submit" class="btn btn-info" style="margin-left: 5px;"><?php echo _l('schedule_save'); ?></button>
					                <?php } ?>
					              <?php } ?>
				            	</div>
		                <?php echo form_close(); ?>
		              </div>
		              <div class="row" style="padding: 0px; margin: 0px;">
		              	<?php if (count($rest) > 0) { ?>
			              	<div class="form-group col-md-12" style="padding: 0px; margin: 0px;">
			              		<h5><?php echo _l('timecontrol_rest'); ?>: </h5>
			              	</div>
											<div class="form-group col-md-12" style="padding: 0px; margin: 0px;">
												<?php
													if (count($rest) > 0) {
														for ($i=0;$i<count($rest);$i++) {
															$output = explode(":",$rest[$i]->output)[0].":".explode(":",$rest[$i]->output)[1].":".explode(":",$rest[$i]->output)[2];
															$input 	= explode(":",$rest[$i]->input)[0].":".explode(":",$rest[$i]->input)[1].":".explode(":",$rest[$i]->input)[2];
															if (is_admin()) {
																if (isset($operation)) {
																	if ($operation == "edit") $edited = "contenteditable='true'";	
																}
															}
												?>
															<div class="form-group col-md-2" style="padding: 0px; margin: 0px;">
																<div class="alert alert-info alert-dismissible text-center" role="alert" style="margin: 2px;">
																  <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="rest_clean(<?php echo $i; ?>);" value="<?php echo $i; ?>">
																  	<span aria-hidden="true">&times;</span>
																  </button>
																  <table id="rest_sign">
																  	<tbody>
																  		<tr><td class="text-right"><strong>Out:</strong></td><td <?php echo $edited; ?>><?php echo $output; ?></td></tr>
																  		<tr><td class="text-right"><strong>Inp:</strong></td><td <?php echo $edited; ?>><?php echo $input; ?></td></tr>
																  	</tbody>
																  </table>
																</div>
															</div>
											<?php } ?>
										<?php } ?>
											</div>
							<?php } ?>	
		              </div>
	              </div>
	              <?php if (has_permission('time_controls', '', 'mysdays') || is_admin()) { ?>
		              <div class="panel-body">
		              	<?php echo form_open(admin_url('time_controls/myday'), array('id'=>'myday-form')); ?>
		            			<div class="row">
		            				<div class="col-md-12" style="padding: 0px;"><h4><?php echo _l('timecontrol_my_days'); ?>: </h4></div>
		            				<div class="col-md-12">
				                  <div class="form-group select-placeholder col-md-6">
														<?php echo render_select_with_input_group('reasonid',$reasons,array('reasonid','full_name'),'timecontrol_reason'); ?>
													</div>
					                <div class="col-md-3">
					                	<?php $value = _d(date('Y-m-d')); ?>
						                <?php echo render_date_input('start_date','general_map_date_from',$value); ?>
					                </div>
					                <div class="col-md-3">
					                	<?php $value = _d(date('Y-m-d')); ?>
						                <?php echo render_date_input('end_date','general_map_date_up',$value); ?>
					                </div>
				                </div>
				                <div class="col-md-12">
					                <div class="col-md-8">
						                <?php echo render_input('notes','timecontrol_notes'); ?>
					                </div>
					                <div class="col-md-4 text-center" style="padding-top: 25px;">
					                	<div class="additional hidden"><?php echo(render_input('staff_id',''));	?></div>
					                	<button type="submit" class="btn btn-info"><?php echo _l('timecontrol_process'); ?></button>
					                </div>
					              </div>
			              	</div>
			              <?php echo form_close(); ?>
		              </div>
	              <?php } ?>
							</div>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
              <div class="clearfix"></div>
              <?php render_datatable_presence(array(
						    _l('timecontrol_date_add'),
						    _l('timecontrol_staff'),
						    _l('timecontrol_reason'),
						    _l('timecontrol_reason_hour'),
						    _l('timecontrol_entry'),
						    _l('timecontrol_departure'),
						    _l('timecontrol_rest')."(H)",
						    _l('timecontrol_total_hours')."(H)",
						    _l('timecontrol_difference_hours')."(H)",
              ),'presence',$valor_contrato,$comision_socio,$comision_comercial,$base_currency->symbol,23); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
  <?php init_tail(); ?>
  <script>
  
		$(function() {
			initDataTable('.table-presence', window.location.href, [3], [3]);
	 	});
  		
	  $("#myday-form").on('submit', function(evt) {
	  	if ($('#staffid option:selected').val().trim() == "") {
				alert_float('success',"Seleccione la persona");
				evt.preventDefault();
			} else {
				$('input[name="staff_id"]').val($('#staffid option:selected').val());
			}
	  	if ($('#reasonid option:selected').val().trim() == "") {
				alert_float('success',"Seleccione un motivo");
				evt.preventDefault();
			}
		});

	  $("#form-signing").on('submit', function(evt) {
	  	if ($('#staffid option:selected').val().trim() == "") {
				alert_float('success',"Seleccione la persona");
				evt.preventDefault();
			} else {
				$('input[name="staff_id"]').val($('#staffid option:selected').val());
			}
			
			rest_clean(9);
		});
		
		function rest_clean(dIndex) {
			var jsonObj = [];
			var out = inp = "";
			
			$( "#rest_sign tbody" ).each( function (index_, value_) {
				if (index_ != dIndex) {
					var item_ = {};
					
					$( this ).children('tr').each( function (index_1, value_1) {
						$( this ).children('td').each( function (index_2, value_2) {
							if (index_1 == 0) out = $(value_2).text();
							if (index_1 == 1) inp = $(value_2).text();
						});
						
						item_['output'] = out;
						item_['input'] = inp;
					});
					
					jsonObj.push(item_);
				}
			});
			
			console.log(jsonObj);
			console.log(JSON.stringify(jsonObj));
			$('input[name="rest"]').val(JSON.stringify(jsonObj));
		}
		
  </script>
</body>
</html>