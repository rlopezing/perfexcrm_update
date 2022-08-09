<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Time_controls extends Admin_controller
{
  public function __construct() 
  {
    parent::__construct();
    $this->load->model('time_controls_model');
  }

  /**
	 * List all signing
	 */
  public function index()
  {
    if (!has_permission('time_controls', '', 'view') && !has_permission('time_controls', '', 'view_own')) access_denied('time_controls');
    if ($this->input->is_ajax_request()) $this->app->get_table_data('time_controls');
    
    $data['title']          = _l('timecontrol_presence');
    $_SESSION['staffid']		= '';
    $_SESSION['$fdesde'] 		= date('Y-m-01');
    $_SESSION['$fhasta'] 		= date('Y-m-t');
		$data['date_from'] 			= date('Y-m-01');
		$data['date_up'] 				= date('Y-m-t');
    $data['reasons'] 				= $this->time_controls_model->get_reasons();
    $data['staff_members'] 	= $this->staff_model->get('', ['active' => 1]);
    $data['time_control'] 	= $this->time_controls_model->get(_d(date('Y-m-d')));
    $data['schedule_assignment'] 	= $this->time_controls_model->get_schedule_assignment(get_staff_user_id());
    
    $this->load->view('admin/time_controls/manage', $data);
  }

  /**
	 * Filter list all signing
	 */
  public function filter() 
  {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('time_controls');
    }

		$data['title']                				= _l('timecontrol_presence');
    $_SESSION['staffid']									= $this->input->post('staffid');
    $_SESSION['$fdesde'] 									= date('Y-m-d', strtotime($this->input->post('date_from')));
    $_SESSION['$fhasta'] 									= date('Y-m-d', strtotime($this->input->post('date_up')));
    $data['staffid'] 											= $this->input->post('staffid');
		$data['date_from'] 										= $_SESSION['fdesde'];
		$data['date_up'] 											= $_SESSION['fhasta'];
    $data['reasons'] 											= $this->time_controls_model->get_reasons();
    $data['staff_members'] 								= $this->staff_model->get('', ['active' => 1]);
    $data['schedule_assignment'] 					= $this->time_controls_model->get_schedule_assignment(get_staff_user_id());
		
    $this->load->view('admin/time_controls/manage', $data);
  }

  /**
	 * Edit signing
	 */
  public function edit($day) 
  {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('time_controls');
    }

		$data['title']                = _l('timecontrol_presence');
    $_SESSION['staffid']					= $this->input->post('staffid');
    $_SESSION['$fdesde'] 					= date('Y-m-d', strtotime($this->input->post('date_from')));
    $_SESSION['$fhasta'] 					= date('Y-m-d', strtotime($this->input->post('date_up')));
    $data['staffid'] 							= $this->input->post('staffid');
		$data['date_from'] 						= $_SESSION['fdesde'];
		$data['date_up'] 							= $_SESSION['fhasta'];
    $data['reasons'] 							= $this->time_controls_model->get_reasons();
    $data['staff_members'] 				= $this->staff_model->get('', ['active' => 1]);
    $data['schedule_assignment'] 	= $this->time_controls_model->get_schedule_assignment(get_staff_user_id());
    $data['time_control'] 				= $this->time_controls_model->get("", $day);
    $data['operation']						= "edit";
		
    $this->load->view('admin/time_controls/manage', $data);
  }
  
  /**
	 * Filter list all signing
	 */
  public function signing($sign) 
  {
    if ($sign == 'entry_time') 
    {
      if (!has_permission('time_controls', '', 'create')) {
        access_denied('time_controls');
      }
      
      $id = $this->time_controls_model->add($sign);
      if ($id) {
        set_alert('success', _l('added_successfully', _l('schedule')));
        redirect(admin_url('time_controls'));
      }
    } else {
      if (!has_permission('time_controls', '', 'edit')) {
        access_denied('time_controls');
      }
      
      if ($sign == "edit") $time_control = $this->input->post(); else $time_control = $this->time_controls_model->get(_d(date('Y-m-d')));
      $success = $this->time_controls_model->update($sign,$time_control);
      if ($success) set_alert('success', _l('updated_successfully', _l('schedule')));
      
      redirect(admin_url('time_controls'));
    }
  }

////////////////////
///// Configuration Holiday
    
  /**
	 * Configurations schedule
	 */
  public function configurations($id = '') 
  {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('configurations');
    }
    
    $data['title']                	= _l('schedule_configuration');
    $data['modalitys'] 							= $this->time_controls_model->get_modalitys();
    $data['holidays'] 							= $this->time_controls_model->get_holidays();
    if (is_numeric($id)) {
    	$data['schedule_holidays'] 		= $this->time_controls_model->get_schedule_holidays($id);
    	$data['schedule'] 						= $this->time_controls_model->get_schedule($id);
		}
		
    $this->load->view('admin/time_controls/manage_configuration', $data);
  }
  
  /**
	 * Add and update configuration schedule
	 */
  public function configuration() 
  {
    if ($this->input->post()) 
    {
      if (!$this->input->post('scheduleid')) {
        $id = $this->time_controls_model->add_schedule($this->input->post());
        if ($id) {
          set_alert('success', _l('added_successfully', _l('schedule')));
          redirect(admin_url('time_controls/configurations'));
        }
      } else {
        $data = $this->input->post();
        $scheduleid = $this->input->post('scheduleid');
        $success = $this->time_controls_model->update_schedule($data, $scheduleid);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('schedule')));
        }
        redirect(admin_url('time_controls/configurations'));
      }
  	}
  }
  
  /**
	 * delete configuration schedule
	 */
  public function delete_configuration($scheduleid) 
  {
    if (!$scheduleid) redirect(admin_url('time_controls/configurations'));
    if (!is_admin()) access_denied('contracts');
    $response = $this->time_controls_model->delete_schedule($scheduleid);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('schedule')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('schedule')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('schedule')));
    }
    redirect(admin_url('time_controls/configurations'));
  }
  
  /**
	 * Add and update configuration holiday associate schedule
	 */
  public function holiday_associate() 
  {
    if ($this->input->post()) {
      if (!$this->input->post('scheduleholidayid')) {
        $id = $this->time_controls_model->add_holiday_associate($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('schedule_holiday'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message
        ]);
      }
  	}
  }
  
  /**
	 * delete holidays associate schedule
	 */
  public function delete_holiday_associate($scheduleholidayid, $scheduleid) 
  {
    if (!$scheduleholidayid) redirect(admin_url('time_controls/configurations/'.$scheduleid));
    if (!is_admin()) access_denied('contracts');
    $response = $this->time_controls_model->delete_holiday_associate($scheduleholidayid);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('schedule_holiday')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('schedule_holiday')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('schedule_holiday')));
    }
    
    redirect(admin_url('time_controls/configurations/'.$scheduleid));
  }
  
