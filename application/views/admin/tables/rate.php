<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
	'tblcomitarifa.module_id',
	'tblcomitarifa.country_id',
	'tblcomitarifa.id',
	"(if ((tblcominivelprecio.tarifa is null)&&(tblcomicontratos.tarifa is null)&&(tblcomiplanos.tarifa is null)&&(tblsimulators.rate is null)&&(tblsimudetpricetable.rate is null),'','disabled')) as valida",
	'tblcomitarifa.id',
  'tblcomitarifa.descripcion'
];
$sIndexColumn = 'id';
$sTable       = 'tblcomitarifa';
$sJoin = [
	'left join tblcominivelprecio on tblcominivelprecio.tarifa = tblcomitarifa.id',
	'left join tblcomicontratos on tblcomicontratos.tarifa = tblcomitarifa.id',
	'left join tblcomiplanos on tblcomiplanos.tarifa = tblcomitarifa.id',
	"left join tblsimulators on tblsimulators.rate = tblcomitarifa.id",
	"left join tblsimudetpricetable on tblsimudetpricetable.rate = tblcomitarifa.id"
];
$sWhere = ["where tblcomitarifa.module_id = ".$module_id." and tblcomitarifa.country_id = ".$country_id];
$sGroup = "group by tblcomitarifa.id, tblcomitarifa.descripcion, tblcominivelprecio.tarifa, tblcomicontratos.tarifa, tblsimulators.rate, tblsimudetpricetable.rate";

$result  = data_tables_init($aColumns,$sIndexColumn,$sTable,$sJoin,$sWhere,[],$sGroup);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 4; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name') {
            $_data = '<a href="#" onclick="edit_tarifa(this,' . $aRow['tblcomitarifa.id'] . '); return false;" data-name="' . $aRow['tblcomitarifa.descripcion'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblcomitarifa', ['rate' => $aRow['tblcomitarifa.id']]) . '</span>';
        }
        $row[] = $_data;
    }
		
    $options = icon_btn('#', 'pencil-square-o', 'btn-default '.$aRow["valida"], ['onclick' => 'edit_tarifa(this,' . $aRow['tblcomitarifa.id'] . '); return false;', 'data-name' => $aRow['tblcomitarifa.descripcion']]);
    $row[]   = $options .= icon_btn('commissions/delete_rate/' . $aRow['tblcomitarifa.id'], 'remove', 'btn-danger _delete '.$aRow["valida"]);

    $output['aaData'][] = $row;
}