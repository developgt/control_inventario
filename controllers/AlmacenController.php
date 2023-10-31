<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Mper;
use Model\Morg;
use Model\Mdep;
use Model\Guarda;
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


    ////AQUI EMPIEZAN LAS FUNCIONES PARA MANEJAR EL MODAL
    //funcion para obtenerNombreAlmacen por su ID

    


    public static function obtenerNombreAlmacenAPI(){
        $alma_id = $_GET['alma_id'] ?? '';
        
        $almacen = []; // Definir $almacen como un arreglo vacío
        //$alma_nombre = [];
        
        $sql = "SELECT alma_id, alma_nombre FROM inv_almacenes WHERE alma_id = $alma_id AND alma_situacion = 1";
        
        try {
            $almacen = Almacen::fetchArray($sql);
            //var_dump($almacen);
            header('Content-Type: application/json');
        
                echo json_encode($almacen);
         
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function guardarAsignarAPI()
    {
        try {

            $guarda = new Guarda($_POST);
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

        //funcion para buscar oficiales

        public static function buscarOficialesAPI()
        {
            $guarda_catalogo = $_GET['guarda_catalogo'] ?? '';
    
            $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as guarda_nombre
            FROM mper inner join grados on per_grado = gra_codigo
            INNER JOIN armas on per_arma = arm_codigo
            where per_catalogo = $guarda_catalogo";
    
            try {
                $oficial = Mper::fetchArray($sql);
    
                // Establece el tipo de contenido de la respuesta a JSON
                header('Content-Type: application/json');
    
                // Convierte el array a JSON 
                echo json_encode($oficial);
                return;
            } catch (Exception $e) {
                // En caso de error, envía una respuesta vacía
                echo json_encode([]);
            }
        }

    //     public static function buscarAsignarAPI(){

    //         $guarda_catalogo = $_GET['guarda_catalogo'] ?? '';
    //         $guarda_almacen = $_GET['guarda_almacen'] ?? '';
    //         //$alma_unidad = $_GET['alma_unidad'] ?? '';
     


    //     $sql = "SELECT 
    //     inv_guarda_almacen.guarda_id,
    //     inv_guarda_almacen.guarda_catalogo,
    //     inv_guarda_almacen.guarda_almacen,
    //     inv_almacenes.alma_nombre AS guarda_almacen_nombre
    // FROM 
    //     inv_guarda_almacen
    // JOIN 
    //     inv_almacenes ON inv_guarda_almacen.guarda_almacen = inv_almacenes.alma_id
    // JOIN 
    //     mdep ON inv_almacenes.alma_unidad = mdep.dep_llave
    // WHERE 
    //     inv_guarda_almacen.guarda_situacion = 1
    //     AND inv_almacenes.alma_unidad = mdep.dep_llave;
    // ";
    
    //         // if ($alma_nombre != '') {
    //         //     $alma_nombre = strtolower($alma_nombre);
    //         //     $sql .= " AND LOWER(alma_nombre) LIKE '%$alma_nombre%' ";
    
    //         //     if ($alma_descripcion != '') {
    //         //         $sql .= " AND alma_descripcion LIKE '%$alma_descripcion%'";
    //         //     }
        
    //         //    // if ($alma_unidad != '') {
    //         //       //  $sql .= " AND alma_unidad LIKE '%$alma_unidad%'";
    //         //     //}
      
    //         // }
    
    //         try {
    
    //             $almacen = Mper::fetchArray($sql);
    
    //             echo json_encode($almacen);
    //         } catch (Exception $e) {
    //             echo json_encode([
    //                 'detalle' => $e->getMessage(),
    //                 'mensaje' => 'Ocurrió un error',
    //                 'codigo' => 0
    //             ]);
    //         }
    //     }
    


        public static function buscarAsignarAPI(){
            $guarda_catalogo = $_GET['guarda_catalogo'] ?? null;
            $guarda_almacen = $_GET['guarda_almacen'] ?? null;
        
            $sql = "
            SELECT alma_nombre, guarda_id, guarda_catalogo, guarda_almacen FROM inv_almacenes, inv_guarda_almacen, mper, morg, mdep 
            WHERE GUARDA_ALMACEN = ALMA_ID AND per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = 657585 AND GUARDA_CATALOGO = 657585 AND guarda_situcion = 1
            ";
        
            // Si se proporcionan valores, añadir las condiciones a la consulta
            if ($guarda_catalogo !== null) {
                $sql .= " AND inv_guarda_almacen.guarda_catalogo = $guarda_catalogo";
            }
        
            if ($guarda_almacen !== null) {
                $sql .= " AND inv_guarda_almacen.guarda_almacen = $guarda_almacen";
            }
        
            try {
                $almacen = Mper::fetchArray($sql);
                echo json_encode($almacen);
            } catch (Exception $e) {
                echo json_encode([
                    'detalle' => $e->getMessage(),
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
        }
        
}
    
    
// $sql = "  SELECT 
// trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md) || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1) || ', ' || trim(per_nom2) as guarda_nombre,
// inv_guarda_almacen.guarda_almacen AS guarda_almacen_id,
// inv_almacenes.alma_nombre AS guarda_almacen_nombre,
// mdep.dep_llave,
// mdep.dep_desc_md
// FROM 
// mper
// JOIN 
// grados ON per_grado = gra_codigo
// JOIN 
// armas ON per_arma = arm_codigo
// LEFT JOIN 
// inv_guarda_almacen ON mper.per_catalogo = inv_guarda_almacen.guarda_catalogo
// LEFT JOIN 
// inv_almacenes ON inv_guarda_almacen.guarda_almacen = inv_almacenes.alma_id
// JOIN 
// morg ON mper.per_plaza = morg.org_plaza
// JOIN 
// mdep ON morg.org_dependencia = mdep.dep_llave
// WHERE 
// per_catalogo = $guarda_catalogo;

//";
    

    


