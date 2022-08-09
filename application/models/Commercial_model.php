<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Commercial_model extends CRM_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get commercial object based on passed id if not passed id return array of all commercial
   */
  public function get($id = '')
  {
    if (is_numeric($id)) {
    	$this->db->select("tblstaff.staffid as id, concat(tblstaff.firstname,' ',tblstaff.lastname) as nombre");
    	$this->db->join('tblstaff_departments','tblstaff_departments.staffid = tblstaff.staffid');
    	$this->db->where('tblstaff_departments.departmentid', '10');
    	$this->db->where('tblstaff.staffid', $id);
      
      return $this->db->get('tblstaff')->row();
    }

    if (!$tarifa && !is_array($tarifa)) {
    	$this->db->select("tblstaff.staffid as id, concat(tblstaff.firstname,' ',tblstaff.lastname) as nombre");
    	$this->db->join('tblstaff_departments','tblstaff_departments.staffid = tblstaff.staffid');
    	$this->db->where('tblstaff_departments.departmentid', '10');
    	
      $tarifa = $this->db->get('tblstaff')->result_array();
    }

    return $tarifa;
  }

}
