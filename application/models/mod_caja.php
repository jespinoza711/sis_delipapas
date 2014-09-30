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
        $query = $this->db->get('v_caja_chica_dia');
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

    public function get_vcajachica_dia($caja) {
        $this->db->where(array('codi_cac' => $caja));
        $this->db->order_by('fein_ccd', 'DESC');
        $query = $this->db->get('v_caja_chica_dia');
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

    public function get_caja_chica_dia_paginate($limit, $start, $string = '', $subquery = '') {
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $this->db->or_like('codi_gas', $string);
        $this->db->or_like('fech_gas', $string);
        $this->db->or_like('nomb_usu', $string);
        $this->db->or_like('nomb_con', $string);
        $this->db->or_like('nomb_gas', $string);
        $query = $this->db->get('v_gastos');
        $gastos = $query->result();

        $i = 0;
        $c = 0;
        $result = array();
        foreach ($gastos as $row) {
            if ($i >= $start) {
                if ($c < $limit) {
                    if ($subquery == 'one') {
                        if (substr($row->fech_gas, 0, 10) == $date) {
                            $result[$c] = $row;
                            $c++;
                        }
                    } else {
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

    function insert($data) {
        $this->db->insert('caja', $data);
    }

    function update($id, $data) {
        $this->db->where('codi_caj', $id);
        return $this->db->update('caja', $data);
    }

    function update_compra($id, $data) {
        $this->db->where('codi_com', $id);
        return $this->db->update('compra', $data);
    }

    function update_venta($id, $data) {
        $this->db->where('codi_ven', $id);
        return $this->db->update('venta', $data);
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

    function open_cajachica($data) {
        $this->db->set('fein_ccd', 'sysdate()', false);
        $this->db->set('fefi_ccd', 'sysdate()', false);
        return $this->db->insert('caja_chica_dia', $data);
    }

    function close_cajachica($data, $caja_dia) {
        $this->db->where('codi_ccd', $caja_dia);
        return $this->db->update('caja_chica_dia', $data);
    }

    function registro_gasto_cajachica($data) {
        $this->db->set('fech_gas', 'sysdate()', false);
        return $this->db->insert('gastos', $data);
    }

    function edit_gasto_cajachica($codi_gas, $data) {
        $this->db->where('codi_gas', $codi_gas);
        return $this->db->update('gastos', $data);
    }

    function get_ventas_interval($interval) {
        $this->db->where($interval);
        $query = $this->db->get('v_venta');
        return $query->result();
    }

    function get_compras_interval($interval) {
        $this->db->where($interval);
        $query = $this->db->get('v_compra');
        return $query->result();
    }

    function get_caja_interval($interval) {
        $this->db->where($interval);
        $query = $this->db->get('v_caja_dia');
        return $query->result();
    }

    function gastos_cajachica_dia($date) {
        $this->db->select('SUM(impo_gas) AS suma');
        $this->db->from('gastos');
        $this->db->where(array('DATE(fech_gas)' => $date, 'esta_gas' => 'A'));
        $query = $this->db->get();
        $result = $query->row();
        return $result->suma;
    }

    function ventas_caja_dia($date) {
        $this->db->select('SUM(tota_ven) AS suma');
        $this->db->from('venta');
        $this->db->where(array('DATE(fech_ven)' => $date, 'esta_ven' => 'A'));
        $query = $this->db->get();
        $result = $query->row();
        return $result->suma;
    }

    function compras_caja_dia($date) {
        $this->db->select('SUM(tota_com) AS suma');
        $this->db->from('compra');
        $this->db->where(array('DATE(fech_com)' => $date, 'esta_com' => 'A'));
        $query = $this->db->get();
        $result = $query->row();
        return $result->suma;
    }

}
