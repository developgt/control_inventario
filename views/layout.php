<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/min.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>Control de Inventarios</title>
</head>
<Style>
    body {
        font-size: 90%;
        zoom: 80%;

    }
</Style>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src="<?= asset('./images/min.png') ?>" width="35px'" alt="min">
            </a>
            <!-- <a class="navbar-brand" href="#">
                <p class="card-text fw-bold"> <?= $usuario['dependencia'] ?> </p>
            </a> -->
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/"><i class="bi bi-house-fill me-2"></i>Menu Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/gestion"><i class="bi bi bi-pencil-fill me-2"></i>Registrar Inventario</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/crear"><i class="bi bi bi-clipboard-data-fill me-2"></i>Administrar Inventario</a>
                    </li> -->
          
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/almacen"><i class="bi bi bi-building-fill-check me-2"></i>Inventario</a>
                    </li>
                    <li>
                        <a class="nav-link" aria-current="page" href="/control_inventario/movimiento"><i class="bi bi-box-arrow-in-down me-2"></i>Ingresos</a>
                    </li>
                    <li>
                        <a class="nav-link" aria-current="page" href="/control_inventario/movegreso"><i class="bi bi-box-arrow-up me-2"></i>Egresos</a>
                    </li>
                    <li>
                        <a class="nav-link" aria-current="page" href="/control_inventario/kardex"><i class="bi bi-archive-fill me-2"></i>Kardex</a>
                    </li>          
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/guarda"><i class="bi bi bi-building-fill-check me-2"></i>Entrega de Inventario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/estadisticas/estadistica"><i class="bi bi-bar-chart me-2"></i>Cantidad de Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/estadisticas/cantidadestadistica"><i class="bi bi-bar-chart me-2"></i>Estadísticas Movimientos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/control_inventario/control"><i class="bi bi bi-printer me-2"></i>Imprimir</a>
                    </li>
                    <!-- GESTION DE INVENTARIOS -->
                    <!-- <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi bi-building-fill-check me-2"></i>Gestión de Inventarios
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <li>
                                <a class="nav-link" aria-current="page" href="/control_inventario/movimiento"><i class="bi bi-file-music-fill me-2"></i>Gestión de Ingreso</a>
                            </li>
                            <li>
                                <a class="nav-link" aria-current="page" href="/control_inventario/movegreso"><i class="bi bi-bookmark-star-fill me-2"></i>Gestión de Egreso</a>
                            </li>
                        </ul>
                    </div> -->
                </ul>
                <ul class="navbar-nav me-0 mb-2 mb-lg-0" >
                    <li class="nav-item">
                        <a href="/login/logout" class="btn btn-danger"><i class="bi bi-x-lg me-2"></i>Cerrar Sesión</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-4 mb-4" style="min-height: 85vh">
        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:x-small; font-weight: bold;">
                    <?= $usuario['dependencia'] ?>, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
    <script src="build/js/inicio.js"></script>
</body>

</html>