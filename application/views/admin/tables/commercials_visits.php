<?php
defined('BASEPATH') or exit('No direct script access allowed');

$base_currency = get_base_currency();

$aColumns = [
  db_prefix() . 'cvisit.id as id',
  db_prefix() . 'cvisit.id as id',
  'subject',
  'tblclients.company', 
  'dni_die',
  db_prefix() . 'cvisit.date_add',
  'hour_add',
  db_prefix() . 'cvstatus.status'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'cvisit';

$join = [
  'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = ' . db_prefix() . 'cvisit.client',
  'LEFT JOIN ' . db_prefix() . 'cvstatus ON ' . db_prefix() . 'cvstatus.id = ' . db_prefix() . 'cvisit.status',
  'LEFT JOIN ' . db_prefix() . 'cvtake_data ON ' . db_prefix() . 'cvtake_data.client = ' . db_prefix() . 'cvisit.client'  
];

$custom_fields = get_table_custom_fields('cvisit');

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);

    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'cvisit.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where  = [];
$filter = [];

if ($this->ci->input->post('exclude_trashed_contracts')) array_push($filter, 'AND trash = 0');
if ($this->ci->input->post('trash')) array_push($filter, 'AND trash = 1');

$years      = $this->ci->commercials_visits_model->get_visits_years();
$yearsArray = [];
foreach ($years as $year) {
    if ($this->ci->input->post('year_' . $year['year'])) {
        array_push($yearsArray, $year['year']);
    }
}
if (count($yearsArray) > 0) array_push($filter, 'AND YEAR(tblcvisit.date_add) IN (' . implode(', ', $yearsArray) . ')');

$monthArray = [];
for ($m = 1; $m <= 12; $m++) {
    if ($this->ci->input->post('contracts_by_month_' . $m)) {
      array_push($monthArray, $m);
    }
}

if (count($filter) > 0) array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
if ($clientid != '') array_push($where, 'AND client=' . $clientid);

if (!has_permission('commercials_visits', '', 'view')) {
  array_push($where, 'AND ' . db_prefix() . 'cvisit.addedfrom=' . get_staff_user_id());
}

$aColumns = hooks()->apply_filters('contracts_table_sql_columns', $aColumns);

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
  @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'cvisit.id','trash','tblcvisit.client','hash','tblcvtake_data.id as takedata']);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];
    
    $subjectOutput = '<a href="' . admin_url('commercials_visits/commercial_visit/' . $aRow['id']) . '">' . $aRow['subject'] . '</a>';
    if ($aRow['trash'] == 1) $subjectOutput .= '<span class="label label-danger pull-right">' . _l('contract_trash') . '</span>';
    $subjectOutput .= '<div class="row-options">';
    $subjectOutput .= '<a href="' . site_url('commercials_visits/' . $aRow['id'] . '/' . $aRow['hash']) . '" target="_blank">' . _l('view') . '</a>';
    if (has_permission('commercials_visits', '', 'edit')) $subjectOutput .= ' | <a href="' . admin_url('commercials_visits/commercial_visit/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    if (has_permission('commercials_visits', '', 'delete')) {
      if (is_null($aRow['takedata'])) {
        $subjectOutput .= ' | <a href="' . admin_url('commercials_visits/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
      }
    }
    $subjectOutput .= '</div>';
    $row[] = $subjectOutput;
    
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['client']) . '">' . $aRow['tblclients.company'] . '</a>';
    $row[] = $aRow['dni_die'];
    $row[] = _d(date ("Y-m-d", strtotime($aRow['tblcvisit.date_add'])));
    $row[] = date("H:i:s", strtotime($aRow['hour_add']));
    $row[] = $aRow[db_prefix() . 'cvstatus.status'];
    
    
    $row[] = '<a href="' . admin_url('commercials_visits/take_form/' . $aRow['client'] . '/' . $aRow['takedata']) . '" class="btn btn-xs btn-primary">' . _l('commercial_visit_take_data') . '</a>';
    
    
    if (isset($row['DT_RowClass'])) $row['DT_RowClass'] .= ' has-row-options'; else $row['DT_RowClass'] = 'has-row-options';
    $row = hooks()->apply_filters('contracts_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
