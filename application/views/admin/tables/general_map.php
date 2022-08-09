<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('currencies_model');
$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

$aColumns = [
  'tblcomicontratos.id',
  'tblcomicontratos.nif',
  'tblclients.company',
  'tblcomicontratos.cpe', 
  'tblcominiveltension.nombre', 
  'tblcomicontratos.potencia_contratada', 
  'tblcomicontratos.consumo_anual',
	'tblcomicomercializador.nombre', 
	'tblcomitarifa.descripcion', 
	'tblcominivelprecio.detalle', 
	'tblcomicontratos.fecha_suscripcion',
  'tblcomicontratos.fecha_envio', 
  'tblcomicontratos.fecha_inicio_suministro', 
  'tblcomicontratos.fecha_fin_suministro', 
  'tblcomicontratos.fecha_comerciante', 
  'tblcomicontratos.fecha_pago', 
  'tblcomicategoriacomercial.detalle', 
  'socio.nombre_socio', 
  'comercial.nombre_comercial', 
  'tblcomicontratos.valor_contrato', 
  'tblcomicontratos.comision_socio', 
  'tblcomicontratos.comision_comercial', 
  'tblcomicontratos.valor_contrato'
];

$sIndexColumn = 'id';
$sTable       = 'tblcomicontratos';

$join = [
	"left join tblclients on tblclients.userid = tblcomicontratos.cliente",
	"left join tblcominiveltension on tblcominiveltension.id = tblcomicontratos.nivel_tension",
	"left join tblcomicomercializador on tblcomicomercializador.id = tblcomicontratos.comercializador",
	"left join tblcomitarifa on tblcomitarifa.id = tblcomicontratos.tarifa",
	"left join tblcominivelprecio on tblcominivelprecio.id = tblcomicontratos.nivel_precios",
	"left join tblcomicategoriacomercial on tblcomicategoriacomercial.id = tblcomicontratos.categoria_comercial",
	"left join (select tblstaff.staffid as id, concat(tblstaff.firstname,' ',tblstaff.lastname) as nombre_socio from tblstaff inner join tblstaff_departments on tblstaff_departments.staffid = tblstaff.staffid) as socio on socio.id = tblcomicontratos.socio",
	"left join (select tblstaff.staffid as id, concat(tblstaff.firstname,' ',tblstaff.lastname) as nombre_comercial from tblstaff inner join tblstaff_departments on tblstaff_departments.staffid = tblstaff.staffid) as comercial on comercial.id = tblcomicontratos.comercial"
];

if ($fdesde != '' && $fhasta != '') {
	$where = ["where date_format(tblcomicontratos.dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."'"];	
	$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);
} else {
	$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], []);	
}

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
  $row = [];
  
  for ($i = 0; $i < count($aColumns); $i++) {
  	$_data = $aRow[$aColumns[$i]];

  	if ($aColumns[$i] == 'socio.nombre_socio') $_data = $aRow['nombre_socio'];
  	if ($aColumns[$i] == 'comercial.nombre_comercial') $_data = $aRow['nombre_comercial'];
  	
  	if ($aColumns[$i] == 'tblcomicontratos.fecha_suscripcion') $_data = _d(date("d-m-Y", strtotime($_data)));
  	if ($aColumns[$i] == 'tblcomicontratos.fecha_envio') $_data = _d(date("d-m-Y", strtotime($_data)));
  	if ($aColumns[$i] == 'tblcomicontratos.fecha_inicio_suministro') $_data = _d(date("d-m-Y", strtotime($_data)));
  	if ($aColumns[$i] == 'tblcomicontratos.fecha_fin_suministro') $_data = _d(date("d-m-Y", strtotime($_data)));
  	if ($aColumns[$i] == 'tblcomicontratos.fecha_comerciante') $_data = _d(date("d-m-Y", strtotime($_data)));
  	if ($aColumns[$i] == 'tblcomicontratos.fecha_pago') $_data = _d(date("d-m-Y", strtotime($_data)));
  	
  	if ($aColumns[$i] == 'tblcomicontratos.valor_contrato') $_data = format_money($_data, $baseCurrencySymbol);
  	if ($aColumns[$i] == 'tblcomicontratos.comision_socio') $_data = format_money($_data, $baseCurrencySymbol);
  	if ($aColumns[$i] == 'tblcomicontratos.comision_comercial') $_data = format_money($_data, $baseCurrencySymbol);
  	if ($aColumns[$i] == 'tblcomicontratos.comision_emsconsulting') $_data = format_money($_data, $baseCurrencySymbol);
  	
    $row[] = $_data;
  }

  $output['aaData'][] = $row;
}
?>