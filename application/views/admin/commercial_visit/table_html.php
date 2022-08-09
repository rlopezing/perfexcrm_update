<?php
	$table_data = array	(
   	'#',
    _l('commercial_visit_subject'),  
   	_l('commercial_visit_client'),
    _l('commercial_visit_dni_nie'),
   	_l('commercial_visit_date'),
    _l('commercial_visit_hour'),
   	_l('commercial_visit_status'),
    _l('commercial_visit_opctions'),
 	);
 	
 	$custom_fields = get_custom_fields('contracts', array('show_on_table'=>1));
 	foreach($custom_fields as $field) {
   	array_push($table_data, $field['name']);
 	}
 	$table_data = do_action('contracts_table_columns', $table_data);
 	
 	render_datatable($table_data, (isset($class) ? $class : 'commercials-visits'),[],[
  	'data-last-order-identifier' => 'contracts',
  	'data-default-order'         => get_table_last_order('commercials-visits'),
 	]);
?>
