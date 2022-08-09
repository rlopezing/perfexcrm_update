<div class="modal fade" id="mPriceTableHead" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open(admin_url('simulators/price_table_head'), array('id'=>'price-table-head-form')); ?>
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span class="edit-title"><?php echo _l('simulator_price_table_head_edit'); ?></span>
                  <span class="add-title"><?php echo _l('simulator_price_table_head_new'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
            <div class="row">
		          <div class="form-group select-placeholder col-md-6">
		          	<div class="additional"></div>
		          	<?php
		             	$selected = (isset($price_table_head) ? $price_table_head->modality : '');
		             	echo render_select('modality',$modality,array('id','detalle'),'simulator_price_modality',$selected);
		            ?>
		        	</div>
		          <div class="form-group select-placeholder col-md-6">
		          	<div class="additional"></div>
		            	<?php
		            		$selected = (isset($finished) ? $finished : '');
		            		echo render_select('finished',$finisheds,array('id','detalle'),'simulator_finished',$selected);
		            	?>
		        	</div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
              <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
          </div>
      </div><!-- /.modal-content -->
      <?php echo form_close(); ?>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>

  window.addEventListener('load',function() {
    _validate_form($('#price-table-head-form'), {	modality:'required' }, manage_price_table_head);
    $('#mPriceTableHead').on('hidden.bs.modal', function(event) 
    {
      $('#additional').html('');
      $('#mPriceTableHead input[name="modality"]').val('');
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_price_table_head(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      if(response.success == true) {
        alert_float('success',response.message);
        if(typeof(response.id) != 'undefined') {
          var cpricetable = $('#price_table');
          cpricetable.find('option:first').after('<option value="'+response.id+'">'+response.name+'</option>');
          cpricetable.selectpicker('val',response.id);
          cpricetable.selectpicker('refresh');
        }
      }
      $('#mPriceTableHead').modal('hide');
    });
    return false;
	}
	
	function new_price_table_head()	{
		var marketer = $('#marketer option:selected').val();
		if (marketer == "") {
			alert_float('success',"Seleccione un comercializador");	
			$('#marketer').focus();
			return false;
		}
		
		$('.additional').append(hidden_input('marketer',marketer));
    $('#mPriceTableHead').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_price_table_head() {
		var marketer = $('#marketer option:selected').val();
		if (marketer == "") {
			alert_float('success',"Seleccione un comercializador");	
			$('#marketer').focus();
			return false;
		}
		
		var ids = $('#price_table option:selected').val();
		if (ids == "") {
			alert_float('success',"Seleccione una tabla de precios");	
			$('#price_table').focus();
			return false;
		}
		var id = ids.split('-')[0];
		var modality = ids.split('-')[1];
    $('.additional').append(hidden_input('id',id));
    var cmodality = $("#modality");
    cmodality.selectpicker('val',modality);
    cmodality.selectpicker('refresh');
    $('#mPriceTableHead').modal('show');
    $('.add-title').addClass('hide');
	}
	
	function remove_price_table_head() {
		var marketer = $('#marketer option:selected').val();
		if (marketer == "") {
			alert_float('success',"Seleccione un comercializador");	
			$('#marketer').focus();
			return false;
		}
		
		var ids = $('#price_table option:selected').val();
		if (ids == "") {
			alert_float('success',"Seleccione una tabla de precios");	
			$('#price_table').focus();
			return false;
		}
		
		if (confirm_delete()) {
			var id = ids.split('-')[0];
			var url = $('#adminurl').val()+"simulators/delete_price_table_head/";
		  requestGetJSON(url + id).done(function (response) {
		  	var message = response.message;
		  	var id = response.id;
	      if (response.success == true) {
          $("#price_table option[value='"+id+"']").remove();
          var cpricetable = $('#price_table');
          cpricetable.selectpicker('val','');
          cpricetable.selectpicker('refresh');
          alert_float('success',message);	
	      } else {
					alert_float('warning',message);
				}
		  });
		}
	}
	
	
</script>
