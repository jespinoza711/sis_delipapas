<?php

class mod_producto extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert($data) {
        $this->db->insert('producto', $data);
    }

    function insert_tipo($data) {
        $this->db->insert('tipo_producto', $data);
    }

    function update($id, $data) {
        $this->db->where('codi_prod', $id);
        $this->db->update('producto', $data);
    }

    public function get_vproducto($where = array()) {
        $this->db->select('producto.codi_prod, producto.codi_tpro,producto.nomb_prod,producto.obsv_prod,'
                . 'producto.esta_prod,tipo_producto.nomb_tipo,producto.prec_prod, producto.stoc_prod, producto.fein_prod, producto.fesa_prod');
        $this->db->from('producto');
        $this->db->join('tipo_producto', 'producto.codi_tpro = tipo_producto.codi_tpro');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function get_vproducto_paginate($limit, $start, $string = "") {
        $this->db->like('codi_prod', $string);
        $this->db->or_like('nomb_tipo', $string);
        $this->db->or_like('nomb_prod', $string);
        $this->db->or_like('obsv_prod', $string);
        $query = $this->db->get('v_producto');
        $productos = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($productos as $row) {
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

    function get_vproducto_operacion_paginate($limit, $start, $string = "") {
        $this->db->like('codi_prod', $string);
        $this->db->or_like('nomb_tipo', $string);
        $this->db->or_like('nomb_prod', $string);
        $this->db->or_like('obsv_prod', $string);
        $query = $this->db->get('v_producto_compra');
        $productos = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($productos as $row) {
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

    function get_historial_compra_paginate($limit, $start, $string = "") {
        $this->db->like('codi_com', $string);
        $this->db->or_like('fech_com', $string);
        $this->db->or_like('nomb_usu', $string);
        $query = $this->db->get('v_compra');
        $productos = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($productos as $row) {
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

    function get_historial_compra_det_paginate($limit, $start, $string = "", $id = 1) {
        $this->db->or_like('nomb_tipo', $string);
        $this->db->or_like('nomb_prod', $string);
//        $this->db->where('codi_com', $id);
        $query = $this->db->get('v_compra_detalle');
        $compra_det = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($compra_det as $row) {
            if ($i >= $start) {
                if ($c < $limit) {
                    if ($row->codi_com == $id) {
                        $result[$c] = $row;
                        $c++;
                    }
                } else {
                    break;
                }
            }
            $i++;
        }
        return $result;
    }

    function get_historial_venta_paginate($limit, $start, $string = "") {
        $this->db->like('codi_ven', $string);
        $this->db->or_like('fech_ven', $string);
        $this->db->or_like('nomb_com', $string);
        $this->db->or_like('nomb_usu', $string);
        $this->db->or_like('nomb_cli', $string);
        $query = $this->db->get('v_venta_historial');
        $productos = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($productos as $row) {
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

    function get_historial_venta_det_paginate($limit, $start, $string = "", $id = 1) {
        $this->db->or_like('nomb_tipo', $string);
        $this->db->or_like('nomb_prod', $string);
        $query = $this->db->get('v_venta_detalle');
        $compra_det = $query->result();
        $i = 0;
        $c = 0;
        $result = array();
        foreach ($compra_det as $row) {
            if ($i >= $start) {
                if ($c < $limit) {
                    if ($row->codi_ven == $id) {
                        $result[$c] = $row;
                        $c++;
                    }
                } else {
                    break;
                }
            }
            $i++;
        }
        return $result;
    }

}
