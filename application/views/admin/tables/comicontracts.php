<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	$this->ci->load->model('currencies_model');
	$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

	$aColumns = [
		'tblcomicontratos.termination_motive',
		'tblcomicontratos.invoiced',
		'tblcomicontratos.id',
   	'tblcomicontratos.id',
   	'tblcomicontratos.cpe',
   	get_sql_select_client_company(),
   	'tblcominiveltension.nombre', 
   	'tblcomicontratos.valor_contrato',
   	'tblcomicontratos.fecha_inicio_suministro',
   	'tblcomicontratos.fecha_fin_suministro',
   	'tblcomicontratos.fecha_pago',
	];
	$sIndexColumn = 'id';
	$sTable       = 'tblcomicontratos';
	$join = [
		'left join tblclients ON tblclients.userid = tblcomicontratos.cliente',
		'left join tblcominiveltension on tblcominiveltension.id = tblcomicontratos.nivel_tension'
	];
	$where  = [];
	$filter = [];
	
	if ($this->ci->input->post('exclude_trashed_contracts')) {
	   array_push($filter, 'AND trash = 0');
	}

	if ($this->ci->input->post('trash')) {
	   array_push($filter, 'OR trash = 1');
	}

	if ($this->ci->input->post('expired')) {
	   array_push($filter, 'OR tblcomicontratos.fecha_fin_suministro IS NOT NULL AND tblcomicontratos.fecha_fin_suministro <"'.date('Y-m-d').'" and tblcomicontratos.trash = 0');
	}

	if ($this->ci->input->post('without_dateend')) {
	   array_push($filter, 'OR tblcomicontratos.fecha_fin_suministro IS NULL AND trash = 0');
	}
	
	$this->ci->load->model('commissions_model');
	$years      = $this->ci->commissions_model->get_contracts_years();
	$yearsArray = [];
	foreach ($years as $year) {
	    if ($this->ci->input->post('year_' . $year['year'])) {
	        array_push($yearsArray, $year['year']);
	    }
	}
	if (count($yearsArray) > 0) {
	    array_push($filter, 'AND YEAR(tblcomicontratos.fecha_inicio_suministro) IN (' . implode(', ', $yearsArray) . ')');
	}

	$monthArray = [];
	for ($m = 1; $m <= 12; $m++) {
	    if ($this->ci->input->post('contracts_by_month_'.$m)) {
	        array_push($monthArray, $m);
	    }
	}

	if (count($monthArray) > 0) {
	    array_push($filter, 'AND MONTH(tblcomicontratos.fecha_inicio_suministro) IN ('.implode(', ', $monthArray).')');
	}
	
	if (count($filter) > 0) {
	   array_push($where, 'AND ('.prepare_dt_filter($filter).')');
	}

	if ($clientid != '') {
	   array_push($where, 'AND client=' . $clientid);
	}

	if (!has_permission('contracts', '', 'view')) {
	   array_push($where, 'AND tblcomicontratos.addedfrom='.get_staff_user_id());
	}
	
	if ($fdesde!='' && $fhasta!='') {
    array_push($where, "AND date_format(tblcomicontratos.dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."'");
	}
	
	if ($cliente!='') {
    array_push($where, "AND tblcomicontratos.comercializador = ".$cliente);
	}

	$aColumns = do_action('contracts_table_sql_columns', $aColumns);

	$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['tblcomicontratos.id', 'tblcomicontratos.trash', 'tblcomicontratos.cliente', 'tblcomicontratos.hash']);
	$output  = $result['output'];
	$rResult = $result['rResult'];

	foreach ($rResult as $aRow) {
	  $row = [];
	  	  
	  if ($aRow['tblcomicontratos.invoiced'] == 0) {
			if ($aRow['tblcomicontratos.termination_motive'] == 0) 
				$row[] = '<label><input type="checkbox" name="chkid[]" class="chk_id" value="'.$aRow['tblcomicontratos.id'].'"></label>';
				else $row[] = '<label>B</label>';
		} else {
			if ($aRow['tblcomicontratos.termination_motive']==0) $row[] = '<label>F</label>'; else $row[] = '<label>B</label>';
		}
	  
	  $id = sprintf("%04d", $aRow['tblcomicontratos.id']);
	  $row[] = $id;

	  $subjectOutput = '<a href="'.admin_url('commissions/contract/'.$aRow['tblcomicontratos.id']).'">'.$aRow['tblcomicontratos.cpe'].'</a>';
	  if ($aRow['trash'] == 1) {
	    $subjectOutput .= '<span class="label label-danger pull-right">'._l('contract_trash').'</span>';
	  }

	  $subjectOutput .= '<div class="row-options">';
	  if (has_permission('contracts', '', 'delete')) {
	    if ($aRow['tblcomicontratos.termination_motive'] == 0)
	    { 
	    	$subjectOutput .= '<a href="'.admin_url('commissions/delete/'.$aRow['id']).'" class="text-danger _delete">'._l('delete').'</a>';
			}
	  }
	  $subjectOutput .= '</div>';
	  $row[] = $subjectOutput;

	  $row[] = '<a href="'.admin_url('clients/client/'.$aRow['tblcomicontratos.cliente']).'">'.$aRow['company'].'</a>';
	  $row[] = $aRow['tblcominiveltension.nombre'];
	  $row[] = format_money($aRow['tblcomicontratos.valor_contrato'], $baseCurrencySymbol);
	  $row[] = _d(date("d-m-Y", strtotime($aRow['tblcomicontratos.fecha_inicio_suministro'])));
	  $row[] = _d(date("d-m-Y", strtotime($aRow['tblcomicontratos.fecha_fin_suministro'])));	    
	  $row[] = _d(date("d-m-Y", strtotime($aRow['tblcomicontratos.fecha_pago'])));

	  // Custom fields add values
	  foreach ($customFieldsColumns as $customFieldColumn) {
	    $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
	  }

	  $hook = do_action('contracts_table_row_data', [
	    'output' => $row,
	    'row'    => $aRow,
	  ]);

	  $row = $hook['output'];

	  if (!empty($aRow['tblcomicontratos.fecha_fin_suministro'])) {
	    $_date_end = date('Y-m-d', strtotime($aRow['tblcomicontratos.fecha_fin_suministro']));
	    if ($_date_end < date('Y-m-d')) {
	      if ($aRow['tblcomicontratos.termination_motive']==0) $row['DT_RowClass'] = 'alert-danger'; else $row['DT_RowClass'] = 'alert-warning';
	    }
	  }

	  if (isset($row['DT_RowClass'])) {
	    $row['DT_RowClass'] .= ' has-row-options';
	  } else {
	    $row['DT_RowClass'] = 'has-row-options';
	  }

	  $output['aaData'][] = $row;
	}
