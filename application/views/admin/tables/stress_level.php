<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
	'tblcominiveltension.id',
	"if(tblcomicontratos.tarifa is null,'','disabled')",
	'tblcominiveltension.id',
  'tblcominiveltension.nombre',
];
$sIndexColumn = 'id';
$sTable       = 'tblcominiveltension';
$sJoin 				= ['left join tblcomicontratos on tblcomicontratos.nivel_tension = tblcominiveltension.id'];
$sGroupby 		= "group by tblcominiveltension.id, tblcominiveltension.nombre, tblcomicontratos.nivel_tension";

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, [], [], $sGroupby);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 2; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name') {
            $_data = '<a href="#" onclick="edit_stress_level(this,' . $aRow['tblcominiveltension.id'] . '); return false;" data-name="' . $aRow['tblcominiveltension.nombre'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblcominiveltension', ['contract_type' => $aRow['tblcominiveltension.id']]) . '</span>';
        }
        $row[] = $_data;
    }

    $options = icon_btn('#', 'pencil-square-o', 'btn-default '.$aRow["if(tblcomicontratos.tarifa is null,'','disabled')"], ['onclick' => 'edit_stress_level(this,' . $aRow['tblcominiveltension.id'] . '); return false;', 'data-name' => $aRow['nombre']]);
    $row[]   = $options .= icon_btn('commissions/delete_stress_level/' . $aRow['tblcominiveltension.id'], 'remove', 'btn-danger _delete '.$aRow["if(tblcomicontratos.tarifa is null,'','disabled')"]);

    $output['aaData'][] = $row;
}
