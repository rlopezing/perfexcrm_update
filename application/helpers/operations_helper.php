<?php

defined('BASEPATH') or exit('No direct script access allowed');

hooks()->add_action('app_admin_assets', '_maybe_init_admin_operation_assets', 5);

function _maybe_init_admin_operation_assets()
{
    $CI = &get_instance();
    if (strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/operation/view') !== false
        || strpos($_SERVER['REQUEST_URI'], get_admin_uri() . '/operation/gantt') !== false) {
        $CI = &get_instance();

        $CI->app_scripts->add('jquery-comments-js', 'assets/plugins/jquery-comments/js/jquery-comments.min.js', 'admin', ['vendor-js']);
        $CI->app_scripts->add('jquery-gantt-js', 'assets/plugins/gantt/js/jquery.fn.gantt.min.js', 'admin', ['vendor-js']);

        $CI->app_css->add('jquery-comments-css', 'assets/plugins/jquery-comments/css/jquery-comments.css', 'admin', ['reset-css']);
        $CI->app_css->add('jquery-gantt-css', 'assets/plugins/gantt/css/style.css', 'admin', ['reset-css']);
    }
}

/**
 * Default operation tabs
 * @return array
 */

function get_operation_tabs_admin()
{
    return get_instance()->app_tabs->get_operation_tabs();
}

/**
 * Init the default operation tabs
 * @return null
 */
function app_init_operation_tabs()
{
    $CI = &get_instance();

    $CI->app_tabs->add_operation_tab('operation_overview', [
        'name'     => _l('operation_overview'),
        'icon'     => 'fa fa-th',
        'view'     => 'admin/operations/operation_overview',
        'position' => 5,
    ]);

    $CI->app_tabs->add_operation_tab('necessary_documentation', [
        'name'                      => _l('necessary_documentation'),
        'icon'                      => 'fa fa-file',
        'view'                      => 'admin/operations/necessary_documentation',
        'position'                  => 10,
        'linked_to_customer_option' => ['view_timesheets'],
    ]);
    
    $CI->app_tabs->add_operation_tab('operation_tracing', [
        'name'                      => _l('operation_tracing'),
        'icon'                      => 'fa fa-check-circle',
        'view'                      => 'admin/operations/operation_tracing',
        'position'                  => 15,
        'linked_to_customer_option' => ['view_tasks'],
    ]);

    $CI->app_tabs->add_operation_tab('contract_signature', [
        'name'                      => _l('contract_signature'),
        'icon'                      => 'fa fa-pencil-square',
        'view'                      => 'admin/operations/contract_signature',
        'position'                  => 20,
        'linked_to_customer_option' => ['view_milestones'],
    ]);
    
}

/**
 * Filter only visible tabs selected from operation settings
 * @param  array $tabs available tabs
 * @param  array $applied_settings current applied operation visible tabs
 * @return array
 */
function filter_operation_visible_tabs($tabs, $applied_settings)
{
    $newTabs = [];
    foreach ($tabs as $key => $tab) {
        $dropdown = isset($tab['collapse']) ? true : false;

        if ($dropdown) {
            $totalChildTabsHidden = 0;
            $newChild             = [];

            foreach ($tab['children'] as $d) {
                if ((isset($applied_settings[$d['slug']]) && $applied_settings[$d['slug']] == 0)) {
                    $totalChildTabsHidden++;
                } else {
                    $newChild[] = $d;
                }
            }

            if ($totalChildTabsHidden == count($tab['children'])) {
                continue;
            }

            if (count($newChild) > 0) {
                $tab['children'] = $newChild;
            }

            $newTabs[$tab['slug']] = $tab;
        } else {
            if (isset($applied_settings[$key]) && $applied_settings[$key] == 0) {
                continue;
            }

            $newTabs[$tab['slug']] = $tab;
        }
    }

    return hooks()->apply_filters('operation_filtered_visible_tabs', $newTabs);
}

/**
 * Get operation by ID or current queried operation
 * @param  mixed $id operation id
 * @return mixed
 */
function get_operation($id = null)
{
    if (empty($id) && isset($GLOBALS['operation'])) {
        return $GLOBALS['operation'];
    }

    // Client global object not set
    if (empty($id)) {
        return null;
    }

    if (!class_exists('operation_model', false)) {
        get_instance()->load->model('operation_model');
    }

    $operation = get_instance()->operation_model->get($id);

    return $operation;
}

/**
 * Get operation status by passed operation id
 * @param  mixed $id operation id
 * @return array
 */
function get_operation_status_by_id($id)
{
    $CI = &get_instance();
    if (!class_exists('operations_model')) {
        $CI->load->model('operations_model');
    }

    $statuses = $CI->operations_model->get_operation_statuses();

    $status = [
          'id'    => 0,
          'color' => '#333',
          'name'  => '[Status Not Found]',
          'order' => 1,
      ];

    foreach ($statuses as $s) {
        if ($s['id'] == $id) {
            $status = $s;

            break;
        }
    }

    return $status;
}

/**
 * Return logged in user pinned operations
 * @return array
 */
