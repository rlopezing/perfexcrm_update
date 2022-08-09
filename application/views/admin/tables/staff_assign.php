<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
	'tblcomistaff_assign.id',
	'tblcomicategoriacomercial.id',
  'tblstaff.staffid',
  'tblstaff.email',
  "concat(tblstaff.firstname,' ',tblstaff.lastname)",
  "if(isnull(tblcomicategoriacomercial.detalle),'NO ASIGNADO',tblcomicategoriacomercial.detalle)",
  ];
$sIndexColumn = 'staffid';
$sTable       = 'tblstaff';
$join = [
	'left join tblcomistaff_assign on tblcomistaff_assign.staff = tblstaff.staffid',
	'left join tblcomicategoriacomercial on tblcomicategoriacomercial.id = tblcomistaff_assign.commercial_category'
];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], []);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
  $row = [];
  for ($i = 2; $i < count($aColumns); $i++) {
    $_data = $aRow[$aColumns[$i]];
    $row[] = $_data;
  }
    
  $data_name = $aRow['tblstaff.email']."*/*".$aRow["concat(tblstaff.firstname,' ',tblstaff.lastname)"]."*/*".$aRow['tblcomicategoriacomercial.id']."*/*".$aRow['tblstaff.staffid'];
  $row[] = icon_btn('#','check-square','btn-default', ['onclick' => 'staff_assign(this,'.$aRow['tblcomistaff_assign.id'].'); return false;','data-name'=>$data_name]);

  $output['aaData'][] = $row;
}
