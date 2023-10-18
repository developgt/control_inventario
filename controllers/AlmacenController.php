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


    ///////funcion para buscar los datos de la tabla inv_almacenes

    public static function buscarAPI(){

        $alma_nombre = $_GET['alma_nombre'] ?? '';
        $alma_descripcion = $_GET['alma_descripcion'] ?? '';
        //$alma_unidad = $_GET['alma_unidad'] ?? '';
 


        $sql = "select alma_nombre, alma_unidad, alma_descripcion, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = 657585
        and alma_situacion = 1";

        if ($alma_nombre != '') {
            $alma_nombre = strtolower($alma_nombre);
            $sql .= " AND LOWER(alma_nombre) LIKE '%$alma_nombre%' ";

            if ($alma_descripcion != '') {
                $sql .= " AND alma_descripcion LIKE '%$alma_descripcion%'";
            }
    
           // if ($alma_unidad != '') {
              //  $sql .= " AND alma_unidad LIKE '%$alma_unidad%'";
            //}
  
        }

        try {

            $almacen = Almacen::fetchArray($sql);

            echo json_encode($almacen);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function modificarAPI() {
        try {
            $alma_id = $_POST['alma_id'];
            $alma_nombre = $_POST['alma_nombre'];
            $alma_descripcion = $_POST['alma_descripcion'];
            $alma_unidad = $_POST['alma_unidad'];

            // echo json_encode($_POST);
            // exit;
            $almacen = new Almacen([
                'alma_id' => $alma_id, 
                'alma_nombre' => $alma_nombre,
                'alma_descripcion' => $alma_descripcion,
                'alma_unidad' => $alma_unidad
            ]);
    
            $resultado = $almacen->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'No se encontraron registros a actualizar',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => "Error al realizar la operación",
                'codigo' => 0
            ]);
        }
    }
    
    public static function eliminarAPI() {
        try {

            //\Log::info('Consulta SQL para eliminar registro con ID: ' . $alma_id);

            $alma_id = $_POST['alma_id'];
            $almacen = Almacen::find($alma_id);
            $almacen->alma_situacion = 0;
            $resultado = $almacen->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    //'sql' => $almacen->toSql(),
                    'mensaje' => "Se ha eliminado el registro con éxito.",
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => "No se pudo eliminar el almacen",
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