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

.all {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
}

.clase1, .clase2, .clase3, .clase4, .clase5, .clase6, .clase7, .clase8, .clase9 {
  width: calc(33.33% - 20px);
  height: 180px;
  border-radius: 10px;
  border: 1px solid #fff;
  box-shadow: 0 0 20px 5px rgba(100, 100, 255, .4);
  position: relative;
  background-position: center center;
  background-size: contain;
  background-repeat: no-repeat;
  background-color: #58d;
  cursor: pointer;
  background-blend-mode: color-burn;
  margin-bottom: 20px;
  display: flex;
  justify-content: center;
  align-items: center; 
  transition: all 0.3s; /* Agregamos transición para suavizar el cambio */
}

.text {
  transform: translateY(30px);
  opacity: 1;
  transition: all .3s ease;
  bottom: 1em;
  margin: auto;
  padding: 1em;
  position: absolute;
  will-change: transform;
  color: black; 
  text-shadow: 0 0 5px rgba(100, 100, 255, .6);
  font-size: 18px; 
  text-align: center; 
}


.clase1:hover, .clase2:hover, .clase3:hover, .clase4:hover, .clase5:hover, .clase6:hover, .clase7:hover, .clase8:hover, .clase9:hover {
  background-size: 40%; 
}

.clase1:hover .text, .clase2:hover .text, .clase3:hover .text, .clase4:hover .text, .clase5:hover .text, .clase6:hover .text, .clase7:hover .text, .clase8:hover .text, .clase9:hover .text {
  display: none;
}

.clase1 {
  background-image: url("./images/clase1.png");
  background-size: 30%;
}


.clase2 {
  background-image: url("./images/clase2.png");
  background-size: 30%;
}

.clase3 {
  background-image: url("./images/clase3.png");
  background-size: 30%;
}

.clase4 {
  background-image: url("./images/clase4.png");
  background-size: 30%;
}

.clase5 {
  background-image: url("./images/clase5.png");
  background-size: 30%;
}

.clase6 {
  background-image: url("./images/clase6.png");
  background-size: 30%;
}

.clase7 {
  background-image: url("./images/clase7.png");
  background-size: 30%;
}

.clase8 {
  background-image: url("./images/clase8.png");
  background-size: 30%;
}

.clase9 {
  background-image: url("./images/clase9.png");
  background-size: 30%;
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
        <a  href="/control_inventario/"><button class="btn btn-info btn-block"  style="margin-top: 5vh;"> Menu Principal</button></a>
      </div>
    </div>

    <div class="col-lg-10 text-center">

      <div class="card-body">  
      <h3> Seleccione el Tipo de Abastecimiento a Inventario </h3>  <br>      
            <div class="all-body">
                <div class="all">
                    <div class="clase1">
                        <div class="text">Alimentos y Comestibles</div>
                    </div>
                    <div class="clase2">
                        <div class="text">Vestuario y Equipo Individual</div>
                    </div>
                    <div class="clase3">
                        <div class="text">Carburantes y Lubricantes</div>
                    </div>
                    <div class="clase4">
                        <div class="text">Material de Construccion</div>
                    </div>
                    <div class="clase5">
                        <div class="text">Articulos Personales</div>
                    </div>
                    <div class="clase6">
                        <div class="text">Articulos Terminados</div>
                    </div>
                    <div class="clase7">
                        <div class="text">Repuestos y Accesorios</div>
                    </div>
                    <div class="clase8">
                        <div class="text">Apoyo Asuntos Civiles</div>
                    </div>
                    <div class="clase9">
                        <div class="text">Material Capturado/Recuperable</div>
                    </div>
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
    </script>
<script src="<?= asset('./build/js/gestion/index.js') ?>"></script>
</body>
</html>
