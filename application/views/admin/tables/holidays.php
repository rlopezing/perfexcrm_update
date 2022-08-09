<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'holidayid',
	'holiday_date',
	'holiday_reason'
];
$sIndexColumn = 'holidayid';
$sTable       = 'tbltcholidays';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], []);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
  $row = [];
  for ($i = 0; $i < count($aColumns); $i++) {
    $_data = $aRow[$aColumns[$i]];
    if ($aColumns[$i] == 'holiday_reason') {
    	$data_name = _d(date("Y-m-d", strtotime($aRow['holiday_date']))) . "*_*" . $aRow['holiday_reason'];
      $_data = '<a href="#" onclick="edit_holiday(this,' . $aRow['holidayid'] . '); return false;" data-name="' . $data_name . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tbltcholidays', ['holidayid' => $aRow['holidayid']]) . '</span>';
    }
    if ($aColumns[$i] == 'holiday_date') $_data = _d(date("d-m-Y", strtotime($aRow['holiday_date'])));
    
    $row[] = $_data;
  }
	
  $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['onclick' => 'edit_holiday(this,' . $aRow['holidayid'] . '); return false;', 'data-name' => $data_name]);
  $row[]   = $options .= icon_btn('time_controls/delete_holiday/' . $aRow['holidayid'], 'remove', 'btn-danger _delete');

  $output['aaData'][] = $row;
}
