<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Reportes';
            $data['container'] = $this->load->view('reporte/reporte_view', null, true);
            $this->load->view('home/body', $data);
        }
    }

}
