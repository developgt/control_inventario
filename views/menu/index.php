<!DOCTYPE html>
<html lang="es">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
</head>
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
      text-align: left;
      text-transform: uppercase;
      font-size: 14px;
    }

.small {
  font-size: 14px;
  margin-bottom: 5vh;
}

</style>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-2 contenido-izquierdo" style="background-color: black; color: white; padding: 20px;">
      <div class="card-body text-center">
        <img id="fotoUsuario" class="card-img-top" src="./images/header.jpg" alt="header">
        <br><br>
        <p class="card-text fw-bold"> <?= $usuario['grado'] .' '. $usuario['nombre'] ?> </p>
        <p class="card-text fw-bold"> <?= $usuario['empleo'] ?> </p>
        <figure>
        <blockquote id='miBloqueCita' class="blockquote small">
        "La preparación es la clave del éxito en cualquier batalla. 
        Tener los suministros adecuados en el momento adecuado puede cambiar el curso de la historia". 
        </blockquote>
          <figcaption class="blockquote-footer text-muted">
            Dwight D. Eisenhower
                </figcaption>
        </figure>
      </div>
    </div>

    <div class="col-lg-10 text-center">
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
        <br><br>
      <div class="card-body">        
            <figure>
                <blockquote id='miBloqueCita' class="blockquote">
                "En el campo de batalla, la verdadera destreza se muestra no solo en la ferocidad del combate,
                 sino en la capacidad de dirigir y administrar los recursos de manera que se alcancen los objetivos estratégicos y se preserven vidas valiosas."
                </blockquote><br><br>
                    <figcaption class="blockquote-footer text-muted">
                    Erwin Rommel
                        </figcaption>
            </figure>
        </div>  
    </div>
  </div>
</div>

<!-- Modal para seleccionar el almacén -->
<div class="modal fade" id="modalSeleccionarAlmacen" tabindex="-1" aria-labelledby="modalSeleccionarAlmacenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSeleccionarAlmacenLabel">Seleccionar Almacén</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <form id="formSeleccionarAlmacen">
                    <div class="form-group">
                        <label for="selectAlmacenes">Seleccione el almacén:</label>
                        <select class="form-control" id="selectAlmacenes" name="almacen">
                            <!-- Opciones del select se llenarán con JavaScript -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Ingresar al Almacen Seleccionado</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script> 
        const usuario = <?= json_encode($usuario) ?>; 
        const fotoUrl = `https://sistema.ipm.org.gt/sistema/fotos_afiliados/ACTJUB/${usuario.per_catalogo}.jpg`;
        document.getElementById("fotoUsuario").src = fotoUrl;
    </script>
<script src="<?= asset('./build/js/gestion/index.js') ?>"></script>
</body>
</html>
