<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class caja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array());
        $this->load->library('session');
    }

    public function index() {
        
    }

    public function abrir_caja() {
        
    }

    public function cerrar_caja() {
        
    }

    public function registrar_compra() {
        
    }

    public function registrar_venta() {
        
    }

    public function abrir_caja_chica() {
        
    }

    public function cerrar_caja_chica() {
        
    }

    public function registrar_gasto_caja_chica() {
        
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
