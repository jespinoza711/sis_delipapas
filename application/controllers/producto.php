<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class producto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_view'));
        $this->load->library('session');
    }

    public function index() {
        $data['page'] = 'Productos';
        $data['container'] = $this->load->view('producto/producto_view', null, true);
        $this->load->view('home/body', $data);
    }

    public function producto() {
        
    }

    public function inventario() {
        $data['page'] = 'Inventario';
        $d['producto'] = $this->mod_view->view('vproducto', false, false, false);
        $data['container'] = $this->load->view('producto/inventario_view', $d, true);
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
