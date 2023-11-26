<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Mper;
use MVC\Router;
use Model\Guarda;
use Model\Usuario;
use Model\ActiveRecord;


class GuardaController
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
        $router->render('guarda/index', [
            'usuario' => $usuario,
        ]);
    }

    //funcion para buscar almacenes

    public static function buscarAlmacenesAPI()
    {
        $sql = "select alma_id, alma_nombre,alma_clase from inv_almacenes, inv_guarda_almacen where alma_id = guarda_almacen and guarda_catalogo = user and guarda_situacion = 1";
        try {
            $almacen = Almacen::fetchArray($sql);
            header('Content-Type: application/json');
            echo json_encode($almacen);
        } catch (Exception $e) {
            echo json_encode([]);
        }
    }

    // funcion para obtener el guarda_id de la tabla inv_guarda_almacen

    public static function buscarIdGuardaAPI()
    {
        $almaSeleccionadoId = $_GET['almaSeleccionadoId'];

        $sql = "SELECT guarda_id FROM inv_guarda_almacen where guarda_catalogo = user and guarda_almacen = $almaSeleccionadoId";

        try {
            $guarda = Guarda::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($guarda);
        } catch (Exception $e) {

            echo json_encode([]);
        }
    }

    //funcion para buscar oficial que entrega 

    public static function buscarOficialesEntregaAPI()
    {
        $guarda_catalogo2 = $_GET['guarda_catalogo2'] ?? '';

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as guarda_nombre2
        FROM mper inner join grados on per_grado = gra_codigo
        INNER JOIN armas on per_arma = arm_codigo
        where per_catalogo = $guarda_catalogo2";

        try {
            $oficial = Mper::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($oficial);
            return;
        } catch (Exception $e) {

            echo json_encode([]);
        }
    }

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



    public static function modificarYGuardarAPI() {
        try {
            // Operación de modificación
            $guardaId = $_POST['guarda_id2']; 
            $guarda = Guarda::find($guardaId);
            $guarda->guarda_situacion = 0;
            $resultadoModificacion = $guarda->actualizar();

            // Verificar resultado de la modificación
            if ($resultadoModificacion['resultado'] != 1) {
                throw new Exception("No se pudo modificar el registro");
            }

            // Operación de guardado
            $nuevoGuarda = new Guarda([
                'guarda_catalogo' => $_POST['guarda_catalogo2'],
                'guarda_almacen' => $_POST['guarda_almacen'],
            ]);
            $resultadoGuardado = $nuevoGuarda->crear();

            // Verificar resultado del guardado
            if ($resultadoGuardado['resultado'] != 1) {
                throw new Exception("No se pudo guardar el registro");
            }

            echo json_encode([
                'mensaje' => 'Inventario entregado con éxito',
                'codigo' => 1
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error en la entrega contacte al administrador de la aplicación',
                'codigo' => 0
            ]);
        }
    }


    
    public static function buscarAPI()
    {
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
        AND ga.guarda_situacion = 0
        AND alm.alma_situacion = 1";


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
}
