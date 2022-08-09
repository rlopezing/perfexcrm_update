<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Commissions_model extends CRM_Model
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
	 * Get contract/s
	 * @param  mixed  $id         contract id
	 * @param  array   $where      perform where
	 * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
	 * @return mixed
	 */
  public function get($id = '', $where = [], $for_editor = false)
  {
    $this->db->select('*,tblcomicontratos.id as id, tblcomicontratos.addedfrom, tblterminationmotive.detalle');
    $this->db->where($where);
    $this->db->join('tblclients', 'tblclients.userid = tblcomicontratos.cliente','Left');
    $this->db->join('tblcominiveltension', 'tblcominiveltension.id = tblcomicontratos.nivel_tension','Left');
    $this->db->join('tblcomicomercializador', 'tblcomicomercializador.id = tblcomicontratos.comercializador','Left');
    $this->db->join('tblcomitarifa', 'tblcomitarifa.id = tblcomicontratos.tarifa','Left');
    $this->db->join('tblcominivelprecio', 'tblcominivelprecio.id = tblcomicontratos.nivel_precios','Left');
    $this->db->join('tblcomicategoriacomercial', 'tblcomicategoriacomercial.id = tblcomicontratos.categoria_comercial','Left');
    $this->db->join('tblstaff', 'tblstaff.staffid = tblcomicontratos.comercial','Left');
    $this->db->join('tblterminationmotive', 'tblterminationmotive.id = tblcomicontratos.termination_motive','Left');

    if (is_numeric($id)) 
    {
      $this->db->where('tblcomicontratos.id', $id);
      $contract = $this->db->get('tblcomicontratos')->row();
			
      return $contract;
    }
    $contracts = $this->db->get('tblcomicontratos')->result_array();
    
    return $contracts;
  }

    /**
     * Select unique contracts years
     * @return array
     */
    public function get_contracts_years()
    {
      return $this->db->query('SELECT DISTINCT(YEAR(fecha_inicio_suministro)) as year FROM tblcomicontratos')->result_array();
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
   * Add new contract
   */
  public function add($data)
  {
    unset($data['categoria_comercial_socio']);
  	
    $data['dateadded'] = date('Y-m-d H:i:s');
    $data['addedfrom'] = get_staff_user_id();
    
    unset($data['attachment']);

		$data['fecha_suscripcion'] = to_sql_date($data['fecha_suscripcion']);
		$data['fecha_envio'] = to_sql_date($data['fecha_envio']);
    $data['fecha_inicio_suministro'] = to_sql_date($data['fecha_inicio_suministro']);
    if ($data['fecha_fin_suministro'] == '') 
    {
      unset($data['fecha_fin_suministro']);
    } else {
      $data['fecha_fin_suministro'] = to_sql_date($data['fecha_fin_suministro']);
    }
		$data['fecha_comerciante'] = to_sql_date($data['fecha_comerciante']);
    $data['fecha_pago'] = to_sql_date($data['fecha_pago']);

    if (isset($data['trash']) && ($data['trash'] == 1 || $data['trash'] === 'on')) 
    {
        $data['trash'] = 1;
    } else {
        $data['trash'] = 0;
    }

    if (isset($data['not_visible_to_client']) && ($data['not_visible_to_client'] == 1 || $data['not_visible_to_client'] === 'on')) 
    {
        $data['not_visible_to_client'] = 1;
    } else {
        $data['not_visible_to_client'] = 0;
    }
    if (isset($data['custom_fields'])) {
        $custom_fields = $data['custom_fields'];
        unset($data['custom_fields']);
    }

    $data['hash'] = app_generate_hash();
    $data = do_action('before_contract_added', $data);
    $this->db->insert('tblcomicontratos', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
        if (isset($custom_fields)) {
            handle_custom_fields_post($insert_id, $custom_fields);
        }
        do_action('after_contract_added', $insert_id);
        logActivity('New Contract Added [' . $data['subject'] . ']');

        return $insert_id;
    }

    return false;
  }

  /**
   * @param  array $_POST data
   * @param  integer Contract ID
   * @return boolean
   */
  public function update($data, $id)
  {
  	unset($data['categoria_comercial_socio']);
    $affectedRows = 0;
    
    if ($data['fecha_suscripcion'] == '') { 
    	unset($data['fecha_suscripcion']); 
    } else { 
    	$data['fecha_suscripcion'] = to_sql_date($data['fecha_suscripcion']); 
    }
    if ($data['fecha_envio'] == '') { 
    	unset($data['fecha_envio']); 
    } else { 
    	$data['fecha_envio'] = to_sql_date($data['fecha_envio']); 
    }
    if ($data['fecha_inicio_suministro'] == '') { 
    	unset($data['fecha_inicio_suministro']); 
    } else { 
    	$data['fecha_inicio_suministro'] = to_sql_date($data['fecha_inicio_suministro']); 
    }
    if ($data['fecha_fin_suministro'] == '') {
      unset($data['fecha_fin_suministro']);
    } else {
      $data['fecha_fin_suministro'] = to_sql_date($data['fecha_fin_suministro']);
    }
    if ($data['fecha_comerciante'] == '') { 
    	unset($data['fecha_comerciante']); 
    } else { 
    	$data['fecha_comerciante'] = to_sql_date($data['fecha_comerciante']); 
    }
    if ($data['fecha_pago'] == '') { 
    	unset($data['fecha_pago']); 
    } else { 
    	$data['fecha_pago'] = to_sql_date($data['fecha_pago']); 
    }

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
    $_data = do_action('before_contract_updated', [
      'data' => $data,
      'id'   => $id,
    ]);
    $data = $_data['data'];
    if (isset($data['custom_fields'])) {
      $custom_fields = $data['custom_fields'];
      if (handle_custom_fields_post($id, $custom_fields)) {
        $affectedRows++;
      }
      unset($data['custom_fields']);
    }
    
    $this->db->where('id', $id);
    $this->db->update('tblcomicontratos', $data);
    if ($this->db->affected_rows() > 0){
      do_action('after_contract_updated', $id);
      logActivity('Contract Updated [' . $data['subject'] . ']');

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
    * Add contract comment
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
        $this->db->insert('tblcontractcomments', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $contract = $this->get($data['contract_id']);

            if (($contract->not_visible_to_client == '1' || $contract->trash == '1') && $client == false) {
                return true;
            }

            $this->load->model('emails_model');

            $this->emails_model->set_rel_id($data['contract_id']);
            $this->emails_model->set_rel_type('contract');

            if ($client == true) {

                // Get creator
                $this->db->select('staffid, email, phonenumber');
                $this->db->where('staffid', $contract->addedfrom);
                $staff_contract = $this->db->get('tblstaff')->result_array();

                $notifiedUsers = [];

                foreach ($staff_contract as $member) {
                    $notified = add_notification([
                        'description'     => 'not_contract_comment_from_client',
                        'touserid'        => $member['staffid'],
                        'fromcompany'     => 1,
                        'fromuserid'      => null,
                        'link'            => 'contracts/contract/' . $data['contract_id'],
                        'additional_data' => serialize([
                            $contract->subject,
                        ]),
                    ]);

                    if ($notified) {
                        array_push($notifiedUsers, $member['staffid']);
                    }

                    $merge_fields = [];
                    $merge_fields = array_merge($merge_fields, get_client_contact_merge_fields($contract->client));
                    $merge_fields = array_merge($merge_fields, get_contract_merge_fields($contract->id));
                    $merge_fields = array_merge($merge_fields, get_staff_merge_fields($member['staffid']));
                    // Send email/sms to admin that client commented
                    $this->emails_model->send_email_template('contract-comment-to-admin', $member['email'], $merge_fields);
                    $this->sms->trigger(SMS_TRIGGER_CONTRACT_NEW_COMMENT_TO_STAFF, $member['phonenumber'], $merge_fields);
                }
                pusher_trigger_notification($notifiedUsers);
            } else {
                $contacts = $this->clients_model->get_contacts($contract->client, ['active' => 1, 'contract_emails' => 1]);

                foreach ($contacts as $contact) {
                    $merge_fields = [];
                    $merge_fields = array_merge($merge_fields, get_client_contact_merge_fields($contract->client, $contact['id']));
                    $merge_fields = array_merge($merge_fields, get_contract_merge_fields($contract->id));
                    $this->emails_model->send_email_template('contract-comment-to-client', $contact['email'], $merge_fields);
                    $this->sms->trigger(SMS_TRIGGER_CONTRACT_NEW_COMMENT_TO_CUSTOMER, $contact['phonenumber'], $merge_fields);
                }
            }

            return true;
        }

        return false;
    }

    public function edit_comment($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tblcomicontractcomments', [
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
        $this->db->where('contract_id', $id);
        $this->db->order_by('dateadded', 'ASC');

        return $this->db->get('tblcomicontractcomments')->result_array();
    }

    /**
     * Get contract single comment
     * @param  mixed $id  comment id
     * @return object
     */
    public function get_comment($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('tblcomicontractcomments')->row();
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
        $this->db->delete('tblcomicontractcomments');
        if ($this->db->affected_rows() > 0) {
            logActivity('Contract Comment Removed [Contract ID:' . $comment->contract_id . ', Comment Content: ' . $comment->content . ']');

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
    public function delete($id)
    {
        do_action('before_contract_deleted', $id);
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


/*********************************************************************************************************************************
/****** COMERCIALIZADOR:
/*********************************************************************************************************************************

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get contract type object based on passed id if not passed id return array of all types
   */
  public function get_comercializador($id='')
  {
  	return $this->comercializador_model->get($id);
  }

  /**
   * @param  integer ID
   * @return mixed
   * Delete contract type from database, if used return array with key referenced
   */
  public function delete_contract_type($id)
  {
    return $this->contract_types_model->delete($id);
  }

  /**
   * Add new contract type
   * @param mixed $data All $_POST data
   */
  public function add_comercializador($data)
  {
    return $this->comercializador_model->add($data);
  }

  /**
   * Edit contract type
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_comercializador($data, $id)
  {
    return $this->comercializador_model->update($data, $id);
  }

  /**
   * Get contract types data for chart
   * @return array
   */
  public function get_comercializador_chart_data()
  {
  	return $this->comercializador_model->get_chart_data();
  }

  /**
  * Get contract types values for chart
  * @return array
  */
  public function get_comercializador_values_chart_data()
  {
    return $this->comercializador_model->get_values_chart_data();
  }
  
  /**
   * Delete contract type
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function delete_comercializador($id)
  {
    return $this->comercializador_model->delete($id);
  }
  
/*********************************************************************************************************************************
/****** TARIFA:
/*********************************************************************************************************************************
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get tarifa object based on passed id if not passed id return array of all tarifas
   */
  public function get_tarifa($id='', $country='',$module='')
  {
  	return $this->tarifa_model->get($id, $country, $module);
  }
  
  /**
   * Add new rate
   * @param mixed $data All $_POST data
   */
  public function add_tarifa($data)
  {
    return $this->tarifa_model->add($data);
  }
  
  /**
   * Edit rate
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function update_tarifa($data, $id)
  {
    return $this->tarifa_model->update($data, $id);
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete stress level from database, if used return array with key referenced
   */
  public function delete_rate($id)
  {
    return $this->tarifa_model->delete($id);
  }
  
  
/*********************************************************************************************************************************
/****** NIVEL PRECIOS:
/*********************************************************************************************************************************
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get price level object based on passed id if not passed id return array of all price level
   */
  public function get_price_level($id='',$comercializador='',$tarifa='',$country='',$module='')
  {
  	return $this->nivel_precios_model->get($id,$comercializador,$tarifa,$country,$module);
  }
  
  /**
   * Add new price level
   * @param mixed $data All $_POST data
   */
  public function add_price_level($data)
  {
    return $this->nivel_precios_model->add($data);
  }
  
  /**
   * Edit price level
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function update_price_level($data, $id)
  {
    return $this->nivel_precios_model->update($data, $id);
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete price level from database, if used return array with key referenced
   */
  public function delete_price_level($id)
  {
  	return $this->nivel_precios_model->delete($id);
  }
  
/*********************************************************************************************************************************
/****** COMMERCIAL CATEGORY:
/*********************************************************************************************************************************
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get commercial category object based on passed id if not passed id return array of all commercial category
   */
  public function get_commercial_category($id='',$opcion='')
  {
  	return $this->commercial_category_model->get($id,$opcion);
  }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get commercial category object based on passed id if not passed id return array of all commercial category
   */
  public function filtrar_commercial_category($id='', $country='', $module='')
  {
  	return $this->commercial_category_model->filtrar($id, $country, $module);
  }
  
  /**
   * Add new commercial category
   * @param mixed $data All $_POST data
   */
  public function add_commercial_category($data)
  {
    return $this->commercial_category_model->add($data);
  }
  
  /**
   * Edit commercial category
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function update_commercial_category($data, $id)
  {
    return $this->commercial_category_model->update($data, $id);
  }

  /**
   * Delete commercial category
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function delete_commercial_category($id)
  {
    return $this->commercial_category_model->delete($id);
  }

/*********************************************************************************************************************************
/****** COMMERCIAL:
/*********************************************************************************************************************************
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get commercial object based on passed id if not passed id return array of all commercial
   */
  public function get_commercial($id = '')
  {
  	return $this->commercial_model->get($id);
  }
  
  /**
   * Add new commercial
   * @param mixed $data All $_POST data
   */
  public function add_commercial($data)
  {
    return $this->commercial_model->add($data);
  }
  
  /**
   * Edit commercial
   * @param mixed $data All $_POST data
   * @param mixed $id commercial id
   */
  public function update_commercial($data, $id)
  {
    return $this->commercial_model->update($data, $id);
  }

/**********************************************************
/****** STRESS LEVEL:
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get stress level object based on passed id if not passed id return array of all stress level
   */
  public function get_stress_level($id = '')
  {
  	return $this->stress_level_model->get($id);
  }
  
  /**
   * Add new stress level
   * @param mixed $data All $_POST data
   */
  public function add_stress_level($data)
  {
    return $this->stress_level_model->add($data);
  }
  
  /**
   * Edit stress level
   * @param mixed $data All $_POST data
   * @param mixed $id stress level id
   */
  public function update_stress_level($data, $id)
  {
    return $this->stress_level_model->update($data, $id);
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete stress level from database, if used return array with key referenced
   */
  public function delete_stress_level($id)
  {
    return $this->stress_level_model->delete($id);
  }
  

/**********************************************************
/****** PARTNER:
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get partner object based on passed id if not passed id return array of all partner
   */
  public function get_partner($id='',$categoria_comercial='')
  {
  	return $this->partner_model->get($id,$categoria_comercial);
  }
  
  /**
   * Add new partner
   * @param mixed $data All $_POST data
   */
  public function add_partner($data)
  {
    return $this->partner_model->add($data);
  }
  
  /**
   * Edit partner
   * @param mixed $data All $_POST data
   * @param mixed $id partner id
   */
  public function update_partner($data, $id)
  {
    return $this->partner_model->update($data, $id);
  }

/**********************************************************
/****** COSTOS:
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get costos object based on passed id if not passed id return array of all costos
   */
  public function get_nivel_precios($id = '')
  {
	  //$this->db->where('contract_id', $id);
	  //$this->db->order_by('dateadded', 'ASC');

	  return $this->db->get('tblcominivelprecio')->result_array();
  }
  
  /**
   * Add new costos
   * @param mixed $data All $_POST data
   */
  public function add_costos($data)
  {
    $this->db->insert('tblcomiplanoscostos', $data);
    $insert_id = $this->db->insert_id();
    
    if ($insert_id) {
      return $insert_id;
    }

    return false;
  }

  /**
   * Delete costos
   * @param mixed $data All $_POST data
   */
  public function delete_costos($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('tblcomiplanoscostos');
    if ($this->db->affected_rows() > 0) {
      logActivity('Commission Coste Deleted [ID: ' . $id . ']');
      return true;
    }

    return false;
  }
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get obtener comisiones object based on passed id if not passed id return array of all obtener comisiones
   */
  public function get_obtener_comisiones($comercializador='',$tarifa='',$nivel_precios='',$categoria_comercial='',$consumo_anual='',
  	$country='',$module='')
  {
		$aColumns = [
			'tblcomiplanos.categoria_comercial as categoria_comercial',
		  'tblcomiplanoscostos.comision as comision',
		];

		$sIndexColumn = 'id';
		$sTable       = 'tblcomiplanos';

		$join = [
			'inner join tblcomiplanosconsumos on tblcomiplanosconsumos.plano = tblcomiplanos.id',
			'inner join tblcomiplanoscostos on tblcomiplanoscostos.consumo = tblcomiplanosconsumos.id',
		];
		
		$where = [
			'where tblcomiplanos.comercializador = '.$comercializador.' 
				and tblcomiplanos.tarifa = '.$tarifa.' 
				and tblcomiplanoscostos.nivel_precio = '.$nivel_precios.'
				and tblcomiplanos.categoria_comercial = '.$categoria_comercial.'
				and tblcomiplanosconsumos.limite_inferior <= '.$consumo_anual.'
				and tblcomiplanosconsumos.limite_superior >= '.$consumo_anual.'
				and tblcomiplanos.country_id = '.$country.'
				and tblcomiplanos.module_id = '.$module,
		];

		$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);
		$rResult = $result['rResult'];
  	
	  return $rResult;
  }
  
  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get obtener comisiones object based on passed id if not passed id return array of all obtener comisiones
   */
  public function get_obtener_comisiones_socio($comercializador='',$tarifa='',$categoria_comercial='',$consumo_anual='',$nivel_precio='',$country='',$module='') {
		$aColumns = [
			'tblcomiplanos.categoria_comercial as categoria_comercial',
		  'tblcomiplanoscostos.comision as comision',
		];
		$sIndexColumn = 'id';
		$sTable       = 'tblcomiplanos';
		$join = [
			'inner join tblcomiplanosconsumos on tblcomiplanosconsumos.plano = tblcomiplanos.id',
			'inner join tblcomiplanoscostos on tblcomiplanoscostos.consumo = tblcomiplanosconsumos.id',
		];
		$where = [
			'where tblcomiplanos.comercializador = '.$comercializador.' 
				and tblcomiplanos.tarifa = '.$tarifa.' 
				and tblcomiplanos.categoria_comercial = '.$categoria_comercial.' 
				and tblcomiplanoscostos.nivel_precio = '.$nivel_precio.' 
				and tblcomiplanosconsumos.limite_inferior <= '.$consumo_anual.' 
				and tblcomiplanosconsumos.limite_superior >= '.$consumo_anual.'
				and tblcomiplanos.country_id = '.$country.'
				and tblcomiplanos.module_id = '.$module,
		];

		$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);
		$rResult = $result['rResult'];
  	
	  return $rResult;
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
   * @param  integer ID (optional)
   * @return mixed
   * Get get clientes object based on passed id if not passed id return array of all get clientes
   */
  public function get_clientes_invoice($id='') {
  	$this->db->select("tblcomicomercializador.id, tblcomicomercializador.nombre, tblcomicomercializador.cliente");
  	$this->db->join("tblclients","tblclients.userid = tblcomicomercializador.cliente","inner");
  	if($id!='') {
  		$this->db->where('tblcomicomercializador.id', $id);
  		$result = $this->db->get('tblcomicomercializador')->row();	
  	} else {
			$result = $this->db->get('tblcomicomercializador')->result_array();
		}
	  
	  return $result;
  }
  
  
/**********************************************************
/****** STAFF ASSIGN:
    
  /**
   * Add new
   * @param mixed $data All $_POST data
   */
  public function add_staff_assign($data) {
    $this->db->insert('tblcomistaff_assign', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New staff assign Added');
      return $insert_id;
    }
    return false;
  }
  
  /**
   * Edit
   * @param mixed $data All $_POST data
   * @param mixed $id staff assign id
   */
  public function update_staff_assign($data, $id) {
    $this->db->where('id', $id);
    $this->db->update('tblcomistaff_assign', $data);
    if ($this->db->affected_rows() > 0) {
      logActivity('staff assign Updated ID:' . $id . ']');
      return true;
    }
    return false;
  }
  
  
  /**
	 * Get validator
	 * 
	 * @return mixed
	 */
  public function get_validator($id='',$id_link='',$tbl_link) {
    $this->db->where($id_link, $id);
    $data = $this->db->get($tbl_link)->result_array();
    $count = count($data);
    
    $response = 'true';
    if ($count == 0) $response = 'false';
    if ($count > 0) $response = 'true';
    
    return $response;
  }
  
  /**
   * Get countrys
   * @param mixed $data All $_POST data
   * @param mixed $id staff assign id
   */
  public function get_countries($id="") {
	  if($id!='') $this->db->where('country_id', $id);
	  $this->db->where("country_id in (209, 177)");
	  $result = $this->db->get('tblcountries')->result_array();
	  
	  return $result;
  }
  
  /**
   * Get modules
   * @param mixed $data All $_POST data
   * @param mixed $id staff assign id
   */
  public function get_modules($id="",$options='') {
	  if($id!='') $this->db->where('id', $id);
	  if($options!='') $this->db->where($options);
	  $this->db->order_by("name", "ASC");
	  $result = $this->db->get('tblmodule')->result_array();
	  
	  return $result;
  }

}
