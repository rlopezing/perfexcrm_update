<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="_filters _hidden_inputs hidden">
               <?php
                  echo form_hidden('my_customers');
                  echo form_hidden('requires_registration_confirmation');
                  foreach($groups as $group){
                     echo form_hidden('customer_group_'.$group['id']);
                  }
                  foreach($contract_types as $type){
                     echo form_hidden('contract_type_'.$type['id']);
                  }
                  foreach($invoice_statuses as $status){
                     echo form_hidden('invoices_'.$status);
                  }
                  foreach($estimate_statuses as $status){
                     echo form_hidden('estimates_'.$status);
                  }
                  foreach($project_statuses as $status){
                  echo form_hidden('projects_'.$status['id']);
                  }
                  foreach($proposal_statuses as $status){
                  echo form_hidden('proposals_'.$status);
                  }
                  foreach($customer_admins as $cadmin){
                  echo form_hidden('responsible_admin_'.$cadmin['staff_id']);
                  }
                  foreach($countries as $country){
                  echo form_hidden('country_'.$country['country_id']);
                  }
                  ?>
            </div>
            <div class="panel_s">
              <div class="panel-body">
                  <div class="_buttons">
                    <?php if (has_permission('customers','','create')) { ?>
                      <a href="<?php echo admin_url('clients/client'); ?>" class="btn btn-info mright5 test pull-left display-block"><?php echo _l('new_client'); ?></a>
                    <?php } ?>
                    <a href="<?php echo admin_url('clients/all_contacts'); ?>" class="btn btn-info pull-left display-block mright5"><?php echo _l('customer_contacts'); ?></a>
                    <div class="visible-xs"><div class="clearfix"></div></div>
                  </div>
                  <div class="clearfix"></div>
                  <hr class="hr-panel-heading" />
                  <div class="clearfix mtop20"></div>
                  <?php
                    $table_data = array();
                    $_table_data = array(
                      array(
                       'name'=>_l('the_number_sign'),
                       'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-number')
                      ),
                      array(
                       'name'=>_l('clients_list_company'),
                       'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-company')
                      ),
                      array(
                       'name'=>_l('contact_primary'),
                       'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-primary-contact')
                      ),
                      array(
                       'name'=>_l('company_primary_email'),
                       'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-primary-contact-email')
                      ),
                      array(
                       'name'=>_l('clients_list_phone'),
                       'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-phone')
                      ),
                      array(
                       'name'=>_l('customer_groups'),
                       'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-groups')
                      ),
                      array(
                       'name'=>_l('commercial_visit_opctions'),
                       'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-date-created')
                      ),
                    );
                    
                    foreach($_table_data as $_t) {
                      array_push($table_data, $_t);
                    }

                    $custom_fields = get_custom_fields('customers',array('show_on_table'=>1));
                    foreach($custom_fields as $field){
                      array_push($table_data,$field['name']);
                    }

                    $table_data = hooks()->apply_filters('customers_table_columns', $table_data);

                    render_datatable($table_data,'clients',[],[
                      'data-last-order-identifier' => 'customers',
                      'data-default-order'         => get_table_last_order('customers'),
                    ]);
                  ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
       var CustomersServerParams = {};
       $.each($('._hidden_inputs._filters input'),function(){
          CustomersServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
      });
       CustomersServerParams['exclude_inactive'] = '[name="exclude_inactive"]:checked';

       var tAPI = initDataTable('.table-clients', admin_url+'commercials_visits/table_clients', [0], [0], CustomersServerParams,<?php echo hooks()->apply_filters('customers_table_default_order', json_encode(array(2,'asc'))); ?>);
       $('input[name="exclude_inactive"]').on('change',function(){
           tAPI.ajax.reload();
       });
   });
   function customers_bulk_action(event) {
       var r = confirm(app.lang.confirm_action_prompt);
       if (r == false) {
           return false;
       } else {
           var mass_delete = $('#mass_delete').prop('checked');
           var ids = [];
           var data = {};
           if(mass_delete == false || typeof(mass_delete) == 'undefined'){
               data.groups = $('select[name="move_to_groups_customers_bulk[]"]').selectpicker('val');
               if (data.groups.length == 0) {
                   data.groups = 'remove_all';
               }
           } else {
               data.mass_delete = true;
           }
           var rows = $('.table-clients').find('tbody tr');
           $.each(rows, function() {
               var checkbox = $($(this).find('td').eq(0)).find('input');
               if (checkbox.prop('checked') == true) {
                   ids.push(checkbox.val());
               }
           });
           data.ids = ids;
           $(event).addClass('disabled');
           setTimeout(function(){
             $.post(admin_url + 'clients/bulk_action', data).done(function() {
              window.location.reload();
          });
         },50);
       }
   }
</script>
</body>
</html>
