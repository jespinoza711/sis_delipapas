<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class empleado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_view', 'mod_empleado'));
        $this->load->library('session');
    }

    // Prueba
    public function index() {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {

            $empleado["form"] = array('role' => 'form', "id" => "form_emp");
            $empleado["form_editar"] = array('role' => 'form', "id" => "form_emp_edit");
            $empleado["form_a"] = array('role' => 'form', "style" => "display: inline-block;");
            $empleado["nombre"] = array('id' => 'nomb_emp', 'name' => 'nombre', 'class' => "form-control", 'placeholder' => "Nombres", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
            $empleado["apellido"] = array('id' => 'apel_emp', 'name' => 'apellido', 'class' => "form-control", 'placeholder' => "Apellidos", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
            $empleado["dni"] = array('id' => 'dni_emp', 'name' => 'dni', 'class' => "form-control", 'placeholder' => "D.N.I.", "maxlength" => "8", 'required' => 'true', "autocomplete" => "off", "title" => "Debe contener 8 dígitos", "pattern" => ".{8,}");
            $empleado["telefono"] = array('id' => 'telefono_emp', 'name' => 'telefono', 'class' => "form-control", 'placeholder' => "Teléfono", 'required' => 'true', 'autocomplete' => 'off');
            $empleado["direccion"] = array('id' => 'direccion_emp', 'name' => 'direccion', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', "autocomplete" => "off");
            $empleado["masculino"] = array('id' => 'masculino_emp', 'name' => 'sexo', "value" => "M", 'required' => "true");
            $empleado["femenino"] = array('id' => 'femenino_emp', 'name' => 'sexo', "value" => "F", 'required' => "true");
            $empleado["soltero"] = array('id' => 'soltero_emp', 'name' => 'civil', "value" => "S", 'required' => "true");
            $empleado["casado"] = array('id' => 'casado_emp', 'name' => 'civil', "value" => "C", 'required' => "true");
            $empleado["divorciado"] = array('id' => 'divorciado_emp', 'name' => 'civil', "value" => "D", 'required' => "tr1ue");
            $empleado["disabled"] = "";
            $empleado["registrar"] = array('id' => 'registrar_emp', 'name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");
//            $empleado["editar"] = array('name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");

            if ($this->input->post('registrar')) {
                $nomb_emp = $this->input->post('nombre');
                $apel_emp = $this->input->post('apellido');
                $dire_emp = $this->input->post('direccion');
                $dni_emp = $this->input->post('dni');
                $telefono_emp = $this->input->post('telefono');
                $sexo_emp = $this->input->post('sexo');
                $civil_emp = $this->input->post('civil');
                $afp_emp = $this->input->post('afp');

                $data = array(
                    'nomb_emp' => $nomb_emp,
                    'apel_emp' => $apel_emp,
                    'dire_emp' => $dire_emp,
                    'dni_emp' => $dni_emp,
                    'telf_emp' => $telefono_emp,
                    'sexo_emp' => $sexo_emp,
                    'afp_emp' => $afp_emp,
                    'civi_emp' => $civil_emp,
                    'esta_emp' => 'A'
                );
                $this->mod_empleado->insert($data);
                $this->session->set_userdata('mensaje_emp', 'El empleado ' . $nomb_emp . ' ' . $apel_emp . ' ha sido registrado existosamente');
                $this->session->set_userdata('ripo_mensaje_emp', 'success');
            } else if ($this->input->post('editar')) {

                // EDITAR   
            } else if ($this->input->post('activar')) {

                // ACTIVAR
            } else if ($this->input->post('desactivar')) {
                // DESACTIVAR
            }
            $planilla = $this->mod_view->view('planilla');
            $tipo_empleado = $this->mod_view->view('tipo_empleado');
            $empleado['empleados'] = $this->mod_view->view('empleado');
            $empleado['tipo'] = array();
            $empleado['planilla'] = array();


            $error_pla = false;
            $error_tip = false;
            if (count($planilla) <= 0) {
                $error_pla = true;
            } else {
                foreach ($planilla as $row) {
                    $phpdate = strtotime($row->fech_pla);
                    $date = date('d/m/Y', $phpdate);
                    $plan[$row->codi_pla] = $date . ' - S/. ' . $row->suel_pla;
                }
                $empleado['planilla'] = $plan;
            }
            if (count($tipo_empleado) <= 0) {
                $error_tip = true;
            } else {
                foreach ($tipo_empleado as $row) {
                    $tipo[$row->codi_tem] = $row->nomb_tem;
                }
                $empleado['tipo'] = $tipo;
            }
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
            $data['container'] = $this->load->view('empleado/empleado_view', $empleado, true);
            $this->load->view('home/body', $data);
        }
    }

    public function logged() {
//        return $this->session->userdata('logged');
        return true;
    }

    public function admin() {
        if ($this->session->userdata('codi_rol') == '1') {
            return true;
        } else {
            return false;
        }
    }

}
