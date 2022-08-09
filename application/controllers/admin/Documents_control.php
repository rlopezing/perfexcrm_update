<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Documents_control extends Admin_controller
{
  public function __construct() 
  {
    parent::__construct();
    $this->load->model('documents_control_model');
    $this->load->model('tarifa_model');
    $this->load->model('nivel_precios_model');
    $this->load->model('commercial_category_model');
    $this->load->model('commercial_model');
    $this->load->model('partner_model');
    $this->load->model('currencies_model');
    $this->load->model("simulators_model");
  }

  /* List all contracts */
  public function index() {
    close_setup_menu();
    if (!has_permission('documents_control', '', 'view') && !has_permission('documents_control', '', 'view_own')) access_denied('documents_control');

    if ($this->input->post()) 
    {
      $dat_form = $this->input->post();
      
      $_SESSION['$fdesde'] 			= "";
      $_SESSION['$fhasta'] 			= "";
      if ($dat_form['fdesde']!='') $_SESSION['$fdesde'] = date('Y-m-d', strtotime($dat_form['fdesde']));
      if ($dat_form['fhasta']!='') $_SESSION['$fhasta'] = date('Y-m-d', strtotime($dat_form['fhasta']));
      if ($dat_form['cliente']) {
        $_SESSION['cliente'] = $dat_form['cliente'];
        $data['cliente'] = $dat_form['cliente'];
      }
    } else {
      $_SESSION['$fdesde'] 			= "";
      $_SESSION['$fhasta'] 			= "";
      $_SESSION['cliente'] 			= "";
      $data['cliente']					= "";
    }

    $data['title']         			= _l('documents_control');
    $data['years']              = $this->documents_control_model->get_visits_years();
    $data['base_currency']      = $this->currencies_model->get_base_currency();
    $data['list_clients']				= $this->documents_control_model->get_clientes();

    $this->load->view('admin/document_control/manage', $data);
  }
    
  public function table($clientid = '')
  {
    if (!has_permission('documents_control', '', 'view') && !has_permission('documents_control', '', 'view_own')) ajax_access_denied();
    $this->app->get_table_data('documents_control', ['clientid' => $clientid,]);
  }

  /* Edit contract or add new contract */
  public function document_control($id = '') {
    if ($this->input->post()) {
      if ($id == ''){
        if (!has_permission('commercials_visits', '', 'create')) access_denied('commercials_visits');
        $id = $this->documents_control_model->add($this->input->post());
        if ($id) {
          set_alert('success', _l('added_successfully', _l('contract')));
          redirect(admin_url('commercials_visits/'));
        }
      } else {
        if (!has_permission('commercials_visits', '', 'edit')) access_denied('commercials_visits');
        $success = $this->documents_control_model->update($this->input->post(), $id);
        if ($success) set_alert('success', _l('updated_successfully', _l('contract')));
        redirect(admin_url('commissions/'));
      }
    }

    if ($id == '') {
      $title 								= _l('add_new', _l('contract_lowercase'));
      $data['accion'] 			= "new";
    }

    if ($this->input->get('customer_id')) $data['customer_id'] = $this->input->get('customer_id');	
    $data['title'] 					= $title;
    $data['bodyclass']      = 'contract';
    $data['types']          = $this->documents_control_model->get_client_types();
    $data['contact_types']  = $this->documents_control_model->get_contact_types();
    

    $this->load->view('admin/commercial_visit/commercial_visit', $data);
  }

  public function get_template() {
    $name = $this->input->get('name');
    echo $this->load->view('admin/contracts/templates/' . $name, [], true);
  }

  public function pdf($id) {
    if (!has_permission('commissions', '', 'view') && !has_permission('commissions', '', 'view_own')) {
      access_denied('commissions');
    }
    if (!$id) {
      redirect(admin_url('contracts'));
    }

    $contract = $this->commissions_model->get($id);
    try {
      $pdf = contract_pdf($contract);
    } catch (Exception $e) {
      echo $e->getMessage();
      die;
    }

    $type = 'D';
    if ($this->input->get('output_type')) {
      $type = $this->input->get('output_type');
    }
    if ($this->input->get('print')) {
      $type = 'I';
    }

    $pdf->Output(slug_it($contract->subject) . '.pdf', $type);
  }

    public function send_to_email($id)
    {
        if (!has_permission('commissions', '', 'view') && !has_permission('commissions', '', 'view_own')) {
            access_denied('commissions');
        }
        $success = $this->commissions_model->send_contract_to_client($id, $this->input->post('attach_pdf'), $this->input->post('cc'));
        if ($success) {
            set_alert('success', _l('contract_sent_to_client_success'));
        } else {
            set_alert('danger', _l('contract_sent_to_client_fail'));
        }
        redirect(admin_url('contracts/contract/' . $id));
    }

    public function add_note($rel_id)
    {
        if ($this->input->post() && (has_permission('commissions', '', 'view') || has_permission('commissions', '', 'view_own'))) {
            $this->misc_model->add_note($this->input->post(), 'contract', $rel_id);
            echo $rel_id;
        }
    }

    public function get_notes($id)
    {
        if ((has_permission('commissions', '', 'view') || has_permission('commissions', '', 'view_own'))) {
            $data['notes'] = $this->misc_model->get_notes($id, 'contract');
            $this->load->view('admin/includes/sales_notes_template', $data);
        }
    }

    public function clear_signature($id)
    {
      if (has_permission('commissions', '', 'delete')) {
          $this->commissions_model->clear_signature($id);
      }

      redirect(admin_url('contracts/contract/' . $id));
    }

    public function save_contract_data()
    {
        if (!has_permission('commissions', '', 'edit') && !has_permission('commissions', '', 'create')) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die;
        }

        $success = false;
        $message = '';

        $this->db->where('id', $this->input->post('contract_id'));
        $this->db->update('tblcontracts', [
                'content' => $this->input->post('content', false),
        ]);

        $success = $this->db->affected_rows() > 0;
        $message = _l('updated_successfully', _l('contract'));

        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function add_comment()
    {
        if ($this->input->post()) {
            echo json_encode([
                'success' => $this->commissions_model->add_comment($this->input->post()),
            ]);
        }
    }

    public function edit_comment($id)
    {
        if ($this->input->post()) {
            echo json_encode([
                'success' => $this->commissions_model->edit_comment($this->input->post(), $id),
                'message' => _l('comment_updated_successfully'),
            ]);
        }
    }

    public function get_comments($id)
    {
        $data['comments'] = $this->commissions_model->get_comments($id);
        $this->load->view('admin/contracts/comments_template', $data);
    }

    public function remove_comment($id)
    {
        $this->db->where('id', $id);
        $comment = $this->db->get('tblcontractcomments')->row();
        if ($comment) {
            if ($comment->staffid != get_staff_user_id() && !is_admin()) {
                echo json_encode([
                    'success' => false,
                ]);
                die;
            }
            echo json_encode([
                'success' => $this->commissions_model->remove_comment($id),
            ]);
        } else {
            echo json_encode([
                'success' => false,
            ]);
        }
    }

  public function termination()
  {
    if (!has_permission('commissions', '', 'create') && !has_permission('commissions', '', 'edit')) 
    {
      access_denied('commissions');
  	}
    if ($this->input->post()) 
    {
      $data    = $this->input->post();
      $success = $this->commissions_model->termination($data);
      if ($success) 
      {
        set_alert('success', _l('contract_terminate_successfully'));
      } else {
        set_alert('warning', _l('contract_terminate_fail'));
      }
      redirect(admin_url('commissions/contract/' . $data['contractid'] . '?tab=tab_content'));
  	}
  }

  public function renew()
  {
    if (!has_permission('commissions', '', 'create') && !has_permission('commissions', '', 'edit')) 
    {
      access_denied('commissions');
  	}
    if ($this->input->post()) 
    {
      $data    = $this->input->post();
      $success = $this->commissions_model->renew($data);
      if ($success) 
      {
        set_alert('success', _l('contract_renewed_successfully'));
      } else {
        set_alert('warning', _l('contract_renewed_fail'));
      }
      redirect(admin_url('commissions/contract/' . $data['contractid'] . '?tab=renewals'));
  	}
  }

  public function delete_renewal($renewal_id, $contractid)
  {
    $success = $this->commissions_model->delete_renewal($renewal_id, $contractid);
    if ($success) {
      set_alert('success', _l('contract_renewal_deleted'));
    } else {
      set_alert('warning', _l('contract_renewal_delete_fail'));
    }
    
    redirect(admin_url('commissions/contract/' . $contractid . '?tab=renewals'));
  }

  public function copy($id)
  {
    if (!has_permission('commissions', '', 'create')) {
      access_denied('commissions');
    }
    if (!$id) {
      redirect(admin_url('contracts'));
    }
    $newId = $this->commissions_model->copy($id);
    if ($newId) {
      set_alert('success', _l('contract_copied_successfully'));
    } else {
      set_alert('warning', _l('contract_copied_fail'));
    }
    redirect(admin_url('commissions/contract/' . $newId));
  }

  /* Delete contract from database */
  public function delete($id)
  {
      if (!has_permission('commissions', '', 'delete')) {
        access_denied('commissions');
      }
      if (!$id) {
        redirect(admin_url('contracts'));
      }
      $response = $this->commissions_model->delete($id);
      if ($response == true) {
          set_alert('success', _l('deleted', _l('contract')));
      } else {
          set_alert('warning', _l('problem_deleting', _l('contract_lowercase')));
      }
      if (strpos($_SERVER['HTTP_REFERER'], 'clients/') !== false) {
          redirect($_SERVER['HTTP_REFERER']);
      } else {
          redirect(admin_url('commissions'));
      }
  }

	// Manage.  
  public function marketer_mant() {
    if (!is_admin()) {
        access_denied('commissions');
    }
    if ($this->input->is_ajax_request()) {
        $this->app->get_table_data('marketer');
    }
    $data['clients']		= $this->commissions_model->get_clientes();
    $data['title'] 			= _l('contract_marketer');
    
    $this->load->view('admin/commission/manage_marketer', $data);
  }

  /* Manage comercilaizador Since Version 1.0.3 */
  public function comercializador($id = '')
  {
      if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') 
      {
          access_denied('commissions');
      }
      if ($this->input->post()) 
      {
          if (!$this->input->post('id')) {
              $id = $this->commissions_model->add_comercializador($this->input->post());
              if ($id) {
                  $success = true;
                  $message = _l('added_successfully', _l('comercializador'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
                  'id'      => $id,
                  'name'    => $this->input->post('nombre'),
              ]);
          } else {
              $data = $this->input->post();
              $id   = $data['id'];
              unset($data['id']);
              $success = $this->commissions_model->update_comercializador($data, $id);
              $message = '';
              if ($success) {
                  $message = _l('updated_successfully', _l('comercializador'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
              ]);
          }
      }
  }
  
  // Delete announcement from database
  public function delete_marketer($id)
  {
    if (!$id) {
      redirect(admin_url('commissions/marketer_mant'));
    }
    if (!is_admin()) {
      access_denied('commissions');
    }
    
    // for rate
    $validator = $this->get_validator($id,'comercializador','tblcomitarifa');
    if ($validator == 'true') {
			set_alert('warning', _l('problem_deleting', _l('commission_marketer').' '._l('commissions_associated')._l('simulator_rates')));
			redirect(admin_url('commissions/marketer_mant'));
		}
		// for price level
    $validator = $this->get_validator($id,'comercializador','tblcominivelprecio');
    if ($validator == 'true') {
			set_alert('warning', _l('problem_deleting', _l('commission_marketer').' '._l('commissions_associated')._l('general_map_price_level')));
			redirect(admin_url('commissions/marketer_mant'));
		}
		// for commissional plan
    $validator = $this->get_validator($id,'comercializador','tblcomiplanos');
    if ($validator == 'true') {
			set_alert('warning', _l('problem_deleting', _l('commission_marketer').' '._l('commissions_associated')._l('commission_plan_title')));
			redirect(admin_url('commissions/marketer_mant'));
		}

    $response = $this->commissions_model->delete_comercializador($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('contract_marketer')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('contract_marketer')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('contract_marketer')));
    }
    
    redirect(admin_url('commissions/marketer_mant'));
  }
  

    public function types()
    {
        if (!is_admin()) {
            access_denied('commissions');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('contract_types');
        }
        $data['title'] = _l('contract_types');
        $this->load->view('admin/contracts/manage_types', $data);
    }

    /* Delete announcement from database */
    public function delete_contract_type($id)
    {
        if (!$id) {
            redirect(admin_url('contracts/types'));
        }
        if (!is_admin()) {
            access_denied('commissions');
        }
        $response = $this->commissions_model->delete_contract_type($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('contract_type_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('contract_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('contract_type_lowercase')));
        }
        redirect(admin_url('contracts/types'));
    }

    public function add_contract_attachment($id)
    {
        handle_contract_attachment($id);
    }

    public function add_external_attachment()
    {
        if ($this->input->post()) {
            $this->misc_model->add_attachment_to_database($this->input->post('contract_id'), 'contract', $this->input->post('files'), $this->input->post('external'));
        }
    }

    public function delete_contract_attachment($attachment_id)
    {
        $file = $this->misc_model->get_file($attachment_id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo json_encode([
                'success' => $this->commissions_model->delete_contract_attachment($attachment_id),
            ]);
        }
    }
    
