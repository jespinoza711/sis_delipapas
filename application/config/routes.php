<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['login'] = "usuario/login";
$route['close'] = "usuario/close";
$route['venta'] = "caja/venta";
$route['compra'] = "caja/compra";
$route['cajachica'] = "caja/caja_chica";
$route['registrodiario'] = "registro/registro_diario";
$route['inventario'] = "producto/inventario";
$route['usuario'] = "usuario";
$route['empleado'] = "empleado";
$route['proveedor'] = "proveedor";
$route['cliente'] = "cliente";
$route['producto'] = "producto/producto";
$route['ajustes'] = "ajustes";
$route['reporte'] = "reporte";

$route['default_controller'] = "home";
$route['404_override'] = '';
