<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Simulators extends Admin_controller {
	
	public function __construct() {
		parent::__construct();
		
			$this->load->model("simulators_model");
    	$this->load->model('commissions_model');
    	$this->load->model('tarifa_model');
    	$this->load->model('nivel_precios_model');
    	$this->load->model('commercial_category_model');
    	$this->load->model('commercial_model');
    	$this->load->model('partner_model');
    	$this->load->model('prices_model');
    	$this->load->model('currencies_model');
	}
	
  /* List all silmulator */
  public function index()
  {
    close_setup_menu();

    if (!has_permission('simulators', '', 'view') && !has_permission('simulators', '', 'view_own')) {
      access_denied('simulators');
    }
		
		$data['title']         				= _l('simulator');
    $data['chart_types']        	= json_encode($this->commissions_model->get_comercializador_chart_data());
    $data['chart_types_values'] 	= json_encode($this->commissions_model->get_comercializador_values_chart_data());
    $data['comercializador']     	= $this->commissions_model->get_comercializador();
    $data['years']              	= $this->commissions_model->get_contracts_years();
    $data['base_currency'] 				= $this->currencies_model->get_base_currency();
    $data['decimal_separator'] 		= $this->simulators_model->decimal_separator()->value;
    
    $this->load->view('admin/simulator/manage', $data);
  }
  
  /* Edit simulator or add new simulators  */
  public function simulator($id = '') {
    if ($this->input->post()){
      if ($id == ''){
        if (!has_permission('simulators', '', 'create')) {
          access_denied('simulators');
        }
        $id = $this->simulators_model->add($this->input->post());
        if ($id) {
          set_alert('success', _l('added_successfully', _l('simulator_simulator')));
          redirect(admin_url('simulators/'));
        }
      } else {
        if (!has_permission('simulators', '', 'edit')) {
          access_denied('simulators');
        }
        $success = $this->simulators_model->update($this->input->post(), $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('simulator_simulator')));
        }
        redirect(admin_url('simulators/'));
      }
    }
      
    if ($id == '') {
      $title = _l('add_new', _l('simulator'));
      $data['accion'] = 'nueva';
    } else {
      $data['simulator'] = $this->simulators_model->get($id, [], true);
      //$data['simulators_renewal_history'] = $this->commissions_model->get_contract_renewal_history($id);
      $data['accion'] = 'edicion';
    }

    if ($this->input->get('customer_id')) {
      $data['customer_id'] = $this->input->get('customer_id');
    }

    $this->load->model('currencies_model');
    $data['base_currency'] = $this->currencies_model->get_base_currency();
    $data['marketer'] = $this->commissions_model->get_comercializador();
    $data['rate'] = $this->commissions_model->get_tarifa('','','3');
    $data['decimal_separator'] = $this->simulators_model->decimal_separator()->value;
    $data['supply_points'] = $this->simulators_model->get_supply_points('',2);
    $data['title'] = $title;
    $data['bodyclass'] = 'contract';
    
    $this->load->view('admin/simulator/simulator', $data);
  }
  
  public function table($clientid = '') {
    if (!has_permission('simulators', '', 'view') && !has_permission('simulators', '', 'view_own')) {
      ajax_access_denied();
    }

    $this->app->get_table_data('simulators');
  }
	
	/**
	* Carga el mantenimiento de las tarifas del simulador.
	* 
	* @return 
	*/
	public function rate_mant() {
    if (!is_admin()) {
        access_denied('simulators');
    }
    if ($this->input->is_ajax_request()) {
        $this->app->get_table_data('simulator_rate');
    }
    $data['title'] = _l('simulator_rate');
    $this->load->view('admin/simulator/manage_rate', $data);
	}
	
	/**
	* Edit rate or add new rate
	* @param undefined $id
	* 
	* @return
	*/
  public function rate($id = '') {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('simulators');
    }
    if ($this->input->post()) 
    {
      if (!$this->input->post('id')) {
        $id = $this->simulators_model->add_rate($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('simulator'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id,
          'name'    => $this->input->post('detalle'),
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->simulators_model->update_rate($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('simulator'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
    }
  }
  
  /**
	* Delete rat.
	* @param undefined $id
	* 
	* @return
	*/
  public function delete_rate($id) {
    if (!$id) {
      redirect(admin_url('simulators/rate_mant'));
    }
    if (!is_admin()) {
      access_denied('simulators');
    }
    $response = $this->simulators_model->delete_rate($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('simulator')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('simulator')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('simulator')));
    }
    redirect(admin_url('simulators/rate_mant'));
  }
  
	/**
	* Potencia contratada el mantenimiento de las tarifas del simulador.
	* 
	* @return 
	*/
	public function hired_potency_mant() {
    if (!is_admin()) {
        access_denied('simulators');
    }
    if ($this->input->is_ajax_request()) {
        $this->app->get_table_data('hired_potency');
    }
    $data['title'] = _l('simulator_rate');
    $this->load->view('admin/simulator/manage_hired_potency', $data);
	}
	
	/**
	* Edit rate or add new rate
	* @param undefined $id
	* 
	* @return
	*/
  public function hired_potency($id = '')
  {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('simulators');
    }
    if ($this->input->post()) 
    {
      if (!$this->input->post('id')) {
        $id = $this->simulators_model->add_hired_potency($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('simulator_hired_potency'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id,
          'name'    => $this->input->post('detalle'),
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->simulators_model->update_hired_potency($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('simulator_hired_potency'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
    }
  }
  
  /**
	* Delete rat.
	* @param undefined $id
	* 
	* @return
	*/
  public function delete_hired_potency($id)
  {
    if (!$id) {
      redirect(admin_url('simulators/hired_potency_mant'));
    }
    if (!is_admin()) {
      access_denied('simulators');
    }
    $response = $this->simulators_model->delete_hired_potency($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('simulator_hired_potency')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('simulator_hired_potency')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('simulator_hired_potency')));
    }
    redirect(admin_url('simulators/hired_potency_mant'));
  }

	/**
	* Prices el mantenimiento de las tarifas del simulador.
	* 
	* @return 
	*/
	public function prices_mant() {
    if (!is_admin()) {
        access_denied('simulators');
    }
    if ($this->input->is_ajax_request()) {
        $this->app->get_table_data('prices');
    }
    $data['title'] = _l('simulator_prices');
    $this->load->view('admin/simulator/manage_prices', $data);
	}
	
	/**
	* Edit prices or add new prices
	* @param undefined $id
	* 
	* @return
	*/
  public function prices($id = '')
  {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('simulators');
    }
    if ($this->input->post()) 
    {
      if (!$this->input->post('id')) {
        $id = $this->simulators_model->add_prices($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('simulator_prices'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id,
          'name'    => $this->input->post('detalle'),
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->simulators_model->update_prices($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('simulator_prices'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
    }
  }
  
  /**
	* Delete prices.
	* @param undefined $id
	* 
	* @return
	*/
  public function delete_prices($id)
  {
    if (!$id) {
      redirect(admin_url('simulators/prices_mant'));
    }
    if (!is_admin()) {
      access_denied('simulators');
    }
    $response = $this->simulators_model->delete_prices($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('simulator_prices')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('simulator_prices')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('simulator_prices')));
    }
    redirect(admin_url('simulators/prices_mant'));
  }

	/**
	* rate types el mantenimiento de las tarifas del simulador.
	* 
	* @return 
	*/
	public function rate_types_mant() {
    if (!is_admin()) {
        access_denied('simulators');
    }
    if ($this->input->is_ajax_request()) {
        $this->app->get_table_data('rate_type');
    }
    $data['title'] = _l('simulator_rate_types');
    $this->load->view('admin/simulator/manage_rate_types', $data);
	}
	
	/**
	* Edit rate_types or add new rate_types
	* @param undefined $id
	* 
	* @return
	*/
  public function rate_types($id = '')
  {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('simulators');
    }
    if ($this->input->post()) 
    {
      if (!$this->input->post('id')) {
        $id = $this->simulators_model->add_rate_type($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('simulator_rate_types'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id,
          'name'    => $this->input->post('detalle'),
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->simulators_model->update_rate_type($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('simulator_rate_types'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
    }
  }
  
  /**
	* Delete prices.
	* @param undefined $id
	* 
	* @return
	*/
  public function delete_rate_type($id)
  {
    if (!$id) {
      redirect(admin_url('simulators/rate_types_mant'));
    }
    if (!is_admin()) {
      access_denied('simulators');
    }
    $response = $this->simulators_model->delete_rate_type($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('simulator_rate_types')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('simulator_rate_types')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('simulator_rate_types')));
    }
    redirect(admin_url('simulators/rate_types_mant'));
  }

	/**
	* Simulators Table Prices Head.
	* 
	* @return 
	*/
  public function price_table_head($id='')
  {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('simulators');
    }
    if ($this->input->post()) 
    {
      if (!$this->input->post('id')) {
        $id = $this->simulators_model->add_price_tables_head($this->input->post());
        if ($id) {
        	$modality = $this->simulators_model->get_rate_types($this->input->post('modality'));
          $success = true;
          $message = _l('added_successfully', _l('simulator_table_price_head'));
          $modality = $modality->detalle;
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id,
          'name'    => $modality,
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->simulators_model->update_price_tables_head($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('simulator_table_price_head'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
    }
  }

  /**
	* Delete table head.
	* @param undefined $id
	* 
	* @return
	*/
  public function delete_price_table_head($id)
  {
    if (!is_admin()) {
      access_denied('simulators');
    }
    $response = $this->simulators_model->delete_price_tables_head($id);
    if (is_array($response) && isset($response['referenced'])) {
      $message = _l('is_referenced', _l('simulator_rates'));
    } elseif ($response == true) {
      $message = _l('deleted', _l('simulator_rates'));
    } else {
      $message = _l('problem_deleting', _l('simulator_rates'));
    }
    echo json_encode([
    	'id' => $id,
      'success' => $response,
      'message' => $message,
    ]);
  }

	/**
	* Simulators Table Prices.
	* 
	* @return 
	*/
	public function price_table_mant() {
    if (!is_admin()) {
      access_denied('simulators');
    }
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('price_table');
    }
    
    $_SESSION['$rate_id'] = '0';
    $_SESSION['$marketer_id'] = '0';
    $rate_id = '';
    $price_table_id = '';
    if ($this->input->post()) {
    	$rate_id = explode('-',$this->input->post('price_table'));
    	$_SESSION['$rate_id'] = $rate_id[0];
    	$price_table_id = $rate_id[0];
    	$rate_id = $rate_id[0].'-'.$rate_id[1];
			$_SESSION['$marketer_id'] = $this->input->post('marketer');
		}

		$_SESSION['$rate_id'] = $rate_id;
    $data['title'] = _l('simulator_price_table');
    $data['price_table'] = $this->simulators_model->get_price_tables_head('',$_SESSION['$marketer_id']);
    $data['modality'] = $this->simulators_model->get_rate_types();
    $data['price_table_id'] = $this->simulators_model->get_price_tables_head($price_table_id,$_SESSION['$marketer_id']);
    if ($data['price_table_id']->finished==1 || $data['price_table_id']->finished==2) $data['rate'] = $this->commissions_model->get_tarifa('','','3');
    if ($data['price_table_id']->finished==3 || $data['price_table_id']->finished==4) $data['rate'] = $this->commissions_model->get_tarifa('','','4');
    $data['hiredpotency'] = $this->simulators_model->get_hired_potency();
    $data['marketers'] = $this->commissions_model->get_comercializador();
    $data['marketer'] = $_SESSION['$marketer_id'];
    $data['rate_id'] = $_SESSION['$rate_id'];
    $data['finisheds'] = $this->prices_model->get();
    $data['decimal_separator'] = $this->simulators_model->decimal_separator()->value;
    
    $this->load->view('admin/simulator/manage_price_table', $data);
	}

  /**
	* get price table detail
	* @param undefined $id
	* 
	* @return
	*/
  public function get_price_table($id)
  {
    $response = $this->simulators_model->get_price_tables_detail($id);
    echo json_encode($response);
  }
	
	/**
	* Simulators Table Prices
	* 
	* @return 
	*/
  public function price_table($id='')
  {
    if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
      access_denied('simulators');
    }
    if ($this->input->post()) {
      if (!$this->input->post('id')) {
        $id = $this->simulators_model->add_price_tables_detail($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('simulator_table_price_head'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id,
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->simulators_model->update_price_tables_detail($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('simulator_table_price_head'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
    }
  }

  /**
	* Delete price table detail
	* @param undefined $id
	* 
	* @return
	*/
  public function delete_price_table($id)
  {
    if (!$id) {
      redirect(admin_url('simulators/price_table_mant'));
    }
    if (!is_admin()) {
      access_denied('simulators');
    }
    $response = $this->simulators_model->delete_price_tables_detail($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('simulator_rates')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('simulator_rates')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('simulator_rates')));
    }
    redirect(admin_url('simulators/price_table_mant'));
  }
  
  // Filtra tabla de precios.
	public function filtrar_price_table($marketer='') {
		$price_table = $this->simulators_model->get_price_tables_head('',$marketer);
		echo json_encode($price_table);
	}

  // Obtiene los precios vinculados a la tarifa.
	public function get_detail_rate($rate='',$finished='') {
		$detail_rate = $this->simulators_model->get_detail_rate($rate,$finished);
		echo json_encode($detail_rate);
	}
	
  // Obtener la mejor tarifa.
	public function get_best_rate() {
		$data = array (
			'rate' => $_POST['rate'],
			
			'consumo_potencia1' => $_POST['cp1'],
			'consumo_potencia2' => $_POST['cp2'],
			'consumo_potencia3' => $_POST['cp3'],
			'consumo_potencia4' => $_POST['cp4'],
			'consumo_potencia5' => $_POST['cp5'],
			'consumo_potencia6' => $_POST['cp6'],
						
			'consumo_energia1' => $_POST['ce1'],
			'consumo_energia2' => $_POST['ce2'],
			'consumo_energia3' => $_POST['ce3'],
			'consumo_energia4' => $_POST['ce4'],
			'consumo_energia5' => $_POST['ce5'],
			'consumo_energia6' => $_POST['ce6'],
						
			'total_potency' => $_POST['total_potency'],
			'total_energy' => $_POST['total_energy']
		);
		$best_rate = $this->simulators_model->get_best_rate($data);
		
		echo json_encode($best_rate);
	}
	
	/**
	* Muestra versión pdf.
	* @param undefined $id
	* 
	* @return
	*/
  public function pdf($id){
  	
    if (!has_permission('simulators', '', 'view') && !has_permission('simulators', '', 'view_own')) access_denied('simulators');
    if (!$id) redirect(admin_url('simulators'));

    $simulation = $this->simulators_model->get_pdf($id);

    try {
      $pdf = simulation_pdf($simulation);
    } catch (Exception $e) {
      echo $e->getMessage();
      die;
    }
    
    //log_message('debug', "pdf: ".print_r($pdf, TRUE));
    $type = 'D';

    if ($this->input->get('output_type')) $type = $this->input->get('output_type');
    if ($this->input->get('print')) $type = 'I';
		
		$subject = _l('simulation_content');
    $pdf->Output(slug_it($subject) . '.pdf', $type);
  }
  
	/**
	* Muestra versión pdf.
	*/
  public function get_supply_points($cliente_id='',$module_id='',$id='') {
    $supply_points = $this->simulators_model->get_supply_points($cliente_id,$module_id,$id);
    echo json_encode($supply_points);
  }

}