<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class vehiculo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_vehiculo'));
        $this->load->library('session');
    }
    
    public function index() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            if ($this->input->post('registrar')) {
                $data['placa_vehi'] = $this->input->post('placa_vehi');
                $data['marca_vehi'] = $this->input->post('marca_vehi');
                $data['obsv_vehi'] = $this->input->post('obsv_vehi');
                $data['esta_vehi'] = 'A';
                $this->mod_vehiculo->insert($data);
                $this->session->set_userdata('info', 'El vehiculo ' . $data['placa_vehi'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('vehiculo'));
            } else if ($this->input->post('editar')) {
                $id_vehi = $this->input->post('id_vehi_e');
                $data['placa_vehi'] = $this->input->post('placa_vehi_e');
                $data['marca_vehi'] = $this->input->post('marca_vehi_e');
                $data['obsv_vehi'] = $this->input->post('obsv_vehi_e');
                $this->mod_vehiculo->update($id_vehi, $data);
                $this->session->set_userdata('info', 'El vehiculo ' . $data['placa_vehi'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('vehiculo'));
            } else if ($this->input->post('activar')) {
                $id_vehi = $this->input->post('id_vehi');
                $placa_vehi = $this->input->post('placa_vehi');
                $this->mod_vehiculo->update($id_vehi, array('esta_vehi' => 'A'));
                $this->session->set_userdata('info', 'El vehiculo ' . $placa_vehi . ' ha sido habilitado existosamente');
                header('Location: ' . base_url('vehiculo'));
            } else if ($this->input->post('desactivar')) {
                $id_vehi = $this->input->post('id_vehi');
                $placa_vehi = $this->input->post('placa_vehi');
                $this->mod_vehiculo->update($id_vehi, array('esta_vehi' => 'D'));
                $this->session->set_userdata('info', 'El vehiculo ' . $placa_vehi . ' ha sido deshabilitado existosamente');
                header('Location: ' . base_url('vehiculo'));
            } else {
                // NUEVO
                $vData["form_vehiculo"] = array('role' => 'form', "id" => "form_vehiculo");
                $vData["placa_vehi"] = array('id' => 'placa_vehi', 'name' => 'placa_vehi', 'class' => "form-control", 'placeholder' => "Placa", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $vData["marca_vehi"] = array('id' => 'marca_vehi', 'name' => 'marca_vehi', 'class' => "form-control", 'placeholder' => "Marca", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $vData["obsv_vehi"] = array('id' => 'obsv_vehi', 'name' => 'obsv_vehi', 'class' => "form-control", 'placeholder' => "Escriba la observacion...", "maxlength" => "250", "rows" => "3", 'autocomplete' => 'off');
                $vData["registrar"] = array('id' => 'registrar', 'name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar vehiculo");
                // EDITAR
                $vData["form_vehiculo_edit"] = array('role' => 'form', "id" => "form_vehiculo_edit");
                $vData["id_vehi_e"] = array('id' => 'id_vehi_e', 'name' => 'id_vehi_e', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $vData["placa_vehi_e"] = array('id' => 'placa_vehi_e', 'name' => 'placa_vehi_e', 'class' => "form-control", 'placeholder' => "Placa", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $vData["marca_vehi_e"] = array('id' => 'marca_vehi_e', 'name' => 'marca_vehi_e', 'class' => "form-control", 'placeholder' => "Marca", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $vData["obsv_vehi_e"] = array('id' => 'obsv_vehi_e', 'name' => 'obsv_vehi_e', 'class' => "form-control", 'placeholder' => "Escriba la observacion...", "maxlength" => "250", "rows" => "3", 'autocomplete' => 'off');
                $vData["editar"] = array('id' => 'editar', 'name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar vehiculo");
                // VIEW
                $data['page'] = 'Vehiculo';
                $data['container'] = $this->load->view('vehiculo/vehiculo_view', $vData, true);
                $this->load->view('home/body', $data);
            }
        }
    }
    
    public function paginate() {
        $nTotal = $this->mod_view->count('transportista_vehiculo');
        $oData = $this->mod_vehiculo->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($oData as $row) {
            $estado = '';
            $opciones = '<button type="button" class="tooltip-vehiculo btn btn-success btn-circle editar_vehiculo" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-edit"></i>
                        </button>&nbsp;';

            if ($row->esta_vehi == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url('vehiculo'), $form_a) . ' 
                                <input type="hidden" name="id_vehi" value="' . $row->id_vehi . '">
                                <input type="hidden" name="placa_vehi" value="' . $row->placa_vehi . '">
                                <input name="activar" type="submit" class="tooltip-transportista btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                ' . form_close() . '
                            </span>';
            } else if ($row->esta_vehi == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url('vehiculo'), $form_a) . ' 
                                <input type="hidden" name="id_vehi" value="' . $row->id_vehi . '">
                                <input type="hidden" name="placa_vehi" value="' . $row->placa_vehi . '">
                                <input name="desactivar" type="submit" class="tooltip-transportista btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                ' . form_close() . '
                            </span>';
            }
            $opciones.="<script>$('.tooltip-vehiculo').tooltip();</script>";

            $aaData[] = array(
                $row->id_vehi,
                $row->placa_vehi,
                $row->marca_vehi,
                $row->obsv_vehi,
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