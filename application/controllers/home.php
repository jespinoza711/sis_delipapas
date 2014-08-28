<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        $data['container'] = $this->load->view('home/index', null, true);
        $this->load->view('home/body', $data);
    }

}
