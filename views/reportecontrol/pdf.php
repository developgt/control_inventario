<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe del Inventario</title>
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

        h1,h4 {
            border-bottom: 2px solid black;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

<h4>Nombre  del Inventario</h4>
<h1 style="font-size: 24px; font-weight: bold;"><?= $almacenes[0]['nombre_almacen'] ?></h1>
<br><br>
<h4>Contenido Neto del Almacén</h4>

    
    <table>
        <thead>
            <tr>
                <th>Nombre Producto</th>
                <th>Descripción Estado</th>
                <th>Fecha Vencimiento</th>
                <th>Lote/Serie</th>
                <th>Descripción Producto</th>
                <th>Cantidad Existente</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($almacenes as $almacen) : ?>
                <tr>
                    <td><?= $almacen['nombre_producto'] ?></td>
                    <td><?= $almacen['descripcion_estado'] ?></td>
                    <td><?= ($almacen['fecha_vencimiento'] == '1999-05-07') ? 'SIN FECHA DE VENCIMIENTO' : $almacen['fecha_vencimiento'] ?></td>
                    <td><?= $almacen['lote_serie'] ?></td>
                    <td><?= $almacen['descripcion_producto'] ?></td>
                    <td><?= $almacen['cantidad_existente'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
