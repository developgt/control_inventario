<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\AlmacenController;
use Controllers\EstadoController;
use Controllers\GuardaController;
use Controllers\MedidaController;
use Controllers\ProductoController;
use Controllers\MovimientoController;
use Controllers\MovimientoEgresoController;
use Controllers\MenuController;
use Controllers\GestionController;
use Controllers\GuardalmacenController;
use Controllers\KardexController;
use Controllers\ReporteController;
use Controllers\ReporteEgresoController;
use Controllers\ReporteKardexController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);


$router->get('/', [AppController::class,'index']);

////rutas para manejar la vista y funciones del almacen
$router->get('/almacen', [AlmacenController::class,'index']);
$router->get('/API/almacen/buscarDependencia', [AlmacenController::class, 'buscarDependenciaAPI']);
$router->get('/API/almacen/obtenerNombreAlmacen', [AlmacenController::class, 'obtenerNombreAlmacenAPI']);
$router->post('/API/almacen/guardar', [AlmacenController::class,'guardarAPI'] );
$router->get('/API/almacen/buscar', [AlmacenController::class, 'buscarAPI']);
$router->post('/API/almacen/modificar', [AlmacenController::class,'modificarAPI'] );
$router->post('/API/almacen/eliminar', [AlmacenController::class,'eliminarAPI'] );
$router->post('/API/almacen/guardarAsignar', [AlmacenController::class,'guardarAsignarAPI'] );
$router->get('/API/almacen/buscarOficiales', [AlmacenController::class, 'buscarOficialesAPI']);
$router->get('/API/almacen/buscarAsignar', [AlmacenController::class, 'buscarAsignarAPI']);
$router->post('/API/almacen/modificarAsignar', [AlmacenController::class,'modificarAsignarAPI'] );

////rutas para manejar la vista y funciones de la tabla estado, pertenecientes a la tabla productos. 

$router->get('/estado', [EstadoController::class,'index']);
$router->post('/API/estado/guardar', [EstadoController::class,'guardarAPI'] );
$router->get('/API/estado/buscar', [EstadoController::class, 'buscarAPI']);
$router->post('/API/estado/modificar', [EstadoController::class,'modificarAPI'] );
$router->post('/API/estado/eliminar', [EstadoController::class,'eliminarAPI'] );
$router->get('/API/estado/buscarDependencia', [EstadoController::class, 'buscarDependenciaAPI']);

//rutas para manejar la vista y funciones de la tabla inv_uni_med, (unidades de medida)
$router->get('/medida', [MedidaController::class,'index']);
$router->post('/API/medida/guardar', [MedidaController::class,'guardarAPI'] );
$router->get('/API/medida/buscar', [MedidaController::class, 'buscarAPI']);
$router->post('/API/medida/modificar', [MedidaController::class,'modificarAPI'] );
$router->post('/API/medida/eliminar', [MedidaController::class,'eliminarAPI'] );
$router->get('/API/medida/buscarAlmacenes', [MedidaController::class, 'buscarAlmacenesAPI']);

//rutas para manejar la vista y funciones de la tabla inv_guarda_almacen (asignar guarda almacen)
$router->get('/guarda', [GuardaController::class,'index']);
$router->get('/API/guarda/buscarAlmacenes', [GuardaController::class, 'buscarAlmacenesAPI']);
$router->get('/API/guarda/buscarOficiales', [GuardaController::class, 'buscarOficialesAPI']);
$router->post('/API/guarda/guardar', [GuardaController::class,'guardarAPI'] );

//rutas para manejar la vista del producto y sus funciones de la tabla inv_producto
$router->get('/producto', [ProductoController::class,'index']);
$router->get('/API/producto/buscarAlmacenes', [ProductoController::class, 'buscarAlmacenesAPI']);
$router->get('/API/producto/buscarUnidades', [ProductoController::class, 'buscarUnidadesAPI']);
$router->get('/API/producto/buscar', [ProductoController::class, 'buscarAPI']);
$router->post('/API/producto/guardar', [ProductoController::class,'guardarAPI'] );

