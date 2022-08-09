<?php init_head(); ?>
	<div id="wrapper">
  	<div class="content">
    	<div class="row">
      	<div class="col-md-12">
        	<?php if($email_exist_as_staff){ ?>
          <div class="alert alert-danger">
            Some of the general map email is used as staff member email, according to the docs, the support general map email must be unique email in the system, you must change the staff email or the support general map email in order all the features to work properly.
          </div>
          <?php } ?>
          <div class="panel_s">
            <div class="panel-body">
              <div class="_buttons">
              	<div class="row">
              		<div class="col-md-3">
											<a href="<?php echo admin_url('commissions/contract'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_contract'); ?></a>       
									</div>
									<?php echo form_open(admin_url('distributors_partners/filtrar'), array('id'=>'filtrar-form')); ?>
										<div class="col-md-1 text-right"><?php echo _l('distributor_partner_date_from'); ?></div>
										<div class="col-md-2"><?php echo render_date_input('fdesde','',_d($fdesde)); ?></div>
										<div class="col-md-1 text-right"><?php echo _l('distributor_partner_date_up'); ?></div>
		                <div class="col-md-2"><?php echo render_date_input('fhasta','',_d($fhasta)); ?></div>
		                <button type="submit" class="btn btn-info">Actualizar</button>
	                <?php echo form_close(); ?>
                </div>
							</div>
              <div class="clearfix"></div>
              <hr class="hr-panel-heading" />
              <div class="clearfix"></div>
              <?php render_datatable_comision(array(
						    _l('general_map_contract_code'),
						    _l('general_map_nif'),
						    _l('general_map_client'),
						    _l('general_map_cpe'),
						    _l('general_map_stress_level'),
						    _l('general_map_annual_consumption'),
						    _l('general_map_marketer'),
						    _l('general_map_rate'),
						    _l('general_map_price_level'),
						    _l('general_map_start_date_subscripction'),
						    _l('general_map_partner'),
						  	_l('general_map_commercial'),
						    _l('general_map_partner_commission')
              ),'distributor-partner',$valor_contrato,$comision_socio,0,$base_currency->symbol,13); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>    
  <?php init_tail(); ?>
  <script>
	  $(function() {
	    initDataTable('.table-distributor-partner', window.location.href, [3], [3]);
	 	});
	 	
		window.addEventListener('load',function() {
	    _validate_form($('#form'), {}, filtrar);
	  });
	  
	  function filtrar(form) {
      var data = $(form).serialize();
      var url = form.action;
      $.post(url, data).done(function(response) {
        response = JSON.parse(response);
        if(response.success == true) {
          alert_float('success',response.message);
        }
        if(response.email_exist_as_staff == true) {
          window.location.reload();
        }
        $('.table-distributor-partner').DataTable().ajax.reload();
      }).fail(function(data) {
        var error = JSON.parse(data.responseText);
        alert_float('danger',error.message);
      });
      return false;
		}
  </script>
</body>
</html>