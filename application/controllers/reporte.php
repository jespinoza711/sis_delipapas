<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_caja', 'mod_empleado', 'mod_registro'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Reportes';
            $data['container'] = $this->load->view('reporte/reporte_view', null, true);
            $this->load->view('home/body', $data);
        }
    }

    public function compra() {
        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_1');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');

        $this->fpdf->SetFont('Times', 'B', 12);
        if ($tipo == "0") {
            $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');
            $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - ' . $mes[substr($this->session->userdata('input_reporte_1'), 5)] . ' ' . substr($this->session->userdata('input_reporte_1'), 0, 4)), 0, 0, 'C');
        } else if ($tipo == "1") {
            $dates = str_replace('/', '-', $this->session->userdata('input_reporte_1'));
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($this->session->userdata('input_reporte_1'), 0, 10) == substr($this->session->userdata('input_reporte_1'), 13)) {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE COMPRA - ' . $fecha_a), 0, 0, 'C');
            } else {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE COMPRA - DE ' . substr($this->session->userdata('input_reporte_1'), 0, 10) . ' AL ' . substr($this->session->userdata('input_reporte_1'), 13)), 0, 0, 'C');
            }
        }


        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(40, 10, utf8_decode("Fecha"), 1, 0, 'C');
        $this->fpdf->Cell(60, 10, utf8_decode("Usuario"), 1, 0, 'C');
        $this->fpdf->Cell(45, 10, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Total de compra"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 11);

        if ($tipo == "0") {

            $compras = $this->mod_view->view('v_compra');

            foreach ($compras as $row) {

                $fech_reg = substr($row->fech_com, 0, 7);

                if ($this->session->userdata('input_reporte_1') == $fech_reg) {
                    $time = strtotime($row->fech_com);
                    $fecha = date("d/m/Y g:i A", $time);
                    $this->fpdf->Cell(40, 8, utf8_decode($fecha), 1, 0, 'C');
                    $this->fpdf->Cell(60, 8, utf8_decode("  " . $row->nomb_usu), 1, 0, 'L');
                    $this->fpdf->Cell(45, 8, utf8_decode($row->num_com), 1, 0, 'C');
                    $this->fpdf->Cell(40, 8, utf8_decode('S/. ' . $row->tota_com . "  "), 1, 0, 'R');

                    $this->fpdf->Ln(8);
                }
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_1'), 0, 10) == substr($this->session->userdata('input_reporte_1'), 13)) {
                $compras = $this->mod_caja->get_compras_interval("DATE(fech_com) = '$fecha_a'");
            } else {
                $compras = $this->mod_caja->get_compras_interval("fech_com BETWEEN '$fecha_a'  AND '$fecha_b'");
            }

            foreach ($compras as $row) {
                $time = strtotime($row->fech_com);
                $fecha = date("d/m/Y g:i A", $time);
                $this->fpdf->Cell(40, 8, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(60, 8, utf8_decode("  " . $row->nomb_usu), 1, 0, 'L');
                $this->fpdf->Cell(45, 8, utf8_decode($row->num_com), 1, 0, 'C');
                $this->fpdf->Cell(40, 8, utf8_decode('S/. ' . $row->tota_com . "  "), 1, 0, 'R');

                $this->fpdf->Ln(8);
            }
        }

        $this->fpdf->Output();
    }

    public function venta() {
        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_2');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        if ($tipo == "0") {
            $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');
            $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - ' . $mes[substr($this->session->userdata('input_reporte_2'), 5)] . ' ' . substr($this->session->userdata('input_reporte_2'), 0, 4)), 0, 0, 'C');
        } else if ($tipo == "1") {
            $dates = str_replace('/', '-', $this->session->userdata('input_reporte_2'));
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($this->session->userdata('input_reporte_2'), 0, 10) == substr($this->session->userdata('input_reporte_2'), 13)) {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - ' . $fecha_a), 0, 0, 'C');
            } else {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - DE ' . substr($this->session->userdata('input_reporte_2'), 0, 10) . ' AL ' . substr($this->session->userdata('input_reporte_2'), 13)), 0, 0, 'C');
            }
        }

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(35, 10, utf8_decode("Fecha"), 1, 0, 'C');
        $this->fpdf->Cell(45, 10, utf8_decode("Empresa"), 1, 0, 'C');
        $this->fpdf->Cell(18, 10, utf8_decode("N° Caja"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Usuario vendedor"), 1, 0, 'C');
        $this->fpdf->Cell(28, 10, utf8_decode("Com."), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Total de venta"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        if ($tipo == "0") {

            $ventas = $this->mod_view->view('v_venta');

            foreach ($ventas as $row) {

                $fech_reg = substr($row->fech_ven, 0, 7);

                if ($this->session->userdata('input_reporte_2') == $fech_reg) {
                    $time = strtotime($row->fech_ven);
                    $fecha = date("d/m/Y g:i A", $time);
                    $this->fpdf->Cell(35, 8, utf8_decode($fecha), 1, 0, 'C');
                    $this->fpdf->Cell(45, 8, utf8_decode($row->empr_cli), 1, 0, 'L');
                    $this->fpdf->Cell(18, 8, utf8_decode($row->num_caj), 1, 0, 'C');
                    $this->fpdf->Cell(35, 8, utf8_decode($row->nomb_usu), 1, 0, 'C');
                    $this->fpdf->Cell(28, 8, utf8_decode($row->nomb_com), 1, 0, 'C');
                    $this->fpdf->Cell(30, 8, utf8_decode('S/. ' . $row->tota_ven), 1, 0, 'R');

                    $this->fpdf->Ln(8);
                }
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_2'), 0, 10) == substr($this->session->userdata('input_reporte_2'), 13)) {
                $ventas = $this->mod_caja->get_ventas_interval("DATE(fech_ven) = '$fecha_a'");
            } else {
                $ventas = $this->mod_caja->get_ventas_interval("fech_ven BETWEEN '$fecha_a'  AND '$fecha_b'");
            }

            foreach ($ventas as $row) {
                $time = strtotime($row->fech_ven);
                $fecha = date("d/m/Y g:i A", $time);
                $this->fpdf->Cell(35, 8, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(45, 8, utf8_decode($row->apel_cli . ', ' . $row->nomb_cli), 1, 0, 'L');
                $this->fpdf->Cell(18, 8, utf8_decode($row->num_caj), 1, 0, 'C');
                $this->fpdf->Cell(35, 8, utf8_decode($row->nomb_usu), 1, 0, 'C');
                $this->fpdf->Cell(28, 8, utf8_decode($row->nomb_com), 1, 0, 'C');
                $this->fpdf->Cell(30, 8, utf8_decode('S/. ' . $row->tota_ven), 1, 0, 'R');

                $this->fpdf->Ln(8);
            }
        }

        $this->fpdf->Output();
    }

    public function inventario() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE INVENTARIO'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(55, 10, utf8_decode("Producto"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Fecha de ingreso"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Fecha de salida"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Precio unitario"), 1, 0, 'C');
        $this->fpdf->Cell(18, 10, utf8_decode("Stock"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 11);

        $productos = $this->mod_view->view('producto', 0, false, array('stoc_prod >' => '0'));

        foreach ($productos as $row) {

            $time_in = strtotime($row->fein_prod);
            $time_sa = strtotime($row->fesa_prod);
            $fecha_in = date("d/m/Y g:i A", $time_in);

            if ($row->fesa_prod == "") {
                $fecha_sa = "-";
            } else {
                $fecha_sa = date("d/m/Y g:i A", $time_sa);
            }

            $this->fpdf->Cell(55, 8, utf8_decode('  ' . $row->nomb_prod), 1, 0, 'L');
            $this->fpdf->Cell(40, 8, utf8_decode($fecha_in), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($fecha_sa), 1, 0, 'C');
            $this->fpdf->Cell(35, 8, utf8_decode('S/. ' . $row->prec_prod), 1, 0, 'C');
            $this->fpdf->Cell(18, 8, utf8_decode($row->stoc_prod), 1, 0, 'C');

            $this->fpdf->Ln(8);
        }

        $this->fpdf->Output();
    }

    public function cliente() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE CLIENTES'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(60, 10, utf8_decode("Empresa"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Teléfono"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("R.U.C."), 1, 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Dirección"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        $clientes = $this->mod_view->view('cliente', 0, false, array('esta_cli' => 'A'));

        foreach ($clientes as $row) {

            $this->fpdf->Cell(60, 8, utf8_decode('  ' . $row->empr_cli), 1, 0, 'L');
            $this->fpdf->Cell(40, 8, utf8_decode($row->telf_cli), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($row->ruc_cli), 1, 0, 'C');
            $this->fpdf->Cell(50, 8, utf8_decode($row->dire_cli), 1, 0, 'C');

            $this->fpdf->Ln(8);
        }

        $this->fpdf->Output();
    }

    public function proveedor() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE PROVEEDORES'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(50, 10, utf8_decode("Proveedor"), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("R.U.C."), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Teléfono"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("E-mail"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Dirección"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        $proveedores = $this->mod_view->view('proveedor', 0, false, array('esta_pro' => 'A'));

        foreach ($proveedores as $row) {

            if ($row->emai_pro != "") {
                $email = $row->emai_pro;
            } else {
                $email = "-";
            }

            $this->fpdf->Cell(50, 8, utf8_decode('  ' . $row->nomb_pro), 1, 0, 'L');
            $this->fpdf->Cell(30, 8, utf8_decode($row->ruc_pro), 1, 0, 'C');
            $this->fpdf->Cell(30, 8, utf8_decode($row->telf_pro), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($email), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($row->dire_pro), 1, 0, 'C');

            $this->fpdf->Ln(8);
        }

        $this->fpdf->Output();
    }

    public function usuario() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE USUARIOS'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(70, 10, utf8_decode("Nombre de usuario"), 1, 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Rol"), 1, 0, 'C');
        $this->fpdf->Cell(60, 10, utf8_decode("Última sesión"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 12);

        $usuarios = $this->mod_view->view('v_usuario', 0, false, array('esta_usu' => 'A'));

        foreach ($usuarios as $row) {

            $time = strtotime($row->ses_usu);
            $fecha = date("d/m/Y g:i:s A", $time);

            $this->fpdf->Cell(70, 8, utf8_decode('   ' . $row->nomb_usu), 1, 0, 'L');
            $this->fpdf->Cell(50, 8, utf8_decode($row->nomb_rol), 1, 0, 'C');
            $this->fpdf->Cell(60, 8, utf8_decode($fecha), 1, 0, 'C');

            $this->fpdf->Ln(8);
        }

        $this->fpdf->Output();
    }

    public function empleado() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE EMPLEADOS'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(25, 10, utf8_decode("D.N.I."), 1, 0, 'C');
        $this->fpdf->Cell(75, 10, utf8_decode("Nombres y apellidos"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Rol"), 1, 0, 'C');
        $this->fpdf->Cell(25, 10, utf8_decode("Teléfono"), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Sueldo"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        $empleados = $this->mod_empleado->get_vempleado(array('empleado.esta_emp' => 'A'));

        foreach ($empleados as $row) {

            $this->fpdf->Cell(25, 8, utf8_decode($row->dni_emp), 1, 0, 'C');
            $this->fpdf->Cell(75, 8, utf8_decode('   ' . $row->apel_emp . ', ' . $row->nomb_emp), 1, 0, 'L');
            $this->fpdf->Cell(35, 8, utf8_decode($row->nomb_tem), 1, 0, 'C');
            $this->fpdf->Cell(25, 8, utf8_decode($row->telf_emp), 1, 0, 'C');
            $this->fpdf->Cell(30, 8, utf8_decode('S/. ' . $row->suel_pla), 1, 0, 'C');

            $this->fpdf->Ln(8);
        }

        $this->fpdf->Output();
    }

    public function caja() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_8');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        if ($tipo == "0") {
            $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE CAJA DIARIO'), 0, 0, 'C');
        } else if ($tipo == "1") {
            $dates = str_replace('/', '-', $this->session->userdata('input_reporte_8'));
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($this->session->userdata('input_reporte_8'), 0, 10) == substr($this->session->userdata('input_reporte_8'), 13)) {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE CAJA DIARIO - ' . $fecha_a), 0, 0, 'C');
            } else {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE CAJA DIARIO - DE ' . substr($this->session->userdata('input_reporte_8'), 0, 10) . ' AL ' . substr($this->session->userdata('input_reporte_8'), 13)), 0, 0, 'C');
            }
        }

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(10, 7, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA A."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO A."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO I."), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA C."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO C."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO F."), 1, 0, 'C');

        $this->fpdf->Ln(7);

        $this->fpdf->SetFont('Times', '', 9);

        if ($tipo == "0") {

            $caja_dia = $this->mod_view->view('v_caja_dia', 0, false, array('esta_cad' => 'C'));

            foreach ($caja_dia as $row) {
                $time_a = strtotime($row->fein_cad);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_cad);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(10, 7, utf8_decode($row->num_caj), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_cad), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->safi_cad), 1, 0, 'R');

                $this->fpdf->Ln(7);
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_8'), 0, 10) == substr($this->session->userdata('input_reporte_8'), 13)) {
                $caja_dia = $this->mod_caja->get_caja_interval("DATE(fein_cad) = '$fecha_a' OR DATE(fefi_cad) = '$fecha_a' AND esta_cad = 'C'");
            } else {
                $caja_dia = $this->mod_caja->get_caja_interval("fein_cad BETWEEN '$fecha_a'  AND '$fecha_b' OR fefi_cad BETWEEN '$fecha_a'  AND '$fecha_b' AND esta_cad = 'C'");
            }

            foreach ($caja_dia as $row) {
                $time_a = strtotime($row->fein_cad);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_cad);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(10, 7, utf8_decode($row->num_caj), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_cad), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->safi_cad), 1, 0, 'R');

                $this->fpdf->Ln(7);
            }
        }

        $this->fpdf->Output();
    }

    public function caja_chica() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_9');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        if ($tipo == "0") {
            $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE CAJA CHICA DIARIO'), 0, 0, 'C');
        } else if ($tipo == "1") {
            $dates = str_replace('/', '-', $this->session->userdata('input_reporte_9'));
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($this->session->userdata('input_reporte_9'), 0, 10) == substr($this->session->userdata('input_reporte_9'), 13)) {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE CAJA CHICA DIARIO - ' . $fecha_a), 0, 0, 'C');
            } else {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE CAJA CHICA DIARIO - DE ' . substr($this->session->userdata('input_reporte_9'), 0, 10) . ' AL ' . substr($this->session->userdata('input_reporte_9'), 13)), 0, 0, 'C');
            }
        }

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(10, 7, utf8_decode("CO"), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA A."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO A."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO I."), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA C."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO C."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO U."), 1, 0, 'C');

        $this->fpdf->Ln(7);

        $this->fpdf->SetFont('Times', '', 9);

        if ($tipo == "0") {

            $caja_chica_dia = $this->mod_view->view('v_caja_chica_dia', 0, false, array('esta_ccd' => 'C'));

            foreach ($caja_chica_dia as $row) {
                $time_a = strtotime($row->fein_ccd);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_ccd);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(10, 7, utf8_decode($row->codi_cac), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_ccd), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->dife_ccd), 1, 0, 'R');

                $this->fpdf->Ln(7);
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_9'), 0, 10) == substr($this->session->userdata('input_reporte_9'), 13)) {
                $caja_chica_dia = $this->mod_caja->get_caja_chica_interval("DATE(fein_ccd) = '$fecha_a' OR DATE(fefi_ccd) = '$fecha_a' AND esta_ccd = 'C'");
            } else {
                $caja_chica_dia = $this->mod_caja->get_caja_chica_interval("fein_ccd BETWEEN '$fecha_a'  AND '$fecha_b' OR fefi_ccd BETWEEN '$fecha_a'  AND '$fecha_b' AND esta_ccd = 'C'");
            }

            foreach ($caja_chica_dia as $row) {
                $time_a = strtotime($row->fein_cad);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_cad);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(10, 7, utf8_decode($row->codi_cac), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_ccd), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->dife_ccd), 1, 0, 'R');

                $this->fpdf->Ln(7);
            }
        }

        $this->fpdf->Output();
    }

    public function registro() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_10');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        if ($tipo == "0") {
            $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE REGISTRO DIARIO'), 0, 0, 'C');
        } else if ($tipo == "1") {
            $dates = str_replace('/', '-', $this->session->userdata('input_reporte_10'));
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($this->session->userdata('input_reporte_10'), 0, 10) == substr($this->session->userdata('input_reporte_10'), 13)) {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE REGISTRO DIARIO - ' . $fecha_a), 0, 0, 'C');
            } else {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE REGISTRO DIARIO - DE ' . substr($this->session->userdata('input_reporte_10'), 0, 10) . ' AL ' . substr($this->session->userdata('input_reporte_10'), 13)), 0, 0, 'C');
            }
        }

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(35, 7, utf8_decode("FECHA"), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO"), 1, 0, 'C');
        $this->fpdf->Cell(65, 7, utf8_decode("EMPLEADO"), 1, 0, 'C');
        $this->fpdf->Cell(30, 7, utf8_decode("P.P."), 1, 0, 'C');
        $this->fpdf->Cell(35, 7, utf8_decode("TOTAL"), 1, 0, 'C');

        $this->fpdf->Ln(7);

        $this->fpdf->SetFont('Times', '', 9);

        if ($tipo == "0") {

            $registro = $this->mod_view->view('v_registro_planilla', 0, false, array());

            foreach ($registro as $row) {
                $time = strtotime($row->fech_dpl);
                $fecha = date("d/m/Y g:i A", $time);

                $this->fpdf->Cell(35, 7, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->nomb_usu), 1, 0, 'C');
                $this->fpdf->Cell(65, 7, utf8_decode(' ' . $row->apel_emp . ', ' . $row->nomb_emp), 1, 0, 'L');
                $this->fpdf->Cell(30, 7, utf8_decode($row->cant_dpl . ' Kls'), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode('S/. ' . $row->tota_dpl . ' '), 1, 0, 'R');

                $this->fpdf->Ln(7);
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_10'), 0, 10) == substr($this->session->userdata('input_reporte_10'), 13)) {
                $registro = $this->mod_registro->get_registro_interval("DATE(fech_dpl) = '$fecha_a'");
            } else {
                $registro = $this->mod_registro->get_registro_interval("fech_dpl BETWEEN '$fecha_a'  AND '$fecha_b'");
            }

            foreach ($registro as $row) {
                $time = strtotime($row->fech_dpl);
                $fecha = date("d/m/Y g:i A", $time);

                $this->fpdf->Cell(35, 7, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->nomb_usu), 1, 0, 'C');
                $this->fpdf->Cell(65, 7, utf8_decode('  ' . $row->apel_emp . ', ' . $row->nomb_emp), 1, 0, 'L');
                $this->fpdf->Cell(30, 7, utf8_decode($row->cant_dpl . ' Kls'), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode('S/. ' . $row->tota_dpl . '  '), 1, 0, 'R');

                $this->fpdf->Ln(7);
            }
        }

        $this->fpdf->Output();
    }

    public function input_1() {
        $fecha = $this->input->post('month');
        $tipo = $this->input->post('type');
        $this->session->set_userdata('input_reporte_1', $fecha);
        $this->session->set_userdata('type_1', $tipo);
    }

    public function input_2() {
        $fecha = $this->input->post('month_2');
        $tipo = $this->input->post('type_2');
        $this->session->set_userdata('input_reporte_2', $fecha);
        $this->session->set_userdata('type_2', $tipo);
    }

    public function input_8() {
        $fecha = $this->input->post('month_8');
        $tipo = $this->input->post('type_8');
        $this->session->set_userdata('input_reporte_8', $fecha);
        $this->session->set_userdata('type_8', $tipo);
    }

    public function input_9() {
        $fecha = $this->input->post('month_9');
        $tipo = $this->input->post('type_9');
        $this->session->set_userdata('input_reporte_9', $fecha);
        $this->session->set_userdata('type_9', $tipo);
    }

    public function input_10() {
        $fecha = $this->input->post('month_10');
        $tipo = $this->input->post('type_10');
        $this->session->set_userdata('input_reporte_10', $fecha);
        $this->session->set_userdata('type_10', $tipo);
    }

    public function reg_venta() {

        $codi_fac = $this->session->userdata('reg_ventas');

        $registros = $this->mod_view->view('v_factura', 0, false, array('codi_fac' => $codi_fac));
        $negocio = $this->mod_view->view('negocio');

        $this->load->library('fpdf');

        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->SetMargins(0, 0, 0);
        $this->fpdf->SetFillColor('203', '251', '207');
        $this->fpdf->SetDrawColor("6", "44", "132");
        $this->fpdf->AddPage('P', array('97.8958', '160.0729'));
        $this->fpdf->Rect(0, 0, 97.8958, 160.0729, 'F');
//        $this->fpdf->Cell('97.8958', '160.0729', "", 0, 0, 'L', true);

        $this->fpdf->SetTextColor("6", "44", "132");

        $this->fpdf->SetFont('Helvetica', 'B', 28);

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Cell('52.91', '11.9', "Delipapas", 0, 0, 'C');

        $this->fpdf->SetFont('Helvetica', 'B', 13);
        $this->fpdf->SetLeftMargin(58.7375);
        $this->fpdf->Cell('35.98', '6', "ORDEN DE", 0, 0, 'C');
        $this->fpdf->Ln();
        $this->fpdf->Cell('35.98', '6', "DESPACHO", 0, 0, 'C');

        $telefono = "";
        if ($negocio[0]->tel1_neg != "") {
            $telefono = $negocio[0]->tel1_neg;
        }
        if ($negocio[0]->tel2_neg != "") {
            if ($telefono == "") {
                $telefono = $negocio[0]->tel2_neg;
            } else {
                $telefono = $telefono . '/' . $negocio[0]->tel2_neg;
            }
        }

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('52.91', '4', utf8_decode("Telf.: " . $telefono), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(58.7375);
        $this->fpdf->SetFont('Courier', 'B', 15);
        $this->fpdf->SetTextColor("156", "87", "79");
        $this->fpdf->Cell('35.98', '8', utf8_decode("N° " . $registros[0]->desp_fac), 1, 0, 'C');

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln(4);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', 'I', 11);
        $this->fpdf->Cell('52.91', '4', utf8_decode(strtoupper($negocio[0]->desc_neg . ": ")), 0, 0, 'C');

        $this->fpdf->Ln(4);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', 'I', 9);
        $this->fpdf->Cell('52.91', '4', utf8_decode("Peladas - Picadas - Peladas en Bolo"), 0, 0, 'C');

        $this->fpdf->Ln(4);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('89', '7', utf8_decode(" Señor: " . $registros[0]->apel_cli . ', ' . $registros[0]->nomb_cli), 1, 0, 'L');

        $this->fpdf->Ln(8.5);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('89', '7', utf8_decode(" Dirección: " . $registros[0]->dire_cli), 1, 0, 'L');

        $this->fpdf->Ln(8.5);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('45', '7', utf8_decode(" R.U.C.: " . $registros[0]->ruc_cli), 1, 0, 'L');
        $this->fpdf->Cell('3', '7', utf8_decode(""));

        $time = strtotime($registros[0]->fech_fac);
        $fecha = date("d/m/Y", $time);
        $this->fpdf->Cell('41', '7', utf8_decode(" Fecha: " . $fecha), 1, 0, 'L');

        $this->fpdf->Ln(7);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', 'I', 9);
        $this->fpdf->Cell('89', '4', utf8_decode("Remitimos a Ud. en buenas condiciones lo siguiente:"), 0, 0, 'C');

        $this->fpdf->Ln(4);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', 'B', 9);
        $this->fpdf->Cell('12', '7', utf8_decode("CANT."), 1, 0, 'C');
        $this->fpdf->Cell('10', '7', utf8_decode("UND."), 1, 0, 'C');
        $this->fpdf->Cell('40', '7', utf8_decode("D E S C R I P C I O N"), 1, 0, 'C');
        $this->fpdf->Cell('11', '7', utf8_decode("P.U."), 1, 0, 'C');
        $this->fpdf->Cell('16', '7', utf8_decode("TOTAL"), 1, 0, 'C');

        foreach ($registros as $row) {
            $this->fpdf->Ln(7);
            $this->fpdf->SetTextColor("6", "44", "132");
            $this->fpdf->SetFont('Courier', '', 9);
            $this->fpdf->Cell('12', '7', utf8_decode($row->cantidad), 1, 0, 'C');
            $this->fpdf->Cell('10', '7', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('40', '7', utf8_decode($row->nomb_prod), 1, 0, 'L');
            $this->fpdf->Cell('11', '7', utf8_decode($row->prec_prod), 1, 0, 'C');
            $this->fpdf->Cell('16', '7', utf8_decode($row->impo_dve), 1, 0, 'C');
        }

        for ($i = 0; $i < (8 - count($registros)); $i++) {
            
            $this->fpdf->Ln(7);
            $this->fpdf->SetTextColor("6", "44", "132");
            $this->fpdf->SetFont('Courier', '', 9);
            $this->fpdf->Cell('12', '7', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('10', '7', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('40', '7', utf8_decode(""), 1, 0, 'L');
            $this->fpdf->Cell('11', '7', utf8_decode(""), 1, 0, 'C');
            if (($i+1) == (8-count($registros))) {
                $this->fpdf->SetFont('Courier', 'B', 9);
                $this->fpdf->Cell('16', '7', utf8_decode($registros[0]->tota_ven), 1, 0, 'C');
            } else {
                $this->fpdf->Cell('16', '7', utf8_decode(""), 1, 0, 'C');
            }            
        }

        $this->fpdf->Ln(8.5);
        $this->fpdf->SetTextColor("6", "44", "132");
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('31', '7', utf8_decode(" Despachado por: "), 0, 0, 'L');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('32', '7', utf8_decode(" Transportado por: "), 0, 0, 'L');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('23', '5', utf8_decode("Cantidad de"), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(70);
        $this->fpdf->Ln(4);
        $this->fpdf->Cell('23', '4', utf8_decode("Bolsas:"), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln(13);
        $this->fpdf->Cell('64', '7', utf8_decode("R E C I B I  C O N F O R M E"), 0, 0, 'C');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('23.5', '7', utf8_decode("Peso total"), 0, 0, 'C');

        $this->fpdf->Ln(13);
        $this->fpdf->Cell('64', '7', utf8_decode("Nombre y apellido      Firma y sello"), 0, 0, 'C');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('23.5', '7', utf8_decode("Kilos  "), 0, 0, 'R');

        $this->fpdf->Rect(58.7, 0, 36, 19.9, 'D');
        $this->fpdf->Rect(4, 116.5, 31, 15, 'D');
        $this->fpdf->Rect(36.5, 116.5, 32, 15, 'D');
        $this->fpdf->Rect(70, 116.5, 23, 15, 'D');
        $this->fpdf->Rect(4, 133.5, 64, 20, 'D');
        $this->fpdf->Rect(69.5, 133.5, 23.5, 20, 'D');

        $this->fpdf->Output();
    }

}
