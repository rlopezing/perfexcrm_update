<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('currencies_model');
$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

$aColumns = [
  'tbltcschedule.scheduleid',
  'tbltcschedule.name',
  'tbltcmodalitys.name',
  'tbltcschedule.entry_time', 
  'tbltcschedule.departure_time',
  'tbltcschedule.rest_start',
  'tbltcschedule.end_rest'
];

$sIndexColumn = 'scheduleid';
$sTable       = 'tbltcschedule';

$join = [
	"inner join tbltcmodalitys on tbltcmodalitys.modalityid = tbltcschedule.modalityid"
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], []);	
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
  $row = [];
  
  for ($i = 0; $i < count($aColumns); $i++) {
  	$_data = $aRow[$aColumns[$i]];

		if ($aColumns[$i] == 'tbltcschedule.name') {
	    $subjectOutput = '<a href="#">' . $_data . '</a>';
	    $subjectOutput .= '<div class="row-options">';
	    if (has_permission('contracts', '', 'edit')) {
	      $subjectOutput .= '<a href="' . admin_url('time_controls/configurations/' . $aRow['tbltcschedule.scheduleid']) . '">' . _l('edit') . '</a>';
	    }
	    if (has_permission('contracts', '', 'delete')) {
	      $subjectOutput .= ' | <a href="' . admin_url('time_controls/delete_configuration/' . $aRow['tbltcschedule.scheduleid']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
	    }
	    $subjectOutput .= '</div>';
	    $_data = $subjectOutput;
		}

  	if ($aColumns[$i] == 'tbltctimecontrols.entry_time') $_data = _d(date("hh:mm:ss", strtotime($_data)));
  	if ($aColumns[$i] == 'tbltctimecontrols.departure_time') $_data = _d(date("hh:mm:ss", strtotime($_data)));
  	if ($aColumns[$i] == 'tbltctimecontrols.rest_start') $_data = _d(date("hh:mm:ss", strtotime($_data)));
  	if ($aColumns[$i] == 'tbltctimecontrols.end_rest') $_data = _d(date("hh:mm:ss", strtotime($_data)));
  	
    $row[] = $_data;
  }

  $output['aaData'][] = $row;
}
?>