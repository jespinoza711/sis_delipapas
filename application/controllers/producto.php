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
            date_default_timezone_set('America/Lima');
            $datetime = date("Y-m-d H:m:s");

            if ($this->input->post('registrar')) {
                $data['codi_tpro'] = $this->input->post('tipo');
                $data['nomb_prod'] = $this->input->post('nombre');
                $data['fein_prod'] = $datetime;
                $data['fesa_prod'] = $datetime;
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

                if ($cont_tipo_producto == 0) {
                    $producto['disabled'] = ' disabled = "true" ';
                    $this->session->set_userdata('error_prod', 'Debe por lo menos registrar un tipo de producto. <button id="btnAddTPro2" type="button" class="btn btn-sm btn-primary" style="padding: 0px 10px; margin-left: 4px;"  data-toggle="tooltip" data-placement="top" title="Añadir un tipo de producto"><i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar un tipo de producto</button>');
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

    public function paginate($table) {
        $nTotal = $this->mod_view->count('v_producto');
        $productos = $this->mod_producto->get_vproducto_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($productos as $row) {
            $url = '';
            $estado = $row->esta_prod == 'A' ? 'Activo' : 'Oculto';
            $opciones = '';

            if ($this->session->userdata('user_rol') == 1) {
                if ($table == 'inv') {
                    $url = 'inventario';
                    $opciones = '<button type="button" class="tooltip-inv btn btn-success btn-circle editar_inv" data-toggle="tooltip" data-placement="top" title="Actualizar stock / precio"><i class="fa fa-edit"></i></button>';
                } else {
                    $url = 'producto';
                    $opciones = '<button type="button" class="tooltip-prod btn btn-success btn-circle editar_prod" data-toggle="tooltip" data-placement="top" title="Editar producto"><i class="fa fa-edit"></i></button>';
                }
                if ($estado == "Oculto") {
                    $opciones .= '&nbsp;<span>' . form_open(base_url($url), $form_a) . ' 
                                <input type="hidden" name="codigo" value="' . $row->codi_prod . '">
                                <input type="hidden" name="producto" value="' . $row->nomb_prod . '">
                                <input name="activar" type="submit" class="tooltip-prod btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar">
                            ' . form_close() . '</span>';
                } else {
                    $opciones .= '&nbsp;<span>' . form_open(base_url($url), $form_a) . ' 
                                <input type="hidden" name="codigo" value="' . $row->codi_prod . '">
                                <input type="hidden" name="producto" value="' . $row->nomb_prod . '">
                                <input name="desactivar" type="submit" class="tooltip-prod btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar">
                            ' . form_close() . '</span>';
                }
                $opciones.= "<script>$('.tooltip-prod').tooltip(); $('.tooltip-inv').tooltip();</script>";
            } else {
                $opciones = '<button type="button" class="btn btn-default btn-circle disabled"><i class="glyphicon glyphicon-ban-circle"></i></button>&nbsp;';
            }
            
            $fein = strtotime($row->fein_prod);
            $fesa = strtotime($row->fesa_prod);
            $fein_prod = date("d/m/Y g:i A", $fein);
            $fesa_prod = date("d/m/Y g:i A", $fesa);

            $observación = "-";
            if ($row->obsv_prod != "") {
                $observación = $row->obsv_prod;
            }

            if ($table == 'inv') {
                $aaData[] = array(
                    $row->codi_prod,
                    $row->nomb_tipo,
                    $row->nomb_prod,
                    $observación,
                    $fein_prod,
                    $fesa_prod,
                    $row->prec_prod,
                    $row->stoc_prod,
                    number_format($row->prec_prod * $row->stoc_prod, 2),                    
                    $estado,
                    $opciones
                );
            } else {
                $aaData[] = array(
                    $row->codi_prod,
                    $row->nomb_prod,
                    $row->nomb_tipo,
                    $observación,
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

    public function paginate_report() {
        $nTotal = $this->mod_view->count('producto', 0, false, array('stoc_prod >' => '0'));
        $productos = $this->mod_view->view('producto', 0, false, array('stoc_prod >' => '0'));
        $aaData = array();

        foreach ($productos as $row) {

            $time_in = strtotime($row->fein_prod);
            $time_sa = strtotime($row->fesa_prod);
            $fecha_in = date("d/m/Y g:i A", $time_in);

            if ($row->fesa_prod == "") {
                $fecha_sa = "-";
            } else {
                $fecha_sa = date("d/m/Y g:i A", $time_sa);
            }


            $aaData[] = array(
                $row->nomb_prod,
                $fecha_in,
                $fecha_sa,
                'S/. ' . $row->prec_prod,
                $row->stoc_prod
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

            if ($row->fein_prod != NULL) {
                $fein_r = strtotime($row->fein_prod);
                $fein = date("d/m/y h:i:s A", $fein_r);
            } else {
                $fein = "-";
            }
            if ($row->fesa_prod != NULL) {
                $fesa_r = strtotime($row->fesa_prod);
                $fesa = date("d/m/y h:i:s A", $fesa_r);
            } else {
                $fesa = "-";
            }
            if ($row->obsv_prod != NULL) {
                $obsv = $row->obsv_prod;
            } else {
                $obsv = "-";
            }

            $data[$row->codi_prod] = array(
                $row->codi_prod,
                $row->nomb_prod,
                $row->nomb_tipo,
                $obsv,
                $row->codi_tpro,
                $row->esta_prod,
                $row->prec_prod,
                $row->stoc_prod,
                $fein,
                $fesa
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

    public function inventario() {
        if (!$this->mod_config->AVP(1)) {
            header('location: ' . base_url('login'));
        } else {
            if ($this->input->post('inventario_update')) {
                $codi_prod = $this->input->post('codi_prod_e');
                $nomb_prod = $this->input->post('nomb_prod_e');
                $data['prec_prod'] = $this->input->post('prec_prod_e');
                $data['stoc_prod'] = $this->input->post('stoc_prod_e');
                $this->mod_producto->update($codi_prod, $data);
                $this->session->set_userdata('info', 'El stock / precio de producto ' . $nomb_prod . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('inventario'));
            } if ($this->input->post('activar')) {
                $codi_prod = $this->input->post('codigo');
                $nomb_prod = $this->input->post('producto');
                $this->mod_producto->update($codi_prod, array("esta_prod" => "A"));
                $this->session->set_userdata('info', 'El producto ' . $nomb_prod . ' ha sido habilitado existosamente');
                header('Location: ' . base_url('inventario'));
            } if ($this->input->post('desactivar')) {
                $codi_prod = $this->input->post('codigo');
                $nomb_prod = $this->input->post('producto');
                $this->mod_producto->update($codi_prod, array("esta_prod" => "D"));
                $this->session->set_userdata('info', 'El producto ' . $nomb_prod . ' ha sido deshabilitado existosamente');
                header('Location: ' . base_url('inventario'));
            } else {
                // Editar stock/precio producto
                $inventario["form_inventario"] = array('role' => 'form', "id" => "form_inventario");
                $inventario["codi_prod_e"] = array('id' => 'codi_prod_e', 'name' => 'codi_prod_e', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $inventario["nomb_tipo_e"] = array('id' => 'nomb_tipo_e', 'name' => 'nomb_tipo_e', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $inventario["nomb_prod_e"] = array('id' => 'nomb_prod_e', 'name' => 'nomb_prod_e', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', 'readonly' => 'true');
                $inventario["prec_prod_e"] = array('id' => 'prec_prod_e', 'name' => 'prec_prod_e', 'class' => "form-control input-lg", 'placeholder' => "Precio unitario", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off', 'type' => 'number', 'step' => 'any', 'min' => '0');
                $inventario["stoc_prod_e"] = array('id' => 'stoc_prod_e', 'name' => 'stoc_prod_e', 'class' => "form-control input-lg", 'placeholder' => "Stock actual", "maxlength" => "20", 'required' => 'true', 'autocomplete' => 'off', 'type' => 'number', 'step' => 'any', 'min' => '0');
                $inventario["inventario_update"] = array('id' => 'inventario_update', 'name' => 'inventario_update', 'class' => "btn btn-primary btn-lg", 'value' => "Actualizar producto");

                $data['page'] = 'Inventario';
                $data['container'] = $this->load->view('producto/inventario_view', $inventario, true);
                $this->load->view('home/body', $data);
            }
        }
    }

}
