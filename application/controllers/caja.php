<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class caja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_view'));
        $this->load->library('session');
    }

    public function venta() {
        $data['page'] = 'Ventas';
        $data['container'] = $this->load->view('caja/venta_view', null, true);
        $this->load->view('home/body', $data);
    }

    public function compra() {
        $data['page'] = 'Compras';
        $compra['compra'] = $this->mod_view->view('compra', false, false, false);
        $compra['producto'] = $this->mod_view->view('vproducto', false, false, false);
        $data['container'] = $this->load->view('caja/compra_view', $compra, true);
        $this->load->view('home/body', $data);
    }

    public function abrir_caja() {
        
    }

    public function cerrar_caja() {
        
    }

    public function registrar_compra() {
        
    }

    public function registrar_venta() {
        
    }

    public function caja_chica() {
        $data['page'] = 'Caja chica';
        $data['container'] = $this->load->view('caja/cajachica_view', null, true);
        $this->load->view('home/body', $data);
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
