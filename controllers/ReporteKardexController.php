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
    // Método para generar el PDF
    public static function pdf(Router $router)
    {
        $mpdf = new Mpdf([
            "orientation" => "P",
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

    // Método para buscar el recibo
    public static function buscarReciboAPI()
    {
        $alma_id = $_GET['alma_id'] ?? '';
        $pro_id = $_GET['pro_id'] ?? '';
        $uni_id = $_GET['uni_id'] ?? '';

        // Aquí debes poner tu consulta SQL
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
        mper.per_catalogo = user AND inv_producto.pro_id = $pro_id AND inv_producto.pro_situacion = 1 
    AND inv_almacenes.alma_id = $alma_id AND inv_almacenes.alma_situacion = 1 
    AND inv_uni_med.uni_id = $uni_id AND inv_uni_med.uni_situacion = 1 ;
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

    // Método para generar el PDF (Revisado)
    public static function generarPDF(Router $router) 
    {
        try {
            $datos = json_decode(file_get_contents('php://input'));

            if (!$datos) {
                throw new Exception("No hay datos para generar el PDF");
            }

            $mpdf = new Mpdf([
                "orientation" => "P",
                "default_font_size" => 12,
                "default_font" => "arial",
                "format" => "Letter",
                "mode" => 'utf-8'
            ]);
            $mpdf->SetMargins(30, 35, 25);

            $html = $router->load('reportekardex/pdf', ['datos' => $datos]);
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