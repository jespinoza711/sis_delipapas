<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pago extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_empleado', 'mod_registro'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $pago['datetime'] = date('Y-m-d H:i:s');

            if ($this->input->post('activar_pago')) {
                $codi_dpl = $this->input->post('codi_dpl');
                $this->mod_registro->registro_diario_dia_edit($codi_dpl, array('esta_dpl' => 'A'));
                $this->session->set_userdata('info', 'El registro de pago ha sido habilitado existosamente. Vuelva a filtrar la busqueda');
                header('Location: ' . base_url('pago'));
            } else if ($this->input->post('desactivar_pago')) {
                $codi_dpl = $this->input->post('codi_dpl');
                $this->mod_registro->registro_diario_dia_edit($codi_dpl, array('esta_dpl' => 'D'));
                $this->session->set_userdata('info', 'El registro de pago ha sido deshabilitado existosamente. Vuelva a filtrar la busqueda');
                header('Location: ' . base_url('pago'));
            } else {
                /* UPDATE */
                $pago['form_regdiario_edit'] = array('role' => 'form', "id" => "form_regdiario_edit");
                $pago['codi_dpl_e'] = array('id' => 'codi_dpl_e', 'name' => 'codi_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $pago['fech_dpl_e'] = array('id' => 'fech_dpl_e', 'name' => 'fech_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $pago['nomb_emp_e'] = array('id' => 'nomb_emp_e', 'name' => 'nomb_emp_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $pago['suel_pla_e'] = array('id' => 'suel_pla_e', 'name' => 'suel_pla_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
                $pago['cant_dpl_e'] = array('id' => 'cant_dpl_e', 'name' => 'cant_dpl_e', 'class' => "form-control", 'placeholder' => "Cantidad procesada", "maxlength" => "10", "min" => "1", 'required' => 'true', 'autocomplete' => 'off');
                $pago['suto_dpl_e'] = array('id' => 'suto_dpl_e', 'name' => 'suto_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
                $pago['desc_dpl_e'] = array('id' => 'desc_dpl_e', 'name' => 'desc_dpl_e', 'class' => "form-control", 'placeholder' => "Descuento observado", "maxlength" => "10", "min" => "0", 'required' => 'true', 'autocomplete' => 'off');
                $pago['tota_dpl_e'] = array('id' => 'tota_dpl_e', 'name' => 'tota_dpl_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
                $pago['obsv_dpl_e'] = array('id' => 'obsv_dpl_e', 'name' => 'obsv_dpl_e', 'class' => "form-control", "maxlength" => "500", "autocomplete" => "off", "rows" => "3");
                $pago['registrodiario_edit'] = array('id' => 'registrodiario_edit', 'name' => 'registrodiario_edit', 'class' => "btn btn-primary", 'value' => "Actualizar día de trabajo");
                // VIEW ALL
                $data['page'] = 'Control de pagos';
                $pago['planilla'] = $this->mod_view->one('planilla', false, false, array('esta_pla' => 'A'));
                $pago['empleado'] = $this->mod_view->view('empleado', false, false, array('esta_emp' => 'A'));
                $data['container'] = $this->load->view('empleado/pago_view', $pago, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function pago_dia() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $pago['datetime'] = date('Y-m-d H:i:s');

            if ($this->input->post('activar_pago')) {
                $codi_dpl = $this->input->post('codi_dpl');
                $this->mod_registro->registro_diario_dia_edit($codi_dpl, array('esta_dpl' => 'A'));
                $this->session->set_userdata('info', 'El registro de pago ha sido habilitado existosamente. Vuelva a filtrar la busqueda');
                header('Location: ' . base_url('registrodiario'));
            } else if ($this->input->post('desactivar_pago')) {
                $codi_dpl = $this->input->post('codi_dpl');
                $this->mod_registro->registro_diario_dia_edit($codi_dpl, array('esta_dpl' => 'D'));
                $this->session->set_userdata('info', 'El registro de pago ha sido deshabilitado existosamente. Vuelva a filtrar la busqueda');
                header('Location: ' . base_url('registrodiario'));
            } else {
                header('Location: ' . base_url('registrodiario'));
            }
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
            header('Location: ' . base_url('pago'));
        }
    }

    public function get_vempleado() {
        $date_filter = $this->input->post('input');
        $type_filter = $this->input->post('type');
        $codi_emp = $this->input->post('codi_emp');
        $data = array();
        $empleados = $this->mod_empleado->get_vempleado(array('codi_emp' => $codi_emp));

        if ($type_filter == '0') {
            $registros = $this->mod_view->view('v_registro_planilla', false, false, array('codi_emp' => $codi_emp, 'esta_dpl' => 'A'));
            $dias_pago = count($registros);
            $prod_pago = 0;
            $suto_pago = 0;
            $desc_pago = 0;

            foreach ($registros as $r) {
                $prod_pago += $r->cant_dpl;
                $suto_pago += $r->suto_dpl;
                $desc_pago += $r->desc_dpl;
            }
            $tota_pago = number_format($suto_pago - $desc_pago, 2);

            foreach ($empleados as $row) {
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
        } else {
            $dates = str_replace('/', '-', $date_filter);
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($date_filter, 0, 10) == substr($date_filter, 13)) {
                $registros = $this->mod_empleado->get_pago_interval("codi_emp = '$codi_emp' AND DATE(fech_dpl) = '$fecha_a' AND esta_dpl = 'A'");
            } else {
                $registros = $this->mod_empleado->get_pago_interval("codi_emp = '$codi_emp' AND fech_dpl BETWEEN '$fecha_a' AND '$fecha_b' AND esta_dpl = 'A'");
            }

            $dias_pago = count($registros);
            $prod_pago = 0;
            $suto_pago = 0;
            $desc_pago = 0;

            foreach ($registros as $r) {
                $prod_pago += $r->cant_dpl;
                $suto_pago += $r->suto_dpl;
                $desc_pago += $r->desc_dpl;
            }
            $tota_pago = number_format($suto_pago - $desc_pago, 2);

            foreach ($empleados as $row) {
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
        }
        echo json_encode($data);
    }

    public function input_filtar_pago() {
        $date_filter = $this->input->post('input');
        $type_filter = $this->input->post('type');
        $codi_emp = $this->input->post('codi_emp');
        $this->session->set_userdata('date_filter', $date_filter);
        $this->session->set_userdata('type_filter', $type_filter);
        $this->session->set_userdata('codi_emp', $codi_emp);
    }

    public function get_v_empleado_paginate() {
        $type_filter = $this->session->userdata('type_filter');
        $date_filter = $this->session->userdata('date_filter');
        $codi_emp = $this->session->userdata('codi_emp');
        $form_rdp = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        if ($type_filter == "0") {
            $registros = $this->mod_view->view('v_registro_planilla', 0, false, array('codi_emp' => $codi_emp));
            $nTotal = count($registros);

            foreach ($registros as $row) {

                $estado = $row->esta_dpl == 'A' ? 'Activo' : 'Oculto';

                $opciones = '';
                if ($this->session->userdata('user_rol') == 1) {
                    $opciones .= '<button type="button" class="tooltip_registrodiario btn btn-success btn-circle editar_registrodiario" data-toggle="tooltip" data-placement="top" title="Editar registro">
                                <i class="fa fa-edit"></i><input type="hidden" value="' . $row->codi_dpl . '">
                            </button>&nbsp;';
                    if ($estado == 'Oculto') {
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_rdp) . ' 
                                        <input type="hidden" name="codi_dpl" value="' . $row->codi_dpl . '">
                                        <input name="activar_pago" type="submit" class="tooltip_registrodiario btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Activar pago">
                                        ' . form_close() . '
                                    </span>';
                    } else {
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_rdp) . ' 
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
                    $estado,
                    $opciones
                );
            }
        } else if ($type_filter == "1") {
            $dates = str_replace('/', '-', $date_filter);
            $fecha_a = date('Y-m-d', strtotime(substr($dates, 0, 10)));
            $fecha_b = date('Y-m-d', strtotime(substr($dates, 13)) + 86400);

            if (substr($date_filter, 0, 10) == substr($date_filter, 13)) {
                $registros = $this->mod_empleado->get_pago_interval("codi_emp = '$codi_emp' AND DATE(fech_dpl) = '$fecha_a'");
            } else {
                $registros = $this->mod_empleado->get_pago_interval("codi_emp = '$codi_emp' AND fech_dpl BETWEEN '$fecha_a'  AND '$fecha_b'");
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
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_rdp) . ' 
                                        <input type="hidden" name="codi_dpl" value="' . $row->codi_dpl . '">
                                        <input name="activar_pago" type="submit" class="tooltip_registrodiario btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Activar pago">
                                        ' . form_close() . '
                                    </span>';
                    } else {
                        $opciones .= '<span>' . form_open(base_url('pago'), $form_rdp) . ' 
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
                    $estado,
                    $opciones
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
