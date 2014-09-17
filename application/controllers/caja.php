<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class caja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_caja', 'mod_producto'));
        $this->load->library('session');
    }

    public function venta() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {

            $venta["form"] = array('role' => 'form', "id" => "form_ven");
            $error = array();
            date_default_timezone_set('America/Lima');
            $fecha_actual = date("Y-m-d");
            if (!$this->mod_caja->validar_caja_dia($fecha_actual)) {
                $error[] = "No se ha aperturado por lo menos una caja por el día de hoy " . date("d-m-Y") . '. <br><strong>Haga click <a href="' . base_url('#') . '">aquí</a> para aperturar una caja</strong>.';
            }

            $cajas = array();
            $clientes = array();
            $comprobantes = array();
            foreach ($this->mod_caja->get_vcaja($fecha_actual) as $row) {
                $cajas[$row->codi_caj] = $row->num_caj;
            }
            foreach ($this->mod_view->view('cliente', 0, false, array('esta_cli' => 'A')) as $row) {
                $clientes[$row->codi_cli] = $row->apel_cli . ', ' . $row->nomb_cli;
            }
            if (count($clientes) <= 0) {
                $error[] = 'Debe registrar por lo menos un cliente. <br><strong>Haga click <a href="' . base_url('cliente') . '">aquí</a> para registrar un cliente</strong>.';
            }
            foreach ($this->mod_view->view('comprobante', 0, false, array('esta_com' => 'A')) as $row) {
                $comprobantes[$row->codi_com] = $row->nomb_com;
            }
            $venta["caja"] = $cajas;
            $venta["cliente"] = $clientes;
            $venta["comprobante"] = $comprobantes;


            $data['page'] = 'Ventas';

            if (count($error) > 0) {
                $venta["encabezado"] = "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!";
                $venta["panel"] = 'yellow';
                $venta["cuerpo"] = $error;
                $data['container'] = $this->load->view('error', $venta, true);
            } else {
                $data['container'] = $this->load->view('caja/venta_view', $venta, true);
            }

            $this->load->view('home/body', $data);
        }
    }

    public function get_producto_autocomplete() {
        $data = array();
        $productos = $this->mod_producto->get_vproducto(array('producto.stoc_prod >' => "0", 'esta_prod' => 'A'));
        foreach ($productos as $row) {
            $data[] = $row->nomb_prod;
        }
        echo json_encode($data);
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
        $caja = $this->input->post('caja');
        $cliente = $this->input->post('cliente');
        $comprobante = $this->input->post('comprobante');
        $tbl_venta = json_decode($this->input->post('tbl_venta'));
        $total = $this->input->post('total');

        // REGISTRO DE VENTA
        date_default_timezone_set('America/Lima');

        $venta = array(
            'codi_caj' => $caja,
            'codi_com' => $comprobante,
            'codi_usu' => $this->session->userdata('user_codi'),
            'codi_cli' => $cliente,
            'fech_ven' => date("Y-m-d H:i:s"),
            'tota_ven' => $total,
            'esta_ven' => 'A'
        );

        $codi_ven = $this->mod_view->insert('venta', $venta);
        
        // GENERAR NUMERO DE FACTURA
        $cont = $this->mod_view->count('factura') + 1;
        $longitud = strlen($cont);
        $numero = 'F000000000000';
        $num_fac = substr($numero, 0, 13 - $longitud) . $cont;

        // REGISTRO DE FACTURA
        $factura = array(
            'num_fac' => $num_fac,
            'ruc_fac' => "-", // FALTA EL RUC DE LA EMPRESA
            'fech_fac' => date("Y-m-d H:i:s"),
            'esta_fac' => 'A'
        );

        $codi_fac = $this->mod_view->insert('factura', $factura);
        
        foreach ($tbl_venta as $row) {

            // ACTUALIZAR STOCK DE PRODUCTO
            $stock_anterior = $this->mod_view->dato('producto', 0, false, array('codi_prod' => $row[0]), 'stoc_prod');
            $stock_actual = (int) $stock_anterior - (int) $row[2];
            $this->mod_view->update('producto', array('codi_prod' => $row[0]), array('stoc_prod' => $stock_actual));
                        
            // REGISTRO DE DETALLE DE VENTA
            $codi_dve = $this->mod_view->count('detalle_venta') + 1;
            $detalle_venta = array(
                'codi_dve' => $codi_dve,
                'codi_ven' => $codi_ven,
                'codi_prod' => $row[0],
                'cantidad' => $row[2],
                'igv_dve' => $row[5],
                'suto_dve' => $row[4],
                'impo_dve' => $row[6]
            );
            $this->mod_view->insert_only('detalle_venta', $detalle_venta);
            
            // REGISTRO DE DETALLE DE FACTURA
            $detalle_factura = array(
                'codi_fac' => $codi_fac,
                'codi_dve' => $codi_dve
            );
            $this->mod_view->insert_only('detalle_factura', $detalle_factura);
        }
        $this->session->set_userdata('info_ven', 'La venta ha sido registrada con éxito');
        header('location: ' . base_url('venta'));
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
