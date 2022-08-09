<div class="modal fade" id="mCommissionPlans" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('commission_plans/commission_plan'), array('id'=>'commission-plan-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="edit-title"><?php echo _l('commission_edit'); ?></span>
          <span class="add-title"><?php echo _l('commission_new'); ?></span>
        </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group select-placeholder col-md-4">
          	<?php
             	$selected = (isset($plan) ? $plan->comercializador : '');
             	echo render_select('comercializador',$comercializador,array('id','nombre'),'commission_marketer',$selected);
            ?>
          </div>
          <div class="form-group select-placeholder col-md-4">
          	<?php
             	$selected = (isset($plan) ? $plan->categoria_comercial : '');
             	echo render_select('categoria_comercial',$categoria_comercial,array('id','detalle'),'general_map_commercial_category',$selected);
            ?>
          </div>
          <div class="form-group select-placeholder col-md-4">
          	<?php
             	$selected = (isset($plan) ? $plan->tarifa : '');
             	echo render_select('tarifa','',array('id','descripcion'),'commission_rate',$selected);
            ?>
          </div>
          <div id="additional"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
      </div>
    </div><!-- /.modal-content -->
    <?php echo form_close(); ?>
    <input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->