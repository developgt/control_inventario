<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\MenuController;
use Controllers\GestionController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [MenuController::class,'index']);
$router->get('/API/menu/buscar', [MenuController::class,'buscarAlmacen']);

$router->get('/gestion', [GestionController::class,'index']);
$router->get('/API/gestion/buscar', [GestionController::class,'buscarAlmacen']);

$router->get('/guardalmacen', [GuardalmacenController::class, 'index']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
