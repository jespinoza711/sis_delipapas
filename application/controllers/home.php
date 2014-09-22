<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_caja'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Inicio';            
            $home['datetime'] = $this->mod_config->datetime_es();
            $home['user'] = $this->session->userdata('user_name');
            $home['rol'] = $this->session->userdata('user_nrol');
            $home['status_caja'] = $this->mod_caja->status_caja();
            $home['status_cajachica'] = $this->mod_caja->status_cajachica();            
            $data['container'] = $this->load->view('home/home_view', $home, true);
            $this->load->view('home/body', $data);
        }
    }

}