function get_user_pinned_operations()
{
    $CI = &get_instance();
    $CI->db->select(db_prefix() . 'projects.id, ' . db_prefix() . 'projects.name, ' . db_prefix() . 'projects.clientid, ' . get_sql_select_client_company());
    $CI->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id=' . db_prefix() . 'pinned_projects.project_id');
    $CI->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'projects.clientid');
    $CI->db->where(db_prefix() . 'pinned_projects.staff_id', get_staff_user_id());
    $projects = $CI->db->get(db_prefix() . 'pinned_projects')->result_array();
    $CI->load->model('operation_model');

    foreach ($projects as $key => $operation) {
        $projects[$key]['progress'] = $CI->operation_model->calc_progress($operation['id']);
    }

    return $projects;
}


/**
 * Get operation name by passed id
 * @param  mixed $id
 * @return string
 */
function get_operation_name_by_id($id)
{
    $CI      = & get_instance();
    $operation = $CI->app_object_cache->get('operation-name-data-' . $id);

    if (!$operation) {
        $CI->db->select('name');
        $CI->db->where('id', $id);
        $operation = $CI->db->get(db_prefix() . 'projects')->row();
        $CI->app_object_cache->add('operation-name-data-' . $id, $operation);
    }

    if ($operation) {
        return $operation->name;
    }

    return '';
}

/**
 * Return operation milestones
 * @param  mixed $project_id project id
 * @return array
 */
function get_operation_milestones($project_id)
{
    $CI = &get_instance();
    $CI->db->where('project_id', $project_id);
    $CI->db->order_by('milestone_order', 'ASC');

    return $CI->db->get(db_prefix() . 'milestones')->result_array();
}

/**
 * Get operation client id by passed operation id
 * @param  mixed $id operation id
 * @return mixed
 */
function get_client_id_by_operation_id($id)
{
    $CI = & get_instance();
    $CI->db->select('clientid');
    $CI->db->where('id', $id);
    $operation = $CI->db->get(db_prefix() . 'projects')->row();
    if ($operation) {
        return $operation->clientid;
    }

    return false;
}

/**
 * Check if customer has operation assigned
 * @param  mixed $customer_id customer id to check
 * @return boolean
 */
function customer_has_operation($customer_id)
{
    $totalCustomerProjects = total_rows(db_prefix() . 'projects', 'clientid=' . $customer_id);

    return ($totalCustomerProjects > 0 ? true : false);
}

/**
 * Get operation billing type
 * @param  mixed $project_id
 * @return mixed
 */
function get_operation_billing_type($project_id)
{
    $CI = & get_instance();
    $CI->db->select('billing_type');
    $CI->db->where('id', $project_id);
    $operation = $CI->db->get(db_prefix() . 'projects')->row();
    if ($operation) {
        return $operation->billing_type;
    }

    return false;
}
/**
 * Get operation deadline
 * @param  mixed $project_id
 * @return mixed
 */
function get_operation_deadline($project_id)
{
    $CI = & get_instance();
    $CI->db->select('deadline');
    $CI->db->where('id', $project_id);
    $operation = $CI->db->get(db_prefix() . 'projects')->row();
    if ($operation) {
        return $operation->deadline;
    }

    return false;
}

/**
 * Translated jquery-comment language based on app languages
 * This feature is used on both admin and customer area
 * @return array
 */
function get_operation_discussions_language_array()
{
    $lang = [
        'discussion_add_comment'      => _l('discussion_add_comment'),
        'discussion_newest'           => _l('discussion_newest'),
        'discussion_oldest'           => _l('discussion_oldest'),
        'discussion_attachments'      => _l('discussion_attachments'),
        'discussion_send'             => _l('discussion_send'),
        'discussion_reply'            => _l('discussion_reply'),
        'discussion_edit'             => _l('discussion_edit'),
        'discussion_edited'           => _l('discussion_edited'),
        'discussion_you'              => _l('discussion_you'),
        'discussion_save'             => _l('discussion_save'),
        'discussion_delete'           => _l('discussion_delete'),
        'discussion_view_all_replies' => _l('discussion_view_all_replies'),
        'discussion_hide_replies'     => _l('discussion_hide_replies'),
        'discussion_no_comments'      => _l('discussion_no_comments'),
        'discussion_no_attachments'   => _l('discussion_no_attachments'),
        'discussion_attachments_drop' => _l('discussion_attachments_drop'),
    ];

    return $lang;
}

/**
 * Check if operation has recurring tasks
 * @param  mixed $id operation id
 * @return boolean
 */
function operation_has_recurring_tasks($id)
{
    return total_rows(db_prefix() . 'tasks', 'recurring=1 AND rel_id="' . $id . '" AND rel_type="operation"') > 0;
}

function total_operation_tasks_by_milestone($milestone_id, $project_id)
{
    return total_rows(db_prefix() . 'tasks', [
              'rel_type'  => 'operation',
              'rel_id'    => $project_id,
              'milestone' => $milestone_id,
             ]);
}

function total_operation_finished_tasks_by_milestone($milestone_id, $project_id)
{
    return total_rows(db_prefix() . 'tasks', [
             'rel_type'  => 'operation',
             'rel_id'    => $project_id,
             'status'    => 5,
             'milestone' => $milestone_id,
             ]);
}
