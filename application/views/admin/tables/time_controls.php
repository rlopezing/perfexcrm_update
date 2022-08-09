<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('currencies_model');
$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

$aColumns = [
  'tbltctimecontrols.date_add',
  'CONCAT(tblstaff.firstname," ",tblstaff.lastname)',
  'func_reasonmyday(tbltctimecontrols.date_add)',
  'func_hoursmyday(tbltctimecontrols.date_add)', 
  'tbltctimecontrols.entry_time', 
  'tbltctimecontrols.departure_time', 
  'tbltctimecontrols.rest', 
	'func_totalhours(tbltctimecontrols.date_add, func_hoursmyday(tbltctimecontrols.date_add), func_holiday(tbltctimecontrols.date_add))',
	'func_difference(tbltctimecontrols.date_add, func_hoursmyday(tbltctimecontrols.date_add), func_holiday(tbltctimecontrols.date_add))',
];

$sIndexColumn = 'timecontrolid';
$sTable       = 'tbltctimecontrols';

$join = [
	"inner join tblstaff on tblstaff.staffid = tbltctimecontrols.staffid",
	"inner join tbltcscheduleassignment on tbltcscheduleassignment.staffid = tbltctimecontrols.staffid",
	"inner join tbltcschedule on tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid"
];

$where = [];
array_push($where, "where");
array_push($where, " date_format(tbltctimecontrols.date_add, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."'");

if ($staffid != '') {
	log_message('debug', "staffid: ".print_r($staffid, TRUE));
	array_push($where, ' AND tbltctimecontrols.staffid=' . $staffid);
}

if (has_permission('time_controls', '', 'view_own') && !is_admin()) {
	log_message('debug', "has_permission: ".print_r(get_staff_user_id(), TRUE));
	array_push($where, ' AND tbltctimecontrols.staffid=' . get_staff_user_id());
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['func_holidayreason(tbltctimecontrols.date_add)', 'func_idmyday(tbltctimecontrols.date_add)', 'tbltctimecontrols.timecontrolid']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
  $row = [];
  
  for ($i = 0; $i < count($aColumns); $i++) {
  	$_data = $aRow[$aColumns[$i]];
  	
  	if (is_admin()) {
	  	if ($aColumns[$i] == 'func_reasonmyday(tbltctimecontrols.date_add)') {
	  		$_data = '<a href="' . admin_url('time_controls/delete_myday/' . $aRow['func_idmyday(tbltctimecontrols.date_add)']) . '">' . $aRow['func_reasonmyday(tbltctimecontrols.date_add)'] . '</a>, ' . $aRow['func_holidayreason(tbltctimecontrols.date_add)'];
			}
		}
		
		$total_ts = 0;
		if ($aColumns[$i] == 'tbltctimecontrols.rest') {
			if (!is_null($aRow['tbltctimecontrols.rest'])) {
				$rest = json_decode($aRow['tbltctimecontrols.rest']);
				$long = count($rest);
				$nodo = 0;
				while ($nodo < $long) {
					$ts_fin = strtotime($rest[$nodo]->input);
					$ts_ini = strtotime($rest[$nodo]->output);
					$total_ts = $total_ts + ($ts_fin - $ts_ini) / 3600;
					$nodo++;
				}
			}
			$_data = round($total_ts, 3);
		}

		if (is_admin()) {
			if ($aColumns[$i] == 'CONCAT(tblstaff.firstname," ",tblstaff.lastname)') {
				
				$_data = '<a href="' . admin_url('time_controls/edit/' . $aRow['timecontrolid']) . '">' . $aRow['CONCAT(tblstaff.firstname," ",tblstaff.lastname)'] . '</a>';
			}
		}
		
  	if ($aColumns[$i] == 'date_add') $_data = _d(date("d-m-Y", strtotime($aRow['date_add'])));
  	
  	if ($aColumns[$i] == 'func_totalhours(tbltctimecontrols.date_add, func_hoursmyday(tbltctimecontrols.date_add), func_holiday(tbltctimecontrols.date_add))') {
			$total_hours = 0;
			$total_hours = $aRow['func_totalhours(tbltctimecontrols.date_add, func_hoursmyday(tbltctimecontrols.date_add), func_holiday(tbltctimecontrols.date_add))'];
			$_data = round(($total_hours - $total_ts), 3);
		}
  	
    $row[] = $_data;
  }

  $output['aaData'][] = $row;
}
?>