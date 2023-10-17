<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Mper;
use Model\Morg;
use Model\Mdep;
use MVC\Router;

class AlmacenController
{

    public static function index(Router $router)
    {

        //$almacen = static::buscarDependencia();

        $router->render('almacen/index', [
            //'almacen' => $almacen,
        ]);
    }
    public static function buscarDependenciaAPI()
{
    $sql = "SELECT dep_llave, dep_desc_md FROM mper, morg, mdep WHERE per_plaza = org_plaza AND org_dependencia = dep_llave AND per_catalogo = 657585";
    try {
        $almacen = Almacen::fetchArray($sql);

        // Establece el tipo de contenido de la respuesta a JSON
        header('Content-Type: application/json');

        // Convierte el array a JSON y envíalo como respuesta
        echo json_encode($almacen);
    } catch (Exception $e) {
        // En caso de error, envía una respuesta vacía
        echo json_encode([]);
    }
}




//funcion para guardar almacen

    public static function guardarAPI()
    {
        try {

            $almacen = new Almacen($_POST);
            $resultado = $almacen->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }

        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


}