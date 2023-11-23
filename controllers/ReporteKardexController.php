<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use Model\Guarda;
use Model\Almacen;
use Model\Producto;
use Model\Movimiento;
use MVC\Router;
use Mpdf\Mpdf;

class ReporteKardexController
{
    // ... (otros métodos)

    public static function pdf(Router $router)
    {
        // Obtener parámetros de la URL
        $almacenId = $_GET['almacen'] ?? '';
        $productoId = $_GET['producto'] ?? '';
        $medidaId = $_GET['medida'] ?? '';

        // Validar parámetros
        if (empty($almacenId) || empty($productoId) || empty($medidaId)) {
            // Manejar el caso en que falten parámetros
            echo json_encode([
                'detalle' => 'Faltan parámetros en la URL',
                'mensaje' => 'Por favor, proporciona los parámetros necesarios.',
                'codigo' => 1
            ]);
            return;
        }

        try {
            // Obtener información del usuario (similar a lo que ya tienes en el controlador de Kardex)
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
                    per_catalogo = user
            ");

            // Obtener información del kardex según los parámetros proporcionados
            $kardexData = self::obtenerDatosKardex($almacenId, $productoId, $medidaId);

            // Crear un nuevo objeto mpdf
            $mpdf = new Mpdf();

            // Crear el contenido del PDF
            $html = $router->renderView('reportekardex/pdf', [
                'usuario' => $usuario,
                'kardexData' => $kardexData,
            ]);

            // Agregar el contenido al PDF
            $mpdf->WriteHTML($html);

            // Guardar o mostrar el PDF
            $mpdf->Output();
        } catch (Exception $e) {
            // Manejar errores de conexión a la base de datos u otros
            echo json_encode([
                'detalle' => $e->getMessage(),
               
        
        'mensaje' => 'Error de conexión bd',
                'codigo' => 5,
            ]);
        }
    }

    // ... (otros métodos)
}
