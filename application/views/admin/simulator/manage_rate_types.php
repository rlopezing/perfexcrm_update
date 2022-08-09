<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-8">
       	<div class="panel_s">
          <div class="panel-body">
            <div class="_buttons">
              <a href="#" onclick="new_rate_type(); return false;" class="btn btn-info pull-left display-block"><?php echo _l('simulator_rate_types_new'); ?></a>
            </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>
            	<?php render_datatable(array(
            		'#',
            		_l('simulator_detail'),
            		_l('options')
            	),'rate-type'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/simulator/rate_type'); ?>
<?php init_tail(); ?>
<script>
  $(function(){
    initDataTable('.table-rate-type', window.location.href, [1], [1]);
  });
</script>
</body>
</html>
