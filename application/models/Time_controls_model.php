<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Time_controls_model extends CRM_Model {
	
  public function __construct() {
    parent::__construct();
    $this->load->model('currencies_model');
  }

  /**
   * @param  id (optional)
   * @param  dateadd (optional)
   * Get time controls object based on passed id if not passed id return array of all time controls
   */
  public function get($dateadd, $id = "") {
  	if ($id == "") {
	  	$strsql = "select timecontrolid, staffid, date_add, entry_time, rest_start, end_rest, departure_time, rest from tbltctimecontrols where date_add = '" . date('Y-m-d', strtotime($dateadd)) . "' and staffid = " . get_staff_user_id();
  	}
  	if ($id != "") {
	  	$strsql = "select timecontrolid, staffid, date_add, entry_time, rest_start, end_rest, departure_time, rest from tbltctimecontrols where timecontrolid = '" . $id . "'";
  	}
  	$query = $this->db->query($strsql);
  	
    return $query->row_array();
  }
  
  /**
   * Add new
   * @param mixed $data All $_POST data
   */
  public function add($sign) {
  	$data['staffid'] 				= get_staff_user_id();
  	$data['date_add'] 			= to_sql_date(_d(date('Y-m-d')));
  	$today = getdate();
  	$hour = $today['hours'].':'.$today['minutes'].':'.$today['seconds'];
  	if ($sign == 'entry_time') $data['entry_time'] = $hour;
  	if ($sign == 'rest_start') $data['rest_start'] = $hour;
  	if ($sign == 'end_rest') $data['end_rest'] = $hour;
  	if ($sign == 'departure_time') $data['departure_time'] = $hour;
  	
  	$rest = array();
  	$data['rest']	= json_encode($rest);
  	
    $this->db->insert('tbltctimecontrols', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Time Control Added');
      return $insert_id;
    }
    
    return false;
  }
  
  /**
   * Edit time controls
   * @param mixed $data All $_POST data
   * @param mixed $id assign id
   */
  public function update($sign,$time_control) 
  {
  	$today = getdate();
  	$hour = $today['hours'].':'.$today['minutes'].':'.$today['seconds'];
  	
  	if ($sign != "edit") 
  	{
	  	if ($sign == 'entry_time') $data['entry_time'] = $hour;
	  	if ($sign == 'departure_time') $data['departure_time'] = $hour;
	  	if ($sign == 'rest_start') $data['rest_start'] = $hour;
	  	if ($sign == 'end_rest') $data['end_rest'] = $hour;
			
			if ($sign == 'end_rest' && !is_null($time_control['rest_start'])) 
			{
				$rest = array();
				$data['end_rest'] = $hour;
				$rest = json_decode($time_control['rest']);
				$period = array('output' => $time_control['rest_start'], 'input' => $hour);
				array_push($rest, $period);
				$data['rest_start'] = '00:00:00';
				$data['end_rest'] = '00:00:00';
				$data['rest']	= json_encode($rest);			
			}
	  	$this->db->where('staffid', get_staff_user_id());
	    $this->db->where('date_add', date('Y-m-d', strtotime(_d(date('Y-m-d')))));
		} 
		else 
		{
			$data['staffid'] 					= $time_control['staffid'];
	  	$data['entry_time'] 			= $time_control['entry_time'];
	  	$data['departure_time'] 	= $time_control['departure_time'];
	  	
	  	if ($time_control['rest_start'] != "" && $time_control['rest_start'] != "00:00:00"
	  		&& $time_control['end_rest'] != "" && $time_control['end_rest'] != "00:00:00")
	  	{
	  		$period = array('output' => $time_control['rest_start'], 'input' => $time_control['end_rest']);
	  		$rest = json_decode($time_control['rest']);
	  		if (count($rest) < 6)
	  		{
					array_push($rest, $period);
					$data['rest_start'] = '00:00:00';
					$data['end_rest'] 	= '00:00:00';
					$data['rest']				= json_encode($rest);
				}
				else
				{
					$data['rest'] 			= $time_control['rest'];
				}
			}
			else
			{
			  $data['rest_start'] 	= $time_control['rest_start'];
			  $data['end_rest'] 		= $time_control['end_rest'];
			  $data['rest'] 				= $time_control['rest'];
			}
	  	
	  	$this->db->where('timecontrolid', $time_control['timecontrolid']);
	  	$this->db->where('staffid', $time_control['staffid']);
		}
		
		log_message('debug', "data: ".print_r($data, TRUE));
    $this->db->update('tbltctimecontrols', $data);
    
    if ($this->db->affected_rows() > 0) {
      logActivity('Time Control Updated ID:' . $id . ']');
      return true;
    }
    
    return false;
  }
  
  
  /**
   * @param  id (optional)
   * @param  dateadd (optional)
   * Get schedule assignment object based on passed id if not passed id return array of all schedule assignment
   */
  public function get_schedule_assignment($staffid) {
  	$this->db->select("tbltcscheduleassignment.scheduleassignmentid, tbltcscheduleassignment.staffid, tbltcscheduleassignment.scheduleid, tbltcschedule.entry_time, tbltcschedule.departure_time, tbltcschedule.rest_start, tbltcschedule.end_rest, tbltcschedule.weekly_holidays");
		$this->db->where('tbltcscheduleassignment.staffid', $staffid);
		$this->db->join('tbltcschedule', 'tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid');
		
    return $this->db->get('tbltcscheduleassignment')->result_array();
  }
    
  /**
   * Get reasons for days
   */
  public function get_reasons($reasonid = '') {
    if (is_numeric($reasonid)) {
      $this->db->where('reasonid', $reasonid);
      return $this->db->get('tbltcreasons')->row();
    }
		
		$this->db->select('tbltcreasons.reasonid, CONCAT(tbltctypesreasons.name,": ",tbltcreasons.name) as full_name');
		$this->db->join("tbltctypesreasons", "tbltctypesreasons.typereasonid = tbltcreasons.type_reason");
    
    return $this->db->get('tbltcreasons')->result_array();
  }

  /**
   * Get modalitys
   */
  public function get_modalitys($modalityid = '') {
    if (is_numeric($modalityid)) {
      $this->db->where('modalityid', $modalityid);
      return $this->db->get('tbltcmodalitys')->row();
    }
		
    return $this->db->get('tbltcmodalitys')->result_array();
  }
  
////////////////////////////
///// Assignment

  /**
   * Get assign
   * @param mixed $scheduleassignmentid 
   */
  public function get_assign($scheduleassignmentid = '') {
    if (is_numeric($scheduleassignmentid)) {
      $this->db->where('scheduleassignmentid', $scheduleassignmentid);
      return $this->db->get('tbltcscheduleassignment')->row();
    }
		
    return $this->db->get('tbltcscheduleassignment')->result_array();
  }

  /**
   * Add new
   * @param mixed $data All $_POST data
   */
  public function add_assign($data) {
  	$data['start_date'] = to_sql_date($data['start_date']);
  	$data['end_date'] = to_sql_date($data['end_date']);
    $this->db->insert('tbltcscheduleassignment', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Assignment Added');
      return $insert_id;
    }
    
    return false;
  }

  /**
   * Edit
   * @param mixed $data All $_POST data
   * @param mixed $id assign id
   */
  public function update_assign($data, $id) {
  	$data['start_date'] = to_sql_date($data['start_date']);
  	$data['end_date'] = to_sql_date($data['end_date']);
    $this->db->where('scheduleassignmentid', $id);
    $this->db->update('tbltcscheduleassignment', $data);
    if ($this->db->affected_rows() > 0) {
      logActivity('Assignment Updated ID:' . $id . ']');
      return true;
    }
    
    return false;
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete assign
   */
  public function delete_assign($id) {
    $this->db->where('scheduleassignmentid', $id);
    $this->db->delete('tbltcscheduleassignment');
    if ($this->db->affected_rows() > 0) {
      logActivity('Assign Deleted [' . $id . ']');
      return true;
    }

    return false;
  }
    
////////////////////////////
///// Schedule
  
  /**
   * Get schedule
   * @param mixed $scheduleid 
   */
  public function get_schedule($scheduleid = '') {
    if (is_numeric($scheduleid)) {
      $this->db->where('scheduleid', $scheduleid);
      return $this->db->get('tbltcschedule')->row();
    }
		
    return $this->db->get('tbltcschedule')->result_array();
  }
  
////////////////////////////
///// Configuration Schedule
  
  /**
   * Get schedule holidays
   * @param mixed $scheduleid
   */
  public function get_schedule_holidays($scheduleid = '') {
  	$this->db->select("tbltcscheduleholidays.scheduleholidayid, tbltcscheduleholidays.scheduleid, tbltcscheduleholidays.holidayid, tbltcholidays.holiday_date, tbltcholidays.holiday_reason");
    $this->db->where('tbltcscheduleholidays.scheduleid', $scheduleid);
    $this->db->join("tbltcholidays", "tbltcholidays.holidayid = tbltcscheduleholidays.holidayid");
    return $this->db->get('tbltcscheduleholidays')->result_array();
  }
  
  /**
   * Add new
   * @param mixed $data All $_POST data
   */
  public function add_schedule($data) {
  	$weekly_holidays = array(
  		"schedule_monday" => isset($data['schedule_monday']) ? 1 : 0,
  		"schedule_tuesday" => isset($data['schedule_tuesday']) ? 1 : 0,
  		"schedule_wednesday" => isset($data['schedule_wednesday']) ? 1 : 0,
  		"schedule_thursday" => isset($data['schedule_thursday']) ? 1 : 0,
  		"schedule_friday" => isset($data['schedule_friday']) ? 1 : 0,
  		"schedule_saturday" => isset($data['schedule_saturday']) ? 1 : 0,
  		"schedule_sunday" => isset($data['schedule_sunday']) ? 1 : 0
  	);
  	$data['weekly_holidays'] = json_encode($weekly_holidays);
  	
  	if (isset($data['schedule_monday'])) unset($data['schedule_monday']);
  	if (isset($data['schedule_tuesday'])) unset($data['schedule_tuesday']);
  	if (isset($data['schedule_wednesday'])) unset($data['schedule_wednesday']);
  	if (isset($data['schedule_thursday'])) unset($data['schedule_thursday']);
  	if (isset($data['schedule_friday'])) unset($data['schedule_friday']);
  	if (isset($data['schedule_saturday'])) unset($data['schedule_saturday']);
  	if (isset($data['schedule_sunday'])) unset($data['schedule_sunday']);
  	
    $this->db->insert('tbltcschedule', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Schedule Added');
      return $insert_id;
    }
    
    return false;
  }
  
  /**
   * Edit
   * @param mixed $data All $_POST data
   * @param mixed $id holiday id
   */
  public function update_schedule($data, $id) {
  	$weekly_holidays = array(
  		"schedule_monday" => isset($data['schedule_monday']) ? 1 : 0,
  		"schedule_tuesday" => isset($data['schedule_tuesday']) ? 1 : 0,
  		"schedule_wednesday" => isset($data['schedule_wednesday']) ? 1 : 0,
  		"schedule_thursday" => isset($data['schedule_thursday']) ? 1 : 0,
  		"schedule_friday" => isset($data['schedule_friday']) ? 1 : 0,
  		"schedule_saturday" => isset($data['schedule_saturday']) ? 1 : 0,
  		"schedule_sunday" => isset($data['schedule_sunday']) ? 1 : 0
  	);
  	$data['weekly_holidays'] = json_encode($weekly_holidays);
  	
  	if (isset($data['schedule_monday'])) unset($data['schedule_monday']);
  	if (isset($data['schedule_tuesday'])) unset($data['schedule_tuesday']);
  	if (isset($data['schedule_wednesday'])) unset($data['schedule_wednesday']);
  	if (isset($data['schedule_thursday'])) unset($data['schedule_thursday']);
  	if (isset($data['schedule_friday'])) unset($data['schedule_friday']);
  	if (isset($data['schedule_saturday'])) unset($data['schedule_saturday']);
  	if (isset($data['schedule_sunday'])) unset($data['schedule_sunday']);
  	
    $this->db->where('scheduleid', $id);
    $this->db->update('tbltcschedule', $data);
    if ($this->db->affected_rows() > 0) {
      logActivity('Schedule Updated ID:' . $id . ']');
      return true;
    }
    
    return false;
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete holiday
   */
  public function delete_schedule($id) {
    $this->db->where('scheduleid', $id);
    $this->db->delete('tbltcschedule');
    if ($this->db->affected_rows() > 0) {
      logActivity('Schedule Deleted [' . $id . ']');
      return true;
    }

    return false;
  }
  
  /**
   * Add new
   * @param mixed $data All $_POST data
   */
  public function add_holiday_associate($data) {
    $this->db->insert('tbltcscheduleholidays', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Holiday Associate Added');
      return $insert_id;
    }
    
    return false;
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete holiday associate
   */
  public function delete_holiday_associate($id) {
    $this->db->where('scheduleholidayid', $id);
    $this->db->delete('tbltcscheduleholidays');
    if ($this->db->affected_rows() > 0) {
      logActivity('Holiday Deleted [' . $id . ']');
      return true;
    }

    return false;
  }
  
////////////////////////////
///// Holiday

  /**
   * Get schedule
   * @param mixed $scheduleid 
   */
  public function get_holidays($holidayid = '') {
    if (is_numeric($holidayid)) {
      $this->db->where('holidayid', $holidayid);
      return $this->db->get('tbltcholidays')->row();
    }
		
    return $this->db->get('tbltcholidays')->result_array();
  }

  /**
   * Add new
   * @param mixed $data All $_POST data
   */
  public function add_holiday($data) {
  	$data['holiday_date'] = to_sql_date($data['holiday_date']);
    $this->db->insert('tbltcholidays', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Holiday Added');
      return $insert_id;
    }
    
    return false;
  }
  
  /**
   * Edit
   * @param mixed $data All $_POST data
   * @param mixed $id holiday id
   */
  public function update_holiday($data, $id) {
  	$data['holiday_date'] = to_sql_date($data['holiday_date']);
    $this->db->where('holidayid', $id);
    $this->db->update('tbltcholidays', $data);
    if ($this->db->affected_rows() > 0) {
      logActivity('Holiday Updated ID:' . $id . ']');
      return true;
    }
    
    return false;
  }
  
  /**
   * @param  integer ID
   * @return mixed
   * Delete holiday
   */
  public function delete_holiday($id) {
    $this->db->where('holidayid', $id);
    $this->db->delete('tbltcholidays');
    if ($this->db->affected_rows() > 0) {
      logActivity('Holiday Deleted [' . $id . ']');
      return true;
    }

    return false;
  }

////////////////////////////
///// Mys days

  /**
   * Add new my day
   * @param mixed $data All $_POST data
   */
  public function add_myday($data) {
  	$data['staffid'] = $data['staff_id'];
  	unset($data['staff_id']);
  	$data['start_date'] = to_sql_date($data['start_date']);
  	$data['end_date'] = to_sql_date($data['end_date']);
    $this->db->insert('tbltcmysdays', $data);
    $insert_id = $this->db->insert_id();
    if ($insert_id) {
      logActivity('New Holiday Added');
      return $insert_id;
    }
    
    return false;
  }
    
  /**
   * @param  integer ID
   * @return mixed
   * Delete my day
   */
  public function delete_myday($id) {
    $this->db->where('mydayid', $id);
    $this->db->delete('tbltcmysdays');
    if ($this->db->affected_rows() > 0) {
      logActivity('Holiday Deleted [' . $id . ']');
      return true;
    }

    return false;
  }
  
}
