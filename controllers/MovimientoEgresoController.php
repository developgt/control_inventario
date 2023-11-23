<?php


namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Detalle;
use Model\Estado;
use Model\Mper;
use Model\Mdep;
use MVC\Router;
use Model\Movimiento;
use Model\Guarda;
use Model\Medida;
use Model\Producto;
use Model\Usuario;

class MovimientoEgresoController
{

    // public static function index(Router $router)
    // {


    //     $router->render('movegreso/index', []);
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
        $router->render('movegreso/index', [
            'usuario' => $usuario,
        ]);
    }


    public static function buscarDependenciaAPI()
    
    {
        $sql = "SELECT dep_llave, dep_desc_md FROM mdep";
        try {
            $dependencias = Mdep::fetchArray($sql);
    
            // Establece el tipo de contenido de la respuesta a JSON
            header('Content-Type: application/json');
    
            // Convierte el array a JSON y envíalo como respuesta
            echo json_encode($dependencias);
        } catch (Exception $e) {
            // En caso de error, envía una respuesta vacía
            echo json_encode([]);
        }
    }

    public static function buscarAlmacenesAPI()
    {
        $sql = "select alma_id, alma_nombre,alma_clase from inv_almacenes, inv_guarda_almacen where alma_id = guarda_almacen and guarda_catalogo = user and guarda_situacion = 1";
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

    //funcion para buscar oficiales

    public static function buscarOficialesAPI()
    {
        $mov_perso_entrega = $_GET['mov_perso_entrega'] ?? '';

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as mov_perso_entrega_nom
              FROM mper inner join grados on per_grado = gra_codigo
              INNER JOIN armas on per_arma = arm_codigo
              where per_catalogo = $mov_perso_entrega";

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



    //funcion para buscar oficiales

    public static function buscarOficialesRecibeAPI()
    {
        $mov_perso_recibe = $_GET['mov_perso_recibe'] ?? '';

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as mov_perso_recibe_nom
              FROM mper inner join grados on per_grado = gra_codigo
              INNER JOIN armas on per_arma = arm_codigo
              where per_catalogo = $mov_perso_recibe";

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



    //funcion para buscar oficiales

    public static function buscarOficialesResponsableAPI()
    {
        $mov_perso_respon = $_GET['mov_perso_respon'] ?? '';

        $sql = "SELECT  trim(gra_desc_ct) || ' DE ' || trim(arm_desc_md)  || ' ' || trim(per_ape1) || ' ' || trim(per_ape2) || ', ' || trim(per_nom1)  || ', ' || trim(per_nom2) as mov_perso_respon_nom
              FROM mper inner join grados on per_grado = gra_codigo
              INNER JOIN armas on per_arma = arm_codigo
              where per_catalogo = $mov_perso_respon";

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


    
    public static function buscarExistenciasAPI()
    {

        $producto = $_GET['det_pro'] ?? '';


        $sql = "SELECT d.*,
        p.pro_id,
        e.est_descripcion,
        p.pro_nom_articulo,
        u.uni_nombre 
 FROM inv_deta_movimientos d
 INNER JOIN (
     SELECT MAX(DET_ID) AS max_det_id
     FROM inv_deta_movimientos
     WHERE det_pro_id = $producto AND det_situacion = 1
     GROUP BY det_pro_id, det_lote, det_estado, det_fecha_vence
 ) max_det ON d.DET_ID = max_det.max_det_id
 LEFT JOIN inv_producto p ON d.det_pro_id = p.pro_id
 LEFT JOIN inv_uni_med u ON d.det_uni_med = u.uni_id
 LEFT JOIN inv_estado e ON d.det_estado = e.est_id
 ORDER BY d.det_id ASC";

      

        try {

            $estado = Detalle::fetchArray($sql);

            echo json_encode($estado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarMovimientosAPI()
    {

        $almaSeleccionadoId = $_GET['mov_alma'];

        $sql = "    
        SELECT m.*, 
        a.alma_nombre, 
        d.dep_desc_md,
        -- Datos de la persona que entrega
        trim(ge.gra_desc_ct) || ' DE ' || trim(ae.arm_desc_md) || ' ' || 
        trim(pe.per_ape1) || ' ' || trim(pe.per_ape2) || ', ' || 
        trim(pe.per_nom1) || ', ' || trim(pe.per_nom2) as mov_perso_entrega_nom,
        -- Datos de la persona que recibe
        trim(gr.gra_desc_ct) || ' DE ' || trim(ar.arm_desc_md) || ' ' || 
        trim(pr.per_ape1) || ' ' || trim(pr.per_ape2) || ', ' || 
        trim(pr.per_nom1) || ', ' || trim(pr.per_nom2) as mov_perso_recibe_nom,
        -- Datos de la persona responsable
        trim(g.gra_desc_ct) || ' DE ' || trim(arm.arm_desc_md) || ' ' || 
        trim(per.per_ape1) || ' ' || trim(per.per_ape2) || ', ' || 
        trim(per.per_nom1) || ', ' || trim(per.per_nom2) as mov_perso_respon_nom
        FROM inv_movimientos AS m
        JOIN inv_almacenes AS a ON m.mov_alma_id = a.alma_id
        LEFT JOIN mdep AS d ON a.alma_unidad = d.dep_llave
        LEFT JOIN inv_guarda_almacen AS ga ON a.alma_id = ga.guarda_almacen 
        -- Datos de la persona que entrega
        LEFT JOIN mper AS pe ON m.mov_perso_entrega = pe.per_catalogo
        LEFT JOIN grados AS ge ON pe.per_grado = ge.gra_codigo
        LEFT JOIN armas AS ae ON pe.per_arma = ae.arm_codigo
        -- Datos de la persona que recibe
        LEFT JOIN mper AS pr ON m.mov_perso_recibe = pr.per_catalogo
        LEFT JOIN grados AS gr ON pr.per_grado = gr.gra_codigo
        LEFT JOIN armas AS ar ON pr.per_arma = ar.arm_codigo
        -- Datos de la persona responsable
        LEFT JOIN mper AS per ON m.mov_perso_respon = per.per_catalogo
        LEFT JOIN grados AS g ON per.per_grado = g.gra_codigo
        LEFT JOIN armas AS arm ON per.per_arma = arm.arm_codigo
        WHERE m.mov_situacion = 1 
        AND ga.guarda_almacen = a.alma_id 
        AND ga.guarda_catalogo = user
        AND ga.guarda_situacion = 1
        AND m.mov_tipo_mov = 'E'";

        if ($almaSeleccionadoId != '') {
            $almaSeleccionadoId = ($almaSeleccionadoId);
            $sql .= " AND a.alma_id = $almaSeleccionadoId ";
         }

        try {

            $movimiento = Movimiento::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($movimiento);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

}
