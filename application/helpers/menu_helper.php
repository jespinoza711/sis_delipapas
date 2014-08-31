<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('show_menu')) {

    function show_menu($codi_rol = "0") {
        if ($codi_rol == "1") {
            // Menu para Administrador
            return
                    "<li>"
                    . '<a href="' . base_url() . 'citas">Inicio</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'odontograma2">Ventas</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'paciente">Compras</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'medico">Inventario</a>'
                    . "</li>" .
                    '<li class="active">' .
                    '<a href="#" >'
                    . 'Registros'
                    
                    . '</a>' .
                        '<ul class="">' .
                            "<li>" .
                            '<a href="' . base_url() . 'usuario">Usuario</a>' .
                            "</li>" .
                            "<li>" .
                            '<a href="' . base_url() . 'proveedor">Proveedor</a>' .
                            "</li>" .
                            
                            "<li>" .
                            '<a href="' . base_url() . 'cliente">Cliente</a>' .
                            "</li>" .
                            "<li>" .
                            '<a href="' . base_url() . 'empleado">Empleado</a>' .
                            "</li>" .
                            "<li>" .
                            '<a href="' . base_url() . 'producto">Producto</a>' .
                            "</li>" .
                        '</ul>' .
                    "</li>".
                    "<li>" .
                        '<a href="' . base_url() . 'test/ancho_completo">Reportes</a>' .
                    "</li>".
                    "<li>" .
                        '<a href="' . base_url() . 'test/ancho_completo">Ajustes</a>' .
                    "</li>";
        } else if ($codi_rol == "2") {
            // Menu para Usuario
            return
//                    "<li>"
//                    . '<a href="' . base_url() . 'about">Acerca de nosotros</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'services">Servicios</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'contact">Contacto</a>'
//                    . "</li>" .
//                    '<li class="dropdown">' .
//                    '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Test <b class="caret"></b></a>' .
//                    '<ul class="dropdown-menu">' .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/ancho_completo">Ancho completo</a>' .
//                    "</li>" .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/sidebar">Página con barra</a>' .
//                    "</li>" .
//                    '</ul>' .
//                    "</li>" .

                    "<li>"
                    . '<a href="' . base_url() . 'citas">Citas médicas</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'paciente">Pacientes</a>'
                    . "</li>" .
                    "<li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'close">Cerrar sesión</a>'
                    . "</li>";
        } else {
            return
//                    "<li>"
//                    . '<a href="' . base_url() . 'about">Acerca de nosotros</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'services">Servicios</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'contact">Contacto</a>'
//                    . "</li>" .
//                    '<li class="dropdown">' .
//                    '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Test <b class="caret"></b></a>' .
//                    '<ul class="dropdown-menu">' .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/ancho_completo">Ancho completo</a>' .
//                    "</li>" .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/sidebar">Página con barra</a>' .
//                    "</li>" .
//                    '</ul>' .
//                    "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'login">Inicio de sesión</a>'
                    . "</li>";
        }
    }

}