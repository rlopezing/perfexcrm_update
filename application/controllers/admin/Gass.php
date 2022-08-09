<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gass extends Admin_controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("gas_model");
  	$this->load->model('commissions_model');
  	$this->load->model('tarifa_model');
  	$this->load->model('nivel_precios_model');
  	$this->load->model('commercial_category_model');
  	$this->load->model('commercial_model');
  	$this->load->model('partner_model');
  	$this->load->model('prices_model');
  	$this->load->model('simulators_model');
	}
	
	/* List all silmulator */
	public function index() {
  	close_setup_menu();

  	if (!has_permission('contracts', '', 'view') && !has_permission('contracts', '', 'view_own')) {
    	access_denied('contracts');
  	}

  	$data['chart_types']        = json_encode($this->commissions_model->get_comercializador_chart_data());
  	$data['chart_types_values'] = json_encode($this->commissions_model->get_comercializador_values_chart_data());
  	$data['comercializador']     = $this->commissions_model->get_comercializador();
  	$data['years']              = $this->commissions_model->get_contracts_years();
  	$this->load->model('currencies_model');
  	$data['base_currency'] = $this->currencies_model->get_base_currency();
  	$data['title']         = _l('simulator');
  	$data['decimal_separator'] = $this->simulators_model->decimal_separator()->value;
  	
  	$this->load->view('admin/gas/manage', $data);
	}
  
  /* Edit simulator or add new simulators  */
  public function gas($id = '') {
    if ($this->input->post()) {
      if ($id == '') {
        if (!has_permission('contracts', '', 'create')) {
          access_denied('contracts');
        }
        $id = $this->gas_model->add($this->input->post());
        if ($id) {
          set_alert('success', _l('added_successfully', _l('simulator_simulator')));
          redirect(admin_url('gass/'));
        }
      } else {
        if (!has_permission('contracts', '', 'edit')) {
          access_denied('contracts');
        }
        $success = $this->gas_model->update($this->input->post(), $id);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('simulator_simulator')));
        }
        redirect(admin_url('gass/'));
      }
    }
      
    if ($id == '') {
      $title = _l('add_new', _l('simulator'));
      $data['accion'] = 'nueva';
    } else {
      $data['simulator'] = $this->gas_model->get($id, [], true);
      $data['accion'] = 'edicion';
    }
    
    if ($this->input->get('customer_id')) {
      $data['customer_id'] = $this->input->get('customer_id');
    }

    $this->load->model('currencies_model');
    $data['base_currency'] = $this->currencies_model->get_base_currency();
    $data['marketer'] = $this->commissions_model->get_comercializador();
    $data['rate'] = $this->commissions_model->get_tarifa('','','4');
    $data['title'] = $title;
    $data['bodyclass'] = 'contract';
    $data['decimal_separator'] = $this->simulators_model->decimal_separator()->value;
    $data['supply_points'] = $this->simulators_model->get_supply_points('',4);
    
    $this->load->view('admin/gas/simulator', $data);
  }
  
  public function table($clientid = '') {
    if (!has_permission('contracts', '', 'view') && !has_permission('contracts', '', 'view_own')) {
      ajax_access_denied();
    }

    $this->app->get_table_data('gas');
  }

  // Obtener la mejor tarifa.
	public function get_best_rate() {
		$data = array (
			'rate' => $_POST['rate'],
			'dias_ano' => $_POST['dias_ano'],
			'consumo' => $_POST['consumo'],
			'total_termino_fijo' => $_POST['total_termino_fijo'],
			'total_termino_variable' => $_POST['total_termino_variable']
		);
		$best_rate = $this->gas_model->get_best_rate($data);
		
		echo json_encode($best_rate);
	}
	
	/**
	* Muestra versión pdf.
	* @param undefined $id
	* 
	* @return
	*/
  	public function pdf($id) {
		if (!has_permission('contracts', '', 'view') && !has_permission('contracts', '', 'view_own')) access_denied('contracts');
    	if (!$id) redirect(admin_url('simulators'));

    	$simulation = $this->Gas_model->get_pdf($id);

    	try {
      	$pdf = gas_pdf($simulation);
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

}







