<style>
    .titulo-estadisticas {
        text-align: center;
        background-color: #007bff;
        color: #ffffff;
        padding: 20px;
        margin-top: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .titulo-estadisticas:hover {
        background-color: #0056b3;
    }

    .contenedor-principal {
        padding: 20px;
        margin-top: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .formulario-busqueda {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .grafica {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .formulario-busqueda, .grafica {
    margin-bottom: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.canvas-container {
    position: relative; 
    height: 500px; 
    justify-content: center;
}

#chartInventario {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

</style>

<div class="container contenedor-principal">
    <h1 class="titulo-estadisticas">Estadísticas de Ingresos y Egresos de Productos por Inventario</h1>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="formulario-busqueda">
            <form class="border rounded bg-light p-3" id="formularioBusqueda">
                <label for="mov_alma_id" class="form-label">Seleccione el inventario</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                    <select name="mov_alma_id" id="mov_alma_id" class="form-select">
                        <option value="">SELECCIONE...</option>
                    </select>
                </div>
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Ver Estadisticas</button>
            </form>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
    <h6 class="titulo-estadisticas">Cantidad de Productos Ingresados por Inventario</h6>
        <div class="grafica canvas-container">
            <canvas id="chartIngreso"></canvas>
            <h6 id="mensajeIngreso" class="mensaje-grafica text-center" style="display: none;">No se han realizado ingresos</h6>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
    <h6 class="titulo-estadisticas">Cantidad de Productos Egresados por Inventario</h6>
        <div class="grafica canvas-container">
            <canvas id="chartEgreso"></canvas>
            <h6 id="mensajeEgreso" class="mensaje-grafica text-center" style="display: none;">No se han realizado egresos</h6>
        </div>
    </div>
</div>



<script src="<?= asset('./build/js/estadisticas/cantidadestadistica.js') ?>"></script>