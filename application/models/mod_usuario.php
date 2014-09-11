<?php

class mod_usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function session($data) {
        $query = $this->db->where('nomb_usu', $data['user']);
        $query = $this->db->where('pass_usu', $data['pass']);
        $query = $this->db->where('esta_usu', 'A');
        $query = $this->db->get('v_usuario');
        $user = $query->row();

        if (count($user) > 0) {
            $this->session->set_userdata('user_codi', $user->codi_usu);
            $this->session->set_userdata('user_name', $user->nomb_usu);
            $this->session->set_userdata('user_rol', $user->codi_rol);
            $this->session->set_userdata('logged', true);
            $this->session->set_userdata('alert', '');

            $this->db->where('codi_usu', $user->codi_usu);
            $this->db->set('ses_usu', 'sysdate()', false);
            return $this->db->update('usuario', array('esta_usu' => 'A'));
        } else {
            return false;
        }
    }

    public function register($data) {
        $query = $this->db->where('nomb_usu', $data['nomb_usu']);
        $query = $this->db->get('usuario');
        $user = $query->row();

        if (count($user) > 0) {
            return false;
        } else {
            $data['acce_usu'] = '1111111111';
            $this->db->set('reg_usu', 'sysdate()', false);
            $this->db->set('ses_usu', 'sysdate()', false);
            return $this->db->insert('usuario', $data);
        }
    }

    function update($id, $data) {
        $this->db->where('codi_usu', $id);
        return $this->db->update('usuario', $data);
    }
    
    function get_vusuario_paginate($limit, $start, $string = "") {
        $this->db->like('nomb_rol', $string);
        $this->db->or_like('nomb_usu', $string);
        $this->db->or_like('codi_usu', $string);
        $this->db->or_like('esta_usu', $string);
        $query = $this->db->get('v_usuario');
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

}
