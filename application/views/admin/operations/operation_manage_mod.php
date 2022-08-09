
<!-- Modal add and edit management status -->
<div class="modal fade" id="operation_manage_mod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('operations/status/'.$operation->id)); ?>
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo _l('operation_management'); ?></h4>
        </div>
        <div class="modal-body">
          <div class="row"> 
            <div class="col-md-12">
              <label class="control-label"><?php echo _l('operation_status'); ?></label>
              <?php
                $value="";
                foreach($statuses as $status) {
                  if ($status['id'] == ($operation->status+1)) $value = $status['name'];
                }
              ?>
              <input type="text" class="form-control" value="<?php echo $operation->status+1 . " - " . $value ?>" readonly="readonly">
              <input type="hidden" class="form-control" name="status" value="<?php echo $operation->status + 1; ?>">
            </div>
            <div class="col-md-12">
              <br/>
              <?php $value = ""; ?>
              <label class="control-label"><?php echo _l('operation_note'); ?></label>
              <textarea name="note" class="form-control" rows="10" required></textarea>
            </div>
            <div class="col-md-12">
              <?php echo form_hidden('visit', $operation->id); ?>
            </div>
          </div> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
          <button type="submit" class="btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
        </div>
      </div>
    <?php echo form_close(); ?>
  </div>
</div>
<!-- /.modal -->
