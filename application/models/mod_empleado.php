<?php

class mod_empleado extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert($data) {
        $this->db->insert('empleado', $data);
    }
    function insert_tipo($data) {
        $this->db->insert('tipo_empleado', $data);
    }
    function insert_pla($data) {
        $this->db->insert('planilla', $data);
    }
    function planilla_año($año) {
        $this->db->where('YEAR(fech_pla)', $año);
        $query = $this->db->get('planilla');
        return $query->result();
    }
}
