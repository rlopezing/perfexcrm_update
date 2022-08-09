<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-7 left-column">
        <div class="panel_s">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12 pull-right" style="padding-bottom: 5px;">
              	<a class="text-uppercase pull-left"><h3>
              		<?php if ($contract->termination_motive>0) 
              		{
              			echo _l('comicontract_termination_contract_'); ?></h3>
              			<h5><label>Motivo: </label><?php echo $contract->detalle; ?></h5>
              			<h5><label>Observación: </label><?php echo $contract->termination_comment; ?></h5><?php
									} else echo _l('comicontract_high_contract'); ?>
              	</a>
              </div>
         		</div>
            <?php echo form_open($this->uri->uri_string(),array('id'=>'contract-form')); ?>
	          <div class="row">
            	<div class="form-group select-placeholder col-md-6">
            		<?php $value = (isset($contract) ? $contract->country_id : ''); ?>
            		<?php echo render_select('country_id',$countries,array('country_id','short_name'),'settings_sales_country_code',$value); ?>
            	</div>
            	<div class="form-group select-placeholder col-md-6">
            		<?php $value = (isset($contract) ? $contract->module_id : ''); ?>
            		<?php echo render_select('module_id',$modules,array('id','name'),'module',$value); ?>
            	</div>
		        </div>
            <div class="row">
              <div class="form-group select-placeholder col-md-6">
                <label for="clientid" class="control-label">
                 	<span class="text-danger">* </span><?php echo _l('contract_client_string'); ?>
                </label>
                <select id="clientid" name="cliente" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                 	<?php
                 		$selected = (isset($contract) ? $contract->cliente : '');
                    if($selected == '')
                    {
                     	$selected = (isset($customer_id) ? $customer_id: '');
                    }
                    if($selected != '')
                    {
                    	$rel_data = get_relation_data('customer', $selected);
                    	$rel_val = get_relation_values($rel_data,'customer');
                    	echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
               	<?php $value = (isset($contract) ? $contract->nif : ''); ?>
                <?php echo render_input('nif','contract_nif',$value); ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
               	<?php $value = (isset($contract) ? $contract->cpe : ''); ?>
                <?php echo render_input('cpe','contract_cpe',$value); ?>
              </div>
              <div class="form-group select-placeholder col-md-6">
              	<?php
                 	$selected = (isset($contract) ? $contract->tarifa : '');
                 	if(is_admin() || get_option('staff_members_create_inline_contract_types') == '1')
                 	{
                  	echo render_select_with_input_group('tarifa',$tarifa,array('id','descripcion'),'contract_rate',$selected,'<a href="#" onclick="new_tarifa();return false;"><i class="fa fa-plus"></i></a>');
                 	} 
                 	else 
                 	{
                 		echo render_select('tarifa',$tarifa,array('id','descripcion'),'contract_rate',$selected);
                 	}
                 ?>
              </div>
            </div>
            <div class="row">
            	<div class="col-md-6">
                <?php $value = (isset($contract) ? $contract->potencia_contratada : ''); ?>
                <?php echo render_input('potencia_contratada','contract_hired_potency',$value,'number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
            	</div>	                  
            	<div class="col-md-6">
                <?php $value = (isset($contract) ? $contract->consumo_anual : ''); ?>
                <?php echo render_input('consumo_anual','contract_annual_consumption',$value,'number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
            	</div>
        	</div>
            <div class="row">
              <div class="form-group select-placeholder col-md-6">
              	<?php
                 	$selected = (isset($contract) ? $contract->comercializador : '');
                 	if(is_admin() || get_option('staff_members_create_inline_contract_types') == '1')
                 	{
                  		echo render_select_with_input_group('comercializador',$comercializador,array('id','nombre'),'contract_marketer',$selected,'<a href="#" onclick="new_comercializador();return false;"><i class="fa fa-plus"></i></a>');
                 	} 
                 	else 
                 	{
                 		echo render_select('comercializador',$comercializador,array('id','name'),'contract_marketer',$selected);
                 	}
                 ?>
              </div>
              <div class="form-group select-placeholder col-md-6">
              	<?php
                 	$selected = (isset($contract) ? $contract->nivel_precios : '');
                 	if(is_admin() || get_option('staff_members_create_inline_contract_types') == '1')
                 	{
                  	echo render_select_with_input_group('nivel_precios',$nivel_precios,array('id','detalle'),'contract_price_level',$selected,'<a href="#" onclick="new_nivel_precios();return false;"><i class="fa fa-plus"></i></a>');
                 	} 
                 	else 
                 	{
                 		echo render_select('nivel_precios',$nivel_precios,array('id','detalle'),'contract_price_level',$selected);
                 	}
                 ?>
              </div>
           	</div>
            <div class="row">
              <div class="form-group col-md-6">
                 <label for="contract_value"><?php echo _l('contract_contract_value'); ?></label>
                 <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                    <input type="number" class="form-control" name="valor_contrato" value="<?php if(isset($contract)){echo $contract->valor_contrato; }?>" readonly>
                    <div class="input-group-addon">
                       <?php echo $base_currency->symbol; ?>
                    </div>
                 </div>
              </div>
              <div class="form-group col-md-6">
              	<?php
                 	$selected = (isset($contract) ? $contract->duration : '');
                 	echo render_select('duration',$duration,array('id','valor'),'comicontract_duration_contracts',$selected);
                ?>
              </div>
           	</div>
            <div class="row">
              <div class="form-group select-placeholder col-md-4">
              	<?php
                 	$selected = (isset($contract) ? $contract->categoria_comercial : '');
                 	echo render_select('categoria_comercial',$commercial_category,array('id','detalle'),'contract_commercial_category',$selected);
                 ?>
              </div>
              <div class="form-group select-placeholder col-md-5">
              	<?php
                 	$selected = (isset($contract) ? $contract->socio : '');
                 	echo render_select('socio',$socio,array('id','nombre'),'contract_partner',$selected);
                 ?>
              </div>
              <div class="form-group col-md-3">
                 <label for="contract_value"><?php echo _l('contract_parnert_commission'); ?></label>
                 <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                    <input type="number" class="form-control" name="comision_socio" value="<?php if(isset($contract)){echo $contract->comision_socio; }?>" readonly>
                    <div class="input-group-addon">
                       <?php echo $base_currency->symbol; ?>
                    </div>
                 </div>
              </div>
           </div>
            <div class="row">
              <div class="form-group select-placeholder col-md-4">
              	<?php
                 	$selected = (isset($contract) ? $contract->categoria_comercial_comercial : '');
                 	echo render_select('categoria_comercial_comercial',$commercial_category,array('id','detalle'),'contract_commercial_category',$selected);
                 ?>
              </div>
              <div class="form-group select-placeholder col-md-5">
              	<?php
                 	$selected = (isset($contract) ? $contract->comercial : '');
                 	echo render_select('comercial',$commercial,array('id','nombre'),'contract_commercial',$selected);
                 ?>
              </div>
              <div class="form-group col-md-3">
                 <label for="contract_value"><?php echo _l('contract_commercial_commission'); ?></label>
                 <div class="input-group" data-toggle="tooltip" title="<?php echo _l('contract_value_tooltip'); ?>">
                    <input type="number" class="form-control" name="comision_comercial" value="<?php if(isset($contract)){echo $contract->comision_comercial; }?>" readonly>
                    <div class="input-group-addon">
                       <?php echo $base_currency->symbol; ?>
                    </div>
                 </div>
              </div>
           </div>
            <div class="row">
               <div class="col-md-6">
                  <?php $value = (isset($contract) ? date('d-m-Y', strtotime($contract->fecha_suscripcion)) : _d(date('Y-m-d'))); ?>
                  <?php echo render_date_input('fecha_suscripcion','contract_subscription_date',$value); ?>
               </div>
               <div class="col-md-6">
               	<?php $value = (isset($contract)?date('d-m-Y', strtotime($contract->fecha_envio)):_d(date('Y-m-d'))); ?>
                <?php echo render_date_input('fecha_envio','contract_delivery_date',$value); ?>
               </div>
            </div>
            <div class="row">
              <div class="col-md-6">
               	<?php $value = (isset($contract)?date('d-m-Y', strtotime($contract->fecha_inicio_suministro)):_d(date('Y-m-d'))); ?>
                <?php echo render_date_input('fecha_inicio_suministro','contract_start_date_supply',$value); ?>
              </div>
              <div class="col-md-6">
               	<?php $value = (isset($contract)?date('d-m-Y', strtotime($contract->fecha_fin_suministro)):_d(date('Y-m-d'))); ?>
                <?php echo render_date_input('fecha_fin_suministro','contract_end_date_supply',$value,['readonly'=>'true']); ?>
              </div>
            </div>
            <div class="row">
               <div class="col-md-6">
               	<?php $value = (isset($contract)?date('d-m-Y', strtotime($contract->fecha_comerciante)):_d(date('Y-m-d'))); ?>
                <?php echo render_date_input('fecha_comerciante','contract_merchant_date',$value,['readonly'=>'true']); ?>
               </div>
               <div class="col-md-6">
               	<?php $value = (isset($contract)?date('d-m-Y', strtotime($contract->fecha_pago)):_d(date('Y-m-d'))); ?>
                  <?php echo render_date_input('fecha_pago','contract_pay_date',$value); ?>
               </div>
            </div>
            <?php $rel_id = (isset($contract) ? $contract->id : false); ?>
            <?php echo render_custom_fields('contracts', $rel_id); ?>
							<div class="btn-bottom-toolbar text-right">
							<?php if ($contract->termination_motive==0) { ?>
								<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
							<?php } ?>
            </div>
            <?php echo form_close(); ?>
            <input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
          </div>
        </div>
      </div>
      
      <?php if(isset($contract)) { //&& ($contract->termination_motive == 0) ?>
      <div class="col-md-5 right-column">
        <div class="panel_s">
          <div class="panel-body">
            <h4 class="no-margin"><?php echo $contract->subject; ?></h4>
            <a href="<?php echo site_url('commissions/'.$contract->id.'/'.$contract->hash); ?>" target="_blank">
            	<?php echo _l('view_contract'); ?>
            </a>
            <hr class="hr-panel-heading" />
            <?php if($contract->trash > 0){
              echo '<div class="ribbon default"><span>'._l('contract_trash').'</span></div>';
            } ?>
            <div class="horizontal-scrollable-tabs preview-tabs-top">
              <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
              <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
              <div class="horizontal-tabs">
                <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                  <li role="presentation" class="<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo 'active';} ?>">
                    <a href="#tab_content" aria-controls="tab_content" role="tab" data-toggle="tab"><?php echo _l('contract_content'); ?></a>
                  </li>
                  <li role="presentation" class="<?php if($this->input->get('tab') == 'attachments'){echo 'active';} ?>">
                    <a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">
                      <?php echo _l('contract_attachments'); ?>
                      <?php if($totalAttachments = count($contract->attachments)) { ?>
                        <span class="badge attachments-indicator"><?php echo $totalAttachments; ?></span>
                      <?php } ?>
                    </a>
                  </li>
                  <li role="presentation" class="<?php if($this->input->get('tab') == 'renewals'){echo 'active';} ?>">
                    <a href="#renewals" aria-controls="renewals" role="tab" data-toggle="tab">
                      <?php echo _l('no_contract_renewals_history_heading'); ?>
                      <?php if($totalRenewals = count($contract_renewal_history)) { ?>
                        <span class="badge"><?php echo $totalRenewals; ?></span>
                      <?php } ?>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane<?php if(!$this->input->get('tab') || $this->input->get('tab') == 'tab_content'){echo ' active';} ?>" id="tab_content">
                <div class="row">
                  <?php if($contract->signed == 1) { ?>
                    <div class="col-md-12">
                      <div class="alert alert-success">
                        <?php echo _l('document_signed_info',array(
                          '<b>'.$contract->acceptance_firstname . ' ' . $contract->acceptance_lastname . '</b> (<a href="mailto:'.$contract->acceptance_email.'">'.$contract->acceptance_email.'</a>)',
                          '<b>'. _dt($contract->acceptance_date).'</b>',
                          '<b>'.$contract->acceptance_ip.'</b>')
                        ); ?>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="col-md-12 text-right _buttons">
                  	<?php if (has_permission('contracts', '', 'delete') && ($contract->termination_motive == 0)) { ?>
                  		<div class="btn-group">
			                <div class="_buttons">
			                  <a href="#" class="btn btn-default" data-toggle="modal" data-target="#termination_contract_modal">
			                  	<i class="fa fa-arrow-down"></i> <?php echo _l('comicontract_termination'); ?>
			                  </a>
			                </div>
			                </div>
                  	<?php } ?>
                    <div class="btn-group">
	                    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                    	<i class="fa fa-file-pdf-o"></i><?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span>
	                    </a>
	                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="hidden-xs"><a href="<?php echo admin_url('commissions/pdf/'.$contract->id.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
                        <li class="hidden-xs">
                        	<a href="<?php echo admin_url('commissions/pdf/'.$contract->id.'?output_type=I'); ?>" target="_blank">
                        		<?php echo _l('view_pdf_in_new_window'); ?>
                        	</a>
                        </li>
                        <li><a href="<?php echo admin_url('commissions/pdf/'.$contract->id); ?>"><?php echo _l('download'); ?></a></li>
                        <li>
                           <a href="<?php echo admin_url('commissions/pdf/'.$contract->id.'?print=true'); ?>" target="_blank">
                           <?php echo _l('print'); ?>
                           </a>
                        </li>
	                    </ul>
                    </div>
                    <a href="#" class="btn btn-default" data-target="#contract_send_to_client_modal" data-toggle="modal">
                    	<span class="btn-with-tooltip" data-toggle="tooltip" data-title="<?php echo _l('contract_send_to_email'); ?>" data-placement="bottom">
                    		<i class="fa fa-envelope"></i>
                    	</span>
                    </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default pull-left dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      	<?php echo _l('more'); ?> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                          <a href="<?php echo site_url('commissions/'.$contract->id.'/'.$contract->hash); ?>" target="_blank"><?php echo _l('view_contract'); ?></a>
                        </li>
                        <?php hooks()->do_action('after_contract_view_as_client_link', $contract); ?>
                        <?php if(has_permission('contracts','','create')){ ?>
                        <li>
                          <a href="<?php echo admin_url('commissions/copy/'.$contract->id); ?>"><?php echo _l('contract_copy'); ?></a>
                        </li>
                        <?php } ?>
                        <?php if($contract->signed == 1 && has_permission('contracts','','delete')){ ?>
                        <li>
                          <a href="<?php echo admin_url('commissions/clear_signature/'.$contract->id); ?>" class="_delete"><?php echo _l('clear_signature'); ?></a>
                        </li>
                        <?php } ?>
                        <?php if(has_permission('contracts','','delete')){ ?>
                        <li>
                          <a href="<?php echo admin_url('commissions/delete/'.$contract->id); ?>" class="_delete"><?php echo _l('delete'); ?></a></li>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <?php if(isset($contract_merge_fields)){ ?>
                    <hr class="hr-panel-heading" />
                    <p class="bold mtop10 text-right">
                    	<a href="#" onclick="slideToggle('.avilable_merge_fields'); return false;"><?php echo _l('available_merge_fields'); ?></a>
                    </p>
                    <div class=" avilable_merge_fields mtop15 hide">
                      <ul class="list-group">
                        <?php
                        	foreach($contract_merge_fields as $field) {
                            foreach($field as $f) {
                              echo '<li class="list-group-item"><b>'.$f['name'].'</b>  <a href="#" class="pull-right" onclick="insert_merge_field(this); return false">'.$f['key'].'</a></li>';
                            }
                          }
                        ?>
                      </ul>
                    </div>
                    <?php } ?>
                  </div>
                </div>
                <hr class="hr-panel-heading" />
                <div class="editable tc-content" style="border:1px solid #d2d2d2;min-height:70px; border-radius:4px;">
                  <?php
                    if(empty($contract->content)){
                      echo hooks()->apply_filters('new_contract_default_content', '<span class="text-danger text-uppercase mtop15 editor-add-content-notice"> ' . _l('click_to_add_content') . '</span>');
                    } else {
                      echo $contract->content;
                    }
                  ?>
                </div>
                <?php if(!empty($contract->signature)) { ?>
                  <div class="row mtop25">
                    <div class="col-md-6 col-md-offset-6 text-right">
                      <p class="bold"><?php echo _l('document_customer_signature_text'); ?>
                        <?php if($contract->signed == 1 && has_permission('contracts','','delete')){ ?>
                          <a href="<?php echo admin_url('contracts/clear_signature/'.$contract->id); ?>" data-toggle="tooltip" title="<?php echo _l('clear_signature'); ?>" class="_delete text-danger">
                        		<i class="fa fa-remove"></i>
                          </a>
                        <?php } ?>
                      </p>
                      <div class="pull-right">
                        <img src="<?php echo site_url('download/preview_image?path='.protected_file_url_by_path(get_upload_path_by_type('contract').$contract->id.'/'.$contract->signature)); ?>" class="img-responsive" alt="">
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'attachments'){echo ' active';} ?>" id="attachments">
                <?php echo form_open(admin_url('contracts/add_contract_attachment/'.$contract->id),array('id'=>'contract-attachments-form','class'=>'dropzone')); ?>
                <?php echo form_close(); ?>
                  <div class="text-right mtop15">
                    <button class="gpicker" data-on-pick="contractGoogleDriveSave">
                        <i class="fa fa-google" aria-hidden="true"></i>
                        <?php echo _l('choose_from_google_drive'); ?>
                    </button>
                    <div id="dropbox-chooser"></div>
                    <div class="clearfix"></div>
                  </div>
                  <!-- <img src="https://drive.google.com/uc?id=14mZI6xBjf-KjZzVuQe8-rjtv_wXEbDTw" /> -->

                  <div id="contract_attachments" class="mtop30">
                    <?php
                      $data = '<div class="row">';
                      foreach($contract->attachments as $attachment) 
                      {
                        $href_url = site_url('download/file/contract/'.$attachment['attachment_key']);
                        if(!empty($attachment['external']))
                        {
                          $href_url = $attachment['external_link'];
                        }
                        $data .= '<div class="display-block contract-attachment-wrapper">';
                        $data .= '<div class="col-md-10">';
                        $data .= '<div class="pull-left"><i class="'.get_mime_class($attachment['filetype']).'"></i></div>';
                        $data .= '<a href="'.$href_url.'"'.(!empty($attachment['external']) ? ' target="_blank"' : '').'>'.$attachment['file_name'].'</a>';
                        $data .= '<p class="text-muted">'.$attachment["filetype"].'</p>';
                        $data .= '</div>';
                        $data .= '<div class="col-md-2 text-right">';
                        if($attachment['staffid'] == get_staff_user_id() || is_admin())
                        {
                          $data .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,'.$attachment['id'].'); return false;"><i class="fa fa fa-times"></i></a>';
                        }
                        $data .= '</div>';
                        $data .= '<div class="clearfix"></div><hr/>';
                        $data .= '</div>';
                      }
                      $data .= '</div>';
                      echo $data;
                    ?>
                  </div>
              </div>
              <div role="tabpanel" class="tab-pane<?php if($this->input->get('tab') == 'renewals'){echo ' active';} ?>" id="renewals">
                <?php if ((has_permission('contracts', '', 'create') || has_permission('contracts', '', 'edit')) && ($contract->termination_motive == 0)) { ?>
                <div class="_buttons">
                  <a href="#" class="btn btn-default" data-toggle="modal" data-target="#renew_contract_modal">
                  	<i class="fa fa-refresh"></i> <?php echo _l('contract_renew_heading'); ?>
                  </a>
                </div>
                <hr />
                <?php } ?>
                <div class="clearfix"></div>
                <?php
                  if(count($contract_renewal_history) == 0)
                  {
                    echo _l('no_contract_renewals_found');
                  }
                  foreach($contract_renewal_history as $renewal)
                  { ?>
                    <div class="display-block">
                      <div class="media-body">
                        <div class="display-block">
                        	<b><?php echo _l('contract_renewed_by',$renewal['renewed_by']); ?></b>
                          <?php if($renewal['renewed_by_staff_id'] == get_staff_user_id() || is_admin()){ ?>
                            <a href="<?php echo admin_url('commissions/delete_renewal/'.$renewal['id'] . '/'.$renewal['contractid']); ?>" class="pull-right _delete text-danger">
                            	<i class="fa fa-remove"></i>
                            </a>
                            <br />
                          <?php } ?>
                          <small class="text-muted"><?php echo _dt($renewal['date_renewed']); ?></small>
                          <hr class="hr-10" />
                          <span class="text-success bold" data-toggle="tooltip" title="<?php echo _l('contract_renewal_old_start_date',_d($renewal['old_start_date'])); ?>">
                            <?php echo _l('contract_renewal_new_start_date',_d($renewal['new_start_date'])); ?>
                          </span>
                          <br />
                          <?php if(is_date($renewal['new_end_date'])){
                            $tooltip = '';
                            if(is_date($renewal['old_end_date'])){
                            	$tooltip = _l('contract_renewal_old_end_date',_d($renewal['old_end_date']));
                            }
                          ?>
                          <span class="text-success bold" data-toggle="tooltip" title="<?php echo $tooltip; ?>">
                          	<?php echo _l('contract_renewal_new_end_date',_d($renewal['new_end_date'])); ?>
                          </span>
                          <br/>
                          <?php } ?>
                          <?php if($renewal['new_value'] > 0){
                            $contract_renewal_value_tooltip = '';
                            if($renewal['old_value'] > 0){
                              $contract_renewal_value_tooltip = ' data-toggle="tooltip" data-title="'._l('contract_renewal_old_value', app_format_money($renewal['old_value'], $base_currency)).'"';
                            } ?>
                          <span class="text-success bold"<?php echo $contract_renewal_value_tooltip; ?>>
                          <?php echo _l('contract_renewal_new_value', app_format_money($renewal['new_value'], $base_currency)); ?>
                          </span>
                          <br />
                          <?php } ?>
                      </div>
                    </div>
                    <hr />
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php init_tail(); ?>
<?php if(isset($contract)){ ?>
<!-- init table tasks -->
<script>
   var contract_id = '<?php echo $contract->id; ?>';
</script>
<?php $this->load->view('admin/commission/send_to_client'); ?>
<?php $this->load->view('admin/commission/renew_contract'); ?>
<?php $this->load->view('admin/commission/termination_contract'); ?>
<?php } ?>
<?php $this->load->view('admin/commission/comercializador'); ?>
<?php $this->load->view('admin/commission/tarifa'); ?>
<?php $this->load->view('admin/commission/nivel_precios'); ?>
<?php $this->load->view('admin/commission/commercial_category'); ?>
<?php $this->load->view('admin/commission/commercial'); ?>
<?php $this->load->view('admin/commission/stress_level'); ?>
<?php $this->load->view('admin/commission/partner'); ?>

<script>
	var decimal_separator = '<?php echo $decimal_separator; ?>';
	var accion = '<?php echo $accion; ?>';
	
  Dropzone.autoDiscover = false;
      
  $(function () {
    if ($('#contract-attachments-form').length > 0) {
     	new Dropzone("#contract-attachments-form", $.extend({}, _dropzone_defaults(), {
      	success: function (file) {
         	if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
          	var location = window.location.href;
          	window.location.href = location.split('?')[0] + '?tab=attachments';
         	}
      	}
     	}));
  	}

  	// In case user expect the submit btn to save the contract content
  	$('#contract-form').on('submit', function () {
     	$('#inline-editor-save-btn').click();
     	return true;
  	});

		if (typeof (Dropbox) != 'undefined' && $('#dropbox-chooser').length > 0) {
		  document.getElementById("dropbox-chooser").appendChild(Dropbox.createChooseButton({
				success: function (files) {
				  $.post(admin_url + 'commissions/add_external_attachment', {
				    files: files,
				    contract_id: contract_id,
				    external: 'dropbox'
				  }).done(function () {
				    var location = window.location.href;
				    window.location.href = location.split('?')[0] + '?tab=attachments';
				  });
				},
				linkType: "preview",
				extensions: app_allowed_files.split(','),
		  }));
		}

  	_validate_form($('#contract-form'), {
     	cliente: 'required',
     	nif: 'required',
     	cpe: 'required',
     	nivel_tension: 'required',
     	potencia_contratada: 'required',
     	consumo_anual: 'required',
     	comercializador: 'required',
     	duration: 'required',
     	tarifa: 'required',
     	nivel_precios: 'required',
     	valor_contrato: 'required'
  	});
    	
  	_validate_form($('#renew-contract-form'), {
     	new_start_date: 'required'
  	});

  	var _templates = [];
  	$.each(contractsTemplates, function (i, template) {
     	_templates.push({
        	url: admin_url + 'commissions/get_template?name=' + template,
        	title: template
     	});
  	});

    	var editor_settings = {
       	selector: 'div.editable',
       	inline: true,
       	theme: 'inlite',
       	relative_urls: false,
       	remove_script_host: false,
       	inline_styles: true,
       	verify_html: false,
       	cleanup: false,
       	apply_source_formatting: false,
       	valid_elements: '+*[*]',
       	valid_children: "+body[style], +style[type]",
       	file_browser_callback: elFinderBrowser,
       	table_default_styles: {
          	width: '100%'
       	},
       	fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
       	pagebreak_separator: '<p pagebreak="true"></p>',
       	plugins: [
          	'advlist pagebreak autolink autoresize lists link image charmap hr',
          	'searchreplace visualblocks visualchars code',
          	'media nonbreaking table contextmenu',
          	'paste textcolor colorpicker'
       	],
       	autoresize_bottom_margin: 50,
       	insert_toolbar: 'image media quicktable | bullist numlist | h2 h3 | hr',
       	selection_toolbar: 'save_button bold italic underline superscript | forecolor backcolor link | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect h2 h3',
       	contextmenu: "image media inserttable | cell row column deletetable | paste pastetext searchreplace | visualblocks pagebreak charmap | code",
       	setup: function (editor) {
          	editor.addCommand('mceSave', function () {
          		alert('mceSave');
             	save_contract_content(true);
          	});

          	editor.addShortcut('Meta+S', '', 'mceSave');

          	editor.on('MouseLeave blur', function () {
             	if (tinymce.activeEditor.isDirty()) {
                	save_contract_content();
             	}
          	});

          	editor.on('MouseDown ContextMenu', function () {
             	if (!is_mobile() && !$('.left-column').hasClass('hide')) {
                	contract_full_view();
             	}
          	});

          	editor.on('blur', function () {
             	$.Shortcuts.start();
          	});

          	editor.on('focus', function () {
             	$.Shortcuts.stop();
          	});
       	}
    	}

    	if (_templates.length > 0) {
       	editor_settings.templates = _templates;
       	editor_settings.plugins[3] = 'template ' + editor_settings.plugins[3];
       	editor_settings.contextmenu = editor_settings.contextmenu.replace('inserttable', 'inserttable template');
    	}

     	if(is_mobile()) {
         editor_settings.theme = 'modern';
         editor_settings.mobile    = {};
         editor_settings.mobile.theme = 'mobile';
         editor_settings.mobile.toolbar = _tinymce_mobile_toolbar();

         editor_settings.inline = false;
         window.addEventListener("beforeunload", function (event) {
            if (tinymce.activeEditor.isDirty()) {
               save_contract_content();
            }
         });
     	}

    	tinymce.init(editor_settings);
   });

	function save_contract_content(manual) {
    	var editor = tinyMCE.activeEditor;
    	var data = {};
    	data.contract_id = contract_id;
    	data.content = editor.getContent();
    	$.post(admin_url + 'commissions/save_contract_data', data).done(function (response) {
       	response = JSON.parse(response);
       	if (typeof (manual) != 'undefined') {
         	// Show some message to the user if saved via CTRL + S
          	alert_float('success', response.message);
       	}
       	// Invokes to set dirty to false
       	editor.save();
    	}).fail(function (error) {
       	var response = JSON.parse(error.responseText);
       	alert_float('danger', response.message);
    	});
  }

   function delete_contract_attachment(wrapper, id) {
    if (confirm_delete()) {
       $.get(admin_url + 'commissions/delete_contract_attachment/' + id, function (response) {
          if (response.success == true) {
             $(wrapper).parents('.contract-attachment-wrapper').remove();

             var totalAttachmentsIndicator = $('.attachments-indicator');
             var totalAttachments = totalAttachmentsIndicator.text().trim();
             if(totalAttachments == 1) {
               totalAttachmentsIndicator.remove();
             } else {
               totalAttachmentsIndicator.text(totalAttachments-1);
             }
          } else {
             alert_float('danger', response.message);
          }
       }, 'json');
    }
    return false;
   }

   function insert_merge_field(field) {
    var key = $(field).text();
    tinymce.activeEditor.execCommand('mceInsertContent', false, key);
   }

   function contract_full_view() {
    $('.left-column').toggleClass('hide');
    $('.right-column').toggleClass('col-md-7');
    $('.right-column').toggleClass('col-md-12');
    $(window).trigger('resize');
   }

   function add_contract_comment() {
    var comment = $('#comment').val();
    if (comment == '') {
       return;
    }
    var data = {};
    data.content = comment;
    data.contract_id = contract_id;
    $('body').append('<div class="dt-loader"></div>');
    $.post(admin_url + 'commissions/add_comment', data).done(function (response) {
       response = JSON.parse(response);
       $('body').find('.dt-loader').remove();
       if (response.success == true) {
          $('#comment').val('');
          get_contract_comments();
       }
    });
   }

   function get_contract_comments() {
    if (typeof (contract_id) == 'undefined') {
      return;
    }
    requestGet('commissions/get_comments/' + contract_id).done(function (response) {
     	$('#contract-comments').html(response);
     	var totalComments = $('[data-commentid]').length;
     	var commentsIndicator = $('.comments-indicator');
     	if(totalComments == 0) {
        commentsIndicator.addClass('hide');
     	} else {
      	commentsIndicator.removeClass('hide');
      	commentsIndicator.text(totalComments);
     	}
    });
   }

   function remove_contract_comment(commentid) {
    if (confirm_delete()) {
       requestGetJSON('commissions/remove_comment/' + commentid).done(function (response) {
          if (response.success == true) {
            var totalComments = $('[data-commentid]').length;
             $('[data-commentid="' + commentid + '"]').remove();
             var commentsIndicator = $('.comments-indicator');
             if(totalComments-1 == 0) {
               commentsIndicator.addClass('hide');
            } else {
               commentsIndicator.removeClass('hide');
               commentsIndicator.text(totalComments-1);
            }
          }
       });
    }
   }

   function edit_contract_comment(id) {
    var content = $('body').find('[data-contract-comment-edit-textarea="' + id + '"] textarea').val();
    if (content != '') {
       $.post(admin_url + 'commissions/edit_comment/' + id, {
          content: content
       }).done(function (response) {
          response = JSON.parse(response);
          if (response.success == true) {
             alert_float('success', response.message);
             $('body').find('[data-contract-comment="' + id + '"]').html(nl2br(content));
          }
       });
       toggle_contract_comment_edit(id);
    }
   }

  function toggle_contract_comment_edit(id) {
		$('body').find('[data-contract-comment="' + id + '"]').toggleClass('hide');
		$('body').find('[data-contract-comment-edit-textarea="' + id + '"]').toggleClass('hide');
  }
   
	///// Cuando cambia el comercializador.
	$('#module_id').change(function(Event) {
		// Filtra las tarifas
		var country_id =  $('#country_id option:selected').val();
		var module_id =  $('#module_id option:selected').val();
		var url = $('#adminurl').val()+'/commissions/filtrar_tarifa/'+country_id+'/'+module_id;
    $.post(url).done(function (response) {
    	response = JSON.parse(response);
			$('#tarifa').children('option:not(:first)').remove();
			for (var i=0; i < response.length; i++) {
				$('#tarifa').append('<option value="'+response[i].id+'">'+response[i].descripcion+'</option>');
			}
			var soTarifa = $('#tarifa');
			soTarifa.selectpicker('refresh');
    });
	});
	
	///// Cuando cambia la categoria comercial.
	$('#categoria_comercial').change(function(Event) {
		//Filtra los socios.
		var categoria_comercial =  $('#categoria_comercial option:selected').val();
		var url = $('#adminurl').val()+'/commissions/filtrar_socios/'+categoria_comercial;
    $.post(url).done(function (response) {
    	response = JSON.parse(response);
			$('#socio').children('option:not(:first)').remove();
			for (var i=0; i < response.length; i++) {
				$('#socio').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
			}
			var soSocio = $('#socio');
			soSocio.selectpicker('refresh');
			$('input[name=comision_socio]').val('');
    });
	});
	
	///// Cuando cambia la categoria comercial comercial.
	$('#categoria_comercial_comercial').change(function(Event) {
		//Filtra los socios.
		var categoria_comercial_comercial =  $('#categoria_comercial_comercial option:selected').val();
		var url = $('#adminurl').val()+'/commissions/filtrar_socios/'+categoria_comercial_comercial;
    $.post(url).done(function (response) {
    	response = JSON.parse(response);
			$('#comercial').children('option:not(:first)').remove();
			for (var i=0; i < response.length; i++) {
				$('#comercial').append('<option value="'+response[i].id+'">'+response[i].nombre+'</option>');
			}
			var soSocio = $('#comercial');
			soSocio.selectpicker('refresh');
			$('input[name=comision_comercial]').val('');
    });
	});

	///// Cuando cambia la tarifa.
	$('#tarifa').change(function(Event) {			
		// Filtra los niveles de precios
		var comercializador =  $('#comercializador option:selected').val();
		var tarifa = $('#tarifa option:selected').val();
		var country_id =  $('#country_id option:selected').val();
		var module_id =  $('#module_id option:selected').val();
		var url = $('#adminurl').val()+'/commissions/filtrar_precios/'+comercializador+'/'+tarifa+'/'+country_id+'/'+module_id;
  	$.post(url).done(function (response) {
  		response = JSON.parse(response);
			$('#nivel_precios').children('option:not(:first)').remove();
			for (var i=0; i < response.length; i++) {
				$('#nivel_precios').append('<option value="'+response[i].id+'">'+response[i].detalle+'</option>');
			}
			var soComercializador = $('#nivel_precios');
			soComercializador.selectpicker('refresh');
		});
	});

	///// Cuando selecciona un cliente.
	$('#clientid').change(function(Event) {
		var id =  $('#clientid option:selected').val();
		if (id != '') {
			var url = $('#adminurl').val()+'commissions/dat_cliente/'+id;
	    $.post(url).done(function (response) {
	      response = JSON.parse(response);
	      if (response.length>0) $('#nif').val(response[0].vat);
	    });
    }
	});
	
	///// Obtiene las comisiones.
	$('#nivel_precios').change(function(Event) {
		//Obtiene las comisiones.
		var url_base = 'commissions/obtener_comisiones/';
		var comercializador = $('#comercializador option:selected').val();
		var tarifa = $('#tarifa option:selected').val();
		var nivel_precios = $('#nivel_precios option:selected').val();
		var categoria_comercial = '1';
		var consumo_anual = $('#consumo_anual').val();
		var country_id =  $('#country_id option:selected').val();
		var module_id =  $('#module_id option:selected').val();
		var url = $('#adminurl').val()+url_base+comercializador+'/'+tarifa+'/'+nivel_precios+'/'+categoria_comercial+'/'+consumo_anual+'/'+country_id+'/'+module_id;
    $.post(url).done(function (response){
	    response = JSON.parse(response);
	    $('input[name=valor_contrato]').val(response[0].comision);
    });
	});

	///// Obtiene las comisiones socio
	$('#socio').change(function(Event) {
		//Obtiene las comisiones socio
		var url_base = 'commissions/obtener_comisiones_socio/';
		var comercializador = $('#comercializador option:selected').val();
		var tarifa = $('#tarifa option:selected').val();
		var categoria_comercial = $('#categoria_comercial option:selected').val();
		var nivel_precios = $('#nivel_precios option:selected').val();
		var consumo_anual = $('#consumo_anual').val();
		var url = $('#adminurl').val()+url_base+comercializador+'/'+tarifa+'/'+categoria_comercial+'/'+consumo_anual+'/'+nivel_precios;
    $.post(url).done(function (response){
	    response = JSON.parse(response);
	    $('input[name=comision_socio]').val(response[0].comision);
    });
	});
	
	///// Cambia el consumo anual
	$('#consumo_anual').change(function(Event) {
		$('#comercializador option:selected').val('');
		// Limpiar nivel de precios
		$('#nivel_precios').children('option:not(:first)').remove();
		var soNivelPrecios = $('#nivel_precios');
		soNivelPrecios.selectpicker('refresh');
		// Valor del contrato
		$('input[name=valor_contrato]').val('');
	});

	///// Obtiene las comisiones comercial
	$('#comercial').change(function(Event) {
		//Obtiene las comisiones comercial
		var url_base = 'commissions/obtener_comisiones_socio/';
		var comercializador = $('#comercializador option:selected').val();
		var tarifa = $('#tarifa option:selected').val();
		var categoria_comercial = $('#categoria_comercial_comercial option:selected').val();
		var nivel_precios = $('#nivel_precios option:selected').val();
		var consumo_anual = $('#consumo_anual').val();
		var url = $('#adminurl').val()+url_base+comercializador+'/'+tarifa+'/'+categoria_comercial+'/'+consumo_anual+'/'+nivel_precios;
    $.post(url).done(function (response){
	    response = JSON.parse(response);
	    $('input[name=comision_comercial]').val(response[0].comision);
    });
	});
	
	function val_numbers(e) 
	{
		var cod = 0;
		if (decimal_separator==',') cod = 44;
		if (decimal_separator=='.') cod = 46;
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == cod)) return true;
    return /\d/.test(String.fromCharCode(keynum));
  }
  
	///// Calcula la fecha de fin de suministro y la renovación.
	$('#duration').change(function(Event) 
	{
		var meses = parseInt($('#duration').val());
		var date = new Date();
		var fecha_actual = date.getDate()+"-"+date.getMonth()+"-"+date.getFullYear();
		date.setMonth(date.getMonth() + meses);
		var fecha_fin_suministro = padLeft(date.getDate(), 2)+"-"+padLeft(date.getMonth(), 2)+"-"+date.getFullYear();
		date.setMonth(date.getMonth() - 2);
		var fecha_renovacion = padLeft(date.getDate(), 2)+'-'+padLeft(date.getMonth(), 2)+'-'+date.getFullYear();
		
		$('#fecha_fin_suministro').val(fecha_fin_suministro);
		$('#fecha_comerciante').val(fecha_renovacion);
	});
	
	function padLeft(value, length) {
    return (value.toString().length < length) ? padLeft("0" + value, length) : value;
	}
	
</script>
</body>
</html>
