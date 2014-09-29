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
            $this->session->set_userdata('user_nrol', $user->nomb_rol);
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

        if ($string !="" && preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/", $string)) {
            
            // Convertir dd/mm/YYYY a YYYY-mm-dd
            $date = str_replace('/', '-', $string);
            $fecha = date('Y-m-d', strtotime($date));

            $this->db->select('usuario.codi_usu AS codi_usu,usuario.codi_rol AS codi_rol,usuario.reg_usu AS reg_usu,
                rol.nomb_rol AS nomb_rol,usuario.nomb_usu AS nomb_usu,usuario.pass_usu AS pass_usu,
                usuario.acce_usu AS acce_usu,usuario.ses_usu AS ses_usu,usuario.esta_usu AS esta_usu');

            $this->db->from('compra');
            $this->db->join('usuario', 'compra.codi_usu = usuario.codi_usu');
            $this->db->join('rol', 'usuario.codi_rol = rol.codi_rol');
            $this->db->where(array('DATE(compra.fech_com)' => $fecha, 'compra.esta_com' => 'A'));
            $this->db->distinct();
            $query = $this->db->get();

        } else {
            $this->db->like('nomb_rol', $string);
            $this->db->or_like('nomb_usu', $string);
            $this->db->or_like('codi_usu', $string);
            $this->db->or_like('esta_usu', $string);
            $query = $this->db->get('v_usuario');
        }

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

    function get_vusuario_paginate_report($limit, $start) {

        $this->db->where(array('esta_usu' => 'A'));
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
