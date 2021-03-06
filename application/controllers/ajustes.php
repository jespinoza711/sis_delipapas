<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ajustes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_ajustes'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');
            $ajustes['datetime'] = date('Y-m-d H:i:s');
            $ajustes['negocio'] = $this->mod_view->one('negocio');
            // NEGOCIO
            if ($this->input->post('registrar_negocio')) {
                $data["ruc_neg"] = $this->input->post('ruc_neg');
                $data["nomb_neg"] = $this->input->post('nomb_neg');
                $data["dire_neg"] = $this->input->post('dire_neg');
                $data["tel1_neg"] = $this->input->post('tel1_neg');
                $data["tel2_neg"] = $this->input->post('tel2_neg');
                $data["email_neg"] = $this->input->post('email_neg');
                $data["web_neg"] = $this->input->post('web_neg');
                $data["desc_neg"] = $this->input->post('desc_neg');
                $data['esta_neg'] = 'A';
                $this->mod_ajustes->update_negocio('1', $data);
                $this->session->set_userdata('info_negocio', 'La informaci&oacute;n de la empresa ha sido actualizado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('registrar_igv')) {
                $data['igv_pla'] = $this->input->post('igv_pla');
                $this->mod_ajustes->update_negocio('1', $data);
                $this->session->set_userdata('info_negocio', 'El I.G.V para operaciones del sistema ha sido actualizado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('registrar_num_orden')) {
                $data['num_ini_orden'] = $this->input->post('num_ini_orden');
                $this->mod_ajustes->update_negocio('1', $data);
                $this->session->set_userdata('info_negocio', 'Se ha establecido el n&uacute;mero incial para la Orden de despacho.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('registrar_num_factura')) {
                $data['num_ini_factura'] = $this->input->post('num_ini_factura');
                $this->mod_ajustes->update_negocio('1', $data);
                $this->session->set_userdata('info_negocio', 'Se ha establecido el n&uacute;mero incial para la Factura.');
                header('Location: ' . base_url('ajustes'));
            } else
            // PLANILLA
            if ($this->input->post('registrar_planilla')) {
                $data['fech_pla'] = $ajustes['datetime'];
                $data['suel_pla'] = $this->input->post('suel_pla');
                $data['obsv_pla'] = $this->input->post('obsv_pla');
                $data['esta_pla'] = 'A';
                $this->mod_ajustes->insert_planilla($data);
                $this->session->set_userdata('info_planilla', 'La planilla con el sueldo S/. ' . $data['suel_pla'] . ' ha sido registrado existosamente. Esta es su planilla actual.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('editar_planilla')) {
                $codi_pla = $this->input->post('codi_pla_e');
                $data['suel_pla'] = $this->input->post('suel_pla_e');
                $data['obsv_pla'] = $this->input->post('obsv_pla_e');
                $data['esta_pla'] = 'A';
                $this->mod_ajustes->update_planilla($codi_pla, $data);
                $this->session->set_userdata('info_planilla', 'La planilla con el sueldo S/. ' . $data['suel_pla'] . ' ha sido actualizado existosamente. Esta es su planilla actual.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('activar_planilla')) {
                $codi_pla = $this->input->post('codi_pla');
                $suel_pla = $this->input->post('suel_pla');
                $this->mod_ajustes->update_planilla($codi_pla, array('esta_pla' => 'A'));
                $this->session->set_userdata('info_planilla', 'La planilla con el sueldo S/. ' . $suel_pla . ' ha sido habilitado existosamente. Esta es su planilla actual.');
                header('Location: ' . base_url('ajustes'));
            } else
            // CONCEPTO-GASTO
            if ($this->input->post('registrar_concepto')) {
                $data['fech_con'] = $ajustes['datetime'];
                $data['codi_usu'] = $this->session->userdata('user_codi');
                $data['nomb_con'] = $this->input->post('nomb_con');
                $data['esta_con'] = 'A';
                $this->mod_ajustes->insert_concepto($data);
                $this->session->set_userdata('info_concepto', 'El concepto de gasto ' . $data['nomb_con'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('editar_concepto')) {
                $codi_con = $this->input->post('codi_con_e');
                $data['nomb_con'] = $this->input->post('nomb_con_e');
                $this->mod_ajustes->update_concepto($codi_con, $data);
                $this->session->set_userdata('info_concepto', 'El concepto de gasto ' . $data['nomb_con'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('activar_concepto')) {
                $codi_con = $this->input->post('codi_con');
                $nomb_con = $this->input->post('nomb_con');
                $this->mod_ajustes->update_concepto($codi_con, array('esta_con' => 'A'));
                $this->session->set_userdata('info_concepto', 'El concepto de gasto ' . $nomb_con . ' ha sido habilitado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('desactivar_concepto')) {
                $codi_con = $this->input->post('codi_con');
                $nomb_con = $this->input->post('nomb_con');
                $this->mod_ajustes->update_concepto($codi_con, array('esta_con' => 'D'));
                $this->session->set_userdata('info_concepto', 'El concepto de gasto ' . $nomb_con . ' ha sido deshabilitado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else
            // COMPROBANTE
            if ($this->input->post('registrar_comprobante')) {
                $data['fech_reg'] = $ajustes['datetime'];
                $data['nomb_com'] = $this->input->post('nomb_com');
                $data['serie_com'] = $this->input->post('serie_com');
                $data['nume_com'] = $this->input->post('nume_com');
                $data['obsv_com'] = $this->input->post('obsv_com');
                $data['esta_com'] = 'A';
                $this->mod_ajustes->insert_comprobante($data);
                $this->session->set_userdata('info_comprobante', 'El comprobante ' . $data['nomb_com'] . ' ha sido registrado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('editar_comprobante')) {
                $codi_com = $this->input->post('codi_com_e');
                $data['nomb_com'] = $this->input->post('nomb_com_e');
                $data['serie_com'] = $this->input->post('serie_com_e');
                $data['nume_com'] = $this->input->post('nume_com_e');
                $data['obsv_com'] = $this->input->post('obsv_com_e');
                $this->mod_ajustes->update_comprobante($codi_com, $data);
                $this->session->set_userdata('info_comprobante', 'El comprobante ' . $data['nomb_com'] . ' ha sido actualizado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('activar_comprobante')) {
                $codi_com = $this->input->post('codi_com');
                $nomb_com = $this->input->post('nomb_com');
                $this->mod_ajustes->update_comprobante($codi_com, array('esta_com' => 'A'));
                $this->session->set_userdata('info_comprobante', 'El comprobante ' . $nomb_com . ' ha sido habilitado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else if ($this->input->post('desactivar_comprobante')) {
                $codi_com = $this->input->post('codi_com');
                $nomb_com = $this->input->post('nomb_com');
                $this->mod_ajustes->update_comprobante($codi_com, array('esta_com' => 'D'));
                $this->session->set_userdata('info_comprobante', 'El comprobante ' . $nomb_com . ' ha sido deshabilitado existosamente.');
                header('Location: ' . base_url('ajustes'));
            } else {
                // NEGOCIO
                $ajustes["form_negocio"] = array('role' => 'form', "id" => "form_negocio");
                $ajustes["ruc_neg"] = array('id' => 'ruc_neg', 'name' => 'ruc_neg', 'class' => "form-control", 'maxlength' => '11', 'required' => 'true');
                $ajustes["nomb_neg"] = array('id' => 'nomb_neg', 'name' => 'nomb_neg', 'class' => "form-control", 'maxlength' => '50', 'required' => 'true');
                $ajustes["dire_neg"] = array('id' => 'dire_neg', 'name' => 'dire_neg', 'class' => "form-control", 'maxlength' => '100', 'required' => 'true');
                $ajustes["tel1_neg"] = array('id' => 'tel1_neg', 'name' => 'tel1_neg', 'class' => "form-control", 'maxlength' => '20', 'required' => 'true');
                $ajustes["tel2_neg"] = array('id' => 'tel2_neg', 'name' => 'tel2_neg', 'class' => "form-control", 'maxlength' => '20',);
                $ajustes["email_neg"] = array('id' => 'email_neg', 'name' => 'email_neg', 'class' => "form-control", 'maxlength' => '50', 'type' => 'email');
                $ajustes["web_neg"] = array('id' => 'web_neg', 'name' => 'web_neg', 'class' => "form-control", 'maxlength' => '100');
                $ajustes["desc_neg"] = array('id' => 'desc_neg', 'name' => 'desc_neg', 'class' => "form-control input-lg", 'placeholder' => "Escriba una descripci&oacute;n de la empresa...", "maxlength" => "1000", "rows" => "3", "autocomplete" => "off");
                $ajustes["registrar_negocio"] = array('name' => 'registrar_negocio', 'class' => "btn btn-primary", 'value' => "Actualizar datos de la empresa");
                // IGV
                $ajustes["form_igv"] = array('role' => 'form', "id" => "form_igv");
                $ajustes["igv_pla"] = array('id' => 'igv_pla', 'name' => 'igv_pla', 'class' => "form-control input-lg", "min" => "1", 'required' => 'true', 'autocomplete' => 'off', "type" => "number", "step" => "any");
                $ajustes["registrar_igv"] = array('name' => 'registrar_igv', 'class' => "btn btn-primary btn-sm", 'value' => "Actualizar IGV");
                // MUNERACION INCIAL DE ORDEN
                $ajustes["form_num_orden"] = array('role' => 'form', "id" => "form_num_orden");
                $ajustes["num_ini_orden"] = array('id' => 'num_ini_orden', 'name' => 'num_ini_orden', 'class' => "form-control", 'maxlength' => '50', 'required' => 'true', "type" => "text");
                $ajustes["registrar_num_orden"] = array('name' => 'registrar_num_orden', 'class' => "btn btn-primary btn-sm", 'value' => "Iniciar Numeración");
                // MUNERACION INCIAL DE FACTURA
                $ajustes["form_num_factura"] = array('role' => 'form', "id" => "form_num_factura");
                $ajustes["num_ini_factura"] = array('id' => 'num_ini_factura', 'name' => 'num_ini_factura', 'class' => "form-control", 'maxlength' => '50', 'required' => 'true', "type" => "text");
                $ajustes["registrar_num_factura"] = array('name' => 'registrar_num_factura', 'class' => "btn btn-primary btn-sm", 'value' => "Iniciar Numeración");

                // PLANILLA INSERT
                $ajustes["form_planilla"] = array('role' => 'form', "id" => "form_planilla");
                $ajustes["fech_pla"] = array('id' => 'fech_pla', 'name' => 'fech_pla', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["suel_pla"] = array('id' => 'suel_pla', 'name' => 'suel_pla', 'class' => "form-control input-lg", "min" => "0", 'required' => 'true', 'autocomplete' => 'off', 'value' => "0", "type" => "number", "step" => "any");
                $ajustes["obsv_pla"] = array('id' => 'obsv_pla', 'name' => 'obsv_pla', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "100", "rows" => "5", "autocomplete" => "off");
                $ajustes["registrar_planilla"] = array('id' => 'registrar_planilla', 'name' => 'registrar_planilla', 'class' => "btn btn-primary", 'value' => "Registrar planilla");
                // PLANILLA EDIT
                $ajustes["form_planilla_edit"] = array('role' => 'form', "id" => "form_planilla_edit");
                $ajustes["fech_pla_e"] = array('id' => 'fech_pla_e', 'name' => 'fech_pla_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["codi_pla_e"] = array('id' => 'codi_pla_e', 'name' => 'codi_pla_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["suel_pla_e"] = array('id' => 'suel_pla_e', 'name' => 'suel_pla_e', 'class' => "form-control input-lg", "min" => "1", 'required' => 'true', 'autocomplete' => 'off', 'value' => "1", "type" => "number", "step" => "any");
                $ajustes["obsv_pla_e"] = array('id' => 'obsv_pla_e', 'name' => 'obsv_pla_e', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "100", "rows" => "5", "autocomplete" => "off");
                $ajustes["editar_planilla"] = array('id' => 'editar_planilla', 'name' => 'editar_planilla', 'class' => "btn btn-primary", 'value' => "Editar planilla");

                // CONCEPTO-GASTO INSERT
                $ajustes["form_concepto"] = array('role' => 'form', "id" => "form_concepto");
                $ajustes["fech_con"] = array('id' => 'fech_con', 'name' => 'fech_con', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["nomb_usu"] = array('id' => 'nomb_usu', 'name' => 'nomb_usu', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["nomb_con"] = array('id' => 'nomb_con', 'name' => 'nomb_con', 'class' => "form-control", 'required' => 'true');
                $ajustes["registrar_concepto"] = array('name' => 'registrar_concepto', 'class' => "btn btn-primary", 'value' => "Registrar concepto de gasto");
                // CONCEPTO-GASTO EDIT
                $ajustes["form_concepto_edit"] = array('role' => 'form', "id" => "form_concepto_edit");
                $ajustes["fech_con_e"] = array('id' => 'fech_con_e', 'name' => 'fech_con_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["codi_con_e"] = array('id' => 'codi_con_e', 'name' => 'codi_con_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["nomb_usu_e"] = array('id' => 'nomb_usu_e', 'name' => 'nomb_usu_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["nomb_con_e"] = array('id' => 'nomb_con_e', 'name' => 'nomb_con_e', 'class' => "form-control", 'required' => 'true');
                $ajustes["editar_concepto"] = array('name' => 'editar_concepto', 'class' => "btn btn-primary", 'value' => "Editar concepto de gasto");

                // COMPROBANTE INSERT
                $ajustes["form_comprobante"] = array('role' => 'form', "id" => "form_comprobante");
                $ajustes["nomb_com"] = array('id' => 'nomb_com', 'name' => 'nomb_com', 'class' => "form-control", 'required' => 'true');
                $ajustes["serie_com"] = array('id' => 'serie_com', 'name' => 'serie_com', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', "min" => "0", 'value' => "0", "maxlength" => "4", "type" => "number", "step" => "any");
                $ajustes["nume_com"] = array('id' => 'nume_com', 'name' => 'nume_com', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', "min" => "0", 'value' => "0", "maxlength" => "6", "type" => "number", "step" => "any");
                $ajustes["obsv_com"] = array('id' => 'obsv_com', 'name' => 'obsv_com', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "150", "rows" => "3", "autocomplete" => "off");
                $ajustes["registrar_comprobante"] = array('id' => 'registrar_comprobante', 'name' => 'registrar_comprobante', 'class' => "btn btn-primary", 'value' => "Registrar comprobante");
                // COMPROBANTE EDIT
                $ajustes["form_comprobante_edit"] = array('role' => 'form', "id" => "form_comprobante_edit");
                $ajustes["fech_reg_e"] = array('id' => 'fech_reg_e', 'name' => 'fech_reg_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["codi_com_e"] = array('id' => 'codi_com_e', 'name' => 'codi_com_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
                $ajustes["nomb_com_e"] = array('id' => 'nomb_com_e', 'name' => 'nomb_com_e', 'class' => "form-control", 'required' => 'true');
                $ajustes["serie_com_e"] = array('id' => 'serie_com_e', 'name' => 'serie_com_e', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', "min" => "0", 'value' => "0", "maxlength" => "4", "type" => "number", "step" => "any");
                $ajustes["nume_com_e"] = array('id' => 'nume_com_e', 'name' => 'nume_com_e', 'class' => "form-control input-lg", 'required' => 'true', 'autocomplete' => 'off', "min" => "0", 'value' => "0", "maxlength" => "6", "type" => "number", "step" => "any");
                $ajustes["obsv_com_e"] = array('id' => 'obsv_com_e', 'name' => 'obsv_com_e', 'class' => "form-control input-lg", 'placeholder' => "Escriba la observación...", "maxlength" => "150", "rows" => "3", "autocomplete" => "off");
                $ajustes["editar_comprobante"] = array('id' => 'editar_comprobante', 'name' => 'editar_comprobante', 'class' => "btn btn-primary", 'value' => "Editar comprobante");

                // VIEW ALL
                $data['page'] = 'Panel de configuraci&oacute;n';
                $data['container'] = $this->load->view('ajustes/ajustes_view', $ajustes, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function get_planilla() {
        $data = array();
        $cajas = $this->mod_view->view('planilla');
        foreach ($cajas as $row) {
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

    public function paginate_planilla() {
        $nTotal = $this->mod_view->count('planilla');
        $planillas = $this->mod_ajustes->get_planilla_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($planillas as $row) {
            $estado = "";
            $opciones = "";
            if ($row->esta_pla == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url('ajustes'), $form_a) . ' 
                                <input type="hidden" name="codi_pla" value="' . $row->codi_pla . '">
                                <input type="hidden" name="suel_pla" value="' . $row->suel_pla . '">
                                <input name="activar_planilla" type="submit" class="tooltip_planilla btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar esta planilla">
                                ' . form_close() . '
                            </span>';
            } else if ($row->esta_pla == "A") {
                $estado = "Planilla vigente";
                $opciones = '<button type="button" class="tooltip_planilla btn btn-success btn-circle editar_planilla" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-edit"></i>
                        </button>';
            }
            $opciones .= "<script>$('.tooltip_planilla').tooltip();</script>";

            $time = strtotime($row->fech_pla);
            $fecha = date("d/m/Y g:i A", $time);

            $observa = "-";
            if ($row->obsv_pla != "") {
                $observa = $row->obsv_pla;
            }

            $aaData[] = array(
                $row->codi_pla,
                $fecha,
                $row->suel_pla,
                $observa,
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

    public function get_concepto() {
        $data = array();
        $cajas = $this->mod_view->view('v_concepto');
        foreach ($cajas as $row) {
            $data[$row->codi_con] = array(
                $row->codi_con,
                $row->fech_con,
                $row->nomb_usu,
                $row->nomb_con,
                $row->esta_con
            );
        }
        echo json_encode($data);
    }

    public function paginate_concepto() {
        $nTotal = $this->mod_view->count('v_concepto');
        $conceptos = $this->mod_ajustes->get_concepto_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($conceptos as $row) {
            $estado = "";
            $opciones = '<button type="button" class="tooltip_concepto btn btn-success btn-circle editar_concepto" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-edit"></i>
                        </button>&nbsp;';
            if ($row->esta_con == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url('ajustes'), $form_a) . ' 
                                <input type="hidden" name="codi_con" value="' . $row->codi_con . '">
                                <input type="hidden" name="nomb_con" value="' . $row->nomb_con . '">
                                <input name="activar_concepto" type="submit" class="tooltip_concepto btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar este concepto">
                                ' . form_close() . '
                            </span>';
            } else if ($row->esta_con == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url('ajustes'), $form_a) . ' 
                                <input type="hidden" name="codi_con" value="' . $row->codi_con . '">
                                <input type="hidden" name="nomb_con" value="' . $row->nomb_con . '">
                                <input name="desactivar_concepto" type="submit" class="tooltip_concepto btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar este concepto">
                                ' . form_close() . '
                            </span>';
            }
            $opciones .= "<script>$('.tooltip_concepto').tooltip();</script>";

            $time = strtotime($row->fech_con);
            $fecha = date("d/m/Y g:i A", $time);

            $aaData[] = array(
                $row->codi_con,
                $fecha,
                $row->nomb_usu,
                $row->nomb_con,
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

    public function get_comprobante() {
        $data = array();
        $comprobantes = $this->mod_view->view('comprobante');
        foreach ($comprobantes as $row) {
            $data[$row->codi_com] = array(
                $row->codi_com,
                $row->fech_reg,
                $row->nomb_com,
                $row->serie_com,
                $row->nume_com,
                $row->obsv_com,
                $row->esta_com
            );
        }
        echo json_encode($data);
    }

    public function paginate_comprobante() {
        $nTotal = $this->mod_view->count('comprobante');
        $comprobantes = $this->mod_ajustes->get_comprobante_paginate($_POST['iDisplayLength'], $_POST['iDisplayStart'], $_POST['sSearch']);
        $form_a = array('role' => 'form', "style" => "display: inline-block;");
        $aaData = array();

        foreach ($comprobantes as $row) {
            $estado = "";
            $opciones = '<button type="button" class="tooltip_comprobante btn btn-success btn-circle editar_comprobante" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fa fa-edit"></i>
                        </button>&nbsp;';
            if ($row->esta_com == "D") {
                $estado = "Deshabilitado";
                $opciones .= '<span>' . form_open(base_url('ajustes'), $form_a) . ' 
                                <input type="hidden" name="codi_com" value="' . $row->codi_com . '">
                                <input type="hidden" name="nomb_com" value="' . $row->nomb_com . '">
                                <input name="activar_comprobante" type="submit" class="tooltip_comprobante btn btn-primary btn-circle fa" value="&#xf00c;" data-toggle="tooltip" data-placement="top" title="Habilitar este comprobante">
                                ' . form_close() . '
                            </span>';
            } else if ($row->esta_com == "A") {
                $estado = "Habilitado";
                $opciones .= '<span>' . form_open(base_url('ajustes'), $form_a) . ' 
                                <input type="hidden" name="codi_com" value="' . $row->codi_com . '">
                                <input type="hidden" name="nomb_com" value="' . $row->nomb_com . '">
                                <input name="desactivar_comprobante" type="submit" class="tooltip_comprobante btn btn-danger btn-circle fa" value="&#xf00d;" data-toggle="tooltip" data-placement="top" title="Deshabilitar este comprobante">
                                ' . form_close() . '
                            </span>';
            }
            $opciones .= "<script>$('.tooltip_comprobante').tooltip();</script>";

            $time = strtotime($row->fech_reg);
            $fecha = date("d/m/Y g:i A", $time);

            $observa = "-";
            if ($row->obsv_com != "") {
                $observa = $row->obsv_com;
            }

            $aaData[] = array(
                $row->codi_com,
                $fecha,
                $row->nomb_com,
                $row->serie_com,
                $row->nume_com,
                $observa,
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
