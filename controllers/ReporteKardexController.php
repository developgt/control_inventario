<?php

namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Detalle;
use Model\Usuario;
use Model\Guarda;
use Model\Almacen;
use Model\Producto;
use Model\Movimiento;
use Exception;

class ReporteKardexController
{
 
    public static function pdf(Router $router)
    {
        $mpdf = new Mpdf([
            "orientation" => "L",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(30, 35, 25);

        $html = $router->load('reportekardex/pdf');
        $htmlHeader = $router->load('reportekardex/header');
        $htmlFooter = $router->load('reportekardex/footer');

        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

  
    public static function buscarReciboAPI()
    {
        $alma_id = $_GET['alma_id'] ?? '';
        $pro_id = $_GET['pro_id'] ?? '';
        $uni_id = $_GET['uni_id'] ?? '';

       
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
        -- Datos de la persona que entrega
        trim(ge.gra_desc_ct) || ' DE ' || trim(ae.arm_desc_md) || ' ' || 
        trim(pe.per_ape1) || ' ' || trim(pe.per_ape2) || ', ' || 
        trim(pe.per_nom1) || ' ' || trim(pe.per_nom2) as mov_perso_entrega_nom,
        -- Datos de la persona que recibe
        trim(gr.gra_desc_ct) || ' DE ' || trim(ar.arm_desc_md) || ' ' || 
        trim(pr.per_ape1) || ' ' || trim(pr.per_ape2) || ', ' || 
        trim(pr.per_nom1) || ' ' || trim(pr.per_nom2) as mov_perso_recibe_nom,
        -- Datos de la persona responsable
        trim(g.gra_desc_ct) || ' DE ' || trim(arm.arm_desc_md) || ' ' || 
        trim(per.per_ape1) || ' ' || trim(per.per_ape2) || ', ' || 
        trim(per.per_nom1) || ' ' || trim(per.per_nom2) as mov_perso_respon_nom
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
    -- Datos de la persona que entrega
    LEFT JOIN mper AS pe ON inv_movimientos.mov_perso_entrega = pe.per_catalogo
    LEFT JOIN grados AS ge ON pe.per_grado = ge.gra_codigo
    LEFT JOIN armas AS ae ON pe.per_arma = ae.arm_codigo
    -- Datos de la persona que recibe
    LEFT JOIN mper AS pr ON inv_movimientos.mov_perso_recibe = pr.per_catalogo
    LEFT JOIN grados AS gr ON pr.per_grado = gr.gra_codigo
    LEFT JOIN armas AS ar ON pr.per_arma = ar.arm_codigo
    -- Datos de la persona responsable
    LEFT JOIN mper AS per ON inv_movimientos.mov_perso_respon = per.per_catalogo
    LEFT JOIN grados AS g ON per.per_grado = g.gra_codigo
    LEFT JOIN armas AS arm ON per.per_arma = arm.arm_codigo
    LEFT JOIN inv_clase ON inv_almacenes.alma_clase = inv_clase.alma_clase
    LEFT JOIN inv_estado ON inv_deta_movimientos.det_estado = inv_estado.est_id
    LEFT JOIN mdep ON inv_movimientos.mov_proce_destino = mdep.dep_llave
    LEFT JOIN mper AS per_entrega ON inv_movimientos.mov_perso_entrega = per_entrega.per_catalogo
    LEFT JOIN mper AS per_recibe ON inv_movimientos.mov_perso_recibe = per_recibe.per_catalogo
    LEFT JOIN mper AS per_respon ON inv_movimientos.mov_perso_respon = per_respon.per_catalogo
    WHERE 
        mper.per_catalogo = user 
        AND inv_producto.pro_id = 88 AND inv_producto.pro_situacion = 1 
        AND inv_almacenes.alma_id = 25 AND inv_almacenes.alma_situacion = 1 
        AND inv_uni_med.uni_id = 9 AND inv_uni_med.uni_situacion = 1;
    ";

    try {
        $almacenes = Almacen::fetchArray($sql);
        echo json_encode(['almacenes' => $almacenes]);
    } catch (Exception $e) {
        echo json_encode([
            'error' => [
                'detalle' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'línea' => $e->getLine(),
                'traza' => $e->getTrace(),
            ],
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

public static function generarPDF(Router $router) 
{
    try {

        $almacenes = json_decode($_POST['almacenes'], true);

        if (!$almacenes) {
            throw new Exception("No hay datos para generar el PDF");
        }

        $mpdf = new Mpdf([
            "orientation" => "L",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(30, 35, 25);

        $html = $router->load('reportekardex/pdf',  ['almacenes' => $almacenes]);
        $htmlHeader = $router->load('reportekardex/header');
        $htmlFooter = $router->load('reportekardex/footer');

        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

}