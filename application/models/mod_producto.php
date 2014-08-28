<?php

class mod_producto extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

}
