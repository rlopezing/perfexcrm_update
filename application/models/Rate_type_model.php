<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate_type_model extends CRM_Model {
	
  public function __construct()
  {
    parent::__construct();
  }

  /**
  * Add new rate type
  * @param mixed $data All $_POST data
  */
  public function add($data)
  {
    $this->db->insert('tblsimutyperates', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Rate Type Added [' . $data['detalle'] . ']');
      
      return $insert_id;
    }

    return false;
  }

  /**
   * Edit rate type
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update($data, $id)
  {
      $this->db->where('id', $id);
      $this->db->update('tblsimutyperates', $data);
      if ($this->db->affected_rows() > 0) {
        logActivity('Rate Type Updated [' . $data['detalle'] . ', ID:' . $id . ']');
        
        return true;
      }

      return false;
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get rate type object based on passed id if not passed id return array of all rate type
   */
  public function get($id='')
  {
    if (is_numeric($id)) {
      $this->db->where('id', $id);

      return $this->db->get('tblsimutyperates')->row();
    }

    if (!$rate && !is_array($rate)) {
      $rate = $this->db->get('tblsimutyperates')->result_array();
    }

    return $rate;
  }

  /**
   * @param  integer ID
   * @return mixed
   * Delete rate type from database, if used return array with key referenced
   */
  public function delete($id)
  {
/*  if (is_reference_in_table('id', 'tblsimurate', $id)) {
    	return ['referenced' => true,];
		}
*/        
    $this->db->where('id', $id);
    $this->db->delete('tblsimutyperates');
    if ($this->db->affected_rows() > 0) {
      logActivity('Rate Type Deleted [' . $id . ']');

      return true;
    }

    return false;
  }

}
