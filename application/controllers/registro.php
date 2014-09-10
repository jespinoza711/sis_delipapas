<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class registro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view'));
        $this->load->library('session');
    }

    public function registro_diario() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Control di&aacute;rio de personal';
            $data['container'] = $this->load->view('empleado/controldiario_view', null, true);
            $this->load->view('home/body', $data);
        }
    }

}
