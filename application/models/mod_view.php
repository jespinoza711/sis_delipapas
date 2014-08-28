<?php

class mod_view extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //PARAMETROS
    
    // $view -> VISTA O TABLA ('')
    // $from -> ESPECIFICA LA FILA DE INICIO DE LA CONSULTA (PARA IGNORAR COLOCAR FALSE)
    // $limit -> ESPECIFICA CUANTAS FILAS DE LA CONSULTA VA A DEVOLVER DESDE EL $from (PARA IGNORAR COLOCAR FALSE)
    // $where -> CONDICIONES PARA LA CONSULTA (ARRAY)

    // DEVUELVE UN CONSULTA NATIVA
    public function view($view, $from = 0, $limit = false, $where = false) {
        if ($where)
            $query = $this->db->where($where);
        if ($limit)
            $query = $this->db->limit($limit, $from);
        $query = $this->db->get($view);
        return $query->result();
    }

    // DEVUELVE UN CONSULTA EN FORMATO ARREGLO
    public function view_array($view, $from = 0, $limit = false, $where = false) {
        if ($where)
            $query = $this->db->where($where);
        if ($limit)
            $query = $this->db->limit($limit, $from);
        $query = $this->db->get($view);
        return $query->result_array();
    }

    // DEVUELVE UNA FILA NATIVA DE LA CONSULTA
    public function one($view, $from = 0, $limit = false, $where = false) {
        if ($where)
            $query = $this->db->where($where);
        if ($limit)
            $query = $this->db->limit($limit, $from);
        $query = $this->db->get($view);
        return $query->row();
    }

    // DEVUELVE UNA FILA EN FORMATO ARREGLO DE LA CONSULTA
    public function one_array($view, $from = 0, $limit = false, $where = false) {
        if ($where)
            $query = $this->db->where($where);
        if ($limit)
            $query = $this->db->limit($limit, $from);
        $query = $this->db->get($view);
        return $query->row_array();
    }

    // DEVUELVE EL NUMERO DE FILAS OBTENIDOS DE LA CONSULTA
    public function count($view, $from = 0, $limit = false, $where = false) {
        if ($where)
            $query = $this->db->where($where);
        if ($limit)
            $query = $this->db->limit($limit, $from);
        return $this->db->count_all_results($view);
    }

    // DEVUELVE EL VALOR DE UN COLUMNA ESPECIFICADA (SOLO APLICA A RESULTADOS DE UNA SOLA FILA)
    // $dato -> NOMBRE DE UNA COLUMNA ESPECIFICA A RETORNAR ('') SIEMPRE QUE LA CONSULTA SEA DE UNA SOLA FILA
    public function dato($view, $from = 0, $limit = false, $where = false, $dato = '') {
        if ($where)
            $query = $this->db->where($where);
        if ($limit)
            $query = $this->db->limit($limit, $from);
        $query = $this->db->get($view);
        $q = $query->row();
        return $q->$dato;
    }

    // DEVUELVE EL VALOR DE UN COLUMNA ESPECIFICADA MAS UN INCREMENTO ESPECIFICADO (SOLO APLICA A RESULTADOS DE UNA SOLA FILA)
    // $dato -> NOMBRE DE UNA COLUMNA ESPECIFICA ('') SIEMPRE QUE LA CONSULTA DEVUELVA UNA SOLA FILA
    // $mas -> VALOR A INCREMENTAR AL DATO ESPECIFICADO (RETORNA EL RESULTADO DE LA OPERACION)
    public function dato_mas($view, $from = 0, $limit = false, $where = false, $dato = '', $mas = 0) {
        if ($where)
            $query = $this->db->where($where);
        if ($limit)
            $query = $this->db->limit($limit, $from);
        $query = $this->db->get($view);
        $q = $query->row();
        return $q->$dato + $mas;
    }

}
