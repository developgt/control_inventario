<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use Model\Guarda;
use Model\Almacen;
use Model\Producto;
use Model\Movimiento;
use MVC\Router;


class KardexController {
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
        $router->render('kardex/index', [
            'usuario' => $usuario,
         ]);
       }
// funcion para traer los almacenes


public static function buscarAlmacen()
{

    $sql = "
    SELECT 
    inv_almacenes.alma_nombre AS nombre_almacen,
    inv_producto.pro_nom_articulo AS nombre_producto,
    inv_producto.pro_id AS id_producto,
    inv_deta_movimientos.*,
    inv_movimientos.*,
    inv_almacenes.*,
    inv_uni_med.uni_nombre AS nombre_unidad_medida,
    inv_clase.alma_descr AS descripcion_clase,
    inv_estado.est_descripcion AS descripcion_estado,
    mdep.dep_desc_md AS descripcion_proce_destino,
    (
        NVL(grados.gra_desc_md, '') || ' ' ||
        per_entrega.per_nom1 || ' ' ||
        per_entrega.per_nom2 || ' ' ||
        per_entrega.per_ape1 || ' ' ||
        per_entrega.per_ape2
    ) AS nombre_entrega,
    (
        NVL(grados.gra_desc_md, '') || ' ' ||
        per_recibe.per_nom1 || ' ' ||
        per_recibe.per_nom2 || ' ' ||
        per_recibe.per_ape1 || ' ' ||
        per_recibe.per_ape2
    ) AS nombre_recibe,
    (
        NVL(grados.gra_desc_md, '') || ' ' ||
        per_respon.per_nom1 || ' ' ||
        per_respon.per_nom2 || ' ' ||
        per_respon.per_ape1 || ' ' ||
        per_respon.per_ape2
    ) AS nombre_respon
FROM 
    inv_almacenes
JOIN 
    inv_movimientos ON inv_almacenes.alma_id = inv_movimientos.mov_alma_id
JOIN 
    inv_deta_movimientos ON inv_movimientos.mov_id = inv_deta_movimientos.det_mov_id
JOIN 
    inv_producto ON inv_deta_movimientos.det_pro_id = inv_producto.pro_id
JOIN
    mper ON mper.per_catalogo = user
JOIN
    inv_uni_med ON inv_uni_med.uni_id = inv_deta_movimientos.det_uni_med 
LEFT JOIN
    inv_clase ON inv_almacenes.alma_clase = inv_clase.alma_clase
LEFT JOIN
    inv_estado ON inv_deta_movimientos.det_estado = inv_estado.est_id
LEFT JOIN
    mdep ON inv_movimientos.mov_proce_destino = mdep.dep_llave
LEFT JOIN
    mper AS per_entrega ON inv_movimientos.mov_perso_entrega = per_entrega.per_catalogo
LEFT JOIN
    mper AS per_recibe ON inv_movimientos.mov_perso_recibe = per_recibe.per_catalogo
LEFT JOIN
    mper AS per_respon ON inv_movimientos.mov_perso_respon = per_respon.per_catalogo
LEFT JOIN
    grados ON mper.per_grado = grados.gra_codigo
WHERE 
    mper.per_catalogo = user;
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

/////////////////////////////////


}
