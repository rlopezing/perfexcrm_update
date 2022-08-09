<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Commercials_visits_model extends CRM_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('comercializador_model');
    $this->load->model('tarifa_model');
    $this->load->model('nivel_precios_model');
    $this->load->model('commercial_category_model');
    $this->load->model('commercial_model');
    $this->load->model('stress_level_model');
    $this->load->model('partner_model');
  }

  /**
	 * Get visit/s
	 * @param  mixed  $id         contract id
	 * @param  array   $where      perform where
	 * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
	 * @return mixed
	 */
  public function get($id = '', $where = [], $for_editor = false)
  {
    $this->db->select('*');
    $this->db->where($where);

    if (is_numeric($id)) {
      $this->db->where('tblcvisit.id', $id);
      $contract = $this->db->get('tblcvisit')->row();
      			
      return $contract;
    }
    $contracts = $this->db->get('tblcvisit')->result_array();
    
    return $contracts;
  }

  /**
   * Select unique contracts years
   * @return array
   */
  public function get_visits_years()
  {
    return $this->db->query('SELECT DISTINCT(YEAR(date_add)) as year FROM tblcvisit')->result_array();
  }

  /**
   * @param  integer ID
   * @return object
   * Retrieve contract attachments from database
   */
  public function get_contract_attachments($attachment_id = '', $id = '')
  {
      if (is_numeric($attachment_id)) {
          $this->db->where('id', $attachment_id);

          return $this->db->get('tblfiles')->row();
      }
      $this->db->order_by('dateadded', 'desc');
      $this->db->where('rel_id', $id);
      $this->db->where('rel_type', 'contract');

      return $this->db->get('tblfiles')->result_array();
  }
    
  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new visit
   */
  public function add($data) {
    if (isset($data['longitude'])) {
      $longitude = $data['longitude'];
      unset($data['longitude']);
    }
    if (isset($data['latitude'])) {
      $latitude = $data['latitude'];
      unset($data['latitude']);
    }
    
    $data['date_add'] = date('Y-m-d', strtotime($data['date_add']));
    $data['hour_add'] = date('Y-m-d H:i:s');
    $data['addedfrom'] = get_staff_user_id();
    $data['status'] = 1;
    
    //unset($data['attachment']);
    if (isset($data['trash']) && ($data['trash'] == 1 || $data['trash'] === 'on')){
      $data['trash'] = 1;
    } else {
      $data['trash'] = 0;
    }

    if (isset($data['not_visible_to_client']) && ($data['not_visible_to_client'] == 1 || $data['not_visible_to_client'] === 'on')){
      $data['not_visible_to_client'] = 1;
    } else {
      $data['not_visible_to_client'] = 0;
    }
    
    $data['hash'] = app_generate_hash();
    
    $this->db->insert('tblcvisit', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      $this->update_ubication_client($data['client'], $latitude, $longitude);
      if (isset($custom_fields)) handle_custom_fields_post($insert_id, $custom_fields);
      do_action('after_visit_added', $insert_id);
      logActivity('New Visit Added');

      return $insert_id;
    }

    return false;
  }
  
  public function update_ubication_client($userid, $latitude, $longitude) {
    $dat['longitude'] = $latitude;
    $dat['latitude'] = $longitude;
    $this->db->where('userid', $userid);
    
    $this->db->update('tblclients', $dat);
  }

  
  public function update_visit_client($client) {
    $this->db->where('client', $client);
    $visit = $this->db->get(db_prefix() . 'cvisit')->row();
    
    $data['status'] = 2;
    $this->db->where('id', $visit->id);
    $this->db->where('client', $client);
    $this->db->update('tblcvisit', $data);
  }

  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new take data
   */
  public function add_take_data($data){
    if (isset($data['id'])) unset($data['id']);
    if (isset($data['age_1'])) unset($data['age_1']);
    if (isset($data['age_2'])) unset($data['age_2']);
    
    $data['birthdate_1'] = date('Y-m-d', strtotime($data['birthdate_1']));
    $data['birthdate_2'] = date('Y-m-d', strtotime($data['birthdate_2']));
    
    $this->db->insert('tblcvtake_data', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      $this->update_visit_client($data['client']);
      return $insert_id;
    }

    return false;
  }
  
  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new sales data
   */
  public function add_sales_data($data){
    if (isset($data['id'])) unset($data['id']);
    
    $data['arran_end_date'] = date('Y-m-d', strtotime($data['arran_end_date']));
    
    $this->db->insert('tblcvsales_data', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      $this->update_visit_client($data['client']);
      return $insert_id;
    }

    return false;
  }
  
  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new economic data
   */
  public function add_economic_data($data){
    if (isset($data['id'])) unset($data['id']);
    
    if (isset($data['pending_total_1'])) unset($data['pending_total_1']);
    if (isset($data['share_total_1'])) unset($data['share_total_1']);
    if (isset($data['pending_total_2'])) unset($data['pending_total_2']);
    if (isset($data['share_total_2'])) unset($data['share_total_2']);
    
    $data['high_date_last_job_1'] = date('Y-m-d', strtotime($data['high_date_last_job_1']));
    $data['high_date_last_job_2'] = date('Y-m-d', strtotime($data['high_date_last_job_2']));
    
    $this->db->insert('tblcveconomic_data', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      $this->update_visit_client($data['client']);
      return $insert_id;
    }

    return false;
  }
  
  /**
   * @param   array $_POST data
   * @return  integer Insert ID
   * Add new economic data
   */
  public function add_operation_banks($data){
    if (isset($data['id'])) unset($data['id']);
        
    $this->db->insert('tblcvoperation_banks', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      $this->update_visit_client($data['client']);
      return $insert_id;
    }

    return false;
  }  
  
  /**
   * @param  array $_POST data
   * @param  integer Contract ID
   * @return boolean
   */
  public function update($data, $id) {
    
    $client = $data['client'];
    if (isset($data['client'])) { unset($data['client']); }
    if (isset($data['date_add'])) { unset($data['date_add']); }
    if (isset($data['hour_add'])) { unset($data['hour_add']); }        
    $affectedRows = 0;

    if (isset($data['trash'])) {
      $data['trash'] = 1;
    } else {
      $data['trash'] = 0;
    }
    if (isset($data['not_visible_to_client'])) {
      $data['not_visible_to_client'] = 1;
    } else {
      $data['not_visible_to_client'] = 0;
    }
    
    $this->db->where('id', $id);
    $this->db->update('tblcvisit', $data);
    if ($this->db->affected_rows() > 0){
      do_action('after_visit_updated', $id);
      logActivity('Visit Updated [' . $data['subject'] . ']');
      $this->update_visit_client($client);

      return true;
    }
    if ($affectedRows > 0) {
        return true;
    }

    return false;
  }
  
  /**
   * @param  array $_POST data
   * @param  integer Contract ID
   * @return boolean
   */
  public function update_take_data($data, $id) {
    if (isset($data['id'])) unset($data['id']);
    if (isset($data['age_1'])) unset($data['age_1']);
    if (isset($data['age_2'])) unset($data['age_2']);
    
    $data['birthdate_1'] = date('Y-m-d', strtotime($data['birthdate_1']));
    $data['birthdate_2'] = date('Y-m-d', strtotime($data['birthdate_2']));
    
    $this->db->where('id', $id);
    $this->db->update('tblcvtake_data', $data);
    if ($this->db->affected_rows() > 0){
      $this->update_visit_client($client);
      
      return true;
    }
    if ($affectedRows > 0) {
       return true;
    }

    return false;
  }

  /**
   * @param  array $_POST data
   * @param  integer Contract ID
   * @return boolean
   */
  public function update_sales_data($data, $id) {
    if (isset($data['id'])) unset($data['id']);
    
    $data['arran_end_date'] = date('Y-m-d', strtotime($data['arran_end_date']));
    
    $this->db->where('id', $id);
    $this->db->update('tblcvsales_data', $data);
    if ($this->db->affected_rows() > 0){
      $this->update_visit_client($client);
      
      return true;
    }
    if ($affectedRows > 0) {
       return true;
    }

    return false;
  }

  /**
   * @param  array $_POST data
   * @param  integer Contract ID
   * @return boolean
   */
  public function update_economic_data($data, $id) {
    if (isset($data['id'])) unset($data['id']);
    
    if (isset($data['pending_total_1'])) unset($data['pending_total_1']);
    if (isset($data['share_total_1'])) unset($data['share_total_1']);
    if (isset($data['pending_total_2'])) unset($data['pending_total_2']);
    if (isset($data['share_total_2'])) unset($data['share_total_2']);
    
    $data['high_date_last_job_1'] = date('Y-m-d', strtotime($data['high_date_last_job_1']));
    $data['high_date_last_job_2'] = date('Y-m-d', strtotime($data['high_date_last_job_2']));
    
    $this->db->where('id', $id);
    $this->db->update('tblcveconomic_data', $data);
    if ($this->db->affected_rows() > 0){
      $this->update_visit_client($client);
      
      return true;
    }
    if ($affectedRows > 0) {
       return true;
    }

    return false;
  }
  
  /**
   * @param  array $_POST data
   * @param  integer Contract ID
   * @return boolean
   */
  public function update_operation_banks($data, $id) {
    if (isset($data['id'])) unset($data['id']);
    
    $data['rental_date_1'] = date('Y-m-d', strtotime($data['rental_date_1']));
    $data['rental_date_2'] = date('Y-m-d', strtotime($data['rental_date_2']));
        
    $this->db->where('id', $id);
    $this->db->update('tblcvoperation_banks', $data);
    if ($this->db->affected_rows() > 0){
      $this->update_visit_client($client);
      
      return true;
    }
    if ($affectedRows > 0) {
      return true;
    }

    return false;
  }
  
  public function clear_signature($id)
  {
    $this->db->select('signature');
    $this->db->where('id', $id);
    $contract = $this->db->get('tblcontracts')->row();

    if ($contract) {
      $this->db->where('id', $id);
      $this->db->update('tblcontracts', array_merge(get_acceptance_info_array(true), ['signed' => 0]));

      if (!empty($contract->signature)) {
        unlink(get_upload_path_by_type('contract') . $id . '/' . $contract->signature);
      }

      return true;
    }

    return false;
  }

    /**
    * Add visit comment
    * @param mixed  $data   $_POST comment data
    * @param boolean $client is request coming from the client side
    */
    public function add_comment($data, $client = false)
    {
        if (is_staff_logged_in()) {
            $client = false;
        }

        if (isset($data['action'])) {
          unset($data['action']);
        }

        $data['dateadded'] = date('Y-m-d H:i:s');

        if ($client == false) {
            $data['staffid'] = get_staff_user_id();
        }

        $data['content'] = nl2br($data['content']);
        $this->db->insert('tblcvisit_comments', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) return true;

        return false;
    }

    public function edit_comment($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tblcvisit_comments', [
            'content' => nl2br($data['content']),
        ]);

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Get contract comments
     * @param  mixed $id contract id
     * @return array
     */
    public function get_comments($id)
    {
        $this->db->where('visit', $id);
        $this->db->order_by('dateadded', 'ASC');

        return $this->db->get('tblcvisit_comments')->result_array();
    }

    /**
     * Get contract single comment
     * @param  mixed $id  comment id
     * @return object
     */
    public function get_comment($id)
    {
      $this->db->where('id', $id);

      return $this->db->get('tblcvisit_comments')->row();
    }

    /**
     * Remove contract comment
     * @param  mixed $id comment id
     * @return boolean
     */
    public function remove_comment($id)
    {
      $comment = $this->get_comment($id);

      $this->db->where('id', $id);
      $this->db->delete('tblcvisit_comments');
      if ($this->db->affected_rows() > 0) {
        logActivity('Visit Comment Removed [Contract ID:' . $comment->id . ', Comment Content: ' . $comment->content . ']');

        return true;
      }

      return false;
    }

  public function copy($id)
  {
    $contract       = $this->get($id, [], true);
    $fields         = $this->db->list_fields('tblcomicontractos');
    
    $newContactData = [];
    foreach ($fields as $field) {
      if (isset($contract->$field)) {
        $newContactData[$field] = $contract->$field;
      }
    }

    unset($newContactData['id']);

    $newContactData['trash']            = 0;
    $newContactData['isexpirynotified'] = 0;
    $newContactData['isexpirynotified'] = 0;
    $newContactData['signed']           = 0;
    $newContactData['signature']        = null;

    $newContactData = array_merge($newContactData, get_acceptance_info_array(true));

    if ($contract->fecha_fin_suministro) {
      $dStart                    = new DateTime($contract->fecha_inicio_suministro);
      $dEnd                      = new DateTime($contract->fecha_fin_suministro);
      $dDiff                     = $dStart->diff($dEnd);
      $newContactData['fecha_fin_suministro'] = _d(date('Y-m-d', strtotime(date('Y-m-d', strtotime('+' . $dDiff->days . 'DAY')))));
    } else {
      $newContactData['fecha_fin_suministro'] = '';
    }

    $newId = $this->add($newContactData);

    if ($newId) {
      $custom_fields = get_custom_fields('contracts');
      foreach ($custom_fields as $field) {
        $value = get_custom_field_value($id, $field['id'], 'contracts', false);
        if ($value != '') {
          $this->db->insert('tblcustomfieldsvalues', [
          'relid'   => $newId,
          'fieldid' => $field['id'],
          'fieldto' => 'contracts',
          'value'   => $value,
          ]);
        }
      }
    }

    return $newId;
  }

    /**
     * @param  integer ID
     * @return boolean
     * Delete contract, also attachment will be removed if any found
     */
    public function delete($id) {
        do_action('before_visit_deleted', $id);
        
        $this->clear_signature($id);
        $contract = $this->get($id);
        $this->db->where('id', $id);
        $this->db->delete('tblcomicontratos');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('contract_id', $id);
            $this->db->delete('tblcomicontractcomments');

            // Delete the custom field values
            $this->db->where('relid', $id);
            $this->db->where('fieldto', 'contracts');
            $this->db->delete('tblcustomfieldsvalues');

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'contract');
            $attachments = $this->db->get('tblcomifiles')->result_array();
            foreach ($attachments as $attachment) {
                $this->delete_contract_attachment($attachment['id']);
            }

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'contract');
            $this->db->delete('tblcominotes');

            $this->db->where('contractid', $id);
            $this->db->delete('tblcomicontractrenewals');
            // Get related tasks
            $this->db->where('rel_type', 'contract');
            $this->db->where('rel_id', $id);
            $tasks = $this->db->get('tblcomistafftasks')->result_array();
            foreach ($tasks as $task) {
                $this->tasks_model->delete_task($task['id']);
            }

            delete_tracked_emails($id, 'contract');
            logActivity('Contract Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

    /**
     * Function that send contract to customer
     * @param  mixed  $id        contract id
     * @param  boolean $attachpdf to attach pdf or not
     * @param  string  $cc        Email CC
     * @return boolean
     */
    public function send_contract_to_client($id, $attachpdf = true, $cc = '')
    {
        $this->load->model('emails_model');

        $this->emails_model->set_rel_id($id);
        $this->emails_model->set_rel_type('contract');

        $contract = $this->get($id);

        if ($attachpdf) {
            $pdf    = contract_pdf($contract);
            $attach = $pdf->Output(slug_it($contract->subject) . '.pdf', 'S');
        }

        $sent_to = $this->input->post('sent_to');
        $sent    = false;
        if (is_array($sent_to)) {
            $i = 0;
            foreach ($sent_to as $contact_id) {
                if ($contact_id != '') {
                    if ($attachpdf) {
                        $this->emails_model->add_attachment([
                            'attachment' => $attach,
                            'filename'   => slug_it($contract->subject) . '.pdf',
                            'type'       => 'application/pdf',
                        ]);
                    }
                    if ($this->input->post('email_attachments')) {
                        $_other_attachments = $this->input->post('email_attachments');
                        foreach ($_other_attachments as $attachment) {
                            $_attachment = $this->get_contract_attachments($attachment);
                            $this->emails_model->add_attachment([
                                'attachment' => get_upload_path_by_type('contract') . $id . '/' . $_attachment->file_name,
                                'filename'   => $_attachment->file_name,
                                'type'       => $_attachment->filetype,
                                'read'       => true,
                            ]);
                        }
                    }
                    $contact      = $this->clients_model->get_contact($contact_id);
                    $merge_fields = [];
                    $merge_fields = array_merge($merge_fields, get_client_contact_merge_fields($contract->client, $contact_id));
                    $merge_fields = array_merge($merge_fields, get_contract_merge_fields($id));
                    // Send cc only for the first contact
                    if (!empty($cc) && $i > 0) {
                        $cc = '';
                    }
                    if ($this->emails_model->send_email_template('send-contract', $contact->email, $merge_fields, '', $cc)) {
                        $sent = true;
                    }
                }
                $i++;
            }
        } else {
            return false;
        }
        if ($sent) {
            return true;
        }

        return false;
    }

    /**
     * Delete contract attachment
     * @param  mixed $attachment_id
     * @return boolean
     */
    public function delete_contract_attachment($attachment_id)
    {
        $deleted    = false;
        $attachment = $this->get_contract_attachments($attachment_id);

        if ($attachment) {
            if (empty($attachment->external)) {
                unlink(get_upload_path_by_type('contract') . $attachment->rel_id . '/' . $attachment->file_name);
            }
            $this->db->where('id', $attachment->id);
            $this->db->delete('tblfiles');
            if ($this->db->affected_rows() > 0) {
                $deleted = true;
                logActivity('Contract Attachment Deleted [ContractID: ' . $attachment->rel_id . ']');
            }

            if (is_dir(get_upload_path_by_type('contract') . $attachment->rel_id)) {
                // Check if no attachments left, so we can delete the folder also
                $other_attachments = list_files(get_upload_path_by_type('contract') . $attachment->rel_id);
                if (count($other_attachments) == 0) {
                    // okey only index.html so we can delete the folder also
                    delete_dir(get_upload_path_by_type('contract') . $attachment->rel_id);
                }
            }
        }

        return $deleted;
    }

  /**
   * Renew contract
   * @param  mixed $data All $_POST data
   * @return mixed
   */
  public function renew($data)
  {
    $keepSignature = isset($data['renew_keep_signature']);
    if ($keepSignature) 
    {
      unset($data['renew_keep_signature']);
    }
    $data['new_start_date']      		= to_sql_date($data['new_start_date']);
    $data['new_end_date']        		= to_sql_date($data['new_end_date']);
    $data['date_renewed']        		= date('Y-m-d H:i:s');
    $data['renewed_by']          		= get_staff_full_name(get_staff_user_id());
    $data['renewed_by_staff_id'] 		= get_staff_user_id();
    
    if (!is_date($data['new_end_date'])) 
    {
      unset($data['new_end_date']);
    }
    
    // get the original contract so we can check if is expiry notified on delete the expiry to revert
    $_contract                         	= $this->get($data['contractid']);
    $data['is_on_old_expiry_notified'] 	= $_contract->isexpirynotified;
    $this->db->insert('tblcomicontractrenewals', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) 
    {
      $this->db->where('id', $data['contractid']);
      $_data = [
        'fecha_inicio_suministro' => $data['new_start_date'],
        'valor_contrato'   				=> $data['new_value'],
      ];

      if (isset($data['new_end_date'])) 
      {
        $_data['fecha_fin_suministro'] = $data['new_end_date'];
      }

			/*
      if (!$keepSignature) 
      {
        $_data           = array_merge($_data, get_acceptance_info_array(true));
        $_data['signed'] = 0;
        if (!empty($_contract->signature)) 
        {
          unlink(get_upload_path_by_type('contract') . $data['contractid'] . '/' . $_contract->signature);
        }
      }
      */

      $this->db->update('tblcomicontratos', $_data);
      if ($this->db->affected_rows() > 0) 
      {
        logActivity('Contract Renewed [ID: ' . $data['contractid'] . ']');
        return true;
      }
      
      // delete the previous entry
      $this->db->where('id', $insert_id);
      $this->db->delete('tblcomicontractrenewals');

      return false;
    }

    return false;
  }

  /**
   * Termination contract
   * @param  mixed $data All $_POST data
   * @return mixed
   */
  public function termination($data)
  {
    $this->db->where('id', $data['contractid']);
    $_data = [
      'termination_date' => to_sql_date($data['termination_date']),
      'termination_motive' => $data['termination_motive'],
      'termination_comment' => $data['termination_comment'],
    ];

    $this->db->update('tblcomicontratos', $_data);
    if ($this->db->affected_rows() > 0) 
    {
      logActivity('Contract Terminate [ID: ' . $data['contractid'] . ']');
      return true;
    }

    return false;
  }

  /**
   * Delete contract renewal
   * @param  mixed $id         renewal id
   * @param  mixed $contractid contract id
   * @return boolean
   */
  public function delete_renewal($id, $contractid)
  {
    // check if this renewal is last so we can revert back the old values, if is not last we wont do anything
    $this->db->select('id')->from('tblcomicontractrenewals')->where('contractid', $contractid)->order_by('id', 'desc')->limit(1);
    $query                 = $this->db->get();
    $last_contract_renewal = $query->row()->id;
    $is_last               = false;
    if ($last_contract_renewal == $id) 
    {
      $is_last = true;
      $this->db->where('id', $id);
      $original_renewal = $this->db->get('tblcomicontractrenewals')->row();
    }
    $this->db->where('id', $id);
    $this->db->delete('tblcomicontractrenewals');
    if ($this->db->affected_rows() > 0) 
    {
      if ($is_last == true) 
      {
        $this->db->where('id', $contractid);
        $data = [
          'fecha_inicio_suministro'        => $original_renewal->old_start_date,
          'valor_contrato'   => $original_renewal->old_value,
        ];
        if ($original_renewal->old_end_date != '0000-00-00') 
        {
          $data['fecha_fin_suministro'] = $original_renewal->old_end_date;
        }
        $this->db->update('tblcomicontratos', $data);
      }
      logActivity('Contract Renewed [RenewalID: ' . $id . ', ContractID: ' . $contractid . ']');

      return true;
    }

    return false;
  }
    
  /**
   * Get contract renewals
   * @param  mixed $id contract id
   * @return array
   */
  public function get_contract_renewal_history($id)
  {
    $this->db->where('contractid', $id);
    $this->db->order_by('date_renewed', 'asc');

    return $this->db->get('tblcomicontractrenewals')->result_array();
  }

  /**
   * Get contract termination motive
   * @param  mixed $id contract id
   * @return array
   */
  public function get_contract_termination_motive()
  {
    return $this->db->get('tblterminationmotive')->result_array();
  }
  
  /**
   * Get client types
   * @return array
   */
  public function get_client_types()
  {
    return $this->db->get('tblcvtype')->result_array();
  }
  
  /**
   * Get contact types
   * @return array
   */
  public function get_contact_types()
  {
    return $this->db->get('tblcvcontact_type')->result_array();
  }
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get get clientes object based on passed id if not passed id return array of all get clientes
   */
  public function get_clientes($id=''){
	  if($id!='') $this->db->where('userid', $id);
	  $result = $this->db->get('tblclients')->result_array();
	  
	  return $result;
  }
  
  /**
   * Get relation ship
   * @return array
   */
  public function get_relation_ship()
  {
    return $this->db->get('tblcvrelation_ship')->result_array();
  }
  
  /**
   * Get civil status
   * @return array
   */
  public function get_civil_status()
  {
    return $this->db->get('tblcvcivil_status')->result_array();
  }
  
  /**
   * Get payment method
   * @return array
   */
  public function get_payment_method()
  {
    return $this->db->get('tblcvpayment_method')->result_array();
  }
  
  /**
   * Get contract types
   * @return array
   */
  public function get_contract_types()
  {
    $contract_types = $this->db->get('tblcvcontract_types')->result_array();
    return $contract_types;
  }
  
  /**
   * Get banks
   * @return array
   */
  public function get_banks()
  {
    return $this->db->get('tblcvbanks')->result_array();
  }

  /**
   * Get banks loan
   * @return array
   */
  public function get_banks_loan()
  {
    return $this->db->get('tblcvbanks_loan')->result_array();
  }

  /**
   * Get tabla take data
   * @return row array
   */
  public function get_take_data($cliente=''){
    if ($id!="" && $cliente!=""){
      $this->db->where('client', $cliente);
    }
    
    return $this->db->get('tblcvtake_data')->row();
  }
  
  /**
   * Get tabla sales data
   * @return row array
   */
  public function get_sales_data($cliente=''){
    if ($id!="" && $cliente!=""){
      $this->db->where('client', $cliente);
    }
    
    return $this->db->get('tblcvsales_data')->row();
  }
  
  /**
   * Get tabla economic data
   * @return row array
   */
  public function get_economic_data($cliente=''){
    if ($id!="" && $cliente!=""){
      $this->db->where('client', $cliente);
    }
    
    return $this->db->get('tblcveconomic_data')->row();
  }
  
  /**
   * Get tabla operation banks
   * @return row array
   */
  public function get_operation_banks($cliente=''){
    if ($id!="" && $cliente!=""){
      $this->db->where('client', $cliente);
    }
    
    return $this->db->get('tblcvoperation_banks')->row();
  }
  
}
