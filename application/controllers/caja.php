<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class caja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view'));
        $this->load->library('session');
    }

    public function venta() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Ventas';
            $data['container'] = $this->load->view('caja/venta_view', null, true);
            $this->load->view('home/body', $data);
        }
    }

    public function compra() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Compras';
            $compra['compra'] = $this->mod_view->view('compra', false, false, false);
            $compra['producto'] = $this->mod_view->view('v_producto', false, false, false);
            $data['container'] = $this->load->view('caja/compra_view', $compra, true);
            $this->load->view('home/body', $data);
        }
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

        $caja["form_cajachica"] = array('role' => 'form', "id" => "form_cajachica");
        $caja["codi_cac"] = array('id' => 'codi_cac', 'name' => 'codi_cac', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
        $caja["nomb_gas"] = array('id' => 'nomb_gas', 'name' => 'nomb_gas', 'class' => "form-control", 'placeholder' => "Descripción", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
        $caja["impo_gas"] = array('id' => 'impo_gas', 'name' => 'impo_gas', 'class' => "form-control", 'placeholder' => "Importe", "maxlength" => "10", 'required' => 'true', 'autocomplete' => 'off');
        $caja["obsv_gas"] = array('id' => 'obsv_gas', 'name' => 'obsv_gas', 'class' => "form-control", "maxlength" => "200", "autocomplete" => "off", "rows" => "3");
        $caja["registrar"] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");

        $caja['empleado'] = $this->mod_view->view('empleado', false, false, false);
        $caja['concepto'] = $this->mod_view->view('concepto', false, false, false);

        $data['container'] = $this->load->view('caja/cajachica_view', $caja, true);
        $this->load->view('home/body', $data);
    }

    public function get_empleado_autocomplete() {
        $empleado = $this->mod_view->view('empleado', false, false, false);
        $i = 0;
        foreach ($empleado as $row) {
            $autocomplete[$i] = $row->nomb_emp . ' ' . $row->apel_emp;
            $i++;
        }
        echo json_encode($autocomplete);
    }

    public function abrir_caja_chica() {
        
    }

    public function cerrar_caja_chica() {
        
    }

    public function registrar_gasto_caja_chica() {
        
    }

}
