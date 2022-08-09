<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
        	<div class="_filters _hidden_inputs hidden">
          	<?php
              echo form_hidden('exclude_trashed_contracts',true);
              echo form_hidden('expired');
              echo form_hidden('without_dateend');
              echo form_hidden('trash');
              foreach($years as $year) {
                echo form_hidden('year_'.$year['year'],$year['year']);
              }
              for ($m = 1; $m <= 12; $m++) {
                echo form_hidden('contracts_by_month_'.$m);
              }
          	?>
          </div>
          <div class="panel-body _buttons">
                    <?php if (has_permission('commissions','','create')){ ?>
                    <div class="col-md-12 pull-right" style="padding: 0px;">
                    	<a class="text-uppercase pull-left"><h3><?php echo _l('comicontract_high_contracts'); ?></h3></a>
                    </div>
                    <a href="<?php echo admin_url('commissions/contract'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_contract'); ?></a>
                    <?php } ?>
                    <div class="btn-group pull-right btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-left width300 height500">
                            <li class="active">
                                <a href="#" data-cview="exclude_trashed_contracts" onclick="dt_custom_view('exclude_trashed_contracts','.table-contracts','exclude_trashed_contracts'); return false;">
                                    <?php echo _l('contracts_view_exclude_trashed'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-cview="all" onclick="dt_custom_view('','.table-contracts',''); return false;">
                                    <?php echo _l('contracts_view_all'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-cview="expired"  onclick="dt_custom_view('expired','.table-contracts','expired'); return false;">
                                    <?php echo _l('contracts_view_expired'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-cview="without_dateend"  onclick="dt_custom_view('without_dateend','.table-contracts','without_dateend'); return false;">
                                    <?php echo _l('contracts_view_without_dateend'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-cview="trash"  onclick="dt_custom_view('trash','.table-contracts','trash'); return false;">
                                    <?php echo _l('contracts_view_trash'); ?>
                                </a>
                            </li>
                            <?php if(count($years) > 0){ ?>
                            <li class="divider"></li>
                            <?php foreach($years as $year){ ?>
                            <li class="active">
                                <a href="#" data-cview="year_<?php echo $year['year']; ?>" onclick="dt_custom_view(<?php echo $year['year']; ?>,'.table-contracts','year_<?php echo $year['year']; ?>'); return false;"><?php echo $year['year']; ?>
                                </a>
                            </li>
                            <?php } ?>
                            <?php } ?>
                            <div class="clearfix"></div>
                            <li class="divider"></li>
                            <li class="dropdown-submenu pull-left">
                                <a href="#" tabindex="-1"><?php echo _l('months'); ?></a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <?php for ($m = 1; $m <= 12; $m++) { ?>
                                    <li><a href="#" data-cview="contracts_by_month_<?php echo $m; ?>" onclick="dt_custom_view(<?php echo $m; ?>,'.table-contracts','contracts_by_month_<?php echo $m; ?>'); return false;"><?php echo _l(date('F', mktime(0, 0, 0, $m, 1))); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="row" id="contract_summary">

                        <?php $minus_7_days = date('Y-m-d', strtotime("-7 days")); ?>
                        <?php $plus_7_days = date('Y-m-d', strtotime("+7 days"));
                        $where_own = array();
                        if(!has_permission('commissions','','view')){
                            $where_own = array('addedfrom'=>get_staff_user_id());
                        }
                        ?>
                        <div class="col-md-12">
                            <h4 class="no-margin text-success"><?php echo _l('contract_summary_heading'); ?></h4>
                        </div>
                        <div class="col-md-2 col-xs-6 border-right">
                            <h3 class="bold">
                            <?php echo total_rows('tblcomicontratos','(DATE(fecha_fin_suministro) >"'.date('Y-m-d').'" AND trash=0' . (count($where_own) > 0 ? ' AND addedfrom='.get_staff_user_id() : '').') OR (DATE(fecha_fin_suministro) IS NULL AND trash=0'.(count($where_own) > 0 ? ' AND addedfrom='.get_staff_user_id() : '').')'); ?>
                            </h3>
                            <span class="text-info"><?php echo _l('contract_summary_active'); ?></span>
                        </div>
                        <div class="col-md-2 col-xs-6 border-right">
                            <h3 class="bold"><?php echo total_rows('tblcomicontratos',array_merge(array('DATE(fecha_fin_suministro) <'=>date('Y-m-d'),'trash'=>0),$where_own)); ?></h3>
                            <span class="text-danger"><?php echo _l('contract_summary_expired'); ?></span>
                        </div>
                        <div class="col-md-2 col-xs-6 border-right">
                            <h3 class="bold"><?php
                                echo total_rows(
                                'tblcomicontratos','fecha_fin_suministro BETWEEN "'.$minus_7_days.'" AND "'.$plus_7_days.'" AND trash=0 AND fecha_fin_suministro is NOT NULL AND fecha_fin_suministro >"'.date('Y-m-d').'"' . (count($where_own) > 0 ? ' AND addedfrom='.get_staff_user_id() : '')); ?></h3>
                                <span class="text-warning"><?php echo _l('contract_summary_about_to_expire'); ?></span>
                            </div>
                            <div class="col-md-2 col-xs-6 border-right">
                                <h3 class="bold"><?php
                                    echo total_rows('tblcomicontratos','dateadded BETWEEN "'.$minus_7_days.'" AND "'.$plus_7_days.'" AND trash=0' . (count($where_own) > 0 ? ' AND addedfrom='.get_staff_user_id() : '')); ?></h3>
                                    <span class="text-success"><?php echo _l('contract_summary_recently_added'); ?></span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <h3 class="bold"><?php echo total_rows('tblcomicontratos',array_merge(array('trash'=>1),$where_own)); ?></h3>
                                    <span class="text-muted"><?php echo _l('contract_summary_trash'); ?></span>
                                </div>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                                <div class="col-md-6 border-right">
                                    <h4><?php echo _l('comicontract_summary_by_type'); ?></h4>
                                    <div class="relative" style="max-height:400px">
                                        <canvas class="chart" height="400" id="contracts-by-type-chart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4><?php echo _l('comicontract_summary_by_type_value'); ?> (<span data-toggle="tooltip" data-title="<?php echo _l('base_currency_string'); ?>" class="text-has-action"><?php echo $base_currency->name; ?></span>)</h4>
                                    <div class="relative" style="max-height:400px">
                                        <canvas class="chart" height="400" id="contracts-value-by-type-chart"></canvas>
                                    </div>
                                </div>
                            </div>
          </div>
        </div>
        <?php if(has_permission('commissions','','create')) { ?>
	      	<div class="panel_s">
	      		<div class="panel-body _buttons" style="padding-top: 0px; padding-bottom: 0px;">
	      			<div class="col-md-12" style="padding: 0px;">
                <div class="row">
                  <div class="col-md-12 pull-right">
                  	<a class="text-uppercase pull-left text-center">
                  		<h4><?php echo _l('commission_billing'); ?>: </h4>
                  	</a>
                  </div>
             		</div>
	      				<div class="row" style="padding-bottom: 0px;">
	      					<?php 
	      						$selected = (isset($cliente) ? $cliente : '');
	      						if($selected == '') $habilitar = "disabled"; else $habilitar = ""; 
	      					?>
				          <div class="col-md-1">
				          	<label>Seleccionar</label>
				          	<br />
				          	<input id="chk_id_all" class="chk_id_all" type="checkbox" title="Todos" <?php echo $habilitar; ?>>
				          </div>
			            <?php echo form_open(admin_url('commissions'), array('id'=>'filtrar-form')); ?>
	                  <div class="form-group select-placeholder col-md-4">
		                  <?php
		                  	$url_client = admin_url('clients/client');
		                    echo render_select_with_input_group('cliente',$list_clients,array('id','nombre'),'commission_marketer',$selected,'<a href="'.$url_client.'"><i class="fa fa-plus"></i></a>');
		                  ?>
	                  </div>
										<div class="col-md-2">
											<?php echo render_date_input('fdesde',_l('general_map_date_from'),_d($fdesde)); ?>
										</div>
		                <div class="col-md-2">
		                	<?php echo render_date_input('fhasta',_l('general_map_date_up'),_d($fhasta)); ?>
		                </div>
		                <div class="col-md-1" style="padding-top: 7px;">
		                	<br />
		                	<button type="submit" class="btn btn-info filter" <?php echo $habilitar; ?>>Filtrar</button>
		                </div>
		                <input id="contracts" name="contracts" class="hidden" type="text">
			            <?php echo form_close(); ?>
			            <div class="col-md-2 text-right" style="padding-top: 7px;">
			            	<br />
			            	<button class="btn btn-info invoice" <?php echo $habilitar; ?>><?php echo _l('create_invoice'); ?></button>
			            </div>
			            <input id="adminurl" class="hidden" type="text" value="<?php echo admin_url(); ?>">
		            </div>
	            </div>
	      		</div>
					</div>
				<?php } ?>
        <div class="panel_s">
          <?php echo form_hidden('custom_view'); ?>
          <div class="panel-body">
            <?php $this->load->view('admin/commission/table_html'); ?>
         	</div>
       	</div>
   		</div>
    </div>
	</div>
</div>
<?php init_tail(); ?>
<script>
   
  $(function() {
    var ContractsServerParams = {};
    
    $.each($('._hidden_inputs._filters input'),function() {
        ContractsServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
    });
    initDataTable('.table-contracts', admin_url+'commissions/table', undefined, undefined, ContractsServerParams,<?php echo do_action('contracts_table_default_order',json_encode(array(6,'asc'))); ?>);

    new Chart($('#contracts-by-type-chart'), {
      type: 'bar',
      data: <?php echo $chart_types; ?>,
      options: {
        legend: {
          display: false,
        },
        responsive: true,
        maintainAspectRatio:false,
        scales: {
          yAxes: [{
            display: true,
            ticks: {
              suggestedMin: 0,
            }
          }]
        }
      }
    });
    
    new Chart($('#contracts-value-by-type-chart'), {
      type: 'line',
      data: <?php echo $chart_types_values; ?>,
      options: {
        responsive: true,
        legend: {
          display: false,
        },
        maintainAspectRatio:false,
        scales: {
          yAxes: [{
            display: true,
            ticks: {
              suggestedMin: 0,
            }
          }]
        }
      }
    });
        
  });
  
  $(".chk_id_all").change(function () {
  	$(".chk_id").attr('checked', this.checked);
  });
  
  $(".invoice").click(function() {
		var contracts = [];
		
    $('.chk_id').each(function() {
      if (this.checked) contracts.push($(this).val());
    });
		if (contracts.length == 0) {
			alert_float('success',"Seleccione contratos a facturar");	
			return false;
		}
  	$('#contracts').val(contracts);
  	var url = $('#adminurl').val()+'invoices/invoice';
  	
  	$("#filtrar-form").attr('action',url);
  	$("#filtrar-form").submit();
  });
  
  function invoice(url) {
		var contracts = [];
		
    $('.chk_id').each(function() {
      if (this.checked) contracts.push($(this).val());
    });
    
		if (contracts.length == 0) {
			alert_float('success',"Seleccione contratos a facturar");	
			return false;
		}
		
    var data = {
    	'fdesde' 		: $('#fdesde').val(),
    	'fhasta' 		: $('#fhasta').val(),
    	'cliente'		: $('#cliente').val(),
    	'contracts' : contracts
    }
    
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      console.log(response);
    }).fail(function(data) {
      var error = JSON.parse(data.responseText);
      alert_float('danger',error.message);
    });
    
    return false;
	}
	
	///// Cuando selecciona un cliente.
	$('#cliente').change(function(Event) {
		var id =  $('#clientid option:selected').val();
		if (id != '') {
			$('.filter').removeAttr('disabled');
    }
	});
	
</script>
</body>
</html>
