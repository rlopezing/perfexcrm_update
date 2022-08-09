<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Stress_level_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Add new stress level
    * @param mixed $data All $_POST data
    */
    public function add($data)
    {
        $this->db->insert('tblcominiveltension', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New stress level Added [' . $data['nombre'] . ']');

            return $insert_id;
        }

        return false;
    }

    /**
     * Edit stress level
     * @param mixed $data All $_POST data
     * @param mixed $id stress level id
     */
    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tblcominiveltension', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('stress level Updated [' . $data['nombre'] . ', ID:' . $id . ']');

            return true;
        }

        return false;
    }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get stress level object based on passed id if not passed id return array of all stress level
   */
  public function get($id = '')
  {
    if (is_numeric($id)) {
      $this->db->where('id', $id);

      return $this->db->get('tblcominiveltension')->row();
    }

    if (!$tarifa && !is_array($tarifa)) {
      $tarifa = $this->db->get('tblcominiveltension')->result_array();
    }

    return $tarifa;
  }

    /**
     * @param  integer ID
     * @return mixed
     * Delete stress level from database, if used return array with key referenced
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblcominiveltension');
        if ($this->db->affected_rows() > 0) {
            logActivity('Stress Level Deleted [' . $id . ']');

            return true;
        }

        return false;
    }
}
