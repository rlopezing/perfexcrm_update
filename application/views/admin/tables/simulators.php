<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	$this->ci->load->model('currencies_model');
	$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

	$aColumns = [
   	'tblsimulators.id',
   	get_sql_select_client_company(),
   	'tblsimulators.nif',
   	'tblsimulators.cups',
   	'tblcomitarifa.descripcion',
   	'tblsimulators.total_savings',
   	'tblsimulators.dateadded',
	];

	$sIndexColumn = 'id';
	$sTable       = 'tblsimulators';
	$join = ['INNER JOIN tblclients ON tblclients.userid = tblsimulators.client','INNER JOIN tblcomitarifa on tblcomitarifa.id = tblsimulators.rate'];
	
	$custom_fields = get_table_custom_fields('tblsimulators');
	foreach ($custom_fields as $key => $field) {
  	$selectAs = (is_cf_date($field) ? 'date_picker_cvalue_'.$key : 'cvalue_'.$key);
  	array_push($customFieldsColumns, $selectAs);
  	array_push($aColumns, 'ctable_'.$key.'.value as '.$selectAs);
  	array_push($join, 'LEFT JOIN tblcustomfieldsvalues as ctable_'.$key.' ON tblsimulators.id = ctable_'.$key.'.relid AND ctable_'.$key.'.fieldto="'.$field['fieldto'].'" AND ctable_'.$key.'.fieldid='.$field['id']);
	}

	$where  = [];
	$filter = [];

	if ($this->ci->input->post('exclude_trashed_contracts')) array_push($filter, 'AND trash = 0');
	if ($this->ci->input->post('trash')) array_push($filter, 'OR trash = 1');
	$this->ci->load->model('simulators_model');
	$years = $this->ci->simulators_model->get_contracts_years();
	$yearsArray = [];
	foreach ($years as $year) {
    if ($this->ci->input->post('year_' . $year['year'])) {
      array_push($yearsArray, $year['year']);
    }
	}
	if (count($yearsArray) > 0) {
    array_push($filter, 'AND YEAR(dateadded) IN (' . implode(', ', $yearsArray) . ')');
	}

	$monthArray = [];
	for ($m = 1; $m <= 12; $m++) {
    if ($this->ci->input->post('contracts_by_month_'.$m)) {
      array_push($monthArray, $m);
    }
	}

	if (count($monthArray) > 0) array_push($filter, 'AND MONTH(dateadded) IN ('.implode(', ',$monthArray).')');
	if (count($filter) > 0) array_push($where, 'AND ('.prepare_dt_filter($filter).')');
	if ($clientid != '') array_push($where,'AND client='.$clientid);
	if (!has_permission('contracts', '', 'view')) array_push($where, 'AND tblcomicontratos.addedfrom='.get_staff_user_id());
	$aColumns = do_action('contracts_table_sql_columns', $aColumns);
	
	array_push($where,'AND gas=0');

	// Fix for big queries. Some hosting have max_join_limit
	if (count($custom_fields) > 4) @$this->ci->db->query('SET SQL_BIG_SELECTS=1');

	$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['tblsimulators.id', 'tblsimulators.trash', 'tblsimulators.client', 'tblsimulators.hash']);
	$output  = $result['output'];
	$rResult = $result['rResult'];

	foreach ($rResult as $aRow) {
	  $row = [];
	  $row[] = sprintf("%04d", $aRow['id']);
		$row[] = '<a href="' . admin_url('clients/client/'.$aRow['cliente']).'">'.$aRow['company'].'</a>';
		$row[] = $aRow['tblsimulators.nif'];
		
	  $subjectOutput = '<a href="'.admin_url('simulators/simulator/'.$aRow['tblsimulators.id']).'">'.$aRow['tblsimulators.cups'].'</a>';
	  if ($aRow['trash'] == 1) $subjectOutput .= '<span class="label label-danger pull-right">'._l('contract_trash').'</span>';
	  $subjectOutput .= '<div class="row-options">';
	  if (has_permission('contracts', '', 'edit')) {
	    $subjectOutput .= '<a href="'.admin_url('simulators/simulator/'.$aRow['tblsimulators.id']).'">'._l('edit').'</a>';
	  }
	  if (has_permission('contracts', '', 'delete')) {
	    $subjectOutput .= ' | <a href="'.admin_url('simulators/delete/'.$aRow['tblsimulators.id']).'" class="text-danger _delete">'._l('delete').'</a>';
	  }
	  $subjectOutput .= '</div>';
	  $row[] = $subjectOutput;
	   
	  $row[] = $aRow['tblcomitarifa.descripcion'];
	  $row[] = format_money($aRow['tblsimulators.total_savings'], ' '.$baseCurrencySymbol);
	  $row[] = _d(date("d-m-Y", strtotime($aRow['tblsimulators.dateadded'])));

	  $output['aaData'][] = $row;
	}
