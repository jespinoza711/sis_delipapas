<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class registro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_empleado', 'mod_registro'));
        $this->load->library('session');
    }

    public function registro_diario() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $control['datetime'] = $this->mod_config->datetime_es();

            $error = array();
            $control['empleado'] = $this->mod_view->view('empleado', false, false, array('esta_emp' => 'A'));
            $control['planilla'] = $this->mod_view->one('planilla', false, false, array('esta_pla' => 'A'));

            if (count($control['empleado']) <= 0) {
                $error[] = 'Debe registrar por lo menos un empleado. <br><strong> Haga click <a href="' . base_url('empleado') . '"> aquí </a> para registrar un empleado </strong>.';
            }
            if (count($control['planilla']) <= 0) {
                $error[] = 'Debe registrar una planilla. <br><strong> Haga click <a href="' . base_url('planilla') . '"> aquí </a> para registrar una planilla </strong>.';
            }

            /* INSERT */
            $control['form_regdiario'] = array('role' => 'form', "id" => "form_regdiario");
            $control['suel_pla'] = array('id' => 'suel_pla', 'name' => 'suel_pla', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['cant_dpl'] = array('id' => 'cant_dpl', 'name' => 'cant_dpl', 'class' => "form-control", 'placeholder' => "Cantidad procesada", "maxlength" => "10", "min" => "1", 'required' => 'true', 'autocomplete' => 'off');
            $control['suto_dpl'] = array('id' => 'suto_dpl', 'name' => 'suto_dpl', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['desc_dpl'] = array('id' => 'desc_dpl', 'name' => 'desc_dpl', 'class' => "form-control", 'placeholder' => "Descuento observado", "maxlength" => "10", "min" => "0", 'required' => 'true', 'autocomplete' => 'off');
            $control['tota_dpl'] = array('id' => 'tota_dpl', 'name' => 'tota_dpl', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['obsv_dpl'] = array('id' => 'obsv_dpl', 'name' => 'obsv_dpl', 'class' => "form-control", "maxlength" => "500", "autocomplete" => "off", "rows" => "3");
            $control['registrodiario'] = array('id' => 'registrodiario', 'name' => 'registrodiario', 'class' => "btn btn-primary", 'value' => "Registrar día de trabajo");
            /* UPDATE */
            $control['form_regdiario_edit'] = array('role' => 'form', "id" => "form_regdiario_edit");
            $control['codi_dpl_e'] = array('id' => 'codi_dpl_e', 'name' => 'codi_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
            $control['fech_dpl_e'] = array('id' => 'fech_dpl_e', 'name' => 'fech_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
            $control['nomb_emp_e'] = array('id' => 'nomb_emp_e', 'name' => 'nomb_emp_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
            $control['suel_pla_e'] = array('id' => 'suel_pla_e', 'name' => 'suel_pla_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['cant_dpl_e'] = array('id' => 'cant_dpl_e', 'name' => 'cant_dpl_e', 'class' => "form-control", 'placeholder' => "Cantidad procesada", "maxlength" => "10", "min" => "1", 'required' => 'true', 'autocomplete' => 'off');
            $control['suto_dpl_e'] = array('id' => 'suto_dpl_e', 'name' => 'suto_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['desc_dpl_e'] = array('id' => 'desc_dpl_e', 'name' => 'desc_dpl_e', 'class' => "form-control", 'placeholder' => "Descuento observado", "maxlength" => "10", "min" => "0", 'required' => 'true', 'autocomplete' => 'off');
            $control['tota_dpl_e'] = array('id' => 'tota_dpl_e', 'name' => 'tota_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['obsv_dpl_e'] = array('id' => 'obsv_dpl_e', 'name' => 'obsv_dpl_e', 'class' => "form-control", "maxlength" => "500", "autocomplete" => "off", "rows" => "3");
            $control['registrodiario_edit'] = array('id' => 'registrodiario_edit', 'name' => 'registrodiario_edit', 'class' => "btn btn-primary", 'value' => "Actualizar día de trabajo");

            if (count($error) > 0) {
                $info["encabezado"] = "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!";
                $info["panel"] = 'yellow';
                $info["cuerpo"] = $error;
                $data['container'] = $this->load->view('error', $info, true);
            } else {
                $data['container'] = $this->load->view('empleado/registrodiario_view', $control, true);
            }

            $data['page'] = 'Control di&aacute;rio de personal';
            $this->load->view('home/body', $data);
        }
    }

    public function registro_diario_dia() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $data['codi_emp'] = $this->input->post('codi_emp');
            $control = $this->mod_view->count('v_registro_planilla', false, false, array('codi_emp' => $data['codi_emp'], 'DATE(fech_dpl)' => $date));

            if ($control > 0) {
                $this->session->set_userdata('error', 'Ya se ha registrado el pago de hoy para este empleado.');
            } else {
                $data['codi_usu'] = $this->session->userdata('user_codi');
                $data['suel_pla'] = $this->input->post('suel_pla');
                $data['cant_dpl'] = $this->input->post('cant_dpl');
                $data['suto_dpl'] = $this->input->post('suto_dpl');
                $data['desc_dpl'] = $this->input->post('desc_dpl');
                $data['tota_dpl'] = $this->input->post('tota_dpl');
                $data['obsv_dpl'] = $this->input->post('obsv_dpl');
                $data['esta_dpl'] = 'A';

                if ($this->mod_registro->registro_diario_dia($data)) {
                    $this->session->set_userdata('info', 'Se ha registrado el pago di&aacute;rio exitosamente.');
                } else {
                    $this->session->set_userdata('error', 'No ha sido posible el registro di&aacute;rio, verifique los datos proporcionados.');
                }
            }
            header('Location: ' . base_url('registrodiario'));
        }
    }

    public function registro_diario_dia_edit() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            $codi_dpl = $this->input->post('codi_dpl_e');
            $data['suel_pla'] = $this->input->post('suel_pla_e');
            $data['cant_dpl'] = $this->input->post('cant_dpl_e');
            $data['suto_dpl'] = $this->input->post('suto_dpl_e');
            $data['desc_dpl'] = $this->input->post('desc_dpl_e');
            $data['tota_dpl'] = $this->input->post('tota_dpl_e');
            $data['obsv_dpl'] = $this->input->post('obsv_dpl_e');

            if ($this->mod_registro->registro_diario_dia_edit($codi_dpl, $data)) {
                $this->session->set_userdata('info', 'Se ha actualizado el pago di&aacute;rio exitosamente.');
            } else {
                $this->session->set_userdata('error', 'No ha sido posible actualizar el registro di&aacute;rio, verifique los datos proporcionados.');
            }
            header('Location: ' . base_url('registrodiario'));
        }
    }

    public function get_registro_diario_dia() {
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $data = array();
        $control = $this->mod_view->view('v_registro_planilla', false, false, array('fech_dpl' => $date));
        foreach ($control as $row) {
            $data[$row->codi_dpl] = array(
                $row->codi_dpl,
                $row->fech_dpl,
                $row->nomb_usu,
                $row->nomb_emp . ' ' . $row->apel_emp,
                $row->suel_pla,
                $row->cant_dpl,
                $row->suto_dpl,
                $row->desc_dpl,
                $row->tota_dpl,
                $row->obsv_dpl
            );
        }
        echo json_encode($data);
    }

    public function paginate_registro_diario_dia() {
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $nTotal = $this->mod_view->count('v_registro_planilla', false, false, array('DATE(fech_dpl)' => $date));
        $control = $this->mod_registro->get_registro_diario_dia_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $aaData = array();

        foreach ($control as $row) {

            $opciones = '<a href="' . base_url('pagoempleado/' . $row->codi_emp) . '"><button type="button" class="tooltip_registrodiario btn btn-primary btn-circle ver_historial_empleado" data-toggle="tooltip" data-placement="top" title="Ver historial de pago">
                            <i class="glyphicon glyphicon-time"></i>
                        </button></a>';

            if ($this->session->userdata('user_rol') == 1) {
                $opciones .= '&nbsp;<button type="button" class="tooltip_registrodiario btn btn-success btn-circle editar_registrodiario" data-toggle="tooltip" data-placement="top" title="Editar registro">
                            <i class="fa fa-edit"></i><input type="hidden" value="' . $row->codi_dpl . '">
                        </button>';
            }
            $opciones .= "<script>$('.tooltip_registrodiario').tooltip(); $('.popover-reg').popover();</script>";

            $time = strtotime($row->fech_dpl);
            $fecha = date("d/m/Y g:i A", $time);

            $observa = "-";
            if ($row->obsv_dpl != "") {
                $observa = '<button type="button" class="popover-reg btn btn-default" data-toggle="popover" data-content="' . $row->obsv_dpl . '" data-original-title="Observación" data-placement="top"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;Ver</button>'
                        . '<input type="hidden" value="' . $row->obsv_dpl . '">';
            }

            $aaData[] = array(
                $fecha,
                $row->nomb_usu,
                $row->nomb_emp . ' ' . $row->apel_emp,
                $row->suel_pla,
                $row->cant_dpl,
                $row->suto_dpl,
                $row->desc_dpl,
                $row->tota_dpl,
                $observa,
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

    public function paginate_report() {

        $tipo = $this->session->userdata('type_10');

        $aaData = array();

        if ($tipo == "0") {
            $nTotal = $this->mod_view->count('registro_planilla', 0, false, array());
            $registro = $this->mod_view->view('v_registro_planilla', 0, false, array());
            
            $i = 1;
            foreach ($registro as $row) {
                $time = strtotime($row->fech_dpl);
                $fecha = date("d/m/Y g:i A", $time);
                $aaData[] = array(
                    $i,
                    $fecha,
                    $row->nomb_usu,
                    $row->apel_emp . ', ' . $row->nomb_emp,
                    $row->cant_dpl . ' Kls',
                    'S/. ' . $row->suel_pla,
                    'S/. ' . $row->suto_dpl,
                    'S/. ' . $row->desc_dpl,
                    'S/. ' . $row->tota_dpl
                );
                $i++;
            }
        } else if ($tipo == "1") {
            $dates = str_replace('/', '-', $this->session->userdata('input_reporte_10'));
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($this->session->userdata('input_reporte_10'), 0, 10) == substr($this->session->userdata('input_reporte_10'), 13)) {
                $registro = $this->mod_registro->get_registro_interval("DATE(fech_dpl) = '$fecha_a'");
            } else {
                $registro = $this->mod_registro->get_registro_interval("fech_dpl BETWEEN '$fecha_a'  AND '$fecha_b'");
            }


            $nTotal = count($registro);

            $i = 1;
            foreach ($registro as $row) {
                $time = strtotime($row->fech_dpl);
                $fecha = date("d/m/Y g:i A", $time);
                $aaData[] = array(
                    $i,
                    $fecha,
                    $row->nomb_usu,
                    $row->apel_emp . ', ' . $row->nomb_emp,
                    $row->cant_dpl . ' Kls',
                    'S/. ' . $row->suel_pla,
                    'S/. ' . $row->suto_dpl,
                    'S/. ' . $row->desc_dpl,
                    'S/. ' . $row->tota_dpl
                );
                $i++;
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
