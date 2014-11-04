<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class transportista extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_transportista'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            if ($this->input->post('registrar')) {
                $data['nomb_tran'] = $this->input->post('nomb_tran');
                $data['ruc_tran'] = $this->input->post('ruc_tran');
                $data['dire_tran'] = $this->input->post('dire_tran');
                $data['telf_tran'] = $this->input->post('telf_tran');
                $data['obsv_tran'] = $this->input->post('obsv_tran');
                $data['esta_tran'] = 'A';
                $this->mod_transportista->insert($data);
                $this->session->set_userdata('info', 'El transportista ' . $data['nomb_tran'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('transportista'));
            } else if ($this->input->post('editar')) {
                $id_tran = $this->input->post('id_tran_e');
                $data['nomb_tran'] = $this->input->post('nomb_tran_e');
                $data['ruc_tran'] = $this->input->post('ruc_tran_e');
                $data['dire_tran'] = $this->input->post('dire_tran_e');
                $data['telf_tran'] = $this->input->post('telf_tran_e');
                $data['obsv_tran'] = $this->input->post('obsv_tran_e');
                $this->mod_transportista->update($id_tran, $data);
                $this->session->set_userdata('info', 'El transportista ' . $data['nomb_tran'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('transportista'));
            } else if ($this->input->post('activar')) {
                $id_tran = $this->input->post('id_tran');
                $nomb_tran = $this->input->post('nomb_tran');
                $this->mod_transportista->update($id_tran, array('esta_tran' => 'A'));
                $this->session->set_userdata('info', 'El transportista ' . $nomb_tran . ' ha sido habilitado existosamente');
                header('Location: ' . base_url('transportista'));
            } else if ($this->input->post('desactivar')) {
                $id_tran = $this->input->post('id_tran');
                $nomb_tran = $this->input->post('nomb_tran');
                $this->mod_transportista->update($id_tran, array('esta_tran' => 'D'));
                $this->session->set_userdata('info', 'El transportista ' . $nomb_tran . ' ha sido deshabilitado existosamente');
                header('Location: ' . base_url('transportista'));
            } else {
                // NUEVO
                $transportista["form_transportista"] = array('role' => 'form', "id" => "form_transportista");
                $transportista["nomb_tran"] = array('id' => 'nomb_tran', 'name' => 'nomb_tran', 'class' => "form-control", 'placeholder' => "Nombre", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $transportista["ruc_tran"] = array('id' => 'ruc_tran', 'name' => 'ruc_tran', 'class' => "form-control", 'placeholder' => "RUC", "maxlength" => "11", 'required' => 'true', 'autocomplete' => 'off');
                $transportista["dire_tran"] = array('id' => 'dire_tran', 'name' => 'dire_tran', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', "autocomplete" => "off");
                $transportista["telf_tran"] = array('id' => 'telf_tran', 'name' => 'telf_tran', 'class' => "form-control", 'placeholder' => "Teléfono", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $transportista["obsv_tran"] = array('id' => 'obsv_tran', 'name' => 'obsv_tran', 'class' => "form-control", 'placeholder' => "Escriba la observacion...", "maxlength" => "250", "rows" => "3", 'autocomplete' => 'off');
                $transportista["registrar"] = array('id' => 'registrar', 'name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar transportista");
                // EDITAR
                $transportista["form_transportista_edit"] = array('role' => 'form', "id" => "form_transportista_edit");
                $transportista["id_tran_e"] = array('id' => 'id_tran_e', 'name' => 'id_tran_e', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $transportista["nomb_tran_e"] = array('id' => 'nomb_tran_e', 'name' => 'nomb_tran_e', 'class' => "form-control", 'placeholder' => "Nombre", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $transportista["ruc_tran_e"] = array('id' => 'ruc_tran_e', 'name' => 'ruc_tran_e', 'class' => "form-control", 'placeholder' => "RUC", "maxlength" => "11", 'required' => 'true', 'autocomplete' => 'off');
                $transportista["dire_tran_e"] = array('id' => 'dire_tran_e', 'name' => 'dire_tran_e', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', "autocomplete" => "off");
                $transportista["telf_tran_e"] = array('id' => 'telf_tran_e', 'name' => 'telf_tran_e', 'class' => "form-control", 'placeholder' => "Teléfono", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $transportista["obsv_tran_e"] = array('id' => 'obsv_tran_e', 'name' => 'obsv_tran_e', 'class' => "form-control", 'placeholder' => "Escriba la observacion...", "maxlength" => "250", "rows" => "3", 'autocomplete' => 'off');
                $transportista["editar"] = array('id' => 'editar_prov', 'name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");
                $transportista["editar"] = array('id' => 'editar', 'name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar transportista");
                // VIEW
                $data['page'] = 'Transportista';
                $data['container'] = $this->load->view('transportista/transportista_view', $transportista, true);
                $this->load->view('home/body', $data);
            }
        }
    }
    
    public function paginate() {
        $nTotal = $this->mod_view->count('transportista');
        $oData = $this->mod_transportista->get_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($oData as $row) {
            $estado = '';
            $opciones = '<button type="button" class="tooltip-transportista btn btn-success btn-circle editar_transportista" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-edit"></i>
                        </button>&nbsp;';

            if ($row->esta_tran == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url('transportista'), $form_a) . ' 
                                <input type="hidden" name="id_tran" value="' . $row->id_tran . '">
                                <input type="hidden" name="nomb_tran" value="' . $row->nomb_tran . '">
                                <input name="activar" type="submit" class="tooltip-transportista btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                ' . form_close() . '
                            </span>';
            } else if ($row->esta_tran == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url('transportista'), $form_a) . ' 
                                <input type="hidden" name="id_tran" value="' . $row->id_tran . '">
                                <input type="hidden" name="nomb_tran" value="' . $row->nomb_tran . '">
                                <input name="desactivar" type="submit" class="tooltip-transportista btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                ' . form_close() . '
                            </span>';
            }
            $opciones.="<script>$('.tooltip-transportista').tooltip();</script>";

            $aaData[] = array(
                $row->id_tran,
                $row->nomb_tran,
                $row->ruc_tran,
                $row->dire_tran,
                $row->telf_tran,
                $row->obsv_tran,
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
