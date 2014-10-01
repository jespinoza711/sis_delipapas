<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pago extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_empleado'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $ajustes['datetime'] = date('Y-m-d H:i:s');
            $ajustes['negocio'] = $this->mod_view->one('negocio');

            // PLANILLA
            if ($this->input->post('registrar_planilla')) {
                $data['fech_pla'] = $ajustes['datetime'];
                $data['suel_pla'] = $this->input->post('suel_pla');
                $data['obsv_pla'] = $this->input->post('obsv_pla');
                $data['esta_pla'] = 'A';
                $this->mod_ajustes->insert_planilla($data);
                $this->session->set_userdata('info_planilla', 'La planilla con el sueldo S/. ' . $data['suel_pla'] . ' ha sido registrado existosamente. Esta es su planilla actual.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('editar_planilla')) {
                $codi_pla = $this->input->post('codi_pla_e');
                $data['suel_pla'] = $this->input->post('suel_pla_e');
                $data['obsv_pla'] = $this->input->post('obsv_pla_e');
                $data['esta_pla'] = 'A';
                $this->mod_ajustes->update_planilla($codi_pla, $data);
                $this->session->set_userdata('info_planilla', 'La planilla con el sueldo S/. ' . $data['suel_pla'] . ' ha sido actualizado existosamente. Esta es su planilla actual.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('activar_planilla')) {
                $codi_pla = $this->input->post('codi_pla');
                $suel_pla = $this->input->post('suel_pla');
                $this->mod_ajustes->update_planilla($codi_pla, array('esta_pla' => 'A'));
                $this->session->set_userdata('info_planilla', 'La planilla con el sueldo S/. ' . $suel_pla . ' ha sido habilitado existosamente. Esta es su planilla actual.');
                header('Location: ' . base_url('ajustes'));
            } else {

                // VIEW ALL
                $data['page'] = 'Panel de configuraci&oacute;n';
                $data['container'] = $this->load->view('empleado/pago_view', $ajustes, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function get_vempleado() {
        $data = array();
        $productos = $this->mod_producto->get_vproducto();
        foreach ($productos as $row) {

            if ($row->fein_prod != NULL) {
                $fein_r = strtotime($row->fein_prod);
                $fein = date("d/m/y h:i:s A", $fein_r);
            } else {
                $fein = "-";
            }
            if ($row->fesa_prod != NULL) {
                $fesa_r = strtotime($row->fesa_prod);
                $fesa = date("d/m/y h:i:s A", $fesa_r);
            } else {
                $fesa = "-";
            }
            if ($row->obsv_prod != NULL) {
                $obsv = $row->obsv_prod;
            } else {
                $obsv = "-";
            }

            $data[$row->codi_prod] = array(
                $row->codi_prod,
                $row->nomb_prod,
                $row->nomb_tipo,
                $obsv,
                $row->codi_tpro,
                $row->esta_prod,
                $row->prec_prod,
                $row->stoc_prod,
                $fein,
                $fesa
            );
        }
        echo json_encode($data);
    }

    public function get_empleado_autocomplete() {
        $data = array();
        $productos = $this->mod_producto->get_vproducto(array('producto.stoc_prod >' => "0", 'esta_prod' => 'A'));
        foreach ($productos as $row) {
            $data[] = $row->nomb_prod;
        }
        echo json_encode($data);
    }

    public function paginate_empleado_pago() {
        $nTotal = $this->mod_view->count('planilla');
        $planillas = $this->mod_ajustes->get_planilla_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($planillas as $row) {
            $estado = "";
            $opciones = "";
            if ($row->esta_pla == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url('ajustes'), $form_a) . ' 
                                <input type="hidden" name="codi_pla" value="' . $row->codi_pla . '">
                                <input type="hidden" name="suel_pla" value="' . $row->suel_pla . '">
                                <input name="activar_planilla" type="submit" class="tooltip_planilla btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar esta planilla">
                                ' . form_close() . '
                            </span>';
            } else if ($row->esta_pla == "A") {
                $estado = "Planilla vigente";
                $opciones = '<button type="button" class="tooltip_planilla btn btn-success btn-circle editar_planilla" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-edit"></i>
                        </button>';
            }
            $opciones .= "<script>$('.tooltip_planilla').tooltip();</script>";

            $time = strtotime($row->fech_pla);
            $fecha = date("d/m/Y g:i A", $time);

            $observa = "-";
            if ($row->obsv_pla != "") {
                $observa = $row->obsv_pla;
            }

            $aaData[] = array(
                $row->codi_pla,
                $fecha,
                $row->suel_pla,
                $observa,
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

}
