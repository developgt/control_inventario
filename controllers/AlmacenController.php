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


    public static function index(Router $router)
    {
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

          
            header('Content-Type: application/json');

         
            echo json_encode($almacen);
        } catch (Exception $e) {
      
            echo json_encode([]);
        }
    }






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
                
                    echo json_encode([
                        'mensaje' => 'Ocurrió un error al asignar',
                        'codigo' => 0
                    ]);
                }
            } else {
            
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

    public static function buscarAPI()
    {

        $alma_nombre = $_GET['alma_nombre'] ?? '';
        $alma_descripcion = $_GET['alma_descripcion'] ?? '';
        $alma_unidad = $_GET['alma_unidad'] ?? '';



        $sql = "SELECT DISTINCT
        alm.alma_nombre AS alma_nombre,
        alm.alma_descripcion AS alma_descripcion,
        alm.alma_id AS alma_id,
        alm.alma_clase AS alma_clase,
        c.alma_descr AS clase_nombre
      FROM 
        inv_guarda_almacen ga
        JOIN inv_almacenes alm ON ga.guarda_almacen = alm.alma_id
        JOIN inv_clase c ON alm.alma_clase = c.alma_clase
      WHERE 
        ga.guarda_catalogo = user
        AND ga.guarda_situacion = 1
        AND alm.alma_situacion = 1";

        if ($alma_nombre != '') {
            $alma_nombre = strtolower($alma_nombre);
            $sql .= " AND LOWER(alma_nombre) LIKE '%$alma_nombre%' ";

            if ($alma_descripcion != '') {
                $sql .= " AND alma_descripcion LIKE '%$alma_descripcion%'";
            }

       

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

    public static function modificarAPI()
    {
        try {

            // Convertir todos los valores de $_POST a mayúsculas
            array_walk_recursive($_POST, function (&$value) {
                $value = strtoupper($value);
            });
            $alma_id = $_POST['alma_id'];
            $alma_nombre = $_POST['alma_nombre'];
            $alma_clase = $_POST['alma_clase'];
            $alma_unidad = $_POST['alma_unidad'];
            $alma_descripcion = $_POST['alma_descripcion'];


            $almacen = new Almacen([
                'alma_id' => $alma_id,
                'alma_nombre' => $alma_nombre,
                'alma_clase' => $alma_clase,
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

    public static function eliminarAPI()
    {
        try {

          

            $alma_id = $_POST['alma_id'];
            $almacen = Almacen::find($alma_id);
            $almacen->alma_situacion = 0;
            $resultado = $almacen->actualizar();

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


    ////AQUI EMPIEZAN LAS FUNCIONES PARA MANEJAR EL MODAL
    //funcion para obtenerNombreAlmacen por su ID




    public static function obtenerNombreAlmacenAPI()
    {
        $alma_id = $_GET['alma_id'] ?? '';

        $almacen = []; // Definir $almacen como un arreglo vacío
    

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
        

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as guarda_nombre, per_catalogo
            FROM mper inner join grados on per_grado = gra_codigo
            INNER JOIN armas on per_arma = arm_codigo
            where per_catalogo = user";

        try {
            $oficial = Mper::fetchArray($sql);

       
            header('Content-Type: application/json');

         
            echo json_encode($oficial);
            return;
        } catch (Exception $e) {
          
            echo json_encode([]);
        }
    }



    public static function buscarAsignarAPI()
    {
       

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


    public static function modificarAsignarAPI()
    {
        try {
            $guarda_id = $_POST['guarda_id'];
            $guarda_catalogo = $_POST['guarda_catalogo'];
            $guarda_almacen = $_POST['guarda_almacen'];
       
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
