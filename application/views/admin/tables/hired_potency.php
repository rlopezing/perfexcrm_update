<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'tblsimuhiredpotency.id',
	"if(tblsimudetpricetable.hiredpotency is null,'','disabled')",
	'tblsimuhiredpotency.id',
  'tblsimuhiredpotency.detalle'
];
$sIndexColumn = 'id';
$sTable       = 'tblsimuhiredpotency';
$sJoin 				= ["left join tblsimudetpricetable on tblsimudetpricetable.hiredpotency = tblsimuhiredpotency.id"];
$sGroupby			= "group by tblsimuhiredpotency.id, tblsimuhiredpotency.detalle, tblsimudetpricetable.hiredpotency";

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, [], [], $sGroupby);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 2; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'detalle') {
            $_data = '<a href="#" onclick="edit_hired_potency(this,' . $aRow['tblsimuhiredpotency.id'] . '); return false;" data-name="' . $aRow['tblsimuhiredpotency.detalle'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblsimuhiredpotency', ['detalle' => $aRow['tblsimuhiredpotency.id']]) . '</span>';
        }
        $row[] = $_data;
    }
		
		$data_name = $aRow['tblsimuhiredpotency.detalle'].'=/='.$aRow['tblsimuhiredpotency.id'];
    $options = icon_btn('#', 'pencil-square-o', 'btn-default '.$aRow["if(tblsimudetpricetable.hiredpotency is null,'','disabled')"], ['onclick' => 'edit_hired_potency(this,' . $aRow['tblsimuhiredpotency.id'] . '); return false;', 'data-name' => $data_name]);
    $row[]   = $options .= icon_btn('simulators/delete_hired_potency/' . $aRow['tblsimuhiredpotency.id'], 'remove', 'btn-danger _delete '.$aRow["if(tblsimudetpricetable.hiredpotency is null,'','disabled')"]);

    $output['aaData'][] = $row;
}
