<style type="text/css">
  .np {padding: 0 !important; margin: 0 !important;}
  .ed tr td {padding: 0 !important; margin: 0 !important;}
</style>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="customer-profile-group-heading"><?php echo _l('commercial_visit_take_fordata'); ?></h4>
<div class="row">
    <div class="col-md-12">
      <div class="horizontal-scrollable-tabs">
        <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
        <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
        <div class="horizontal-tabs">
          <ul class="nav nav-tabs profile-tabs row customer-profile-tabs nav-tabs-horizontal" role="tablist">
            <li role="presentation" class="<?php if(!$this->input->get('tab')){echo 'active';}; ?>">
              <a href="#contact_info" aria-controls="contact_info" role="tab" data-toggle="tab">
                <?php echo _l( 'personal_information'); ?>
              </a>
            </li>
            <li role="presentation">
              <a href="#sales_data" aria-controls="sales_data" role="tab" data-toggle="tab">
                <?php echo _l( 'sales_data'); ?>
              </a>
            </li>
            <li role="presentation">
              <a href="#economic_data" aria-controls="economic_data" role="tab" data-toggle="tab">
                <?php echo _l( 'economic_data'); ?>
              </a>
            </li> 
            <li role="presentation">
              <a href="#operation_banks" aria-controls="operation_banks" role="tab" data-toggle="tab">
                <?php echo _l( 'operation_banks'); ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="tab-content">

        <!-- Datos personales -->
        <div role="tabpanel" class="tab-pane<?php if(!$this->input->get('tab')){echo ' active';}; ?>" id="contact_info">
          <?php $id_takedata=(isset($take_data) ? $take_data->id : ''); ?>
          <?php $url = admin_url('commercials_visits/take_form/' . $client . '/' . $id_takedata); ?>
          <?php echo form_open($url,array('class'=>'information-data-head-form','autocomplete'=>'off','id'=>'take-data-form')); ?>
            <!--<div class="row">-->
              <div class="col-md-12 np">
                <div class="additional">
                  <?php echo form_hidden('id', $id_takedata); ?>
                  <?php echo form_hidden('client', $client); ?>
                  <?php echo form_hidden('form', 'take-data-form'); ?>
                </div>
                <div class="col-md-3">
                  <?php $value=(isset($take_data) ? $take_data->cesion : ''); ?>
                  <?php echo render_input('cesion', 'take_data_cesion',$value,'text'); ?>
                </div>
                <div class="col-md-3">
                  <?php $selected=(isset($take_data) ? $take_data->collaboration_contract : ''); ?>
                  <?php echo render_select('collaboration_contract',$collaborations_contracts,array('id','name'),'take_data_collaboration_contract',$selected); ?>
                </div>
                <div class="col-md-3">
                  <?php $selected=(isset($take_data) ? $take_data->endorsement : ''); ?>
                  <?php echo render_select('endorsement',$endorsements,array('id','name'),'take_data_double_endorsement',$selected); ?>
                </div>
                <div class="col-md-3">
                  <?php $selected=(isset($take_data) ? $take_data->relation_ship : ''); ?>
                  <?php echo render_select('relation_ship',$relations_ships,array('id','relation_ship'),'take_data_double_relation_ship',$selected); ?>
                </div>
                <hr />
              </div>  
              <div class="col-md-6">
                <h3><?php echo _l('headline'); ?> 1</h3>
                <hr />
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->name_1 : ''); ?>
                    <?php echo render_input('name_1', 'take_data_name',$value,'text'); ?>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->lastname_1 : ''); ?>
                    <?php echo render_input('lastname_1', 'take_data_lastname',$value,'text'); ?>
                  </div>
                  <div class="col-md-5" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->dninie_1 : ''); ?>
                    <?php echo render_input('dninie_1', 'take_data_dnidie',$value); ?>
                  </div>
                  <div class="col-md-5" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? _d(date("Y-m-d",strtotime($take_data->birthdate_1))) : _d(date())); ?>
                    <?php echo render_date_input('birthdate_1', 'take_data_birth_date',$value); ?>
                  </div>
                  <div class="col-md-2" style="padding: 0px;">
                    <?php 
                      $tiempo = strtotime($value); 
                      $ahora = time(); 
                      $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
                      $edad = floor($edad);                     
                    ?>
                    <?php echo render_input('age_1', 'take_data_age',$edad,'number',['style'=>'text-align: center; background-color:White;','readonly'=>'true']); ?>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->phonenumber_1 : ''); ?>
                    <?php echo render_input('phonenumber_1', 'client_phonenumber',$value); ?>
                  </div>  
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->email_1 : ''); ?>
                    <?php echo render_input('email_1', 'take_data_email',$value); ?>
                  </div>  
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $selected=(isset($take_data) ? $take_data->civilstatus_1 : ''); ?>
                    <?php echo render_select('civilstatus_1',$civils_status,array('id','civil_status'),'take_data_civil_status',$selected); ?>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->sons_1 : ''); ?>
                    <?php echo render_input('sons_1', 'take_data_sons',$value,'number'); ?>
                  </div>
                  <div class="col-md-7" style="padding: 0px;">
                    <?php $selected=(isset($take_data) ? $take_data->maintenance_1 : ''); ?>
                    <?php if ($selected==0) $selected = ""; ?>
                    <?php echo render_select('maintenance_1',$maintenances,array('id','name'),'take_data_maintenance',$selected); ?>
                  </div>
                  <div class="col-md-5" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->amount_1 : ''); ?>
                    <?php echo render_input('amount_1', 'take_data_amount',$value,'number',['style'=>'text-align: right']); ?>
                  </div>
                <h4><?php echo _l('take_data_double_guarantee'); ?></h4>
                <hr />
                  <?php $value=(isset($take_data) ? $take_data->owner1 : ''); ?>
                  <?php echo render_input('owner1', 'take_data_owners',$value); ?>
                  <?php $value=(isset($take_data) ? $take_data->owner2 : ''); ?>
                  <?php echo render_input('owner2', '...',$value); ?>
                  <?php $value=(isset($take_data) ? $take_data->owner3 : ''); ?>
                  <?php echo render_input('owner3', '...',$value); ?>
              </div>
              <div class="col-md-6">
                <h3><?php echo _l('headline'); ?> 2</h3>
                <hr />
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->name_2 : ''); ?>
                    <?php echo render_input('name_2', 'take_data_name',$value,'text',$attrs); ?>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->lastname_2 : ''); ?>
                    <?php echo render_input('lastname_2', 'take_data_lastname',$value,'text',$attrs); ?>
                  </div>
                  <div class="col-md-5" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->dninie_2 : ''); ?>
                    <?php echo render_input('dninie_2', 'take_data_dnidie',$value); ?>
                  </div>
                  <div class="col-md-5" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? _d(date("Y-m-d",strtotime($take_data->birthdate_2))) : _d(date())); ?>
                    <?php echo render_date_input('birthdate_2', 'take_data_birth_date',$value); ?>
                  </div>
                  <div class="col-md-2" style="padding: 0px;">
                    <?php 
                      $tiempo = strtotime($value); 
                      $ahora = time(); 
                      $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
                      $edad = floor($edad);                     
                    ?>
                    <?php echo render_input('age_2', 'take_data_age',$edad,'number',['style'=>'text-align: center; background-color:White;','readonly'=>'true']); ?>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->phonenumber_2 : ''); ?>
                    <?php echo render_input('phonenumber_2', 'client_phonenumber',$value); ?>
                  </div>  
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->email_2 : ''); ?>
                    <?php echo render_input('email_2', 'take_data_email',$value); ?>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $selected=(isset($take_data) ? $take_data->civilstatus_2 : ''); ?>
                    <?php echo render_select('civilstatus_2',$civils_status,array('id','civil_status'),'take_data_civil_status',$selected); ?>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                    <?php $value=(isset($take_data) ? $take_data->sons_2 : ''); ?>
                    <?php echo render_input('sons_2', 'take_data_sons',$value,'number'); ?>
                  </div>
                  <div class="col-md-7" style="padding: 0px;">
                    <?php $selected=(isset($take_data) ? $take_data->maintenance_2 : ''); ?>
                    <?php if ($selected==0) $selected = ""; ?>
                    <?php echo render_select('maintenance_2',$maintenances,array('id','name'),'take_data_maintenance',$selected); ?>
                  </div>
                  <div class="col-md-5" style="padding: 0px;">   
                    <?php $value=(isset($take_data) ? $take_data->amount_2 : ''); ?>
                    <?php echo render_input('amount_2', 'take_data_amount',$value,'number',['style'=>'text-align: right']); ?>
                  </div>
                <h4><?php echo _l('take_data_double_guarantee'); ?></h4>
                <hr />
                  <?php $value=(isset($take_data) ? $take_data->direction : ''); ?>
                  <?php echo render_input('direction', 'take_data_direction',$value); ?>
                  <?php $value=(isset($take_data) ? $take_data->estimated : ''); ?>
                  <?php echo render_input('estimated', 'take_data_estimated',$value,'number',['style'=>'text-align: right']); ?>
                  <?php $selected=(isset($take_data) ? $take_data->responsabilities : ''); ?>
                  <?php echo render_select('responsabilities',$responsabilities,array('id','name'),'take_data_responsabilities',$selected); ?>
              </div>
              <?php if (has_permission('commercials_visits', '', 'create') || has_permission('commercials_visits', '', 'edit')) { ?>
                <div class="col-md-12 text-center">
                  <button type="submit" class="btn btn-info"><?php echo _l('personal_information_save'); ?></button>
                </div>
              <?php } ?>
            <!--</div>-->
          <?php echo form_close(); ?>
        </div>
        
        <!-- Datos compraventa -->
        <div role="tabpanel" class="tab-pane" id="sales_data">
          <?php $id_salesdata=(isset($sales_data) ? $sales_data->id : ''); ?>
          <?php $url = admin_url('commercials_visits/take_form/' . $client . '/' . $id_salesdata); ?>
          <?php echo form_open($url,array('class'=>'sales-data-form','autocomplete'=>'off','id'=>'sales-data-form')); ?>
            <div class="row"><br>
              <div class="col-md-12">
                <div class="additional">
                  <?php echo form_hidden('id', $id_salesdata); ?>
                  <?php echo form_hidden('client', $client); ?>
                  <?php echo form_hidden('form', 'sales-data-form'); ?>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php $value=( isset($sales_data) ? $sales_data->purchase_price : ''); ?>
                    <?php echo render_input( 'purchase_price', 'take_data_purchase_price',$value,'number',['style'=>'text-align: right']); ?>
                    <?php $value=( isset($sales_data) ? $sales_data->purchase_address : ''); ?>
                    <?php echo render_input( 'purchase_address', 'take_data_purchase_address',$value); ?>
                    <?php $value=( isset($sales_data) ? $sales_data->maximum_quota : ''); ?>
                    <?php echo render_input( 'maximum_quota', 'take_data_maximum_quota',$value,'number',['style'=>'text-align: right']); ?>
                    <?php $value=( isset($sales_data) ? $sales_data->reserve_amount : ''); ?>
                    <?php echo render_input( 'reserve_amount', 'take_data_reserve_amount',$value,'number',['style'=>'text-align: right']); ?>
                    <?php $value=( isset($sales_data) ? $sales_data->proposed_fees : ''); ?>
                    <?php echo render_input( 'proposed_fees', 'take_data_proposed_fees',$value,'number',['style'=>'text-align: right']); ?>
                    <?php $selected=(isset($sales_data) ? $sales_data->arran_contract : ''); ?>
                    <?php echo render_select('arran_contract',$maintenances,array('id','name'),'take_data_arran_contract',$selected); ?>
                    <?php $value = (isset($sales_data) ? _d(date("Y-m-d",strtotime($sales_data->arran_end_date))) : _d(date())); ?>
                    <?php echo render_date_input('arran_end_date','take_data_arran_end_date',$value); ?>
                  </div>
                  <div class="col-md-6">
                    <?php $value=( isset($sales_data) ? $sales_data->total_contribution : ''); ?>
                    <?php echo render_input( 'total_contribution', 'take_data_total_contribution',$value,'number',['style'=>'text-align: right']); ?>
                    <?php $value=( isset($sales_data) ? $sales_data->real_state_appraisa : ''); ?>
                    <?php echo render_input( 'real_state_appraisa', 'take_data_real_state_appraisa',$value,'number',['style'=>'text-align: right']); ?>
                    <?php $value=( isset($sales_data) ? $sales_data->real_state_commisionss : ''); ?>
                    <?php echo render_input( 'real_state_commisionss', 'take_data_real_state_commisionss',$value,'number',['style'=>'text-align: right']); ?>
                    <?php $selected=(isset($sales_data) ? $sales_data->purchase_price_commission : ''); ?>
                    <?php echo render_select('purchase_price_commission',$purchase_prices_commission,array('id','name'),'take_data_purchase_price_commission',$selected); ?>
                    <?php $selected=(isset($sales_data) ? $sales_data->payment_method : ''); ?>
                    <?php echo render_select('payment_method',$payment_methods,array('id','payment_method'),'take_data_payment_method',$selected); ?>
                    <?php $selected=(isset($sales_data) ? $sales_data->priced : ''); ?>
                    <?php echo render_select('priced',$priceds,array('id','name'),'take_data_priced',$selected); ?>
                    <?php $value=( isset($sales_data) ? $sales_data->appraisal_company : ''); ?>
                    <?php echo render_input( 'appraisal_company', 'take_data_appraisal_company',$value); ?>
                  </div>
                </div>
              </div>
              <?php if (has_permission('commercials_visits', '', 'create') || has_permission('commercials_visits', '', 'edit')) { ?>
                <div class="col-md-12 text-center">
                  <button type="submit" class="btn btn-info"><?php echo _l('sales_data_save'); ?></button>
                </div>
              <?php } ?>
            </div>
          <?php echo form_close(); ?>
        </div>
        
				<!-- Datos economicos -->
        <div role="tabpanel" class="tab-pane" id="economic_data">
          <?php $id_economicdata=(isset($sales_data) ? $economic_data->id : ''); ?>
          <?php $url = admin_url('commercials_visits/take_form/' . $client . '/' . $id_economicdata); ?>
          <?php echo form_open($url,array('class'=>'economic-data-hl1-form','autocomplete'=>'off','id'=>'economic-data-form')); ?>
            <div class="row">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="additional">
                          <?php echo form_hidden('id', $id_economicdata); ?>
                          <?php echo form_hidden('client', $client); ?>
                          <?php echo form_hidden('form', 'economic-data-form'); ?>
                        </div>
                        <h4><?php echo _l('headline'); ?> 1</h4>
                        <hr />
                          <table class="ed col-md-12 table table-bordered">
                            <tr>
                              <td><?php echo _l('high_date_last_job'); ?></td>
                              <?php $value=( isset($economic_data) ? _d(date("Y-m-d",strtotime($economic_data->high_date_last_job_1))) : _d(date())); ?>
                              <td><?php echo render_date_input('high_date_last_job_1', '',$value); ?></td>
                            </tr><tr>
                              <td><?php echo _l('profession'); ?></td>
                              <?php $value=( isset($economic_data) ? $economic_data->profession_1 : ''); ?>
                              <td><?php echo render_input('profession_1', '',$value); ?></td>
                            </tr><tr>
                              <td><?php echo _l('contract_type'); ?></td>
                              <?php $selected=( isset($economic_data) ? $economic_data->contract_type_1 : ''); ?>
                              <td><?php echo render_select('contract_type_1',$contract_types,array('id','contract_types'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                            </tr><tr>
                              <td>
                                <?php $value=( isset($economic_data) ? $economic_data->income_1 : ''); ?>
                                <?php echo _l('income'); ?>
                                <div class="input-group">
                                  <?php echo render_input('income_1', '',$value,'number',['style'=>'text-align: right']); ?>
                                  <div class="input-group-addon"><?php echo $base_currency->symbol; ?></div>
                                </div>
                              </td>
                              <td>
                                <?php $value=( isset($economic_data) ? $economic_data->payments_1 : ''); ?>
                                <?php echo _l('payments'); ?>
                                <?php echo render_input('payments_1', '',$value,'number',['style'=>'text-align: right']); ?>
                              </td>
                            </tr>
                          </table>
                          <table class="ed col-md-12 table table-bordered">
                            <tr><td><?php echo _l('banks_works'); ?></td></tr>
                            <?php $selected=( isset($economic_data) ? $economic_data->banks_works_1_1 : ''); ?>
                            <tr><td><?php echo render_select('banks_works_1_1',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                            <?php $selected=( isset($economic_data) ? $economic_data->banks_works_2_1 : ''); ?>
                            <tr><td><?php echo render_select('banks_works_2_1',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                            <?php $selected=( isset($economic_data) ? $economic_data->banks_works_3_1 : ''); ?>
                            <tr><td><?php echo render_select('banks_works_3_1',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                          </table>
                        <h4><?php echo _l('loans'); ?></h4>
                        <hr />
                          <table class="ed col-md-12 table table-bordered">
                            <thead>
                              <tr>
                                <td class="col-md-6 text-center"><?php echo _l('entity'); ?></td>
                                <td class="text-center"><?php echo _l('pending'); ?></td>
                                <td class="text-center"><?php echo _l('share'); ?></td>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <?php $total_pendientes = 0; $total_cuotas = 0; ?>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_1_1 : ''); ?>
                                <td><?php echo render_select('entity_1_1',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_1_1 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input( 'pending_1_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_1_1 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input( 'share_1_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_2_1 : ''); ?>
                                <td><?php echo render_select('entity_2_1',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_2_1 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input('pending_2_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_2_1 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input('share_2_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_3_1 : ''); ?>
                                <td><?php echo render_select('entity_3_1',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_3_1 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input('pending_3_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_3_1 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input('share_3_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_4_1 : ''); ?>
                                <td><?php echo render_select('entity_4_1',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_4_1 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input('pending_4_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_4_1 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input('share_4_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td>
                                  <div class="input-group">
                                    <?php echo render_input('pending_total_1', '', $total_pendientes,'number',['style'=>'text-align: center; background-color:White;','readonly'=>'true']); ?>
                                    <div class="input-group-addon"><?php echo $base_currency->symbol; ?></div>
                                  </div>
                                </td>
                                <td>
                                  <div class="input-group">
                                    <?php echo render_input('share_total_1', '', $total_cuotas,'number',['style'=>'text-align: center; background-color:White;','readonly'=>'true']); ?>
                                    <div class="input-group-addon"><?php echo $base_currency->symbol; ?></div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                     </div>
                     <div class="col-md-6">
                        <h4><?php echo _l('headline'); ?> 2</h4>
                        <hr />
                          <style type="text/css">
                            .ed tr td{ padding: 0 !important; margin: 0 !important; }
                          </style>
                          <table class="ed col-md-12 table table-bordered">
                            <tr>
                              <td><?php echo _l('high_date_last_job'); ?></td>
                              <?php $value=( isset($economic_data) ? _d(date("Y-m-d",strtotime($economic_data->high_date_last_job_2))) : _d(date())); ?>
                              <td><?php echo render_date_input('high_date_last_job_2', '',$value); ?></td>
                            </tr><tr>
                              <td><?php echo _l('profession'); ?></td>
                              <?php $value=( isset($economic_data) ? $economic_data->profession_2 : ''); ?>
                              <td><?php echo render_input( 'profession_2', '',$value); ?></td>
                            </tr><tr>
                              <td><?php echo _l('contract_type'); ?></td>
                              <?php $selected=( isset($economic_data) ? $economic_data->contract_type_2 : ''); ?>
                              <td><?php echo render_select( 'contract_type_2',$contract_types,array('id','contract_types'), '',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                            </tr><tr>
                              <td>
                                <?php $value=( isset($economic_data) ? $economic_data->income_2 : ''); ?>
                                <?php echo _l('income'); ?>
                                <div class="input-group">
                                  <?php echo render_input('income_2', '',$value,'number',['style'=>'text-align: right']); ?>
                                  <div class="input-group-addon"><?php echo $base_currency->symbol; ?></div>
                                </div>
                              </td>
                              <td>
                                <?php $value=( isset($economic_data) ? $economic_data->payments_2 : ''); ?>
                                <?php echo _l('payments'); ?>
                                <?php echo render_input( 'payments_2', '',$value,'number',['style'=>'text-align: right']); ?>
                              </td>
                            </tr>
                          </table>
                          <table class="ed col-md-12 table table-bordered">
                            <tr><td><?php echo _l('banks_works'); ?></td></tr>
                            <?php $selected=( isset($economic_data) ? $economic_data->banks_works_1_2 : ''); ?>
                            <tr><td><?php echo render_select('banks_works_1_2',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                            <?php $selected=( isset($economic_data) ? $economic_data->banks_works_2_2 : ''); ?>
                            <tr><td><?php echo render_select('banks_works_2_2',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                            <?php $selected=( isset($economic_data) ? $economic_data->banks_works_3_2 : ''); ?>
                            <tr><td><?php echo render_select('banks_works_3_2',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                          </table>
                        <h4><?php echo _l('loans'); ?></h4>
                        <hr />
                          <table class="ed col-md-12 table table-bordered">
                            <thead>
                              <tr>
                                <td class="col-md-6 text-center"><?php echo _l('entity'); ?></td>
                                <td class="text-center"><?php echo _l('pending'); ?></td>
                                <td class="text-center"><?php echo _l('share'); ?></td>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <?php $total_pendientes = 0; $total_cuotas = 0; ?>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_1_2 : ''); ?>
                                <td><?php echo render_select('entity_1_2',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_1_2 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input( 'pending_1_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_1_2 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input( 'share_1_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_2_2 : ''); ?>
                                <td><?php echo render_select('entity_2_2',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_2_2 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input( 'pending_2_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_2_2 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input( 'share_2_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_3_2 : ''); ?>
                                <td><?php echo render_select('entity_3_2',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_3_2 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input( 'pending_3_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_3_2 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input( 'share_3_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <?php $selected=( isset($economic_data) ? $economic_data->entity_4_2 : ''); ?>
                                <td><?php echo render_select('entity_4_2',$banks_loan,array('id','bank_loan'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->pending_4_2 : '0,00'); ?>
                                <?php $total_pendientes = $total_pendientes + $value; ?>
                                <td><?php echo render_input( 'pending_4_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                                <?php $value=( isset($economic_data) ? $economic_data->share_4_2 : '0,00'); ?>
                                <?php $total_cuotas = $total_cuotas + $value; ?>
                                <td><?php echo render_input( 'share_4_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td>
                                  <div class="input-group">
                                    <?php echo render_input('pending_total_2', '', $total_pendientes,'number',['style'=>'text-align: center; background-color:White;','readonly'=>'true']); ?>
                                    <div class="input-group-addon"><?php echo $base_currency->symbol; ?></div>
                                  </div>
                                </td>
                                <td>
                                  <div class="input-group">
                                    <?php echo render_input('share_total_2', '', $total_cuotas,'number',['style'=>'text-align: center; background-color:White;','readonly'=>'true']); ?>
                                    <div class="input-group-addon"><?php echo $base_currency->symbol; ?></div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                    <?php if (has_permission('commercials_visits', '', 'create') || has_permission('commercials_visits', '', 'edit')) { ?>
                      <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-info"><?php echo _l('economic_data_save'); ?></button>
                      </div>
                    <?php } ?>
                  </div>
               </div>
            </div>
          <?php echo form_close(); ?>
        </div>
        
        <!-- Bancos operación -->
        <div role="tabpanel" class="tab-pane" id="operation_banks">
          <?php $id_operationbanks=(isset($operation_banks) ? $operation_banks->id : ''); ?>
          <?php $url = admin_url('commercials_visits/take_form/' . $client . '/' . $id_operationbanks); ?>
          <?php echo form_open($url,array('class'=>'operation-banks-hl1-form','autocomplete'=>'off','id'=>'operation-banks-form')); ?>
            <div class="row">
              <div class="col-md-12">
                  <div class="row">
                    <br>
                    <div class="col-md-12">
                      <div class="col-md-12"><h2 class="no-mtop"><?php echo _l('present_operation_banks'); ?></h2></div>
                    </div>
                    <div class="ed col-md-6">
                      <div class="additional">
                        <?php echo form_hidden('id', $id); ?>
                        <?php echo form_hidden('client', $client); ?>
                        <?php echo form_hidden('form', 'operation-banks-form'); ?>
                      </div>
                      <div class="col-md-12"><h3><?php echo _l('headline'); ?> 1</h3><hr /></div>
                      <div class="col-md-8">
                        <table class="ed col-md-6 table table-bordered np">
                          <?php $selected=( isset($operation_banks) ? $operation_banks->banks_works_1_1 : ''); ?>
                          <tr><td><?php echo render_select('banks_works_1_1',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                          <?php $selected=( isset($operation_banks) ? $operation_banks->banks_works_2_1 : ''); ?>
                          <tr><td><?php echo render_select('banks_works_2_1',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                          <?php $selected=( isset($operation_banks) ? $operation_banks->banks_works_3_1 : ''); ?>
                          <tr><td><?php echo render_select('banks_works_3_1',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                        </table>
                      </div>
                      <!--Incidenias-->
                      <div class="col-md-10">
                        <h4 class="no-mtop"><?php echo _l('incidents'); ?></h4>
                        <table class="ed col-md-12 table table-bordered np">
                          <thead>
                            <tr>
                              <td class="text-center"><?php echo _l('creditor'); ?></td>
                              <td class="text-center"><?php echo _l('amount'); ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->creditor_1_1 : ''); ?>
                              <td><?php echo render_input( 'creditor_1_1', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->amount_1_1 : ''); ?>
                              <td><?php echo render_input('amount_1_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->creditor_2_1 : ''); ?>
                              <td><?php echo render_input('creditor_2_1', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->amount_2_1 : ''); ?>
                              <td><?php echo render_input('amount_2_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--Alquiler-->
                      <div class="col-md-3"><h4 class="no-mtop"><?php echo _l('rental'); ?></h4></div>
                      <div class="col-md-7">
                        <table class="ed col-md-12 table table-bordered np">
                          <thead>
                            <tr>
                              <td class="text-center"><?php echo _l('rental_amount'); ?></td>
                              <td class="text-center"><?php echo _l('rental_payment_method'); ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->rental_amount_1 : ''); ?>
                              <td><?php echo render_input('rental_amount_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              <?php $selected=( isset($operation_banks) ? $operation_banks->rental_payment_method_1 : ''); ?>
                              <td><?php echo render_select('rental_payment_method_1',$payment_methods,array('id','payment_method'),'',$selected); ?></td>
                            </tr>
                            <tr>
                              <td><?php echo _l('rental_date'); ?></td>
                              <?php $value=( isset($operation_banks) ? _d(date("Y-m-d",strtotime($operation_banks->rental_date_1))) : _d(date())); ?>
                              <td><?php echo render_date_input('rental_date_1', '',$value); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--Propiedades-->
                      <div class="col-md-9">
                        <h4 class="no-mtop"><?php echo _l('physical_properties'); ?></h4>
                        <table class="ed col-md-12 table table-bordered np">
                          <thead>
                            <tr>
                              <td class="text-center col-md-9"><?php echo _l('address'); ?></td>
                              <td class="text-center"><?php echo _l('charges'); ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->address_1_1 : ''); ?>
                              <td><?php echo render_input('address_1_1', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->charges_1_1 : ''); ?>
                              <td><?php echo render_input('charges_1_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->address_2_1 : ''); ?>
                              <td><?php echo render_input('address_2_1', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->charges_2_1 : ''); ?>
                              <td><?php echo render_input('charges_2_1', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="col-md-12"><h3><?php echo _l('headline'); ?> 2</h3><hr /></div>
                      <div class="col-md-8">
                        <table class="ed col-md-6 table table-bordered np">
                          <?php $selected=( isset($operation_banks) ? $operation_banks->banks_works_1_2 : ''); ?>
                          <tr><td><?php echo render_select('banks_works_1_2',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                          <?php $selected=( isset($operation_banks) ? $operation_banks->banks_works_2_2 : ''); ?>
                          <tr><td><?php echo render_select('banks_works_2_2',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                          <?php $selected=( isset($operation_banks) ? $operation_banks->banks_works_3_2 : ''); ?>
                          <tr><td><?php echo render_select('banks_works_3_2',$banks,array('id','bank'),'',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex'))); ?></td></tr>
                        </table>
                      </div>
                      <div class="col-md-10">
                        <h4 class="no-mtop"><?php echo _l('incidents'); ?></h4>
                        <table class="ed col-md-12 table table-bordered np">
                          <thead>
                            <tr>
                              <td class="text-center"><?php echo _l('creditor'); ?></td>
                              <td class="text-center"><?php echo _l('amount'); ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->creditor_1_2 : ''); ?>
                              <td><?php echo render_input( 'creditor_1_2', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->amount_1_2 : ''); ?>
                              <td><?php echo render_input('amount_1_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->creditor_2_2 : ''); ?>
                              <td><?php echo render_input('creditor_2_2', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->amount_2_2 : ''); ?>
                              <td><?php echo render_input('amount_2_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!--Alquiler-->
                      <div class="col-md-3"><h4 class="no-mtop"><?php echo _l('rental'); ?></h4></div>
                      <div class="col-md-7">
                        <table class="ed col-md-12 table table-bordered np">
                          <thead>
                            <tr>
                              <td class="text-center"><?php echo _l('rental_amount'); ?></td>
                              <td class="text-center"><?php echo _l('rental_payment_method'); ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->rental_amount_2 : ''); ?>
                              <td><?php echo render_input('rental_amount_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                              <?php $selected=( isset($operation_banks) ? $operation_banks->rental_payment_method_2 : ''); ?>
                              <td><?php echo render_select('rental_payment_method_2',$payment_methods,array('id','payment_method'),'',$selected); ?></td>
                            </tr>
                            <tr>
                              <td><?php echo _l('rental_date'); ?></td>
                              <?php $value=( isset($operation_banks) ? _d(date("Y-m-d",strtotime($operation_banks->rental_date_2))) : _d(date())); ?>
                              <td><?php echo render_date_input('rental_date_2', '',$value); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-10">
                        <h4 class="no-mtop"><?php echo _l('physical_properties'); ?></h4>
                        <table class="ed col-md-12 table table-bordered np">
                          <thead>
                            <tr>
                              <td class="text-center col-md-9"><?php echo _l('address'); ?></td>
                              <td class="text-center"><?php echo _l('charges'); ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->address_1_2 : ''); ?>
                              <td><?php echo render_input('address_1_2', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->charges_1_2 : ''); ?>
                              <td><?php echo render_input('charges_1_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                            <tr>
                              <?php $value=( isset($operation_banks) ? $operation_banks->address_2_2 : ''); ?>
                              <td><?php echo render_input('address_2_2', '',$value); ?></td>
                              <?php $value=( isset($operation_banks) ? $operation_banks->charges_2_2 : ''); ?>
                              <td><?php echo render_input('charges_2_2', '',$value,'number',['style'=>'text-align: right']); ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-12">
                        <?php $value=( isset($operation_banks) ? $operation_banks->observations : ''); ?>
                        <?php echo render_textarea('observations', 'observations',$value); ?>
                      </div>
                    </div>
                    <?php if (has_permission('commercials_visits', '', 'create') || has_permission('commercials_visits', '', 'edit')) { ?>
                      <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-info"><?php echo _l('operation_banks_save'); ?></button>
                      </div>
                    <?php } ?>
                  </div>
              </div>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
</div>
