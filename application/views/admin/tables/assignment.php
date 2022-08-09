<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('currencies_model');
$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

$aColumns = [
  'tblstaff.staffid',
  'CONCAT(tblstaff.firstname," ",tblstaff.lastname)',
  'tbltcschedule.name',
  'tbltcmodalitys.name', 
  'tbltcscheduleassignment.start_date', 
  'tbltcscheduleassignment.end_date'
];

$sIndexColumn = 'staffid';
$sTable       = 'tblstaff';

$join = [
	"left join tbltcscheduleassignment on tbltcscheduleassignment.staffid = tblstaff.staffid",
	"left join tbltcschedule on tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid",
	"left join tbltcmodalitys on tbltcmodalitys.modalityid = tbltcschedule.modalityid"
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], ['scheduleassignmentid']);	
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
  $row = [];
  
  for ($i = 0; $i < count($aColumns); $i++) {
  	$_data = $aRow[$aColumns[$i]];
  	
  	if ($aColumns[$i] == 'tbltcschedule.name') {
  		if (is_null($aRow['tbltcschedule.name'])) {
				$subjectOutput = $_data;
			} else {
		    $subjectOutput = '<a href="#">' . $_data . '</a>';
		    $subjectOutput .= '<div class="row-options">';
		    if (has_permission('contracts', '', 'edit')) {
		      $subjectOutput .= '<a href="' . admin_url('time_controls/assignments/' . $aRow['scheduleassignmentid']) . '">' . _l('edit') . '</a>';
		    }
		    if (has_permission('contracts', '', 'delete')) {
		      $subjectOutput .= ' | <a href="' . admin_url('time_controls/delete_assignment/' . $aRow['scheduleassignmentid']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
		    }
		    $subjectOutput .= '</div>';
			}
	    $_data = $subjectOutput;
		}
  	
  	if ($aColumns[$i] == 'tbltcscheduleassignment.start_date')
  		if (is_null($_data)) $_data = ''; else $_data = _d(date("d-m-Y", strtotime($_data)));
  	if ($aColumns[$i] == 'tbltcscheduleassignment.end_date') 
  		if (is_null($_data)) $_data = ''; else $_data = _d(date("d-m-Y", strtotime($_data)));
    $row[] = $_data;
  }

  $output['aaData'][] = $row;
}
?>