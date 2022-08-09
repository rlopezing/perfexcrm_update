<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'tblsimutyperates.id',
	"if(tblsimuheadpricetable.modality is null,'','disabled')",
	'tblsimutyperates.id',
  'tblsimutyperates.detalle',
];
$sIndexColumn = 'id';
$sTable       = 'tblsimutyperates';
$sJoin 				= ["left join tblsimuheadpricetable on tblsimuheadpricetable.modality = tblsimutyperates.id"];
$sGroupby			= "group by tblsimutyperates.id, tblsimutyperates.detalle, tblsimuheadpricetable.modality";

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, [], [], $sGroupby);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 2; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'detalle') {
            $_data = '<a href="#" onclick="edit_rate_type(this,' . $aRow['tblsimutyperates.id'] . '); return false;" data-name="' . $aRow['tblsimutyperates.detalle'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblsimutyperates', ['detalle' => $aRow['tblsimutyperates.id']]) . '</span>';
        }
        $row[] = $_data;
    }
		
		$data_name = $aRow['tblsimutyperates.detalle'];
    $options = icon_btn('#', 'pencil-square-o', 'btn-default '.$aRow["if(tblsimuheadpricetable.modality is null,'','disabled')"], ['onclick' => 'edit_rate_type(this,' . $aRow['tblsimutyperates.id'] . '); return false;', 'data-name' => $data_name]);
    $row[]   = $options .= icon_btn('simulators/delete_rate_type/' . $aRow['tblsimutyperates.id'], 'remove', 'btn-danger _delete '.$aRow["if(tblsimuheadpricetable.modality is null,'','disabled')"]);

    $output['aaData'][] = $row;
}