////////////////////
///// Assignments Schedule

  /**
	 * List assign schedule
	 */
  public function assignments($id = '') 
  {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('assignment');
    }
    
    $data['title']                				= _l('schedule_assignment');
    $data['schedules'] 										= $this->time_controls_model->get_schedule();
    $data['staff_members'] 								= $this->staff_model->get('', ['active' => 1]);
    if (is_numeric($id)) $data['assign'] 	= $this->time_controls_model->get_assign($id);
		
    $this->load->view('admin/time_controls/manage_assignment', $data);
  }
  
  /**
	 * Add and update assign schedule
	 */
  public function assignment() 
  {
    if ($this->input->post()) {
      if (!$this->input->post('scheduleassignmentid')) {
        $id = $this->time_controls_model->add_assign($this->input->post());
        if ($id) {
          set_alert('success', _l('added_successfully', _l('schedule_assignment')));
          redirect(admin_url('time_controls/assignments'));
        }
      } else {
        $data = $this->input->post();
        $scheduleassignmentid = $this->input->post('scheduleassignmentid');
        $success = $this->time_controls_model->update_assign($data, $scheduleassignmentid);
        if ($success) {
          set_alert('success', _l('updated_successfully', _l('schedule_assignment')));
        }
        redirect(admin_url('time_controls/assignments'));
      }
  	}
  }
  
  /**
	 * delete assign schedule
	 */
  public function delete_assignment($scheduleassignmentid) 
  {
    if (!$scheduleassignmentid) redirect(admin_url('time_controls/assignments'));
    if (!is_admin()) access_denied('contracts');
    $response = $this->time_controls_model->delete_assign($scheduleassignmentid);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('schedule_assignment')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('schedule_assignment')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('schedule_assignment')));
    }
    redirect(admin_url('time_controls/assignments'));
  }
  
////////////////////
///// Configuration Holiday
  
  /**
   * List the holidays
   */
  public function holidays() {
    if ($this->input->is_ajax_request()) {
      $this->app->get_table_data('holidays');
    }
    
    $data['title']                = _l('schedule_holidays');
		
    $this->load->view('admin/time_controls/manage_holidays', $data);
  }
  
  /**
	 * Add and edit holiday
	 */
  public function holiday() {
    if ($this->input->post()) {
      if (!$this->input->post('id')) {
        $id = $this->time_controls_model->add_holiday($this->input->post());
        if ($id) {
          $success = true;
          $message = _l('added_successfully', _l('schedule_holiday'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
          'id'      => $id,
          'detalle' => $this->input->post('holiday_reason'),
        ]);
      } else {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);
        $success = $this->time_controls_model->update_holiday($data, $id);
        $message = '';
        if ($success) {
          $message = _l('updated_successfully', _l('schedule_holiday'));
        }
        echo json_encode([
          'success' => $success,
          'message' => $message,
        ]);
      }
  	}
  }
  
  /**
	 * Delete holiday
	 * @param mixed $id holiday id
	 */
  public function delete_holiday($id) {
    if (!$id) redirect(admin_url('time_controls/holidays'));
    if (!is_admin()) access_denied('contracts');
    $response = $this->time_controls_model->delete_holiday($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('schedule_holidays')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('schedule_holidays')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('schedule_holidays')));
    }
    redirect(admin_url('time_controls/holidays'));
  }
  
////////////////////
///// Signing My Days
    
  /**
	 * Add my day
	 */
  public function myday() {
    if ($this->input->post()) {
      if (!$this->input->post('id')) {
        $id = $this->time_controls_model->add_myday($this->input->post());
        if ($id) {
          set_alert('success', _l('added_successfully', _l('timecontrol_my_day')));
          redirect(admin_url('time_controls'));
        }
			}
  	}
  }
  
  /**
	 * Delete my day
	 * @param mixed $id my day id
	 */
  public function delete_myday($id) {
    if (!$id) redirect(admin_url('time_controls'));
    if (!is_admin()) access_denied('time_controls');
    $response = $this->time_controls_model->delete_myday($id);
    if (is_array($response) && isset($response['referenced'])) {
      set_alert('warning', _l('is_referenced', _l('timecontrol_my_day')));
    } elseif ($response == true) {
      set_alert('success', _l('deleted', _l('timecontrol_my_day')));
    } else {
      set_alert('warning', _l('problem_deleting', _l('timecontrol_my_day')));
    }
    redirect(admin_url('time_controls'));
  }
  
}
