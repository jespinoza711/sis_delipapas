<?php

class mod_empleado extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_vempleado() {
        $this->db->select('empleado.codi_emp, empleado.nomb_emp,empleado.apel_emp,empleado.dire_emp,'
                . 'empleado.dni_emp,empleado.telf_emp,empleado.sexo_emp,empleado.afp_emp,'
                . 'empleado.civi_emp,empleado.esta_emp, empleado.codi_pla, empleado.codi_tem,'
                . 'tipo_empleado.nomb_tem, planilla.fech_pla, planilla.suel_pla, planilla.obsv_pla');
        $this->db->from('empleado');
        $this->db->join('tipo_empleado', 'tipo_empleado.codi_tem = empleado.codi_tem');
        $this->db->join('planilla', 'planilla.codi_pla = empleado.codi_pla');
        $query = $this->db->get();
        return $query->result();
    }

    function insert($data) {
        $this->db->insert('empleado', $data);
    }

    function insert_tipo($data) {
        $this->db->insert('tipo_empleado', $data);
    }

    function insert_pla($data) {
        $this->db->insert('planilla', $data);
    }

    function update($id, $data) {
        $this->db->where('codi_emp', $id);
        $this->db->update('empleado', $data);
    }

    function planilla_año($año) {
        $this->db->where('YEAR(fech_pla)', $año);
        $query = $this->db->get('planilla');
        return $query->result();
    }

}
