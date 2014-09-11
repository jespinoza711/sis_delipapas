<?php

class mod_proveedor extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($data) {
        $this->db->insert('proveedor', $data);
    }
    
    function update($id, $data) {
        $this->db->where('codi_pro', $id);
        $this->db->update('proveedor', $data);
    }
    
    function get_proveedor_paginate($limit, $start, $string = "") {
        $this->db->like('codi_pro', $string);
        $this->db->or_like('nomb_pro', $string);
        $this->db->or_like('dire_pro', $string);
        $this->db->or_like('telf_pro', $string);
        $this->db->or_like('ruc_pro', $string);
        $this->db->or_like('emai_pro', $string);
        $this->db->or_like('esta_pro', $string);
        $query = $this->db->get('proveedor');
        $proveedor = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($proveedor as $row) {
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
