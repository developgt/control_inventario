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
        }

        .report-header {
            text-align: center;
            margin-top: 20px;
        }

        .report-details {
            text-align: center;
            margin-top: 5px;
        }

        .report-title {
            font-size: 24px;
            margin: 20px 0;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
            margin-bottom: 30px;
        }

        .report-title {
            font-size: 24px;
            margin: 20px 0;
            color: #333;
        }

        .styled-table th {
            background-color: #f2f2f2;
        }

        .styled-table td {
            color: #000000;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #050505;
        }


        .fecha {
            float: left;
            width: 40%;
        }

  
    </style>
</head>

<body>
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
</body>
</html>