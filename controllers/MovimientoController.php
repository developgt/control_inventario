<?php


namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Detalle;
use Model\Estado;
use Model\Mper;
use Model\Mdep;
use MVC\Router;
use Model\Guarda;
use Model\Medida;
use Model\Usuario;
use Model\Movimiento;
use Model\Producto;

class MovimientoController
{

    // public static function index(Router $router)
    // {


    //     $router->render('movimiento/index', []);
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
        $router->render('movimiento/index', [
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

    public static function buscarDependenciaInternaAPI()

    {
        $sql = "SELECT dep_llave, dep_desc_md FROM mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and per_catalogo = user";
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
        $sql = "select alma_nombre, alma_id from inv_almacenes, mper, morg, mdep where per_plaza = org_plaza and org_dependencia= dep_llave and alma_unidad = dep_llave and per_catalogo = user
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

    public static function buscarEstadosAPI()
    {
        $sql = "SELECT est_descripcion, est_id 
        FROM inv_estado
        WHERE est_situacion = 1";
        try {
            $estado = Estado::fetchArray($sql);

            // Establece el tipo de contenido de la respuesta a JSON
            header('Content-Type: application/json');
            //return;
            // Convierte el array a JSON 
            echo json_encode($estado);
        } catch (Exception $e) {
            // En caso de error, envía una respuesta vacía
            echo json_encode([]);
        }
    }

    // $sql = "SELECT pro_id, pro_nom_articulo, inv_uni_med.uni_nombre AS pro_medida, 
    // inv_almacenes.alma_nombre AS pro_almacen_id
    // FROM inv_producto
    // JOIN inv_uni_med ON inv_producto.pro_medida = inv_uni_med.uni_id
    // JOIN inv_almacenes ON inv_producto.pro_almacen_id = inv_almacenes.alma_id
    // JOIN mdep ON inv_almacenes.alma_unidad = mdep.dep_llave
    // JOIN morg ON mdep.dep_llave = morg.org_dependencia
    // JOIN mper ON morg.org_plaza = mper.per_plaza
    // WHERE mper.per_catalogo = 665133 AND inv_producto.pro_situacion = 1";
    public static function buscarProductoAPI()
    {

        $almaSeleccionadoId = $_GET['almaSeleccionadoId'];



        $sql = "SELECT pro_id, pro_nom_articulo, inv_uni_med.uni_nombre AS pro_medida, 
                inv_almacenes.alma_nombre AS pro_almacen_id
                FROM inv_producto
                JOIN inv_uni_med ON inv_producto.pro_medida = inv_uni_med.uni_id
                JOIN inv_almacenes ON inv_producto.pro_almacen_id = inv_almacenes.alma_id
                WHERE inv_almacenes.alma_id = $almaSeleccionadoId AND inv_producto.pro_situacion = 1";

        try {

            $producto = Producto::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($producto);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarProductoModalAPI()
    {

        $almaSeleccionadoId = $_GET['almaSeleccionId'];



        $sql = "SELECT pro_id, pro_nom_articulo, inv_uni_med.uni_nombre AS pro_medida, 
                inv_almacenes.alma_nombre AS pro_almacen_id
                FROM inv_producto
                JOIN inv_uni_med ON inv_producto.pro_medida = inv_uni_med.uni_id
                JOIN inv_almacenes ON inv_producto.pro_almacen_id = inv_almacenes.alma_id
                WHERE inv_almacenes.alma_id = $almaSeleccionadoId AND inv_producto.pro_situacion = 1";

        try {

            $producto = Producto::fetchArray($sql);

            header('Content-Type: application/json');

            echo json_encode($producto);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function guardarAPI()
    {
        try {

            $movimiento = new Movimiento($_POST);
            $resultado = $movimiento->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1,
                    'id' => $resultado['id'] // Devuelve el ID del registro recién insertado
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

    /// para buscar la cantidad del formulario detalle 

    public static function buscarCantidadAPI()
    {
        $det_pro_id = $_GET['det_pro_id'] ?? '';

        $sql = "   SELECT det_cantidad_existente from inv_deta_movimientos where det_pro_id = $det_pro_id and det_situacion = 1 
        and det_id = (select max(det_id) from  inv_deta_movimientos where det_pro_id = $det_pro_id and det_situacion = 1)
        group by det_cantidad_existente";

        try {

            $detalle = Detalle::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    ///BUSCAR LA CANTIDAD DE ACUERDO AL LOTE Y ESTADO DEL FORM DETALLE
    public static function buscarCantidadLoteAPI()
    {
        $det_pro_id = $_GET['det_pro_id'] ?? '';
        $det_lote = $_GET['det_lote'] ?? '';
        $det_estado = $_GET['det_estado'] ?? '';
        $det_fecha_vence = $_GET['det_fecha_vence'] ?? '';



        $sql = "SELECT det_cantidad_lote from inv_deta_movimientos where det_pro_id = $det_pro_id and det_situacion = 1 and det_lote = '$det_lote' and det_estado = $det_estado and det_fecha_vence = '$det_fecha_vence'
        and det_id = (select max(det_id) from  inv_deta_movimientos where det_pro_id = $det_pro_id and det_situacion = 1 and det_lote = '$det_lote' and det_estado = $det_estado and det_fecha_vence = '$det_fecha_vence' )
        group by det_cantidad_lote";


        try {

            $detalle = Detalle::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function guardarDetalleAPI()
    {
        try {

            
        $datosDetalle = $_POST;

       
        if (empty($datosDetalle['det_fecha_vence'])) {
            $datosDetalle['det_fecha_vence'] = '1999/05/07';
        }

     
        $movimiento = new Detalle($datosDetalle);
        $resultado = $movimiento->crear();

            if ($resultado['resultado'] == 1) {
                header('Content-Type: application/json');

                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1,

                ]);
            } else {
                header('Content-Type: application/json');

                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');

            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function buscarExistenciasAPI()
    {

        $producto = $_GET['det_pro'] ?? '';


        $sql = "
        SELECT
        d.det_id,
        d.det_pro_id,
        d.det_mov_id,
        p.pro_id,
        d.det_lote,
        d.det_estado,
        m.mov_tipo_trans,
        d.det_fecha_vence,
        e.est_descripcion,
        d.det_cantidad_existente,
        d.det_cantidad_lote,
        p.pro_nom_articulo,
        u.uni_nombre AS pro_medida_nombre,
        m.mov_tipo_mov
    FROM inv_deta_movimientos d
    INNER JOIN inv_producto p ON d.det_pro_id = p.pro_id
    LEFT JOIN inv_uni_med u ON p.pro_medida = u.uni_id
    INNER JOIN inv_movimientos m ON d.det_mov_id = m.mov_id
    INNER JOIN inv_estado e ON d.det_estado = e.est_id
    WHERE d.det_pro_id = $producto AND det_situacion = 1 AND mov_tipo_mov = 'I'
    ORDER BY d.det_id ASC
    ";
      

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


}
