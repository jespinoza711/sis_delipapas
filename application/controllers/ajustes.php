<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ajustes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_view'));
        $this->load->library('session');
    }

    public function index() {
        $data['page'] = 'Panel de configuraci&oacute;n';
        $data['container'] = $this->load->view('caja/cajachica_view', null, true);
        $this->load->view('home/body', $data);
    }

    public function registrar_concepto() {
        
    }

    public function registrar_pago_hora_empleado() {
        
    }

    public function registrar_igv() {
        
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
