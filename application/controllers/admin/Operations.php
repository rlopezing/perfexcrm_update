<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operations extends Admin_controller
{
  public function __construct() 
  {
    parent::__construct();
    $this->load->model('operations_model');
    $this->load->model('commercials_visits_model');
    $this->load->model('projects_model');
    $this->load->model('currencies_model');
    $this->load->model('tasks_model');
    $this->load->helper('date');
  }

  /* List all contracts */
  public function index() {
    close_setup_menu();
    if (!has_permission('operations', '', 'view') && !has_permission('operations', '', 'view_own')) access_denied('operations');

    $data['statuses'] = $this->operations_model->get_operation_statuses();
    $data['title']    = _l('operations_list_operations');
    $this->load->view('admin/operations/manage', $data);
  }
    
  public function table($clientid = '')
  {
    $this->app->get_table_data('operations', ['clientid' => $clientid,]);
  }
  
  /************************************
  * CLIENT GEOLOCATION
  */  
  
  /* clients geolocation */
  public function geolocations ($id = '') 
  {
    if (!has_permission('operations','','view') && !has_permission('operations','','view_own')) {
      access_denied('operations');
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
  
  /*** Vista Operación ***/
  public function view($id) {
    if (has_permission('operations', '', 'view')) {
      close_setup_menu();
      $operation = $this->operations_model->get($id);

      if (!$operation) blank_page(_l('project_not_found'));

      $project->settings->available_features = unserialize($project->settings->available_features);
      
      $data['statuses'] = $this->operations_model->get_operation_statuses();
      $group = !$this->input->get('group') ? 'operation_overview' : $this->input->get('group');

      if (strpos($group, '#') !== false) $group = str_replace('#', '', $group);
      $data['tabs'] = get_operation_tabs_admin();
      $data['tab']  = $this->app_tabs->filter_tab($data['tabs'], $group);

      if (!$data['tab']) show_404();
      
      $percent            = $this->operations_model->get_percent_circle($id);
      $data['operation']  = $operation;
      $data['currency']   = $this->projects_model->get_currency($id);
      $data['staff']     = $this->staff_model->get('', ['active' => 1]);
      
      $data['bodyclass'] = '';
      $this->app_scripts->add(
        'projects-js',
        base_url($this->app_scripts->core_file('assets/js', 'projects.js')) . '?v=' . $this->app_scripts->core_version(),
        'admin',
        ['app-js', 'jquery-comments-js', 'jquery-gantt-js', 'circle-progress-js']
      );
      
      if ($group == 'operation_overview') {
        $data['members'] = $this->projects_model->get_project_members($id);
        foreach ($data['members'] as $key => $member) {
          $data['members'][$key]['total_logged_time'] = 0;
          $member_timesheets                          = $this->tasks_model->get_unique_member_logged_task_ids($member['staff_id'], ' AND task_id IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type="project" AND rel_id="' . $id . '")');
          foreach ($member_timesheets as $member_task) {
            $data['members'][$key]['total_logged_time'] += $this->tasks_model->calc_task_total_time($member_task->task_id, ' AND staff_id=' . $member['staff_id']);
          }
        }
        @$percent_circle = (round(($percent->status / $percent->percent) * 100,0,PHP_ROUND_HALF_ODD))/100;
        $data['percent_circle'] = $percent_circle;
      } elseif ($group == 'necessary_documentation') {
        $data['documents'] = $this->operations_model->get_documents_necessary($id, $operation->type_id);
      } elseif ($group == 'operation_tracing') {  
        $data['contact_types'] = $this->commercials_visits_model->get_contact_types();
        $data['tracings']      = $this->operations_model->get_tracing();
      } elseif ($group == 'contract_signature') {
        
      }

      // Discussions
      if ($this->input->get('discussion_id')) {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['discussion']                        = $this->projects_model->get_discussion($this->input->get('discussion_id'), $id);
        $data['current_user_is_admin']             = is_admin();
      }

      $data['percent'] = $percent;

      $this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');
      
      $other_operations       = [];
      $other_operations_where = 'id != ' . $id;
      $statuses = $this->operations_model->get_operation_statuses();
      $other_operations_where .= ' AND (';
      foreach ($statuses as $status) {
        $other_operations_where .= 'status = ' . $status['id'] . ' OR ';
      }
      $other_operations_where = rtrim($other_operations_where, ' OR ');
      $other_operations_where .= ')';

      if (!has_permission('operations', '', 'view')) {
        if (is_admin()) $other_operations_where .= ' AND ' . db_prefix() . 'cvisit.id IN (SELECT id FROM ' . db_prefix() . 'cvisit WHERE status > 1)';
        if (!is_admin()) $other_operations_where .= ' AND ' . db_prefix() . 'cvisit.id IN (SELECT ' . db_prefix() . 'cvisit.id FROM ' . db_prefix() . 'customer_admins INNER JOIN ' . db_prefix() . 'cvisit ON ' . db_prefix() . 'customer_admins.customer_id = ' . db_prefix() . 'cvisit.client WHERE ' . db_prefix() . 'customer_admins.staff_id=' . get_staff_user_id() . ' AND ' . db_prefix() . 'cvisit.status > 1)';
      }
      $data['other_operations'] = $this->commercials_visits_model->get('', $other_operations_where);
      
      $data['title']              = $data['operation']->subject;
      $data['bodyclass']         .= 'project invoices-total-manual estimates-total-manual';
      $data['operations_status']  = get_operation_status_by_id($operation->status);
      $data['details']            = $this->operations_model->get_visit_detail($operation->id);

      $this->load->view('admin/operations/view', $data);
    } else {
      access_denied('Project View');
    }
  }
  
  /* Edit documents or add new documents */
  public function documents_necessary($id='') {
    if ($this->input->post()) {
      if ($id == ''){
        if (!has_permission('operations', '', 'create')) access_denied('operations');
        
        $data = $this->input->post();
        $visit = $data['visit'];
        $id = $this->operations_model->add_documents_necessary($data,$_FILES['file']);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('operations')));
          redirect(admin_url('operations/view/' . $visit . '?group=necessary_documentation'));
        }
      } else {
        if (!has_permission('operations', '', 'edit')) access_denied('operations');
        
        $success = $this->operations_model->update_documents_necessary($this->input->post(), $id, $_FILES['file']);
        if ($success) set_alert('success', _l('updated_successfully', _l('operations')));
        redirect(admin_url('operations/view/' . $id . '?group=necessary_documentation'));
      }
    }
  }
  
  /* Edit or add new tracing */
  public function tracing($id='') {
    if ($this->input->post()) {
      if ($id == ''){
        if (!has_permission('operations', '', 'create')) access_denied('operations');
        
        $data = $this->input->post();
        $visit = $data['visit'];
        $id = $this->operations_model->add_tracing($data);
        if ($id) {
          set_alert('success', _l('added_successfully', _l('operations')));
          redirect(admin_url('operations/view/' . $visit . '?group=operation_tracing'));
        }
      } else {
        if (!has_permission('operations', '', 'edit')) access_denied('operations');
        
        $success = $this->operations_model->update_tracing($this->input->post(), $id);
        if ($success) set_alert('success', _l('updated_successfully', _l('operations')));
        redirect(admin_url('operations/view/' . $id . '?group=operation_tracing'));
      }
    }
  }
  
  /* Update operation status */
  public function status($id) {
    if ($this->input->post()) {
      if (!has_permission('operations', '', 'edit')) access_denied('operations');

      $success = $this->operations_model->update_status($this->input->post(), $id);
      if ($success) set_alert('success', _l('updated_successfully', _l('operations')));
      redirect(admin_url('operations/view/' . $id . '?group=operation_overview'));
    }
  }
  
}