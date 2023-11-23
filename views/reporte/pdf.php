<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
        }
        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        .signature-space {
            padding-top: 15px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 10px auto;
        }
        .footer-section {
            margin-top: 30px;
        }
        .footer-section p {
            display: inline-block;
            width: 30%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <h1>Reporte de Movimientos</h1>
        <p>No. de ingreso <?= htmlspecialchars($datos[0]->mov_id) ?></p>
        <p>Fecha del Reporte: <?= date("d/m/Y") ?></p>
    </div>
    <table class="styled-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Inventario al que Ingreso</th>
                <th>Tipo de Movimiento</th>
                <th>Fecha</th>
                <th>Nombre del Producto</th>
                <th>Estado del Insumo</th>
                <th>Unidad de Medida</th>
                <th>Fecha de Vencimiento</th>
                <th>Cantidad</th>
                <th>Procedencia</th>
            </tr>
        </thead>
        <tbody>
            <?php $contador = 1; ?>
            <?php foreach ($datos as $movimiento) : ?>
                <tr>
                    <td><?= $contador++ ?></td>
                    <td><?= htmlspecialchars($movimiento->alma_nombre) ?></td>
                    <td><?= $movimiento->mov_tipo_trans == 'I' ? 'Ingreso Interno' : ($movimiento->mov_tipo_trans == 'E' ? 'Ingreso Externo' : htmlspecialchars($movimiento->mov_tipo_trans)) ?></td>
                    <td><?= htmlspecialchars($movimiento->mov_fecha) ?></td>
                    <td><?= htmlspecialchars($movimiento->pro_nom_articulo) ?></td>
                    <td><?= htmlspecialchars($movimiento->est_descripcion) ?></td>
                    <td><?= htmlspecialchars($movimiento->uni_nombre) ?></td>
                    <td><?= htmlspecialchars($movimiento->det_fecha_vence) == '1999-05-07' ? 'Sin fecha de vencimiento' : htmlspecialchars($movimiento->det_fecha_vence) ?></td>
                    <td><?= htmlspecialchars($movimiento->det_cantidad) ?></td>
                    <td><?= htmlspecialchars($movimiento->dep_desc_md) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer-section">
        <p>Persona que Entrega: <?= htmlspecialchars($datos[0]->mov_perso_entrega_nom) ?></p>
        <div class="signature-line"></div>
        <p>Persona que Recibe: <?= htmlspecialchars($datos[0]->mov_perso_recibe_nom) ?></p>
        <div class="signature-line"></div>
        <p>Persona Responsable: <?= htmlspecialchars($datos[0]->mov_perso_respon_nom) ?></p>
        <div class="signature-line"></div>
    </div>
</body>
</html>

