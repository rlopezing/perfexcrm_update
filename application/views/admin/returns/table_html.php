<?php defined('BASEPATH') or exit('No direct script access allowed');

if ($_SESSION['cliente_id'] == '') {
	$table_data = array(
	  _l('return_dt_table_heading_number'),
	  _l('invoice_dt_table_heading_number'),
	  array(
	    'name'=>_l('invoice_dt_table_heading_client'),
	    'th_attrs'=>array('class'=>(isset($client) ? 'not_visible' : ''))
	  ),
	  _l('invoice_dt_table_heading_date'),
	 	_l('return_dt_table_heading_subtotal'),
	  _l('invoice_total_tax'),
	  _l('invoice_dt_table_heading_amount'),
	  _l('options'),
	);
} else {
	$table_data = array(
	  _l('invoice_dt_table_heading_number'),
	  array(
	    'name'=>_l('invoice_dt_table_heading_client'),
	    'th_attrs'=>array('class'=>(isset($client) ? 'not_visible' : ''))
	  ),
	  _l('invoice_dt_table_heading_date'),
	 	_l('return_dt_table_heading_subtotal'),
	  _l('invoice_total_tax'),
	  _l('invoice_dt_table_heading_amount'),
	  _l('options'),
	);
}

$custom_fields = get_custom_fields('invoice',array('show_on_table'=>1));
foreach($custom_fields as $field) {
  array_push($table_data,$field['name']);
}
$table_data = hooks()->apply_filters('invoices_table_columns', $table_data);

render_datatable($table_data, (isset($class) ? $class : 'returns'));
?>
