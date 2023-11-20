<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Mper;
use Model\Mdep;
use Model\Guarda;
use MVC\Router;
use Model\Usuario;

class AlmacenController
{

    // public static function index(Router $router)
    // {

    //     //$almacen = static::buscarDependencia();

    //     $router->render('almacen/index', [
    //         //'almacen' => $almacen,
    //     ]);
    // }


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
        $router->render('almacen/index', [
            'usuario' => $usuario,
        ]);
    }
    public static function buscarDependenciaAPI()

{
    $sql = "SELECT dep_llave, dep_desc_md FROM mper, morg, mdep WHERE per_plaza = org_plaza AND org_dependencia = dep_llave AND per_catalogo = user";
    try {
        $almacen = Mdep::fetchArray($sql);

        // Establece el tipo de contenido de la respuesta a JSON
        header('Content-Type: application/json');

        // Convierte el array a JSON y envíalo como respuesta
        echo json_encode($almacen);
    } catch (Exception $e) {
        // En caso de error, envía una respuesta vacía
        echo json_encode([]);
    }
}




// //funcion para guardar almacen

//     public static function guardarAPI()
//     {
//         try {

//             $almacen = new Almacen($_POST);
//             $resultado = $almacen->crear();

//             if ($resultado['resultado'] == 1) {
//                 echo json_encode([
//                     'mensaje' => 'Registro guardado correctamente',
//                     'codigo' => 1,
//                     'id' => $resultado['id'] // Devuelve el ID del registro recién insertado
//                 ]);
//             } else {
//                 echo json_encode([
//                     'mensaje' => 'Ocurrió un error',
//                     'codigo' => 0
//                 ]);
//             }

//         } catch (Exception $e) {
//             echo json_encode([
//                 'detalle' => $e->getMessage(),
//                 'mensaje' => 'Ocurrió un error',
//                 'codigo' => 0
//             ]);
//         }
//     }


    
//     public static function guardarAsignarAPI()
//     {
//         try {

//             $guarda = new Guarda($_POST);
//             $resultado = $guarda->crear();

//             if ($resultado['resultado'] == 1) {
//                 echo json_encode([
//                     'mensaje' => 'Registro guardado correctamente',
//                     'codigo' => 1
//                 ]);
//             } else {
//                 echo json_encode([
//                     'mensaje' => 'Ocurrió un error',
//                     'codigo' => 0
//                 ]);
//             }
//         } catch (Exception $e) {
//             echo json_encode([
//                 'detalle' => $e->getMessage(),
//                 'mensaje' => 'Ocurrió un error',
//                 'codigo' => 0
//             ]);
//         }
//     }



    public static function guardarAPI()
{
    try {

          // Convertir todos los valores de $_POST a mayúsculas
          array_walk_recursive($_POST, function (&$value) {
            $value = strtoupper($value);
        });
        // Guardar Almacén
        $almacen = new Almacen($_POST);
        $resultadoAlmacen = $almacen->crear();

        if ($resultadoAlmacen['resultado'] == 1) {
          
            $_POST['guarda_almacen'] = $resultadoAlmacen['id']; // Asigna el ID del almacén al campo 'guarda_almacen'

            $guarda = new Guarda($_POST);
            $resultadoAsignar = $guarda->crear();

            if ($resultadoAsignar['resultado'] == 1) {
                // Ambos registros guardados correctamente
                echo json_encode([
                    'mensaje' => 'Inventario creado correctamente',
                    'codigo' => 1,
                    'idAlmacen' => $resultadoAlmacen['id'],
                    'idAsignar' => $resultadoAsignar['id']
                ]);
            } else {
                // Error al asignar
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al asignar',
                    'codigo' => 0
                ]);
            }
        } else {
            // Error al guardar el almacén
            echo json_encode([
                'mensaje' => 'Ocurrió un error al guardar el almacén',
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
        $alma_unidad = $_GET['alma_unidad'] ?? '';
 


        $sql = "select alma_nombre, alma_unidad, alma_descripcion, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = user
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
            $alma_unidad = $_POST['alma_unidad'];
            $alma_descripcion = $_POST['alma_descripcion'];
    

            // echo json_encode($_POST);
            // exit;
            $almacen = new Almacen([
                'alma_id' => $alma_id, 
                'alma_nombre' => $alma_nombre,
                'alma_descripcion' => $alma_descripcion,
                'alma_unidad' => $alma_unidad,
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
            // $guarda_catalogo = $_GET['guarda_catalogo'] ?? '';
    
            $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as guarda_nombre, per_catalogo
            FROM mper inner join grados on per_grado = gra_codigo
            INNER JOIN armas on per_arma = arm_codigo
            where per_catalogo = user";
    
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



        public static function buscarAsignarAPI(){
            // $guarda_catalogo = $_GET['guarda_catalogo'] ?? null;
            // $guarda_almacen = $_GET['guarda_almacen'] ?? null;
        
            $sql = "SELECT 
            a.alma_nombre AS guarda_almacen_nombre, 
            g.guarda_id, 
            g.guarda_catalogo, 
            g.guarda_almacen,  
            TRIM(gr.gra_desc_ct) || ' DE ' || TRIM(ar.arm_desc_md) || ' ' || TRIM(mper.per_ape1) || ' ' || TRIM(mper.per_ape2) || ', ' || TRIM(mper.per_nom1) || ', ' || TRIM(mper.per_nom2) AS guarda_nombre
        FROM 
            inv_almacenes a
        JOIN 
            inv_guarda_almacen g ON a.alma_id = g.GUARDA_ALMACEN
        JOIN 
            mper ON mper.per_catalogo = g.guarda_catalogo
        JOIN 
            morg ON morg.org_plaza = mper.per_plaza
        JOIN 
            mdep ON mdep.dep_llave = morg.org_dependencia
        JOIN 
            grados gr ON mper.per_grado = gr.gra_codigo
        JOIN 
            armas ar ON mper.per_arma = ar.arm_codigo
        WHERE 
            g.GUARDA_ALMACEN = a.alma_id 
            AND mper.per_catalogo = g.guarda_catalogo 
            AND mper.per_plaza = morg.org_plaza 
            AND morg.org_dependencia = mdep.dep_llave 
            AND a.alma_unidad = mdep.dep_llave 
            AND mper.per_catalogo = user
            AND g.guarda_situacion = 1
            ";

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


        public static function modificarAsignarAPI() {
            try {
                $guarda_id = $_POST['guarda_id'];
                $guarda_catalogo = $_POST['guarda_catalogo'];
                $guarda_almacen = $_POST['guarda_almacen'];
                //$alma_unidad = $_POST['alma_unidad'];
    
                //echo json_encode($_POST);
                // exit;
                $guarda = new Guarda([
                    'guarda_id' => $guarda_id, 
                    'guarda_catalogo' => $guarda_catalogo,
                    'guarda_almacen' => $guarda_almacen
                ]);
        
                $resultado = $guarda->actualizar();
        
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
        
}
    



