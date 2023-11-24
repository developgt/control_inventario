<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Kardex</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte de Kardex</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo del Movimiento</th>
                <th>No. de Gestion</th>
                <th>Descripcion del Movimiento</th>
                <th>Procedencia/Destino</th>
                <th>Cantidad</th>
                <th>Unidad de Medida</th>
                <th>Articulo</th>
                <th>No. Serie/Lote</th>
                <th>Estado</th>
                <th>Nueva Cantidad Existente</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($almacenes as $almacen) : ?>
                <tr>
                    <td><?= $almacen['mov_fecha'] ?></td>
                    <td><?= ($almacen['mov_tipo_mov'] == 'I') ? 'Ingreso' : 'Egreso' ?></td>
                    <td><?= $almacen['mov_id'] ?></td>
                    <td><?= $almacen['mov_descrip'] ?></td>
                    <td><?= $almacen['descripcion_proce_destino'] ?></td>
                    <td><?= $almacen['det_cantidad'] ?></td>
                    <td><?= $almacen['nombre_unidad_medida'] ?></td>
                    <td><?= $almacen['nombre_producto'] ?></td>
                    <td><?= $almacen['det_lote'] ?></td>
                    <td><?= $almacen['descripcion_estado'] ?></td>
                    <td><?= $almacen['det_cantidad_existente'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
