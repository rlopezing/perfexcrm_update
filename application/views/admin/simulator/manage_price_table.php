<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
       	<div class="panel_s">
          <div class="panel-body">
          	<h3 style="color: #07a4f8">Creación y configuración de tablas de precios.</h3>
	          <?php echo form_open(admin_url('simulators/price_table_mant/'),array('id'=>'pt-form')); ?>
	            <div class="row">
								<div class="form-group select-placeholder col-md-3">
		            	<?php
		            		$selected = (isset($marketer) ? $marketer : '');
		            		echo render_select('marketer',$marketers,array('id','nombre'),'commission_marketer',$selected);
		            	?>
	            	</div>
								<div class="form-group select-placeholder col-md-6">
		            	<?php
		            		$selected = (isset($rate_id) ? $rate_id : '0');
		            		echo render_select_with_input_group('price_table',$price_table,array('id','detalle'),'simulator_price_tables',$selected,'<a href="#" onclick="new_price_table_head();return false;"><i class="fa fa-plus"></i></a><a href="#" style="margin-left:20px; color:orange;" onclick="edit_price_table_head();return false;"><i class="fa fa-edit"></i></a><a href="#" style="margin-left:20px; color:red;" onclick="remove_price_table_head();return false;"><i class="fa fa-eraser"></i></a>');
		              ?>
		              <input id='submit' class="hidden" type="submit" name="submit" value="Submit">
		            </div>
		          </div>
	          <?php echo form_close(); ?>
	          <input id="adminurl" class="hidden" type="text" value="<?php echo admin_url(); ?>">
	          <input id="finished" class="hidden" type="text" value="<?php if(isset($price_table_id)) echo $price_table_id->finished; ?>">
            <div class="row">
            	<div class="form-group col-md-8" style="pointer-events: none;">
	              <div class="checkbox checkbox-primary no-mtop checkbox-inline">
	                <input type="checkbox" id="trash" name="trash" data-toggle="tooltip" title="<?php echo _l('simulator_price_finished_potency'); ?>" <?php if(isset($price_table_id)){if($price_table_id->finished == 1){echo 'checked';}}; ?>>
	                <label for="trash"><?php echo _l('simulator_price_finished_potency'); ?></label>
	              </div>
	              <div class="checkbox checkbox-primary no-mtop checkbox-inline">
	                <input type="checkbox" id="trash" name="trash" data-toggle="tooltip" title="<?php echo _l('simulator_price_finished_energy'); ?>" <?php if(isset($price_table_id)){if($price_table_id->finished == 2){echo 'checked';}}; ?>>
	                <label for="trash"><?php echo _l('simulator_price_finished_energy'); ?></label>
	              </div>
	              <div class="checkbox checkbox-primary no-mtop checkbox-inline">
	                <input type="checkbox" id="trash" name="trash" data-toggle="tooltip" title="<?php echo _l('gas')," ",_l('simulator_fixed_term'); ?>" <?php if(isset($price_table_id)){if($price_table_id->finished == 3){echo 'checked';}}; ?>>
	                <label for="trash"><?php echo _l('gas')," ",_l('simulator_fixed_term'); ?></label>
	              </div>
	              <div class="checkbox checkbox-primary no-mtop checkbox-inline">
	                <input type="checkbox" id="trash" name="trash" data-toggle="tooltip" title="<?php echo _l('gas')," ",_l('simulator_variable_term'); ?>" <?php if(isset($price_table_id)){if($price_table_id->finished == 4){echo 'checked';}}; ?>>
	                <label for="trash"><?php echo _l('gas')," ",_l('simulator_variable_term'); ?></label>
	              </div>
              </div>
            </div>
            <div class="_buttons">
              <a href="#" onclick="new_price_table(); return false;" class="btn btn-info pull-left display-block"><?php echo _l('simulator_rate_new'); ?></a>
            </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>
            <?php render_datatable(array(
            	_l('simulator_rates'),
            	_l('simulator_hired_potency'),
            	_l('simulator_price_1'),
            	_l('simulator_price_2'),
            	_l('simulator_price_3'),
            	_l('simulator_price_4'),
            	_l('simulator_price_5'),
            	_l('simulator_price_6'),
            	_l('options')
            ),'price-table'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/simulator/price_table'); ?>
<?php $this->load->view('admin/simulator/price_table_head'); ?>
<?php init_tail(); ?>
<script>
	var decimal_separator = '<?php echo $decimal_separator; ?>';

  $(function() {
    initDataTable('.table-price-table', window.location.href, [1], [1]);
  });
  
  // Obtiene las tarifas relacionadas con la modalidad de precios.
	$('#price_table').change(function(event) {
		var marketer = $('#marketer option:selected').val();
		if (marketer == "") {
			alert_float('success',"Seleccione un comercializador");	
			$('#marketer').focus();
			event.target.selectedIndex = 0;
			return false;
		}
		
    $('#submit').click();
	});
	
	///// Cuando cambia el comercializador.
	$('#marketer').change(function(Event) {
		var marketer =  $('#marketer option:selected').val();
		var url = $('#adminurl').val()+'simulators/filtrar_price_table/'+marketer;
  	$.post(url).done(function (response) {
  		response = JSON.parse(response);
			$('#price_table').children('option:not(:first)').remove();
			for (var i=0; i < response.length; i++) {
				$('#price_table').append('<option value="'+response[i].id+'-'+response[i].modality+'">'+response[i].detalle+'</option>');
			}
			var sPriceTable = $('#price_table');
			sPriceTable.selectpicker('refresh');
		});
	});

</script>
</body>
</html>
