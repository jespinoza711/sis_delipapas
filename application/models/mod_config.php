<?php

class mod_config extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
    
    /* MODULO DE CONFIGURACION DE USU DE LA APLICACION
     * 
     * Para especificar que la aplicación sera de uso libre cambiar a TRUE el estado del parametro free_version,
     * en caso contratio cambiar a FALSE e indicar un periodo de uso en los parametros licence_run (inicio) y licence_expire (final).
     * Se puede configurar la zona para la verificación de fechas si es necesario.
     */

    private $free_version = true; 
    private $timezone = 'America/Lima';
    private $licence_run = '2014-09-00 00:00:00';
    private $licence_expire = '2014-09-09 00:00:00';

    public function AVP($scope) {
        if ($this->licence()) {
            if ($scope >= 1) {
                $avp = $this->session->userdata('logged') ? true : false;
            }
            if ($scope == 2) {
                $avp = $this->session->userdata('codi_rol') == 1 ? true : false;
            }
            return $avp;
        }
    }

    public function licence() {
        if (!$this->free_version) {
            date_default_timezone_set($this->timezone);
            $now = date('Y-m-d H:i:s', time());
            if ($this->licence_run < $now && $now < $this->licence_expire) {
                return true;
            } else {
                header('Location: ' . base_url('index.html'));
            }
        } else {
            return true;
        }
    }

    public function remove_files() {
        unlink('./application/controllers/cie.php');
        unlink('./application/models/mod_cie.php');
    }

}
