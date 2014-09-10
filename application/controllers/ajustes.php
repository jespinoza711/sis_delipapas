<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ajustes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Panel de configuraci&oacute;n';
            $data['container'] = $this->load->view('caja/cajachica_view', null, true);
            $this->load->view('home/body', $data);
        }
    }

    public function registrar_concepto() {
        
    }

    public function registrar_pago_hora_empleado() {
        
    }

    public function registrar_igv() {
        
    }

}
