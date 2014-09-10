<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class producto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view'));
        $this->load->library('session');
    }

    // El index de esta clase es para el mantenimiento de producto
    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Productos';
            $data['container'] = $this->load->view('producto/producto_view', null, true);
            $this->load->view('home/body', $data);
        }
    }

    public function producto() {
        
    }

    public function inventario() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Inventario';
            $d['producto'] = $this->mod_view->view('vproducto', false, false, false);
            $data['container'] = $this->load->view('producto/inventario_view', $d, true);
            $this->load->view('home/body', $data);
        }
    }

}
