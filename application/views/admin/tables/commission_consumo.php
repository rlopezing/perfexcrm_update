<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	$this->ci->load->model('currencies_model');
	$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

	$aColumns = [
		'tblcomiplanosconsumos.id',
		"(if(tblcomiplanoscostos.consumo is null,'','disabled')) as valida",
	  'tblcomiplanosconsumos.id',
	  'tblcomiplanosconsumos.plano',
		'tblcomiplanosconsumos.anual',
		'tblcomiplanosconsumos.mensual',
	  'tblcomiplanosconsumos.limite_inferior',
	  'tblcomiplanosconsumos.limite_superior'
	];
	$sIndexColumn = 'id';
	$sTable       = 'tblcomiplanosconsumos';
	$sJoin 				= [
		'inner join tblcomiplanos on tblcomiplanos.id = tblcomiplanosconsumos.plano',
		"left join tblcomiplanoscostos on tblcomiplanoscostos.consumo = tblcomiplanosconsumos.id"	
	];
	$sWhere  			= ['where tblcomiplanosconsumos.plano = '.$plan];
	$sGroup 			= "group by tblcomiplanosconsumos.id, tblcomiplanosconsumos.plano, tblcomiplanosconsumos.anual, tblcomiplanosconsumos.mensual, tblcomiplanosconsumos.limite_inferior, tblcomiplanosconsumos.limite_superior, tblcomiplanoscostos.consumo";

	$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $sJoin, $sWhere, [], $sGroup);
	$output  = $result['output'];
	$rResult = $result['rResult'];
	
	foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 2; $i < count($aColumns); $i++) {
      $_data = $aRow[$aColumns[$i]];
	    $row[] = $_data;
    }
    
    $url = admin_url('Commission_plans');
    $icon_btn = '<a href="#" class="btn btn-default _new btn-icon" onclick="costos(this,'.$aRow['tblcomiplanosconsumos.id'].'); return false;" name="'.$url.'=/='.$plan.'=/='.$aRow['tblcomiplanosconsumos.anual'].'=/='.$aRow['tblcomiplanosconsumos.mensual'].'=/='.$aRow['tblcomiplanosconsumos.limite_inferior'].'=/='.$aRow['tblcomiplanosconsumos.limite_superior'].'"><i class="fa fa-archive"></i></a>';
    
    $row[] = $icon_btn . '<a href="#" class="btn btn-danger _delete btn-icon "'.$aRow["valida"].' onclick="delete_commission_consumo(this,'.$aRow['tblcomiplanosconsumos.id'].'); return false;" name="'.$url.'=/='.$plan.'"><i class="fa fa-remove"></i></a>';
    
    $output['aaData'][] = $row;
	}
?>