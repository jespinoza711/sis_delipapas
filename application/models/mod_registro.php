<?php

class mod_registro extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_registro_diario_paginate($limit, $start, $string = "") {
        $this->db->or_like('fech_dpl', $string);
        $this->db->or_like('nomb_usu', $string);
        $this->db->or_like('nomb_emp', $string);
        $this->db->or_like('apel_emp', $string);
        $query = $this->db->get('v_registro_planilla');
        $control = $query->result();

        $i = 0;
        $c = 0;
        $result = array();
        foreach ($control as $row) {
            if ($i >= $start) {
                if ($c < $limit) {
                    $result[$c] = $row;
                    $c++;
                } else {
                    break;
                }
            }
            $i++;
        }
        return $result;
    }

    public function get_registro_diario_dia_paginate($limit, $start, $string = "") {
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $this->db->or_like('fech_dpl', $string);
        $this->db->or_like('nomb_usu', $string);
        $this->db->or_like('nomb_emp', $string);
        $this->db->or_like('apel_emp', $string);
        $query = $this->db->get('v_registro_planilla');
        $control = $query->result();

        $i = 0;
        $c = 0;
        $result = array();
        foreach ($control as $row) {
            if ($i >= $start) {
                if ($c < $limit) {
                    if (substr($row->fech_dpl, 0, 10) == $date) {
                        $result[$c] = $row;
                        $c++;
                    }
                } else {
                    break;
                }
            }
            $i++;
        }
        return $result;
    }

    function registro_diario_dia($data) {
        $this->db->set('fech_dpl', 'sysdate()', false);
        return $this->db->insert('registro_planilla', $data);
    }

    function registro_diario_dia_edit($codi_dpl, $data) {
        $this->db->where(array('codi_dpl' => $codi_dpl));
        return $this->db->update('registro_planilla', $data);
        ;
    }

    function get_registro_interval($interval) {
        $this->db->where($interval);
        $query = $this->db->get('v_registro_planilla');
        return $query->result();
    }

}
