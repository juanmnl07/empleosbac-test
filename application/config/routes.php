<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['hola/ss'] = 'test/ms';

$route['cultura-de-innovacion'] = 'cultura_de_innovacion';
$route['carreras/(:any)/(:num)'] = 'carreras/detalle';
$route['puestos/(:any)/(:num)'] = 'puestos/detalle';
/*$route['historias/pagina/(:num)'] = 'historias/pagina';*/
$route['historias/categoria/(:any)/(:num)'] = 'historias/categoria';
$route['historias/tag/(:any)/(:num)'] = 'historias/tag';
$route['historias/(:any)/(:num)'] = 'historias/detalle';

$route['default_controller'] = 'inicio';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/*Usuario*/
$route['registro'] = 'usuario/registro';
$route['ingreso'] = 'usuario/index';
$route['micuenta'] = 'usuario/perfil';
$route['cerrar-sesion'] = 'usuario/cerrarSesion';
$route['sesion'] = 'usuario/obtenerSesion';
$route['listado-paises'] = 'usuario/ObtenerListadoPaises';
$route['recordar'] = 'recordar/index';
$route['cambio-clave/(:any)'] = 'recordar/cambioClave/$1';
$route['verificar-correo/(:any)'] = 'usuario/verificarDisponibilidadEmail/$1';
$route['verificar-validar-correo'] = 'usuario/verificarValidarCorreoElectronico';

/*Administradores*/
$route['admin/dashboard'] = 'usuario/dashboard';
$route['admin/puestos'] = 'puestos/listado_admin_general';

/*Puestos*/
$route['admin/puestos/crear'] = 'puestos/crear';
$route['admin/puestos/editar/(:any)'] = 'puestos/editar/$1';

/*Administracion aplicantes*/
$route['admin/aplicantes'] = 'aplicantes/index';
$route['admin/aplicantes/por-puesto/(:any)'] = 'aplicantes/porPuesto/$1';
$route['admin/aplicantes/detalle/(:any)'] = 'aplicantes/detalle_aplicante';
$route['admin/aplicantes/lista/(:any)'] = 'aplicantes/obtenerListaPuestosAplicadosPorAplicante/$1';
$route['admin/listado/bitacora'] = 'aplicantes/obtenerListadoEstadosBitacora';
$route['admin/estado/aplicante/(:any)/(:any)'] = 'aplicantes/consultarEstadoAplicante/$1/$2';
$route['admin/estado/aplicante/actualizar/(:any)/(:any)/(:any)'] = 'aplicantes/actualizarEstadoAplicante/$1/$2/$3';

$route['admin/usuario/cambia-pais/(:any)'] = 'usuario/cambiaPaisSession/$1';

/* Presencia regional */
$route['presencia-regional/(:any)/(:num)'] = 'presencia_regional/detalle';

/* Pruebas */
$route['interfaz/estado/aplicante/actualizar/(:any)/(:any)/(:any)'] = 'interfaz/actualizarEstadoAplicante/$1/$2/$3';
$route['interfaz/estado/aplicante/liberar/(:any)/(:any)'] = 'interfaz/liberarEstadoAplicante/$1/$2';
$route['interfaz/estado/aplicante/modificar-estado-directo/(:any)/(:any)'] = 'interfaz/liberarEstadoAplicanteDirecto/$1/$2';
$route['interfaz/puesto/agregar'] = 'interfaz/agregarPuesto';
$route['interfaz/puesto/actualizar/(:any)'] = 'interfaz/actualizarPuesto/$1';
$route['interfaz/aplicante/(:any)'] = 'interfaz/obtenerDetalleAplicante/$1'; //obtener detalle del aplicante costa rica
$route['interfaz/aplicante/desaplicar/(:any)/(:any)'] = 'interfaz/desaplicar/$1/$2';
$route['interfaz/aplicantes-costa-rica'] = 'interfaz/ObtenerAplicantesCostaRica'; //obtener aplicantes costa rica por carrera