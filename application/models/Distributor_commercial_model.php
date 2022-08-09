<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Distributor_commercial_model extends CRM_Model
{
    public function __construct() {
      parent::__construct();
    }
    
 		/**
     * @param  integer ID (optional)
     * @param  boolean (optional)
     * @return mixed
     * Get general map object based on passed id if not passed id return array of all general map
     * Second parameter is to check if the request is coming from clientarea, so if any general map are hidden from client to exclude
     */
    public function get_valor_contrato($fdesde='', $fhasta='') {
      $sql = "select ifnull(sum(valor_contrato), 0) as total from tblcomicontratos where date_format(dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."' and comision_comercial > 0";
      $get_total = $this->db->query($sql)->row();
      return $get_total->total;
    }
    public function get_comision_socio($fdesde='', $fhasta='') {
      $sql = "select ifnull(sum(comision_socio), 0) as total from tblcomicontratos where date_format(dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."' and comision_comercial > 0";
      $get_total = $this->db->query($sql)->row();
      return $get_total->total;
    }
    public function get_comision_comercial($fdesde='', $fhasta='') {
      $sql = "select ifnull(sum(comision_comercial), 0) as total from tblcomicontratos where date_format(dateadded, '%Y-%m-%d') between '".$fdesde."' and '".$fhasta."' and comision_comercial > 0";
      $get_total = $this->db->query($sql)->row();
      return $get_total->total;
    }

}
