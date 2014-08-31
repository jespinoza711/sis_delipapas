<?php

class mod_usuario extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
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
        $consulta = $this->db->get("vusuario_rol");
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
