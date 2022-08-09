<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gas_model extends CRM_Model {
	
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
  public function get($id = '', $where = [], $for_editor = false) {
    $this->db->select('*');
    $this->db->where($where);
		$this->db->where('tblsimulators.gas', 1);
		
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
  public function get_pdf($id = '', $where = [], $for_editor = false) {
    $this->db->select('tblsimulators.id, tblsimulators.client, tblsimulators.nif, tblsimulators.cups, tblsimulators.rate, tblsimulators.consumo_potencia1, tblsimulators.consumo_potencia2, tblsimulators.consumo_potencia3, tblsimulators.consumo_potencia4, tblsimulators.consumo_potencia5, tblsimulators.consumo_potencia6, tblsimulators.consumo_energia1, tblsimulators.consumo_energia2, tblsimulators.consumo_energia3, tblsimulators.consumo_energia4, tblsimulators.consumo_energia5, tblsimulators.consumo_energia6, tblsimulators.savings_potency, tblsimulators.savings_energy, tblsimulators.total_savings, tblsimulators.marketer_savings, tblclients.country, tblcontacts.firstname, tblcontacts.lastname, tblclients.phonenumber, tblcontacts.email, tblclients.address, tblclients.city, tblclients.state, tblclients.zip,tblsimulators.dateadded');
    $this->db->where($where);
    $this->db->join('tblclients', 'tblclients.userid = tblsimulators.client','inner');
    $this->db->join('tblcontacts', 'tblcontacts.userid = tblclients.userid','inner');
		$this->db->where('tblsimulators.gas', 1);
		
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
  public function add($data) {
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
  public function update($data, $id) {
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

	/**
	 * Get the best rate. 
	 * @param mixed $data All $_POST data
	 */
	public function get_best_rate($data='') {
   	return $this->price_table_model->get_best_rate_gas($data);
  }
  
  /**
   * Select unique contracts years
   * @return array
   */
  public function get_contracts_years() {
    return $this->db->query('SELECT DISTINCT(YEAR(dateadded)) as year FROM tblsimulators')->result_array();
  }
}
