<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
            	<div class="panel_s">
                <div class="panel-body">
                    <div class="_buttons">
                      <a href="#" onclick="new_comercializador(); return false;" class="btn btn-info pull-left display-block"><?php echo _l('new_comercializador'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(	
                    	_l('Id'),
                      _l('name'),
                      _l('general_map_client'),
                      _l('options')
                    ),'marketer'); ?>
                </div>
              </div>
          </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/commission/comercializador'); ?>
<?php init_tail(); ?>
<script>
  $(function(){
    initDataTable('.table-marketer', window.location.href, [1], [1]);
  });
</script>
</body>
</html>
