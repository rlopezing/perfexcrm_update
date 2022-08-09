<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'tblsimufinished.id',
	"if(tblsimuheadpricetable.finished is null,'','disabled')",
	'tblsimufinished.id',
  'tblsimufinished.detalle',
];
$sIndexColumn = 'id';
$sTable       = 'tblsimufinished';
$sJoin				= ["left join tblsimuheadpricetable on tblsimuheadpricetable.finished = tblsimufinished.id"];
$sGroupby			= "group by tblsimufinished.id, tblsimufinished.detalle, tblsimuheadpricetable.finished";

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, [], [], $sGroupby);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 2; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'detalle') {
            $_data = '<a href="#" onclick="edit_prices(this,' . $aRow['tblsimufinished.id'] . '); return false;" data-name="' . $aRow['tblsimufinished.detalle'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblsimufinished', ['detalle' => $aRow['tblsimufinished.id']]) . '</span>';
        }
        $row[] = $_data;
    }
		
		$data_name = $aRow['detalle'];
    $options = icon_btn('#', 'pencil-square-o', 'btn-default '.$aRow["if(tblsimuheadpricetable.finished is null,'','disabled')"], ['onclick' => 'edit_prices(this,' . $aRow['tblsimufinished.id'] . '); return false;', 'data-name' => $data_name]);
    $row[] = $options .= icon_btn('simulators/delete_prices/' . $aRow['tblsimufinished.id'], 'remove', 'btn-danger _delete '.$aRow["if(tblsimuheadpricetable.finished is null,'','disabled')"]);

    $output['aaData'][] = $row;
}
