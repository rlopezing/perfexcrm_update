<div class="modal fade" id="supply_points_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 70% !important;">
    <?php echo form_open(admin_url('clients/supply_points'),array('id'=>'supply-points-form','name'=>'supply-points-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo _l('supply_points_electric_config'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group select-placeholder col-md-3">
            <?php $selected=2; ?>
            <?php echo render_select('module_fijo',$modules,array('id','name'),'supply_points_module',$selected,["disabled"=>"true"]); ?>
          </div>
        	<div class="col-md-3">
            <?php $value=( isset($supplypoints) ? $supplypoints->cups : ''); ?>
            <?php echo render_input('cups', 'supply_points_cups',$value); ?>	
        	</div>
        	<div class="col-md-3">
           	<?php $value = (isset($supplypoints) ? $supplypoints->address : ''); ?>
        		<?php echo render_input('address','supply_points_address',$value); ?>
        	</div>
          <div class="col-md-3">
            <?php $value=( isset($supplypoints) ? $supplypoints->zip : ''); ?>
            <?php echo render_input('zip', 'supply_points_zip',$value); ?>     
          </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
            <?php $value=( isset($supplypoints) ? $supplypoints->city : ''); ?>
            <?php echo render_input('city', 'supply_points_city',$value); ?>                  	
        	</div>
        	<div class="col-md-3">
            <?php $value=( isset($supplypoints) ? $supplypoints->state : ''); ?>
            <?php echo render_input('state', 'supply_points_state',$value); ?>      	        	
        	</div>
          <div class="col-md-3">
            <?php $selected=( isset($supplypoints) ? $supplypoints->country : '' ); ?>
            <?php echo render_select('country',$countries,array('country_id','short_name'),'supply_points_country',$selected); ?>          
          </div>
        	<div class="col-md-3">
	          <?php $selected = (isset($supplypoints) ? $supplypoints->rate : ''); ?>
	          <?php echo render_select('rate',$rates,array('id','descripcion'),'simulator_rates_upper',$selected); ?>
        	</div>
        </div>
        <div class="row" style="padding: 0px;">
           	<!-- 
           	CONSUMOS CONTRATADOS EN TERMINOS DE POTENCIA.
           		-->
           	<div class="col-md-3" style="padding: 0px;">
              	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
              		<h5><?php echo _l('simulator_consumption'); ?> (kW)</h5>
              	</div>
                <div class="form-group col-md-12">
                  	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
                    	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_potencia1" value="<?php if(isset($simulator)){print_r($simulator->consumo_potencia1); }?>" disabled>
                  	</div>
               </div>
                <div class="form-group col-md-12">
                  <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  	<div class="input-group-addon"><?php echo _l('simulator_potency_p2'); ?></div>
                     <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_potencia2" value="<?php if(isset($simulator)){echo $simulator->consumo_potencia2; }?>" disabled>
                  </div>
               </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p3'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_potencia3" value="<?php if(isset($simulator)){echo $simulator->consumo_potencia3; }?>" disabled>
                   </div>
                </div>
              	<div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p4'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_potencia4" value="<?php if(isset($simulator)){echo $simulator->consumo_potencia4; }?>" disabled>
                   </div>
                </div>
                <div class="form-group col-md-12">
                     <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                     	<div class="input-group-addon"><?php echo _l('simulator_potency_p5'); ?></div>
                        <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_potencia5" value="<?php if(isset($simulator)){echo $simulator->consumo_potencia5; }?>" disabled>
                     </div>
                  </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p6'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="consumo_potencia6" value="<?php if(isset($simulator)){echo $simulator->consumo_potencia6; }?>" disabled>
                   </div>
                </div>
           	</div>
           	<!-- 
           	PRECIOS CONTRATADOS EN TERMINOS DE POTENCIA.
           		-->
           	<div class="col-md-3" style="padding: 0px;">
              	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
              		<h5><?php echo _l('simulator_price'); ?> (<?php echo $base_currency->symbol; ?>)</h5>
              	</div>
                <div class="form-group col-md-12">
                  	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
                    	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_potencia1" value="<?php if(isset($simulator)){print_r($simulator->precio_potencia1); }?>" disabled>
                    	
                  	</div>
               </div>
                <div class="form-group col-md-12">
                  <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  	<div class="input-group-addon"><?php echo _l('simulator_potency_p2'); ?></div>
                     <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_potencia2" value="<?php if(isset($simulator)){echo $simulator->precio_potencia2; }?>" disabled>
                  </div>
               </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p3'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_potencia3" value="<?php if(isset($simulator)){echo $simulator->precio_potencia3; }?>" disabled>
                   </div>
                </div>
              	<div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p4'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_potencia4" value="<?php if(isset($simulator)){echo $simulator->precio_potencia4; }?>" disabled>
                   </div>
                </div>
                <div class="form-group col-md-12">
                     <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                     	<div class="input-group-addon"><?php echo _l('simulator_potency_p5'); ?></div>
                        <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_potencia5" value="<?php if(isset($simulator)){echo $simulator->precio_potencia5; }?>" disabled>
                     </div>
                  </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p6'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_potencia6" value="<?php if(isset($simulator)){echo $simulator->precio_potencia6; }?>" disabled>
                   </div>
                </div>
           	</div>
           	<!-- 
           	CONSUMOS CONTRATADOS EN TERMINOS DE ENERGÍA.
           		-->
           	<div class="col-md-3" style="padding: 0px;">
              	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
              		<h5><?php echo _l('simulator_consumption'); ?> (kWh)</h5>
              	</div>
                <div class="form-group col-md-12">
                  	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
                    	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" step="any" class="form-control" name="consumo_energia1" value="<?php if(isset($simulator)){print_r($simulator->consumo_energia1); }?>" disabled>
                  	</div>
               </div>
                <div class="form-group col-md-12">
                  <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  	<div class="input-group-addon"><?php echo _l('simulator_potency_p2'); ?></div>
                     <input type="number" step="0.000001" onkeypress="return val_numbers(event);" step="any" class="form-control" name="consumo_energia2" value="<?php if(isset($simulator)){echo $simulator->consumo_energia2; }?>" disabled>
                  </div>
               </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p3'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" step="any" class="form-control" name="consumo_energia3" value="<?php if(isset($simulator)){echo $simulator->consumo_energia3; }?>" disabled>
                   </div>
                </div>
              	<div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p4'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" step="any" class="form-control" name="consumo_energia4" value="<?php if(isset($simulator)){echo $simulator->consumo_energia4; }?>" disabled>
                   </div>
                </div>
                <div class="form-group col-md-12">
                     <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                     	<div class="input-group-addon"><?php echo _l('simulator_potency_p5'); ?></div>
                        <input type="number" step="0.000001" onkeypress="return val_numbers(event);" step="any" class="form-control" name="consumo_energia5" value="<?php if(isset($simulator)){echo $simulator->consumo_energia5; }?>" disabled>
                     </div>
                  </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p6'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" step="any" class="form-control" name="consumo_energia6" value="<?php if(isset($simulator)){echo $simulator->consumo_energia6; }?>" disabled>
                   </div>
                </div>
           	</div>
           	<!-- 
           	PRECIOS CONTRATADOS EN TERMINOS DE ENERGÍA.
           		-->
           	<div class="col-md-3" style="padding: 0px;">
              	<div class="col-md-12 pull-right" style="padding-bottom: 5px;">
              		<h5><?php echo _l('simulator_price'); ?> (<?php echo $base_currency->symbol; ?>)</h5>
              	</div>
                <div class="form-group col-md-12">
                  	<div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  		<div class="input-group-addon"><?php echo _l('simulator_potency_p1'); ?></div>
                    	<input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_energia1" value="<?php if(isset($simulator)){print_r($simulator->precio_energia1); }?>" disabled>
                    	
                  	</div>
               </div>
                <div class="form-group col-md-12">
                  <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                  	<div class="input-group-addon"><?php echo _l('simulator_potency_p2'); ?></div>
                     <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_energia2" value="<?php if(isset($simulator)){echo $simulator->precio_energia2; }?>" disabled>
                  </div>
               </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p3'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_energia3" value="<?php if(isset($simulator)){echo $simulator->precio_energia3; }?>" disabled>
                   </div>
                </div>
              	<div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p4'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_energia4" value="<?php if(isset($simulator)){echo $simulator->precio_energia4; }?>" disabled>
                   </div>
                </div>
                <div class="form-group col-md-12">
                     <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                     	<div class="input-group-addon"><?php echo _l('simulator_potency_p5'); ?></div>
                        <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_energia5" value="<?php if(isset($simulator)){echo $simulator->precio_energia5; }?>" disabled>
                     </div>
                  </div>
                <div class="form-group col-md-12">
                   <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                   	<div class="input-group-addon"><?php echo _l('simulator_potency_p6'); ?></div>
                      <input type="number" step="0.000001" onkeypress="return val_numbers(event);" class="form-control" name="precio_energia6" value="<?php if(isset($simulator)){echo $simulator->precio_energia6; }?>" disabled>
                   </div>
                </div>
           	</div>
	      </div>
	      <div id="additional">
	      	<?php echo form_hidden('cliente',$client->userid); ?>
	      	<?php echo form_hidden('module_id',2); ?>
	      </div>
    	</div>
    	<div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
      	<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
  		</div>
  	</div>
  	<?php echo form_close(); ?>
	</div>
</div>