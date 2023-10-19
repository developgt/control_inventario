<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\AlmacenController;
use Controllers\EstadoController;
use Controllers\UnimedidaController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

////rutas para manejar la vista y funciones del almacen
$router->get('/almacen', [AlmacenController::class,'index']);
$router->get('/API/almacen/buscarDependencia', [AlmacenController::class, 'buscarDependenciaAPI']);
$router->post('/API/almacen/guardar', [AlmacenController::class,'guardarAPI'] );
$router->get('/API/almacen/buscar', [AlmacenController::class, 'buscarAPI']);
$router->post('/API/almacen/modificar', [AlmacenController::class,'modificarAPI'] );
$router->post('/API/almacen/eliminar', [AlmacenController::class,'eliminarAPI'] );


////rutas para manejar la vista y funciones de la tabla estado, pertenecientes a la tabla productos. 

$router->get('/estado', [EstadoController::class,'index']);
$router->post('/API/estado/guardar', [EstadoController::class,'guardarAPI'] );
$router->get('/API/estado/buscar', [EstadoController::class, 'buscarAPI']);
$router->post('/API/estado/modificar', [EstadoController::class,'modificarAPI'] );
$router->post('/API/estado/eliminar', [EstadoController::class,'eliminarAPI'] );


//rutas para manejar la vista y funciones de la tabla inv_uni_med, (unidades de medida)
$router->get('/unimedida', [UnimedidaController::class,'index']);
$router->get('/API/unimedida/buscarAlmacen', [UnimedidaController::class, 'buscarAlmacenAPI']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
