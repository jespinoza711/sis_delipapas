<?php

class mod_conductor extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert($data) {
        $this->db->insert('transportista_conductor', $data);
    }

    function update($id, $data) {
        $this->db->where('id_cond', $id);
        $this->db->update('transportista_conductor', $data);
    }

    function get_paginate($limit, $start, $string = "") {
        $this->db->like('id_cond', $string);
        $this->db->or_like('nomb_cond', $string);
        $this->db->or_like('apel_cond', $string);
        $this->db->or_like('licen_cond', $string);
        $query = $this->db->get('transportista_conductor');
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