//////////////////////////////////////
/// RATE.
    
	// Manage.  
  public function rate_mant() {
    if (!is_admin()) {
      access_denied('commissions');
    }
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('rate');
    }
    
    $data['country'] = "";
    $data['module'] = "";
    if ($this->input->post()) {
	    $filtro = $this->input->post();
	    $_SESSION['country_id'] = $filtro['country_id'];
	    $_SESSION['module_id'] = $filtro['module_id'];
	    $data['country'] = $filtro['country_id'];
	    $data['module'] = $filtro['module_id'];
		}
    
    $data['countries'] = $this->commissions_model->get_countries();
    $data['modules'] = $this->commissions_model->get_modules();
    $data['title'] = _l('contract_rate');
    
    $this->load->view('admin/commission/manage_rate', $data);
  }
    
  /* Manage rate Since Version 1.0.3 */
  public function tarifa($id = '') {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('commissions');
    }
    if ($this->input->post()) {
        if (!$this->input->post('id')) {
        		$data = $this->input->post();
        		unset($data['rmodule']);
            $id = $this->commissions_model->add_tarifa($data);
            if ($id) {
                $success = true;
                $message = _l('added_successfully', _l('contract_rate'));
            }
            echo json_encode([
                'success' => $success,
                'message' => $message,
                'id'      => $id,
                'descripcion'    => $this->input->post('descripcion'),
            ]);
        } else {
            $data = $this->input->post();
            $id   = $data['id'];
            unset($data['id']);
            unset($data['rmodule']);
            $success = $this->commissions_model->update_tarifa($data, $id);
            $message = '';
            if ($success) {
                $message = _l('updated_successfully', _l('contract_rate'));
            }
            echo json_encode([
                'success' => $success,
                'message' => $message,
            ]);
        }
    }
  }
  
  // Delete announcement from database
  public function delete_rate($id)
  {
    if (!$id) {
      redirect(admin_url('commissions/rate_mant'));
    }
    if (!is_admin()) {
      access_denied('commissions');
    }
    $response = $this->commissions_model->delete_rate($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('contract_rate')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('contract_rate')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('contract_rate')));
    }
    redirect(admin_url('commissions/rate_mant'));
  }
  
