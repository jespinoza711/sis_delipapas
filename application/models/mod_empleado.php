<?php

class mod_empleado extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert($data) {
        $this->db->insert('empleado', $data);
    }
    
}
