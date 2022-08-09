<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-5 left-column">
            <div class="panel_s">
              <div class="panel-body">
                <?php echo form_open($this->uri->uri_string(),array('id'=>'commercial-visit-form')); ?>
                  <div class="col-md-12 pull-right" style="padding: 0px;">
                    <a class="text-uppercase pull-left"><h4><?php echo _l('commercial_visit_create'); ?></h4></a>
                  </div>
                  <?php if (!isset($cvisit)) { $accion = "New"; ?>
                    <div class="row">
                      <div class="col-md-6 disabled">
                        <?php echo render_input('longitude','customer_longitude','','text',['readonly'=>'true']); ?>
                      </div>
                      <div class="col-md-6">
                        <?php echo render_input('latitude','customer_latitude','','text',['readonly'=>'true']); ?>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="form-group select-placeholder">
                    <label for="clientid" class="control-label"><span class="text-danger">* </span><?php echo _l('contract_client_string'); ?></label>
                    <?php $disabled = (isset($cvisit) ? 'disabled' : ''); ?>
                    <select id="clientid" name="client" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" <?php echo $disabled; ?>>
                    <?php
                      $selected = (isset($cvisit) ? $cvisit->client : '');
                      if($selected == '') $selected = (isset($customer_id) ? $customer_id: '');
                      if($selected != '') {
                        $rel_data = get_relation_data('customer',$selected);
                        $rel_val = get_relation_values($rel_data,'customer');
                        echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                      } 
                    ?>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col-md-6 disabled">
                      <?php $value = (isset($cvisit) ? _d(date("Y-m-d", strtotime($cvisit->date_add))) : _d(date('Y-m-d'))); ?>
                      <?php echo render_input('date_add','commercial_visit_date',$value,'text',['readonly'=>'true']); ?>
                    </div>
                    <div class="col-md-6">
                      <?php $value = (isset($cvisit) ? date("H:i:s",strtotime($cvisit->hour_add)) : date("h").":".date("i").":".date("s")); ?>
                      <?php echo render_input('hour_add','commercial_visit_hour',$value,'text',['readonly'=>'true']); ?>
                    </div>
                  </div>
                  <?php $value = (isset($cvisit) ? $cvisit->subject : ''); ?>
                  <?php echo render_input('subject','contract_subject',$value); ?>
                  <?php $selected = (isset($cvisit) ? $cvisit->type : '');  ?>
                  <?php echo render_select('type',$types,array('id','type'),'commercial_visit_type_client',$selected); ?>
                  <?php $value = (isset($cvisit) ? $cvisit->name : ''); ?>
                  <?php echo render_input('name','commercial_visit_name',$value); ?>
                  <?php $value = (isset($cvisit) ? $cvisit->dni_die : ''); ?>
                  <?php echo render_input('dni_die','commercial_visit_dni_nie',$value); ?>
                  <?php $value = (isset($cvisit) ? $cvisit->telephone : ''); ?>
                  <?php echo render_input('telephone','commercial_visit_telephone',$value); ?>
                  <?php $value = (isset($cvisit) ? $cvisit->email : ''); ?>
                  <?php echo render_input('email','commercial_visit_email',$value); ?>
                  <?php $value = (isset($cvisit) ? $cvisit->notes : ''); ?>
                  <?php echo render_textarea('notes','commercial_visit_notes',$value,array('rows'=>10)); ?>
                  <div class="btn-bottom-toolbar text-right">
                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                  </div>
                  <?php echo form_close(); ?>
               </div>
            </div>
        </div>
        <?php if(isset($cvisit)) { ?>
        <div class="col-md-7 right-column">
          <div class="panel_s">
              <div class="panel-body">
                <div class="col-md-12 text-left"><h4 class="no-margin"><?php echo $cvisit->subject; ?></h4></div>
                <div class="col-md-12">
                  <hr class="hr-panel-heading" />
                  <?php if($cvisit->trash > 0) {
                     echo '<div class="ribbon default"><span>'._l('contract_trash').'</span></div>';
                  } ?>
                  <div class="horizontal-scrollable-tabs preview-tabs-top">
                     <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                     <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                     <div class="horizontal-tabs">
                        <ul class="nav nav-tabs tabs-in-body-no-margin contract-tab nav-tabs-horizontal mbot15" role="tablist">
                           <li role="presentation" class="<?php if(!$this->input->get('tab') || $this->input->get('tab')=='tab_comments' || $this->input->get('tab')==''){echo 'active';} ?>">
                              <a href="#tab_comments" aria-controls="tab_comments" role="tab" data-toggle="tab" onclick="get_visit_comments(); return false;">
                              <?php echo _l('contract_comments'); ?>
                              <?php
                              $totalComments = total_rows(db_prefix().'contract_comments','contract_id='.$cvisit->id)
                              ?>
                              <span class="badge comments-indicator<?php echo $totalComments == 0 ? ' hide' : ''; ?>"><?php echo $totalComments; ?></span>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="tab-content">
                    <!-- Tab panel comments -->
                     <div role="tabpanel" class="tab-pane <?php if(!$this->input->get('tab') || $this->input->get('tab')=='tab_comments' || $this->input->get('tab')==''){echo 'active';} ?>" id="tab_comments">
                        <div class="row contract-comments mtop15">
                           <div class="col-md-12">
                              <div id="contract-comments"></div>
                              <div class="clearfix"></div>
                              <textarea name="content" id="comment" rows="4" class="form-control mtop15 contract-comment"></textarea>
                              <button type="button" class="btn btn-info mtop10 pull-right" onclick="add_visit_comment();"><?php echo _l('proposal_add_comment'); ?></button>
                           </div>
                        </div>
                     </div>
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
<?php if(isset($cvisit)) { ?>
  <script> var visit_id = '<?php echo $cvisit->id; ?>'; </script>
<?php } ?>
<script>
  
  var accion = "<?php echo $accion; ?>";
  if (accion == "New") {
    if ("geolocation" in navigator) { 
      navigator.geolocation.getCurrentPosition( function(position) { 
        $('#longitude').val(position.coords.longitude);
        $('#latitude').val(position.coords.latitude);
      });
    } else {
      console.log("Geolocation not available!");
    }
  }
  
   //Dropzone.autoDiscover = false;
   $(function () {

    // In case user expect the submit btn to save the contract content
    $('#commercial-visit-form').on('submit', function () {
       $('#inline-editor-save-btn').click();
       return true;
    });

    if (typeof (Dropbox) != 'undefined' && $('#dropbox-chooser').length > 0) {
       document.getElementById("dropbox-chooser").appendChild(Dropbox.createChooseButton({
          success: function (files) {
             $.post(admin_url + 'contracts/add_external_attachment', {
                files: files,
                contract_id: contract_id,
                external: 'dropbox'
             }).done(function () {
                var location = window.location.href;
                window.location.href = location.split('?')[0] + '?tab=attachments';
             });
          },
          linkType: "preview",
          extensions: app.options.allowed_files.split(','),
       }));
    }

    appValidateForm($('#commercial-visit-form'), {
      client: 'required',
      subject: 'required',
      type: 'required',
      name: 'required'
    });

    var _templates = [];
    $.each(contractsTemplates, function (i, template) {
       _templates.push({
          url: admin_url + 'contracts/get_template?name=' + template,
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

  function add_visit_comment() {
    var comment = $('#comment').val();
    if (comment == '') return;
    
    var data = {};
    data.content = comment;
    data.visit = visit_id;
    $('body').append('<div class="dt-loader"></div>');
    $.post(admin_url + 'commercials_visits/add_comment', data).done(function (response) {
      response = JSON.parse(response);
      $('body').find('.dt-loader').remove();
      if (response.success == true) {
        $('#comment').val('');
        get_visit_comments();
      }
    });
  }

   function get_visit_comments() {
    if (typeof (visit_id) == 'undefined') return;
    requestGet('commercials_visits/get_comments/' + visit_id).done(function (response) {
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
   get_visit_comments();

   function remove_visit_comment(commentid) {
    if (confirm_delete()) {
       requestGetJSON('commercials_visits/remove_comment/' + commentid).done(function (response) {
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

  function edit_visit_comment(id) {
    alert(id);
    var content = $('body').find('[data-visit-comment-edit-textarea="' + id + '"] textarea').val();
    if (content != '') {
      $.post(admin_url + 'commercials_visits/edit_comment/' + id, {
          content: content
      }).done(function (response) {
        response = JSON.parse(response);
        if (response.success == true) {
          alert_float('success', response.message);
          $('body').find('[data-visit-comment="' + id + '"]').html(nl2br(content));
        }
      });
      toggle_visit_comment_edit(id);
    }
  }

  function toggle_visit_comment_edit(id) {
    $('body').find('[data-visit-comment="' + id + '"]').toggleClass('hide');
    $('body').find('[data-visit-comment-edit-textarea="' + id + '"]').toggleClass('hide');
  }

  function contractGoogleDriveSave(pickData) {
    var data = {};
    data.contract_id = contract_id;
    data.external = 'gdrive';
    data.files = pickData;
    $.post(admin_url + 'contracts/add_external_attachment', data).done(function () {
      var location = window.location.href;
      window.location.href = location.split('?')[0] + '?tab=attachments';
   });
  }
   
  $('#clientid').change(function() {
    var clientid = $(this).val();
    if (clientid != '') {
      $.post(admin_url + 'commercials_visits/get_client/'+clientid).done(function (response) {
        response = JSON.parse(response);
        console.log(response);
        if (response != null) {
          if (response.type!=null && response.type!='') {
            $('input[name=type]').val(response.type);
            $('input[name=type]').prop('readonly', true);
          } if (response.company!=null && response.company!='') {
            $('input[name=name]').val(response.company);
            $('input[name=name]').prop('readonly', true);
          } if (response.vat != null && response.vat!='') {
            $('input[name=dni_die]').val(response.vat);
            $('input[name=dni_die]').prop('readonly', true);
          } if (response.phonenumber!=null && response.phonenumber!='') {
            $('input[name=telephone]').val(response.phonenumber);
            $('input[name=telephone]').prop('readonly', true);
          }
        }
      }).fail(function (error) {
         var response = JSON.parse(error.responseText);
         alert_float('danger', response.message);
      });
    } 
  });

</script>
</body>
</html>
