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
        $query = $this->db->where('user_coder', $data['user_coder']);
        $query = $this->db->where('esta_coder', 'A');
        $query = $this->db->get('tb_coder');
        $user = $query->row();

        if (count($user) > 0) {
            return false;
        } else {
            $query = $this->db->where('email_coder', $data['email_coder']);
            $query = $this->db->where('esta_coder', 'A');
            $query = $this->db->get('tb_coder');
            $email = $query->row();

            if (count($email) > 0) {
                return false;
            } else {
                $data['sexo_coder'] = '';
                $data['mov_coder'] = '';
                $data['id_dist'] = '1';
                $data['id_univ'] = '1';
                $data['id_tico'] = '1';
                $data['id_nivel'] = '1';
                $data['id_team'] = '1';
                $data['fast_tra'] = '0';
                $data['fast_con'] = '0';
                $data['sub_tra'] = '0';
                $data['sub_con'] = '0';
                $data['cont_coder'] = '0';
                $data['dare_win'] = '0';
                $data['dare_los'] = '0';
                $data['hack_win'] = '0';
                $data['hack_los'] = '0';
                $data['puntos_prev'] = '0';
                $data['puntos_coder'] = '0';
                $data['acti_coder'] = 'S';
                $data['ses_coder'] = 'O';
                $data['esta_coder'] = 'A';
                $this->db->set('date_reg', 'sysdate()', false);
                $this->db->set('last_visit', 'sysdate()', false);
                $this->db->insert('tb_coder', $data);
                return $this->db->insert_id();
            }
        }
    }

    function get_usuario() {
        $consulta = $this->db->get("vusuario");
        return $consulta->result();
    }

    function get_rol() {
        $consulta = $this->db->get("rol");
        return $consulta->result();
    }

    function get_tbl_usuario() {
        $consulta = $this->db->get("vusuario");
        return $consulta->result();
    }

    function insert_usu($data) {
        $this->db->insert('usuario', $data);
    }

    function update_usu($id, $data) {
        $this->db->where('codi_usu', $id);
        $this->db->update('usuario', $data);
    }

}
