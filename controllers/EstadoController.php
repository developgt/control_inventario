<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Estado;
use Model\Mper;
use Model\Morg;
use Model\Mdep;
use MVC\Router;

class EstadoController
{

    public static function index(Router $router)
    {

        $router->render('estado/index', [
       
        ]);
    }
    
    public static function buscarDependenciaAPI()
{
    $sql = "SELECT dep_llave, dep_desc_md FROM mper, morg, mdep WHERE per_plaza = org_plaza AND org_dependencia = dep_llave AND per_catalogo = 665133";
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
           // Convertir datos a mayúsculas
           foreach ($_POST as $key => $value) {
            $_POST[$key] = strtoupper($value);
        }

        $estado = new Estado($_POST);
        $resultado = $estado->crear();

        header('Content-Type: text/html; charset=utf-8');

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



    $sql = "SELECT est_descripcion, est_id, est_dependencia
    FROM inv_estado
    JOIN mdep ON inv_estado.est_dependencia = mdep.dep_llave
    JOIN morg ON mdep.dep_llave = morg.org_dependencia
    JOIN mper ON morg.org_plaza = mper.per_plaza
    WHERE mper.per_catalogo = 665133 AND inv_estado.est_situacion = 1";

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
        $est_descripcion = strtoupper($_POST['est_descripcion']);
        $est_dependencia = ($_POST['est_dependencia']);

      

        // echo json_encode($_POST);
        // exit;
        $estado = new Estado([
            'est_id' => $est_id, 
            'est_descripcion' => $est_descripcion,
            'est_dependencia'=> $est_dependencia

        ]);

        $resultado = $estado->actualizar();

        header('Content-Type: text/html; charset=utf-8');


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

