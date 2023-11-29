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

class ReporteControlController
{

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

        $html = $router->load('reportecontrol/pdf');
        $htmlHeader = $router->load('reportecontrol/header');
        $htmlFooter = $router->load('reportecontrol/footer');

        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

   
    public static function buscarReciboAPI()
    {
        $alma_id = $_GET['alma_id'] ?? '';

        
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
        MAX(inv_deta_movimientos.det_cantidad_lote) AS cantidad_existente
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
        AND inv_guarda_almacen.guarda_almacen = $alma_id 
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
            "orientation" => "P",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(30, 35, 25);

        $html = $router->load('reportecontrol/pdf',  ['almacenes' => $almacenes]);
        $htmlHeader = $router->load('reportecontrol/header');
        $htmlFooter = $router->load('reportecontrol/footer');

        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

}