<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class producto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_producto'));
        $this->load->library('session');
    }

    // El index de esta clase es para el mantenimiento de producto
    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {

            if ($this->input->post('registrar')) {
                $data['codi_tpro'] = $this->input->post('tipo');
                $data['nomb_prod'] = $this->input->post('nombre');
                if ($this->input->post('observa') != "") {
                    $data['obsv_prod'] = $this->input->post('observa');
                }
                $data['esta_prod'] = 'A';
                $this->mod_producto->insert($data);
                $this->session->set_userdata('info_prod', 'El producto ' . $data['nomb_prod'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('producto'));
            } if ($this->input->post('editar')) {
                $codigo = $this->input->post('codigo');
                $data['codi_tpro'] = $this->input->post('tipo');
                $data['nomb_prod'] = $this->input->post('nombre');
                if ($this->input->post('observa') != "") {
                    $data['obsv_prod'] = $this->input->post('observa');
                }
                $this->mod_producto->update($codigo, $data);
                $this->session->set_userdata('info_prod', 'El producto ' . $data['nomb_prod'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('producto'));
            } if ($this->input->post('activar')) {
                $codigo = $this->input->post('codigo');
                $producto = $this->input->post('producto');
                $this->mod_producto->update($codigo, array("esta_prod" => "A"));
                $this->session->set_userdata('info_prod', 'El producto ' . $producto . ' ha sido habilitado existosamente');
                header('Location: ' . base_url('producto'));
            } if ($this->input->post('desactivar')) {
                $codigo = $this->input->post('codigo');
                $producto = $this->input->post('producto');
                $this->mod_producto->update($codigo, array("esta_prod" => "D"));
                $this->session->set_userdata('info_prod', 'El producto ' . $producto . ' ha sido deshabilitado existosamente');
                header('Location: ' . base_url('producto'));     
            } if ($this->input->post('registrar_tpro')) {
                $data['nomb_tipo'] = $this->input->post('nombre');
                $data['esta_tipo'] = "A";
                $this->mod_producto->insert_tipo($data);
                $this->session->set_userdata('info_prod', 'El tipo de producto ' . $data['nomb_tipo'] . ' ha sido registrado existosamente');
                header('Location: ' . base_url('producto'));  
            } else {

                $producto['disabled'] = "";
                $cont_tipo_producto = $this->mod_view->count('tipo_producto', 0, false, array('esta_tipo' => 'A'));
                $tipo_producto = $this->mod_view->view('tipo_producto', 0, false, array('esta_tipo' => 'A'));

                if ($cont_tipo_producto > 0) {
                    
                } else {
                    $producto['disabled'] = ' disabled = "true" ';
                    $this->session->set_userdata('error_prod', 'Debe por lo menos registrar un tipo de producto');
                }

                $tipo = array();
                foreach ($tipo_producto as $r) {
                    $tipo[$r->codi_tpro] = $r->nomb_tipo;
                }
                $producto['tipo'] = $tipo;

                // Nuevo producto

                $producto["form"] = array('role' => 'form', "id" => "form_prod");
                $producto["nombre"] = array('id' => 'nomb_prod', 'name' => 'nombre', 'class' => "form-control input-lg", 'placeholder' => "Nombre", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $producto["observa"] = array('id' => 'observa_prod', 'name' => 'observa', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "100", "rows" => "5", "autocomplete" => "off");
                $producto["registrar"] = array('id' => 'registrar_prod', 'name' => 'registrar', 'class' => "btn btn-primary btn-lg", 'value' => "Registrar");
                
                // Editar producto
                $producto["form_e"] = array('role' => 'form', "id" => "form_prod_e");
                $producto["codigo_e"] = array('id' => 'codigo_prod_e', 'name' => 'codigo', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $producto["nombre_e"] = array('id' => 'nomb_prod_e', 'name' => 'nombre', 'class' => "form-control input-lg", 'placeholder' => "Nombre", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $producto["observa_e"] = array('id' => 'observa_prod_e', 'name' => 'observa', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "100", "rows" => "5", "autocomplete" => "off");
                $producto["editar"] = array('id' => 'editar_prod', 'name' => 'editar', 'class' => "btn btn-primary btn-lg", 'value' => "Editar");

                // Añadir tipo de producto
                
                $producto["form_tpro"] = array('role' => 'form', "id" => "form_tpro");
                $producto["nombre_tpro"] = array('id' => 'nomb_tpro', 'name' => 'nombre', 'class' => "form-control input-lg", 'placeholder' => "Nombre", "maxlength" => "45", 'required' => 'true', 'autocomplete' => 'off');
                $producto["registrar_tpro"] = array('id' => 'registrar_tpro', 'name' => 'registrar_tpro', 'class' => "btn btn-primary btn-lg", 'value' => "Registrar");
                
                $data['page'] = 'Productos';
                $data['container'] = $this->load->view('producto/producto_view', $producto, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function paginate() {

        $nTotal = $this->mod_view->count('producto');

        $productos = $this->mod_producto->get_vproducto_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);

        $form_a = array('role' => 'form', "style" => "display: inline-block;");

        $aaData = array();

        foreach ($productos as $row) {

            $opciones = '<button type="button" class="tooltip-prod btn btn-default btn-circle editar_prod" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </button>';
            $estado = "";
            if ($row->esta_prod == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url() . 'producto', $form_a) . ' 
                                            <input type="hidden" name="codigo" value="' . $row->codi_prod . '">
                                            <input type="hidden" name="producto" value="' . $row->nomb_prod . '">
                                            <input name="activar" type="submit" class="tooltip-prod btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                                      ' . form_close() . '
                                                </span>';
            } else if ($row->esta_prod == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url() . 'producto', $form_a) . ' 
                                         <input type="hidden" name="codigo" value="' . $row->codi_prod . '">
                                         <input type="hidden" name="producto" value="' . $row->nomb_prod . '">
                                         <input name="desactivar" type="submit" class="tooltip-prod btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                                    ' . form_close() . '</span>';
            }
            $opciones.="<script>$('.tooltip-prod').tooltip(); $('.popover-prod').popover();</script>";

            $observación = "-";
            if ($row->obsv_prod != "") {
                $observación = '<button type="button" class="popover-prod btn btn-default" data-toggle="popover" data-content="'.$row->obsv_prod.'" data-original-title="Observación" data-placement="top"><i class="fa fa-eye"></i>&nbsp;&nbsp;&nbsp;Ver</button>';
            }
            
            $aaData[] = array(
                $row->codi_prod,
                $row->nomb_prod,
                $row->nomb_tipo,
                $observación,
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

    public function get_vproducto() {
        $data = array();
        $productos = $this->mod_producto->get_vproducto();
        foreach ($productos as $row) {
            $data[$row->codi_prod] = array(
                $row->codi_prod,
                $row->nomb_prod,
                $row->nomb_tipo,
                $row->obsv_prod,
                $row->codi_tpro,
                $row->esta_prod
            );
        }
        echo json_encode($data);
    }
    
    public function get_tipo_producto() {
        $data = array();
        $tipo_producto = $this->mod_view->view('tipo_producto');
        foreach ($tipo_producto as $row) {
            $data[$row->codi_tpro] = array(
                $row->codi_tpro,
                $row->nomb_tipo,
                $row->esta_tipo
            );
        }
        echo json_encode($data);
    }

    public function producto() {
        
    }

    public function inventario() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            $data['page'] = 'Inventario';
            $d['producto'] = $this->mod_view->view('v_producto', false, false, false);
            $data['container'] = $this->load->view('producto/inventario_view', $d, true);
            $this->load->view('home/body', $data);
        }
    }

}
