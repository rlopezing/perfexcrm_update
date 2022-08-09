<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'tblcominivelprecio.id',
	'tblcominivelprecio.tarifa',
	'tblcominivelprecio.comercializador',
	"if ((tblcomicontratos.nivel_precios is null)&&(tblcomiplanoscostos.nivel_precio is null),'','disabled')",
	'tblcominivelprecio.id',
  'tblcominivelprecio.detalle',
  'tblcomicomercializador.nombre',
  'tblcomitarifa.descripcion'
];
$sIndexColumn = 'id';
$sTable       = 'tblcominivelprecio';
$join = [
	'inner join tblcomicomercializador on tblcomicomercializador.id = tblcominivelprecio.comercializador',
	'inner join tblcomitarifa on tblcomitarifa.id = tblcominivelprecio.tarifa',
	"left join tblcomicontratos on tblcomicontratos.nivel_precios = tblcominivelprecio.id",
	"left join tblcomiplanoscostos on tblcomiplanoscostos.nivel_precio = tblcominivelprecio.id"
];
$sWhere = ["where tblcominivelprecio.country_id = ".$country_id." and tblcominivelprecio.module_id = ".$module_id];
$sGroupby = "group by tblcominivelprecio.tarifa, tblcominivelprecio.comercializador, tblcominivelprecio.id, tblcominivelprecio.detalle,
  tblcomicomercializador.nombre, tblcomitarifa.descripcion, tblcomicontratos.nivel_precios, tblcomiplanoscostos.nivel_precio";

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $sWhere, [], $sGroupby);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 4; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name') {
          $_data = '<a href="#" onclick="edit_nivel_precios(this,'.$aRow['id'].'); return false;" data-name="'.$aRow['tblcominivelprecio.detalle'].'">'.$_data.'</a> '.'<span class="badge pull-right">'.total_rows('tblcominivelprecio',['price_level' => $aRow['id']]).'</span>';
        }
        $row[] = $_data;
    }
	
		$data_name = $aRow['tblcominivelprecio.detalle'].'=/='.$aRow['tblcominivelprecio.comercializador'].'=/='.$aRow['tblcominivelprecio.tarifa'];
    $options = icon_btn('#', 'pencil-square-o', 'btn-default '.$aRow["if ((tblcomicontratos.nivel_precios is null)&&(tblcomiplanoscostos.nivel_precio is null),'','disabled')"], ['onclick' => 'edit_nivel_precios(this,' . $aRow['tblcominivelprecio.id'] . '); return false;', 'data-name'=>$data_name]);
    $row[]   = $options .= icon_btn('commissions/delete_price_level/' . $aRow['tblcominivelprecio.id'], 'remove', 'btn-danger _delete '.$aRow["if ((tblcomicontratos.nivel_precios is null)&&(tblcomiplanoscostos.nivel_precio is null),'','disabled')"]);

    $output['aaData'][] = $row;
}
