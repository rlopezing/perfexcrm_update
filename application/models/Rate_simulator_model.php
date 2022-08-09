<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate_simulator_model extends CRM_Model {
	
  public function __construct()
  {
    parent::__construct();
  }

  /**
  * Add new rate simulator
  * @param mixed $data All $_POST data
  */
  public function add($data)
  {
    $this->db->insert('tblsimurate', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New rate Added [' . $data['detalle'] . ']');
      
      return $insert_id;
    }

    return false;
  }

  /**
   * Edit rate simulator
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('tblsimurate', $data);
      if ($this->db->affected_rows() > 0) {
        logActivity('Rate Updated [' . $data['detalle'] . ', ID:' . $id . ']');
        
        return true;
      }

      return false;
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get rate object based on passed id if not passed id return array of all rates
   */
  public function get($id = '')
  {
    if (is_numeric($id)) {
      $this->db->where('id', $id);

      return $this->db->get('tblsimurate')->row();
    }

    $rate = $this->object_cache->get('simulator_rate');

    if (!$rate && !is_array($rate)) {
      $rate = $this->db->get('tblsimurate')->result_array();
      $this->object_cache->add('simulator_rate', $rate);
    }

    return $rate;
  }

  /**
   * @param  integer ID
   * @return mixed
   * Delete rate from database, if used return array with key referenced
   */
  public function delete($id)
  {
/*  if (is_reference_in_table('id', 'tblsimurate', $id)) {
    	return ['referenced' => true,];
		}
*/        
    $this->db->where('id', $id);
    $this->db->delete('tblsimurate');
    if ($this->db->affected_rows() > 0) {
      logActivity('Rate Deleted [' . $id . ']');

      return true;
    }

    return false;
  }

}
