<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = [
   '#',
   _l('commercial_visit_subject'),
    [
      'name'     => _l('commercial_visit_client'),
      'th_attrs' => ['class' => isset($client) ? 'not_visible' : ''],
    ],
   _l('commercial_visit_dni_nie'),
   _l('commercial_visit_date'),
   _l('commercial_visit_status'),
   _l('commercial_visit_options'),
];

$custom_fields = get_custom_fields('operations', ['show_on_table' => 1]);
foreach ($custom_fields as $field) {
  array_push($table_data, $field['name']);
}

$table_data = hooks()->apply_filters('projects_table_columns', $table_data);

render_datatable($table_data, isset($class) ?  $class : 'operations', [], [
  'data-last-order-identifier' => 'operations',
  'data-default-order'  => get_table_last_order('operations'),
]);
