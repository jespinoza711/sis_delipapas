<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_config', 'mod_view', 'mod_usuario'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->mod_config->AVP(2)) {
            header('location: ' . base_url('login'));
        } else {
            $usuario["form_usu"] = array('role' => 'form', "id" => "form_usu");
            $usuario["form_usu_edit"] = array('role' => 'form', "id" => "form_usu_edit");
            $usuario["form_status"] = array('role' => 'form', "style" => "display: inline-block;");
            $usuario["nomb_usu"] = array('id' => 'nomb_usu', 'name' => 'nomb_usu', 'class' => "form-control", 'placeholder' => "Nombre de usuario", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["pass_usu"] = array('id' => 'pass_usu', 'name' => 'pass_usu', 'class' => "form-control", 'placeholder' => "Contraseña", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["pass_usu_con"] = array('id' => 'pass_usu_con', 'name' => 'pass_usu_con', 'class' => "form-control", 'placeholder' => "Vuelva a ingresar contraseña", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["codi_usu_e"] = array('id' => 'codi_usu_e', 'name' => 'codi_usu_e', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
            $usuario["nomb_usu_e"] = array('id' => 'nomb_usu_e', 'name' => 'nomb_usu_e', 'class' => "form-control", 'placeholder' => "Nombre de usuario", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["pass_usu_e"] = array('id' => 'pass_usu_e', 'name' => 'pass_usu_e', 'class' => "form-control", 'placeholder' => "Contraseña", "maxlength" => "16", 'autocomplete' => 'off');
            $usuario["pass_usu_con_e"] = array('id' => 'pass_usu_con_e', 'name' => 'pass_usu_con_e', 'class' => "form-control", 'placeholder' => "Vuelva a ingresar contraseña", "maxlength" => "16", 'autocomplete' => 'off');
            $usuario["registrar"] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");
            $usuario["editar"] = array('name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");
            $usuario["rol"] = $this->mod_view->view('rol', false, false, false);

            if ($this->input->post('registrar')) {
                $data['nomb_usu'] = $this->input->post('nomb_usu');
                $data['pass_usu'] = md5($this->input->post('pass_usu'));
                $data['codi_rol'] = $this->input->post('codi_rol');
                $data['esta_usu'] = 'A';
                if ($this->mod_usuario->register($data)) {
                    $this->session->set_userdata('info', 'El usuario ' . $data['nomb_usu'] . ' ha sido registrado existosamente.');
                } else {
                    $this->session->set_userdata('error', 'Se ha detenido el proceso, verif&iacute;ca que los datos no existan actualmente.');
                }
            } else if ($this->input->post('editar')) {
                $codi_usu = $this->input->post('codi_usu_e');
                $data['nomb_usu'] = $this->input->post('nomb_usu_e');
                $data['codi_rol'] = $this->input->post('codi_rol_e');
                if ($this->input->post('pass_usu_e') != "") {
                    $data['pass_usu'] = md5($this->input->post('pass_usu_e'));
                }
                if ($this->mod_usuario->update($codi_usu, $data)) {
                    $this->session->set_userdata('info', 'El usuario ' . $data['nomb_usu'] . ' ha sido actualizado existosamente.');
                } else {
                    $this->session->set_userdata('error', 'Los datos no han podido ser actualizados, intente nuevamente.');
                }
            } else if ($this->input->post('activar')) {
                $codi_usu = $this->input->post('codi_usu');
                $nomb_usu = $this->input->post('nomb_usu');
                if ($this->mod_usuario->update($codi_usu, array('esta_usu' => 'A'))) {
                    $this->session->set_userdata('info', 'El usuario ' . $nomb_usu . ' ha sido habilitado existosamente.');
                } else {
                    $this->session->set_userdata('error', 'No se ha podido realizar la operaci&oacute;n requerida.');
                }
            } else if ($this->input->post('desactivar')) {
                $codi_usu = $this->input->post('codi_usu');
                $nomb_usu = $this->input->post('nomb_usu');
                if ($this->mod_usuario->update($codi_usu, array('esta_usu' => 'D'))) {
                    $this->session->set_userdata('info', 'El usuario ' . $nomb_usu . ' ha sido deshabilitado existosamente.');
                } else {
                    $this->session->set_userdata('error', 'No se ha podido realizar la operaci&oacute;n requerida.');
                }
            }
            $data['page'] = 'Usuarios';
            $usuario['usuarios'] = $this->mod_view->view('v_usuario', false, false, false);
            $data['container'] = $this->load->view('usuario/usuario_view', $usuario, true);
            $this->load->view('home/body', $data);
        }
    }

    public function login() {
        if ($this->mod_config->AVP(1)) {
            header('Location: ' . base_url('home'));
        } else {
            $this->form_validation->set_rules('usuario', 'Username', 'required');
            $this->form_validation->set_rules('clave', 'Clave', 'required');

            if ($this->form_validation->run() == FALSE) {
                $login["form"] = array('role' => 'form');
                $login["usuario"] = array('id' => 'usuario_log', 'name' => 'usuario', 'class' => "form-control", 'placeholder' => "Usuario", 'required' => 'true');
                $login["password"] = array('id' => 'clave_log', 'name' => 'clave', 'class' => "form-control", 'placeholder' => "Clave", 'required' => 'true');
                $login["inicio_sesion"] = array('name' => 'inicio_sesion', 'class' => "btn btn-lg btn-success btn-block", 'value' => "Ingresar");
                $this->load->view('login/login_view', $login);
            } else {
                $data['user'] = $this->input->post('usuario');
                $data['pass'] = md5($this->input->post('clave'));
                if ($this->mod_usuario->session($data)) {
                    header('Location: ' . base_url('home'));
                } else {
                    $this->session->set_userdata('error', 'El usuario y/o clave son incorrectas o no estan resgistrados.');
                    header('Location: ' . base_url('login'));
                }
            }
        }
    }

    public function close() {
        if ($this->mod_config->AVP(1)) {
            $this->session->sess_destroy();
            header('Location: ' . base_url('login'));
        }
    }

}
