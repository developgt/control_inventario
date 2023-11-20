<!DOCTYPE html>
<html lang="es">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- Agrega SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Agrega SweetAlert2 JS -->
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

.all-body {
  font-family: 'Raleway', sans-serif;
  background-image: radial-gradient(circle at center, #899Dc4, #495D84);
  background-size: cover;
  background-repeat: no-repeat;
  height: 25vh;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  background: radial-gradient(ellipse at bottom, #1b2735, #090a0f);
  font-weight: 300;

}
.all {
  display: flex;
  perspective: 10px;
  transform: perspective(300px) rotateX(20deg);
  will-change: perspective;
  perspective-origin: center center;
  transition: all 1.3s ease-out;
  justify-content: center;
  transform-style: preserve-3d;
}
.all:hover {
  perspective: 1000px;
  transition: all 1.3s ease-in;
  transform: perspective(10000px) rotateX(0deg);
  .text {
    opacity: 1;
  }
  & > div {
    opacity: 1;
    transition-delay: 0s;
  }
  .explainer {
    opacity: 0;
  }
}

.left, .center, .right, .lefter, .righter {
  width: 200px;
  height: 150px;
  transform-style: preserve-3d;
  border-radius: 10px;
  border: 1px solid #fff;
  box-shadow: 0 0 20px 5px rgba(100, 100, 255, .4);
  opacity: 0;
  transition: all .3s ease;
  transition-delay: 1s;
  position: relative;
  background-position: center center;
  background-size: contain;
  background-repeat: no-repeat;
  background-color: #58d;
  cursor: pointer;
  background-blend-mode: color-burn;
  
  &:hover {
    box-shadow: 0 0 30px 10px rgba(100, 100, 255, .6);
  background-color: #ccf;
  }
}
.text {
  transform: translateY(30px);
  opacity: 0;
  transition: all .3s ease;
  bottom: 0;
  left: 5px;
  position: absolute;
  will-change: transform;
  color: #fff;
  text-shadow: 0 0 5px rgba(100, 100, 255, .6)
}
.lefter {
  transform: translateX(-60px) translateZ(-50px) rotateY(-10deg);
  background-image: url(https://cdn3.iconfinder.com/data/icons/other-icons/48/organization-512.png);
}
.left {
  transform: translateX(-30px) translateZ(-25px) rotateY(-5deg);
  background-image: url(https://cdn3.iconfinder.com/data/icons/other-icons/48/creative_draw-512.png);
}
.center {
  opacity: 1;
  background-image: url(https://cdn3.iconfinder.com/data/icons/other-icons/48/app_window-512.png);
}
.right {
  transform: translateX(30px) translateZ(-25px) rotateY(5deg);
  background-image: url(https://cdn3.iconfinder.com/data/icons/other-icons/48/cloud_weather-512.png);
}
.righter {
  transform: translateX(60px) translateZ(-50px) rotateY(10deg);
  background-image: url(https://cdn3.iconfinder.com/data/icons/other-icons/48/search-512.png);
}
.explainer {
  font-weight: 300;
  font-size: 2rem;
  color: #fff;
  transition: all .6s ease;
  width: 100%;
  height: 100%;
  background-color: #303050;
  background-image: radial-gradient(circle at center top, #cce, #33a);
  border-radius: 10px;
  text-shadow: 0 0 10px rgba(255, 255, 255, .8);
  
  display: flex;
  justify-content: center;
  align-items: center;
}


.ref {
  background-color: #000;
  background-image: linear-gradient(to bottom, #d80, #c00);
  border-radius: 3px;
  padding: 7px 10px;
  position: absolute;
  font-size: 16px;
  bottom: 10px;
  right: 10px;
  color: #fff;
  text-decoration: none;
  text-shadow: 0 0 3px rgba(0, 0, 0, .4);
  &::first-letter {
    font-size: 12px;
  }
}

</style>
<body>

<div class="row mt-0">
    <div class="col-lg-2">
        <div class="contenido-izquierdo" style="background-color: black; color: white; padding: 20px;">
            <div class="card-body text-center">
                <img id="fotoUsuario" class="card-img-top" src="./images/header.jpg" alt="header">
                <br><br>
                <p class="card-text fw-bold"> <?= $usuario['grado'] .' '. $usuario['nombre'] ?> </p>
                <p>Nombre del Almacén:</p>
                <figure>
                <p id="nombreAlmacen"></p>
                </figure>
                <br><br><br><br>
                    <button class="btn btn-primary btn-block" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" >Generar Registros </button>
                    <a  href="/control_inventario/guardalmacen"><button class="btn btn-warning btn-block"  style="margin-top: 20px;">Regresar Almacen</button></a>
                    <a  href="/control_inventario/"><button class="btn btn-info btn-block"  style="margin-top: 20px;"> Menu Principal</button></a>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                          <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasRightLabel">Menu Principal del Guardalmacen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                          </div>
                      <div class="offcanvas-body">      
                          <div class="container mt-5">
                            <div class="row">
                              <div class="col-md-12 mb-3">
                                <button class="btn btn-primary btn-block" type="button">
                                  <i class="bi bi-plus"></i> Registrar Ingreso
                                </button>
                              </div>
                              <div class="col-md-12 mb-3">
                                <button class="btn btn-primary btn-block" type="button">
                                  <i class="bi bi-arrow-down-left"></i> Registrar Egreso
                                </button>
                              </div>
                              <div class="col-md-12 mb-3">
                                <a href="/control_inventario/kardex"><button class="btn btn-primary btn-block" type="button" >
                                <i class="bi bi-archive" ></i> Kardex por Producto
                                </button></a>
                              </div>
                              <div class="col-md-12 mb-3">
                                <button class="btn btn-primary btn-block" type="button">
                                  <i class="bi bi-person"></i> Atención al Usuario
                                </button>
                              </div>
                              <div class="col-md-12 mb-3">
                                <button class="btn btn-danger btn-block" type="button">
                                  <i class="bi bi-door-closed"></i> Cerrar Sesión
                                </button>
                              </div>
                          </div>
                      </div>
                    </div>
              </div>
            </div>
        </div>
    </div>

    <div class="col-lg-10">
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


        <div class="card-body">        
            <div class="all-body">
                <div class="all">
                    <div class="lefter">
                        <div class="text">Ingresos</div>
                    </div>
                    <div class="left">
                        <div class="text">Egresos</div>
                    </div>
                    <div class="center">
                        <div class="explainer"><span>Registrar Movimientos</span></div>
                    <div class="text">Gestion de Almacenes</div>
                    </div>
                    <div class="right">
                        <div class="text">Productos</div>
                    </div>
                      <div class="righter" href="/control_inventario/kardex" id="kardex">
                      <a href="/control_inventario/kardex"><div class="text">Kardex </div></a>
                      </div>
                  </div>
              </div>
        </div>  


        </div>
    </div>
</div>


    <script> 
        const usuario = <?= json_encode($usuario) ?>; 
        const fotoUrl = `https://sistema.ipm.org.gt/sistema/fotos_afiliados/ACTJUB/${usuario.per_catalogo}.jpg`;
        document.getElementById("fotoUsuario").src = fotoUrl;

        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el valor almacenado en localStorage
            const almacenSeleccionado = localStorage.getItem('almacenSeleccionado');

            // Hacer algo con el valor del almacén
            if (almacenSeleccionado) {
                // Imprimir el valor en la consola (puedes quitar esto en producción)
                console.log('Almacén Seleccionado:', almacenSeleccionado);

                // También puedes colocar el valor en algún elemento HTML si es necesario
                document.getElementById('nombreAlmacen').innerText = almacenSeleccionado;
            } else {
                console.warn('No se encontró un almacén seleccionado en localStorage.');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
          // Obtén el elemento div con la clase 'righter'
          var righterDiv = document.getElementById('kardex');

          // Agrega un evento de clic al div
          righterDiv.addEventListener('click', function() {
            // Redirige a la URL deseada
            window.location.href = 'kardex';
          });
        });

    </script>
<script src="<?= asset('./build/js/guardalmacen/index.js') ?>"></script>

</body>
</html>
