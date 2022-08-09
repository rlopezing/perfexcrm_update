<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Commission_plans extends Admin_controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model('commission_plan_model');
    $this->load->model('commissions_model');
    $this->load->model('clients_model');
    $this->load->model("simulators_model");

    if (!is_admin()) {
      access_denied('Departments');
    }
  }

  /* List all commissional plan */
  public function index() {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('commission_plan');
    }
    
  	$_SESSION['country_id'] = $data['country'] = 0;
  	$_SESSION['module_id'] = $data['module'] = 0;
    
    $data['title']	= _l('commission_plan_title');
    $data['comercializador'] = $this->commissions_model->get_comercializador();
    $data['tarifa'] = $this->commissions_model->get_tarifa();
    $data['categoria_comercial'] = $this->commissions_model->get_commercial_category('','todos');
    $data['nivel_precio'] = $this->commissions_model->get_nivel_precios();
    $data['plan'] = '0';
    $data['decimal_separator'] = $this->simulators_model->decimal_separator()->value;
    $data['countries'] = $this->commissions_model->get_countries();
    $data['modules'] = $this->commissions_model->get_modules();
    
    $this->load->view('admin/commission_plan/manage', $data);
  }

  /* List all commissional plan */
  public function filtrar() {
  	$filtro = $this->input->post();
  	$_SESSION['country_id'] = $filtro['country_id'];
  	$data['country'] = $filtro['country_id'];
  	$_SESSION['module_id'] = $filtro['module_id'];
  	$data['module'] = $filtro['module_id'];
  	
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('commission_plan');
    }
    
    $data['title']	= _l('commission_plan_title');
    $data['comercializador'] = $this->commissions_model->get_comercializador();
    $data['tarifa'] = $this->commissions_model->get_tarifa();
    $data['categoria_comercial'] = $this->commissions_model->get_commercial_category('','todos');
    $data['nivel_precio'] = $this->commissions_model->get_nivel_precios();
    $data['plan'] = '0';
    $data['decimal_separator'] = $this->simulators_model->decimal_separator()->value;
    $data['countries'] = $this->commissions_model->get_countries();
    $data['modules'] = $this->commissions_model->get_modules();
    
    $this->load->view('admin/commission_plan/manage', $data);
  }

  /* Edit or add new commission plan */
  public function commission_plan($id='') {
    if ($this->input->post()) {
    	$message = '';
      if ($id == '') {
      	if ($this->commission_plan_model->validate($this->input->post())) {
          $success = true;
          $message = _l('commission_plan_exist');
				} else {
					$id = $this->commission_plan_model->add($this->input->post());
	        if ($id) {
	          $success = true;
	          $message = _l('added_successfully', _l('commission_plan_title'));
	        }
				}
        echo json_encode([
          'success'              => $success,
          'message'              => $message
        ]);
      } else {
        $success = $this->commission_plan_model->update($this->input->post(), $id);
        if ($id) {
          $success = true;
          $message = _l('updated_successfully', _l('commission_plan_title'));
        }
        echo json_encode([
          'success'              => $success,
          'message'              => $message
        ]);
      }
		}

		die;
  }
  
  /* Delete commission plan from database */
  public function delete($id) {
    if (!$id) {
      redirect(admin_url('commission_plans'));
    }
    $response = $this->commission_plan_model->delete($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('commission_plan_title')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('commission_plan_title')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('commission_plan_title')));
    }
    redirect(admin_url('commission_plans'));
  }


/////////////////////////////////////////
///// Consumos.

  /* Commissional consumos */
  public function consumos($plan) {
    if ($this->input->is_ajax_request()) {
    	$_SESSION['plan'] = $plan;
      $this->app->get_table_data('commission_consumo');
    }
    
    die;
  }

  /* List all commissional plan consumos */
  public function commission_consumo() {
    if ($this->input->post()) {
    	$message = '';
      if ($id == '') {
        $id = $this->commission_plan_model->add_consumo($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('commission_consumo_title'));
	        $url = admin_url('commission_plans/consumos/'.$this->input->post('plano'));
		      $aaData = $_SESSION['aaData'];
	        echo json_encode([
	          'success'              => $success,
	          'message'              => $message,
	          'url'									 => $url,
	          'aaData'							 => $aaData
	        ]);
        }
      } 
		}

		die;
  }

  /* Delete consumo plan from database */
  public function delete_consumo($id, $plan) {
    $response = $this->commission_plan_model->delete_consumo($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('commission_consumo_title')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('commission_consumo_title')));
      $success = true;
      $message = _l('deleted', _l('commission_consumo_title'));
      $url = admin_url('commission_plans/consumos/'.$plan);
      $aaData = $_SESSION['aaData'];
      echo json_encode([
        'success'              => $success,
        'message'              => $message,
        'url'              		 => $url,
        'aaData'							 => $aaData
      ]);
    } else {
      set_alert('warning', _l('problem_deleting', _l('commission_consumo_title')));
    }
		
    die;
  }
  
  /**********************************************  
  /* commissional costos de comisiones */
  
  public function costos($consumo)
  {
    if ($this->input->is_ajax_request()) {
    	$_SESSION['consumo'] = $consumo;
      $this->app->get_table_data('commission_costos');
    }
    
    die;
  }
  
  /* Add new costes */
  public function commission_costos($id='') {
    if ($this->input->post()) {
    	$message = '';
      if ($id == '') {
        $costo = $this->commission_plan_model->add_costo($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('commission_consumo_title'));
        }
        $consumo = $this->input->post('consumo');
        $url = admin_url('commission_plans/costos/'.$consumo);
        echo json_encode([
          'success'              => $success,
          'message'              => $message,
          'url'									 => $url
        ]);
      } else {
        $success = $this->commission_plan_model->update_consumo($this->input->post(), $id);
        if ($id) {
          $success = true;
          $message = _l('updated_successfully', _l('commission_consumo_title'));
        }
        echo json_encode([
          'success'              => $success,
          'message'              => $message
        ]);
      }
		}

		die;
  }
  
  /* Delete coste from database */
  public function delete_costo($id,$consumo)
  {
    $response = $this->commission_plan_model->delete_costo($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('commission_consumo_title')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('commission_costo_title')));
      $success = true;
      $message = _l('deleted', _l('commission_costo_title'));
      $url = admin_url('commission_plans/costos/'.$consumo);
      echo json_encode([
        'success'              => $success,
        'message'              => $message,
        'url'              		 => $url
      ]);
    } else {
      set_alert('warning', _l('problem_deleting', _l('commission_consumo_title')));
    }
		
    die;
  }
  
}
