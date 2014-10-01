<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('show_menu')) {

    function show_menu($codi_rol = "0") {
        if ($codi_rol == "1") {
            // Menu para Administrador
            return
                    '<li><a href="' . base_url('home') . '"><i class="glyphicon glyphicon-home"></i> &nbsp; Inicio </a></li>' .
                    '<li><a href="' . base_url('venta') . '"><i class="glyphicon glyphicon-usd"></i> &nbsp; Ventas </a></li>' .
                    '<li><a href="' . base_url('compra') . '"><i class="glyphicon glyphicon-shopping-cart"></i> &nbsp; Compras </a></li>' .
                    '<li><a href="' . base_url('pagoempleado') . '"><i class="glyphicon glyphicon-user"></i> &nbsp; Pagos </a></li>' .
                    '<li><a href="' . base_url('inventario') . '"><i class="glyphicon glyphicon-list-alt"></i> &nbsp; Inventario </a></li>' .
                    '<li class="treeview"><a href="#"><span><i class="glyphicon glyphicon-pencil"></i> &nbsp; Registros </span><i class="fa pull-right fa-angle-down"></i></a>' .
                        '<ul class="treeview-menu" style="display: none;">' .
                            '<li><a href="' . base_url('usuario') . '"><i class="fa fa-angle-double-right"></i>Usuario</a></li>' .
                            '<li><a href="' . base_url('proveedor') . '"><i class="fa fa-angle-double-right"></i>Proveedor</a></li>' .
                            '<li><a href="' . base_url('cliente') . '"><i class="fa fa-angle-double-right"></i>Cliente</a></li>' .
                            '<li><a href="' . base_url('empleado') . '"><i class="fa fa-angle-double-right"></i>Empleado</a></li>' .
                            '<li><a href="' . base_url('producto') . '"><i class="fa fa-angle-double-right"></i>Producto</a></li>' .
                            '<li><a href="' . base_url('caja') . '"><i class="fa fa-angle-double-right"></i>Caja</a></li>' .
                        '</ul>' .
                    '</li>' .
                    '<li><a href="' . base_url('reporte') . '"><i class="glyphicon glyphicon-folder-open"></i> &nbsp; Reportes </a></li>' .
                    '<li><a href="' . base_url('ajustes') . '"><i class="glyphicon glyphicon-wrench"></i> &nbsp; Ajustes </a></li>';
            
        } else if ($codi_rol == "2") {
            // Menu para Usuario
            return
                    '<li><a href="' . base_url('home') . '"><i class="glyphicon glyphicon-home"></i> &nbsp; Inicio </a></li>' .
                    '<li><a href="' . base_url('venta') . '"><i class="glyphicon glyphicon-usd"></i> &nbsp; Ventas </a></li>' .
                    '<li><a href="' . base_url('compra') . '"><i class="glyphicon glyphicon-shopping-cart"></i> &nbsp; Compras </a></li>' .
                    '<li><a href="' . base_url('pagoempleado') . '"><i class="glyphicon glyphicon-user"></i> &nbsp; Pagos </a></li>' .
                    '<li><a href="' . base_url('inventario') . '"><i class="glyphicon glyphicon-list-alt"></i> &nbsp; Inventario </a></li>' .
                    '<li><a href="' . base_url('reporte') . '"><i class="glyphicon glyphicon-folder-open"></i> &nbsp; Reportes </a></li>';
            
        } else {
            return '<li><a href="' . base_url() . 'login">Inicio de sesión</a></li>';
        }
    }

}