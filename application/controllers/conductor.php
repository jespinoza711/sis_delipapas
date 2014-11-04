<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class conductor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_conductor'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            if ($this->input->post('registrar')) {
                $data['nomb_cond'] = $this->input->post('nomb_cond');
                $data['apel_cond'] = $this->input->post('apel_cond');
                $data['dni_cond'] = $this->input->post('dni_cond');
                $data['licen_cond'] = $this->input->post('licen_cond');
                $data['obsv_cond'] = $this->input->post('obsv_cond');
                $data['esta_cond'] = 'A';
                $this->mod_conductor->insert($data);
                $this->session->set_userdata('info', 'El conductor ' . $data['nomb_cond'] . " " . $data['apel_cond'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('conductor'));
            } else if ($this->input->post('editar')) {
                $id_cond = $this->input->post('id_cond_e');
                $data['nomb_cond'] = $this->input->post('nomb_cond_e');
                $data['apel_cond'] = $this->input->post('apel_cond_e');
                $data['dni_cond'] = $this->input->post('dni_cond_e');
                $data['licen_cond'] = $this->input->post('licen_cond_e');
                $data['obsv_cond'] = $this->input->post('obsv_cond_e');
                $this->mod_conductor->update($id_cond, $data);
                $this->session->set_userdata('info', 'El conductor ' . $data['nomb_cond'] . " " . $data['apel_cond'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('conductor'));
            } else if ($this->input->post('activar')) {
                $id_cond = $this->input->post('id_cond');
                $nomb_cond = $this->input->post('nomb_cond');
                $this->mod_conductor->update($id_cond, array('esta_cond' => 'A'));
                $this->session->set_userdata('info', 'El conductor ' . $nomb_cond . ' ha sido habilitado existosamente');
                header('Location: ' . base_url('conductor'));
            } else if ($this->input->post('desactivar')) {
                $id_cond = $this->input->post('id_cond');
                $nomb_cond = $this->input->post('nomb_cond');
                $this->mod_conductor->update($id_cond, array('esta_cond' => 'D'));
                $this->session->set_userdata('info', 'El conductor ' . $nomb_cond . ' ha sido deshabilitado existosamente');
                header('Location: ' . base_url('conductor'));
            } else {
                // NUEVO
                $vData["form_conductor"] = array('role' => 'form', "id" => "form_conductor");
                $vData["nomb_cond"] = array('id' => 'nomb_cond', 'name' => 'nomb_cond', 'class' => "form-control", 'placeholder' => "Primer nombre", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $vData["apel_cond"] = array('id' => 'apel_cond', 'name' => 'apel_cond', 'class' => "form-control", 'placeholder' => "Apellidos", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $vData["dni_cond"] = array('id' => 'dni_cond', 'name' => 'dni_cond', 'class' => "form-control", 'placeholder' => "DNI", "maxlength" => "8", 'required' => 'true', 'autocomplete' => 'off');
                $vData["licen_cond"] = array('id' => 'licen_cond', 'name' => 'licen_cond', 'class' => "form-control", 'placeholder' => "Licencia", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $vData["obsv_cond"] = array('id' => 'obsv_cond', 'name' => 'obsv_cond', 'class' => "form-control", 'placeholder' => "Escriba la observacion...", "maxlength" => "250", "rows" => "3", 'autocomplete' => 'off');
                $vData["registrar"] = array('id' => 'registrar', 'name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar Conductor");
                // EDITAR
                $vData["form_conductor_edit"] = array('role' => 'form', "id" => "form_conductor_edit");
                $vData["id_cond_e"] = array('id' => 'id_cond_e', 'name' => 'id_cond_e', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $vData["nomb_cond_e"] = array('id' => 'nomb_cond_e', 'name' => 'nomb_cond_e', 'class' => "form-control", 'placeholder' => "Primer nombre", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $vData["apel_cond_e"] = array('id' => 'apel_cond_e', 'name' => 'apel_cond_e', 'class' => "form-control", 'placeholder' => "Apellidos", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $vData["dni_cond_e"] = array('id' => 'dni_cond_e', 'name' => 'dni_cond_e', 'class' => "form-control", 'placeholder' => "DNI", "maxlength" => "8", 'required' => 'true', 'autocomplete' => 'off');
                $vData["licen_cond_e"] = array('id' => 'licen_cond_e', 'name' => 'licen_cond_e', 'class' => "form-control", 'placeholder' => "Licencia", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $vData["obsv_cond_e"] = array('id' => 'obsv_cond_e', 'name' => 'obsv_cond_e', 'class' => "form-control", 'placeholder' => "Escriba la observacion...", "maxlength" => "250", "rows" => "3", 'autocomplete' => 'off');
                $vData["editar"] = array('id' => 'editar', 'name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar Conductor");
                // VIEW
                $data['page'] = 'Conductor';
                $data['container'] = $this->load->view('conductor/conductor_view', $vData, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function paginate() {
        $nTotal = $this->mod_view->count('transportista_conductor');
        $oData = $this->mod_conductor->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($oData as $row) {
            $estado = '';
            $opciones = '<button type="button" class="tooltip-conductor btn btn-success btn-circle editar_conductor" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-edit"></i>
                        </button>&nbsp;';

            if ($row->esta_cond == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url('conductor'), $form_a) . ' 
                                <input type="hidden" name="id_cond" value="' . $row->id_cond . '">
                                <input type="hidden" name="nomb_cond" value="' . $row->nomb_cond . '">
                                <input name="activar" type="submit" class="tooltip-transportista btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                ' . form_close() . '
                            </span>';
            } else if ($row->esta_cond == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url('conductor'), $form_a) . ' 
                                <input type="hidden" name="id_cond" value="' . $row->id_cond . '">
                                <input type="hidden" name="nomb_cond" value="' . $row->nomb_cond . '">
                                <input name="desactivar" type="submit" class="tooltip-transportista btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                ' . form_close() . '
                            </span>';
            }
            $opciones.="<script>$('.tooltip-conductor').tooltip();</script>";

            $aaData[] = array(
                $row->id_cond,
                $row->dni_cond,                
                $row->nomb_cond,
                $row->apel_cond,
                $row->licen_cond,
                $row->obsv_cond,
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
