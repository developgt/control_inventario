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

class ProductoController
{

    public static function index(Router $router)
    {
        //$almacen = static::buscarAlmacen();

        $router->render('producto/index', [
            //'almacen' => $almacen
        ]);
    }


    //funcion para buscar almacenes


    public static function buscarAlmacenesAPI()
    {
        $sql = "select alma_nombre, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = 665133
        and alma_situacion = 1";
        try {
            $almacen = Almacen::fetchArray($sql);

            // Establece el tipo de contenido de la respuesta a JSON
            header('Content-Type: application/json');

            // Convierte el array a JSON 
            echo json_encode($almacen);
        } catch (Exception $e) {
            // En caso de error, envía una respuesta vacía
            echo json_encode([]);
        }
    }

    public static function buscarUnidadesAPI()
    {
        $sql = "SELECT uni_nombre, uni_id, inv_almacenes.alma_id, inv_almacenes.alma_nombre as uni_almacen 
        FROM inv_uni_med
        JOIN inv_almacenes ON inv_uni_med.uni_almacen = inv_almacenes.alma_id
        JOIN mdep ON inv_almacenes.alma_unidad = mdep.dep_llave
        JOIN morg ON mdep.dep_llave = morg.org_dependencia
        JOIN mper ON morg.org_plaza = mper.per_plaza
        WHERE mper.per_catalogo = 665133 AND inv_uni_med.uni_situacion = 1;
        ";
         try {
            $medida = Medida::fetchArray($sql);

            // Establece el tipo de contenido de la respuesta a JSON
            header('Content-Type: application/json');

            // Convierte el array a JSON 
            echo json_encode($medida);
        } catch (Exception $e) {
            // En caso de error, envía una respuesta vacía
            echo json_encode([]);
        }
    }
    
    
    public static function buscarEstadosAPI()
    {
        $sql = "SELECT est_descripcion, est_id, est_dependencia
        FROM inv_estado
        JOIN mdep ON inv_estado.est_dependencia = mdep.dep_llave
        JOIN morg ON mdep.dep_llave = morg.org_dependencia
        JOIN mper ON morg.org_plaza = mper.per_plaza
        WHERE mper.per_catalogo = 665133 AND inv_estado.est_situacion = 1
        ";
         try {
            $estado = Estado::fetchArray($sql);

            // Establece el tipo de contenido de la respuesta a JSON
            header('Content-Type: application/json');
            //return;
            // Convierte el array a JSON 
            echo json_encode($estado);
        } catch (Exception $e) {
            // En caso de error, envía una respuesta vacía
            echo json_encode([]);
        }
    }
    



    public static function guardarAPI()
    {
        try {

               // Convertir datos a mayúsculas
           foreach ($_POST as $key => $value) {
            $_POST[$key] = strtoupper($value);
        }

            $guarda = new Producto($_POST);
            $resultado = $guarda->crear();

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


