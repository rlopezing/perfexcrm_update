<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
				if ($option == "new")	echo form_open(admin_url("returns/invoice"), array('id'=>'invoice-form', 'class'=>'_transaction_form invoice-form'));
				if ($option == "edit") echo form_open(admin_url("returns/invoice/" . $id), array('id'=>'invoice-form', 'class'=>'_transaction_form invoice-form'));
				if(isset($invoice)) echo form_hidden('isedit');
			?>
			<div class="col-md-3">
				<input type="text" name="contracts" class="form-control hidden" value="<?php echo $contracts; ?>">
			</div>
			<div class="col-md-12">
				<?php $this->load->view('admin/returns/invoice_template'); ?>
			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/return_items/item'); ?>
			<input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>

	$(function() {
		validate_return_form();
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
			url = $('#adminurl').val()+'returns/get_client_default_tax/'+clientid;
		  $.post(url).done(function (response) {
				response = JSON.parse('['+response+']');
			});
		}
	});
	
</script>
</body>
</html>
