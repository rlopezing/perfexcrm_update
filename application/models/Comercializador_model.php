<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Comercializador_model extends CRM_Model
{
    public function __construct() {
        parent::__construct();
    }

    /**
    * Add new contract type
    * @param mixed $data All $_POST data
    */
    public function add($data)
    {
        $this->db->insert('tblcomicomercializador', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New Comercializador Added [' . $data['nombre'] . ']');

            return $insert_id;
        }

        return false;
    }

    /**
     * Edit contract type
     * @param mixed $data All $_POST data
     * @param mixed $id Contract type id
     */
    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tblcomicomercializador', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Comercializador Updated [' . $data['nombre'] . ', ID:' . $id . ']');

            return true;
        }

        return false;
    }

  /**
   * @param  integer ID (optional)
   * @return mixed
   * Get comercializador object based on passed id if not passed id return array of all comercializadores
   */
  public function get($id='')
  {
    if (is_numeric($id)) {
      $this->db->where('id', $id);

      return $this->db->get('tblcomicomercializador')->row();
    }
    
    if (!$comercializador && !is_array($comercializador)) {
      $comercializador = $this->db->get('tblcomicomercializador')->result_array();
    }

    return $comercializador;
  }

    /**
     * @param  integer ID
     * @return mixed
     * Delete contract type from database, if used return array with key referenced
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblcomicomercializador');
        if ($this->db->affected_rows() > 0) {
            logActivity('Contract Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

    /**
     * Get contract types data for chart
     * @return array
     */
    public function get_chart_data()
    {
        $labels = [];
        $totals = [];
        $comercializadores  = $this->get();
        foreach ($comercializadores as $comercializador) {
            $total_rows_where = [
                'comercializador' => $comercializador['id'],
                'trash'         => 0,
            ];
            if (is_client_logged_in()) {
                $total_rows_where['client']                = get_client_user_id();
                $total_rows_where['not_visible_to_client'] = 0;
            } else {
                if (!has_permission('contracts', '', 'view')) {
                    $total_rows_where['addedfrom'] = get_staff_user_id();
                }
            }
            $total_rows = total_rows('tblcomicontratos', $total_rows_where);
            if ($total_rows == 0 && is_client_logged_in()) {
                continue;
            }
            array_push($labels, $comercializador['nombre']);
            array_push($totals, $total_rows);
        }
        $chart = [
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => _l('comicontract_summary_by_type'),
                    'backgroundColor' => 'rgba(3,169,244,0.2)',
                    'borderColor'     => '#03a9f4',
                    'borderWidth'     => 1,
                    'data'            => $totals,
                ],
            ],
        ];

        return $chart;
    }

    /**
     * Get contract types values for chart
     * @return array
     */
    public function get_values_chart_data()
    {
        $labels = [];
        $totals = [];
        $comercializadores  = $this->get();
        foreach ($comercializadores as $comercializador) {
            array_push($labels, $comercializador['nombre']);

            $where = [
                'where' => [
                    'comercializador' => $comercializador['id'],
                    'trash'         => 0,
                ],
                'field' => 'valor_contrato',
            ];

            if (!has_permission('contracts', '', 'view')) {
                $where['where']['addedfrom'] = get_staff_user_id();
            }

            $total = sum_from_table('tblcomicontratos', $where);
            if ($total == null) {
                $total = 0;
            }
            array_push($totals, $total);
        }
        $chart = [
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => _l('comicontract_summary_by_type_value'),
                    'backgroundColor' => 'rgba(37,155,35,0.2)',
                    'borderColor'     => '#84c529',
                    'tension'         => false,
                    'borderWidth'     => 1,
                    'data'            => $totals,
                ],
            ],
        ];

        return $chart;
    }
}
