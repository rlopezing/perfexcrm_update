<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(), array('id'=>'invoice-form', 'class'=>'_transaction_form invoice-form'));
			if(isset($invoice)) {
				echo form_hidden('isedit');
			}
			?>
			<div class="col-md-3">
				<input type="text" name="contracts" class="form-control hidden" value="<?php echo $contracts; ?>">
			</div>
			<div class="col-md-12">
				<?php $this->load->view('admin/invoices/invoice_template'); ?>
			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/invoice_items/item'); ?>
			<input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>

	$(function() {
		validate_invoice_form();
    // Init accountacy currency symbol
    init_currency();
    // Project ajax search
    init_ajax_project_search_by_customer_id();
    // Maybe items ajax search
    init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');
	});
	
	///// Responde a la selección del cliente.
	$('#clientid').change(function(Event) {
		var clientid =  $('#clientid option:selected').val();
		if (clientid != '') {
			url = $('#adminurl').val()+'invoices/get_client_default_tax/'+clientid;
		  $.post(url).done(function (response) {
				response = JSON.parse('['+response+']');
				
				console.log(response[0].default_tax);
				console.log(response);
			});
		}
	});
	
</script>
</body>
</html>
