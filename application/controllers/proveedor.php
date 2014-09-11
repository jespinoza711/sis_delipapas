<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class proveedor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_proveedor'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {

            if ($this->input->post('registrar')) {
                $data['nomb_pro'] = $this->input->post('nombre');
                $data['dire_pro'] = $this->input->post('direccion');
                $data['telf_pro'] = $this->input->post('telefono');
                $data['ruc_pro'] = $this->input->post('ruc');
                if ($this->input->post('email') != "") {
                    $data['emai_pro'] = $this->input->post('email');
                }
                $data['esta_pro'] = 'A';
                $this->mod_proveedor->insert($data);
                $this->session->set_userdata('info_pro', 'El proveedor ' . $data['nomb_pro'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('proveedor'));
            } else if ($this->input->post('editar')) {
                $codigo = $this->input->post('codigo');
                $data['nomb_pro'] = $this->input->post('nombre');
                $data['dire_pro'] = $this->input->post('direccion');
                $data['telf_pro'] = $this->input->post('telefono');
                $data['ruc_pro'] = $this->input->post('ruc');
                if ($this->input->post('email') != "") {
                    $data['emai_pro'] = $this->input->post('email');
                }
                $this->mod_proveedor->update($codigo, $data);
                $this->session->set_userdata('info_pro', 'El proveedor ' . $data['nomb_pro'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('proveedor'));
            } else if ($this->input->post('activar')) {
                $codigo = $this->input->post('codigo');
                $proveedor = $this->input->post('proveedor');
                $this->mod_proveedor->update($codigo, array("esta_pro" => "A"));
                $this->session->set_userdata('info_pro', 'El proveedor ' . $proveedor . ' ha sido habilitado existosamente');
                header('Location: ' . base_url('proveedor'));
            } else if ($this->input->post('desactivar')) {
                $codigo = $this->input->post('codigo');
                $proveedor = $this->input->post('proveedor');
                $this->mod_proveedor->update($codigo, array("esta_pro" => "D"));
                $this->session->set_userdata('info_pro', 'El proveedor ' . $proveedor . ' ha sido deshabilitado existosamente');
                header('Location: ' . base_url('proveedor'));
            } else {

                // Nuevo proveedor
                $proveedor["form"] = array('role' => 'form', "id" => "form_prov");
                $proveedor["nombre"] = array('id' => 'nomb_prov', 'name' => 'nombre', 'class' => "form-control", 'placeholder' => "Nombre", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $proveedor["direccion"] = array('id' => 'direccion_prov', 'name' => 'direccion', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', "autocomplete" => "off");
                $proveedor["telefono"] = array('id' => 'telefono_prov', 'name' => 'telefono', 'class' => "form-control", 'placeholder' => "Teléfono", 'required' => 'true', 'autocomplete' => 'off');
                $proveedor["ruc"] = array('id' => 'ruc_prov', 'name' => 'ruc', 'class' => "form-control", 'placeholder' => "R.U.C.", "maxlength" => "11", 'required' => 'true', 'autocomplete' => 'off');
                $proveedor["email"] = array('id' => 'email_prov', 'name' => 'email', 'class' => "form-control", 'placeholder' => "E-mail", "maxlength" => "45", 'autocomplete' => 'off', "type" => "email");

                // Editar proveedor
                $proveedor["form_e"] = array('role' => 'form', "id" => "form_prov_e");
                $proveedor["codigo_e"] = array('id' => 'codigo_prov_e', 'name' => 'codigo', 'class' => "form-control", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $proveedor["nombre_e"] = array('id' => 'nomb_prov_e', 'name' => 'nombre', 'class' => "form-control", 'placeholder' => "Nombre", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $proveedor["direccion_e"] = array('id' => 'direccion_prov_e', 'name' => 'direccion', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', "autocomplete" => "off");
                $proveedor["telefono_e"] = array('id' => 'telefono_prov_e', 'name' => 'telefono', 'class' => "form-control", 'placeholder' => "Teléfono", 'required' => 'true', 'autocomplete' => 'off');
                $proveedor["ruc_e"] = array('id' => 'ruc_prov_e', 'name' => 'ruc', 'class' => "form-control", 'placeholder' => "R.U.C.", "maxlength" => "11", 'required' => 'true', 'autocomplete' => 'off');
                $proveedor["email_e"] = array('id' => 'email_prov_e', 'name' => 'email', 'class' => "form-control", 'placeholder' => "E-mail", "maxlength" => "45", 'autocomplete' => 'off');

                $proveedor["registrar"] = array('id' => 'registrar_prov', 'name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");
                $proveedor["editar"] = array('id' => 'editar_prov', 'name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");


                $data['page'] = 'Proveedores';
                $data['container'] = $this->load->view('proveedor/proveedor_view', $proveedor, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function paginate() {

        $nTotal = $this->mod_view->count('proveedor');

        $proveedor = $this->mod_proveedor->get_proveedor_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
//        $proveedor = $this->mod_proveedor->get_proveedor_paginate(10, 0, "");

        $form_a = array('role' => 'form', "style" => "display: inline-block;");

        $aaData = array();

        foreach ($proveedor as $row) {
            $estado = "";
            $opciones = '<button type="button" class="tooltip-pro btn btn-default btn-circle editar_prov" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </button>';
            if ($row->esta_pro == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url() . 'proveedor', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_pro . '">
                                                    <input type="hidden" name="proveedor" value="' . $row->nomb_pro . '">
                                                    <input name="activar" type="submit" class="tooltip-pro btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                                    ' . form_close() . '
                                                </span>';
            } else if ($row->esta_pro == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url() . 'proveedor', $form_a) . ' 
                         <input type="hidden" name="codigo" value="' . $row->codi_pro . '">
                                                    <input type="hidden" name="proveedor" value="' . $row->nomb_pro . '">
                                                    <input name="desactivar" type="submit" class="tooltip-pro btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                                    ' . form_close() . '
                                                </span>';
            }
            $opciones.="<script>$('.tooltip-pro').tooltip();</script>";

            $aaData[] = array(
                '<button type="button" class="tooltip-pro btn btn-primary btn-circle info_prov" data-toggle="tooltip" data-placement="top" title="Ver más info">
                    <i class="fa fa-chevron-down info_i"></i>
                 </button>',
                $row->codi_pro,
                $row->nomb_pro,
                $row->ruc_pro,
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

    public function get_proveedor() {

        $data = array();
        $proveedores = $this->mod_view->view('proveedor', false, false, false);
        foreach ($proveedores as $row) {
            $data[$row->codi_pro] = array(
                $row->codi_pro,
                $row->nomb_pro,
                $row->dire_pro,
                $row->telf_pro,
                $row->ruc_pro,
                $row->emai_pro,
                $row->esta_pro
            );
        }
        echo json_encode($data);
    }

}
