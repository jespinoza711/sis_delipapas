<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('show_menu')) {

    function show_menu($codi_rol = "0") {
        if ($codi_rol == "1") {
            // Menu para Administrador
            return
                    '<li><a href="' . base_url('home') . '">Inicio</a></li>' .
                    '<li><a href="' . base_url('venta') . '">Ventas</a></li>' .
                    '<li><a href="' . base_url('compra') . '">Compras</a></li>' .
                    '<li><a href="' . base_url('inventario') . '">Inventario</a></li>' .
                    '<li class="active"><a href="#">Registros</a>' .
                        '<ul class="">' .
                            '<li><a href="' . base_url('usuario') . '">Usuario</a></li>' .
                            '<li><a href="' . base_url('proveedor') . '">Proveedor</a></li>' .
                            '<li><a href="' . base_url('cliente') . '">Cliente</a></li>' .
                            '<li><a href="' . base_url('empleado') . '">Empleado</a></li>' .
                            '<li><a href="' . base_url('producto') . '">Producto</a></li>' .
                        '</ul>' .
                    '</li>' .
                    '<li><a href="' . base_url('reporte') . '">Reportes</a></li>' .
                    '<li><a href="' . base_url('ajustes') . '">Ajustes</a></li>';
            
        } else if ($codi_rol == "2") {
            // Menu para Usuario
            return
                    '<li><a href="' . base_url('home') . '">Inicio</a></li>' .
                    '<li><a href="' . base_url('venta') . '">Ventas</a></li>' .
                    '<li><a href="' . base_url('compra') . '">Compras</a></li>' .
                    '<li><a href="' . base_url('inventario') . '">Inventario</a></li>' .
                    '<li><a href="' . base_url('reporte') . '">Reportes</a></li>';
            
        } else {
            return '<li><a href="' . base_url() . 'login">Inicio de sesión</a></li>';
        }
    }

}