<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-12 border-right project-overview-left">
    <div class="row">
      <div class="col-md-12">
         <p class="project-info bold font-size-14"><?php echo _l('operation_tracing'); ?></p>
         <hr class="hr-panel-heading" />
      </div>
      <div class="col-md-5">
        <?php $action = admin_url('operations/tracing'); ?>
        <?php echo form_open($action,array('id'=>'operation-tracing-form','enctype'=>'multipart/form-data')); ?>
          <div class="col-md-6">
            <?php $value = _d(date("Y-m-d")); ?>
            <?php echo render_input('date_add','commercial_visit_date',$value,'text',['readonly'=>'true']); ?>
          </div>
          <div class="col-md-12">
            <?php echo render_select('contact_type',$contact_types,array('id','type_name'),'commercials_visits_type'); ?>
          </div>
          <div class="col-md-12">
            <?php $value = ""; ?>
            <?php echo render_textarea('information','commercial_visit_information',$value,array('rows'=>10)); ?>
          </div>
          <div class="col-md-12">
            <?php echo form_hidden('visit', $operation->id); ?>
            <button type="submit" class="btn btn-info mtop10 pull-right"><?php echo _l('commercial_visit_add_management'); ?></button>
          </div>
        <?php echo form_close(); ?>
      </div>
      <div class="col-md-7">
        <?php foreach($tracings as $tracing) { ?>
          <div class="panel_s project-menu-panel">
            <div class="panel-body ">
              <div class="col-md-6"><p class="project-info bold font-size-14"><?php echo _d(date("Y-m-d", strtotime($tracing['date_add']))); ?></p></div>
              <div class="col-md-6"><p class="project-info bold font-size-14"><?php echo $tracing['type_name']; ?></p></div>
              <div class="col-md-12"><p class="font-size-12"><?php echo trim($tracing['information']); ?></p></div>
              <div class="col-md-12">
              <div class="media">
                <div class="media-left">
                  <a href="<?php echo admin_url('profile/' . $tracing['staffid']); ?>">
                    <?php echo staff_profile_image($tracing['staffid'],array('staff-profile-image-small','media-object')); ?>
                  </a>
                </div>
                <div class="media-body">
                  <h5 class="media-heading mtop5">
                    <a href="<?php echo admin_url('profile/' . $tracing['staffid']); ?>"><?php echo get_staff_full_name($tracing['staffid']); ?></a>
                    <?php if(has_permission('operations','','create') || $tracing['staffid'] == get_staff_user_id() || is_admin()){ ?>
                      <br /><small class="text-muted"><?php echo _l('total_logged_hours_by_staff') . ': ' . seconds_to_time_format($member['total_logged_time']); ?></small>
                    <?php } ?>
                  </h5>
                </div>
              </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>    
  </div>
</div>
