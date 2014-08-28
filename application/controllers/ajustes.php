<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ajustes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array());
        $this->load->library('session');
    }

    public function index() {
        
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
