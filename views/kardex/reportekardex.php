<?php
require_once __DIR__ . '/vendor/autoload.php'; // Ajusta la ruta según tu estructura de carpetas

use Mpdf\Mpdf;

// Obtener el contenido HTML de la tabla desde la solicitud AJAX
$tablaContenido = urldecode($_POST['tablaContenido']);

// Configurar mPDF
$mpdf = new Mpdf();
$mpdf->WriteHTML($tablaContenido);

// Obtener el contenido del PDF como una cadena base64
$pdfContent = base64_encode($mpdf->Output('', 'S'));

// Devolver el PDF al cliente
echo $pdfContent;
?>
