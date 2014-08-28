<?php

class mod_proveedor extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

}
