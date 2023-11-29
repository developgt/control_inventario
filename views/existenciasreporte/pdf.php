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

        header {
            text-align: center;
        }

        header span {
            font-size: 22px;
            font-weight: bold;
            color: #000;
    
        }

        .report-header {
            text-align: center;
            margin: 20px 0;
        }

        .report-title {
            font-size: 24px;
            color: #000;
            margin: 20px 0;
            text-align: center;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
            margin-bottom: 30px;
            background-color: #fff;
            border: 2px solid #000;

        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #000;
            text-align: left;
        }

        .styled-table thead th {
            background-color: #f2f2f2;
            color: #000;
        }

        .styled-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
           
        }

        .fecha {
            font-size: 0.9em;
            color: #333;
            margin-bottom: 20px;
        }

 
        header {
            border-bottom: 2px solid #000;
            bottom: 25px;
           
        }

        .report-footer {
            border-top: 2px solid #000;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
<header>
  <div style="text-align: center;">
  <span>Ejército de Guatemala</span>
      <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%);">
          <img src="./images/min.png" alt="Descripción de la imagen" style="width: 80px; height: auto;">
      </div>
  </div>
</header>


    <div class="report">
        <h1 class="report-title text-align: center; ">Reporte de Existencias de Insumos del inventario "<?= htmlspecialchars($datos[0]->alma_nombre) ?>"</h1>
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