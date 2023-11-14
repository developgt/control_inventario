<!DOCTYPE html>
<html lang="es">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .carousel-inner img {
      width: 100%;
      height: 100%;
    }

    .carousel-item img {
      height: 400px; 
      object-fit: cover; 
    }

    #almacenAsignado {
      text-align: left; /* Alineación a la izquierda */
      text-transform: uppercase; /* Convertir a mayúsculas */
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="row justify-content-center mt-0">
    
    <div class="col-lg-3">
        <div class="contenido-izquierdo" style="background-color: black; color: white; padding: 20px;">
            <div class="card-body text-center">
                <img id="fotoUsuario" class="card-img-top" src="./images/header.jpg" alt="header">
                <br><br>
                <p class="card-text fw-bold"> <?= $usuario['grado'] .' '. $usuario['nombre'] ?> </p>
                <p> ALMACENES ASIGNADOS </p>
                <figure>
                    <blockquote id='almacenAsignado' class="blockquote">
                        <!-- Vacío inicialmente, se llenará con JavaScript -->
                    </blockquote>
                </figure>
                <button class="btn btn-warning btn-block" style="margin-top: 20px;">Ingresar como Guardalmacén</button>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <!-- Carrusel -->
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= asset('./images/header.jpg') ?>" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="<?= asset('./images/header2.jpeg') ?>" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="<?= asset('./images/header3.jpg') ?>" class="d-block w-100" alt="">
                </div>
            </div>
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="card-body text-center mt-4">
            <figure>
                <blockquote class="blockquote">
                    <p class="text-muted">
                        "La victoria se obtiene con la planificación cuidadosa, la gestión sabia de los recursos y 
                        la atención meticulosa a los detalles. En la guerra, cada recurso cuenta,
                        y aquel que administra su inventario con prudencia asegura el triunfo en el campo de batalla".
                    </p>
                </blockquote>
                <figcaption class="blockquote-footer text-muted">
                    Sun Tzu
                </figcaption>
            </figure>
            <button class="btn btn-warning btn-lg" style="position: absolute; bottom: 0; right: 0; margin: 10px;">
                Gestionar Almacenes <i class="bi bi-arrow-right-square bi-lg"></i>
            </button>
        </div>
    </div>
</div>

<script> 
    const nombreAlmacen = document.getElementById('almacenAsignado')
   
    var usuario = <?= json_encode($usuario) ?>; 
    var fotoUrl = `https://sistema.ipm.org.gt/sistema/fotos_afiliados/ACTJUB/${usuario.per_catalogo}.jpg`; 
    document.getElementById("fotoUsuario").src = fotoUrl; 

    const buscar = async () => {
        const url = `/control_inventario/API/menu/buscar`;
        const config = {
            method: 'GET'
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            if (data.almacenes && data.almacenes.length > 0) {
                const nombresAlmacen = data.almacenes.map(almacen => almacen.alma_nombre.toUpperCase()).join('<br>');
                nombreAlmacen.innerHTML = `<ol>${nombresAlmacen}</ol>`;
            } else {
                nombreAlmacen.innerHTML = 'No se encontraron registros';
            }
        } catch (error) {
            console.log(error);
        }

    };

    buscar();
</script>

</body>
</html>
