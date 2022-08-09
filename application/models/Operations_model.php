<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operations_model extends CRM_Model {
  
  public function __construct() {
    parent::__construct();
  }
  
  /**
   * Get get operation
   * @return array
   */
  public function get($id='') {
    $this->db->select('
      tblcvisit.*, tblcvisit.type as type_id, tblcvtype.type, tblcvtake_data.date_add as take_date,
      (case when (tblcvisit.date_input is null) 
        then timestampdiff(day, tblcvisit.date_add, CURDATE()) 
            else timestampdiff(day, tblcvisit.date_add, tblcvisit.date_input) end) as day_date_input, 
      (case when (tblcvisit.date_inbank is null) 
        then (case when (tblcvisit.date_input is null) 
            then 0 else timestampdiff(day, tblcvisit.date_input, CURDATE()) end) 
            else timestampdiff(day, tblcvisit.date_input, tblcvisit.date_inbank) end) as day_date_inbank, 
      (case when (tblcvisit.date_study is null) 
        then (case when (tblcvisit.date_inbank is null) 
            then 0 else timestampdiff(day, tblcvisit.date_study, CURDATE()) end) 
            else timestampdiff(day, tblcvisit.date_inbank, tblcvisit.date_study) end) as day_date_study, 
      (case when (tblcvisit.date_approved is null) 
        then (case when (tblcvisit.date_study is null) 
            then 0 else timestampdiff(day, tblcvisit.date_study, CURDATE()) end) 
            else timestampdiff(day, tblcvisit.date_study, tblcvisit.date_approved) end) as day_date_approved, 
      (case when (tblcvisit.date_finished is null) 
        then (case when (tblcvisit.date_approved is null) 
            then 0 else timestampdiff(day, tblcvisit.date_approved, CURDATE()) end) 
            else timestampdiff(day, tblcvisit.date_approved, tblcvisit.date_finished) end) as day_date_finished, 
      (case when (tblcvisit.date_finished is null) 
        then timestampdiff(day, tblcvisit.date_add, CURDATE()) 
        else timestampdiff(day, tblcvisit.date_add, tblcvisit.date_finished) end) as days_passed
    ');
    $this->db->join('tblclients', 'tblclients.userid = tblcvisit.client','inner');
    $this->db->join('tblcvtype', 'tblcvtype.id = tblcvisit.type','inner');
    $this->db->join('tblcvtake_data', 'tblcvtake_data.client = tblcvisit.client','inner');
    $this->db->where('tblcvisit.id', $id);
    $this->db->where('tblcvisit.status > 1');
    
    if (is_numeric($id)) return $this->db->get('tblcvisit')->row();
    
    return $this->db->get('tblcvisit')->result_array();
  }
  
  /**
   * Get get operation statuses
   * @return array
   */
  public function get_operation_statuses() {
    return $this->db->get('tblcvstatus')->result_array();
  }
  
  public function is_member($project_id, $staff_id = '')
  {
    if (!is_numeric($staff_id)) {
      $staff_id = get_staff_user_id();
    }
    $member = total_rows(db_prefix() . 'project_members', [
      'staff_id'   => $staff_id,
      'project_id' => $project_id,
    ]);
    if ($member > 0) {
      return true;
    }

    return false;
  }
  
  /**
   * Get get percent circle
   * @return array
   */
  public function get_percent_circle($id) {
    $this->db->select('status, (SELECT count(id) FROM tblcvstatus) as percent');
    $this->db->where('tblcvisit.id', $id);
    
    return $this->db->get('tblcvisit')->row();
  }
  
  /**
	 * Get operation documents necessary
	 * @param  mixed  $id         documents id
	 * @param  array   $where      perform where
	 * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
	 * @return mixed
	 */
  public function add_documents_necessary($data,$files)
  {
    $resp = false;
    
    $app_name = APP_NAME;
    if ($app_name=="") $dir_files = $_SERVER['DOCUMENT_ROOT'] . "/files";
    if ($app_name!="")$dir_files = $_SERVER['DOCUMENT_ROOT'] . "/" . $app_name . "/files";
    if (!file_exists($dir_files)) mkdir($dir_files, 0777, "a");
    $dir_oper = $dir_files . "/operaciones";
    if (!file_exists($dir_oper)) mkdir($dir_oper, 0777, "a");
    $dir_visit = $dir_oper . "/visit_" . $data['visit'];
    if (!file_exists($dir_visit)) mkdir($dir_visit, 0777, "a");
    
    foreach ($data['number'] as $number) {
      $document = [];
      $document['visit'] = $data['visit'];
      $document['type'] = $data['type'];
      $document['number'] = $number;
      if ($data['exist'][$number-1] == $number) $document['exist'] = 1; else $document['exist'] = 0;
      $document['title'] = $data['name'][$number-1];
      if ($files['error'][$number-1] == 0) {
        $document['name'] = $files['name'][$number-1];
        $document['file'] = base_url('/files/operaciones/' . "visit_" . $data['visit'] . "/" . $files['name'][$number-1]);
        $document['path'] = $dir_visit . "/" . $files['name'][$number-1];
      }
      $document['addedfrom'] = get_staff_user_id();
      
      $this->db->insert('tblcvisit_documents', $document);
      $insert_id = $this->db->insert_id();
      if ($insert_id) {
        if ($files['error'][$number-1] == 0) {
          $destination = $dir_visit . '/' . $files['name'][$number-1];
          move_uploaded_file($files['tmp_name'][$number-1], $destination);
        }
        
        $resp = true;
      }
    }

    return $resp;
  }
  
  /**
   * @param  array $_POST data
   * @param  integer documents necessary ID
   * @return boolean
   */
  public function update_documents_necessary($data, $id, $files) {
    $resp = false;
    
    foreach ($data['number'] as $number) {
      $document = [];
      
      // Obtiene el registro del documento
      $this->db->where('visit', $id);
      $this->db->where('number', $number);
      $rs = $this->db->get('tblcvisit_documents')->row();
      
      if (count($rs)) {
        $exist = 0;
        foreach ($data['exist'] as $value) {
          if ($number == $value) $exist = 1;
        }
        if (($exist!=$rs->exist) && ($files['error'][$number-1]!=0 || $files['error'][$number-1]==0)) {
          $document['exist'] = $exist;
          if ($rs->exist==1) {
            if (file_exists($rs->path)) {
              $document['name'] = null;
              $document['file'] = null;
              $document['path'] = null;
              unlink($rs->path);
            }
          } else if ($rs->exist==0) {
            $app_name = APP_NAME;
            if ($app_name=="") $dir_files = $_SERVER['DOCUMENT_ROOT'] . "/files";
            if ($app_name!="")$dir_files = $_SERVER['DOCUMENT_ROOT'] . "/" . $app_name . "/files";
            if (!file_exists($dir_files)) mkdir($dir_files, 0777, "a");
            $dir_oper = $dir_files . "/operaciones";
            if (!file_exists($dir_oper)) mkdir($dir_oper, 0777, "a");
            $dir_visit = $dir_oper . "/visit_" . $data['visit'];
            if (!file_exists($dir_visit)) mkdir($dir_visit, 0777, "a");
            
            if ($data['exist'][$number-1] == $number) $document['exist'] = 1; else $document['exist'] = 0;
            $document['name'] = $files['name'][$number-1];
            $document['file'] = base_url('/files/operaciones/' . "visit_" . $data['visit'] . "/" . $files['name'][$number-1]);
            $document['path'] = $dir_visit . "/" . $files['name'][$number-1];
            $destination = $dir_visit . '/' . $files['name'][$number-1];
            move_uploaded_file($files['tmp_name'][$number-1], $destination);
          }
          
          $this->db->where('id', $rs->id);
          $this->db->update('tblcvisit_documents', $document);
          $resp = true;
        } else if (($exist==$rs->exist) && ($files['error'][$number-1]==0)) {
          if (file_exists($rs->path)) unlink($rs->path);
          $app_name = APP_NAME;
          if ($app_name=="") $dir_files = $_SERVER['DOCUMENT_ROOT'] . "/files";
          if ($app_name!="")$dir_files = $_SERVER['DOCUMENT_ROOT'] . "/" . $app_name . "/files";
          if (!file_exists($dir_files)) mkdir($dir_files, 0777, "a");
          $dir_oper = $dir_files . "/operaciones";
          if (!file_exists($dir_oper)) mkdir($dir_oper, 0777, "a");
          $dir_visit = $dir_oper . "/visit_" . $data['visit'];
          if (!file_exists($dir_visit)) mkdir($dir_visit, 0777, "a");

          $document['name'] = $files['name'][$number-1];
          $document['file'] = base_url('/files/operaciones/' . "visit_" . $data['visit'] . "/" . $files['name'][$number-1]);
          $document['path'] = $dir_visit . "/" . $files['name'][$number-1];
          $destination = $dir_visit . '/' . $files['name'][$number-1];
          move_uploaded_file($files['tmp_name'][$number-1], $destination);
          
          $this->db->where('id', $rs->id);
          $this->db->update('tblcvisit_documents', $document);
          $resp = true;
        }
      }
    }

    return $resp;
  }
  
  /**
   * Get get documents necessary
   * @return array
   */
  public function get_documents_necessary($visit,$type) {
    $this->db->where('visit', $visit);
    $this->db->where('type', $type);
    
    return $this->db->get('tblcvisit_documents')->result_array();
  }
  
  /**
   * Get get documents necessary
   * @return array
   */
  public function get_tracing($id="") {
    $this->db->select('tblcvisit_management.*, tblcvcontact_type.type_name');
    $this->db->join('tblcvcontact_type', 'tblcvcontact_type.id = tblcvisit_management.contact_type','inner');
    if (is_numeric($id)) $this->db->where('id', $id);
    
    return $this->db->get('tblcvisit_management')->result_array();
  }
  
  /**
	 * Get operation tracing
	 * @param  mixed  $id         documents id
	 * @param  array   $where      perform where
	 * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
	 * @return mixed
	 */
  public function add_tracing($data)
  {
    $resp = false;
    
    $data['date_add'] = date('Y-m-d', strtotime($data['date_add']));
    $data['staffid'] = get_staff_user_id();
      
    $this->db->insert('tblcvisit_management', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) $resp = true;

    return $resp;
  }
  
  /**
   * @param  array $_POST data
   * @param  integer tracing ID
   * @return boolean
   */
  public function update_tracing($data, $id) {
    $resp = false;
    
    $this->db->where('id', $rs->id);
    $this->db->update('tblcvisit_management', $data);

    return $resp;
  }
  
  /**
   * @param  array $_POST data
   * @param  integer status ID
   * @return boolean
   */
  public function update_status($data, $id) {
    $resp = false;
    
    $data['date_add'] = date('Y-m-d');
    $data['addedfrom'] = get_staff_user_id();
    
    $this->db->insert('tblcvisit_detail', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      $resp = true;
      
      $visit = $data['visit'];
      $status = $data['status'];
      $data = [];
      $data['status'] = $status;
      $this->db->where('id', $visit);
      $this->db->update('tblcvisit', $data);
    }
    
    return $resp;
  }
  
  /**
   * Get get visit details
   * @return array
   */
  public function get_visit_detail($id="") {
    $this->db->select('tblcvisit_detail.*, tblcvstatus.name');
    $this->db->join('tblcvstatus', 'tblcvstatus.id = tblcvisit_detail.status','inner');
    $this->db->where('visit', $id);
    
    return $this->db->get('tblcvisit_detail')->result_array();
  }
  
}
