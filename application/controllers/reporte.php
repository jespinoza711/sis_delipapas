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

        $total = 0;
        $dates = str_replace('/', '-', $this->session->userdata('input_reporte_1'));
        $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
        $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

        if ($tipo == "0") {
            $compras = $this->mod_view->view('v_compra');
            foreach ($compras as $row) {
                $fech_reg = substr($row->fech_com, 0, 7);
                if ($this->session->userdata('input_reporte_1') == $fech_reg) {
                    $total += $row->tota_com;
                }
            }
        } else if ($tipo == "1") {
            if (substr($this->session->userdata('input_reporte_1'), 0, 10) == substr($this->session->userdata('input_reporte_1'), 13)) {
                $compras = $this->mod_caja->get_compras_interval("DATE(fech_com) = '$fecha_a'");
            } else {
                $compras = $this->mod_caja->get_compras_interval("fech_com BETWEEN '$fecha_a'  AND '$fecha_b'");
            }
            foreach ($compras as $row) {
                $total += $row->tota_com;
            }
        }

        $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');

        $this->fpdf->SetFont('Times', 'B', 12);
        if ($tipo == "0") {
            $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');
            $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE COMPRA - ' . $mes[substr($this->session->userdata('input_reporte_1'), 5)] . ' ' . substr($this->session->userdata('input_reporte_1'), 0, 4)), 0, 0, 'C');
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_1'), 0, 10) == substr($this->session->userdata('input_reporte_1'), 13)) {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE COMPRA - ' . $fecha_a), 0, 0, 'C');
            } else {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE COMPRA - DE ' . substr($this->session->userdata('input_reporte_1'), 0, 10) . ' AL ' . substr($this->session->userdata('input_reporte_1'), 13)), 0, 0, 'C');
            }
        }


        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(0, 0, utf8_decode('Total de compras del reporte: S/. ' . sprintf('%.02F', $total)), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(20, 10, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Fecha"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Usuario"), 1, 0, 'C');
        $this->fpdf->Cell(45, 10, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Total de compra"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 11);

        if ($tipo == "0") {

            $compras = $this->mod_view->view('v_compra');

            $i = 1;
            foreach ($compras as $row) {

                $fech_reg = substr($row->fech_com, 0, 7);

                if ($this->session->userdata('input_reporte_1') == $fech_reg) {
                    $time = strtotime($row->fech_com);
                    $fecha = date("d/m/Y g:i A", $time);
                    $this->fpdf->Cell(20, 8, utf8_decode($i), 1, 0, 'C');
                    $this->fpdf->Cell(40, 8, utf8_decode($fecha), 1, 0, 'C');
                    $this->fpdf->Cell(40, 8, utf8_decode("  " . $row->nomb_usu), 1, 0, 'L');
                    $this->fpdf->Cell(45, 8, utf8_decode($row->num_com), 1, 0, 'C');
                    $this->fpdf->Cell(40, 8, utf8_decode('S/. ' . $row->tota_com . "  "), 1, 0, 'R');

                    $this->fpdf->Ln(8);
                    $i++;
                }
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_1'), 0, 10) == substr($this->session->userdata('input_reporte_1'), 13)) {
                $compras = $this->mod_caja->get_compras_interval("DATE(fech_com) = '$fecha_a'");
            } else {
                $compras = $this->mod_caja->get_compras_interval("fech_com BETWEEN '$fecha_a'  AND '$fecha_b'");
            }

            $i = 1;
            foreach ($compras as $row) {
                $time = strtotime($row->fech_com);
                $fecha = date("d/m/Y g:i A", $time);
                $this->fpdf->Cell(20, 8, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(40, 8, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(40, 8, utf8_decode("  " . $row->nomb_usu), 1, 0, 'L');
                $this->fpdf->Cell(45, 8, utf8_decode($row->num_com), 1, 0, 'C');
                $this->fpdf->Cell(40, 8, utf8_decode('S/. ' . $row->tota_com . "  "), 1, 0, 'R');

                $this->fpdf->Ln(8);
                $i++;
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
        // Total de ventas
        $total = 0;

        $dates = str_replace('/', '-', $this->session->userdata('input_reporte_2'));
        $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
        $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

        if ($tipo == "0") {
            $ventas = $this->mod_view->view('v_venta');
            foreach ($ventas as $row) {
                $fech_reg = substr($row->fech_ven, 0, 7);
                if ($this->session->userdata('input_reporte_2') == $fech_reg) {
                    $total += $row->tota_ven;
                }
            }
        } else if ($tipo == "1") {
            if (substr($this->session->userdata('input_reporte_2'), 0, 10) == substr($this->session->userdata('input_reporte_2'), 13)) {
                $ventas = $this->mod_caja->get_ventas_interval("DATE(fech_ven) = '$fecha_a'");
            } else {
                $ventas = $this->mod_caja->get_ventas_interval("fech_ven BETWEEN '$fecha_a'  AND '$fecha_b'");
            }
            foreach ($ventas as $row) {
                $total += $row->tota_ven;
            }
        }
        $this->fpdf->SetFont('Times', 'B', 12);
        if ($tipo == "0") {
            $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');
            $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - ' . $mes[substr($this->session->userdata('input_reporte_2'), 5)] . ' ' . substr($this->session->userdata('input_reporte_2'), 0, 4)), 0, 0, 'C');
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_2'), 0, 10) == substr($this->session->userdata('input_reporte_2'), 13)) {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - ' . $fecha_a), 0, 0, 'C');
            } else {
                $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - DE ' . substr($this->session->userdata('input_reporte_2'), 0, 10) . ' AL ' . substr($this->session->userdata('input_reporte_2'), 13)), 0, 0, 'C');
            }
        }

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(0, 0, utf8_decode('Total de ventas del reporte: S/. ' . sprintf('%.02F', $total)), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(18, 10, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Fecha"), 1, 0, 'C');
        $this->fpdf->Cell(45, 10, utf8_decode("Empresa"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Usuario vendedor"), 1, 0, 'C');
        $this->fpdf->Cell(28, 10, utf8_decode("Com."), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Total de venta"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        if ($tipo == "0") {

            $ventas = $this->mod_view->view('v_venta');

            $i = 1;
            foreach ($ventas as $row) {

                $fech_reg = substr($row->fech_ven, 0, 7);

                if ($this->session->userdata('input_reporte_2') == $fech_reg) {
                    $time = strtotime($row->fech_ven);
                    $fecha = date("d/m/Y g:i A", $time);
                    $this->fpdf->Cell(18, 8, utf8_decode($i), 1, 0, 'C');
                    $this->fpdf->Cell(35, 8, utf8_decode($fecha), 1, 0, 'C');
                    $this->fpdf->Cell(45, 8, utf8_decode($row->empr_cli), 1, 0, 'L');
                    $this->fpdf->Cell(35, 8, utf8_decode($row->nomb_usu), 1, 0, 'C');
                    $this->fpdf->Cell(28, 8, utf8_decode($row->nomb_com), 1, 0, 'C');
                    $this->fpdf->Cell(30, 8, utf8_decode('S/. ' . $row->tota_ven), 1, 0, 'R');

                    $this->fpdf->Ln(8);

                    $i++;
                }
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_2'), 0, 10) == substr($this->session->userdata('input_reporte_2'), 13)) {
                $ventas = $this->mod_caja->get_ventas_interval("DATE(fech_ven) = '$fecha_a'");
            } else {
                $ventas = $this->mod_caja->get_ventas_interval("fech_ven BETWEEN '$fecha_a'  AND '$fecha_b'");
            }

            $i = 1;
            foreach ($ventas as $row) {
                $time = strtotime($row->fech_ven);
                $fecha = date("d/m/Y g:i A", $time);
                $this->fpdf->Cell(18, 8, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(35, 8, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(45, 8, utf8_decode($row->apel_cli . ', ' . $row->nomb_cli), 1, 0, 'L');
                $this->fpdf->Cell(35, 8, utf8_decode($row->nomb_usu), 1, 0, 'C');
                $this->fpdf->Cell(28, 8, utf8_decode($row->nomb_com), 1, 0, 'C');
                $this->fpdf->Cell(30, 8, utf8_decode('S/. ' . $row->tota_ven), 1, 0, 'R');

                $this->fpdf->Ln(8);

                $i++;
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

        $total = 0;
        $productos = $this->mod_view->view('producto', 0, false, array('stoc_prod >' => '0'));
        foreach ($productos as $row) {
            $total += sprintf('%.02F', (double) $row->prec_prod * (double) $row->stoc_prod);
        }

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE INVENTARIO'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(0, 0, utf8_decode('Total de valor estimado del reporte: S/. ' . sprintf('%.02F', $total)), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(15, 10, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Producto"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Fecha de ingreso"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Fecha de salida"), 1, 0, 'C');
        $this->fpdf->Cell(25, 10, utf8_decode("P.U."), 1, 0, 'C');
        $this->fpdf->Cell(15, 10, utf8_decode("Stock"), 1, 0, 'C');
        $this->fpdf->Cell(25, 10, utf8_decode("V.E."), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        $productos = $this->mod_view->view('producto', 0, false, array('stoc_prod >' => '0'));

        $i = 1;
        foreach ($productos as $row) {

            $time_in = strtotime($row->fein_prod);
            $time_sa = strtotime($row->fesa_prod);
            $fecha_in = date("d/m/Y g:i A", $time_in);

            if ($row->fesa_prod == "") {
                $fecha_sa = "-";
            } else {
                $fecha_sa = date("d/m/Y g:i A", $time_sa);
            }

            $this->fpdf->Cell(15, 8, utf8_decode($i), 1, 0, 'C');
            $this->fpdf->Cell(35, 8, utf8_decode('  ' . $row->nomb_prod), 1, 0, 'L');
            $this->fpdf->Cell(40, 8, utf8_decode($fecha_in), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($fecha_sa), 1, 0, 'C');
            $this->fpdf->Cell(25, 8, utf8_decode('S/. ' . $row->prec_prod), 1, 0, 'C');
            $this->fpdf->Cell(15, 8, utf8_decode($row->stoc_prod), 1, 0, 'C');
            $this->fpdf->Cell(25, 8, utf8_decode('S/. ' . sprintf('%.02F', (double) $row->prec_prod * (double) $row->stoc_prod)), 1, 0, 'C');

            $this->fpdf->Ln(8);
            $i++;
        }

        $this->fpdf->Output();
    }

    public function cliente() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage('L');
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE CLIENTES'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(15, 10, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(55, 10, utf8_decode("Empresa"), 1, 0, 'C');
        $this->fpdf->Cell(70, 10, utf8_decode("Nombres y apellidos"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Teléfono"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("R.U.C."), 1, 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Dirección"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        $clientes = $this->mod_view->view('cliente', 0, false, array('esta_cli' => 'A'));

        $i = 1;
        foreach ($clientes as $row) {

            $this->fpdf->Cell(15, 8, utf8_decode($i), 1, 0, 'C');
            $this->fpdf->Cell(55, 8, utf8_decode('  ' . $row->empr_cli), 1, 0, 'L');
            $this->fpdf->Cell(70, 8, utf8_decode('  ' . $row->nomb_cli . ' ' . $row->apel_cli), 1, 0, 'L');
            $this->fpdf->Cell(40, 8, utf8_decode($row->telf_cli), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($row->ruc_cli), 1, 0, 'C');
            $this->fpdf->Cell(50, 8, utf8_decode($row->dire_cli), 1, 0, 'C');

            $this->fpdf->Ln(8);
            $i++;
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
        $this->fpdf->Cell(15, 10, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Proveedor"), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("R.U.C."), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Teléfono"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("E-mail"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Dirección"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 9);

        $proveedores = $this->mod_view->view('proveedor', 0, false, array('esta_pro' => 'A'));

        $i = 1;
        foreach ($proveedores as $row) {

            if ($row->emai_pro != "") {
                $email = $row->emai_pro;
            } else {
                $email = "-";
            }

            $this->fpdf->Cell(15, 8, utf8_decode($i), 1, 0, 'C');
            $this->fpdf->Cell(35, 8, utf8_decode('  ' . $row->nomb_pro), 1, 0, 'L');
            $this->fpdf->Cell(30, 8, utf8_decode($row->ruc_pro), 1, 0, 'C');
            $this->fpdf->Cell(30, 8, utf8_decode($row->telf_pro), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($email), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($row->dire_pro), 1, 0, 'C');

            $this->fpdf->Ln(8);
            $i++;
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
        $this->fpdf->Cell(15, 10, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(65, 10, utf8_decode("Nombre de usuario"), 1, 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Rol"), 1, 0, 'C');
        $this->fpdf->Cell(60, 10, utf8_decode("Última sesión"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 12);

        $usuarios = $this->mod_view->view('v_usuario', 0, false, array('esta_usu' => 'A'));

        $i = 1;
        foreach ($usuarios as $row) {

            $time = strtotime($row->ses_usu);
            $fecha = date("d/m/Y g:i:s A", $time);

            $this->fpdf->Cell(15, 8, utf8_decode($i), 1, 0, 'C');
            $this->fpdf->Cell(65, 8, utf8_decode('   ' . $row->nomb_usu), 1, 0, 'L');
            $this->fpdf->Cell(50, 8, utf8_decode($row->nomb_rol), 1, 0, 'C');
            $this->fpdf->Cell(60, 8, utf8_decode($fecha), 1, 0, 'C');

            $this->fpdf->Ln(8);
            $i++;
        }

        $this->fpdf->Output();
    }

    public function empleado() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage('L');
        // CABECERA

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE EMPLEADOS'), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(15, 10, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(25, 10, utf8_decode("D.N.I."), 1, 0, 'C');
        $this->fpdf->Cell(65, 10, utf8_decode("Nombres y apellidos"), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Rol"), 1, 0, 'C');
        $this->fpdf->Cell(25, 10, utf8_decode("Teléfono"), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Sueldo"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Fecha P."), 1, 0, 'C');
        $this->fpdf->Cell(20, 10, utf8_decode("A.F.P."), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Dirección"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 9);

        $empleados = $this->mod_empleado->get_vempleado(array('empleado.esta_emp' => 'A'));

        $i = 1;
        foreach ($empleados as $row) {

            $time = strtotime($row->fech_pla);
            $fecha = date("d/m/Y g:i A", $time);

            $this->fpdf->Cell(15, 8, utf8_decode($i), 1, 0, 'C');
            $this->fpdf->Cell(25, 8, utf8_decode($row->dni_emp), 1, 0, 'C');
            $this->fpdf->Cell(65, 8, utf8_decode('   ' . $row->apel_emp . ', ' . $row->nomb_emp), 1, 0, 'L');
            $this->fpdf->Cell(30, 8, utf8_decode($row->nomb_tem), 1, 0, 'C');
            $this->fpdf->Cell(25, 8, utf8_decode($row->telf_emp), 1, 0, 'C');
            $this->fpdf->Cell(30, 8, utf8_decode('S/. ' . $row->suel_pla), 1, 0, 'C');
            $this->fpdf->Cell(35, 8, utf8_decode($fecha), 1, 0, 'C');
            $this->fpdf->Cell(20, 8, utf8_decode($row->afp_emp), 1, 0, 'C');
            $this->fpdf->Cell(35, 8, utf8_decode($row->dire_emp), 1, 0, 'C');

            $this->fpdf->Ln(8);
            $i++;
        }

        $this->fpdf->Output();
    }

    public function caja() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_8');

        $this->load->library('fpdf');

        $this->fpdf->AddPage('L');
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
        $this->fpdf->Cell(15, 7, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(10, 7, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA A."), 1, 0, 'C');
        $this->fpdf->Cell(35, 7, utf8_decode("USUARIO A."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO I."), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA C."), 1, 0, 'C');
        $this->fpdf->Cell(35, 7, utf8_decode("USUARIO C."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO F."), 1, 0, 'C');
        $this->fpdf->Cell(30, 7, utf8_decode("DIFERENCIA"), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("MARGEN"), 1, 0, 'C');

        $this->fpdf->Ln(7);

        $this->fpdf->SetFont('Times', '', 9);

        if ($tipo == "0") {

            $caja_dia = $this->mod_view->view('v_caja_dia', 0, false, array('esta_cad' => 'C'));

            $i = 1;
            foreach ($caja_dia as $row) {
                $time_a = strtotime($row->fein_cad);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_cad);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(15, 7, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(10, 7, utf8_decode($row->num_caj), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_cad), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->safi_cad), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->dife_cad), 1, 0, 'R');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->dife_reg), 1, 0, 'R');

                $this->fpdf->Ln(7);

                $i++;
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_8'), 0, 10) == substr($this->session->userdata('input_reporte_8'), 13)) {
                $caja_dia = $this->mod_caja->get_caja_interval("DATE(fein_cad) = '$fecha_a' OR DATE(fefi_cad) = '$fecha_a' AND esta_cad = 'C'");
            } else {
                $caja_dia = $this->mod_caja->get_caja_interval("fein_cad BETWEEN '$fecha_a'  AND '$fecha_b' OR fefi_cad BETWEEN '$fecha_a'  AND '$fecha_b' AND esta_cad = 'C'");
            }

            $i = 1;
            foreach ($caja_dia as $row) {
                $time_a = strtotime($row->fein_cad);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_cad);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(15, 7, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(10, 7, utf8_decode($row->num_caj), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_cad), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->safi_cad), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->dife_cad), 1, 0, 'R');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->dife_reg), 1, 0, 'R');

                $this->fpdf->Ln(7);
                $i++;
            }
        }

        $this->fpdf->Output();
    }

    public function caja_chica() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_9');

        $this->load->library('fpdf');

        $this->fpdf->AddPage('L');
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
        $this->fpdf->Cell(15, 7, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(10, 7, utf8_decode("CO"), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA A."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO A."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO I."), 1, 0, 'C');
        $this->fpdf->Cell(40, 7, utf8_decode("FECHA C."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO C."), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("SALDO F."), 1, 0, 'C');
        $this->fpdf->Cell(30, 7, utf8_decode("DIFERENCIA"), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("MARGEN"), 1, 0, 'C');

        $this->fpdf->Ln(7);

        $this->fpdf->SetFont('Times', '', 9);

        if ($tipo == "0") {

            $caja_chica_dia = $this->mod_view->view('v_caja_chica_dia', 0, false, array('esta_ccd' => 'C'));

            $i = 1;
            foreach ($caja_chica_dia as $row) {
                $time_a = strtotime($row->fein_ccd);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_ccd);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(15, 7, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(10, 7, utf8_decode($row->codi_cac), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_ccd), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->safi_ccd), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->dife_ccd), 1, 0, 'R');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->dife_reg), 1, 0, 'R');

                $this->fpdf->Ln(7);

                $i++;
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_9'), 0, 10) == substr($this->session->userdata('input_reporte_9'), 13)) {
                $caja_chica_dia = $this->mod_caja->get_caja_chica_interval("DATE(fein_ccd) = '$fecha_a' OR DATE(fefi_ccd) = '$fecha_a' AND esta_ccd = 'C'");
            } else {
                $caja_chica_dia = $this->mod_caja->get_caja_chica_interval("fein_ccd BETWEEN '$fecha_a'  AND '$fecha_b' OR fefi_ccd BETWEEN '$fecha_a'  AND '$fecha_b' AND esta_ccd = 'C'");
            }

            $i = 1;
            foreach ($caja_chica_dia as $row) {
                $time_a = strtotime($row->fein_ccd);
                $fecha_a = date("d/m/Y g:i A", $time_a);
                $time_b = strtotime($row->fefi_ccd);
                $fecha_b = date("d/m/Y g:i A", $time_b);

                $this->fpdf->Cell(15, 7, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(10, 7, utf8_decode($row->codi_cac), 1, 0, 'C');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_a), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_ini), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->sain_ccd), 1, 0, 'R');
                $this->fpdf->Cell(40, 7, utf8_decode($fecha_b), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->usu_fin), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->safi_ccd), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->dife_ccd), 1, 0, 'R');
                $this->fpdf->Cell(25, 7, utf8_decode('S/. ' . $row->dife_reg), 1, 0, 'R');

                $this->fpdf->Ln(7);

                $i++;
            }
        }

        $this->fpdf->Output();
    }

    public function registro() {

        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');
        $tipo = $this->session->userdata('type_10');

        $this->load->library('fpdf');

        $this->fpdf->AddPage('L');
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
        $this->fpdf->Cell(10, 7, utf8_decode("ID"), 1, 0, 'C');
        $this->fpdf->Cell(35, 7, utf8_decode("FECHA"), 1, 0, 'C');
        $this->fpdf->Cell(25, 7, utf8_decode("USUARIO"), 1, 0, 'C');
        $this->fpdf->Cell(55, 7, utf8_decode("EMPLEADO"), 1, 0, 'C');
        $this->fpdf->Cell(20, 7, utf8_decode("P.P."), 1, 0, 'C');
        $this->fpdf->Cell(30, 7, utf8_decode("P.K."), 1, 0, 'C');
        $this->fpdf->Cell(30, 7, utf8_decode("S.T."), 1, 0, 'C');
        $this->fpdf->Cell(30, 7, utf8_decode("DESC."), 1, 0, 'C');
        $this->fpdf->Cell(30, 7, utf8_decode("TOTAL"), 1, 0, 'C');

        $this->fpdf->Ln(7);

        $this->fpdf->SetFont('Times', '', 9);

        if ($tipo == "0") {

            $registro = $this->mod_view->view('v_registro_planilla', 0, false, array());

            $i = 1;
            foreach ($registro as $row) {
                $time = strtotime($row->fech_dpl);
                $fecha = date("d/m/Y g:i A", $time);

                $this->fpdf->Cell(10, 7, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->nomb_usu), 1, 0, 'C');
                $this->fpdf->Cell(55, 7, utf8_decode(' ' . $row->apel_emp . ', ' . $row->nomb_emp), 1, 0, 'L');
                $this->fpdf->Cell(20, 7, utf8_decode($row->cant_dpl . ' Kls'), 1, 0, 'C');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->suel_pla . ' '), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->suto_dpl . ' '), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->desc_dpl . ' '), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->tota_dpl . ' '), 1, 0, 'R');

                $this->fpdf->Ln(7);
                $i++;
            }
        } else if ($tipo == "1") {

            if (substr($this->session->userdata('input_reporte_10'), 0, 10) == substr($this->session->userdata('input_reporte_10'), 13)) {
                $registro = $this->mod_registro->get_registro_interval("DATE(fech_dpl) = '$fecha_a'");
            } else {
                $registro = $this->mod_registro->get_registro_interval("fech_dpl BETWEEN '$fecha_a'  AND '$fecha_b'");
            }

            $i = 1;
            foreach ($registro as $row) {
                $time = strtotime($row->fech_dpl);
                $fecha = date("d/m/Y g:i A", $time);

                $this->fpdf->Cell(10, 7, utf8_decode($i), 1, 0, 'C');
                $this->fpdf->Cell(35, 7, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(25, 7, utf8_decode($row->nomb_usu), 1, 0, 'C');
                $this->fpdf->Cell(55, 7, utf8_decode('  ' . $row->apel_emp . ', ' . $row->nomb_emp), 1, 0, 'L');
                $this->fpdf->Cell(20, 7, utf8_decode($row->cant_dpl . ' Kls'), 1, 0, 'C');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->suel_pla . ' '), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->suto_dpl . ' '), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->desc_dpl . ' '), 1, 0, 'R');
                $this->fpdf->Cell(30, 7, utf8_decode('S/. ' . $row->tota_dpl . '  '), 1, 0, 'R');

                $this->fpdf->Ln(7);
                $i++;
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

        $codi_ven = $this->session->userdata('reg_ventas');

        $registros = $this->mod_view->view('v_venta_det', 0, false, array('codi_ven' => $codi_ven));
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
        $this->fpdf->SetFont('Courier', 'B', 10);
        $this->fpdf->SetTextColor("156", "87", "79");
        $this->fpdf->Cell('35.98', '8', utf8_decode("N° " . $registros[0]->nume_com), 1, 0, 'C');

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

        $time = strtotime($registros[0]->fech_ven);
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
            if (($i + 1) == (8 - count($registros))) {
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

    public function reg_venta_only() {

        $codi_fac = $this->session->userdata('reg_ventas');

        $registros = $this->mod_view->view('v_venta_det', 0, false, array('codi_ven' => $codi_fac));
        $negocio = $this->mod_view->view('negocio');

        $this->load->library('fpdf');

        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->SetMargins(0, 0, 0);
        $this->fpdf->AddPage('P', array('97.8958', '160.0729'));

        $this->fpdf->SetFont('Helvetica', 'B', 28);

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Cell('52.91', '11.9', "", 0, 0, 'C');

        $this->fpdf->SetFont('Helvetica', 'B', 13);
        $this->fpdf->SetLeftMargin(58.7375);
        $this->fpdf->Cell('35.98', '6', "", 0, 0, 'C');
        $this->fpdf->Ln();
        $this->fpdf->Cell('35.98', '6', "", 0, 0, 'C');

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('52.91', '4', utf8_decode(""), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(58.7375);
        $this->fpdf->SetFont('Courier', 'B', 10);
//        $this->fpdf->Cell('35.98', '8', utf8_decode("N° " . $registros[0]->nume_com), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln(4);
        $this->fpdf->SetFont('Helvetica', 'I', 11);
        $this->fpdf->Cell('52.91', '4', "", 0, 0, 'C');

        $this->fpdf->Ln(4);
        $this->fpdf->SetFont('Helvetica', 'I', 9);
        $this->fpdf->Cell('52.91', '4', utf8_decode(""), 0, 0, 'C');

        $this->fpdf->Ln(4);
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('89', '7', utf8_decode("             " . $registros[0]->apel_cli . ', ' . $registros[0]->nomb_cli), 0, 0, 'L');

        $this->fpdf->Ln(8.5);
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('89', '7', utf8_decode("                  " . $registros[0]->dire_cli), 0, 0, 'L');

        $this->fpdf->Ln(8.5);
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('45', '7', utf8_decode("              " . $registros[0]->ruc_cli), 0, 0, 'L');
        $this->fpdf->Cell('3', '7', utf8_decode(""));

        $time = strtotime($registros[0]->fech_ven);
        $fecha = date("d/m/Y", $time);
        $this->fpdf->Cell('41', '7', utf8_decode("             " . $fecha), 0, 0, 'L');

        $this->fpdf->Ln(7);
        $this->fpdf->SetFont('Helvetica', 'I', 9);
        $this->fpdf->Cell('89', '4', utf8_decode(""), 0, 0, 'C');

        $this->fpdf->Ln(4);
        $this->fpdf->SetFont('Helvetica', 'B', 9);
        $this->fpdf->Cell('12', '7', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('10', '7', utf8_decode("."), 0, 0, 'C');
        $this->fpdf->Cell('40', '7', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('11', '7', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('16', '7', utf8_decode(""), 0, 0, 'C');

        foreach ($registros as $row) {
            $this->fpdf->Ln(7);
            $this->fpdf->SetFont('Courier', '', 9);
            $this->fpdf->Cell('12', '7', utf8_decode($row->cantidad), 0, 0, 'C');
            $this->fpdf->Cell('10', '7', utf8_decode(""), 0, 0, 'C');
            $this->fpdf->Cell('40', '7', utf8_decode($row->nomb_prod), 0, 0, 'L');
            $this->fpdf->Cell('11', '7', utf8_decode($row->prec_prod), 0, 0, 'C');
            $this->fpdf->Cell('16', '7', utf8_decode($row->impo_dve), 0, 0, 'C');
        }

        for ($i = 0; $i < (8 - count($registros)); $i++) {

            $this->fpdf->Ln(7);
            $this->fpdf->SetFont('Courier', '', 9);
            $this->fpdf->Cell('12', '7', utf8_decode(""), 0, 0, 'C');
            $this->fpdf->Cell('10', '7', utf8_decode(""), 0, 0, 'C');
            $this->fpdf->Cell('40', '7', utf8_decode(""), 0, 0, 'L');
            $this->fpdf->Cell('11', '7', utf8_decode(""), 0, 0, 'C');
            if (($i + 1) == (8 - count($registros))) {
                $this->fpdf->SetFont('Courier', 'B', 9);
                $this->fpdf->Cell('16', '7', utf8_decode($registros[0]->tota_ven), 0, 0, 'C');
            } else {
                $this->fpdf->Cell('16', '7', utf8_decode(""), 0, 0, 'C');
            }
        }

        $this->fpdf->Ln(8.5);
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('31', '7', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('32', '7', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('23', '5', utf8_decode(""), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(70);
        $this->fpdf->Ln(4);
        $this->fpdf->Cell('23', '4', utf8_decode(""), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln(13);
        $this->fpdf->Cell('64', '7', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('23.5', '7', utf8_decode(""), 0, 0, 'C');

        $this->fpdf->Ln(13);
        $this->fpdf->Cell('64', '7', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('1.5', '7', utf8_decode(""));
        $this->fpdf->Cell('23.5', '7', utf8_decode(""), 0, 0, 'R');

        $this->fpdf->Output();
    }

    // FACTURA Y GUIA

    public function reg_venta_data() {

        $codi_fac = $this->session->userdata('reg_ventas');

        $registros = $this->mod_view->view('v_factura', 0, false, array('codi_fac' => $codi_fac));
        $guia_remision = $this->mod_view->view('guia_remision', 0, false, array('id_fac' => $codi_fac));
        $negocio = $this->mod_view->view('negocio');

        $this->load->library('fpdf');

        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->SetMargins(0, 0, 0);
        $this->fpdf->SetTopMargin(40);
        $this->fpdf->AddPage('L', array('209.020833333', '161.395833333'));

        $this->fpdf->SetLeftMargin(135);

        $this->fpdf->SetFont('Courier', 'B', 18);
//        $this->fpdf->Cell('50', '8', utf8_decode("N° " . $registros[0]->desp_fac), 0, 0, 'C');

        $fecha_fac = $registros[0]->fech_fac;

        $this->fpdf->SetLeftMargin(33);
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Courier', 'B', 10);
        $this->fpdf->Cell('13', '5', utf8_decode(substr($fecha_fac, 8, 2)), 0, 0, 'C');

        $mes_date = substr($fecha_fac, 5, 2);
        $mes = "Enero";
        if ($mes_date == "02") {
            $mes = "Febrero";
        } else if ($mes_date == "03") {
            $mes = "Marzo";
        } else if ($mes_date == "04") {
            $mes = "Abril";
        } else if ($mes_date == "05") {
            $mes = "Mayo";
        } else if ($mes_date == "06") {
            $mes = "Junio";
        } else if ($mes_date == "07") {
            $mes = "Julio";
        } else if ($mes_date == "08") {
            $mes = "Agosto";
        } else if ($mes_date == "09") {
            $mes = "Septiembre";
        } else if ($mes_date == "10") {
            $mes = "Octubre";
        } else if ($mes_date == "11") {
            $mes = "Noviembre";
        } else if ($mes_date == "12") {
            $mes = "Diciembre";
        }
        $this->fpdf->Cell('5', '5', "", 0);
        $this->fpdf->Cell('37', '5', utf8_decode($mes), 0, 0, 'C');
        $this->fpdf->Cell('10', '5', "", 0);
        $this->fpdf->Cell('5', '5', utf8_decode(substr($fecha_fac, 3, 1)), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->Ln(8);

        $this->fpdf->Cell('112', '5', utf8_decode($registros[0]->nomb_cli . ' ' . $registros[0]->apel_cli), 0, 0, 'L');
        $this->fpdf->Cell('15', '5', "", 0);
        $this->fpdf->Cell('48', '5', utf8_decode($registros[0]->ruc_cli), 0, 0, 'L');

        $this->fpdf->Ln(6);

        $this->fpdf->Cell('112', '5', utf8_decode($registros[0]->dire_cli), 0, 0, 'L');
        $this->fpdf->Cell('15', '5', "", 0);
        $this->fpdf->Cell('48', '5', utf8_decode(""), 0, 0, 'L');

        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln(12);

        $i = 0;
        $total = 0;
        foreach ($registros as $row) {
            $i++;
            $total += round($row->cantidad * $row->prec_prod, 2);
            $this->fpdf->Cell('14', '6,1', utf8_decode($row->cantidad), 0, 0, 'C');
            $this->fpdf->Cell('123', '6.1', utf8_decode($row->nomb_prod), 0, 0, 'L');
            $this->fpdf->Cell('24', '6.1', utf8_decode($row->prec_prod), 0, 0, 'C');
            $this->fpdf->Cell('32', '6.1', utf8_decode(round($row->cantidad * $row->prec_prod, 2)), 0, 0, 'C');
            $this->fpdf->Ln(6.1);
        }
        while ($i != 8) {
            $i++;
            $this->fpdf->Cell('14', '6.1', utf8_decode(""), 0, 0, 'C');
            $this->fpdf->Cell('123', '6.1', utf8_decode(""), 0, 0, 'L');
            $this->fpdf->Cell('24', '6.1', utf8_decode(""), 0, 0, 'C');
            $this->fpdf->Cell('32', '6.1', utf8_decode(""), 0, 0, 'C');
            $this->fpdf->Ln(6.1);
        }

        $this->fpdf->Cell('14', '6.1', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('123', '6.1', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('24', '6.1', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('32', '6.1', utf8_decode(""), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(23);
        $this->fpdf->Ln(6.1);

        $this->fpdf->SetFont('Courier', 'B', 8);
        $this->fpdf->Cell('24', '4.5', utf8_decode($guia_remision[0]->serie_guia . '-' . $guia_remision[0]->nume_guia), 0, 0, 'C');

        $this->fpdf->SetFont('Courier', 'B', 10);

        $this->fpdf->Cell('118', '7', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('32', '7', utf8_decode($total), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(47 + 118);
        $this->fpdf->Ln(7);
        $this->fpdf->Cell('32', '7', utf8_decode((int) $negocio[0]->igv_pla), 0, 0, 'C');
        $this->fpdf->Ln(7);
        $this->fpdf->Cell('32', '7', utf8_decode($registros[0]->tota_ven), 0, 0, 'C');

        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->SetMargins(0, 0, 0);
        $this->fpdf->SetTopMargin(35);
        $this->fpdf->AddPage('L', array('209.020833333', '161.395833333'));

        $this->fpdf->SetLeftMargin(145);

        $this->fpdf->SetFont('Courier', 'B', 18);
//        $this->fpdf->Cell('50', '8', utf8_decode("N° " . $guia_remision[0]->nume_guia), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(50);
        $this->fpdf->Ln(6.5);
        $this->fpdf->SetFont('Courier', 'B', 10);
        $this->fpdf->Cell('11', '5', utf8_decode(substr($fecha_fac, 8, 2)), 0, 0, 'C');
        $this->fpdf->Cell('15', '5', utf8_decode(substr($fecha_fac, 5, 2)), 0, 0, 'C');
        $this->fpdf->Cell('11', '5', utf8_decode(substr($fecha_fac, 2, 2)), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(30);
        $this->fpdf->Ln(5);

        $this->fpdf->Cell('57', '4', utf8_decode($registros[0]->nomb_cli . ' ' . $registros[0]->apel_cli), 0, 0, 'L');
        $this->fpdf->Cell('45', '4', "", 0);
        $this->fpdf->Cell('76', '4', utf8_decode($guia_remision[0]->punto_par), 0);

        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->Ln(5);

        $this->fpdf->Cell('40', '4', utf8_decode($registros[0]->ruc_cli), 0, 0, 'L');
        $this->fpdf->Cell('21', '4', "", 0);
        $this->fpdf->Cell('26', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('25', '4', "", 0);
        $this->fpdf->Cell('76', '4', utf8_decode($guia_remision[0]->punto_lle), 0);

        $this->fpdf->SetLeftMargin(13);
        $this->fpdf->Ln(32);

        $i = 0;
        $total = 0;
        foreach ($registros as $row) {
            $i++;
            $total += round($row->cantidad * $row->prec_prod, 2);
            $this->fpdf->Cell('88', '4', utf8_decode($row->nomb_prod), 0, 0, 'L');
            $this->fpdf->Cell('36', '4', utf8_decode($row->cantidad), 0, 0, 'C');
            $this->fpdf->Ln(4);
        }
        while ($i != 7) {
            $i++;
            $this->fpdf->Cell('88', '4', utf8_decode(""), 0, 0, 'L');
            $this->fpdf->Cell('36', '4', utf8_decode(""), 0, 0, 'C');
            $this->fpdf->Ln(4);
        }

        $this->fpdf->SetLeftMargin(15);
        $this->fpdf->Ln(10);

        $transportista = $this->mod_view->view('transportista', 0, false, array('id_tran' => $guia_remision[0]->id_tran));
        $conductor = $this->mod_view->view('transportista_conductor', 0, false, array('id_cond' => $guia_remision[0]->id_cond));
        $vehiculo = $this->mod_view->view('transportista_vehiculo', 0, false, array('id_vehi' => $guia_remision[0]->id_vehi));

        $this->fpdf->Cell('40', '4', utf8_decode($transportista[0]->ruc_tran), 0, 0, 'L');
        $this->fpdf->Cell('50', '4', utf8_decode($transportista[0]->nomb_tran), 0, 0, 'L');
        $this->fpdf->Cell('15', '4', "", 0);
        $this->fpdf->Cell('45', '4', utf8_decode($vehiculo[0]->marca_vehi . ' - ' . $vehiculo[0]->placa_vehi), 0);
        $this->fpdf->Cell('40', '4', utf8_decode($conductor[0]->licen_cond), 0);

        $this->fpdf->Output();
    }

    public function reg_venta_show() {

        $codi_fac = $this->session->userdata('reg_ventas');

        $registros = $this->mod_view->view('v_factura', 0, false, array('codi_fac' => $codi_fac));
        $guia_remision = $this->mod_view->view('guia_remision', 0, false, array('id_fac' => $codi_fac));
        $negocio = $this->mod_view->view('negocio');
        $comprobantes = $this->mod_view->view('comprobante');

        $this->load->library('fpdf');

        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->SetMargins(0, 0, 0);
        $this->fpdf->SetTopMargin(13);
        $this->fpdf->AddPage('L', array('209.020833333', '161.395833333'));

//        $this->fpdf->SetTextColor("6", "44", "132");
        // TITULO
        $this->fpdf->SetFont('Helvetica', 'B', 36);
        $this->fpdf->SetLeftMargin(40);
        $this->fpdf->Cell('52.91', '11.9', "DELIPAPAS", 0, 0, 'C');
        $this->fpdf->Ln(2);

        // RUC
        $this->fpdf->SetFont('Helvetica', 'B', 21);
        $this->fpdf->SetLeftMargin(133);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("RUC N° " . $negocio[0]->ruc_neg), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(40);
        $this->fpdf->Ln(6);

        // Dr. Quispe Ugalbe, Fernando Ernesto
        $this->fpdf->SetFont('Helvetica', 'I', 10);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("De: Quispe Ugalbe, Fernando Ernesto"), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(130);
        $this->fpdf->Ln(7);

        // FACTURA
        $this->fpdf->SetFont('Helvetica', 'B', 25);
        $this->fpdf->SetFillColor(0, 0, 0);
        $this->fpdf->Rect(119, 27, 79, 13, 'F');
        $this->fpdf->SetTextColor(255, 255, 255);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("FACTURA"), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(40);
        $this->fpdf->Ln(3);

        $this->fpdf->SetTextColor(0, 0, 0);

        // DIRECCIONES
        $this->fpdf->SetFont('Helvetica', '', 7);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("AV. CRUZ BLANCA N°567 INT. A. PAN. NORTE KM. 152"), 0, 0, 'C');
        $this->fpdf->Ln(3);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("AV. PUQUIO CANO - HUALMAY - HUAURA - LIMA"), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(120);
        $this->fpdf->Ln(8);

        // SERIE Y DESPACHO
        $this->fpdf->SetFont('Helvetica', 'B', 18);
        $this->fpdf->Cell('25', '8', utf8_decode($registros[0]->serie_fac . ' - '), 0, 0, 'C');
        $this->fpdf->SetFont('Courier', '', 18);
        $this->fpdf->Cell('50', '8', utf8_decode("N° " . $registros[0]->desp_fac), 0, 0, 'L');
        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->Ln(7);

        // FECHAS
        $fecha_fac = $registros[0]->fech_fac;
        $mes_date = substr($fecha_fac, 5, 2);
        $mes = "Enero";
        if ($mes_date == "02") {
            $mes = "Febrero";
        } else if ($mes_date == "03") {
            $mes = "Marzo";
        } else if ($mes_date == "04") {
            $mes = "Abril";
        } else if ($mes_date == "05") {
            $mes = "Mayo";
        } else if ($mes_date == "06") {
            $mes = "Junio";
        } else if ($mes_date == "07") {
            $mes = "Julio";
        } else if ($mes_date == "08") {
            $mes = "Agosto";
        } else if ($mes_date == "09") {
            $mes = "Septiembre";
        } else if ($mes_date == "10") {
            $mes = "Octubre";
        } else if ($mes_date == "11") {
            $mes = "Noviembre";
        } else if ($mes_date == "12") {
            $mes = "Diciembre";
        }
        $this->fpdf->SetFont('Helvetica', '', 8);
        $this->fpdf->Cell('14', '4', utf8_decode("Hualmay,"), 0, 0, 'C');
        $this->fpdf->Cell('12', '4', utf8_decode(substr($fecha_fac, 8, 2)), 0, 0, 'C');
        $this->fpdf->Cell('4', '4', utf8_decode("de"), 0, 0, 'C');
        $this->fpdf->Cell('37', '4', utf8_decode($mes), 0, 0, 'C');
        $this->fpdf->Cell('11', '4', utf8_decode("del 201"), 0, 0, 'C');
        $this->fpdf->Cell('3', '4', utf8_decode(substr($fecha_fac, 3, 1)), 0, 0, 'C');
        $this->fpdf->Ln(1);
        $this->fpdf->Cell('14', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('12', '4', utf8_decode(".............."), 0, 0, 'C');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('37', '4', utf8_decode("..............................................."), 0, 0, 'C');
        $this->fpdf->Cell('11', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('3', '4', utf8_decode("......"), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(6);
        $this->fpdf->Ln(7);

        // DATOS DEL CLIENTE
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('17', '4', utf8_decode("Señor (es):"), 0, 0, 'C');
        $this->fpdf->Cell('112', '4', utf8_decode($registros[0]->nomb_cli . ' ' . $registros[0]->apel_cli), 0, 0, 'L');
        $this->fpdf->Cell('17', '4', utf8_decode("R.U.C. N°:"), 0);
        $this->fpdf->Cell('48', '4', utf8_decode($registros[0]->ruc_cli), 0, 0, 'L');
        $this->fpdf->Ln(1);
        $this->fpdf->Cell('17', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('112', '4', utf8_decode("............................................................................................................................."), 0, 0, 'L');
        $this->fpdf->Cell('17', '4', utf8_decode(""), 0);
        $this->fpdf->Cell('48', '4', utf8_decode("................................................"), 0, 0, 'L');
        $this->fpdf->Ln(6);
        $this->fpdf->Cell('17', '4', utf8_decode("Dirección: "), 0, 0, 'C');
        $this->fpdf->Cell('112', '4', utf8_decode($registros[0]->dire_cli), 0, 0, 'L');
        $this->fpdf->Cell('15', '4', utf8_decode("Guía N°: "), 0);
        $this->fpdf->Cell('48', '4', utf8_decode($guia_remision[0]->nume_guia), 0, 0, 'L');
        $this->fpdf->Ln(1);
        $this->fpdf->Cell('17', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('112', '4', utf8_decode(".............................................................................................................................."), 0, 0, 'L');
        $this->fpdf->Cell('15', '4', utf8_decode(""), 0);
        $this->fpdf->Cell('48', '4', utf8_decode(".................................................."), 0, 0, 'L');
        $this->fpdf->SetLeftMargin(4);
        $this->fpdf->Ln(5);

        // DETALLE DE PRODUCTOS
        $this->fpdf->Cell('14', '6.1', utf8_decode("CANT."), 1, 0, 'C');
        $this->fpdf->Cell('123', '6.1', utf8_decode("D  E  S  C  R  I  P  C  I  O  N"), 1, 0, 'C');
        $this->fpdf->Cell('24', '6.1', utf8_decode("P. UNITARIO"), 1, 0, 'C');
        $this->fpdf->Cell('32', '6.1', utf8_decode("VALOR VENTA"), 1, 0, 'C');
        $this->fpdf->Ln(6.1);
        $i = 0;
        $total = 0;
        foreach ($registros as $row) {
            $i++;
            $total += round($row->cantidad * $row->prec_prod, 2);
            $this->fpdf->Cell('14', '6,1', utf8_decode($row->cantidad), 1, 0, 'C');
            $this->fpdf->Cell('123', '6.1', utf8_decode('   ' . $row->nomb_prod), 1, 0, 'L');
            $this->fpdf->Cell('24', '6.1', utf8_decode($row->prec_prod), 1, 0, 'C');
            $this->fpdf->Cell('32', '6.1', utf8_decode(round($row->cantidad * $row->prec_prod, 2)), 1, 0, 'C');
            $this->fpdf->Ln(6.1);
        }
        while ($i != 8) {
            $i++;
            $this->fpdf->Cell('14', '6.1', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('123', '6.1', utf8_decode(""), 1, 0, 'L');
            $this->fpdf->Cell('24', '6.1', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('32', '6.1', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Ln(6.1);
        }
        $this->fpdf->Cell('161', '6.1', utf8_decode("SON:                                                                                                                                                   Nuevos Soles"), 1, 0, 'L');
        $this->fpdf->Cell('32', '6.1', utf8_decode(""), 1, 0, 'C');
//        $this->fpdf->SetLeftMargin(23);
        $this->fpdf->Ln(6.1);

        // GUIA DE REMISIÓN
        $this->fpdf->SetFont('Helvetica', 'B', 8);
        $this->fpdf->Cell('30', '4.5', utf8_decode("Guía de remisión N°: "), 0, 0, 'L');
        $this->fpdf->SetFont('Courier', 'B', 8);
        $this->fpdf->Cell('24', '4.5', utf8_decode($guia_remision[0]->serie_guia . '-' . $guia_remision[0]->nume_guia), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(78);
        $this->fpdf->Ln(1.5);

        $this->fpdf->SetFont('Courier', 'B', 9);

        $this->fpdf->Cell('32', '4.5', utf8_decode("C A N C E L A D O"), 0, 0, 'L');
        $this->fpdf->Cell('30', '4.5', "", 0, 0, 'L');
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('25.1', '6.1', utf8_decode("SUB-TOTAL"), 1, 0, 'C');
        $this->fpdf->SetFont('Courier', 'B', 9);
        $this->fpdf->Cell('32', '6.1', utf8_decode($total), 1, 0, 'C');

        $this->fpdf->SetLeftMargin(60);
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Helvetica', '', 8);
        $this->fpdf->Cell('14', '4', utf8_decode("Hualmay,"), 0, 0, 'C');
        $this->fpdf->Cell('10', '4', utf8_decode(substr($fecha_fac, 8, 2)), 0, 0, 'C');
        $this->fpdf->Cell('4', '4', utf8_decode("de"), 0, 0, 'C');
        $this->fpdf->Cell('26', '4', utf8_decode($mes), 0, 0, 'C');
        $this->fpdf->Cell('11', '4', utf8_decode("del 201"), 0, 0, 'C');
        $this->fpdf->Cell('3', '4', utf8_decode(substr($fecha_fac, 3, 1)), 0, 0, 'C');
        $this->fpdf->Ln(1);
        $this->fpdf->Cell('14', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('10', '4', utf8_decode("........."), 0, 0, 'C');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('26', '4', utf8_decode(".................................."), 0, 0, 'C');
        $this->fpdf->Cell('11', '4', utf8_decode(""), 0, 0, 'C');
        $this->fpdf->Cell('3', '4', utf8_decode("......"), 0, 0, 'C');
        $this->fpdf->Cell('12', '6.1', "", 0, 0, 'C');
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('25.1', '6.1', utf8_decode("I.G.V.        %"), 1, 0, 'C');
        $this->fpdf->SetFont('Courier', 'B', 9);
        $this->fpdf->Cell('32', '6.1', utf8_decode((int) $negocio[0]->igv_pla), 1, 0, 'C');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Helvetica', 'B', 8);
        $this->fpdf->Cell('70', '8', utf8_decode("___________________________________"), 0, 0, 'C');
        $this->fpdf->Ln(6);
        $this->fpdf->SetFont('Helvetica', 'I', 8);
        $this->fpdf->Cell('70', '4', utf8_decode("p. Quispe Ugalbe, Fernando Ernesto"), 0, 0, 'C');

        $this->fpdf->SetLeftMargin(140);
        $this->fpdf->Ln(-5);
        $this->fpdf->SetFont('Helvetica', '', 9);
        $this->fpdf->Cell('25.1', '6.1', utf8_decode("TOTAL       S/."), 1, 0, 'C');
        $this->fpdf->SetFont('Courier', 'B', 9);
        $this->fpdf->Cell('32', '6.1', utf8_decode($registros[0]->tota_ven), 1, 0, 'C');

        $this->fpdf->SetLeftMargin(35);
        $this->fpdf->Ln(-12);
        $this->fpdf->Cell('20', '4', utf8_decode("............"), 0, 0, 'C');

        $this->fpdf->Rect(119, 14, 79, 38, 'D');
        $this->fpdf->Rect(4, 54, 193, 15, 'D');
        $this->fpdf->Rect(4, 54, 193, 15, 'D');
        $this->fpdf->Rect(58, 132.5, 73, 22, 'D');

        $this->fpdf->SetAutoPageBreak(false);
        $this->fpdf->SetMargins(0, 0, 0);
        $this->fpdf->SetTopMargin(13);
        $this->fpdf->AddPage('L', array('209.020833333', '161.395833333'));

        // TITULO
        $this->fpdf->SetFont('Helvetica', 'B', 36);
        $this->fpdf->SetLeftMargin(40);
        $this->fpdf->Cell('52.91', '11.9', "DELIPAPAS", 0, 0, 'C');
        $this->fpdf->Ln(2);

        // RUC
        $this->fpdf->SetFont('Helvetica', 'B', 21);
        $this->fpdf->SetLeftMargin(133);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("RUC N° " . $negocio[0]->ruc_neg), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(40);
        $this->fpdf->Ln(6);

        // Dr. Quispe Ugalbe, Fernando Ernesto
        $this->fpdf->SetFont('Helvetica', 'I', 10);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("De: Quispe Ugalbe, Fernando Ernesto"), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(130);
        $this->fpdf->Ln(3);

        // GIOA DE REMITENTE
        $this->fpdf->SetFont('Helvetica', 'B', 16);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("GUÍA DE REMISIÓN"), 0, 0, 'C');
        $this->fpdf->Ln(7);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("REMITENTE"), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(40);
        $this->fpdf->Ln(0);

        $this->fpdf->SetTextColor(0, 0, 0);

        // DIRECCIONES
        $this->fpdf->SetFont('Helvetica', '', 7);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("AV. CRUZ BLANCA N°567 INT. A. PAN. NORTE KM. 152"), 0, 0, 'C');
        $this->fpdf->Ln(3);
        $this->fpdf->Cell('52.91', '11.9', utf8_decode("AV. PUQUIO CANO - HUALMAY - HUAURA - LIMA"), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(122);
        $this->fpdf->Ln(8);

        // SERIE Y DESPACHO
        $this->fpdf->SetFont('Helvetica', 'B', 18);
        $this->fpdf->Cell('25', '8', utf8_decode($guia_remision[0]->serie_guia . ' - '), 0, 0, 'C');
        $this->fpdf->SetFont('Courier', '', 18);
        $this->fpdf->Cell('50', '8', utf8_decode("N° " . $guia_remision[0]->nume_guia), 0, 0, 'L');
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(7);

        // FECHAS

        $this->fpdf->SetFont('Helvetica', '', 8);
        $this->fpdf->Cell('40', '4', utf8_decode("Fecha del inicio del traslado: "), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(50);
        $this->fpdf->Ln(-2);
        $this->fpdf->Cell('40', '6', utf8_decode(substr($fecha_fac, 8, 2) . '     /     ' . substr($fecha_fac, 5, 2) . '     /     ' . substr($fecha_fac, 2, 2)), 1, 0, 'C');
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(7);
        $this->fpdf->Cell('20', '4', utf8_decode("Destinatario: "), 0, 0, 'L');
        $this->fpdf->Cell('85', '4', utf8_decode($registros[0]->nomb_cli . ' ' . $registros[0]->apel_cli), 0, 0, 'L');
        $this->fpdf->Cell('25', '4', "Punto de partida:", 0);
        $this->fpdf->Cell('25', '4', utf8_decode($guia_remision[0]->punto_par), 0);
        $this->fpdf->SetLeftMargin(30);
        $this->fpdf->Ln(0.5);
        $this->fpdf->Cell('110', '4', utf8_decode("_______________________________________"), 0, 0, 'L');
        $this->fpdf->Cell('70', '4', utf8_decode("__________________________________________"), 0, 0, 'L');
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(4);
        $this->fpdf->Cell('10', '4', utf8_decode("RUC:"), 0, 0, 'L');
        $this->fpdf->Cell('42', '4', utf8_decode($registros[0]->ruc_cli), 0, 0, 'L');
        $this->fpdf->Cell('25', '4', utf8_decode("N° Doc. Identidad:"), 0, 0, 'L');
        $this->fpdf->Cell('23', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('5', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('25', '4', "Punto de llegada:", 0);
        $this->fpdf->Cell('25', '4', utf8_decode($guia_remision[0]->punto_lle), 0);
        $this->fpdf->SetLeftMargin(20);
        $this->fpdf->Ln(0.5);
        $this->fpdf->Cell('67', '4', utf8_decode("_________________________"), 0, 0, 'L');
        $this->fpdf->Cell('53', '4', utf8_decode("_____________"), 0, 0, 'L');
        $this->fpdf->Cell('70', '4', utf8_decode("__________________________________________"), 0, 0, 'L');
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(5);
        $this->fpdf->Cell('10', '4', utf8_decode("Motivo del traslado:"), 0, 0, 'L');
        $this->fpdf->Ln(6);
        $this->fpdf->SetFont('Times', '', 8);
        $this->fpdf->Cell('35', '4', utf8_decode("Venta"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->SetFont('Times', '', 7);
        $this->fpdf->Cell('56', '4', utf8_decode("Venta sujeta a confirmación por el comprador"), 0, 0, 'L');
        $this->fpdf->SetFont('Times', '', 8);
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('22', '4', utf8_decode("Recojo de bienes"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('50', '4', utf8_decode("Traslado zona primaria"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Ln(4);
        $this->fpdf->Cell('35', '4', utf8_decode("Compra"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->SetFont('Times', '', 7);
        $this->fpdf->Cell('56', '4', utf8_decode("Traslado entre establecimientos de la misma empresa"), 0, 0, 'L');
        $this->fpdf->SetFont('Times', '', 8);
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('22', '4', utf8_decode("Importación"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('50', '4', utf8_decode("Traslado por emisor itinerante"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Ln(4);
        $this->fpdf->Cell('35', '4', utf8_decode("Consignación"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->SetFont('Times', '', 7);
        $this->fpdf->Cell('56', '4', utf8_decode("Devolución"), 0, 0, 'L');
        $this->fpdf->SetFont('Times', '', 8);
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('22', '4', utf8_decode("Exportación"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->Cell('50', '4', utf8_decode("Traslado entre bienes para transformación"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Ln(4);
        $this->fpdf->Cell('35', '4', utf8_decode("Venta con entrega a terceros"), 0, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 1, 0, 'L');
        $this->fpdf->Cell('4', '4', utf8_decode(""), 0, 0, 'L');
        $this->fpdf->SetFont('Times', '', 7);
        $this->fpdf->Cell('56', '4', utf8_decode("Otros (especificar) ................................................................................................................................................................................................................"
                        . ""), 0, 0, 'L');
        $this->fpdf->Ln(9);
        $this->fpdf->SetFont('Helvetica', '', 8);
        $this->fpdf->Cell('10', '4', utf8_decode("Datos del bien transportado:"), 0, 0, 'L');
        $this->fpdf->Ln(4);
        $this->fpdf->Cell('88', '8', utf8_decode("   Descripción"), 1, 0, 'L');
        $this->fpdf->Cell('36', '8', utf8_decode("   Cantidad"), 1, 0, 'L');
        $this->fpdf->Cell('36', '8', utf8_decode("   Unidad de medida"), 1, 0, 'L');
        $this->fpdf->Cell('32', '8', utf8_decode("   Peso"), 1, 0, 'L');
        $this->fpdf->Ln(8);
        $i = 0;
        $total = 0;
        foreach ($registros as $row) {
            $i++;
            $total += round($row->cantidad * $row->prec_prod, 2);
            $this->fpdf->Cell('88', '4', utf8_decode($row->nomb_prod), 1, 0, 'L');
            $this->fpdf->Cell('36', '4', utf8_decode($row->cantidad), 1, 0, 'C');
            $this->fpdf->Cell('36', '4', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('32', '4', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Ln(4);
        }
        while ($i != 7) {
            $i++;
            $this->fpdf->Cell('88', '4', utf8_decode(""), 1, 0, 'L');
            $this->fpdf->Cell('36', '4', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('36', '4', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Cell('32', '4', utf8_decode(""), 1, 0, 'C');
            $this->fpdf->Ln(4);
        }
        $transportista = $this->mod_view->view('transportista', 0, false, array('id_tran' => $guia_remision[0]->id_tran));
        $conductor = $this->mod_view->view('transportista_conductor', 0, false, array('id_cond' => $guia_remision[0]->id_cond));
        $vehiculo = $this->mod_view->view('transportista_vehiculo', 0, false, array('id_vehi' => $guia_remision[0]->id_vehi));

        $this->fpdf->Ln(2);
        $this->fpdf->Cell('102', '4', utf8_decode("Datos del transportista:"), 0, 0, 'L');
        $this->fpdf->Cell('20', '4', utf8_decode("Datos de la Unidad de Transporte y conductor:"), 0, 0, 'L');
        $this->fpdf->Ln(6);
        $this->fpdf->Cell('40', '4', utf8_decode("   RUC"), 0, 0, 'L');
        $this->fpdf->Cell('60', '4', utf8_decode("   Denominación, apellidos y nombres"), 0, 0, 'L');
        $this->fpdf->Cell('45', '4', utf8_decode("   Marca y placa"), 0, 0, 'L');
        $this->fpdf->Cell('40', '4', utf8_decode("   Licencia de conducir"), 0, 0, 'L');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell('40', '4', utf8_decode("   " . $transportista[0]->ruc_tran), 0, 0, 'L');
        $this->fpdf->Cell('60', '4', utf8_decode("   " . $transportista[0]->nomb_tran), 0, 0, 'L');
        $this->fpdf->Cell('45', '4', utf8_decode("   " . $vehiculo[0]->marca_vehi . ' - ' . $vehiculo[0]->placa_vehi), 0, 0, 'L');
        $this->fpdf->Cell('40', '4', utf8_decode("   " . $conductor[0]->licen_cond), 0, 0, 'L');
        $this->fpdf->SetLeftMargin(110);
        $this->fpdf->Ln(7);
        $this->fpdf->Cell('45', '4', utf8_decode("   Código de Autorización (SCOP) de OSINERG"), 0, 0, 'L');

        $this->fpdf->Rect(119, 14, 81, 38, 'D');

        $this->fpdf->Rect(10, 68, 193, 20, 'D');
        $this->fpdf->Rect(10, 138, 38, 11, 'D');
        $this->fpdf->Rect(48, 138, 53, 11, 'D');
        $this->fpdf->Rect(110, 138, 45, 11, 'D');
        $this->fpdf->Rect(155, 138, 45, 11, 'D');
        $this->fpdf->Rect(110, 150, 65, 10, 'D');

        $this->fpdf->Output();
    }

}
