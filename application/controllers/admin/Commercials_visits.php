<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Commercials_visits extends Admin_controller
{
  public function __construct() 
  {
    parent::__construct();
    $this->load->model('commercials_visits_model');
    $this->load->model('tarifa_model');
    $this->load->model('nivel_precios_model');
    $this->load->model('commercial_category_model');
    $this->load->model('commercial_model');
    $this->load->model('partner_model');
    $this->load->model('currencies_model');
    $this->load->model("simulators_model");
    $this->load->model("clients_model");
  }

  /* List all contracts */
  public function index() {
    close_setup_menu();
    if (!has_permission('commercials_visits', '', 'view') && !has_permission('commercials_visits', '', 'view_own')) access_denied('commercials_visits');

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

    $data['title']         			= _l('commercials_visits');
    $data['years']              = $this->commercials_visits_model->get_visits_years();
    $data['base_currency']      = $this->currencies_model->get_base_currency();
    $data['list_clients']				= $this->commercials_visits_model->get_clientes();

    $this->load->view('admin/commercial_visit/manage', $data);
  }
    
  public function table($clientid='')
  {
    if (!has_permission('commercials_visits', '', 'view') && !has_permission('commercials_visits', '', 'view_own')) { ajax_access_denied(); }
    $this->app->get_table_data('commercials_visits');
  }

  /* Edit contract or add new contract */
  public function commercial_visit($id='') {
    if ($this->input->post()) {
      if ($id == ''){
        if (!has_permission('commercials_visits', '', 'create')) { 
          access_denied('commercials_visits'); 
        }
        $id = $this->commercials_visits_model->add($this->input->post());
        if ($id) {
          set_alert('success', _l('added_successfully', _l('commercial_visit')));
          redirect(admin_url('commercials_visits/'));
        }
      } else {
        if (!has_permission('commercials_visits', '', 'edit')) access_denied('commercials_visits');
        $success = $this->commercials_visits_model->update($this->input->post(), $id);
        if ($success) set_alert('success', _l('updated_successfully', _l('commercial_visit')));
        redirect(admin_url('commercials_visits/'));
      }
    }

    if ($id == '') {
      $title 								= _l('add_new', _l('contract_lowercase'));
      $data['accion'] 			= "new";
    } else {
      $data['cvisit']       = $this->commercials_visits_model->get($id, [], true);
    }

    if ($this->input->get('customer_id')) $data['customer_id'] = $this->input->get('customer_id');	
    $data['title'] 					= $title;
    $data['bodyclass']      = 'contract';
    $data['types']          = $this->commercials_visits_model->get_client_types();
    $data['contact_types']  = $this->commercials_visits_model->get_contact_types();

    $this->load->view('admin/commercial_visit/commercial_visit', $data);
  }

  public function get_template() {
    $name = $this->input->get('name');
    echo $this->load->view('admin/contracts/templates/' . $name, [], true);
  }
    
    public function get_client($id) {
      $client = $this->clients_model->get($id);
      
      echo json_encode($client);
    }

    public function add_comment() {
      if ($this->input->post()) {
        echo json_encode([
          'success' => $this->commercials_visits_model->add_comment($this->input->post()),
        ]);
      }
    }

    public function edit_comment($id)
    {
        if ($this->input->post()) {
            echo json_encode([
                'success' => $this->commercials_visits_model->edit_comment($this->input->post(), $id),
                'message' => _l('comment_updated_successfully'),
            ]);
        }
    }

    public function get_comments($id)
    {
        $data['comments'] = $this->commercials_visits_model->get_comments($id);
        $this->load->view('admin/commercial_visit/comments_template', $data);
    }

    public function remove_comment($id)
    {
        $this->db->where('id', $id);
        $comment = $this->db->get('tblcvisit_comments')->row();
        if ($comment) {
            if ($comment->staffid != get_staff_user_id() && !is_admin()) {
                echo json_encode([
                    'success' => false,
                ]);
                die;
            }
            echo json_encode([
                'success' => $this->commercials_visits_model->remove_comment($id),
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

  /* Delete contract from database */
  public function delete($id) {
    if (!has_permission('commercials_visits', '', 'delete')) {
      access_denied('commercials_visits');
    }
    if (!$id) {
      redirect(admin_url('commercials_visits'));
    }
    $response = $this->commercials_visits_model->delete($id);
    if ($response == true) {
      set_alert('success', _l('deleted', _l('contract')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('visit_lowercase')));
    }
    if (strpos($_SERVER['HTTP_REFERER'], 'clients/') !== false) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect(admin_url('commercials_visits'));
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
  public function take_form($cliente='',$id='') {
    if (!has_permission('commercials_visits', '', 'view')) if ($id != '' && !is_customer_admin($id)) access_denied('commercials_visits');

    if ($this->input->post() && !$this->input->is_ajax_request()) {
      if ($id == '') {
        if (!has_permission('commercials_visits', '', 'create')) { 
          access_denied('commercials_visits');
        }
        $data = $this->input->post();
        
        $form = "";
        if (isset($data['form'])) {
          $form = $data['form'];
          unset($data['form']);
        }
        if ($form=="take-data-form") $id = $this->commercials_visits_model->add_take_data($data);
        if ($form=="sales-data-form") $id = $this->commercials_visits_model->add_sales_data($data);
        if ($form=="economic-data-form") $id = $this->commercials_visits_model->add_economic_data($data);
        if ($form=="operation-banks-form") $id = $this->commercials_visits_model->add_operation_banks($data);
        
        if ($id) set_alert('success', _l('added_successfully', _l('commercials_visits')));
      }else{
        if (!has_permission('commercials_visits', '', 'edit')) {
          if (!is_customer_admin($id)) access_denied('commercials_visits');
        }
        $data = $this->input->post();
        
        $form = "";
        if (isset($data['form'])){
          $form = $data['form'];
          unset($data['form']);
        }
        if ($form=="take-data-form") $success = $this->commercials_visits_model->update_take_data($data, $id);
        if ($form=="sales-data-form") $success = $this->commercials_visits_model->update_sales_data($data, $id);
        if ($form=="economic-data-form") $success = $this->commercials_visits_model->update_economic_data($data, $id);
        if ($form=="operation-banks-form") $success = $this->commercials_visits_model->update_operation_banks($data, $id);
        
        if ($success == true) set_alert('success', _l('updated_successfully', _l('commercials_visits')));
      }
    }
    
    $data = [];
    
    if ($id=='') {
      $title                    = _l('add_new_take_data');
      $data['accion']           = "nuevo";
    } else {
      $data['take_data']        = $this->commercials_visits_model->get_take_data($cliente);
      $data['sales_data']       = $this->commercials_visits_model->get_sales_data($cliente);
      $data['economic_data']    = $this->commercials_visits_model->get_economic_data($cliente);
      $data['operation_banks']  = $this->commercials_visits_model->get_operation_banks($cliente);
    }

    $global_arr = [ array("id"=>"1", "name"=>"NO"), array("id"=>"2", "name"=>"SI") ];
    
    $data['client']                     = $cliente;
    $data['responsabilities']           = $global_arr;
    $data['maintenances']               = $global_arr;
    $data['collaborations_contracts']   = $global_arr;
    $data['endorsements']               = $global_arr;
    $data['purchase_prices_commission'] = $global_arr;
    $data['priceds']                    = $global_arr;
    $data['relations']                  = $this->commercials_visits_model->get_relation_ship();
    $data['civils_status']              = $this->commercials_visits_model->get_civil_status();
    $data['relations_ships']            = $this->commercials_visits_model->get_relation_ship();
    $data['payment_methods']            = $this->commercials_visits_model->get_payment_method();
    $data['contract_types']             = $this->commercials_visits_model->get_contract_types();
    $data['banks']                      = $this->commercials_visits_model->get_banks();
    $data['banks_loan']                 = $this->commercials_visits_model->get_banks_loan();
    $data['base_currency']              = $this->currencies_model->get_base_currency();
    $data['bodyclass']                  = 'customer-profile dynamic-create-groups';
    $data['title']                      = $title;

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
    $this->load->model("clients_model");
    $data['clients']				= $this->clients_model->get_customers_admin_unique_ids();

    $this->load->view('admin/commercial_visit/manage_geolocation', $data);
  }
  
}