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
            m2.mov_alma_id =  $alma_id
             AND d2.det_situacion = 1
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