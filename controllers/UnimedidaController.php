<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Estado;
use Model\Mper;
use Model\Morg;
use Model\Mdep;
use MVC\Router;
use Model\Unimedida;

class UnimedidaController
{

    public static function index(Router $router)
    {
        $almacen = static::buscarAlmacenAPI();

        $router->render('unimedida/index', [
       
            'unimedida' => $almacen,

        ]);
    }
    

    public static function buscarAlmacenAPI()
    {
        $sql = "select alma_nombre, alma_unidad, alma_descripcion, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = 657585
        and alma_situacion = 1";
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

        $estado = new Unimedida($_POST);
        $resultado = $estado->crear();

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

    
    $est_descripcion = $_GET['est_descripcion'] ?? '';



    $sql = "select est_descripcion, est_id from inv_estado, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and per_catalogo = 657585
    and est_situacion = 1";

    if ($est_descripcion != '') {
        $est_descripcion = strtolower($est_descripcion);
        $sql .= " AND LOWER(est_descripcion) LIKE '%$est_descripcion%' ";

    }

    try {

        $estado = Estado::fetchArray($sql);

        echo json_encode($estado);
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
        $est_id = $_POST['est_id'];
        $est_descripcion = $_POST['est_descripcion'];
      

        // echo json_encode($_POST);
        // exit;
        $estado = new Estado([
            'est_id' => $est_id, 
            'est_descripcion' => $est_descripcion
        ]);

        $resultado = $estado->actualizar();

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
        $est_id = $_POST['est_id'];
        $estado = Estado::find($est_id);
        $estado->est_situacion = 0;
        $resultado = $estado->actualizar();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
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



