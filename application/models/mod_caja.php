<?php

class mod_caja extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function validar_caja_dia($fecha) {
        $this->db->where(array('DATE(fein_cad)' => $fecha, 'esta_cad' => 'A'));
        $query = $this->db->get('caja_dia');
        $result = $query->result();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

//    public function get_vcaja($fecha) {
//        $this->db->select('*');
//        $this->db->from('caja');
//        $this->db->where(array('(SELECT DATE(`caja_dia`.`fein_cad`) FROM `caja_dia` WHERE `caja`.`codi_caj` = `caja_dia`.`codi_caj`) =' => $fecha));
//        $query = $this->db->get();
//        return $query->result();
//    }

    public function get_vcaja($fecha) {
        $this->db->where(array('DATE(fein_cad)' => $fecha));
        $query = $this->db->get('v_caja_dia');
        return $query->result();
    }

    public function get_caja_paginate($limit, $start, $string = "") {

        $this->db->like('codi_caj', $string);
        $this->db->or_like('num_caj', $string);
        $this->db->or_like('obsv_caj', $string);
        $this->db->or_like('fech_caj', $string);

        $query = $this->db->get('caja');

        $usuarios = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($usuarios as $row) {
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

    function insert($data) {
        $this->db->insert('caja', $data);
    }

    function update($id, $data) {
        $this->db->where('codi_caj', $id);
        return $this->db->update('caja', $data);
    }

}
