<?php

class mod_caja extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function status_caja() {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL, 'es_ES');
        $date = date('Y-m-d');
        $status = 1;
        
        $this->db->where(array('DATE(fein_cad)' => $date, 'esta_cad' => 'C'));
        $query = $this->db->get('v_caja_dia');
        $result = $query->result();
        if (count($result) > 0) {
            $status = 3;
        } else {
            $this->db->where(array('DATE(fein_cad)' => $date, 'esta_cad' => 'A'));
            $query = $this->db->get('v_caja_dia');
            $result = $query->result();
            if (count($result) > 0) {
                $status = 2;
            }
        }
        return $status;
    }

    public function status_cajachica() {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL, 'es_ES');
        $date = date('Y-m-d');
        $status = 1;

        $this->db->where(array('DATE(fein_ccd)' => $date, 'esta_ccd' => 'C'));
        $query = $this->db->get('caja_chica_dia');
        $result = $query->result();
        if (count($result) > 0) {
            $status = 3;
        } else {
            $this->db->where(array('DATE(fein_ccd)' => $date, 'esta_ccd' => 'A'));
            $query = $this->db->get('caja_chica_dia');
            $result = $query->result();
            if (count($result) > 0) {
                $status = 2;
            }
        }
        return $status;
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

    public function get_vcaja_dia($caja) {
        $this->db->where(array('codi_caj' => $caja));
        $this->db->order_by('fein_cad', 'DESC');
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

    function open_caja($data) {
        $this->db->set('fein_cad', 'sysdate()', false);
        $this->db->set('fefi_cad', 'sysdate()', false);
        return $this->db->insert('caja_dia', $data);
    }

    function close_caja($data, $caja_dia) {
        $this->db->where('codi_cad', $caja_dia);
        return $this->db->update('caja_dia', $data);
    }

}
