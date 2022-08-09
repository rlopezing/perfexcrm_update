<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'tblcomicategoriacomercial.id',
	"if((tblcomistaff_assign.commercial_category is null)&&(tblcomiplanos.categoria_comercial is null)&&(tblcomicontratos.categoria_comercial is null),'','disabled')",
	'tblcomicategoriacomercial.id',
  'tblcomicategoriacomercial.detalle',
];
$sIndexColumn = 'id';
$sTable       = 'tblcomicategoriacomercial';
$sJoin 				= [
	"left join tblcomistaff_assign on tblcomistaff_assign.commercial_category = tblcomicategoriacomercial.id",
	"left join tblcomiplanos on tblcomiplanos.categoria_comercial = tblcomicategoriacomercial.id",
	"left join tblcomicontratos on tblcomicontratos.categoria_comercial = tblcomicategoriacomercial.id"
];
$sWhere = ["where tblcomicategoriacomercial.country_id = ".$country_id];
$sGroupby = "group by tblcomicategoriacomercial.id, tblcomicategoriacomercial.detalle, tblcomistaff_assign.commercial_category, 
	tblcomiplanos.categoria_comercial, tblcomicontratos.categoria_comercial";

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, $sWhere, [], $sGroupby);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 2; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name') {
            $_data = '<a href="#" onclick="edit_commercial_category(this,' . $aRow['tblcomicategoriacomercial.id'] . '); return false;" data-name="' . $aRow['tblcomicategoriacomercial.detalle'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblcomicategoriacomercial', ['commercial_category' => $aRow['tblcomicategoriacomercial.id']]) . '</span>';
        }
        $row[] = $_data;
    }

    $options = icon_btn('#', 'pencil-square-o', 'btn-default '.$aRow["if((tblcomistaff_assign.commercial_category is null)&&(tblcomiplanos.categoria_comercial is null)&&(tblcomicontratos.categoria_comercial is null),'','disabled')"], ['onclick' => 'edit_commercial_category(this,' . $aRow['tblcomicategoriacomercial.id'] . '); return false;', 'data-name' => $aRow['tblcomicategoriacomercial.detalle']]);
    $row[]   = $options .= icon_btn('commissions/delete_commercial_category/' . $aRow['tblcomicategoriacomercial.id'], 'remove', 'btn-danger _delete '.$aRow["if((tblcomistaff_assign.commercial_category is null)&&(tblcomiplanos.categoria_comercial is null)&&(tblcomicontratos.categoria_comercial is null),'','disabled')"]);

    $output['aaData'][] = $row;
}
