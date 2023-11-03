<?php


namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Estado;
use Model\Mper;
use MVC\Router;
use Model\Guarda;
use Model\Medida;
use Model\Producto;

class MovimientoController
{

    public static function index(Router $router)
    {
       

        $router->render('movimiento/index', [
        
        ]);
    }
}
