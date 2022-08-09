<div class="modal fade" id="mCommissionCostos" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('commission_plans/commission_costos'), array('id'=>'commission-costos-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="edit-title"><?php echo _l('Commission_costos'); ?></span>
          <span class="add-title"><?php echo _l('Commission_costos'); ?></span>
        </h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-md-3 text-left"><p><?php echo _l('commission_plan_title'); ?>:</p></div>
      		<div class="col-md-2 text-left"><p id="id_comer_c"></p></div>
      		<div class="col-md-2 text-left"><p id="id_tipo_c"></p></div>
      		<div class="col-md-5 text-left"><p id="id_tarifa_c"></p></div>
        </div>
      	<div class="row hidden">
      		<div class="col-md-4 text-center"><p><?php echo _l('commission_consumo_title'); ?>:</p></div>
      		<div class="col-md-2 text-center"><p id="id_anual"></p></div>
      		<div class="col-md-2 text-center"><p id="id_mensual"></p></div>
      		<div class="col-md-2 text-center"><p id="id_inferior"></p></div>
      		<div class="col-md-2 text-center"><p id="id_superior"></p></div>
        </div>
        <div class="row">
          <div class="col-md-4" style="display: none;">
            <div id="additional"></div>
            <?php echo render_input('consumo', 'Commission_comision'); ?>
          </div>
          <div class="col-md-4">
          	<?php
             	$selected = (isset($costo) ? $costo->nivel_precio : '');
             	echo render_select('nivel_precio',$nivel_precio,array('id','detalle'),'Commission_costos_nivel_precio',$selected);
            ?>
          </div>
          <div class="col-md-4">
            <div id="additional"></div>
            <?php echo render_input('comision', 'Commission_comision','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
          </div>
          <div class="col-md-4">
          	<label for="nivel_precio" class="control-label">Nivel de precios</label>
            <button type="button" class="btn btn-info" onclick="commission_costos();"><?php echo _l('Commission_insert'); ?></button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <div class="clearfix"></div>
            <div class="">
							<table id="tab_costos" class="table table-commission-costos dataTable no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
								<thead><tr role="row">
									<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="ComercializadorActivar para ordenar la columna descendente">Nivel precio</th>
									<th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Tipo de clienteActivar para ordenar la columna ascendente">Costo</th>
									<th class="sorting_disabled not-export" rowspan="1" colspan="1" aria-label="Opciones">Opciones</th>
								</tr></thead>
								<tbody></tbody>
							</table>
            </div>
        	</div>
        </div>
      </div>
      <div class="modal-footer"></div>
    </div><!-- /.modal-content -->
    <?php echo form_close(); ?>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->