<?php

class mod_empleado extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_vempleado($where = array()) {
        $this->db->select('empleado.codi_emp, empleado.nomb_emp,empleado.apel_emp,empleado.dire_emp,'
                . 'empleado.dni_emp,empleado.telf_emp,empleado.sexo_emp,empleado.afp_emp,'
                . 'empleado.civi_emp,empleado.esta_emp, empleado.codi_pla, empleado.codi_tem,'
                . 'tipo_empleado.nomb_tem, planilla.fech_pla, planilla.suel_pla, planilla.obsv_pla');
        $this->db->from('empleado');
        $this->db->join('tipo_empleado', 'tipo_empleado.codi_tem = empleado.codi_tem');
        $this->db->join('planilla', 'planilla.codi_pla = empleado.codi_pla');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function get_vempleado_paginate($limit, $start, $string = "") {
        $this->db->select('empleado.codi_emp, empleado.nomb_emp,empleado.apel_emp,empleado.dire_emp,'
                . 'empleado.dni_emp,empleado.telf_emp,empleado.sexo_emp,empleado.afp_emp,'
                . 'empleado.civi_emp,empleado.esta_emp, empleado.codi_pla, empleado.codi_tem,'
                . 'tipo_empleado.nomb_tem, planilla.fech_pla, planilla.suel_pla, planilla.obsv_pla');
        $this->db->from('empleado');
        $this->db->join('tipo_empleado', 'tipo_empleado.codi_tem = empleado.codi_tem');
        $this->db->join('planilla', 'planilla.codi_pla = empleado.codi_pla');
        $this->db->like('empleado.codi_emp', $string);
        $this->db->or_like('empleado.nomb_emp', $string);
        $this->db->or_like('empleado.apel_emp', $string);
        $this->db->or_like('empleado.dire_emp', $string);
        $this->db->or_like('empleado.dni_emp', $string);
        $this->db->or_like('empleado.telf_emp', $string);
        $this->db->or_like('empleado.sexo_emp', $string);
        $this->db->or_like('empleado.afp_emp', $string);
        $this->db->or_like('empleado.civi_emp', $string);
        $this->db->or_like('empleado.esta_emp', $string);
        $this->db->or_like('empleado.codi_pla', $string);
        $this->db->or_like('empleado.codi_tem', $string);
        $this->db->or_like('tipo_empleado.nomb_tem', $string);
        $this->db->or_like('planilla.fech_pla', $string);
        $this->db->or_like('planilla.suel_pla', $string);
        $this->db->or_like('planilla.obsv_pla', $string);
        $this->db->or_like("CONCAT(empleado.nomb_emp,' ',empleado.apel_emp)", $string);
        $query = $this->db->get();
        $empleados = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($empleados as $row) {
            if ($i >= $start) {
                if ($c < $limit) {
                    $result[$c] = $row;
                    $c++;
                } else {
                    break;
                }
            }
            $i++;
        }
        return $result;
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
        $this->db->where(array('YEAR(fech_pla)' => $año));
        $query = $this->db->get('planilla');
        return $query->result();
    }
    
    function registro_diario_dia($data){
        $this->db->set('fech_dpl', 'sysdate()', false);
        return $this->db->insert('registro_planilla', $data);;
    }

}
