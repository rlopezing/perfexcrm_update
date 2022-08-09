<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-6 border-right project-overview-left">
    <div class="row">
      
      <div class="col-md-12">
         <p class="project-info bold font-size-14">
            <?php echo _l('overview'); ?>
         </p>
      </div>
      
      <div class="col-md-12">
        <table class="table no-margin project-overview-table">
          <tbody>
            <tr class="project-overview-customer">
              <td class="bold"><?php echo _l('project_customer'); ?></td>
              <td colspan="2"><a href="<?php echo admin_url(); ?>clients/client/<?php echo $operation->client; ?>"><?php echo $operation->name; ?></a></td>
            </tr>
            <tr class="project-overview-billing">
              <td class="bold"><?php echo _l('operation_client_type'); ?></td>
              <td colspan="2"><?php echo $operation->type; ?></td>
            <tr>
            <tr class="project-overview-status">
              <td class="bold"><?php echo _l('project_status'); ?></td>
              <td colspan="2"><?php echo $operations_status['name']; ?></td>
            </tr>
            <tr class="project-overview-date-created">
              <td class="bold"><?php echo _l('project_datecreated'); ?></td>
              <td colspan="2"><?php echo _d(date('d-m-Y', strtotime($operation->date_add))); ?></td>
            </tr>
            <tr class="project-overview-start-date">
              <td class="bold"><?php echo _l('operation_take_date'); ?></td>
              <td colspan="2"><?php echo _d(date('d-m-Y', strtotime($operation->take_date))); ?></td>
            </tr>
            <tr class="project-overview-date-finished">
              <td class="bold"><?php echo _l('operation_input_date'); ?></td>
              <?php if( !is_null($project->date_input) ){ ?>
                <td class="text-success"><?php echo _d(date('d-m-Y', strtotime($project->date_input))); ?></td>
              <?php } else { ?>
                <td><?php echo _d(date('d-m-Y')); ?></td>
              <?php } ?>
              <td><?php echo $operation->day_date_input; ?> Días</td>
            </tr>
            <tr class="project-overview-date-finished">
              <td class="bold"><?php echo _l('operation_inbank_date'); ?></td>
              <?php if( !is_null($project->date_inbank) ){ ?>
                <td class="text-success"><?php echo _d(date('d-m-Y', strtotime($project->date_inbank))); ?></td>
                <td><?php echo $operation->day_date_inbank; ?> Días</td>
              <?php } else { ?>
                <?php if( !is_null($project->date_input) ){ ?> 
                  <td><?php echo _d(date('d-m-Y')); ?></td>
                  <td><?php echo $operation->day_date_inbank; ?> Días</td>
                <?php } else { ?>
                  <td>..</td><td>..</td>                  
                <?php } ?>
              <?php } ?>
            </tr>
            <tr class="project-overview-date-finished">
              <td class="bold"><?php echo _l('operation_study_date'); ?></td>
              <?php if( !is_null($project->date_study) ){ ?>
                <td class="text-success"><?php echo _d(date('d-m-Y', strtotime($project->date_study))); ?></td>
                <td><?php echo $operation->day_date_study; ?> Días</td>
              <?php } else { ?>
                <?php if( !is_null($project->date_inbank) ){ ?> 
                  <td><?php echo _d(date('d-m-Y')); ?></td>
                  <td><?php echo $operation->day_date_study; ?> Días</td>
                <?php } else { ?>
                  <td>..</td><td>..</td>
                <?php } ?>
              <?php } ?>
            </tr>
            <tr class="project-overview-date-finished">
              <td class="bold"><?php echo _l('operation_approved_date'); ?></td>
              <?php if( !is_null($project->date_approved) ){ ?>
                <td class="text-success"><?php echo _d(date('d-m-Y', strtotime($project->date_approved))); ?></td>
                <td><?php echo $operation->day_date_approved; ?> Días</td>
              <?php } else { ?>
                <?php if( !is_null($project->date_study) ){ ?> 
                  <td><?php echo _d(date('d-m-Y')); ?></td>
                  <td><?php echo $operation->day_date_approved; ?> Días</td>
                <?php } else { ?>
                  <td>..</td><td>..</td>                  
                <?php } ?>
              <?php } ?>
            </tr>
            <tr class="project-overview-date-finished">
              <td class="bold"><?php echo _l('operation_completed_date'); ?></td>
              <?php if( !is_null($project->date_finished) ){ ?>
                <td class="text-success"><?php echo _d(date('d-m-Y', strtotime($project->date_finished))); ?></td>
                <td><?php echo $operation->day_date_finished; ?> Días</td>
              <?php } else { ?>
                <?php if( !is_null($project->date_approved) ){ ?> 
                  <td><?php echo _d(date('d-m-Y')); ?></td>
                  <td><?php echo $operation->day_date_finished; ?> Días</td>
                <?php } else { ?>
                  <td>..</td><td>..</td>                  
                <?php } ?>
              <?php } ?>
            </tr>
            <?php if($operation->days_passed){ ?>
            <tr class="project-overview-estimated-hours">
              <td class="bold"><?php echo _l('operation_days_passed'); ?></td>
              <td><?php echo _d(date('d-m-Y')); ?></td>
              <td><?php echo $operation->days_passed; ?> Días</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-12">
        <div class="team-members project-overview-team-members">
          <hr class="hr-panel-heading project-area-separation" />
          <?php if(has_permission('operations','','edit') || has_permission('operations','','create') || is_admin()){ ?>
          <div class="inline-block pull-right mright10 project-member-settings" data-toggle="tooltip" data-title="<?php echo _l('add_edit_members'); ?>">
            <a href="#" data-toggle="modal" class="pull-right" data-target="#add-edit-members"><i class="fa fa-cog"></i></a>
          </div>
          <?php } ?>
          <p class="bold font-size-14 project-info">
            <?php echo _l('operation_members'); ?>
          </p>
          <div class="clearfix"></div>
          <?php
          if(count($members) == 0){
            echo '<p class="text-muted mtop10 no-mbot">'._l('no_project_members').'</p>';
          }
          foreach($members as $member){ ?>
            <div class="media">
              <div class="media-left">
                 <a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>">
                    <?php echo staff_profile_image($member['staff_id'],array('staff-profile-image-small','media-object')); ?>
                 </a>
              </div>
              <div class="media-body">
                 <?php if(has_permission('operations','','edit') || has_permission('operations','','create') ||is_admin()){ ?>
                 <a href="<?php echo admin_url('projects/remove_team_member/'.$operation->id.'/'.$member['staff_id']); ?>" class="pull-right text-danger _delete"><i class="fa fa fa-times"></i></a>
                 <?php } ?>
                 <h5 class="media-heading mtop5"><a href="<?php echo admin_url('profile/'.$member["staff_id"]); ?>"><?php echo get_staff_full_name($member['staff_id']); ?></a>
                    <?php if(has_permission('operations','','create') || $member['staff_id'] == get_staff_user_id() || is_admin()){ ?>
                    <br /><small class="text-muted"><?php echo _l('total_logged_hours_by_staff') .': '.seconds_to_time_format($member['total_logged_time']); ?></small>
                    <?php } ?>
                 </h5>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-6 project-overview-right">
    <div class="col-md-12 text-center project-percent-col mtop10">
      <p class="bold"><?php echo _l('operation_progress'); ?></p>
      <div class="project-progress relative mtop15" data-value="<?php echo $percent_circle; ?>" data-size="150" data-thickness="22" data-reverse="true">
        <strong class="project-percent"></strong>
      </div>
    </div>
    <div class="tc-content project-overview-description">
      <hr class="hr-panel-heading project-area-separation" />
      <p class="bold font-size-14 project-info"><?php echo _l('operation_changes'); ?></p>
    </div>
    <div class="col-md-12">
      <?php foreach($details as $detail) { ?>
        <div class="panel_s project-menu-panel">
          <div class="panel-body ">
            <div class="col-md-6"><p class="project-info bold font-size-14"><?php echo _d(date("Y-m-d", strtotime($detail['date_add']))); ?></p></div>
            <div class="col-md-6"><p class="project-info bold font-size-14"><?php echo trim($detail['name']); ?></p></div>
            <div class="col-md-12"><p class="font-size-12"><?php echo trim($detail['note']); ?></p></div>
            <div class="col-md-12">
              <div class="media">
                <div class="media-left">
                  <a href="<?php echo admin_url('profile/' . $detail['addedfrom']); ?>">
                    <?php echo staff_profile_image($detail['addedfrom'],array('staff-profile-image-small','media-object')); ?>
                  </a>
                </div>
                <div class="media-body">
                  <h5 class="media-heading mtop5">
                    <a href="<?php echo admin_url('profile/' . $detail['addedfrom']); ?>"><?php echo get_staff_full_name($detail['addedfrom']); ?></a>
                    <?php if(has_permission('operations','','create') || $detail['addedfrom'] == get_staff_user_id() || is_admin()){ ?>
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
