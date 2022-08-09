<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	$this->ci->load->model('currencies_model');
	$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

	$consumo = $_SESSION['consumo'];

	$aColumns = [
	  'tblcomiplanoscostos.id',
	  'tblcomiplanoscostos.consumo',
		'tblcomiplanoscostos.nivel_precio',
		'tblcominivelprecio.detalle',
		'tblcomiplanoscostos.comision'
	];

	$sIndexColumn = 'id';
	$sTable       = 'tblcomiplanoscostos';
	$join 				= ['inner join tblcominivelprecio on tblcominivelprecio.id = tblcomiplanoscostos.nivel_precio'];
	$where 				= ['where tblcomiplanoscostos.consumo = '.$consumo];

	$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);
	$output  = $result['output'];
	$rResult = $result['rResult'];
	
	foreach ($rResult as $aRow) {
    $row = [];
    
    for ($i = 0; $i < count($aColumns); $i++) {
	    $_data = $aRow[$aColumns[$i]];
	    $row[] = $_data;
    }
    
    $url = admin_url('Commission_plans');
    $icon_btn = '<a href="#" class="btn btn-danger _delete btn-icon" onclick="delete_commission_costo(this,'.$aRow['tblcomiplanoscostos.id'].'); return false;" name="'.$url.'=/='.$consumo.'"><i class="fa fa-remove"></i></a>';
    
    $row[] = $icon_btn;
    
    $output['aaData'][] = $row;
	}
	
?>