<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'id',
  'detalle',
];
$sIndexColumn = 'id';
$sTable       = 'tblsimurate';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], []);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 1; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'detalle') {
            $_data = '<a href="#" onclick="edit_rate(this,' . $aRow['id'] . '); return false;" data-name="' . $aRow['detalle'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblsimurate', ['detalle' => $aRow['id']]) . '</span>';
        }
        $row[] = $_data;
    }
		
		$data_name = $aRow['detalle'].'=/='.$aRow['id'];
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['onclick' => 'edit_rate(this,' . $aRow['id'] . '); return false;', 'data-name' => $data_name]);
    $row[]   = $options .= icon_btn('simulators/delete_rate/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
