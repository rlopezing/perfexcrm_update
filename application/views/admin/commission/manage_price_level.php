<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-8">
        <div class="panel_s">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-4 _buttons">
                <a href="#" onclick="new_nivel_precios(); return false;" class="btn btn-info pull-left">
                  <?php echo _l('new_price_level'); ?>
                </a>
              </div>
            </div>
            <br />
				    <div class="row">
				    	<?php echo form_open(admin_url('commissions/price_level_mant'), array('id'=>'consultar-form')); ?>
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
                  <div class="clearfix"></div>
                  <hr class="hr-panel-heading" />
                  <div class="clearfix"></div>
                  	<?php render_datatable(array(
                  		'#',
                      _l('general_map_price_level'),
                      _l('general_map_marketer'),
                      _l('general_map_rate'),
                      _l('options')
                      ),'price-level'); 
                    ?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/commission/nivel_precios'); ?>
<?php init_tail(); ?>
<script>
  $(function(){
    initDataTable('.table-price-level', window.location.href, [1], [1]);
  });
</script>
</body>
</html>
