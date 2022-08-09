<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Commission_plan_model extends CRM_Model
{
  public function __construct()
  {
    parent::__construct();
  }
    
  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new plan
   */
  public function add($data)
  {
    $this->db->insert('tblcomiplanos', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      return $insert_id;
    }

    return false;
  }

  /**
   * @param  array $_POST data
   * @param  integer Plan ID
   * @return boolean
   */
  public function update($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('tblcomiplanos', $data);
    if ($this->db->affected_rows() > 0) {
      return true;
    }
    if ($affectedRows > 0) {
      return true;
    }

    return false;
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete commission plan from database, if used return array with key referenced
   */
  public function delete($id)
  {
  	
/*    $id      = do_action('before_delete_commission_plan', $id);
    $current = $this->get($id);
    if (is_reference_in_table('commission_plan', 'tbltickets', $id)) {
      return [
        'referenced' => true,
      ];
    }
    do_action('before_commission_plan_deleted', $id);
*/    
    $this->db->where('id', $id);
    $this->db->delete('tblcomiplanos');
    if ($this->db->affected_rows() > 0) {
      logActivity('Commission Plan Deleted [ID: ' . $id . ']');
      return true;
    }

    return false;
  }

  /**
   * @param  integer ID
   * @return mixed
   * validate commission plan from database
   * if validate = not exist
   * if not validate = exist
   */
  public function validate($data) {
    $this->db->where('comercializador', $data["comercializador"]);
    $this->db->where('categoria_comercial', $data["categoria_comercial"]);
    $this->db->where('tarifa', $data["tarifa"]);
    
    $count = count($this->db->get('tblcomiplanos'));
    $validate=TRUE;
    if ($count>0) $validate=FALSE;
    
    return $validate;
  }

  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new consumo
   */
  public function add_consumo($data) {
  	
  	$this->db->set('plano',$data['plano']);
  	$this->db->set('anual',$data['anual']);
  	$this->db->set('mensual',$data['mensual']);
  	$this->db->set('limite_inferior',$data['limite_inferior']);
  	$this->db->set('limite_superior',$data['limite_superior']);
    $this->db->insert('tblcomiplanosconsumos');
    $insert_id = $this->db->insert_id();
    if ($insert_id) return $insert_id;

    return false;
  }

  /**
   * @param  array $_POST data
   * @param  integer Plan ID
   * @return boolean
   */
  public function update_consumo($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('tblcomiplanosconsumos', $data);
    if ($this->db->affected_rows() > 0) {
      return true;
    }
    if ($affectedRows > 0) {
      return true;
    }

    return false;
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete consumo plan from database, if used return array with key referenced
   */
  public function delete_consumo($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('tblcomiplanosconsumos');
    if ($this->db->affected_rows() > 0) {
      logActivity('Commission Consumo Deleted [ID: ' . $id . ']');
      return true;
    }

    return false;
  }
  
  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new coste
   */
  public function add_costo($data)
  {
    $this->db->insert('tblcomiplanoscostos', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      return $insert_id;
    }

    return false;
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete coste plan from database, if used return array with key referenced
   */
  public function delete_costo($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('tblcomiplanoscostos');
    if ($this->db->affected_rows() > 0) {
      logActivity('Commission Coste Deleted [ID: ' . $id . ']');
      return true;
    }

    return false;
  }

}
