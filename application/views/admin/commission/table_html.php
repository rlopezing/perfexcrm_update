<?php
	$table_data = array	(
		'',
   	'#',
   	_l('contract_cpe'),
   	array(
   		'name'=>_l('contract_list_client'),
   		'th_attrs'=>array('class'=> (isset($client) ? 'not_visible' : ''))
   	),
   	_l('tdm_contract_types_list_name'),
   	_l('contract_value'),
   	_l('tdm_contract_start_date_supply'),
   	_l('tdm_contract_end_date_supply'),
   	_l('tdm_contract_pay_date')
 	);
 	
 	$custom_fields = get_custom_fields('contracts', array('show_on_table'=>1));
 	foreach($custom_fields as $field) {
   	array_push($table_data, $field['name']);
 	}
 	$table_data = do_action('contracts_table_columns', $table_data);
 	
 	render_datatable($table_data, (isset($class) ? $class : 'contracts'),[],[
  	'data-last-order-identifier' => 'contracts',
  	'data-default-order'         => get_table_last_order('contracts'),
 	]);
?>
