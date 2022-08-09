<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-10">
             <div class="panel_s">
                <div class="panel-body">
                    <div class="_buttons">
                        <h3 style="color: #07a4f8"><?php echo _l('commissions_staff_assign'); ?></h3>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('commissions_staffid'),
                        _l('commissions_email'),
                        _l('commissions_staff'),
                        _l('commissions_commercial_category'),
                        _l('options')
                        ),'staff-assign'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/commission/staff_assign'); ?>
<?php init_tail(); ?>
<script>
  $(function(){
    initDataTable('.table-staff-assign', window.location.href, [1], [1]);
  });
</script>
</body>
</html>
