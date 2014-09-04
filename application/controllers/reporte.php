<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_view'));
        $this->load->library('session');
    }

    public function index() {
        $data['page'] = 'Reportes';
        $data['container'] = $this->load->view('reporte/reporte_view', null, true);
        $this->load->view('home/body', $data);
    }

    public function logged() {
        return $this->session->userdata('logged');
    }

    public function admin() {
        if ($this->session->userdata('codi_rol') == '1') {
            return true;
        } else {
            return false;
        }
    }

}