<div class="modal fade" id="termination_contract_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <?php echo form_open(admin_url('commissions/termination'),array('id'=>'renew-contract-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo _l('comicontract_termination_contract'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6"><?php echo render_select('termination_motive',$termination_motive,array('id','detalle'),'comicontract_termination_motive'); ?></div>
        	<div class="col-md-6"><?php echo render_date_input('termination_date','comicontract_termination_date',_d(date('Y-m-d'))); ?></div>
        </div>
        <div class="row">
        	<div class="col-md-12"><?php echo render_textarea('termination_comment','comicontract_termination_comment'); ?></div>
        </div>
        <?php echo form_hidden('contractid',$contract->id); ?>
    	</div>
    	<div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
      	<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
  		</div>
  	</div>
  	<?php echo form_close(); ?>
	</div>
</div>
