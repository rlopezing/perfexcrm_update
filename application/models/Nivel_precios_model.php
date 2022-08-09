<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Nivel_precios_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Add new price level
    * @param mixed $data All $_POST data
    */
    public function add($data)
    {
        $this->db->insert('tblcominivelprecio', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New price level Added [' . $data['detalle'] . ']');

            return $insert_id;
        }

        return false;
    }

    /**
     * Edit price level
     * @param mixed $data All $_POST data
     * @param mixed $id price level id
     */
    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tblcominivelprecio', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Price Level Updated [' . $data['detalle'] . ', ID:' . $id . ']');

            return true;
        }

        return false;
    }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get price level object based on passed id if not passed id return array of all price level
   */
  public function get($id='',$comercializador='',$tarifa='',$country='',$module='')
  {
    if (is_numeric($id)&&!is_numeric($comercializador)) 
    {
      $this->db->where('id', $id);
      return $this->db->get('tblcominivelprecio')->row();
    }

    if (!$price_level && !is_array($price_level))
    {
    	if ($id != '') $this->db->where('id', $id);
    	if ($comercializador!='') $this->db->where('comercializador', $comercializador);
    	if ($tarifa!='') $this->db->where('tarifa', $tarifa);
    	if ($country!='') $this->db->where('country_id', $country);
    	if ($module!='') $this->db->where('module_id', $module);
    	
      $price_level = $this->db->get('tblcominivelprecio')->result_array();
    }

    return $price_level;
  }

  /**
   * @param  integer ID
   * @return mixed
   * Delete price level from database, if used return array with key referenced
   */
  public function delete($id)
  {
  	/*
    if (is_reference_in_table('id', 'tblcominivelprecio', $id)) {
      return [
        'referenced' => true,
      ];
    }
    */
    $this->db->where('id', $id);
    $this->db->delete('tblcominivelprecio');
    if ($this->db->affected_rows() > 0) {
      logActivity('Price Level Deleted [' . $id . ']');

      return true;
    }

    return false;
  }

}
