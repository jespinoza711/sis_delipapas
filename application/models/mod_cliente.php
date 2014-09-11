<?php

class mod_cliente extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($data) {
        $this->db->insert('cliente', $data);
    }
    
    function update($id, $data) {
        $this->db->where('codi_cli', $id);
        $this->db->update('cliente', $data);
    }

    function get_cliente_paginate($limit, $start, $string = "") {

        $this->db->like('codi_cli', $string);
        $this->db->or_like('nomb_cli', $string);
        $this->db->or_like('apel_cli', $string);
        $this->db->or_like('dire_cli', $string);
        $this->db->or_like('telf_cli', $string);
        $this->db->or_like('ruc_cli', $string);
        $this->db->or_like("CONCAT(nomb_cli,' ', apel_cli)", $string);
        $query = $this->db->get('cliente');
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
