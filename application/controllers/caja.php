<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class caja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_caja', 'mod_producto'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            if ($this->input->post('registrar')) {
                $data['num_caj'] = $this->input->post('num_caj');
                $data['obsv_caj'] = $this->input->post('obsv_caj');
                $data['fech_caj'] = date('Y-m-d H:i:s');
                $data['esta_caj'] = 'A';
                $this->mod_caja->insert($data);
                $this->session->set_userdata('info', 'La caja de número ' . $data['num_caj'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('caja'));
            } else if ($this->input->post('editar')) {
                $codi_caj = $this->input->post('codi_caj_e');
                $data['num_caj'] = $this->input->post('num_caj');
                $data['obsv_caj'] = $this->input->post('obsv_caj');

                $this->mod_caja->update($codi_caj, $data);
                $this->session->set_userdata('info', 'La caja de número ' . $data['num_caj'] . ' ha sido actualizado existosamente.');

                header('Location: ' . base_url('caja'));
            } else if ($this->input->post('activar')) {
                $codi_caj = $this->input->post('codigo');
                $num_caja = $this->input->post('numero');
                
                $this->mod_caja->update($codi_caj, array('esta_caj' => 'A'));
                $this->session->set_userdata('info', 'La caja de número ' . $num_caja . ' ha sido habilitado existosamente.');

                header('Location: ' . base_url('caja'));
            } else if ($this->input->post('desactivar')) {
                $codi_caj = $this->input->post('codigo');
                $num_caja = $this->input->post('numero');
                
                $this->mod_caja->update($codi_caj, array('esta_caj' => 'D'));
                $this->session->set_userdata('info', 'La caja de número ' . $num_caja . ' ha sido deshabilitado existosamente.');

                header('Location: ' . base_url('caja'));
            } else {

                $caja["form_caj"] = array('role' => 'form', "id" => "form_caj");
                $caja["num_caj"] = array('id' => 'num_caj', 'name' => 'num_caj', 'class' => "form-control input-lg", "min" => "1", 'required' => 'true', 'autocomplete' => 'off', 'value' => "1", "type" => "number");
                $caja["obsv_caja"] = array('id' => 'obsv_caj', 'name' => 'obsv_caj', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "100", "rows" => "5", "autocomplete" => "off");
                $caja["registrar"] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");

                // EDITAR
                $caja["form_caj_edit"] = array('role' => 'form', "id" => "form_caj_edit");
                $caja["codi_caj_e"] = array('id' => 'codi_caj_e', 'name' => 'codi_caj_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $caja["num_caj_e"] = array('id' => 'num_caj_e', 'name' => 'num_caj', 'class' => "form-control input-lg", "min" => "1", 'required' => 'true', 'autocomplete' => 'off', 'value' => "1", "type" => "number");
                $caja["obsv_caja_e"] = array('id' => 'obsv_caj_e', 'name' => 'obsv_caj', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "100", "rows" => "5", "autocomplete" => "off");
                $caja["editar"] = array('name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");

                $data['page'] = 'Caja';
                $data['container'] = $this->load->view('caja/caja_view', $caja, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function paginate() {

        $nTotal = $this->mod_view->count('caja');

        $cajas = $this->mod_caja->get_caja_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

        $form_a = array('role' => 'form', "style" => "display: inline-block;");

        $aaData = array();

        foreach ($cajas as $row) {


            $estado = "";
            $opciones = '<button type="button" class="tooltip_caj btn btn-default btn-circle editar_caj" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </button>';
            if ($row->esta_caj == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url() . 'caja', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_caj . '">
                                                    <input type="hidden" name="numero" value="' . $row->num_caj . '">
                                                    <input name="activar" type="submit" class="tooltip_caj btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                                    ' . form_close() . '
                                                </span>';
            } else if ($row->esta_caj == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url() . 'caja', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_caj . '">
                                                    <input type="hidden" name="numero" value="' . $row->num_caj . '">
                                                    <input name="desactivar" type="submit" class="tooltip_caj btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                                    ' . form_close() . '
                                                </span>';
            }
            $opciones.="<script>$('.tooltip_caj').tooltip();</script>";

            $time = strtotime($row->fech_caj);
            $fecha = date("d/m/Y g:i A", $time);

            $observa = "-";
            if ($row->obsv_caj != "") {
                $observa = $row->obsv_caj;
            }

            $aaData[] = array(
                $row->codi_caj,
                $row->num_caj,
                $observa,
                $fecha,
                $estado,
                $opciones
            );
        }

        $aa = array(
            'sEcho' => $_POST['sEcho'],
            'iTotalRecords' => $nTotal,
            'iTotalDisplayRecords' => $nTotal,
            'aaData' => $aaData);

        print_r(json_encode($aa));
    }

    public function get_caja() {

        $data = array();
        $cajas = $this->mod_view->view('caja');
        foreach ($cajas as $row) {
            $data[$row->codi_caj] = array(
                $row->codi_caj,
                $row->num_caj,
                $row->obsv_caj,
                $row->fech_caj,
                $row->esta_caj
            );
        }
        echo json_encode($data);
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
                $error[] = "No se ha aperturado por lo menos una caja por el día de hoy " . date("d-m-Y") . '. <br><strong>Haga click <a href="' . base_url('abrircaja') . '">aquí</a> para aperturar una caja</strong>.';
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
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {

            $data['page'] = 'Aperturar caja';
            $caja["datetime"] = $this->datetime_es();
//            $caja["cajas"] =  $this->mod_view->view('caja_dia', false, false, false);

            $data['container'] = $this->load->view('caja/open_caja_view', $caja, true);
            $this->load->view('home/body', $data);
        }
    }

    public function cerrar_caja() {
        
    }

    public function datetime_es() {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL, "es_ES");
        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        return $dias[date('w')] . ", " . date('d') . " de " . $meses[date('n') - 1] . " de " . date('Y') . " y " . date('g:i A');
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

            // ACTUALIZAR STOCK Y FECHA DE SALIDA DE PRODUCTO
            $stock_anterior = $this->mod_view->dato('producto', 0, false, array('codi_prod' => $row[0]), 'stoc_prod');
            $stock_actual = (int) $stock_anterior - (int) $row[2];
            $this->mod_view->update('producto', array('codi_prod' => $row[0]), array('stoc_prod' => $stock_actual, 'fesa_prod' => date("Y-m-d H:i:s")));

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

    public function get_vcompras_paginate() {

        $nTotal = $this->mod_view->count('compra', 0, false, array('esta_com' => 'A'));

        $compras = $this->mod_view->view('v_compra');

        $aaData = array();

        foreach ($compras as $row) {

            $fech_reg = substr($row->fech_com, 0, 7);

            if ($this->session->userdata('input_reporte_1') == $fech_reg) {

                $time = strtotime($row->fech_com);
                $fecha = date("d/m/Y g:i A", $time);

                $aaData[] = array(
                    $fecha,
                    $row->nomb_usu,
                    $row->num_com,
                    'S/. ' . $row->tota_com
                );
            }
        }

        $aa = array(
            'sEcho' => $_POST['sEcho'],
            'iTotalRecords' => $nTotal,
            'iTotalDisplayRecords' => $nTotal,
            'aaData' => $aaData);

        print_r(json_encode($aa));
    }

    public function get_v_ventas_paginate() {

        $nTotal = $this->mod_view->count('venta', 0, false, array('esta_ven' => 'A'));

        $ventas = $this->mod_view->view('v_venta');

        $aaData = array();

        foreach ($ventas as $row) {

            $fech_reg = substr($row->fech_ven, 0, 7);

            if ($this->session->userdata('input_reporte_2') == $fech_reg) {

                $time = strtotime($row->fech_ven);
                $fecha = date("d/m/Y g:i A", $time);

                $aaData[] = array(
                    $fecha,
                    $row->apel_cli . ', ' . $row->nomb_cli,
                    $row->num_caj,
                    $row->nomb_usu,
                    $row->nomb_com,
                    'S/. ' . $row->tota_ven
                );
            }
        }

        $aa = array(
            'sEcho' => $_POST['sEcho'],
            'iTotalRecords' => $nTotal,
            'iTotalDisplayRecords' => $nTotal,
            'aaData' => $aaData);

        print_r(json_encode($aa));
    }

}
