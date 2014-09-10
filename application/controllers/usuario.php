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
            $usuario["form"] = array('role' => 'form', "id" => "form_usu");
            $usuario["form_editar"] = array('role' => 'form', "id" => "form_usu_edit");
            $usuario["form_a"] = array('role' => 'form', "style" => "display: inline-block;");
            $usuario["login"] = array('id' => 'logi_usu', 'name' => 'login', 'class' => "form-control", 'placeholder' => "Nombre de usuario", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["pass"] = array('id' => 'pass_usu', 'name' => 'pass', 'class' => "form-control", 'placeholder' => "Contraseña", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["con_pass"] = array('id' => 'con_pass_usu', 'name' => 'con_pass', 'class' => "form-control", 'placeholder' => "Vuelva a ingresar contraseña", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["codigo_e"] = array('id' => 'codi_usu_e', 'name' => 'codigo', 'class' => "form-control", 'required' => 'true', 'readonly' => 'true');
            $usuario["login_e"] = array('id' => 'logi_usu_e', 'name' => 'login', 'class' => "form-control", 'placeholder' => "Nombre de usuario", "maxlength" => "16", 'required' => 'true', 'autocomplete' => 'off');
            $usuario["pass_e"] = array('id' => 'pass_usu_e', 'name' => 'pass', 'class' => "form-control", 'placeholder' => "Contraseña", "maxlength" => "16", 'autocomplete' => 'off');
            $usuario["con_pass_e"] = array('id' => 'con_pass_usu_e', 'name' => 'con_pass', 'class' => "form-control", 'placeholder' => "Vuelva a ingresar contraseña", "maxlength" => "16", 'autocomplete' => 'off');
            $usuario["registrar"] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");
            $usuario["editar"] = array('name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");

            $rol = $this->mod_usuario->get_rol();
            foreach ($rol as $row) {
                $roles[$row->codi_rol] = $row->nomb_rol;
            }
            $usuario["roles"] = $roles;
            if ($this->input->post('registrar')) {
                $logi_usu = $this->input->post('login');
                $pass_usu = md5($this->input->post('pass'));
                $codi_rol = $this->input->post('rol');

                $data = array(
                    'nomb_usu' => $logi_usu,
                    'pass_usu' => $pass_usu,
                    'codi_rol' => $codi_rol,
                    'esta_usu' => 'A'
                );
                $this->mod_usuario->insert_usu($data);
                $this->session->set_userdata('mensaje_usu', 'El usuario ' . $logi_usu . ' ha sido registrado existosamente');
            } else if ($this->input->post('editar')) {
                $codi_usu = $this->input->post('codigo');
                $logi_usu = $this->input->post('login');
                $pass_usu = md5($this->input->post('pass'));
                $codi_rol = $this->input->post('rol_e');

                $data = array(
                    'nomb_usu' => $logi_usu,
                    'codi_rol' => $codi_rol
                );

                if ($pass_usu != "") {
                    $data['pass_usu'] = $pass_usu;
                }

                $this->mod_usuario->update_usu($codi_usu, $data);
                $this->session->set_userdata('mensaje_usu', 'El usuario ' . $logi_usu . ' ha sido actualizado existosamente');
            } else if ($this->input->post('activar')) {
                $codi_usu = $this->input->post('codigo');
                $logi_usu = $this->input->post('usuario');
                $this->mod_usuario->update_usu($codi_usu, array("esta_usu" => "A"));
                $this->session->set_userdata('mensaje_usu', 'El usuario ' . $logi_usu . ' ha sido habilitado existosamente');
            } else if ($this->input->post('desactivar')) {
                $codi_usu = $this->input->post('codigo');
                $logi_usu = $this->input->post('usuario');
                $this->mod_usuario->update_usu($codi_usu, array("esta_usu" => "D"));
                $this->session->set_userdata('mensaje_usu', 'El usuario ' . $logi_usu . ' ha sido deshabilitado existosamente');
            }
            $data['page'] = 'Usuarios';
            $usuario['usuarios'] = $this->mod_usuario->get_tbl_usuario();
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
                $login["password"] = array('id' => 'clave_log', 'name' => 'clave', 'class' => "form-control", 'placeholder' => "ContraseÃ±a", 'required' => 'true');
                $login["inicio_sesion"] = array('name' => 'inicio_sesion', 'class' => "btn btn-lg btn-success btn-block", 'value' => "Ingresar");
                $this->load->view('login/login_view', $login);
            } else {
                $usuario = $this->input->post('usuario');
                $clave = md5($this->input->post('clave'));
                $usuarios = $this->mod_usuario->get_usuario();

                $acceso = false;
                foreach ($usuarios as $row) {
                    if ($row->nomb_usu == $usuario && $row->pass_usu == $clave && $row->esta_usu == 'A') {
                        $acceso = true;
                        $rol = $row->codi_rol;
                        break;
                    }
                }

                if ($acceso) {
                    $sesion_activa = array(
                        'estado_sesion' => 'A',
                        'logi_usu' => $usuario,
                        'codi_rol' => $rol,
                        'logged' => true
                    );
                    $this->session->set_userdata($sesion_activa);
                    header('Location: ' . base_url() . 'home');
                } else {
                    $this->session->set_userdata('error_login_1', 'El usuario y/o clave son incorrectas');
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
