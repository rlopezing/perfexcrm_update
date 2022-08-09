<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="panel_s">
          <div class="panel-body">
          	<div class="_buttons">
          		<div class="row">
		            <div class="col-md-12">
		              <a href="#" onclick="new_tarifa(); return false;" class="btn btn-info pull-left display-block"><?php echo _l('new_tarifa'); ?></a>
		            </div>
		          </div>
		          <br />
		          <div class="row">
		            <?php echo form_open(admin_url('commissions/rate_mant'), array('id'=>'consultar-form')); ?>
		            	<div class="form-group select-placeholder col-md-4">
		            		<?php $selected = (isset($country) ? $country : ''); ?>
		            		<?php echo render_select('country_id',$countries,array('country_id','short_name'),'settings_sales_country_code',$selected); ?>
		            	</div>
		            	<div class="form-group select-placeholder col-md-4">
		            		<?php $selected = (isset($module) ? $module : ''); ?>
		            		<?php echo render_select('module_id',$modules,array('id','name'),'module',$selected); ?>
		            	</div>
		            	<div class="col-md-3" style="padding-top: 25px;"><button type="submit" class="btn btn-default">Actualizar</button></div>
		            <?php echo form_close(); ?>
			        </div>
          	</div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>
            <?php render_datatable(array(
            	'#',
              _l('tarifa_descripcion'),
              _l('options')
            ),'rate'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/commission/tarifa'); ?>
<?php init_tail(); ?>
<script>

  $(function() {
    initDataTable('.table-rate', window.location.href, [1], [1]);
  });
  
	///// Cuando cambia el pais.
	$('#country_id').change(function(Event) { $('.table-rate tbody tr').remove(); });
	///// Cuando cambia el mosulo.
	$('#module_id').change(function(Event) { $('.table-rate tbody tr').remove(); });
  
</script>
</body>
</html>
