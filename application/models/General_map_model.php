<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_map_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('currencies_model');
    }

    /**
     * @param  integer ID (optional)
     * @param  boolean (optional)
     * @return mixed
     * Get general map object based on passed id if not passed id return array of all general map
     * Second parameter is to check if the request is coming from clientarea, so if any general map are hidden from client to exclude
     */
    public function get($id = false, $clientarea = false)
    {
      if ($clientarea == true) {
        $this->db->where('hidefromclient', 0);
      }
      if (is_numeric($id)) {
        $this->db->where('departmentid', $id);

        return $this->db->get('tbldepartments')->row();
      }

      $departments = $this->object_cache->get('departments');
      if (!$departments && !is_array($departments)) {
        $departments = $this->db->get('tbldepartments')->result_array();
        $this->object_cache->add('departments', $departments);
      }

      return $departments;
    }

    /**
     * @param  integer ID (option)
     * @param  boolean (optional)
     * @return mixed
     * Get general map where staff belongs
     * If $onlyids passed return only contractID (simple array) if not returns array of all general map
     */
    public function get_staff_general_map($userid = false, $onlyids = false)
    {
        if ($userid == false) {
            $userid = get_staff_user_id();
        }
        if ($onlyids == false) {
            $this->db->select();
        } else {
            $this->db->select('tblstaffdepartments.departmentid');
        }
        $this->db->from('tblstaffdepartments');
        $this->db->join('tbldepartments', 'tblstaffdepartments.departmentid = tbldepartments.departmentid', 'left');
        $this->db->where('staffid', $userid);
        $departments = $this->db->get()->result_array();
        if ($onlyids == true) {
            $departmentsid = [];
            foreach ($departments as $department) {
                array_push($departmentsid, $department['departmentid']);
            }

            return $departmentsid;
        }

        return $departments;
    }
    
    /**
     * @param  integer ID (optional)
     * @param  boolean (optional)
     * @return mixed
     * Get general map object based on passed id if not passed id return array of all general map
     * Second parameter is to check if the request is coming from clientarea, so if any general map are hidden from client to exclude
     */
    public function get_valor_contrato($fdesde='', $fhasta='') {
      $sql = "select ifnull(sum(valor_contrato), 0) as total from tblcomicontratos where date_format(dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."'";
      $get_total = $this->db->query($sql)->row();
      return $get_total->total;
    }
    public function get_comision_socio($fdesde='', $fhasta='') {
      $sql = "select ifnull(sum(comision_socio), 0) as total from tblcomicontratos where date_format(dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."'";
      $get_total = $this->db->query($sql)->row();
      return $get_total->total;
    }
    public function get_comision_comercial($fdesde='', $fhasta='') {
      $sql = "select ifnull(sum(comision_comercial), 0) as total from tblcomicontratos where date_format(dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."'";
      $get_total = $this->db->query($sql)->row();
      return $get_total->total;
    }
}
