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

        <div class="card-body text-center mt-4">

            <h1 class="text-center">Selecciona el Producto para Generar el Kardex</h1>
            <br><br>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioKardex">
        <div class="row mb-3">
            <div class="col">
                <label for="kardex_producto">Nombre del Producto:</label>
                <select name="kardex_producto" id="kardex_producto" class="form-control">
                    <option value="">Seleccione el Producto</option>
                </select>
            </div>
        </div>

            <div class="row mb-3">
                <div class="col">
                    <button type="button" id="btnBuscar" class="btn btn-info btn-block">Buscar</button>
                </div>
            </div>
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
<script src="<?= asset('./build/js/kardex/index.js') ?>"></script>

</body>
</html>
