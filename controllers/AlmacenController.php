<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use MVC\Router;

class AlmacenController{

    public static function index(Router $router){
    
    $router->render('almacen/index', []);
    }

}