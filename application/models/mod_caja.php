<?php

class mod_caja extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function validar_caja_dia($fecha) {
        $this->db->where(array('DATE(fein_cad)' => $fecha, 'esta_cad' => 'A'));
        $query = $this->db->get('caja_dia');
        $result = $query->result();
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_vcaja($fecha) {
        $this->db->select('*');
        $this->db->from('caja');
        $this->db->where(array('(SELECT DATE(`caja_dia`.`fein_cad`) FROM `caja_dia`
                     WHERE `caja`.`codi_caj` = `caja_dia`.`codi_caj`) =' => $fecha));
        $query = $this->db->get();
        return $query->result();
    }

}
