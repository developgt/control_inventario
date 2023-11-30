<?php

namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Detalle;
use Exception;

class ReporteEgresoController
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

        $html = $router->load('egresoreporte/pdf');
        $htmlHeader = $router->load('egresoreporte/header');
        $htmlFooter = $router->load('egresoreporte/footer');

        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

    // Método para buscar el recibo
    public static function buscarReciboAPI()
    {
        $det_mov_id = $_GET['det_mov_id'] ?? '';

     
        $sql = "SELECT 
        m.*, 
        d.*, 
        e.est_descripcion, 
        u.uni_nombre, 
        p.pro_nom_articulo,
        a.alma_nombre, 
        dep.dep_desc_md, 
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
    FROM 
        inv_movimientos AS m
    JOIN 
        inv_deta_movimientos AS d ON m.mov_id = d.det_mov_id
    LEFT JOIN 
        inv_estado AS e ON d.det_estado = e.est_id
    LEFT JOIN 
        inv_uni_med AS u ON d.det_uni_med = u.uni_id
    LEFT JOIN 
        inv_producto AS p ON d.det_pro_id = p.pro_id
    JOIN 
        inv_almacenes AS a ON m.mov_alma_id = a.alma_id
    LEFT JOIN 
        mdep AS dep ON a.alma_unidad = dep.dep_llave  
    -- Datos de la persona que entrega
    LEFT JOIN 
        mper AS pe ON m.mov_perso_entrega = pe.per_catalogo
    LEFT JOIN 
        grados AS ge ON pe.per_grado = ge.gra_codigo
    LEFT JOIN 
        armas AS ae ON pe.per_arma = ae.arm_codigo
    -- Datos de la persona que recibe
    LEFT JOIN 
        mper AS pr ON m.mov_perso_recibe = pr.per_catalogo
    LEFT JOIN 
        grados AS gr ON pr.per_grado = gr.gra_codigo
    LEFT JOIN 
        armas AS ar ON pr.per_arma = ar.arm_codigo
    -- Datos de la persona responsable
    LEFT JOIN 
        mper AS per ON m.mov_perso_respon = per.per_catalogo
    LEFT JOIN 
        grados AS g ON per.per_grado = g.gra_codigo
    LEFT JOIN 
        armas AS arm ON per.per_arma = arm.arm_codigo
    WHERE 
        m.mov_situacion = 1 AND d.det_mov_id = $det_mov_id AND d.det_situacion = 1 AND m.mov_id = $det_mov_id"; 

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


       // Método para buscar el recibo
       public static function buscarRecibo2API()
       {
           $det_mov_id = $_GET['det_mov_id'] ?? '';
   
          
           $sql = "SELECT 
           m.*, 
           d.*, 
           e.est_descripcion, 
           u.uni_nombre, 
           p.pro_nom_articulo,
           a.alma_nombre, 
           dep.dep_desc_md, 
        dep.dep_desc_lg, 
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
       FROM 
           inv_movimientos AS m
       JOIN 
           inv_deta_movimientos AS d ON m.mov_id = d.det_mov_id
       LEFT JOIN 
           inv_estado AS e ON d.det_estado = e.est_id
       LEFT JOIN 
           inv_uni_med AS u ON d.det_uni_med = u.uni_id
       LEFT JOIN 
           inv_producto AS p ON d.det_pro_id = p.pro_id
       JOIN 
           inv_almacenes AS a ON m.mov_alma_id = a.alma_id
       LEFT JOIN 
           mdep AS dep ON a.alma_unidad = dep.dep_llave  
       -- Datos de la persona que entrega
       LEFT JOIN 
           mper AS pe ON m.mov_perso_entrega = pe.per_catalogo
       LEFT JOIN 
           grados AS ge ON pe.per_grado = ge.gra_codigo
       LEFT JOIN 
           armas AS ae ON pe.per_arma = ae.arm_codigo
       -- Datos de la persona que recibe
       LEFT JOIN 
           mper AS pr ON m.mov_perso_recibe = pr.per_catalogo
       LEFT JOIN 
           grados AS gr ON pr.per_grado = gr.gra_codigo
       LEFT JOIN 
           armas AS ar ON pr.per_arma = ar.arm_codigo
       -- Datos de la persona responsable
       LEFT JOIN 
           mper AS per ON m.mov_perso_respon = per.per_catalogo
       LEFT JOIN 
           grados AS g ON per.per_grado = g.gra_codigo
       LEFT JOIN 
           armas AS arm ON per.per_arma = arm.arm_codigo
       WHERE 
           m.mov_situacion = 2 AND d.det_mov_id = $det_mov_id AND d.det_situacion = 1 AND m.mov_id = $det_mov_id"; 
   
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

            $html = $router->load('egresoreporte/pdf', ['datos' => $datos]);
            $htmlHeader = $router->load('egresoreporte/header',['datos' => $datos]);
            $htmlFooter = $router->load('egresoreporte/footer', ['datos' => $datos]);

            $mpdf->SetHTMLHeader($htmlHeader);
            $mpdf->SetHTMLFooter($htmlFooter);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}