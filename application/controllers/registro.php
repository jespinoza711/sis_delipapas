<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class registro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_empleado'));
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

            $control['form_regdiario'] = array('role' => 'form', "id" => "form_regdiario");
            $control['suel_pla'] = array('id' => 'suel_pla', 'name' => 'suel_pla', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['cant_dpl'] = array('id' => 'cant_dpl', 'name' => 'cant_dpl', 'class' => "form-control", 'placeholder' => "Cantidad procesada", "maxlength" => "10", 'required' => 'true', 'autocomplete' => 'off');
            $control['suto_dpl'] = array('id' => 'suto_dpl', 'name' => 'suto_dpl', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['desc_dpl'] = array('id' => 'desc_dpl', 'name' => 'desc_dpl', 'class' => "form-control", 'placeholder' => "Descuento observado", "maxlength" => "10", 'required' => 'true', 'autocomplete' => 'off');
            $control['tota_dpl'] = array('id' => 'tota_dpl', 'name' => 'tota_dpl', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true', 'type' => 'number', 'step' => 'any');
            $control['obsv_dpl'] = array('id' => 'obsv_dpl', 'name' => 'obsv_dpl', 'class' => "form-control", "maxlength" => "200", "autocomplete" => "off", "rows" => "3");
            $control['registrar'] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar trabajo");


            if (count($error) > 0) {
                $info["encabezado"] = "<i class='fa fa-warning'></i>&nbsp;&nbsp;&nbsp;¡Advertencia!";
                $info["panel"] = 'yellow';
                $info["cuerpo"] = $error;
                $data['container'] = $this->load->view('error', $info, true);
            } else {
                $data['container'] = $this->load->view('empleado/controldiario_view', $control, true);
            }

            $data['page'] = 'Control di&aacute;rio de personal';
            $this->load->view('home/body', $data);
        }
    }

    public function registro_diario_dia() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['codi_emp'] = $this->input->post('codi_emp');
            $data['codi_usu'] = $this->session->userdata('user_codi');
            $data['suel_pla'] = $this->input->post('suel_pla');
            $data['cant_dpl'] = $this->input->post('cant_dpl');
            $data['suto_dpl'] = $this->input->post('suto_dpl');
            $data['desc_dpl'] = $this->input->post('desc_dpl');
            $data['tota_dpl'] = $this->input->post('tota_dpl');
            $data['obsv_dpl'] = $this->input->post('obsv_dpl');
            $data['esta_dpl'] = 'A';

            if ($this->mod_empleado->registro_diario_dia($data)) {
                $this->session->set_userdata('info', 'Se ha registrado el pago di&aacute;rio exitosamente.');
            } else {
                $this->session->set_userdata('error', 'No ha sido posible el registro di&aacute;rio, verifique los datos proporcionados.');
            }
            header('Location: ' . base_url('registrodiario'));
        }
    }

}
