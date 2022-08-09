<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
       	<div class="panel_s">
          <div class="panel-body">
            <div class="_buttons">
              <a href="#" onclick="new_prices(); return false;" class="btn btn-info pull-left display-block"><?php echo _l('simulator_finished_new'); ?></a>
            </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>
            <?php render_datatable(array(
            	'#',
            	_l('simulator_detail'),
            	_l('options')
            ),'prices'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/simulator/prices'); ?>
<?php init_tail(); ?>
<script>
  $(function(){
    initDataTable('.table-prices', window.location.href, [1], [1]);
  });
</script>
</body>
</html>
