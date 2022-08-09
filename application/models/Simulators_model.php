<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Simulators_model extends CRM_Model {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("rate_simulator_model");
		$this->load->model("hired_potency_model");
		$this->load->model("prices_model");
		$this->load->model("rate_type_model");
		$this->load->model("price_table_model");
	}
	
  /**
	 * Get simulator/s
	 * @param  mixed  $id         simulator id
	 * @param  array   $where      perform where
	 * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
	 * @return mixed
	 */
  public function get($id = '', $where = [], $for_editor = false)
  {
    $this->db->select('*');
    $this->db->where($where);

    if (is_numeric($id)) 
    {
      $this->db->where('tblsimulators.id', $id);
      $simulator = $this->db->get('tblsimulators')->row();
      
      return $simulator;
    }
    $simulator = $this->db->get('tblsimulators')->result_array();
    
    return $simulator;
  }

  /**
	 * Get simulator/s pdf
	 * @param  mixed  $id         simulator id
	 * @param  array   $where      perform where
	 * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
	 * @return mixed
	 */
  public function get_pdf($id = '', $where = [], $for_editor = false)
  {
    $this->db->select('tblsimulators.id, tblsimulators.client, tblsimulators.nif, tblsimulators.cups, tblsimulators.rate, tblsimulators.consumo_potencia1, tblsimulators.consumo_potencia2, tblsimulators.consumo_potencia3, tblsimulators.consumo_potencia4, tblsimulators.consumo_potencia5, tblsimulators.consumo_potencia6, tblsimulators.consumo_energia1, tblsimulators.consumo_energia2, tblsimulators.consumo_energia3, tblsimulators.consumo_energia4, tblsimulators.consumo_energia5, tblsimulators.consumo_energia6, tblsimulators.savings_potency, tblsimulators.savings_energy, tblsimulators.total_savings, tblsimulators.marketer_savings, tblclients.country, tblcontacts.firstname, tblcontacts.lastname, tblclients.phonenumber, tblcontacts.email, tblclients.address, tblclients.city, tblclients.state, tblclients.zip,tblsimulators.dateadded');
    $this->db->where($where);
    $this->db->join('tblclients', 'tblclients.userid = tblsimulators.client','inner');
    $this->db->join('tblcontacts', 'tblcontacts.userid = tblclients.userid','inner');

    if (is_numeric($id)) {
      $this->db->where('tblsimulators.id', $id);
      $simulator = $this->db->get('tblsimulators')->row();
      
      return $simulator;
    }
    $simulator = $this->db->get('tblsimulators')->result_array();
    
    return $simulator;
  }
	
  /**
  * Add new simulator
  * @param mixed $data All $_POST data
  */
  public function add($data)
  {
  	$data['hash'] = app_generate_hash();
    $data['savings_potency'] = str_replace(",",".",$data['savings_potency']);
    $data['savings_energy'] = str_replace(",",".",$data['savings_energy']);
    $data['total_savings'] = str_replace(",",".",$data['total_savings']);
    
    $this->db->insert('tblsimulators', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      return $insert_id;
    }

    return false;
  }

  /**
   * Edit simulators
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update($data, $id)
  {
    $data['savings_potency'] = str_replace(",",".",$data['savings_potency']);
    $data['savings_energy'] = str_replace(",",".",$data['savings_energy']);
    $data['total_savings'] = str_replace(",",".",$data['total_savings']);
  	
    $this->db->where('id', $id);
    $this->db->update('tblsimulators', $data);
    if ($this->db->affected_rows() > 0) {
      return true;
    }

    return false;
  }

	/**********************************
	/*** RATE SIMULATOR
	
  /**
   * List rate
   * @param mixed $data All $_POST data
   */
  public function get_rate($id='') {
    return $this->rate_simulator_model->get($id);
  }
	
  /**
   * Add new rate
   * @param mixed $data All $_POST data
   */
  public function add_rate($data) {
    return $this->rate_simulator_model->add($data);
  }

  /**
   * Edit rate
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_rate($data, $id) {
    return $this->rate_simulator_model->update($data, $id);
  }
	
  /**
   * Delete rate
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function delete_rate($id) {
    return $this->rate_simulator_model->delete($id);
  }

	/**********************************
	/*** HIRED POTENCY SIMULATOR
	
  /**
   * List hired portency
   * @param mixed $data All $_POST data
   */
  public function get_hired_potency($id='')
  {
    return $this->hired_potency_model->get($id);
  }
	
  /**
   * Add new hired potency
   * @param mixed $data All $_POST data
   */
  public function add_hired_potency($data)
  {
    return $this->hired_potency_model->add($data);
  }

  /**
   * Edit hired potency
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_hired_potency($data, $id)
  {
    return $this->hired_potency_model->update($data, $id);
  }
	
  /**
   * Delete hired potency
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function delete_hired_potency($id)
  {
    return $this->hired_potency_model->delete($id);
  }

	/**********************************
	/*** PRICES SIMULATOR
	
  /**
   * Add new prices
   * @param mixed $data All $_POST data
   */
  public function add_prices($data)
  {
    return $this->prices_model->add($data);
  }

  /**
   * Edit prices
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_prices($data, $id)
  {
    return $this->prices_model->update($data, $id);
  }
	
  /**
   * Delete prices
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function delete_prices($id)
  {
    return $this->prices_model->delete($id);
  }

	/**********************************
	/*** RATE TYPES

  /**
   * List rate type
   * @param mixed $data All $_POST data
   */
  public function get_rate_types($id='')
  {
    return $this->rate_type_model->get($id);
  }

  /**
   * Add new rate type
   * @param mixed $data All $_POST data
   */
  public function add_rate_type($data)
  {
    return $this->rate_type_model->add($data);
  }

  /**
   * Edit rate type
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_rate_type($data, $id)
  {
    return $this->rate_type_model->update($data, $id);
  }
	
  /**
   * Delete rate type
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function delete_rate_type($id)
  {
    return $this->rate_type_model->delete($id);
  }
  
	/**********************************
	/*** PRICE TABLES

  /**
   * List price tables
   * @param mixed $data All $_POST data
   */
  public function get_price_tables_head($id='',$marketer='')
  {
    return $this->price_table_model->get_head($id,$marketer);
  }
  
  /**
   * Add new price tables
   * @param mixed $data All $_POST data
   */
  public function add_price_tables_head($data)
  {
    return $this->price_table_model->add_head($data);
  }

  /**
   * Edit price tables
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_price_tables_head($data, $id)
  {
    return $this->price_table_model->update_head($data, $id);
  }
	
  /**
   * Delete price tables
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function delete_price_tables_head($id)
  {
    return $this->price_table_model->delete_head($id);
  }

	/**********************************
	/*** PRICE TABLES DETAIL

  /**
   * List price tables detail
   * @param mixed $data All $_POST data
   */
  public function get_price_tables_detail($id='')
  {
    return $this->price_table_model->get_detail($id);
  }
  
  /**
   * Add new price tables detail
   * @param mixed $data All $_POST data
   */
  public function add_price_tables_detail($data)
  {
    return $this->price_table_model->add_detail($data);
  }

  /**
   * Edit price tables detail
   * @param mixed $data All $_POST data
   * @param mixed $id Contract type id
   */
  public function update_price_tables_detail($data, $id)
  {
    return $this->price_table_model->update_detail($data, $id);
  }
	
  /**
   * Delete price tables detail
   * @param mixed $data All $_POST data
   * @param mixed $id rate id
   */
  public function delete_price_tables_detail($id)
  {
    return $this->price_table_model->delete_detail($id);
  }

  /**
   * List price tables detail for rate
   * @param mixed $data All $_POST data
   */
  public function get_detail_rate($rate='',$finished='')
  {
    return $this->price_table_model->get_detail_rate($rate,$finished);
  }

	/**
	 * Get the best rate. 
	 * @param mixed $data All $_POST data
	 */
	public function get_best_rate($data='') {
   	return $this->price_table_model->get_best_rate($data);
  	}
  
  /**
   * Select unique contracts years
   * @return array
   */
  public function get_contracts_years()
  {
    return $this->db->query('SELECT DISTINCT(YEAR(dateadded)) as year FROM tblsimulators')->result_array();
  }
  
  /**
   * Select decimal_separator
   * @return array
   */
  public function decimal_separator()
  {
    return $this->db->query("select value from tbloptions where name='decimal_separator'")->row();
  }
  
  /**
	 * Get simulator/s supply points client
	 */
  public function get_supply_points($cliente_id='',$module_id='',$id='') {
  	if ($id != '') $this->db->where('id', $id);
    $this->db->where('cliente', $cliente_id);
    $this->db->where('module_id', $module_id);
      
    return $this->db->get('tblsupplypoints')->result_array();
  }
	
}
