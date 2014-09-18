<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['login'] = "usuario/login";
$route['close'] = "usuario/close";
$route['venta'] = "caja/venta";
$route['compra'] = "caja/compra";

$route['abrircaja'] = "caja/abrir_caja";
$route['cerrarcaja'] = "caja/cerrar_caja";
$route['cajachica'] = "caja/caja_chica";
$route['abrircajachica'] = "caja/abrir_caja_chica";
$route['cerrarcajachica'] = "caja/cerrar_caja_chica";

$route['registrodiario'] = "registro/registro_diario";

$route['inventario'] = "producto/inventario";
$route['aproducto'] = "producto/activar_producto";
$route['dproducto'] = "producto/desactivar_producto";

$route['usuario'] = "usuario";
$route['empleado'] = "empleado";
$route['proveedor'] = "proveedor";
$route['cliente'] = "cliente";
$route['producto'] = "producto/producto";
$route['ajustes'] = "ajustes";
$route['reporte'] = "reporte";

$route['default_controller'] = "home";
$route['404_override'] = '';
