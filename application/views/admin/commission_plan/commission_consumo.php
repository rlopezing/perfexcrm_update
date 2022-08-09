<div class="modal fade" id="mCommissionConsumo" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('commission_plans/commission_consumo'), array('id'=>'commission-consumo-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="edit-title"><?php echo _l('consumo_edit'); ?></span>
          <span class="add-title"><?php echo _l('consumo_new'); ?></span>
        </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-2 hidden">
            <div id="additional"></div>
            <?php echo render_input('plano', ''); ?>
          </div>
          <div class="col-md-2">
            <div class="hidden" id="additional"><?php echo render_input('anual'); ?></div>
            <br />
      			<div class="radio radio-primary">
              <input type="radio" onchange="change('1=/=0'); return false;">
              <label for="rtiempo"><?php echo _l('es_anual'); ?></label>
            </div>
          </div>
          <div class="col-md-2">
            <div class="hidden" id="additional"><?php echo render_input('mensual'); ?></div>
            <br />
      			<div class="radio radio-primary">
              <input type="radio" onchange="change('0=/=1'); return false;">
              <label for="rtiempo"><?php echo _l('es_mensual'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div id="additional"></div>
            <?php echo render_input('limite_inferior', 'limite_inferior','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
          </div>
          <div class="col-md-4">
            <div id="additional"></div>
            <?php echo render_input('limite_superior', 'limite_superior','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <button type="button" class="btn btn-info" onclick="save_commission_consumo();"><?php echo _l('submit'); ?></button>
      </div>
    </div><!-- /.modal-content -->
    <?php echo form_close(); ?>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->