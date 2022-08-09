<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-6">
      	<div class="panel_s">
          <div class="panel-body">
          	<div class="row">
	            <div class="col-md-6 _buttons">
	              <a href="#" onclick="new_holiday(); return false;" class="btn btn-info pull-left display-block">
	              	<?php echo _l('schedule_holiday_new'); ?>
	              </a>
	            </div>
            </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>
          	<?php render_datatable(array(
          		'#',
          		_l('timecontrol_date_add'),
              _l('schedule_holiday_detail'),
              _l('options')
              ),'holidays');
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/time_controls/holiday'); ?>
<?php init_tail(); ?>
<script>
  $(function() {
    initDataTable('.table-holidays', window.location.href, [1], [1]);
  });
</script>
</body>
</html>
