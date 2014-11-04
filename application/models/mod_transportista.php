<?php

class mod_transportista extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert($data) {
        $this->db->insert('transportista', $data);
    }

    function update($id, $data) {
        $this->db->where('id_tran', $id);
        $this->db->update('transportista', $data);
    }

    function get_paginate($limit, $start, $string = "") {
        $this->db->like('id_tran', $string);
        $this->db->or_like('nomb_tran', $string);
        $this->db->or_like('ruc_tran', $string);
        $query = $this->db->get('transportista');
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
