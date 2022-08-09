<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <?php echo form_hidden('id',$operation->id) ?>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s project-top-panel panel-full">
          <div class="panel-body _buttons">
            <div class="row">
              <div class="col-md-7 project-heading">
                <h3 class="hide project-name"><?php echo $operation->subject; ?></h3>
                <div id="project_view_name" class="pull-left">
                  <select class="selectpicker" id="project_top" data-width="fit"<?php if(count($other_operations) > 6) { ?> data-live-search="true" <?php } ?>>
                    <option value="<?php echo $operation->id; ?>" selected><?php echo $operation->subject; ?></option>
                    <?php foreach($other_operations as $op) { ?>
                      <option value="<?php echo $op['id']; ?>" data-subtext="<?php echo $op['name']; ?>">#<?php echo $op['id']; ?> - <?php echo $op['subject']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="visible-xs">
                  <div class="clearfix"></div>
                </div>
                <?php echo '<div class="label pull-left mleft15 mtop8 p8 project-status-label-' . $operation->status . '" style="background:' . $operations_status['color'] . '">' . $operations_status['name'] . '</div>'; ?>
              </div>
              <div class="col-md-5 text-right">
                <button id="btn_manage_status" type="button" class="btn btn-success" data-toggle="modal" data_target="#mod_operation_manage_status">
                  <?php echo _l('operation_manage_status'); ?>
                </button>
                <?php if(has_permission('contracts','','create')) { ?>
                  <a href="<?php echo admin_url('contracts/contract'); ?>" class="btn btn-info pull-right display-block"><?php echo _l('operation_contract'); ?></a>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="panel_s project-menu-panel">
          <div class="panel-body">
            <?php hooks()->do_action('before_render_project_view', $operation->id); ?>
            <?php $this->load->view('admin/operations/operation_tabs'); ?>
          </div>
        </div>
        <?php
          if((has_permission('operations','','create') || has_permission('operations','','edit'))
            && $operation->status == 1
            && $this->projects_model->timers_started_for_project($operation->id)
            && $tab['slug'] != 'project_milestones') {
          ?>
            <div class="alert alert-warning project-no-started-timers-found mbot15">
              <?php echo _l('project_not_started_status_tasks_timers_found'); ?>
            </div>
            <?php } ?>
            <?php
              if($operation->deadline && date('Y-m-d') > $operation->deadline
                && $operation->status == 2
                && $tab['slug'] != 'project_milestones') {
              ?>
            <div class="alert alert-warning bold project-due-notice mbot15">
              <?php echo _l('project_due_notice', floor((abs(time() - strtotime($operation->deadline)))/(60*60*24))); ?>
            </div>
            <?php } ?>
            <?php
              if(!has_contact_permission('operations',get_primary_contact_user_id($operation->clientid))
                && total_rows(db_prefix().'contacts',array('userid'=>$operation->clientid)) > 0
                && $tab['slug'] != 'project_milestones') {
              ?>
            <div class="alert alert-warning project-permissions-warning mbot15">
              <?php echo _l('project_customer_permission_warning'); ?>
            </div>
            <?php } ?>
          <div class="panel_s">
            <div class="panel-body">
              <?php $this->load->view(($tab ? $tab['view'] : 'admin/operations/operation_overview')); ?>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<?php require('operation_manage_mod.php'); ?>
<?php 
  if(isset($discussion)) {
    echo form_hidden('discussion_id',$discussion->id);
    echo form_hidden('discussion_user_profile_image_url',$discussion_user_profile_image_url);
    echo form_hidden('current_user_is_admin',$current_user_is_admin);
  }
  echo form_hidden('project_percent',$percent);
?>

<div id="invoice_project"></div>
<div id="pre_invoice_project"></div>

<?php $this->load->view('admin/projects/milestone'); ?>
<?php $this->load->view('admin/projects/copy_settings'); ?>
<?php $this->load->view('admin/projects/_mark_tasks_finished'); ?>
<?php init_tail(); ?>

<!-- For invoices table -->
<script>
   taskid = '<?php echo $this->input->get('taskid'); ?>';
</script>
<script>
   var gantt_data = {};
   <?php if(isset($gantt_data)) { ?>
   gantt_data = <?php echo json_encode($gantt_data); ?>;
   <?php } ?>
   var discussion_id = $('input[name="discussion_id"]').val();
   var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
   var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
   var project_id = $('input[name="project_id"]').val();
   if(typeof(discussion_id) != 'undefined'){
     discussion_comments('#discussion-comments',discussion_id,'regular');
   }
   $(function(){
    var project_progress_color = '<?php echo hooks()->apply_filters('admin_project_progress_color','#84c529'); ?>';
    var circle = $('.project-progress').circleProgress({fill: {
     gradient: [project_progress_color, project_progress_color]
   }}).on('circle-animation-progress', function(event, progress, stepValue) {
     $(this).find('strong.project-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
   });
   });

   function discussion_comments(selector,discussion_id,discussion_type){
     var defaults = _get_jquery_comments_default_config(<?php echo json_encode(get_project_discussions_language_array()); ?>);
     var options = {
      currentUserIsAdmin:current_user_is_admin,
      getComments: function(success, error) {
        $.get(admin_url + 'projects/get_discussion_comments/'+discussion_id+'/'+discussion_type,function(response){
          success(response);
        },'json');
      },
      postComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: admin_url + 'projects/add_discussion_comment/'+discussion_id+'/'+discussion_type,
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      putComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: admin_url + 'projects/update_discussion_comment',
          data: commentJSON,
          success: function(comment) {
            comment = JSON.parse(comment);
            success(comment)
          },
          error: error
        });
      },
      deleteComment: function(commentJSON, success, error) {
        $.ajax({
          type: 'post',
          url: admin_url + 'projects/delete_discussion_comment/'+commentJSON.id,
          success: success,
          error: error
        });
      },
      uploadAttachments: function(commentArray, success, error) {
        var responses = 0;
        var successfulUploads = [];
        var serverResponded = function() {
          responses++;
            // Check if all requests have finished
            if(responses == commentArray.length) {
                // Case: all failed
                if(successfulUploads.length == 0) {
                  error();
                // Case: some succeeded
              } else {
                successfulUploads = JSON.parse(successfulUploads);
                success(successfulUploads)
              }
            }
          }
          $(commentArray).each(function(index, commentJSON) {
            // Create form data
            var formData = new FormData();
            if(commentJSON.file.size && commentJSON.file.size > app.max_php_ini_upload_size_bytes){
             alert_float('danger',"<?php echo _l("file_exceeds_max_filesize"); ?>");
             serverResponded();
           } else {
            $(Object.keys(commentJSON)).each(function(index, key) {
              var value = commentJSON[key];
              if(value) formData.append(key, value);
            });

            if (typeof(csrfData) !== 'undefined') {
               formData.append(csrfData['token_name'], csrfData['hash']);
            }
            $.ajax({
              url: admin_url + 'projects/add_discussion_comment/'+discussion_id+'/'+discussion_type,
              type: 'POST',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(commentJSON) {
                successfulUploads.push(commentJSON);
                serverResponded();
              },
              error: function(data) {
               var error = JSON.parse(data.responseText);
               alert_float('danger',error.message);
               serverResponded();
             },
           });
          }
        });
        }
      }
      var settings = $.extend({}, defaults, options);
    $(selector).comments(settings);
   }
</script>



</body>
</html>
