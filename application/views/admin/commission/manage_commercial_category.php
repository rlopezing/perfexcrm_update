<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
      	<div class="panel_s">
          <div class="panel-body">
          	<div class="row">
	            <div class="col-md-6 _buttons">
	              <a href="#" onclick="new_commercial_category(); return false;" class="btn btn-info pull-left display-block">
	              	<?php echo _l('new_commercial_category'); ?>
	              </a>
	            </div>
            </div>
            <br />
	          <div class="row">
	            <?php echo form_open(admin_url('commissions/commercial_category_mant'), array('id'=>'consultar-form')); ?>
	            	<div class="form-group select-placeholder col-md-6">
	            		<?php $selected = (isset($country) ? $country : ''); ?>
	            		<?php echo render_select('country_id',$countries,array('country_id','short_name'),'settings_sales_country_code',$selected); ?>
	            	</div>
	            	<div class="col-md-3" style="padding-top: 25px;"><button type="submit" class="btn btn-default">Actualizar</button></div>
	            <?php echo form_close(); ?>
		        </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>
          	<?php render_datatable(array(
          		'#',
              _l('commercial_category_detalle'),
              _l('options')
              ),'commercial-category'); 
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/commission/commercial_category'); ?>
<?php init_tail(); ?>
<script>
  $(function() {
    initDataTable('.table-commercial-category', window.location.href, [1], [1]);
  });
</script>
</body>
</html>
