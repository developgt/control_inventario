<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Kardex</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 20px;
            color: #333;
        }

        h1, h4 {
            color: black;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #343a40; 
            padding: 12px;
            text-align: left;
            color: #333;
        }

        th {
            background-color: #212529;
            color: #fff; 
        }

        h4 {
            border-bottom: 2px solid black;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

<h4>Nombre y Clase del Inventario:</h4>
<h1 style="font-size: 24px; font-weight: bold;"><?= $almacenes[0]['nombre_almacen'] ?> - <?= $almacenes[0]['descripcion_clase'] ?></h1>
<h4 style="font-weight: normal;">Descripción del Inventario: <?= $almacenes[0]['alma_descripcion'] ?></h4>
<br><br>
<h4>Historial de los Movimientos Realizados</h4>
<table>
    <thead>
        <tr>
            <th>No. de Gestion</th>
            <th>Tipo del Movimiento</th>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Unidad de Medida</th>
            <th>Articulo</th>
            <th>Estado</th>
            <th>No. Serie/Lote</th>
            <th>Descripcion del Movimiento</th>
            <th>Procedencia/Destino</th>
            <th>Persona Entrega</th>
            <th>Persona Recibe</th>
            <th>Persona Responsable</th>
            <th>Observaciones</th>
            <th>Nueva Cantidad Existente</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($almacenes as $almacen) : ?>
            <tr>
                <td><?= $almacen['mov_id'] ?></td>
                <td><?= ($almacen['mov_tipo_mov'] == 'I') ? 'Ingreso' : 'Egreso' ?></td>
                <td><?= $almacen['mov_fecha'] ?></td>
                <td><?= $almacen['det_cantidad'] ?></td>
                <td><?= $almacen['nombre_unidad_medida'] ?></td>
                <td><?= $almacen['nombre_producto'] ?></td>
                <td><?= $almacen['descripcion_estado'] ?></td>
                <td><?= $almacen['det_lote'] ?></td>
                <td><?= $almacen['mov_descrip'] ?></td>
                <td><?= $almacen['descripcion_proce_destino'] ?></td>
                <td><?= $almacen['mov_perso_entrega_nom'] ?></td>
                <td><?= $almacen['mov_perso_recibe_nom'] ?></td>
                <td><?= $almacen['mov_perso_respon_nom'] ?></td>
                <td><?= $almacen['det_observaciones'] ?></td>
                <td><?= $almacen['det_cantidad_existente'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
