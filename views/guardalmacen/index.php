<?php
// Obtén el nombre del almacén de la URL
$nombreAlmacen = $_GET['almacen'] ?? 'Almacén Predeterminado';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Guarda Almacén</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2>Bienvenido al Almacén: <?= htmlspecialchars($nombreAlmacen) ?></h2>
        <p>Aquí puedes realizar las gestiones correspondientes.</p>

        <!-- Agrega aquí el contenido específico de la página del guardalmacén -->

    </div>

    <!-- Agrega aquí cualquier script adicional si es necesario -->

</body>

</html>
