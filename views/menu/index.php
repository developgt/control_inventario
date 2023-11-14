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

<div class="row justify-content-center mt-0">
    
    <div class="col-lg-3">
        <div class="contenido-izquierdo" style="background-color: black; color: white; padding: 20px;">
            <div class="card-body text-center">
                <img id="fotoUsuario" class="card-img-top" src="./images/header.jpg" alt="header">
                <br><br>
                <p class="card-text fw-bold"> <?= $usuario['grado'] .' '. $usuario['nombre'] ?> </p>
                <p class="card-text fw-bold"> <?= $usuario['empleo'] ?> </p>
                <p> ALMACENES ASIGNADOS </p>
                <figure>
                    <blockquote id='almacenAsignado' class="blockquote">
                        <!-- Vacío inicialmente, se llenará con JavaScript -->
                    </blockquote>
                </figure>
                <button class="btn btn-warning btn-block" id="btnIngresarGuardalmacen" style="margin-top: 20px;">Ingresar como Guardalmacén</button>
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
            <button class="btn btn-primary btn-lg" id="buttonGestion" style="position: absolute; bottom: 0; right: 0; margin: 10px;">
                Gestionar Almacenes <i class="bi bi-arrow-right-square bi-lg"></i>
            </button>
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
    const buttonGestion = document.getElementById('buttonGestion');
    const nombreAlmacen = document.getElementById('almacenAsignado');
    const usuario = <?= json_encode($usuario) ?>;
    const fotoUrl = `https://sistema.ipm.org.gt/sistema/fotos_afiliados/ACTJUB/${usuario.per_catalogo}.jpg`;
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

    const btnIngresarGuardalmacen = document.getElementById('btnIngresarGuardalmacen');

    // Función para mostrar el modal al hacer clic en el botón "Ingresar como Guardalmacén"
    btnIngresarGuardalmacen.addEventListener('click', async function() {
        try {
            const respuesta = await fetch('/control_inventario/API/menu/buscar', { method: 'GET' });
            const data = await respuesta.json();
            const almacenes = data.almacenes || [];

            if (almacenes.length > 0) {
                const selectAlmacenes = document.getElementById('selectAlmacenes');
                selectAlmacenes.innerHTML = ''; // Limpiar opciones actuales

                almacenes.forEach(almacen => {
                    const option = document.createElement('option');
                    option.value = almacen.alma_nombre;
                    option.textContent = almacen.alma_nombre.toUpperCase();
                    selectAlmacenes.appendChild(option);
                });

                // Mostrar el modal
                $('#modalSeleccionarAlmacen').modal('show');
            } else {
                // Mostrar SweetAlert si no hay registros de almacenes
                Swal.fire({
                    icon: 'error',
                    title: 'No ha sido registrado en ningún almacén',
                    text: 'Por favor, contacte al administrador.',
                });
            }
        } catch (error) {
            console.log(error);
        }
    });

    // Función para manejar el envío del formulario y redirigir a la página correspondiente
    document.getElementById('formSeleccionarAlmacen').addEventListener('submit', function(event) {
        event.preventDefault();

        // Obtener el valor seleccionado en el select
        const selectedAlmacen = document.getElementById('selectAlmacenes').value;

        // Aquí puedes redirigir a la página correspondiente, por ejemplo:
        window.location.href = `/control_inventario/guardalmacen?almacen=${selectedAlmacen}`;

        // Cerrar el modal después de redirigir
        $('#modalSeleccionarAlmacen').modal('hide');
    });

    buttonGestion.addEventListener('click', function () {
        if (usuario && usuario.empleo) {
            if (usuario.empleo.includes('LOGISTICA')) {
                window.location.href = '/control_inventario/gestion';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Usted no posee permisos para la creación de almacenes.',
                });
            }
        } else {
            console.error('El objeto usuario o la propiedad empleo es undefined.');
        }
    });

</script>

</body>
</html>
