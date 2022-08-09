<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
        	<div class="_filters _hidden_inputs hidden">
          	<?php
              echo form_hidden('exclude_trashed_contracts',true);
              echo form_hidden('expired');
              echo form_hidden('without_dateend');
              echo form_hidden('trash');
              foreach($years as $year) {
                echo form_hidden('year_'.$year['year'],$year['year']);
              }
              for ($m = 1; $m <= 12; $m++) {
                echo form_hidden('contracts_by_month_'.$m);
              }
          	?>
          </div>
          <div class="panel-body _buttons">
            <?php if (has_permission('documents_control','','create')){ ?>
              <div class="col-md-12 pull-right" style="padding: 0px;">
                 <a class="text-uppercase pull-left"><h3><?php echo _l('documents_control'); ?></h3></a>
              </div>
              <a href="<?php echo admin_url('clients/client'); ?>" class="btn btn-info pull-left display-block" style="margin-right: 5px;"><?php echo _l('new_client'); ?></a>
              <a href="<?php echo admin_url('documents_control/document_control'); ?>" class="btn btn-info pull-left display-block">
                <?php echo _l('documents_control'); ?>
              </a>
            <?php } ?>
          </div>
        </div>
        <div class="panel_s">
          <?php echo form_hidden('custom_view'); ?>
          <div class="panel-body">
            <?php $this->load->view('admin/document_control/table_html'); ?>
         	</div>
       	</div>
   		</div>
    </div>
	</div>
</div>
<?php init_tail(); ?>
<script>
   
  $(function(){
    var ContractsServerParams = {};
    
    $.each($('._hidden_inputs._filters input'),function() {
       ContractsServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
    });
    
    initDataTable('.table-documents-control', admin_url+'documents_control/table', undefined, undefined, ContractsServerParams,<?php echo do_action('contracts_table_default_order',json_encode(array(6,'asc'))); ?>);
  });
  
  $(".chk_id_all").change(function(){
  	$(".chk_id").attr('checked', this.checked);
  });
  
  $(".invoice").click(function(){
		var contracts = [];
		
    $('.chk_id').each(function(){
      if (this.checked) contracts.push($(this).val());
    });
		if (contracts.length == 0) {
			alert_float('success',"Seleccione contratos a facturar");	
			return false;
		}
  	$('#contracts').val(contracts);
  	var url = $('#adminurl').val()+'commercials_visits/commercial_visit';
  	
  	$("#filtrar-form").attr('action',url);
  	$("#filtrar-form").submit();
  });
  
  function invoice(url) {
		var contracts = [];
		
    $('.chk_id').each(function() {
      if (this.checked) contracts.push($(this).val());
    });
    
		if (contracts.length == 0) {
			alert_float('success',"Seleccione contratos a facturar");	
			return false;
		}
		
    var data = {
    	'fdesde' 		: $('#fdesde').val(),
    	'fhasta' 		: $('#fhasta').val(),
    	'cliente'		: $('#cliente').val(),
    	'contracts' : contracts
    }
    
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
    }).fail(function(data) {
      var error = JSON.parse(data.responseText);
      alert_float('danger',error.message);
    });
    
    return false;
	}
	
	///// Cuando selecciona un cliente.
	$('#cliente').change(function(Event) {
		var id =  $('#clientid option:selected').val();
		if (id != '') {
			$('.filter').removeAttr('disabled');
    }
	});
	
</script>
</body>
</html>
