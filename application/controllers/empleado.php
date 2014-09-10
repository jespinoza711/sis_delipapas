<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class empleado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_empleado'));
        $this->load->library('session');
    }

    // Prueba
    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $fecha_actual = date("d/m/Y");
            $datetime = date("Y-m-d H:i:s");
            $año_actual = date("Y");
            $empleado['fecha'] = $fecha_actual;

            if ($this->input->post('registrar')) {
                $nomb_emp = $this->input->post('nombre');
                $apel_emp = $this->input->post('apellido');
                $dire_emp = $this->input->post('direccion');
                $dni_emp = $this->input->post('dni');
                $telefono_emp = $this->input->post('telefono');
                $sexo_emp = $this->input->post('sexo');
                $civil_emp = $this->input->post('civil');
                $afp_emp = $this->input->post('afp');
                $tipo_emp = $this->input->post('tipo_emp');
                $plan_emp = $this->input->post('plan_emp');

                $data = array(
                    'nomb_emp' => $nomb_emp,
                    'apel_emp' => $apel_emp,
                    'dire_emp' => $dire_emp,
                    'dni_emp' => $dni_emp,
                    'telf_emp' => $telefono_emp,
                    'sexo_emp' => $sexo_emp,
                    'afp_emp' => $afp_emp,
                    'civi_emp' => $civil_emp,
                    'codi_tem' => $tipo_emp,
                    'codi_pla' => $plan_emp,
                    'esta_emp' => 'A'
                );
                $this->mod_empleado->insert($data);
                $this->session->set_userdata('mensaje_emp', 'El empleado ' . $nomb_emp . ' ' . $apel_emp . ' ha sido registrado existosamente');
                $this->session->set_userdata('ripo_mensaje_emp', 'success');
                header('Location: ' . base_url('empleado'));
            } else if ($this->input->post('editar')) {
                // REGISTRO MODIFICADO
                $codigo = $this->input->post('codigo');
                $nomb = $this->input->post('nombre');
                $apel = $this->input->post('apellido');
                $dire = $this->input->post('direccion');
                $dni = $this->input->post('dni');
                $telefono = $this->input->post('telefono');
                $sexo = $this->input->post('sexo_e');
                $civil = $this->input->post('civil_e');
                $afp = $this->input->post('afp');
                $tipo = $this->input->post('tipo_emp');
                $plan = $this->input->post('plan_emp');

                $data = array(
                    'nomb_emp' => $nomb,
                    'apel_emp' => $apel,
                    'dire_emp' => $dire,
                    'dni_emp' => $dni,
                    'telf_emp' => $telefono,
                    'sexo_emp' => $sexo,
                    'afp_emp' => $afp,
                    'civi_emp' => $civil,
                    'codi_tem' => $tipo,
                    'codi_pla' => $plan
                );

                $this->mod_empleado->update($codigo, $data);
                $this->session->set_userdata('mensaje_emp', 'El empleado ' . $this->input->post('nombre') . ' ' . $this->input->post('apellido') . ' ha sido actualizado existosamente');
                $this->session->set_userdata('ripo_mensaje_emp', 'success');
                header('Location: ' . base_url('empleado'));
            } else if ($this->input->post('activar')) {
                $codigo = $this->input->post('codigo');
                $empleado_desc = $this->input->post('empleado');
                $this->mod_empleado->update($codigo, array("esta_emp" => "A"));
                $this->session->set_userdata('mensaje_emp', 'El empleado ' . $empleado_desc . ' ha sido habilitado existosamente');
                $this->session->set_userdata('ripo_mensaje_emp', 'success');
                header('Location: ' . base_url('empleado'));
            } else if ($this->input->post('desactivar')) {
                $codigo = $this->input->post('codigo');
                $empleado_desc = $this->input->post('empleado');
                $this->mod_empleado->update($codigo, array("esta_emp" => "D"));
                $this->session->set_userdata('mensaje_emp', 'El empleado ' . $empleado_desc . ' ha sido deshabilitado existosamente');
                $this->session->set_userdata('ripo_mensaje_emp', 'success');
                header('Location: ' . base_url('empleado'));
            } else if ($this->input->post('registrar_temp')) {
                $nomb_temp = $this->input->post('nombre_tipo');
                $data = array(
                    'nomb_tem' => $nomb_temp,
                    'esta_tem' => 'A'
                );
                $this->mod_empleado->insert_tipo($data);
                $this->session->set_userdata('mensaje_emp', 'El tipo de empleado ' . $nomb_temp . ' ha sido registrado existosamente');
                $this->session->set_userdata('ripo_mensaje_emp', 'success');
                header('Location: ' . base_url('empleado'));
            } else if ($this->input->post('registrar_pla')) {
                $sueldo = $this->input->post('sueldo');
                $observacion = $this->input->post('observa');
                $data = array(
                    'fech_pla' => $datetime,
                    'suel_pla' => str_replace(",", "", $sueldo),
                    'esta_pla' => 'A'
                );
                if ($observacion && $observacion != "") {
                    $data['obsv_pla'] = $observacion;
                }
                $this->mod_empleado->insert_pla($data);
                $this->session->set_userdata('mensaje_emp', 'La planilla de la fecha ' . $fecha_actual . ' ha sido registrado existosamente');
                $this->session->set_userdata('ripo_mensaje_emp', 'success');
                header('Location: ' . base_url('empleado'));
            } else {
                $empleado["form"] = array('role' => 'form', "id" => "form_emp");
                $empleado["form_editar"] = array('role' => 'form', "id" => "form_emp_edit");
                $empleado["form_tipo"] = array('role' => 'form', "id" => "form_tem");
                $empleado["form_pla"] = array('role' => 'form', "id" => "form_pla");
                $empleado["form_a"] = array('role' => 'form', "style" => "display: inline-block;");
                $empleado["nombre"] = array('id' => 'nomb_emp', 'name' => 'nombre', 'class' => "form-control", 'placeholder' => "Nombres", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $empleado["nombre_tipo"] = array('id' => 'nomb_temp', 'name' => 'nombre_tipo', 'class' => "form-control", 'placeholder' => "Nombres", "maxlength" => "45", 'required' => 'true', "pattern" => ".{6,}", "title" => "Debe contener mínimo 6 carácteres", 'autocomplete' => 'off');
                $empleado["apellido"] = array('id' => 'apel_emp', 'name' => 'apellido', 'class' => "form-control", 'placeholder' => "Apellidos", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $empleado["dni"] = array('id' => 'dni_emp', 'name' => 'dni', 'class' => "form-control", 'placeholder' => "D.N.I.", "maxlength" => "8", 'required' => 'true', "autocomplete" => "off", "title" => "Debe contener 8 dígitos", "pattern" => ".{8,}");
                $empleado["telefono"] = array('id' => 'telefono_emp', 'name' => 'telefono', 'class' => "form-control", 'placeholder' => "Teléfono", 'required' => 'true', 'autocomplete' => 'off');
                $empleado["direccion"] = array('id' => 'direccion_emp', 'name' => 'direccion', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', "autocomplete" => "off");
                $empleado["masculino"] = array('id' => 'masculino_emp', 'name' => 'sexo', "value" => "M", 'required' => "true");
                $empleado["femenino"] = array('id' => 'femenino_emp', 'name' => 'sexo', "value" => "F", 'required' => "true");
                $empleado["soltero"] = array('id' => 'soltero_emp', 'name' => 'civil', "value" => "S", 'required' => "true");
                $empleado["casado"] = array('id' => 'casado_emp', 'name' => 'civil', "value" => "C", 'required' => "true");
                $empleado["divorciado"] = array('id' => 'divorciado_emp', 'name' => 'civil', "value" => "D", 'required' => "tr1ue");
                // editar
                $empleado["codigo_e"] = array('id' => 'codigo_emp_e', 'name' => 'codigo', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $empleado["nombre_e"] = array('id' => 'nomb_emp_e', 'name' => 'nombre', 'class' => "form-control", 'placeholder' => "Nombres", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $empleado["apellido_e"] = array('id' => 'apel_emp_e', 'name' => 'apellido', 'class' => "form-control", 'placeholder' => "Apellidos", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $empleado["dni_e"] = array('id' => 'dni_emp_e', 'name' => 'dni', 'class' => "form-control", 'placeholder' => "D.N.I.", "maxlength" => "8", 'required' => 'true', "autocomplete" => "off", "title" => "Debe contener 8 dígitos", "pattern" => ".{8,}");
                $empleado["telefono_e"] = array('id' => 'telefono_emp_e', 'name' => 'telefono', 'class' => "form-control", 'placeholder' => "Teléfono", 'required' => 'true', 'autocomplete' => 'off');
                $empleado["direccion_e"] = array('id' => 'direccion_emp_e', 'name' => 'direccion', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', "autocomplete" => "off");
                $empleado["masculino_e"] = array('id' => 'masculino_emp_e', 'name' => 'sexo_e', "value" => "M", 'required' => "true");
                $empleado["femenino_e"] = array('id' => 'femenino_emp_e', 'name' => 'sexo_e', "value" => "F", 'required' => "true");
                $empleado["soltero_e"] = array('id' => 'soltero_emp_e', 'name' => 'civil_e', "value" => "S", 'required' => "true");
                $empleado["casado_e"] = array('id' => 'casado_emp_e', 'name' => 'civil_e', "value" => "C", 'required' => "true");
                $empleado["divorciado_e"] = array('id' => 'divorciado_emp_e', 'name' => 'civil_e', "value" => "D", 'required' => "tr1ue");
                $empleado["disabled"] = "";
                $empleado["registrar"] = array('id' => 'registrar_emp', 'name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");
                $empleado["registrar_temp"] = array('id' => 'registrar_temp', 'name' => 'registrar_temp', 'class' => "btn btn-primary", 'value' => "Registrar");
                $empleado["registrar_pla"] = array('id' => 'registrar_pla', 'name' => 'registrar_pla', 'class' => "btn btn-primary", 'value' => "Registrar");
                $empleado["editar"] = array('id' => 'editar_emp', 'name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");


                $planilla = $this->mod_view->view('planilla');
                $tipo_empleado = $this->mod_view->view('tipo_empleado');
                $empleado['empleados'] = $this->mod_empleado->get_vempleado();
                $empleado['tipo'] = array();
                $empleado['planilla'] = array();
                $tipo = array();
                $plan = array();

                $error_pla = false;
                $error_tip = false;
                if (count($planilla) <= 0) {
                    $error_pla = true;
                }
                foreach ($planilla as $row) {
                    $phpdate = strtotime($row->fech_pla);
                    $date = date('d/m/Y', $phpdate);
                    $plan[$row->codi_pla] = $date . ' - S/. ' . $row->suel_pla;
                }
                $empleado['planilla'] = $plan;
                if (count($tipo_empleado) <= 0) {
                    $error_tip = true;
                }
                foreach ($tipo_empleado as $row) {
                    $tipo[$row->codi_tem] = $row->nomb_tem;
                }
                $empleado['tipo'] = $tipo;
                $empleado['tipo_empleado'] = $tipo_empleado;
                if ($error_tip || $error_pla) {
                    $empleado["nombre"]['disabled'] = 'true';
                    $empleado["apellido"]['disabled'] = 'true';
                    $empleado["dni"]['disabled'] = 'true';
                    $empleado["telefono"]['disabled'] = 'true';
                    $empleado["direccion"] ['disabled'] = 'true';
                    $empleado["masculino"]['disabled'] = 'true';
                    $empleado["femenino"]['disabled'] = 'true';
                    $empleado["soltero"]['disabled'] = 'true';
                    $empleado["casado"]['disabled'] = 'true';
                    $empleado["divorciado"]['disabled'] = 'true';
                    $empleado["disabled"] = 'disabled';
                    $empleado["registrar"]['disabled'] = 'true';
                }
                if ($error_pla && !$error_tip) {
                    $this->session->set_userdata('mensaje_nemp', 'Para registrar empleado debe registrar por lo menos una planilla');
                    $this->session->set_userdata('ripo_mensaje_nemp', 'danger');
                } else if (!$error_pla && $error_tip) {
                    $this->session->set_userdata('mensaje_nemp', 'Para registrar empleado debe registrar por lo menos un tipo de empleado');
                    $this->session->set_userdata('ripo_mensaje_nemp', 'danger');
                } else if ($error_pla && $error_tip) {
                    $this->session->set_userdata('mensaje_nemp', 'Para registrar empleado debe registrar por lo menos un tipo de empleado y una planilla');
                    $this->session->set_userdata('ripo_mensaje_nemp', 'danger');
                }

                $data['page'] = 'Empleados';
                $data['container'] = $this->load->view('empleado/empleado_view', $empleado, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function generar_registros($num) {
        for ($i = 0; $i < $num; $i++) {
            $data = array(
                'nomb_emp' => 'Robot',
                'apel_emp' => 'Testing',
                'dire_emp' => 'Virtual',
                'dni_emp' => '00000000',
                'telf_emp' => '999-999-999',
                'sexo_emp' => 'M',
                'afp_emp' => '10',
                'civi_emp' => 'S',
                'codi_tem' => "2",
                'codi_pla' => "1",
                'esta_emp' => 'A'
            );
            $this->mod_empleado->insert($data);
        }
    }

    public function paginate() {

        $nTotal = $this->mod_view->count('empleado');

        $empleados = $this->mod_empleado->get_vempleado_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

        $form_a = array('role' => 'form', "style" => "display: inline-block;");

        $aaData = array();

        foreach ($empleados as $row) {

            $opciones = '<button type="button" class="tooltip-emp btn btn-default btn-circle editar_emp" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </button>';
            if ($row->esta_emp == "D") {
                $opciones .= '<span>' . form_open(base_url() . 'empleado', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_emp . '">
                                                    <input type="hidden" name="empleado" value="' . $row->nomb_emp . ' ' . $row->apel_emp . '">
                                                    <input name="activar" type="submit" class="tooltip-emp btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                                    ' . form_close() . '
                                                </span>';
            } else if ($row->esta_emp == "A") {
                $opciones .= '<span>' . form_open(base_url() . 'empleado', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_emp . '">
                                                    <input type="hidden" name="empleado" value="' . $row->nomb_emp . ' ' . $row->apel_emp . '">
                                                    <input name="desactivar" type="submit" class="tooltip-emp btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                                    ' . form_close() . '
                                                </span>';
            }
            $opciones.="<script>$('.tooltip-emp').tooltip();</script>";

            $aaData[] = array(
                '<button type="button" class="tooltip-emp btn btn-primary btn-circle info_emp" data-toggle="tooltip" data-placement="top" title="Ver más info">
                    <i class="fa fa-chevron-down info_i"></i>
                 </button>',
                $row->codi_emp,
                $row->nomb_emp . ' ' . $row->apel_emp,
                $row->nomb_tem,
                'S/. ' . $row->suel_pla,
                $row->telf_emp,
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

    public function get_vempleado() {
        $data = array();
        $empleados = $this->mod_empleado->get_vempleado();
        foreach ($empleados as $row) {
            $data[$row->codi_emp] = array(
                $row->codi_emp,
                $row->nomb_emp,
                $row->apel_emp,
                $row->dire_emp,
                $row->dni_emp,
                $row->telf_emp,
                $row->sexo_emp,
                $row->afp_emp,
                $row->civi_emp,
                $row->esta_emp,
                $row->codi_pla,
                $row->codi_tem
            );
        }
        echo json_encode($data);
    }

    public function get_planillas() {
        date_default_timezone_set('America/Lima');
        $data = array();
        $planillas = $this->mod_empleado->planilla_año(date("Y"));
        foreach ($planillas as $row) {
            $data[$row->codi_pla] = array(
                $row->codi_pla,
                $row->fech_pla,
                $row->suel_pla,
                $row->obsv_pla,
                $row->esta_pla
            );
        }
        echo json_encode($data);
    }

    public function get_tipo_empleado() {
        $data = array();
        $tipo_empleado = $this->mod_view->view('tipo_empleado');
        foreach ($tipo_empleado as $row) {
            $data[$row->codi_tem] = array(
                $row->codi_tem,
                $row->esta_tem,
                $row->nomb_tem
            );
        }
        echo json_encode($data);
    }

}
