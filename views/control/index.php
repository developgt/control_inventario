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

    #almacenAsignado {
      text-align: left;
      text-transform: uppercase;
      font-size: 14px;
    }

    .small {
  font-size: 14px;
  margin-bottom: 5vh;
}

.col-fijo {
      position: sticky;
      top: 50px; 
    }

    .contenido-interno {
      background-color: black;
      color: white;
      padding: 20px;
    }

body {
        font-size: 90%;
        zoom: 80%;

    }

</style>
<body>

<div class="row mt-0">
    <div class="col-fijo col-lg-2 h-100">
        <div class="contenido-izquierdo" style="background-color: black; color: white; padding: 20px;">
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
    </div>

    <div class="col-lg-10">

        <div class="card-body text-center mt-4">

            <h1 class="text-center">Verificacion de los Recursos Asignados al inventario</h1>
            <br><br>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioControl">
        <div class="row mb-3">
            <div class="col">
                <label for="control_almacen">Seleccione el Inventario a Consultar</label>
                <select name="control_almacen" id="control_almacen" class="form-control">
                    <option value="">Seleccione el Inventario</option>
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

<div id="mostrarResultados">

</div>

        </div>
    </div>
</div>



    <script> 
            const usuario = <?= json_encode($usuario) ?>; 
            const fotoUrl = `https://sistema.ipm.org.gt/sistema/fotos_afiliados/ACTJUB/${usuario.per_catalogo}.jpg`;
            document.getElementById("fotoUsuario").src = fotoUrl;
    </script>
<script src="<?= asset('./build/js/control/index.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
