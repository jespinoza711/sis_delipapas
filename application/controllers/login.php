<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array());
        $this->load->library('session');
    }
    
    public function index() {        
        $this->load->view('login/login_view');        
    }
    
}