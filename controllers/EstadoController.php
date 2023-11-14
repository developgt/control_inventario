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



    $sql = "SELECT est_descripcion, est_id
    FROM inv_estado
    WHERE est_situacion = 1";

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


      

        // echo json_encode($_POST);
        // exit;
        $estado = new Estado([
            'est_id' => $est_id, 
            'est_descripcion' => $est_descripcion,

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

