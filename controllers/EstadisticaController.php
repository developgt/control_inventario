<?php

namespace Controllers;

use Exception;
use Model\Almacen;
use Model\Estado;
use Model\Mper;
use Model\Morg;
use Model\Mdep;
use Model\Detalle;
use Model\Movimiento;
use MVC\Router;
use Model\Usuario;



class EstadisticaController {


public static function estadistica(Router $router)
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
        $router->render('estadisticas/estadistica', [
            'usuario' => $usuario,
        ]);

     
    }


    public static function cantidadEstadistica(Router $router)
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
        $router->render('estadisticas/cantidadestadistica', [
            'usuario' => $usuario,
        ]);
     
    }

    public static function buscarCantidadAPI()
    {
        $inventario = $_GET['mov_alma_id'] ?? '';
      

        $sql = "SELECT 
    dm.det_pro_id,
    p.pro_nom_articulo,
    um.uni_nombre,
    dm.det_cantidad_existente
FROM 
    inv_deta_movimientos dm
JOIN 
    inv_movimientos m ON dm.det_mov_id = m.mov_id
JOIN 
    inv_producto p ON dm.det_pro_id = p.pro_id
JOIN 
    inv_uni_med um ON dm.det_uni_med = um.uni_id
INNER JOIN (
    SELECT 
        det_pro_id, 
        det_uni_med, 
        MAX(det_id) AS max_det_id
    FROM 
        inv_deta_movimientos
    WHERE 
        det_situacion = 1
    GROUP BY 
        det_pro_id, det_uni_med
) AS sub ON dm.det_id = sub.max_det_id AND dm.det_pro_id = sub.det_pro_id AND dm.det_uni_med = sub.det_uni_med
WHERE 
    m.mov_alma_id = $inventario
    AND dm.det_situacion = 1
    AND m.mov_situacion = 2
    AND p.pro_situacion = 1
    AND um.uni_situacion = 1
ORDER BY 
    dm.det_pro_id, um.uni_id";

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


    public static function buscarIngresoAPI()
    {
        $inventario = $_GET['mov_alma_id'] ?? '';
      

        $sql = "SELECT 
        p.pro_nom_articulo AS Producto,
        dm.det_cantidad_existente AS totalingresos
    FROM 
        inv_movimientos m
    INNER JOIN 
        inv_deta_movimientos dm ON m.mov_id = dm.det_mov_id
    INNER JOIN 
        inv_producto p ON dm.det_pro_id = p.pro_id
    WHERE 
        m.mov_tipo_mov = 'I'
        AND m.mov_alma_id = $inventario
        AND m.mov_situacion = 2
        AND dm.det_situacion = 1
        AND dm.det_id = (
            SELECT 
                MAX(det_id)
            FROM 
                inv_deta_movimientos sub_dm
            WHERE 
                sub_dm.det_pro_id = dm.det_pro_id
                AND sub_dm.det_mov_id = dm.det_mov_id
        )
    ORDER BY 
        totalingresos DESC;
    ";

        try {

            $detalle = Movimiento::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarEgresoAPI()
    {
        $inventario = $_GET['mov_alma_id'] ?? '';
      

        $sql = "SELECT 
        p.pro_nom_articulo AS Producto,
        SUM(dm.det_cantidad) AS TotalEgresos
    FROM 
        inv_movimientos m
    INNER JOIN 
        inv_deta_movimientos dm ON m.mov_id = dm.det_mov_id
    INNER JOIN 
        inv_producto p ON dm.det_pro_id = p.pro_id
    WHERE 
        m.mov_tipo_mov = 'E'
          AND m.mov_alma_id = $inventario
        AND m.mov_situacion = 2
        AND dm.det_situacion = 1
    GROUP BY 
        p.pro_nom_articulo
    ORDER BY 
        TotalEgresos DESC";

        try {

            $detalle = Movimiento::fetchArray($sql);

            echo json_encode($detalle);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

 }