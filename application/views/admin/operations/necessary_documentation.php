<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-12 border-right project-overview-left">
    <div class="row">
      <?php if ($operation->type_id == 1) $this->load->view('admin/operations/physical_person_documentation'); ?>
      <?php if ($operation->type_id == 2) $this->load->view('admin/operations/legal_person_documentation'); ?>
    </div>
  </div>
</div>

<!-- Modal add and edit members -->
<div class="modal fade" id="add-edit-members" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <?php echo form_open(admin_url('projects/add_edit_members/'.$operation->id)); ?>
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo _l('project_members'); ?></h4>
         </div>
         <div class="modal-body">
            <?php
            $selected = array();
            foreach($members as $member){
              array_push($selected,$member['staff_id']);
           }
           echo render_select('project_members[]',$staff,array('staffid',array('firstname','lastname')),'project_members',$selected,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
           ?>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
         <button type="submit" class="btn btn-info" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<!-- /.modal -->

<?php if(isset($project_overview_chart)){ ?>
<script>
   var project_overview_chart = <?php echo json_encode($project_overview_chart); ?>;
</script>
<?php } ?>