///////////////////////////////
// PRICE LEVEL.

	// Manage.  
  public function price_level_mant() {
    if (!is_admin()) {
        access_denied('commissions');
    }
    if ($this->input->is_ajax_request()) {
        $this->app->get_table_data('price_level');
    }
    
    $data["module"] = 0;
    $data["country"] = 0;
    $_SESSION['country_id'] = 0;
    $_SESSION['module_id'] = 0;
    if ($this->input->post()) {
    	$filtro = $this->input->post();
    	$_SESSION['country_id'] = $filtro['country_id'];
    	$_SESSION['module_id'] = $filtro['module_id'];
    	$data["country"] = $filtro['country_id'];
    	$data["module"] = $filtro['module_id'];
		}
    
    $data['title'] = _l('price_level');
    $data['comercializador'] = $this->commissions_model->get_comercializador();
    $data['countries'] = $this->commissions_model->get_countries();
    $data['modules'] = $this->commissions_model->get_modules();
    $data['tarifa'] = [];
    $this->load->view('admin/commission/manage_price_level', $data);
  }
    
  /* Manage price level Since Version 1.0.3 */
  public function price_level($id = '')
  {
      if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') 
      {
          access_denied('commissions');
      }
      if ($this->input->post()) 
      {
          if (!$this->input->post('id')) {
              $id = $this->commissions_model->add_price_level($this->input->post());
              if ($id) {
                  $success = true;
                  $message = _l('added_successfully', _l('price_level'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
                  'id'      => $id,
                  'detalle'    => $this->input->post('detalle'),
              ]);
          } else {
              $data = $this->input->post();
              $id   = $data['id'];
              unset($data['id']);
              $success = $this->commissions_model->update_price_level($data, $id);
              $message = '';
              if ($success) {
                  $message = _l('updated_successfully', _l('price_level'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
              ]);
          }
      }
  }
  
  // Delete announcement from database
  public function delete_price_level($id) {
    if (!$id) {
      redirect(admin_url('commissions/price_level_mant'));
    }
    if (!is_admin()) {
      access_denied('commissions');
    }
    
    $response = $this->commissions_model->delete_price_level($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('price_level')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('price_level')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('price_level')));
    }
    redirect(admin_url('commissions/price_level_mant'));
  }
  

