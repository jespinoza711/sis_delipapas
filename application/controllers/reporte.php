<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
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

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE COMPRA - ' . $mes[substr($this->session->userdata('input_reporte_1'), 5)] . ' ' . substr($this->session->userdata('input_reporte_1'), 0, 4)), 0, 0, 'C');

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



        $this->fpdf->Output();
    }

    public function venta() {
        // *********************** CABECERA ******************************************* //
        date_default_timezone_set('America/Lima');

        $this->load->library('fpdf');

        $this->fpdf->AddPage();
        // CABECERA

        $mes = array('01' => "ENERO", '02' => 'FEBRERO', '03' => "MARZO", '04' => 'ABRIL', '05' => "MAYO", '06' => 'JUNIO', '07' => "JULIO", '08' => 'AGOSTO', '09' => "SEPTIEMBRE", '10' => 'OCTUBRE', '11' => "NOVIEMBRE", '12' => 'DICIEMBRE');

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 0, utf8_decode('LISTADO DE MOVIMIENTOS DE VENTA - ' . $mes[substr($this->session->userdata('input_reporte_2'), 5)] . ' ' . substr($this->session->userdata('input_reporte_2'), 0, 4)), 0, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->Cell(0, 0, utf8_decode('Fecha de reporte: ' . date("d/m/Y g:i:s A")), 0, 0, 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(35, 10, utf8_decode("Fecha"), 1, 0, 'C');
        $this->fpdf->Cell(55, 10, utf8_decode("Cliente"), 1, 0, 'C');
        $this->fpdf->Cell(18, 10, utf8_decode("N° Caja"), 1, 0, 'C');
        $this->fpdf->Cell(35, 10, utf8_decode("Usuario vendedor"), 1, 0, 'C');
        $this->fpdf->Cell(18, 10, utf8_decode("Com."), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Total de venta"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        $ventas = $this->mod_view->view('v_venta');

        foreach ($ventas as $row) {

            $fech_reg = substr($row->fech_ven, 0, 7);

            if ($this->session->userdata('input_reporte_2') == $fech_reg) {
                $time = strtotime($row->fech_ven);
                $fecha = date("d/m/Y g:i A", $time);
                $this->fpdf->Cell(35, 8, utf8_decode($fecha), 1, 0, 'C');
                $this->fpdf->Cell(55, 8, utf8_decode($row->apel_cli . ', ' . $row->nomb_cli), 1, 0, 'L');
                $this->fpdf->Cell(18, 8, utf8_decode($row->num_caj), 1, 0, 'C');
                $this->fpdf->Cell(35, 8, utf8_decode($row->nomb_usu), 1, 0, 'C');
                $this->fpdf->Cell(18, 8, utf8_decode($row->nomb_com), 1, 0, 'C');
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

            $this->fpdf->Cell(55, 8, utf8_decode('  '.$row->nomb_prod), 1, 0, 'L');
            $this->fpdf->Cell(40, 8, utf8_decode($fecha_in), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($fecha_sa), 1, 0, 'C');
            $this->fpdf->Cell(35, 8, utf8_decode('S/. '.$row->prec_prod), 1, 0, 'C');
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
        $this->fpdf->Cell(60, 10, utf8_decode("Nombres y apellidos"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Teléfono"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("R.U.C."), 1, 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Dirección"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 10);

        $clientes = $this->mod_view->view('cliente', 0, false, array('esta_cli' => 'A'));

        foreach ($clientes as $row) {

            $this->fpdf->Cell(60, 8, utf8_decode('  '.$row->nomb_cli . ' ' . $row->apel_cli), 1, 0, 'L');
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

            if ($row->emai_pro!="") {
                $email = $row->emai_pro;
            } else {
                $email = "-";
            }
            
            $this->fpdf->Cell(50, 8, utf8_decode('  '.$row->nomb_pro), 1, 0, 'L');
            $this->fpdf->Cell(30, 8, utf8_decode($row->ruc_pro), 1, 0, 'C');
            $this->fpdf->Cell(30, 8, utf8_decode($row->telf_pro), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($email), 1, 0, 'C');
            $this->fpdf->Cell(40, 8, utf8_decode($row->dire_pro), 1, 0, 'C');

            $this->fpdf->Ln(8);
        }

        $this->fpdf->Output();
    }

    public function input_1() {
        $fecha = $this->input->post('month');
        $this->session->set_userdata('input_reporte_1', $fecha);
    }

    public function input_2() {
        $fecha = $this->input->post('month_2');
        $this->session->set_userdata('input_reporte_2', $fecha);
    }

}
