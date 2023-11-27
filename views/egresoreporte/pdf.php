<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos</title>
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

        .signature-section {
            text-align: center;
            margin-top: 60px;
        }

        .signature-recibi-entregue {
            float: left;
            width: 30%;

        }

        .signature-entregue {
            float: right;
            width: 30%;
        }

        .signature-line {
            border-top: 2px solid #000;
            margin: 10px;
            width: 80%;
        }

        .signature-name {
            font-size: 0.7em;
            text-align: center;
            margin-top: 5px;

        }

        .firma {
            font-size: 0.9em;
            text-align: center;
            margin-top: 5px;
            margin-bottom: 50px;
            font-weight: bold;
            color: #333;
        }

        .signature-responsable {
            display: block;
            margin: 150px auto;
            width: 30%;
        }

        .fecha {
            float: right;
            width: 40%;
        }

        .ingreso {
            float: left;
            width: 40%;

        }
    </style>
</head>

<body>
    <div class="report-header">
        <h1 class="report-title">Reporte de Movimientos</h1>
        <div class="ingreso">
            <span class="left">No. de egreso: <?= htmlspecialchars($datos[0]->mov_id) ?></span>
        </div>
        <div class="fecha">
            <span class="right">Fecha del Reporte: <?= date("d/m/Y") ?></span>
        </div>
    </div>

    <table class="styled-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Inventario del que Egreso</th>
                <th>Tipo de Movimiento</th>
                <th>Fecha</th>
                <th>Nombre del Producto</th>
                <th>Estado del Insumo</th>
                <th>Unidad de Medida</th>
                <th>Fecha de Vencimiento</th>
                <th>Cantidad</th>
                <th>Destino</th>
            </tr>
        </thead>
        <tbody>
            <?php $contador = 1; ?>
            <?php foreach ($datos as $movimiento) : ?>
                <tr>
                    <td><?= $contador++ ?></td>
                    <td><?= htmlspecialchars($movimiento->alma_nombre) ?></td>
                    <td><?= $movimiento->mov_tipo_trans == 'I' ? 'Egreso Interno' : ($movimiento->mov_tipo_trans == 'E' ? 'Egreso Externo' : htmlspecialchars($movimiento->mov_tipo_trans)) ?></td>
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


    <div class="signature-section">
        <div class="signature-recibi-entregue">
            <p class="firma">RECIBÍ</p>
            <div class="signature-line"></div>
            <div class="signature-name"><?= htmlspecialchars($datos[0]->mov_perso_recibe_nom) ?></div>
        </div>

        <div class="signature-entregue">
            <p class="firma">ENTREGUÉ</p>
            <div class="signature-line"></div>
            <div class="signature-name"><?= htmlspecialchars($datos[0]->mov_perso_entrega_nom) ?></div>
        </div>

        <div class="signature-responsable">
            <p class="firma">RESPONSABLE</p>
            <div class="signature-line"></div>
            <div class="signature-name"><?= htmlspecialchars($datos[0]->mov_perso_respon_nom) ?></div>
        </div>

    </div>





</body>

</html>