//////////////////////////////////////////
/// COMMERCIAL CATEGORY.

	// Manage.  
  public function commercial_category_mant() {
    if (!is_admin()) {
      access_denied('commissions');
    }
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('commercial_category');
    }
    
    $data['country'] = 0;
    $_SESSION['country_id'] = 0;
    if ($this->input->post()) {
    	$filtro = $this->input->post();
    	$_SESSION['country_id'] = $filtro['country_id'];
    	$data['country'] = $filtro['country_id'];
		}
    
    $data['title'] = _l('commercial_category');
    $data['countries'] = $this->commissions_model->get_countries();
    
    $this->load->view('admin/commission/manage_commercial_category', $data);
  }

  /* Manage commercial category Version 1.0.3 */
  public function commercial_category($id = '')
  {
      if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') 
      {
          access_denied('commissions');
      }
      if ($this->input->post()) 
      {
          if (!$this->input->post('id')) {
              $id = $this->commissions_model->add_commercial_category($this->input->post());
              if ($id) {
                  $success = true;
                  $message = _l('added_successfully', _l('commercial_category'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
                  'id'      => $id,
                  'detalle'    => $this->input->post('detalle'),
              ]);
          } else {
              $data = $this->input->post();
              $id   = $data['id'];
              unset($data['id']);
              $success = $this->commissions_model->update_commercial_category($data, $id);
              $message = '';
              if ($success) {
                  $message = _l('updated_successfully', _l('commercial_category'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
              ]);
          }
      }
  }

  // Delete announcement from database
  public function delete_commercial_category($id)
  {
    if (!$id) {
      redirect(admin_url('commissions/commercial_category_mant'));
    }
    if (!is_admin()) {
      access_denied('commissions');
    }
    $response = $this->commissions_model->delete_commercial_category($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('commercial_category')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('commercial_category')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('commercial_category')));
    }
    redirect(admin_url('commissions/commercial_category_mant'));
  }
  
  
