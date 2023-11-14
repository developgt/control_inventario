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
<body class="bg-light" >
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img src="<?= asset('./images/min.png') ?>" width="35px'" alt="min">
        </a>
        <a class="navbar-brand" href="#">
            <p class="card-text fw-bold"> SISTEMA DE GESTION DE INVENTARIOS DEL <?= $usuario['dependencia'] ?> </p>
        </a>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto">
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
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        <?php echo $contenido; ?>  
    </div>
    <div class="container-fluid ">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                <?= $usuario['dependencia'] ?>, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
    <script src="build/js/inicio.js"></script>
</body>
</html>