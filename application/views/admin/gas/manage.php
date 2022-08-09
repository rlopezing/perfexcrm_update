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
            <?php if(has_permission('simulators','','create')) { ?>
              <div class="col-md-12 pull-right" style="padding: 0px;">
                <a class="text-uppercase pull-left"><h3><?php echo _l('simulator_rate_gas'); ?></h3></a>
              </div>
              <a href="<?php echo admin_url('gass/gas'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('simulator_new'); ?></a>
            <?php } ?>
            <div class="btn-group pull-right btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>" >
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
                <?php if(count($years) > 0) { ?>
                  <li class="divider"></li>
                  <?php foreach($years as $year) { ?>
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
          </div>
          <?php echo form_hidden('custom_view'); ?>
          <div class="panel-body">
            <?php $this->load->view('admin/gas/table_html'); ?>
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
    
    initDataTable('.table-contracts', admin_url+'gass/table', undefined, undefined, ContractsServerParams,<?php echo do_action('contracts_table_default_order',json_encode(array(6,'asc'))); ?>);
  });
    
</script>
</body>
</html>