///////////////////////////////////////  

  /* Manage commercial Version 1.0.3 */
  public function commercial($id = '')
  {
      if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') 
      {
          access_denied('commissions');
      }
      if ($this->input->post()) 
      {
          if (!$this->input->post('id')) {
              $id = $this->commissions_model->add_commercial($this->input->post());
              if ($id) {
                  $success = true;
                  $message = _l('added_successfully', _l('contract_commercial'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
                  'id'      => $id,
                  'nombre'    => $this->input->post('nombre'),
              ]);
          } else {
              $data = $this->input->post();
              $id   = $data['id'];
              unset($data['id']);
              $success = $this->commissions_model->update_commercial($data, $id);
              $message = '';
              if ($success) {
                  $message = _l('updated_successfully', _l('contract_commercial'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
              ]);
          }
      }
  }


///////////////////////////////////////////////
/// Stress level Version 1.0.3

	// Manage.  
  public function stress_level_mant() {
    if (!is_admin()) {
      access_denied('commissions');
    }
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('stress_level');
    }
    $data['title'] = _l('contract_stress_level');
    $this->load->view('admin/commission/manage_stress_level', $data);
  }
  
  // Stress level new and edit.
  public function stress_level($id = '') {
      if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') 
      {
          access_denied('commissions');
      }
      if ($this->input->post()) 
      {
          if (!$this->input->post('id')) {
              $id = $this->commissions_model->add_stress_level($this->input->post());
              if ($id) {
                  $success = true;
                  $message = _l('added_successfully', _l('contract_stress_level'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
                  'id'      => $id,
                  'nombre'    => $this->input->post('nombre'),
              ]);
          } else {
              $data = $this->input->post();
              $id   = $data['id'];
              unset($data['id']);
              $success = $this->commissions_model->update_stress_level($data, $id);
              $message = '';
              if ($success) {
                  $message = _l('updated_successfully', _l('contract_stress_level'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
              ]);
          }
      }
  }
  
  // Delete announcement from database
  public function delete_stress_level($id)
  {
    if (!$id) {
      redirect(admin_url('commissions/stress_level_mant'));
    }
    if (!is_admin()) {
      access_denied('commissions');
    }
    
    $this->load->model('commissions_model');
    $response = $this->commissions_model->delete_stress_level($id);
    
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('stress_level')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('stress_level')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('stress_level')));
    }
    redirect(admin_url('commissions/stress_level_mant'));
  }
    
