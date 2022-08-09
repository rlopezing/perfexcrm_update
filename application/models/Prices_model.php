<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prices_model extends CRM_Model {
	
  public function __construct()
  {
    parent::__construct();
  }

  /**
  * Add new price
  * @param mixed $data All $_POST data
  */
  public function add($data)
  {
    $this->db->insert('tblsimufinished', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Prices Added [' . $data['detalle'] . ']');
      
      return $insert_id;
    }

    return false;
  }

  /**
   * Edit price
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('tblsimufinished', $data);
      if ($this->db->affected_rows() > 0) {
        logActivity('Prices Updated [' . $data['detalle'] . ', ID:' . $id . ']');
        
        return true;
      }

      return false;
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get price object based on passed id if not passed id return array of all prices
   */
  public function get($id = '')
  {
    if (is_numeric($id)) {
      $this->db->where('id', $id);

      return $this->db->get('tblsimufinished')->row();
    }

    if (!$rate && !is_array($rate)) {
      $rate = $this->db->get('tblsimufinished')->result_array();
    }

    return $rate;
  }

  /**
   * @param  integer ID
   * @return mixed
   * Delete price from database, if used return array with key referenced
   */
  public function delete($id)
  {
/*  if (is_reference_in_table('id', 'tblsimurate', $id)) {
    	return ['referenced' => true,];
		}
*/        
    $this->db->where('id', $id);
    $this->db->delete('tblsimufinished');
    if ($this->db->affected_rows() > 0) {
      logActivity('Prices Deleted [' . $id . ']');

      return true;
    }

    return false;
  }

}
