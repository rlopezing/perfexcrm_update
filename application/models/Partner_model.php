<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Partner_model extends CRM_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get partner object based on passed id if not passed id return array of all partner
   */
  public function get($id='',$categoria_comercial='')
  {
    if (is_numeric($id)&&!is_numeric($categoria_comercial)) {
    	$this->db->select("tblstaff.staffid as id, concat(tblstaff.firstname,' ',tblstaff.lastname) as nombre");
    	$this->db->join('tblstaff_departments','tblstaff_departments.staffid = tblstaff.staffid');
    	$this->db->where('tblstaff.staffid', $id);
      
      return $this->db->get('tblstaff')->row();
    }

    if (!$tarifa && !is_array($tarifa)) {
    	$this->db->select("tblstaff.staffid as id, concat(tblstaff.firstname,' ',tblstaff.lastname) as nombre");
    	$this->db->join('tblcomistaff_assign','tblcomistaff_assign.staff = tblstaff.staffid');
      if ($id!='') $this->db->where('tblstaff.staffid', $id);
      if ($categoria_comercial!='') $this->db->where('tblcomistaff_assign.commercial_category', $categoria_comercial);
      $tarifa = $this->db->get('tblstaff')->result_array();
    }

    return $tarifa;
  }

}
