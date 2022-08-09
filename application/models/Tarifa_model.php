<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Tarifa_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Add new tarifa
    * @param mixed $data All $_POST data
    */
    public function add($data)
    {
        $this->db->insert('tblcomitarifa', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New Tarifa Added [' . $data['descripcion'] . ']');

            return $insert_id;
        }

        return false;
    }

    /**
     * Edit rate
     * @param mixed $data All $_POST data
     * @param mixed $id rate id
     */
    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tblcomitarifa', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Rate Updated [' . $data['descripcion'] . ', ID:' . $id . ']');

            return true;
        }

        return false;
    }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get tarifa object based on passed id if not passed id return array of all tarifas
   */
  public function get($id='', $country='', $module='')
  {
    if (is_numeric($ids) && !is_numeric($country)) {
      $this->db->where('id', $id);

      return $this->db->get('tblcomitarifa')->row();
    }

    if (!$tarifa && !is_array($tarifa)) {
    	if ($id!='') $this->db->where('id', $id);
    	if ($country!='') $this->db->where('country_id', $country);
    	if ($module!='') $this->db->where('module_id', $module);
      $tarifa = $this->db->get('tblcomitarifa')->result_array();
    }

    return $tarifa;
  }

    /**
     * @param  integer ID
     * @return mixed
     * Delete rate from database, if used return array with key referenced
     */
    public function delete($id)
    {
/*        if (is_reference_in_table('id', 'tblcomitarifa', $id)) {
            return [
                'referenced' => true,
            ];
        }
*/        
        $this->db->where('id', $id);
        $this->db->delete('tblcomitarifa');
        if ($this->db->affected_rows() > 0) {
            logActivity('Tarifa Deleted [' . $id . ']');

            return true;
        }

        return false;
    }
}
