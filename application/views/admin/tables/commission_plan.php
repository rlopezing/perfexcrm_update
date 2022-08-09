<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	$this->ci->load->model('currencies_model');
	$baseCurrencySymbol = $this->ci->currencies_model->get_base_currency()->symbol;

	$aColumns = [
		'tblcomiplanos.id',
		'tblcomicomercializador.id',
		'tblcomicategoriacomercial.id',
		"if(tblcomiplanosconsumos.plano is null,'','disabled')",
		'tblcomitarifa.id',
		'tblcomiplanos.id',
	  'tblcomicomercializador.nombre',
	  'tblcomicategoriacomercial.detalle',
	  'tblcomitarifa.descripcion',
	  'tblcountries.short_name',
	];
	$sIndexColumn = 'id';
	$sTable       = 'tblcomiplanos';
	$join = [
		'inner join tblcomicomercializador on tblcomicomercializador.id = tblcomiplanos.comercializador',
		'inner join tblcomicategoriacomercial on tblcomicategoriacomercial.id = tblcomiplanos.categoria_comercial',
		'inner join tblcomitarifa on tblcomitarifa.id = tblcomiplanos.tarifa',
		'left join tblcomiplanosconsumos on tblcomiplanosconsumos.plano = tblcomiplanos.id',
		'inner join tblcountries on tblcountries.country_id = tblcomiplanos.country_id',
	];
	$sWhere = ["where tblcomiplanos.country_id = ".$country_id." and tblcomiplanos.module_id = ".$module_id];
	$sGroupby = "group by tblcomicomercializador.id, tblcomicategoriacomercial.id, tblcomitarifa.id, tblcomiplanos.id, tblcomicomercializador.nombre, tblcomicategoriacomercial.detalle, tblcomitarifa.descripcion, tblcomiplanosconsumos.plano";

	$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $sWhere, [], $sGroupby);
	$output  = $result['output'];
	$rResult = $result['rResult'];
	
	$url = admin_url('commission_plans/consumos');
	foreach ($rResult as $aRow) {
    $row = [];
    $ids = $aRow['tblcomicomercializador.id'].' '.$aRow['tblcomicategoriacomercial.id'] .' '.$aRow['tblcomitarifa.id'];
    for ($i = 6; $i < count($aColumns); $i++) {
      $_data = $aRow[$aColumns[$i]];
      if ($aColumns[$i] == 'tblcomicomercializador.nombre') {
        $_data = '<a href="#" name="'.$url.'=/='.$aRow['tblcomicomercializador.nombre'].'=/='.$aRow['tblcomicategoriacomercial.detalle'].'=/='.$aRow['tblcomitarifa.descripcion'].'=/='.$ids.'" onclick="commission_consumos(this,'.$aRow['tblcomiplanos.id'].'); return false;">'.$_data.'</a>';
      }
	      
	    $row[] = $_data;
    }
    
		$row[] = icon_btn('commission_plans/delete/'.$aRow['tblcomiplanos.id'], 'remove', 'btn-danger _delete '.$aRow["if(tblcomiplanosconsumos.plano is null,'','disabled')"]);	
    
    $output['aaData'][] = $row;
	}
?>