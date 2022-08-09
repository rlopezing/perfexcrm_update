<?php

	$table_data = array
	(
   	_l('the_number_sign'),
   	array(
   		'name'=>_l('contract_list_client'),
   		'th_attrs'=>array('class'=> (isset($client) ? 'not_visible' : ''))
   	),
   	_l('general_map_nif'),
   	_l('simulator_cups'),
   	_l('simulator_rates'),
   	_l('simulator_total_savings'),
   	_l('simulator_date_add')
 	);
 	
 	$custom_fields = get_custom_fields('contracts', array('show_on_table'=>1));
 	foreach($custom_fields as $field)
 	{
   	array_push($table_data, $field['name']);
 	}
 	$table_data = do_action('contracts_table_columns', $table_data);
 
 	render_datatable($table_data, (isset($class) ? $class : 'contracts'),[],[
    	'data-last-order-identifier' => 'contracts',
    	'data-default-order'         => get_table_last_order('contracts'),
 	]);
 
?>
