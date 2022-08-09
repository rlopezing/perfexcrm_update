<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Generals_maps extends Admin_controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('general_map_model');

    if (!is_admin()) {
      access_denied('Departments');
    }
  }

  /* List all general map */
  public function index() {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('general_map');
    }
    
    $data['email_exist_as_staff'] = $this->email_exist_as_staff();
    $data['title']                = _l('general_map_title');
    
		/** Actual month first and last day **/
    $_SESSION['$fdesde'] = date('Y-m-01');
    $_SESSION['$fhasta'] = date('Y-m-t');
		$data['fdesde'] = date('Y-m-01');
		$data['fhasta'] = date('Y-m-t');
    
    $data['valor_contrato'] = $this->general_map_model->get_valor_contrato($_SESSION['$fdesde'],$_SESSION['$fhasta']);
    $data['comision_socio'] = $this->general_map_model->get_comision_socio($_SESSION['$fdesde'],$_SESSION['$fhasta']);
    $data['comision_comercial'] = $this->general_map_model->get_comision_comercial($_SESSION['$fdesde'],$_SESSION['$fhasta']);
    $data['base_currency'] = $this->currencies_model->get_base_currency();
		
    $this->load->view('admin/general_map/manage', $data);
  }

  /* List all general map */
  public function filtrar() {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('general_map');
    }
    $data['email_exist_as_staff'] = $this->email_exist_as_staff();
    $data['title']                = _l('general_map_title');
    
    $periodo = $this->input->post();
    $_SESSION['$fdesde'] = date('Y-m-d', strtotime($periodo['fdesde']));
    $_SESSION['$fhasta'] = date('Y-m-d', strtotime($periodo['fhasta']));
		$data['fdesde'] = $_SESSION['fdesde'];
		$data['fhasta'] = $_SESSION['fhasta'];
    
    $data['valor_contrato'] = $this->general_map_model->get_valor_contrato($_SESSION['$fdesde'],$_SESSION['$fhasta']);
    $data['comision_socio'] = $this->general_map_model->get_comision_socio($_SESSION['$fdesde'],$_SESSION['$fhasta']);
    $data['comision_comercial'] = $this->general_map_model->get_comision_comercial($_SESSION['$fdesde'],$_SESSION['$fhasta']);
    
    $data['base_currency'] = $this->currencies_model->get_base_currency();
		
    $this->load->view('admin/general_map/manage', $data);
  }

  /* Edit or add new general map */
  public function general_map($id = '')
  {
    if ($this->input->post()) {
      $message          = '';
      $data             = $this->input->post();
      $data             = $this->input->post();
      $data['password'] = $this->input->post('password', false);

      if (isset($data['fakeusernameremembered']) || isset($data['fakepasswordremembered'])) {
        unset($data['fakeusernameremembered']);
        unset($data['fakepasswordremembered']);
      }

      die;
    }
  }

    public function email_exists()
    {
        // First we need to check if the email is the same
        $departmentid = $this->input->post('id');
        if ($departmentid) {
            $this->db->where('departmentid', $departmentid);
            $_current_email = $this->db->get('tbldepartments')->row();
            if ($_current_email->email == $this->input->post('email')) {
                echo json_encode(true);
                die();
            }
        }
        $exists = total_rows('tblcomicontratos', [
            'email' => $this->input->post('email'),
        ]);
        if ($exists > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function test_imap_connection()
    {
        $email         = $this->input->post('email');
        $password      = $this->input->post('password', false);
        $host          = $this->input->post('host');
        $imap_username = $this->input->post('username');
        if ($this->input->post('encryption')) {
            $encryption = $this->input->post('encryption');
        } else {
            $encryption = '';
        }

        require_once(APPPATH . 'third_party/php-imap/Imap.php');

        $mailbox = $host;

        if ($imap_username != '') {
            $username = $imap_username;
        } else {
            $username = $email;
        }

        $password   = $password;
        $encryption = $encryption;
        // open connection
        $imap = new Imap($mailbox, $username, $password, $encryption);
        if ($imap->isConnected() === true) {
            echo json_encode([
                'alert_type' => 'success',
                'message'    => _l('lead_email_connection_ok'),
            ]);
        } else {
            echo json_encode([
                'alert_type' => 'warning',
                'message'    => $imap->getError(),
            ]);
        }
    }

    private function email_exist_as_staff()
    {
        return total_rows('tbldepartments', 'email IN (SELECT email FROM tblstaff)') > 0;
    }
}
