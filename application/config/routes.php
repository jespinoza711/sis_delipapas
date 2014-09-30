<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['login'] = "usuario/login";
$route['close'] = "usuario/close";
$route['venta'] = "caja/venta";
$route['hisventa'] = "caja/historial_venta/0";

$route['compra'] = "caja/compra";
$route['hiscompra'] = "caja/historial_compra/0";

$route['abrircaja'] = "caja/abrir_caja";
$route['opencaja'] = "caja/open_caja";
$route['cerrarcaja'] = "caja/cerrar_caja";
$route['closecaja'] = "caja/close_caja";
$route['cajachica'] = "caja/caja_chica";
$route['abrircajachica'] = "caja/abrir_caja_chica";
$route['opencajachica'] = "caja/open_caja_chica";
$route['cerrarcajachica'] = "caja/cerrar_caja_chica";
$route['closecajachica'] = "caja/close_caja_chica";
$route['cajachicainsert'] = "caja/registro_gasto_caja_chica";
$route['cajachicaedit'] = "caja/edit_gasto_caja_chica";
$route['cajachicaeditall'] = "caja/edit_gasto_caja_chica_all";
$route['hiscajachica'] = "caja/history_caja_chica";

$route['registrodiario'] = "registro/registro_diario";
$route['regdiarioinsert'] = "registro/registro_diario_dia";
$route['regdiarioedit'] = "registro/registro_diario_dia_edit";

$route['pagoempleado'] = "registro/pago_empleado";
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
