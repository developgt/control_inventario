<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Estado;
use Model\Mper;
use Model\Morg;
use Model\Mdep;
use Model\Usuario;
use MVC\Router;
use Model\Medida;


class MedidaController
{

    public static function index(Router $router){
        isAuth();
        try {
            $usuario = Usuario::fetchFirst("
            
            SELECT
            per_catalogo,
            TRIM(per_nom1) || ' ' || TRIM(per_nom2) || ' ' || TRIM(per_ape1) || ' ' || TRIM(per_ape2) as nombre,
            per_desc_empleo as empleo,
            dep_desc_lg as dependencia,
            gra_desc_md as grado
        FROM
            mper
        INNER JOIN
            morg ON per_plaza = org_plaza
        INNER JOIN
            mdep ON org_dependencia = dep_llave
        INNER JOIN
            grados ON per_grado = gra_codigo
        WHERE
            per_catalogo = user;

            ");
            
        } catch (Exception $e) {
            getHeadersApi();
            echo json_encode([
                "detalle" => $e->getMessage(),       
                "mensaje" => "Error de conexión bd",
        
                "codigo" => 5,
            ]);
            exit;
        }
        $router->render('medida/index', [
            'usuario' => $usuario,
        ]);
    }
 
    
    

    public static function buscarAlmacen()
    {
        $sql = "select alma_nombre, alma_unidad, alma_descripcion, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = user
        and alma_situacion = 1";
        try {
            $almacen = Almacen::fetchArray($sql);
            //print_r($almacen); 
            return $almacen;
        } catch (Exception $e) {
            return[];
        }
    }

    public static function buscarAlmacenesAPI()
    {
        $sql = "select alma_nombre, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = user
        and alma_situacion = 1";
        try {
            $almacen = Almacen::fetchArray($sql);
    
          
            header('Content-Type: application/json');
    
         
            echo json_encode($almacen);
        } catch (Exception $e) {
           
            echo json_encode([]);
        }
    }
//funcion para guardar almacen

public static function guardarAPI()
{
    try {

        $medida = new Medida($_POST);
        $resultado = $medida->crear();

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

    
    $uni_nombre = $_GET['uni_nombre'] ?? '';
    $uni_almacen = $_GET['uni_almacen'] ?? '';
    $alma_nombre = $_GET['alma_nombre'] ?? '';
    $alma_id = $_GET['alma_id'] ?? '';



    $sql = "
    SELECT uni_nombre, uni_id, inv_almacenes.alma_id, inv_almacenes.alma_nombre as uni_almacen 
    FROM inv_uni_med
    JOIN inv_almacenes ON inv_uni_med.uni_almacen = inv_almacenes.alma_id
    JOIN mdep ON inv_almacenes.alma_unidad = mdep.dep_llave
    JOIN morg ON mdep.dep_llave = morg.org_dependencia
    JOIN mper ON morg.org_plaza = mper.per_plaza
    WHERE mper.per_catalogo = user AND inv_uni_med.uni_situacion = 1
    ";

    if ($uni_nombre != '') {
        $uni_nombre = strtolower($uni_nombre);
        $sql .= " AND LOWER(uni_nombre) LIKE '%$uni_nombre%' ";

    }
    if ($uni_almacen != '' ) {
        $uni_almacen = strtolower($uni_almacen);
        $sql .= " AND LOWER(uni_almacen) LIKE '%$uni_almacen%' ";
     }
     if ($alma_nombre != '' ) {
        $alma_nombre = strtolower($alma_nombre);
        $sql .= " AND LOWER(inv_almacenes.alma_nombre) LIKE '%$alma_nombre
        %' ";
        }

    try {

        $medida = Medida::fetchArray($sql);

        echo json_encode($medida);
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
        $uni_id = $_POST['uni_id'];
        $uni_nombre = $_POST['uni_nombre'];
        $uni_almacen = $_POST['uni_almacen'];

      

        $medida = new Medida([
            'uni_id' => $uni_id, 
            'uni_nombre' => $uni_nombre,
            'uni_almacen' => $uni_almacen
        ]);

        $resultado = $medida->actualizar();

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
        $uni_id = $_POST['uni_id'];
        $medida = Medida::find($uni_id);
        $medida->uni_situacion = 0;
        $resultado = $medida->actualizar();

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



