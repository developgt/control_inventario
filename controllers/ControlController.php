<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use Model\Guarda;
use Model\Almacen;
use Model\Producto;
use Model\Movimiento;
use MVC\Router;


class ControlController {
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
        $router->render('control/index', [
            'usuario' => $usuario,
         ]);
       }


public static function seleccionarAlmacen()
{

    $sql = "
    SELECT
    inv_almacenes.alma_nombre AS nombre_almacen,
    inv_almacenes.*
    FROM inv_almacenes
    JOIN inv_guarda_almacen ON inv_almacenes.alma_id = inv_guarda_almacen.guarda_almacen
    WHERE inv_almacenes.alma_id = inv_guarda_almacen.guarda_almacen
    AND inv_guarda_almacen.guarda_catalogo = user
    AND inv_guarda_almacen.guarda_situacion = 1
    AND inv_almacenes.alma_situacion = 1
    ; 
";

    try {
        $almacenes = Almacen::fetchArray($sql);
        echo json_encode(['almacenes' => $almacenes]);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

public static function buscarProductoAPI()
{

    $almaSeleccionadoId = $_GET['almaSeleccionadoId'];



    $sql = "
    SELECT 
    d.*,
    p.pro_id,
    e.est_descripcion,
    p.pro_nom_articulo,
    u.uni_nombre,
    m.mov_alma_id
    FROM 
    inv_deta_movimientos d
    INNER JOIN (
    SELECT 
        MAX(d2.det_id) AS max_det_id
    FROM 
        inv_deta_movimientos d2
    INNER JOIN 
        inv_movimientos m2 ON d2.det_mov_id = m2.mov_id
    WHERE 
        m2.mov_alma_id = $almaSeleccionadoId AND d2.det_situacion = 1
    GROUP BY 
        d2.det_pro_id, d2.det_lote, d2.det_estado, d2.det_fecha_vence
    ) max_det ON d.DET_ID = max_det.max_det_id
    LEFT JOIN inv_producto p ON d.det_pro_id = p.pro_id
    LEFT JOIN inv_uni_med u ON d.det_uni_med = u.uni_id
    LEFT JOIN inv_estado e ON d.det_estado = e.est_id
    INNER JOIN inv_movimientos m ON d.det_mov_id = m.mov_id
    INNER JOIN inv_almacenes a ON m.mov_alma_id = a.alma_id
    INNER JOIN inv_guarda_almacen ga ON a.alma_id = ga.guarda_almacen
    WHERE 
    ga.guarda_catalogo = user
    AND ga.guarda_situacion = 1
    ORDER BY 
    d.det_id ASC;
    
    ";

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


public static function buscarAlmacen()
{
    $almaSeleccionadoId = $_GET['almaSeleccionadoId'];



    $sql = "
    SELECT
    inv_almacenes.alma_id AS id_almacen,
    inv_almacenes.alma_nombre AS nombre_almacen,
    inv_producto.pro_nom_articulo AS nombre_producto,
    inv_producto.pro_id AS id_producto,
    inv_estado.est_descripcion AS descripcion_estado,
    inv_deta_movimientos.det_fecha_vence AS fecha_vencimiento,
    inv_deta_movimientos.det_lote AS lote_serie,
    inv_producto.pro_descripcion AS descripcion_producto,
    MAX(inv_deta_movimientos.det_cantidad_existente) AS cantidad_existente
FROM
    inv_almacenes
JOIN
    inv_movimientos ON inv_almacenes.alma_id = inv_movimientos.mov_alma_id
JOIN
    inv_deta_movimientos ON inv_movimientos.mov_id = inv_deta_movimientos.det_mov_id
JOIN
    inv_producto ON inv_deta_movimientos.det_pro_id = inv_producto.pro_id
JOIN
    inv_guarda_almacen ON inv_almacenes.alma_id = inv_guarda_almacen.guarda_almacen
JOIN
    mper ON inv_guarda_almacen.guarda_catalogo = mper.per_catalogo
LEFT JOIN
    inv_estado ON inv_deta_movimientos.det_estado = inv_estado.est_id
WHERE
    inv_guarda_almacen.guarda_catalogo = user
    AND inv_almacenes.alma_situacion = 1
    AND inv_guarda_almacen.guarda_almacen =  $almaSeleccionadoId
GROUP BY
    inv_almacenes.alma_id,
    inv_almacenes.alma_nombre,
    inv_producto.pro_nom_articulo,
    inv_producto.pro_id,
    inv_estado.est_descripcion,
    inv_deta_movimientos.det_fecha_vence,
    inv_deta_movimientos.det_lote,
    inv_producto.pro_descripcion
ORDER BY
    nombre_almacen, nombre_producto DESC;
";



    try {
        $almacenes = Almacen::fetchArray($sql);
        echo json_encode(['almacenes' => $almacenes]);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}



}
