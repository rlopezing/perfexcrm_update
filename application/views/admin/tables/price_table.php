<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
	'tblsimudetpricetable.id',
  'tblsimudetpricetable.headpricetable',
  'tblsimudetpricetable.rate',
  'tblsimudetpricetable.hiredpotency',
  'tblcomitarifa.descripcion',
  'tblsimuhiredpotency.detalle',
  'tblsimudetpricetable.columnprice1',
  'tblsimudetpricetable.columnprice2',
  'tblsimudetpricetable.columnprice3',
  'tblsimudetpricetable.columnprice4',
  'tblsimudetpricetable.columnprice5',
  'tblsimudetpricetable.columnprice6',
];

$sIndexColumn = 'id';
$sTable       = 'tblsimudetpricetable';
$sJoin = [
	'inner join tblsimuheadpricetable on tblsimuheadpricetable.id = tblsimudetpricetable.headpricetable',
	'inner join tblsimuhiredpotency on tblsimuhiredpotency.id = tblsimudetpricetable.hiredpotency',
	'inner join tblcomitarifa on tblcomitarifa.id = tblsimudetpricetable.rate'
];

//log_message('debug', "rate_id:".print_r($rate_id, TRUE));
//log_message('debug', "marketer_id".print_r($marketer_id, TRUE));

if ($rate_id == '') {
	$headpricetable = '0'; 
} else {
	$headpricetable = explode("-", $rate_id)[0];
}
if ($marketer_id == '') $marketer_id = '0';
$sWhere = ['where tblsimudetpricetable.headpricetable = '.$headpricetable.' and tblsimudetpricetable.marketer = '.$marketer_id];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, $sWhere);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 4; $i < count($aColumns); $i++) {
      $_data = $aRow[$aColumns[$i]];
      if ($aColumns[$i] == 'tblcomitarifa.descripcion') {
        $_data = '<a href="#" onclick="edit_prices(this,' . $aRow['tblsimudetpricetable.id'] . '); return false;" data-name="' . $aRow['tblcomitarifa.descripcion'] . '">' . $_data . '</a> ' . '<span class="badge pull-right">' . total_rows('tblsimudetpricetable', ['id' => $aRow['tblsimudetpricetable.id']]) . '</span>';
      }
      $row[] = $_data;
    }
		
		$data_name = $aRow['tblcomitarifa.descripcion'];
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['onclick' => 'edit_prices(this,' . $aRow['tblsimudetpricetable.id'] . '); return false;', 'data-name' => $data_name]);
    $row[] = $options .= icon_btn('simulators/delete_price_table/' . $aRow['tblsimudetpricetable.id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
