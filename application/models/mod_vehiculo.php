<?php

class mod_vehiculo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert($data) {
        $this->db->insert('transportista_vehiculo', $data);
    }

    function update($id, $data) {
        $this->db->where('id_vehi', $id);
        $this->db->update('transportista_vehiculo', $data);
    }

    function get_paginate($limit, $start, $string = "") {
        $this->db->like('id_vehi', $string);
        $this->db->or_like('placa_vehi', $string);
        $query = $this->db->get('transportista_vehiculo');
        $clientes = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($clientes as $row) {
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

}
