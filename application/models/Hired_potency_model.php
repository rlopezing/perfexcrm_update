<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hired_potency_model extends CRM_Model {
	
  public function __construct()
  {
    parent::__construct();
  }

  /**
  * Add new hired potency
  * @param mixed $data All $_POST data
  */
  public function add($data)
  {
    $this->db->insert('tblsimuhiredpotency', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Hired Potency Added [' . $data['detalle'] . ']');
      
      return $insert_id;
    }

    return false;
  }

  /**
   * Edit hired potency
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('tblsimuhiredpotency', $data);
      if ($this->db->affected_rows() > 0) {
        logActivity('Rate Updated [' . $data['detalle'] . ', ID:' . $id . ']');
        
        return true;
      }

      return false;
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get hired potency object based on passed id if not passed id return array of all hired potencys
   */
  public function get($id = '')
  {
    if (is_numeric($id)) {
      $this->db->where('id', $id);

      return $this->db->get('tblsimuhiredpotency')->row();
    }

    if (!$rate && !is_array($rate)) {
      $rate = $this->db->get('tblsimuhiredpotency')->result_array();
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
    $this->db->delete('tblsimuhiredpotency');
    if ($this->db->affected_rows() > 0) {
      logActivity('Hired Potency Deleted [' . $id . ']');

      return true;
    }

    return false;
  }

}
