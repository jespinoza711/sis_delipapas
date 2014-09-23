<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class caja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_caja', 'mod_producto'));
        $this->load->library('session');
        $this->load->helper('url');
    }

    /* MANTENIMIENTO CAJA */

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
                // VIEW
                $data['page'] = 'Caja';
                $data['container'] = $this->load->view('caja/caja_view', $caja, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    /* VENTA */

    public function venta() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $datetime = $this->mod_config->datetime_es();
            $status = $this->mod_caja->status_caja();
            $date = date("Y-m-d");

            if ($status == 3) {
                $error[] = "La caja de hoy " . $datetime . ' esta cerrada. <br><strong> Para ver el estado de hoy haga click <a href="' . base_url('home') . '"> aquí </a></strong>.';
            } else if ($status == 1) {
                $error[] = "No se ha aperturado por lo menos una caja el día de hoy " . $datetime . '. <br><strong> Haga click <a href="' . base_url('abrircaja') . '"> aquí </a> para aperturar una caja </strong>.';
            } else {
                $error = array();
                $cajas = array();
                $clientes = array();
                $comprobantes = array();

                foreach ($this->mod_caja->get_vcaja($date) as $row) {
                    $cajas[$row->codi_caj] = $row->num_caj;
                }
                foreach ($this->mod_view->view('cliente', 0, false, array('esta_cli' => 'A')) as $row) {
                    $clientes[$row->codi_cli] = $row->apel_cli . ', ' . $row->nomb_cli;
                }
                foreach ($this->mod_view->view('comprobante', 0, false, array('esta_com' => 'A')) as $row) {
                    $comprobantes[$row->codi_com] = $row->nomb_com;
                }

                if (count($clientes) <= 0) {
                    $error[] = 'Debe registrar por lo menos un cliente. <br><strong> Haga click <a href="' . base_url('cliente') . '"> aquí </a> para registrar un cliente</strong>.';
                }

                $venta["form"] = array('role' => 'form', "id" => "form_ven");
                $venta["caja"] = $cajas;
                $venta["cliente"] = $clientes;
                $venta["comprobante"] = $comprobantes;
            }

            if (count($error) > 0) {
                $venta["encabezado"] = "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!";
                $venta["panel"] = 'yellow';
                $venta["cuerpo"] = $error;
                $data['container'] = $this->load->view('error', $venta, true);
            } else {
                $data['container'] = $this->load->view('caja/venta_view', $venta, true);
            }

            $data['page'] = 'Ventas';
            $this->load->view('home/body', $data);
        }
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

    /* COMPRA */

    public function compra() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $datetime = $this->mod_config->datetime_es();
            $status = $this->mod_caja->status_caja();

            if ($status == 3) {
                $error[] = "La caja de hoy " . $datetime . ' esta cerrada. <br><strong> Para ver el estado de hoy haga click <a href="' . base_url('home') . '"> aquí </a></strong>.';
            } else if ($status == 1) {
                $error[] = "No se ha aperturado por lo menos una caja el día de hoy " . $datetime . '. <br><strong> Haga click <a href="' . base_url('abrircaja') . '"> aquí </a> para aperturar una caja </strong>.';
            } else {
                $error = array();
                $compra['form_compra'] = array('role' => 'form', "id" => "form_compra");
                $compra['cantidad'] = array('id' => 'catidad', 'name' => 'catidad', 'class' => "form-control", 'placeholder' => "Cantidad", "maxlength" => "10", 'required' => 'true', 'autocomplete' => 'off');
                $compra['producto'] = $this->mod_view->view('v_producto', false, false, array('esta_prod' => 'A'));
                $compra['proveedor'] = $this->mod_view->view('proveedor', false, false, array('esta_pro' => 'A'));

                if (count($compra['producto']) <= 0) {
                    $error[] = 'Debe registrar por lo menos un producto. <br><strong> Haga click <a href="' . base_url('producto') . '"> aquí </a> para registrar un producto </strong>.';
                }
                if (count($compra['proveedor']) <= 0) {
                    $error[] = 'Debe registrar por lo menos un proveedor. <br><strong> Haga click <a href="' . base_url('proveedor') . '"> aquí </a> para registrar un proveeedor </strong>.';
                }
            }

            if (count($error) > 0) {
                $info["encabezado"] = "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!";
                $info["panel"] = 'yellow';
                $info["cuerpo"] = $error;
                $data['container'] = $this->load->view('error', $info, true);
            } else {
                $data['container'] = $this->load->view('caja/compra_view', $compra, true);
            }

            $data['page'] = 'Compras';
            $this->load->view('home/body', $data);
        }
    }

    public function registrar_compra() {
        
    }

    /* CAJA */

    public function abrir_caja() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $status = $this->mod_caja->status_caja();
            $date = date("Y-m-d");

            if ($status == 2) {
                redirect(base_url('cerrarcaja'), 'refresh');
            } else if ($status == 3) {
                redirect(base_url('home'), 'refresh');
            } else {
                $data['page'] = 'Aperturar caja';
                $caja['datetime'] = $this->mod_config->datetime_es();
                $caja['cajas'] = $this->get_caja_dia_lasttime();

                $caja['form_opencaja'] = array('role' => 'form', "id" => "form_opencaja");
                $caja['sain_cad'] = array('id' => 'sain_cad', 'name' => 'sain_cad', 'class' => "form-control", 'placeholder' => "Saldo inicial", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $caja['obsv_cad'] = array('id' => 'obsv_cad', 'name' => 'obsv_cad', 'class' => "form-control", "maxlength" => "200", "autocomplete" => "off", "rows" => "3");
                $caja['registrar'] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Abrir caja");

                $caja['usuarios'] = $this->mod_view->view('v_usuario', false, false, array('esta_usu' => 'A'));
                $data['container'] = $this->load->view('caja/open_caja_view', $caja, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function open_caja() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $num_caja = $this->input->post('num_caj');
            $data['codi_caj'] = $this->input->post('codi_caj');
            $data['usin_cad'] = $this->input->post('usin_cad');
            $data['sain_cad'] = $this->input->post('sain_cad');
            $data['usfi_cad'] = $this->input->post('usin_cad');
            $data['safi_cad'] = $this->input->post('sain_cad');
            $data['obsv_cad'] = $this->input->post('obsv_cad');
            $data['esta_cad'] = 'A';

            if (!$this->mod_caja->open_caja($data)) {
                $this->session->set_userdata('error', 'No ha sido posible la operaci&oacute;n de apertura de la caja ' . $num_caja . ', verifique la fecha actual.');
            }
            header('Location: ' . base_url('abrircaja'));
        }
    }

    public function cerrar_caja() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $status = $this->mod_caja->status_caja();
            $date = date("Y-m-d");

            if ($status == 1) {
                redirect(base_url('abrircaja'), 'refresh');
            } else if ($status == 3) {
                redirect(base_url('home'), 'refresh');
            } else {
                $data['page'] = 'Cerrar caja';
                $caja['datetime'] = $this->mod_config->datetime_es();
                $caja['cajas'] = $this->get_caja_dia_lasttime();

                $caja['form_closecaja'] = array('role' => 'form', "id" => "form_closecaja");
                $caja['safi_cad'] = array('id' => 'safi_cad', 'name' => 'safi_cad', 'class' => "form-control", 'placeholder' => "Saldo final", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $caja['obsv_cad'] = array('id' => 'obsv_cad', 'name' => 'obsv_cad', 'class' => "form-control", "maxlength" => "200", "autocomplete" => "off", "rows" => "3");
                $caja['registrar'] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Cerar caja");

                $caja['usuarios'] = $this->mod_view->view('v_usuario', false, false, array('esta_usu' => 'A'));
                $data['container'] = $this->load->view('caja/close_caja_view', $caja, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function close_caja() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $codi_cad = $this->input->post('codi_cad');
            $num_caja = $this->input->post('num_caj');
            $data['usfi_cad'] = $this->input->post('usfi_cad');
            $data['safi_cad'] = $this->input->post('safi_cad');
            $data['obsv_cad'] = $this->input->post('obsv_cad');
            $data['esta_cad'] = 'C';

            if (!$this->mod_caja->close_caja($data, $codi_cad)) {
                $this->session->set_userdata('error', 'No ha sido posible la operaci&oacute;n de cierre de la caja ' . $num_caja . ', verifique la fecha actual.');
            }
            header('Location: ' . base_url('cerrarcaja'));
        }
    }

    /* CAJA CHICA */

    public function caja_chica() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $datetime = $this->mod_config->datetime_es();
            $status = $this->mod_caja->status_cajachica();
            $date = date("Y-m-d");

            if ($status == 3) {
                $error[] = "La caja chica de hoy " . $datetime . ' esta cerrada. <br><strong> Para ver el estado de hoy haga click <a href="' . base_url('home') . '"> aquí </a></strong>.';
            } else if ($status == 1) {
                $error[] = "No se ha aperturado la caja chica hoy " . $datetime . '. <br><strong> Haga click <a href="' . base_url('abrircajachica') . '"> aquí </a> para aperturar una la caja chica </strong>.';
            } else {
                $error = array();
                $caja['cajachica'] = $this->mod_view->one('caja_chica', false, false, array('esta_cac' => 'A'));
                $caja['concepto'] = $this->mod_view->view('concepto', false, false, array('esta_con' => 'A'));

                if (count($caja['concepto']) <= 0) {
                    $error[] = 'Debe registrar por lo menos un concepto de gasto. <br><strong> Haga click <a href="' . base_url('concepto') . '"> aquí </a> para registrar un concepto de gasto </strong>.';
                }

                $caja['form_regcajachica'] = array('role' => 'form', "id" => "form_regcajachica");
                $caja['codi_cac'] = array('id' => 'codi_cac', 'name' => 'codi_cac', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $caja['codi_usu'] = array('id' => 'codi_usu', 'name' => 'codi_usu', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $caja['nomb_gas'] = array('id' => 'nomb_gas', 'name' => 'nomb_gas', 'class' => "form-control", 'placeholder' => "Descripción", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $caja['impo_gas'] = array('id' => 'impo_gas', 'name' => 'impo_gas', 'class' => "form-control", 'placeholder' => "Importe", "maxlength" => "10", 'required' => 'true', 'autocomplete' => 'off');
                $caja['obsv_gas'] = array('id' => 'obsv_gas', 'name' => 'obsv_gas', 'class' => "form-control", "maxlength" => "200", "autocomplete" => "off", "rows" => "3");
                $caja['registrar'] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar gasto");
            }

            if (count($error) > 0) {
                $cajachica["encabezado"] = "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!";
                $cajachica["panel"] = 'yellow';
                $cajachica["cuerpo"] = $error;
                $data['container'] = $this->load->view('error', $cajachica, true);
            } else {
                $data['container'] = $this->load->view('caja/cajachica_view', $caja, true);
            }

            $data['page'] = 'Caja chica';
            $this->load->view('home/body', $data);
        }
    }

    public function abrir_caja_chica() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $status = $this->mod_caja->status_cajachica();
            if ($status == 2) {
                redirect(base_url('cerrarcajachica'), 'refresh');
            } else if ($status == 3) {
                redirect(base_url('home'), 'refresh');
            } else {
                $data['page'] = 'Aperturar caja chica';
                $cajachica['datetime'] = $this->mod_config->datetime_es();
                $cajachica['cajas'] = $this->get_cajachica_dia_lasttime();

                $cajachica['form_opencajachica'] = array('role' => 'form', "id" => "form_opencajachica");
                $cajachica['sain_ccd'] = array('id' => 'sain_ccd', 'name' => 'sain_ccd', 'class' => "form-control", 'placeholder' => "Saldo inicial", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $cajachica['obsv_ccd'] = array('id' => 'obsv_ccd', 'name' => 'obsv_ccd', 'class' => "form-control", "maxlength" => "200", "autocomplete" => "off", "rows" => "3");
                $cajachica['registrar'] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Abrir caja chica");

                $cajachica['usuarios'] = $this->mod_view->view('v_usuario', false, false, array('esta_usu' => 'A'));
                $data['container'] = $this->load->view('caja/open_cajachica_view', $cajachica, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function open_caja_chica() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $codi_caja = $this->input->post('codi_cac');
            $data['codi_cac'] = $this->input->post('codi_cac');
            $data['usin_ccd'] = $this->input->post('usin_ccd');
            $data['sain_ccd'] = $this->input->post('sain_ccd');
            $data['usfi_ccd'] = $this->input->post('usin_ccd');
            $data['safi_ccd'] = $this->input->post('sain_ccd');
            $data['obsv_ccd'] = $this->input->post('obsv_ccd');
            $data['esta_ccd'] = 'A';

            if (!$this->mod_caja->open_cajachica($data)) {
                $this->session->set_userdata('error', 'No ha sido posible la operaci&oacute;n de apertura de la caja chica ' . $codi_caja . ', verifique la fecha actual.');
            }
            header('Location: ' . base_url('abrircajachica'));
        }
    }

    public function cerrar_caja_chica() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $status = $this->mod_caja->status_cajachica();
            if ($status == 1) {
                redirect(base_url('abrircajachica'), 'refresh');
            } else if ($status == 3) {
                redirect(base_url('home'), 'refresh');
            } else {
                $data['page'] = 'Cerrar caja chica';
                $cajachica['datetime'] = $this->mod_config->datetime_es();
                $cajachica['cajas'] = $this->get_cajachica_dia_lasttime();

                $cajachica['form_closecajachica'] = array('role' => 'form', "id" => "form_closecajachica");
                $cajachica['safi_ccd'] = array('id' => 'safi_ccd', 'name' => 'safi_ccd', 'class' => "form-control", 'placeholder' => "Saldo final", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $cajachica['obsv_ccd'] = array('id' => 'obsv_ccd', 'name' => 'obsv_ccd', 'class' => "form-control", "maxlength" => "200", "autocomplete" => "off", "rows" => "3");
                $cajachica['registrar'] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Cerrar caja chica");

                $cajachica['usuarios'] = $this->mod_view->view('v_usuario', false, false, array('esta_usu' => 'A'));
                $data['container'] = $this->load->view('caja/close_cajachica_view', $cajachica, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function close_caja_chica() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $codi_ccd = $this->input->post('codi_ccd');
            $sain_ccd = $this->input->post('sain_ccd');
            $data['usfi_ccd'] = $this->input->post('usfi_ccd');
            $data['safi_ccd'] = $this->input->post('safi_ccd');
            $data['dife_ccd'] = $data['safi_ccd'] - $sain_ccd;
            $data['obsv_ccd'] = $this->input->post('obsv_ccd');
            $data['esta_ccd'] = 'C';

            if (!$this->mod_caja->close_cajachica($data, $codi_ccd)) {
                $this->session->set_userdata('error', 'No ha sido posible la operaci&oacute;n de cierre de la caja chica ' . $codi_caja . ', verifique la fecha actual.');
            }
            header('Location: ' . base_url('cerrarcajachica'));
        }
    }

    public function registro_gasto_caja_chica() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['codi_cac'] = $this->input->post('codi_cac');
            $data['codi_usu'] = $this->session->userdata('user_codi');
            $data['codi_con'] = $this->input->post('codi_con');
            $data['nomb_gas'] = $this->input->post('nomb_gas');
            $data['impo_gas'] = $this->input->post('impo_gas');
            $data['obsv_gas'] = $this->input->post('obsv_gas');
            $data['esta_gas'] = 'A';

            if ($this->mod_caja->registro_gasto_cajachica($data)) {
                $this->session->set_userdata('info', 'Se ha registrado el gasto de la caja chica ' . $data['codi_cac'] . ' exitosamente.');
            } else {
                $this->session->set_userdata('error', 'No ha sido posible registrar el gasto de la caja chica ' . $data['codi_cac'] . ', verifique los datos proporcionados.');
            }
            header('Location: ' . base_url('cajachica'));
        }
    }

    /* GET DATA PHP */

    public function get_caja_dia_lasttime() {
        $data_cajas = array();
        $get_cajas = $this->mod_view->view('caja', false, false, array('esta_caj' => 'A'));
        foreach ($get_cajas as $c) {
            $cajas = array();
            $cajas['codi_caj'] = $c->codi_caj;
            $cajas['num_caj'] = $c->num_caj;
            $get_caja_dia = $this->mod_caja->get_vcaja_dia($c->codi_caj);
            foreach ($get_caja_dia as $cd) {
                $cajas['codi_cad'] = $cd->codi_cad;
                $cajas['fein_cad'] = $cd->fein_cad;
                $cajas['sain_cad'] = $cd->sain_cad;
                $cajas['usin_cad'] = $cd->usu_ini;
                $cajas['fefi_cad'] = $cd->fefi_cad;
                $cajas['safi_cad'] = $cd->safi_cad;
                $cajas['usfi_cad'] = $cd->usu_fin;
                $cajas['obsv_cad'] = $cd->obsv_cad;
                $cajas['esta_cad'] = $cd->esta_cad;
                break;
            }
            $data_cajas[] = $cajas;
        }
        return $data_cajas;
    }

    public function get_cajachica_dia_lasttime() {
        $data_cajas = array();
        $get_cajas = $this->mod_view->view('caja_chica', false, false, array('esta_cac' => 'A'));
        foreach ($get_cajas as $c) {
            $cajas = array();
            $cajas['codi_cac'] = $c->codi_cac;
            $get_caja_dia = $this->mod_caja->get_vcajachica_dia($c->codi_cac);
            foreach ($get_caja_dia as $cd) {
                $cajas['codi_ccd'] = $cd->codi_ccd;
                $cajas['fein_ccd'] = $cd->fein_ccd;
                $cajas['sain_ccd'] = $cd->sain_ccd;
                $cajas['usin_ccd'] = $cd->usu_ini;
                $cajas['fefi_ccd'] = $cd->fefi_ccd;
                $cajas['safi_ccd'] = $cd->safi_ccd;
                $cajas['usfi_ccd'] = $cd->usu_fin;
                $cajas['obsv_ccd'] = $cd->obsv_ccd;
                $cajas['esta_ccd'] = $cd->esta_ccd;
                break;
            }
            $data_cajas[] = $cajas;
        }
        return $data_cajas;
    }

    /* GET DATA JSON */

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
            $opciones .= "<script>$('.tooltip_caj').tooltip();</script>";

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

    public function get_producto_autocomplete() {
        $data = array();
        $productos = $this->mod_producto->get_vproducto(array('producto.stoc_prod >' => "0", 'esta_prod' => 'A'));
        foreach ($productos as $row) {
            $data[] = $row->nomb_prod;
        }
        echo json_encode($data);
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