//rutas para manejar la vista de movimiento de la tabla INV_MOVIMIENTOS (ingresos)
$router->get('/movimiento', [MovimientoController::class,'index']);
$router->get('/API/movimiento/buscarOficiales', [MovimientoController::class, 'buscarOficialesAPI']);
$router->get('/API/movimiento/buscarOficialesRecibe', [MovimientoController::class, 'buscarOficialesRecibeAPI']);
$router->get('/API/movimiento/buscarOficialesResponsable', [MovimientoController::class, 'buscarOficialesResponsableAPI']);
$router->get('/API/movimiento/buscarAlmacenes', [MovimientoController::class, 'buscarAlmacenesAPI']);
$router->get('/API/movimiento/buscarAlmacenesMovimientos', [MovimientoController::class, 'buscarAlmacenesMovimientosAPI']);
$router->get('/API/movimiento/buscarEstados', [MovimientoController::class, 'buscarEstadosAPI']);
$router->get('/API/movimiento/buscarProducto', [MovimientoController::class, 'buscarProductoAPI']);
$router->get('/API/movimiento/buscarProductoModal', [MovimientoController::class, 'buscarProductoModalAPI']);
$router->get('/API/movimiento/buscarDependencia', [MovimientoController::class, 'buscarDependenciaAPI']);
$router->get('/API/movimiento/buscarDependenciaInterna', [MovimientoController::class, 'buscarDependenciaInternaAPI']);
$router->get('/API/movimiento/buscarCantidad', [MovimientoController::class, 'buscarCantidadAPI']);
$router->get('/API/movimiento/buscarExistencias', [MovimientoController::class, 'buscarExistenciasAPI']);
$router->get('/API/movimiento/buscarCantidadLote', [MovimientoController::class, 'buscarCantidadLoteAPI']);
$router->get('/API/movimiento/buscarUnidades', [MovimientoController::class, 'buscarUnidadesAPI']);
$router->get('/API/movimiento/buscarDetalleMovimiento', [MovimientoController::class, 'buscarDetalleMovimientoAPI']);
$router->get('/API/movimiento/buscarDetalleIngresado', [MovimientoController::class, 'buscarDetalleIngresadoAPI']);
$router->get('/API/movimiento/buscarMovimientos', [MovimientoController::class, 'buscarMovimientosAPI']);
$router->post('/API/movimiento/guardar', [MovimientoController::class,'guardarAPI'] );
$router->post('/API/movimiento/guardarDetalle', [MovimientoController::class,'guardarDetalleAPI']);
$router->post('/API/movimiento/eliminar', [MovimientoController::class,'eliminarAPI'] );


//rutas para manejar la vista de movimiento de la tabla INV_MOVIMIENTOS (egresos)

$router->get('/movegreso', [MovimientoEgresoController::class,'index']);
$router->get('/API/movegreso/buscarOficiales', [MovimientoEgresoController::class, 'buscarOficialesAPI']);
$router->get('/API/movegreso/buscarOficialesRecibe', [MovimientoEgresoController::class, 'buscarOficialesRecibeAPI']);
$router->get('/API/movegreso/buscarOficialesResponsable', [MovimientoEgresoController::class, 'buscarOficialesResponsableAPI']);
$router->get('/API/movegreso/buscarAlmacenes', [MovimientoEgresoController::class, 'buscarAlmacenesAPI']);
$router->get('/API/movegreso/buscarDependencia', [MovimientoEgresoController::class, 'buscarDependenciaAPI']);
$router->get('/API/movegreso/buscarExistencias', [MovimientoEgresoController::class, 'buscarExistenciasAPI']);
$router->get('/API/movegreso/buscarMovimientos', [MovimientoEgresoController::class, 'buscarMovimientosAPI']);


/////IMPRIMIR PDF DE VALE DE INGRESO al inventario

$router->get('/pdf', [ReporteController::class,'pdf']);
$router->post('/reporte/generarPDF', [ReporteController::class, 'generarPDF']);
$router->get('/API/reporte/buscarRecibo', [ReporteController::class, 'buscarReciboAPI']);


///imprimir vale de egreso al inventario 

$router->get('/pdf', [ReporteEgresoController::class,'pdf']);
$router->post('/egresoreporte/generarPDF', [ReporteEgresoController::class, 'generarPDF']);
$router->get('/API/egresoreporte/buscarRecibo', [ReporteEgresoController::class, 'buscarReciboAPI']);

$router->get('/', [MenuController::class,'index']);
$router->get('/API/menu/buscar', [MenuController::class,'buscarAlmacen']);

$router->get('/gestion', [GestionController::class,'index']);
$router->get('/API/gestion/buscar', [GestionController::class,'buscarAlmacen']);

$router->get('/guardalmacen', [GuardalmacenController::class, 'index']);
$router->get('/API/guardalmacen/buscar', [GuardalmacenController::class, 'buscarAlmacen']);

$router->get('/kardex', [KardexController::class, 'index']);
$router->get('/API/kardex/buscar', [KardexController::class, 'buscarAlmacen']);

$router->get('/kardexpdf', [ReporteKardexController::class,'pdf']);
$router->post('/reportekardex/generarPDF', [ReporteKardexController::class, 'generarPDF']);
$router->get('/API/reportekardex/buscarRecibo', [ReporteKardexController::class, 'buscarReciboAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
