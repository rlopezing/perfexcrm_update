<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	"tblcomicomercializador.id",
	"(if ((tblcominivelprecio.comercializador is null)&&(tblcomiplanos.comercializador is null)&&(tblcomicontratos.comercializador is null)&&(tblsimuheadpricetable.marketer is null)&&(tblsimudetpricetable.marketer is null),'','disabled')) as valida",
	"tblcomicomercializador.id",
  "tblcomicomercializador.nombre",
  "tblclients.company",
];
$sIndexColumn = 'id';
$sTable       = 'tblcomicomercializador';
$sJoin = [
	"left join tblclients on tblclients.userid = tblcomicomercializador.cliente",
	"left join tblcominivelprecio on tblcominivelprecio.comercializador = tblcomicomercializador.id",
	"left join tblcomiplanos on tblcomiplanos.comercializador = tblcomicomercializador.id",
	"left join tblcomicontratos on tblcomicontratos.comercializador = tblcomicomercializador.id",
	"left join tblsimuheadpricetable on tblsimuheadpricetable.marketer = tblcomicomercializador.id",
	"left join tblsimudetpricetable on tblsimudetpricetable.marketer = tblcomicomercializador.id"
];
$sGroup = 'group by tblcomicomercializador.id, tblcomicomercializador.nombre, tblsimuheadpricetable.marketer, tblsimudetpricetable.marketer';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, [], [], $sGroup);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 2; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'name') {
            $_data = '<a href="#" onclick="edit_comercializador(this,'.$aRow['tblcomicomercializador.id'].'); return false;" data-name="'.$aRow['tblcomicomercializador.nombre'].'">'.$_data.'</a> '.'<span class="badge pull-right">'.total_rows('tblcomicomercializador', ['contract_type' => $aRow['tblcomicomercializador.id']]).'</span>';
        }
        $row[] = $_data;
    }

		$dataname = $aRow['tblcomicomercializador.nombre']."*/*".$aRow['valida'];
    $options = icon_btn('#','pencil-square-o','btn-default',['onclick'=>'edit_comercializador(this,'.$aRow['tblcomicomercializador.id'].'); return false;','data-name'=>$dataname,'aria-disabled'=>'true']);
    $row[] = $options .= icon_btn('commissions/delete_marketer/' . $aRow['tblcomicomercializador.id'], 'remove', 'btn-danger _delete '.$aRow['valida']);

    $output['aaData'][] = $row;
}
