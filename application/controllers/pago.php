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
            $pago['datetime'] = date('Y-m-d H:i:s');

            if ($this->input->post('activar_pago')) {
                $codi_pago = $this->input->post('codi_pla');
                $this->mod_registro->registro_diario_dia_edit($codi_pago, array('esta_dpl' => 'A'));
                $this->session->set_userdata('info_planilla', 'El registro de pago ha sido habilitado existosamente. Vuelva a filtrar la busqueda');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('desactivar_pago')) {
                $codi_pago = $this->input->post('codi_pla');
                $this->mod_registro->registro_diario_dia_edit($codi_pago, array('esta_dpl' => 'D'));
                $this->session->set_userdata('info_planilla', 'El registro de pago ha sido deshabilitado existosamente. Vuelva a filtrar la busqueda');
                header('Location: ' . base_url('ajustes'));
            } else {
                // VIEW ALL
                $data['page'] = 'Panel de configuraci&oacute;n';
                $pago['empleado'] = $this->mod_view->view('empleado', false, false, array('esta_emp' => 'A'));
                $data['container'] = $this->load->view('empleado/pago_view', $pago, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function get_vempleado() {
        $data = array();
        $empleados = $this->mod_empleado->get_vempleado();
        foreach ($empleados as $row) {

            $dias_pago = $this->mod_view->count('registro_planilla', false, false, array('codi_emp' => $row->codi_emp));
            $prod_pago = $this->mod_empleado->sum_pago($row->codi_emp, 'cant_dpl');
            $suto_pago = $this->mod_empleado->sum_pago($row->codi_emp, 'suto_dpl');
            $desc_pago = $this->mod_empleado->sum_pago($row->codi_emp, 'desc_dpl');
            $tota_pago = number_format($suto_pago - $desc_pago, 2);

            $data[$row->codi_emp] = array(
                $row->codi_tem,
                $row->nomb_emp,
                $row->apel_emp,
                $row->nomb_tem,
                $row->fech_pla,
                $row->suel_pla,
                $dias_pago,
                $prod_pago,
                $suto_pago,
                $desc_pago,
                $tota_pago,
                $row->esta_emp
            );
        }
        echo json_encode($data);
    }

    public function get_empleado_autocomplete() {
        $data = array();
        $empleados = $this->mod_view->view('empleado', false, false, array('esta_emp' => 'A'));
        foreach ($empleados as $row) {
            $data[] = $row->nomb_emp;
        }
        echo json_encode($data);
    }

    public function input_2() {
        $fecha = $this->input->post('month_2');
        $tipo = $this->input->post('type_2');
        $codi_emp = $this->input->post('codi_emp');
        $this->session->set_userdata('input_reporte_2', $fecha);
        $this->session->set_userdata('type_2', $tipo);
        $this->session->set_userdata('codi_emp', $codi_emp);
    }

    public function get_v_empleado_paginate() {
        $tipo = $this->session->userdata('type_2');
        $codi_emp = $this->session->userdata('codi_emp');
        $aaData = array();
        $form_regdiario = array('role' => 'form', "style" => "display: inline-block;");

        if ($tipo == "0") {
            $registros = $this->mod_view->view('v_registro_planilla', 0, false, array('codi_emp' => $codi_emp, 'esta_dpl' => 'A'));
            $nTotal = count($registros);
            

            foreach ($registros as $row) {

                $estado = $row->esta_dpl == 'A' ? 'Activo' : 'Oculto';

                $opciones = '';
                if ($this->session->userdata('user_rol') == 1) {
                    $opciones .= '<button type="button" class="tooltip_registrodiario btn btn-success btn-circle editar_registrodiario" data-toggle="tooltip" data-placement="top" title="Editar registro">
                                <i class="fa fa-edit"></i><input type="hidden" value="' . $row->codi_dpl . '">
                            </button>&nbsp;';
                    if ($estado == 'Oculto') {
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_regdiario) . ' 
                                        <input type="hidden" name="codi_dpl" value="' . $row->codi_dpl . '">
                                        <input name="activar_pago" type="submit" class="tooltip_registrodiario btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Activar pago">
                                        ' . form_close() . '
                                    </span>';
                    } else {
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_regdiario) . ' 
                                        <input type="hidden" name="codi_dpl" value="' . $row->codi_dpl . '">
                                        <input name="desactivar_pago" type="submit" class="tooltip_registrodiario btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Ocultar pago">
                                        ' . form_close() . '
                                    </span>';
                    }
                } else {
                    $opciones = '<button type="button" class="btn btn-default btn-circle disabled"><i class="glyphicon glyphicon-ban-circle"></i></button>&nbsp;';
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
        } else if ($tipo == "1") {
            $dates = str_replace('/', '-', $this->session->userdata('input_reporte_2'));
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($this->session->userdata('input_reporte_2'), 0, 10) == substr($this->session->userdata('input_reporte_2'), 13)) {
                $registros = $this->mod_empleado->get_pago_interval("codi_emp = '$codi_emp' AND DATE(fech_dpl) = '$fecha_a' AND esta_dpl = 'A'");
            } else {
                $registros = $this->mod_empleado->get_pago_interval("codi_emp = '$codi_emp' AND fech_dpl BETWEEN '$fecha_a'  AND '$fecha_b' AND esta_dpl = 'A'");
            }
            $nTotal = count($registros);


            foreach ($registros as $row) {
                $estado = $row->esta_dpl == 'A' ? 'Activo' : 'Oculto';

                $opciones = '';
                if ($this->session->userdata('user_rol') == 1) {
                    $opciones .= '<button type="button" class="tooltip_registrodiario btn btn-success btn-circle editar_registrodiario" data-toggle="tooltip" data-placement="top" title="Editar registro">
                                <i class="fa fa-edit"></i><input type="hidden" value="' . $row->codi_dpl . '">
                            </button>&nbsp;';
                    if ($estado == 'Oculto') {
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_regdiario) . ' 
                                        <input type="hidden" name="codi_dpl" value="' . $row->codi_dpl . '">
                                        <input name="activar_pago" type="submit" class="tooltip_registrodiario btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Activar pago">
                                        ' . form_close() . '
                                    </span>';
                    } else {
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_regdiario) . ' 
                                        <input type="hidden" name="codi_dpl" value="' . $row->codi_dpl . '">
                                        <input name="desactivar_pago" type="submit" class="tooltip_registrodiario btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Ocultar pago">
                                        ' . form_close() . '
                                    </span>';
                    }
                } else {
                    $opciones = '<button type="button" class="btn btn-default btn-circle disabled"><i class="glyphicon glyphicon-ban-circle"></i></button>&nbsp;';
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

//                $aaData[] = array(
//                    '1',
//                    '2',
//                    '3',
//                    '4',
//                    '5',
//                    '6',
//                    '7',
//                    '8',
//                    '9',
//                    '10',
//                );
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
