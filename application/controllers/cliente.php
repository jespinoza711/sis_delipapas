<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_cliente'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {

            if ($this->input->post('registrar')) {
                $data['empr_cli'] = $this->input->post('empresa');
                $data['nomb_cli'] = $this->input->post('nombre');
                $data['apel_cli'] = $this->input->post('apellido');
                $data['dire_cli'] = $this->input->post('direccion');
                $data['telf_cli'] = $this->input->post('telefono');
                $data['fena_cli'] = $this->input->post('fecha');
                $data['ruc_cli'] = $this->input->post('ruc');
                $data['sexo_cli'] = $this->input->post('sexo');
                $data['esta_cli'] = 'A';
                $this->mod_cliente->insert($data);
                $this->session->set_userdata('info_cli', 'El cliente ' . $data['nomb_cli'] . ' ' . $data['apel_cli'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('cliente'));
            } else if ($this->input->post('editar')) {
                $codigo = $this->input->post('codigo');
                $data['empr_cli'] = $this->input->post('empresa');
                $data['nomb_cli'] = $this->input->post('nombre');
                $data['apel_cli'] = $this->input->post('apellido');
                $data['dire_cli'] = $this->input->post('direccion');
                $data['telf_cli'] = $this->input->post('telefono');
                $data['fena_cli'] = $this->input->post('fecha');
                $data['ruc_cli'] = $this->input->post('ruc');
                $data['sexo_cli'] = $this->input->post('sexo');
                $this->mod_cliente->update($codigo, $data);
                $this->session->set_userdata('info_cli', 'El cliente ' . $data['nomb_cli'] . ' ' . $data['apel_cli'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('cliente'));
            } else if ($this->input->post('activar')) {
                $codigo = $this->input->post('codigo');
                $cliente = $this->input->post('cliente');
                $this->mod_cliente->update($codigo, array("esta_cli" => "A"));
                $this->session->set_userdata('info_cli', 'El cliente ' . $cliente . ' ha sido habilitado existosamente');
                header('Location: ' . base_url('cliente'));
            } else if ($this->input->post('desactivar')) {
                $codigo = $this->input->post('codigo');
                $cliente = $this->input->post('cliente');
                $this->mod_cliente->update($codigo, array("esta_cli" => "D"));
                $this->session->set_userdata('info_cli', 'El cliente ' . $cliente . ' ha sido deshabilitado existosamente');
                header('Location: ' . base_url('cliente'));
            } else {

                // Nuevo cliente
                $cliente["form"] = array('role' => 'form', "id" => "form_cli");
                $cliente["nombre"] = array('id' => 'nomb_cli', 'name' => 'nombre', 'class' => "form-control", 'placeholder' => "Nombre", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["empresa"] = array('id' => 'empr_cli', 'name' => 'empresa', 'class' => "form-control", 'placeholder' => "Empresa", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["apellido"] = array('id' => 'apel_cli', 'name' => 'apellido', 'class' => "form-control", 'placeholder' => "Apellido", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["direccion"] = array('id' => 'direccion_cli', 'name' => 'direccion', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "50", 'required' => 'true', "autocomplete" => "off");
                $cliente["telefono"] = array('id' => 'telefono_cli', 'name' => 'telefono', 'class' => "form-control", 'placeholder' => "Teléfono", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["fecha"] = array('id' => 'fecha_cli', 'name' => 'fecha', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["ruc"] = array('id' => 'ruc_cli', 'name' => 'ruc', 'class' => "form-control", 'placeholder' => "R.U.C.", "maxlength" => "11", 'autocomplete' => 'off');
                $cliente["masculino"] = array('id' => 'masculino_cli', 'name' => 'sexo', "value" => "M", 'required' => "true");
                $cliente["femenino"] = array('id' => 'femenino_cli', 'name' => 'sexo', "value" => "F", 'required' => "true");

                // Editar cliente
                $cliente["form_e"] = array('role' => 'form', "id" => "form_cli_e");
                $cliente["codigo_e"] = array('id' => 'codigo_cli_e', 'name' => 'codigo', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $cliente["nombre_e"] = array('id' => 'nomb_cli_e', 'name' => 'nombre', 'class' => "form-control", 'placeholder' => "Nombre", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["empresa_e"] = array('id' => 'empr_cli_e', 'name' => 'empresa', 'class' => "form-control", 'placeholder' => "Empresa", "maxlength" => "50", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["apellido_e"] = array('id' => 'apel_cli_e', 'name' => 'apellido', 'class' => "form-control", 'placeholder' => "Apellido", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["direccion_e"] = array('id' => 'direccion_cli_e', 'name' => 'direccion', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "50", 'required' => 'true', "autocomplete" => "off");
                $cliente["telefono_e"] = array('id' => 'telefono_cli_e', 'name' => 'telefono', 'class' => "form-control", 'placeholder' => "Teléfono", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["fecha_e"] = array('id' => 'fecha_cli_e', 'name' => 'fecha', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["ruc_e"] = array('id' => 'ruc_cli_e', 'name' => 'ruc', 'class' => "form-control", 'placeholder' => "R.U.C.", "maxlength" => "11", 'required' => 'true', 'autocomplete' => 'off');
                $cliente["masculino_e"] = array('id' => 'masculino_cli_e', 'name' => 'sexo', "value" => "M", 'required' => "true");
                $cliente["femenino_e"] = array('id' => 'femenino_cli_e', 'name' => 'sexo', "value" => "F", 'required' => "true");


                $cliente["registrar"] = array('id' => 'registrar_cli', 'name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");
                $cliente["editar"] = array('id' => 'editar_cli', 'name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");

                $data['page'] = 'Clientes';
                $data['container'] = $this->load->view('cliente/cliente_view', $cliente, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function paginate() {
        $nTotal = $this->mod_view->count('cliente');

        $clientes = $this->mod_cliente->get_cliente_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

        $form_a = array('role' => 'form', "style" => "display: inline-block;");

        $aaData = array();

        foreach ($clientes as $row) {
            $estado = "";
            $opciones = '<button type="button" class="tooltip-cli btn btn-success btn-circle editar_cli" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </button>&nbsp;';
            if ($row->esta_cli == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url() . 'cliente', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_cli . '">
                                                    <input type="hidden" name="cliente" value="' . $row->nomb_cli . ' ' . $row->apel_cli . '">
                                                    <input name="activar" type="submit" class="tooltip-cli btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                                    ' . form_close() . '
                                                </span>';
            } else if ($row->esta_cli == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url() . 'cliente', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_cli . '">
                                                    <input type="hidden" name="cliente" value="' . $row->nomb_cli . ' ' . $row->apel_cli . '">
                                                    <input name="desactivar" type="submit" class="tooltip-cli btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                                    ' . form_close() . '
                                                </span>';
            }
            $opciones.="<script>$('.tooltip-cli').tooltip();</script>";

            $aaData[] = array(
                '<button type="button" class="tooltip-cli btn btn-primary btn-circle info_cli" data-toggle="tooltip" data-placement="top" title="Ver más info">
                    <i class="fa fa-chevron-down info_i"></i>
                 </button>',
                $row->codi_cli,
                $row->empr_cli,
                $row->nomb_cli . ' ' . $row->apel_cli,
                $row->telf_cli,
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

    public function paginate_report() {

        $nTotal = $this->mod_view->count('cliente', 0, false, array('esta_cli' => 'A'));

        $clientes = $this->mod_view->view('cliente', 0, false, array('esta_cli' => 'A'));

        $aaData = array();

        $i = 1;
        foreach ($clientes as $row) {

            $aaData[] = array(
                $i,
                $row->empr_cli,
                $row->nomb_cli . ' ' . $row->apel_cli,
                $row->telf_cli,
                $row->ruc_cli,
                $row->dire_cli
            );
            $i++;
        }

        $aa = array(
            'sEcho' => $_POST['sEcho'],
            'iTotalRecords' => $nTotal,
            'iTotalDisplayRecords' => $nTotal,
            'aaData' => $aaData);

        print_r(json_encode($aa));
    }

    public function get_cliente() {

        $data = array();
        $clientes = $this->mod_view->view('cliente', false, false, false);
        foreach ($clientes as $row) {
            $data[$row->codi_cli] = array(
                $row->codi_cli,
                $row->nomb_cli,
                $row->apel_cli,
                $row->dire_cli,
                $row->telf_cli,
                $row->sexo_cli,
                $row->fena_cli,
                $row->ruc_cli,
                $row->esta_cli,
                $row->empr_cli
            );
        }
        echo json_encode($data);
    }

}
