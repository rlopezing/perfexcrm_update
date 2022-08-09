<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Commercial_category_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Add new commercial category
    * @param mixed $data All $_POST data
    */
    public function add($data)
    {
        $this->db->insert('tblcomicategoriacomercial', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New Tarifa Added [' . $data['detalle'] . ']');

            return $insert_id;
        }

        return false;
    }

    /**
     * Edit commercial category
     * @param mixed $data All $_POST data
     * @param mixed $id commercial category id
     */
    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tblcomicategoriacomercial', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Commercial category Updated [' . $data['detalle'] . ', ID:' . $id . ']');

            return true;
        }

        return false;
    }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get commercial category object based on passed id if not passed id return array of all commercial category
   */
  public function get($id='', $opcion='') {
    if (is_numeric($id)) {
      $this->db->where('id', $id);
      return $this->db->get('tblcomicategoriacomercial')->row();
    }
    if (!$tarifa && !is_array($tarifa)) {
      if ($opcion=='') $tarifa = $this->db->query('select * from tblcomicategoriacomercial where id > 1')->result_array();
      if ($opcion!='') $tarifa = $this->db->query('select * from tblcomicategoriacomercial')->result_array();
    }

    return $tarifa;
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get commercial category object based on passed id if not passed id return array of all commercial category
   */
  public function filtrar($id='', $country='', $module='') {
    if (is_numeric($id)) {
      $this->db->where('id', $id);
      return $this->db->get('tblcomicategoriacomercial')->row();
    }
    
    if (is_numeric($country)) $this->db->where('country_id', $country);
  	$tarifa = $this->db->query('select * from tblcomicategoriacomercial')->result_array();

    return $tarifa;
  }

    /**
     * @param  integer ID
     * @return mixed
     * Delete categoria comercial from database, if used return array with key referenced
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblcomicategoriacomercial');
        if ($this->db->affected_rows() > 0) {
            logActivity('Commercial category Deleted [' . $id . ']');

            return true;
        }

        return false;
    }
}