///////////////////////////////////////////////
///////////////////////////////////////////////

  /* Manage partner Version 1.0.3 */
  public function partner($id = '')
  {
      if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') 
      {
          access_denied('commissions');
      }
      if ($this->input->post()) 
      {
          if (!$this->input->post('id')) {
              $id = $this->commissions_model->add_partner($this->input->post());
              if ($id) {
                  $success = true;
                  $message = _l('added_successfully', _l('contract_stress_level'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
                  'id'      => $id,
                  'nombre'    => $this->input->post('nombre'),
              ]);
          } else {
              $data = $this->input->post();
              $id   = $data['id'];
              unset($data['id']);
              $success = $this->commissions_model->update_partner($data, $id);
              $message = '';
              if ($success) {
                  $message = _l('updated_successfully', _l('contract_stress_level'));
              }
              echo json_encode([
                  'success' => $success,
                  'message' => $message,
              ]);
          }
      }
      
      die;
  }

	public function filtrar_tarifa($country='',$module='') {
		$tarifa = $this->commissions_model->get_tarifa('',$country,$module);
		echo json_encode($tarifa);
	}
	
	public function filtrar_categoria_comercial($country='',$module='') {
		$categoria_comercial = $this->commissions_model->filtrar_commercial_category('',$country,$module);
		echo json_encode($categoria_comercial);
	}
	
	public function filtrar_precios($comercializador,$tarifa,$country,$module) {
		$price_level = $this->commissions_model->get_price_level('',$comercializador,$tarifa,$country,$module);
		echo json_encode($price_level);
	}
	
	public function filtrar_socios($categoria_comercial) {
		$socios = $this->commissions_model->get_partner('',$categoria_comercial);
		echo json_encode($socios);
	}
	
	public function dat_cliente($id) {
		$cliente = $this->commissions_model->get_clientes($id);
		echo json_encode($cliente);
	}

	public function obtener_comisiones($comercializador,$tarifa,$nivel_precios,$categoria_comercial,$consumo_anual,$country,$module) {
		$comisiones = $this->commissions_model->get_obtener_comisiones($comercializador,$tarifa,$nivel_precios,$categoria_comercial,$consumo_anual,$country,$module);
		if (empty($comisiones)) {
			$comisiones = array(
				"categoria_comercial" => "0",
				"comision" => "0"
			);
      $comisiones = [$comisiones];
		}
		echo json_encode($comisiones);
	}

	public function obtener_comisiones_socio($comercializador,$tarifa,$categoria_comercial,$consumo_anual,$nivel_precio,$country,$module) {
		$comisiones = $this->commissions_model->get_obtener_comisiones_socio($comercializador,$tarifa,$categoria_comercial,$consumo_anual,$nivel_precio,$country,$module);
		if (empty($comisiones)) {
			$comisiones = array(
				"categoria_comercial" => "0",
				"comision" => "0"
			);
      $comisiones = [$comisiones];
		}
		echo json_encode($comisiones);
	}
	
///////////////////////////////////////////////
/// Staff assign

	// Manage.  
  public function staff_assign_mant() {
    if (!is_admin()) {
      access_denied('commissions');
    }
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('staff_assign');
    }
    $data['title'] = _l('contract_stress_level');
    $data['commercial_category'] = $this->commissions_model->get_commercial_category('','todos');
    $this->load->view('admin/commission/manage_staff_assign', $data);
  }
  
  // New and edit.
  public function staff_assign($id = '') {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('commissions');
    }
    if ($this->input->post()) {
      if (!$this->input->post('id')) {
        $id = $this->commissions_model->add_staff_assign($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('commissions_assign'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->commissions_model->update_staff_assign($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('commissions_assign'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
    }
  }
  
	/**
	 * Get validator
	 * 
	 * @return mixed
	 */
  public function get_validator($id='',$id_link='',$tbl_link) {
    $response = $this->commissions_model->get_validator($id,$id_link,$tbl_link);
    
    return $response;
  }
  
	/**
	 * Deregister for contract
	 * 
	 * @return mixed
	*/
  public function deregister($id='')
  {
    
    
  }
  
	/**
	 * Deregister for contract
	 * 
	 * @return mixed
	*/
  public function renovate($id='')
  {
    $title 															= _l('add_new', _l('contract_lowercase'));
    $data['accion'] 										= "new";
    
    $contract = $this->commissions_model->get($id, [], true);
    unset($contract['id']);
    $data['contract']                 	= $contract;
    $data['contract_renewal_history'] 	= $this->commissions_model->get_contract_renewal_history($id);
    $comer 															= $data['contract']->comercializador;
    $data['tarifa'] 										= $this->commissions_model->get_tarifa('',$comer);
    $rate 															= $data['contract']->tarifa;
    $data['nivel_precios'] 							= $this->commissions_model->get_nivel_precios($rate);

    if ($this->input->get('customer_id'))
    {
			$data['customer_id'] 								= $this->input->get('customer_id');	
		}
    $data['base_currency'] 								= $this->currencies_model->get_base_currency();
    $data['comercializador'] 							= $this->commissions_model->get_comercializador();
    $data['commercial_category'] 					= $this->commissions_model->get_commercial_category();
    $data['commercial'] 									= $this->commissions_model->get_commercial();
    $data['nivel_tension'] 								= $this->commissions_model->get_stress_level();
    $data['socio'] 												= $this->commissions_model->get_partner();
    $data['title'] 												= $title;
    $data['bodyclass'] 										= 'contract';
    $data['decimal_separator'] 						= $this->simulators_model->decimal_separator()->value;
    $data['countries'] 										= $this->commissions_model->get_countries();
    $data['modules'] 											= $this->commissions_model->get_modules("", "id in (1,3)");
    
  	$d1 = array('id'=>12,'valor'=>'12 meses');
  	$d2 = array('id'=>18,'valor'=>'18 meses');
  	$d3 = array('id'=>24,'valor'=>'24 meses');
  	$d4 = array('id'=>36,'valor'=>'36 meses');
    $duration = array($d1,$d2,$d3,$d4);
    $data['duration'] = $duration;
      
    $this->load->view('admin/commission/contract', $data);
  }
  
/************************************
 * TAKE DATA CLIENT
 */  
  
  /* List all clients */
  public function take_data()
  {
    if (!has_permission('commercials_visits', '', 'view')) {
      if (!have_assigned_customers() && !has_permission('commercials_visits', '', 'create')) access_denied('commercials_visits');
    }

    $data['title']              = _l('commercial_visit_take_fordata');
    $this->load->model('contracts_model');
    $data['contract_types']     = $this->contracts_model->get_contract_types();
    $this->load->model('clients_model');
    $data['groups']             = $this->clients_model->get_groups();
    $this->load->model('proposals_model');
    $data['proposal_statuses']  = $this->proposals_model->get_statuses();
    $this->load->model('invoices_model');
    $data['invoice_statuses']   = $this->invoices_model->get_statuses();
    $this->load->model('estimates_model');
    $data['estimate_statuses']  = $this->estimates_model->get_statuses();
    $this->load->model('projects_model');
    $data['project_statuses']   = $this->projects_model->get_project_statuses();
    $data['customer_admins']    = $this->clients_model->get_customers_admin_unique_ids();

    $whereContactsLoggedIn = '';
    if (!has_permission('customers', '', 'view')) {
      $whereContactsLoggedIn = ' AND userid IN (SELECT customer_id FROM '.db_prefix().'customer_admins WHERE staff_id=' . get_staff_user_id() . ')';
    }

    $data['contacts_logged_in_today'] = $this->clients_model->get_contacts('', 'last_login LIKE "' . date('Y-m-d') . '%"' . $whereContactsLoggedIn);
    $data['countries']                = $this->clients_model->get_clients_distinct_countries();

    $this->load->view('admin/commercial_visit/manage_clients', $data);
  }
  
  public function table_clients()
  {
    if (!has_permission('customers', '', 'view')) {
      if (!have_assigned_customers() && !has_permission('customers', '', 'create')) ajax_access_denied();
    }

    $this->app->get_table_data('take_data_clients');
  }
  
  /* form take data client */
  public function take_form($id='')
  {
    if (!has_permission('commercials_visits', '', 'view')) if ($id != '' && !is_customer_admin($id)) access_denied('commercials_visits');

    if ($this->input->post() && !$this->input->is_ajax_request()) {
        if ($id == '') {
            if (!has_permission('customers', '', 'create')) access_denied('customers');
            $data = $this->input->post();

            $save_and_add_contact = false;
            if (isset($data['save_and_add_contact'])) {
                unset($data['save_and_add_contact']);
                $save_and_add_contact = true;
            }
            $id = $this->clients_model->add($data);
            if (!has_permission('customers', '', 'view')) {
                $assign['customer_admins']   = [];
                $assign['customer_admins'][] = get_staff_user_id();
                $this->clients_model->assign_admins($assign, $id);
            }
            if ($id) {
                set_alert('success', _l('added_successfully', _l('client')));
                if ($save_and_add_contact == false) {
                    redirect(admin_url('clients/client/' . $id));
                } else {
                    redirect(admin_url('clients/client/' . $id . '?group=contacts&new_contact=true'));
                }
            }
        } else {
            if (!has_permission('customers', '', 'edit')) {
                if (!is_customer_admin($id)) access_denied('customers');
            }
            $success = $this->clients_model->update($this->input->post(), $id);
            if ($success == true) {
                set_alert('success', _l('updated_successfully', _l('client')));
            }
            redirect(admin_url('clients/client/' . $id));
        }
    }

    $group         = !$this->input->get('group') ? 'profile' : $this->input->get('group');
    $data['group'] = $group;

    if ($group != 'contacts' && $contact_id = $this->input->get('contactid')) {
        redirect(admin_url('clients/client/' . $id . '?group=contacts&contactid=' . $contact_id));
    }

    // Customer groups
    $data['groups'] = $this->clients_model->get_groups();
    
    $id = ''; //Forzado temporal mientras para diseño

    if ($id == '') {
        $title = _l('add_new', _l('client_lowercase'));
        $data['accion'] = "nuevo";
    } else {
        $client                = $this->clients_model->get($id);
        $data['customer_tabs'] = get_customer_profile_tabs();

        // Supply points.
        $this->load->model('commissions_model');
        $data['supply_points'] = $this->clients_model->get_supply_points($id);
        $data['rates'] = $this->commissions_model->get_tarifa('','','3');
        $data['rates_gas'] = $this->commissions_model->get_tarifa('','','4');
        $data['countries'] = $this->commissions_model->get_countries();
        $data['modules'] = $this->commissions_model->get_modules();
        $this->load->model('simulators_model');
        $data['decimal_separator'] = $this->simulators_model->decimal_separator()->value;
        $data['accion'] = "edicion";

        if (!$client) {
            show_404();
        }

        $data['contacts'] = $this->clients_model->get_contacts($id);
        $data['tab']      = isset($data['customer_tabs'][$group]) ? $data['customer_tabs'][$group] : null;

        if (!$data['tab']) {
            show_404();
        }

        // Fetch data based on groups
        if ($group == 'profile') {
            $data['customer_groups'] = $this->clients_model->get_customer_groups($id);
            $data['customer_admins'] = $this->clients_model->get_admins($id);
        } elseif ($group == 'attachments') {
            $data['attachments'] = get_all_customer_attachments($id);
        } elseif ($group == 'vault') {
            $data['vault_entries'] = hooks()->apply_filters('check_vault_entries_visibility', $this->clients_model->get_vault_entries($id));

            if ($data['vault_entries'] === -1) {
                $data['vault_entries'] = [];
            }
        } elseif ($group == 'estimates') {
            $this->load->model('estimates_model');
            $data['estimate_statuses'] = $this->estimates_model->get_statuses();
        } elseif ($group == 'invoices') {
            $this->load->model('invoices_model');
            $data['invoice_statuses'] = $this->invoices_model->get_statuses();
        } elseif ($group == 'credit_notes') {
            $this->load->model('credit_notes_model');
            $data['credit_notes_statuses'] = $this->credit_notes_model->get_statuses();
            $data['credits_available']     = $this->credit_notes_model->total_remaining_credits_by_customer($id);
        } elseif ($group == 'payments') {
            $this->load->model('payment_modes_model');
            $data['payment_modes'] = $this->payment_modes_model->get();
        } elseif ($group == 'notes') {
            $data['user_notes'] = $this->misc_model->get_notes($id, 'customer');
        } elseif ($group == 'projects') {
            $this->load->model('projects_model');
            $data['project_statuses'] = $this->projects_model->get_project_statuses();
        } elseif ($group == 'statement') {
            if (!has_permission('invoices', '', 'view') && !has_permission('payments', '', 'view')) {
                set_alert('danger', _l('access_denied'));
                redirect(admin_url('clients/client/' . $id));
            }

            $data = array_merge($data, prepare_mail_preview_data('customer_statement', $id));
        } elseif ($group == 'map') {
            if (get_option('google_api_key') != '' && !empty($client->latitude) && !empty($client->longitude)) {

                $this->app_scripts->add('map-js', base_url($this->app_scripts->core_file('assets/js', 'map.js')) . '?v=' . $this->app_css->core_version());

                $this->app_scripts->add('google-maps-api-js', [
                    'path'       => 'https://maps.googleapis.com/maps/api/js?key=' . get_option('google_api_key') . '&callback=initMap',
                    'attributes' => [
                        'async',
                        'defer',
                        'latitude'       => "$client->latitude",
                        'longitude'      => "$client->longitude",
                        'mapMarkerTitle' => "$client->company",
                    ],
                    ]);
            }
        }

        $data['staff'] = $this->staff_model->get('', ['active' => 1]);

        $data['client'] = $client;
        $title          = $client->company;

        // Get all active staff members (used to add reminder)
        $data['members'] = $data['staff'];

        if (!empty($data['client']->company)) {
            // Check if is realy empty client company so we can set this field to empty
            // The query where fetch the client auto populate firstname and lastname if company is empty
            if (is_empty_customer_company($data['client']->userid)) {
                $data['client']->company = '';
            }
        }
    }

    $this->load->model('currencies_model');
    $data['currencies'] = $this->currencies_model->get();

    if ($id != '') {
        $customer_currency = $data['client']->default_currency;

        foreach ($data['currencies'] as $currency) {
            if ($customer_currency != 0) {
                if ($currency['id'] == $customer_currency) {
                    $customer_currency = $currency;

                    break;
                }
            } else {
                if ($currency['isdefault'] == 1) {
                    $customer_currency = $currency;

                    break;
                }
            }
        }

        if (is_array($customer_currency)) {
            $customer_currency = (object) $customer_currency;
        }

        $data['customer_currency'] = $customer_currency;

        $slug_zip_folder = (
            $client->company != ''
            ? $client->company
            : get_contact_full_name(get_primary_contact_user_id($client->userid))
        );

        $data['zip_in_folder'] = slug_it($slug_zip_folder);
    }
    
    $global_arr = [ array("id"=>"0", "name"=>"NO"), array("id"=>"1", "name"=>"SI") ];
    $data['responsabilities']         = $global_arr;
    $data['maintenances']             = $global_arr;
    $data['collaborations_contracts'] = $global_arr;
    $data['endorsements']             = $global_arr;
    $data['relations']                = $this->commercials_visits_model->get_relation_ship();
    $data['civils_status']            = $this->commercials_visits_model->get_civil_status();
    $data['relations_ships']          = $this->commercials_visits_model->get_relation_ship();
    $data['bodyclass']                = 'customer-profile dynamic-create-groups';
    $data['title']                    = $title;

    $this->load->view('admin/commercial_visit/take_data', $data);
  }
  
  
/************************************
 * CLIENT GEOLOCATION
 */  
  
  /* clients geolocation */
  public function geolocations ($id = '') 
  {
    if (!has_permission('commercials_visits','','view') && !has_permission('commercials_visits','','view_own')) {
      access_denied('commercials_visits');
    }
    
    close_setup_menu();
    
    if ($this->input->post()) {
      $dat_form = $this->input->post();
      $_SESSION['$fdesde'] 			= "";
      $_SESSION['$fhasta'] 			= "";
      if ($dat_form['fdesde']!='') $_SESSION['$fdesde'] = date('Y-m-d', strtotime($dat_form['fdesde']));
      if ($dat_form['fhasta']!='') $_SESSION['$fhasta'] = date('Y-m-d', strtotime($dat_form['fhasta']));
      if ($dat_form['cliente']) {
        $_SESSION['cliente'] = $dat_form['cliente'];
        $data['cliente'] = $dat_form['cliente'];
      }
    } else {
      $_SESSION['$fdesde'] 			= "";
      $_SESSION['$fhasta'] 			= "";
      $_SESSION['cliente'] 			= "";
      $data['cliente']						= "";
    }

    $data['title']              = _l('commercials_visits_geolocation');
    //$data['comercializador']    = $this->commissions_model->get_comercializador();
    //$data['years']              = $this->commissions_model->get_contracts_years();
    //$data['base_currency'] 			= $this->currencies_model->get_base_currency();
    $this->load->model("clients_model");
    $data['clients']				= $this->clients_model->get_customers_admin_unique_ids();

    $this->load->view('admin/commercial_visit/manage_geolocation', $data);
  }


}