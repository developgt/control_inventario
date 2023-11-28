<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Insumos</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .report-header {
            text-align: center;
            margin-top: 20px;
            padding-bottom: 10px;
        }

        .report-footer {
            border-top: 5px solid #007bff; /* Línea azul en el pie de página */
            padding-top: 10px;
            color: #6c757d;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #e3f2fd; /* Fondo celeste metálico en el pie de página */
        }

        .report-title {
            font-size: 24px;
            margin: 20px 0;
            color: #000; /* Título en negro */
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
            margin-bottom: 30px;
            background-color: #fff;
            border: 2px solid #000; /* Bordes más definidos para la tabla */
        }

        .styled-table th {
            background-color: #e3f2fd; /* Encabezados en celeste metálico */
            color: #000; /* Texto oscuro para contraste */
        }

        .styled-table td {
            color: #000000;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #000; /* Bordes negros para cada celda */
        }

        .styled-table tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Filas alternas en gris claro */
        }

        .fecha {
            margin-top: 5px;
            color: #6c757d;
            font-size: 0.8em;
        }

  
    </style>
</head>

<body>
    <header>
  
    <div style="position: relative; text-align: center;">
    <span>Ejército de Guatemala</span>
        <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%);">
            <img src="./images/min.png" alt="Descripción de la imagen" style="width: 80px; height: auto;">
        </div>
    </div>


    </header>
    <div class="report-header">
        <h1 class="report-title">Reporte de Existencias de Insumos del inventario "<?= htmlspecialchars($datos[0]->alma_nombre) ?>"</h1>
        <div class="fecha">
            <span class="right">Fecha del Reporte: <?= date("d/m/Y") ?></span>
        </div>
    </div>

    <table class="styled-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Inventario al que pertenecen</th>
                <th>Nombre del Insumo</th>
                <th>Estado del Insumo</th>
                <th>Unidad de Medida</th>
                <th>Fecha de Vencimiento</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php $contador = 1; ?>
            <?php foreach ($datos as $movimiento) : ?>
                <tr>
                    <td><?= $contador++ ?></td>
                    <td><?= htmlspecialchars($movimiento->alma_nombre) ?></td>
                    <td><?= htmlspecialchars($movimiento->pro_nom_articulo) ?></td>
                    <td><?= htmlspecialchars($movimiento->est_descripcion) ?></td>
                    <td><?= htmlspecialchars($movimiento->uni_nombre) ?></td>
                    <td><?= htmlspecialchars($movimiento->det_fecha_vence) == '1999-05-07' ? 'Sin fecha de vencimiento' : htmlspecialchars($movimiento->det_fecha_vence) ?></td>
                    <td><?= htmlspecialchars($movimiento->det_cantidad) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



    <div class="report-footer">
        <span>Sistema de Gestión de Control de Inventarios - Reporte generado automáticamente</span>
    </div>
</body>
</html>