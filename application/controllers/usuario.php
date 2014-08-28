<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array());
        $this->load->library('session');
    }
    
    public function login() {
        
        $this->load->view('usuario/login');
        
    }
    
}