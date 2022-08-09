<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Price_table_model extends CRM_Model {
	
  public function __construct()
  {
    parent::__construct();
  }

  /**
  * Add new price head table
  * @param mixed $data All $_POST data
  */
  public function add_head($data)
  {
    $this->db->insert('tblsimuheadpricetable', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New price table head Added [' . $data['modality'] . ']');
      
      return $insert_id;
    }

    return false;
  }

  /**
   * Edit price table head
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_head($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('tblsimuheadpricetable', $data);
      if ($this->db->affected_rows() > 0) {
        logActivity('Price head table Updated [' . $data['modality'] . ', ID:' . $id . ']');
        
        return true;
      }

      return false;
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get price table head object based on passed id if not passed id return array of all price table head
   */
  public function get_head($id='',$marketer='')
  {
    if (is_numeric($id)) {
    	$this->db->select('tblsimuheadpricetable.id, tblsimuheadpricetable.modality, tblsimutyperates.detalle, tblsimuheadpricetable.finished');
    	$this->db->from('tblsimuheadpricetable');
    	$this->db->join('tblsimutyperates', 'tblsimutyperates.id = tblsimuheadpricetable.modality');
      $this->db->where('tblsimuheadpricetable.id', $id);

      return $this->db->get()->row();
    }

    if (!$rate && !is_array($rate)) {
    	$this->db->select("concat(tblsimuheadpricetable.id,'-',tblsimuheadpricetable.modality) as id , tblsimutyperates.detalle, tblsimuheadpricetable.finished");
    	$this->db->from('tblsimuheadpricetable');
    	$this->db->join('tblsimutyperates', 'tblsimutyperates.id = tblsimuheadpricetable.modality');
    	if (is_numeric($marketer)) $this->db->where('tblsimuheadpricetable.marketer', $marketer);
    	
      $rate = $this->db->get()->result_array();
    }

    return $rate;
  }

  /**
   * @param  integer ID
   * @return mixed
   * Delete price table head from database, if used return array with key referenced
   */
  public function delete_head($id)
  {
/*  if (is_reference_in_table('id', 'tblsimurate', $id)) {
    	return ['referenced' => true,];
		}
*/        
    $this->db->where('id', $id);
    $this->db->delete('tblsimuheadpricetable');
    if ($this->db->affected_rows() > 0) {
      logActivity('Price table head Deleted [' . $id . ']');

      return true;
    }

    return false;
  }
  
  /**
  * Add new price detail
  * @param mixed $data All $_POST data
  */
  public function add_detail($data)
  {
    $this->db->insert('tblsimudetpricetable', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New detail Added [' . $data['modality'] . ']');
      return $insert_id;
    }

    return false;
  }

  /**
   * Edit price detail
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_detail($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('tblsimudetpricetable', $data);
      if ($this->db->affected_rows() > 0) {
        logActivity('Price detail Updated [' . $data['modality'] . ', ID:' . $id . ']');
        
        return true;
      }

      return false;
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get price detail object based on passed id if not passed id return array of all price detail
   */
  public function get_detail($id='')
  {
    if (is_numeric($id)) {
    	$this->db->select('id, marketer, headpricetable, rate, hiredpotency, columnprice1, columnprice2, columnprice3, columnprice4, columnprice5, columnprice6');
    	$this->db->from('tblsimudetpricetable');
      $this->db->where('id', $id);

      return $this->db->get()->row();
    }

    if (!$rate && !is_array($rate)) {
    	$this->db->select("id, marketer, headpricetable, rate, hiredpotency, columnprice1, columnprice2, columnprice3, columnprice4, columnprice5, columnprice6");
    	$this->db->from('tblsimudetpricetable');
    	
      $rate = $this->db->get()->result_array();
    }

    return $rate;
  }

  /**
   * @param  integer ID
   * @return mixed
   * Delete price detail from database, if used return array with key referenced
   */
  public function delete_detail($id)
  {
/*  if (is_reference_in_table('id', 'tblsimurate', $id)) {
    	return ['referenced' => true,];
		}
*/        
    $this->db->where('id', $id);
    $this->db->delete('tblsimudetpricetable');
    if ($this->db->affected_rows() > 0) {
      logActivity('Price detail Deleted [' . $id . ']');

      return true;
    }

    return false;
  }
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get price detail
   */
   public function get_detail_rate($rate='',$finished='') {
  		$strsql = 'tblsimudetpricetable.marketer, columnprice1, columnprice2, columnprice3, columnprice4, columnprice5, columnprice6';
  		$this->db->select($strsql);
  		$this->db->from('tblsimudetpricetable');
  		$this->db->join('tblsimuheadpricetable','tblsimuheadpricetable on tblsimuheadpricetable.id = tblsimudetpricetable.headpricetable','inner');
		$this->db->where('tblsimudetpricetable.rate', $rate);
		$this->db->where('tblsimuheadpricetable.finished', $finished);
   	$detail_rate = $this->db->get()->row_array();
		
   	return $detail_rate;
   }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get the best rate.
   */
	public function get_best_rate($data='') {
		$init_potency = $data['total_potency'];
		$init_energy = $data['total_energy'];
		
		$marketer_savings = '';
		$rate = '';
  		
  	///// Análisis de precios termino de potencia.
  	$this->db->select('tblsimudetpricetable.marketer,tblsimudetpricetable.columnprice1,tblsimudetpricetable.columnprice2,tblsimudetpricetable.columnprice3,tblsimudetpricetable.columnprice4,tblsimudetpricetable.columnprice5,tblsimudetpricetable.columnprice6,tblsimutyperates.detalle');
		$this->db->from('tblsimudetpricetable');
		$this->db->join('tblsimuheadpricetable','tblsimuheadpricetable.id = tblsimudetpricetable.headpricetable');
		$this->db->join('tblsimutyperates','tblsimuheadpricetable.modality = tblsimutyperates.id');
   	$this->db->where('tblsimudetpricetable.rate', $data['rate']);
   	$this->db->where('tblsimuheadpricetable.finished', 1);
   	
    $detail_rate = $this->db->get()->result_array();
    	
    $total_potency = 0;
	  foreach ($detail_rate as $row) {
	   	if (floatval($data['consumo_potencia1'])>0) $total_potency+=floatval($row["columnprice1"])*floatval($data['consumo_potencia1']);
	   	if (floatval($data['consumo_potencia2'])>0) $total_potency+=floatval($row["columnprice2"])*floatval($data['consumo_potencia2']);
	   	if (floatval($data['consumo_potencia3'])>0) $total_potency+=floatval($row["columnprice3"])*floatval($data['consumo_potencia3']);
	   	if (floatval($data['consumo_potencia4'])>0) $total_potency+=floatval($row["columnprice4"])*floatval($data['consumo_potencia4']);
	   	if (floatval($data['consumo_potencia5'])>0) $total_potency+=floatval($row["columnprice5"])*floatval($data['consumo_potencia5']);
	   	if (floatval($data['consumo_potencia6'])>0) $total_potency+=floatval($row["columnprice6"])*floatval($data['consumo_potencia6']);
   		$data['total_potency'] = $total_potency;
   		$marketer_savings = $row["marketer"];
   		$rate = $row["detalle"];
		}
    
	  ///// Análisis de precios termino de energía.
  	$this->db->select('tblsimudetpricetable.marketer,tblsimudetpricetable.columnprice1,tblsimudetpricetable.columnprice2,tblsimudetpricetable.columnprice3,tblsimudetpricetable.columnprice4,tblsimudetpricetable.columnprice5,tblsimudetpricetable.columnprice6,tblsimutyperates.detalle');
  	$this->db->from('tblsimudetpricetable');
  	$this->db->join('tblsimuheadpricetable','tblsimuheadpricetable.id = tblsimudetpricetable.headpricetable');
  	$this->db->join('tblsimutyperates','tblsimuheadpricetable.modality = tblsimutyperates.id');
   	$this->db->where('tblsimudetpricetable.rate', $data['rate']);
   	$this->db->where('tblsimuheadpricetable.finished', 2);
    
	  $detail_rate = $this->db->get()->result_array();
	   
	  $total_energy = 0;
	  foreach ($detail_rate as $row) {
	   	if (floatval($data['consumo_energia1'])>0) $total_energy+=floatval($row["columnprice1"])*floatval($data['consumo_energia1']);
	   	if (floatval($data['consumo_energia2'])>0) $total_energy+=floatval($row["columnprice2"])*floatval($data['consumo_energia2']);
	   	if (floatval($data['consumo_energia3'])>0) $total_energy+=floatval($row["columnprice3"])*floatval($data['consumo_energia3']);
	   	if (floatval($data['consumo_energia4'])>0) $total_energy+=floatval($row["columnprice4"])*floatval($data['consumo_energia4']);
	   	if (floatval($data['consumo_energia5'])>0) $total_energy+=floatval($row["columnprice5"])*floatval($data['consumo_energia5']);
	   	if (floatval($data['consumo_energia6'])>0) $total_energy+=floatval($row["columnprice6"])*floatval($data['consumo_energia6']);
   		$data['total_energy'] = $total_energy;
   		$marketer_savings = $row["marketer"];
   		$rate = $row["detalle"];
		}
		
		$data['total_potency']=floatval($init_potency)-floatval($data['total_potency']);
		$data['total_energy']=floatval($init_energy)-floatval($data['total_energy']);
		$total_savings = $data['total_potency'] + $data['total_energy'];
		
		$pos = strpos($rate, "POTENCIA");
		if ($pos === false) $rate = $rate; else $rate = substr($rate, 0, $pos-1);
		$pos = strpos($rate, "ENERGIA");
		if ($pos === false) $rate = $rate; else $rate = substr($rate, 0, $pos-1);
		
		$marketer = $this->db->query("select nombre from tblcomicomercializador where id = ".$marketer_savings.";");
		foreach ($marketer->result_array() as $marketer) { 
			$marketer_savings=$marketer["nombre"]; 
		}
		
		$message = '';
		if ($total_savings > 0) {
			$message='Existe una mejor tarifa: '.$rate;
		} else {
			$message='No existe mejor tarifa';
		}
		
		$data['total_potency']=format_money($data['total_potency']);
		$data['total_energy']=format_money($data['total_energy']);
		$total_savings=format_money($total_savings);
		
		$best_rate = array(
			'message'=>$message,
			'savings_potency'=>$data['total_potency'],
			'savings_energy'=>$data['total_energy'],
			'total_savings'=>$total_savings,
			'marketer_savings'=>$marketer_savings
		);
		
   	return $best_rate;
	}
	
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get the best rate gas.
   */
	public function get_best_rate_gas($data='') {
		$init_fijo = $data['total_termino_fijo'];
		$init_variable = $data['total_termino_variable'];
		
		$marketer_savings = '';
		$rate = '';
		
		///// Análisis de precios termino fijo.
		$this->db->select('tblsimudetpricetable.marketer, tblsimudetpricetable.columnprice1, tblsimutyperates.detalle');
		$this->db->from('tblsimudetpricetable');
		$this->db->join('tblsimuheadpricetable','tblsimuheadpricetable.id = tblsimudetpricetable.headpricetable');
		$this->db->join('tblsimutyperates','tblsimuheadpricetable.modality = tblsimutyperates.id');
   	$this->db->where('tblsimudetpricetable.rate', $data['rate']);
   	$this->db->where('tblsimuheadpricetable.finished', 3);
    $detail_rate = $this->db->get()->result_array();
    	
    $total_fijo = 0;
	  foreach ($detail_rate as $row) {
	   	if (floatval($data['dias_ano'])>0) $total_fijo+=floatval($row["columnprice1"])*floatval($data['dias_ano']);
   		$data['total_termino_fijo'] = $total_fijo;
   		$marketer_savings = $row["marketer"];
   		$rate = $row["detalle"];
		}
    
	  ///// Análisis de precios termino variable.
		$this->db->select('tblsimudetpricetable.marketer, tblsimudetpricetable.columnprice1, tblsimutyperates.detalle');
		$this->db->from('tblsimudetpricetable');
		$this->db->join('tblsimuheadpricetable','tblsimuheadpricetable.id = tblsimudetpricetable.headpricetable');
		$this->db->join('tblsimutyperates','tblsimuheadpricetable.modality = tblsimutyperates.id');
   	$this->db->where('tblsimudetpricetable.rate', $data['rate']);
   	$this->db->where('tblsimuheadpricetable.finished', 4);
	  $detail_rate = $this->db->get()->result_array();
	   
	  $total_variable = 0;
	  foreach ($detail_rate as $row) {
	   	if (floatval($data['consumo'])>0) $total_variable+=floatval($row["columnprice1"])*floatval($data['consumo']);
   		$data['total_termino_variable'] = $total_variable;
   		$marketer_savings = $row["marketer"];
   		$rate = $row["detalle"];
		}
		
		$data['total_termino_fijo']=floatval($init_fijo)-floatval($data['total_termino_fijo']);
		$data['total_termino_variable']=floatval($init_variable)-floatval($data['total_termino_variable']);
		$total_savings = $data['total_termino_fijo'] + $data['total_termino_variable'];
		
		$pos = strpos($rate, "TÉRMINO FIJO");
		if ($pos === false) $rate = $rate; else $rate = substr($rate, 0, $pos-1);
		$pos = strpos($rate, "TÉRMINO VARIABLE");
		if ($pos === false) $rate = $rate; else $rate = substr($rate, 0, $pos-1);
		
		$marketer = $this->db->query("select nombre from tblcomicomercializador where id = ".$marketer_savings.";");
		foreach ($marketer->result_array() as $marketer) {
			$marketer_savings=$marketer["nombre"]; 
		}
		
		$message = '';
		if ($total_savings>0) {
			$message='Existe una mejor tarifa: '.$rate;
		} else {
			$message='No existe mejor tarifa';
		}
		
		$data['total_termino_fijo']=format_money($data['total_termino_fijo']);
		$data['total_termino_variable']=format_money($data['total_termino_variable']);
		$total_savings=format_money($total_savings);
		
		$best_rate = array(
			'message'=>$message,
			'savings_fijo'=>$data['total_termino_fijo'],
			'savings_variable'=>$data['total_termino_variable'],
			'total_savings'=>$total_savings,
			'marketer_savings'=>$marketer_savings
		);
		
   	return $best_rate;
	}
  
}
