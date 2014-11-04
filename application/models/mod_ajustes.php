<?php

class mod_ajustes extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function update_negocio($codi, $data) {
        $this->db->where(array('codi_neg' => $codi));
        return $this->db->update('negocio', $data);
    }

    public function get_planilla_paginate($limit, $start, $string = "") {
        $this->db->like('codi_pla', $string);
        $this->db->or_like('fech_pla', $string);
        $this->db->or_like('suel_pla', $string);
        $this->db->or_like('obsv_pla', $string);
        $this->db->order_by('codi_pla', 'DESC');
        $query = $this->db->get('planilla');
        $planilla = $query->result();

        $i = 0;
        $c = 0;
        $result = array();
        foreach ($planilla as $row) {
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

    public function insert_planilla($data) {
        $this->desactivar_planillas();
        return $this->db->insert('planilla', $data);
    }

    public function update_planilla($codi_pla, $data) {
        $this->desactivar_planillas();
        $this->db->where(array('codi_pla' => $codi_pla));
        return $this->db->update('planilla', $data);
    }

    public function desactivar_planillas() {
        return $this->db->update('planilla', array('esta_pla' => 'D'));
    }

    public function get_concepto_paginate($limit, $start, $string = "") {
        $this->db->like('codi_con', $string);
        $this->db->or_like('fech_con', $string);
        $this->db->or_like('nomb_usu', $string);
        $this->db->or_like('nomb_con', $string);
        $query = $this->db->get('v_concepto');
        $concepto = $query->result();

        $i = 0;
        $c = 0;
        $result = array();
        foreach ($concepto as $row) {
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

    public function insert_concepto($data) {
        return $this->db->insert('concepto', $data);
    }

    public function update_concepto($codi_con, $data) {
        $this->db->where(array('codi_con' => $codi_con));
        return $this->db->update('concepto', $data);
    }

    public function get_comprobante_paginate($limit, $start, $string = "") {
        $this->db->like('codi_com', $string);
        $this->db->or_like('fech_reg', $string);
        $this->db->or_like('nomb_com', $string);
        $query = $this->db->get('comprobante');
        $data = $query->result();

        $i = 0;
        $c = 0;
        $result = array();
        foreach ($data as $row) {
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

    public function insert_comprobante($data) {
        return $this->db->insert('comprobante', $data);
    }

    public function update_comprobante($codi_com, $data) {
        $this->db->where(array('codi_com' => $codi_com));
        return $this->db->update('comprobante', $data);
    }

}
