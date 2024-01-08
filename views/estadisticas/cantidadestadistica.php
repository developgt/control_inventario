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
        box-shadow: 0 4px 8px rgba(0, 128, 255, 0.3), 0 6px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        justify-content: center;

    }

    .formulario-busqueda {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
    }

    .grafica {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        height: 700px;
        width: 600;
        position: relative;
      
    }

   
    .canvas-container {
        position: relative;
        justify-content: center;
    }

    #chartIngreso {
        padding-top: 100px;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        bottom: 0;
    }

    #chartIngresoEgreso {
        padding-top: 100px;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .chart-title {
        margin-bottom: 20px;
        background-color: rgba(173, 216, 230, 0.8) ;
        color: #2c3e50;
        padding: 20px;
        margin-top: 10px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #dee2e6;
        transition: background-color 0.3s;
    }


    .chart-title:hover {
        background-color: #dde1e6;
    
    }

    .grafica-container {
    display: flex;
    justify-content: center;
    height: 800px;
    flex-wrap: wrap; 
    gap: 15px;


}

.canvas-container {
    position: relative; 
    height: 500px; 
    justify-content: center;
}

#chartInventario {
    padding-top: 100px;
    position: absolute;
    top: 10px;
    left: 0;
    right: 0;
    bottom: 0;
}

.grafica-inventario {
    margin-bottom: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    height: 500px;
    width: 700px;
}


   
    @media (min-width: 150px) {
        .grafica-container {
           gap: 30px;
        }
    }
</style>

<div class="container contenedor-principal">
    <h1 class="titulo-estadisticas">Estadísticas por Inventario</h1>
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
        <!-- Columna para la gráfica de ingreso y egreso -->
        <div class="col-lg-6">
            <div class="grafica">
                <h6 class="chart-title">Cantidad de Ingresos y Egresos de Insumos</h6>
                <canvas id="chartIngresoEgreso"></canvas>
                <h6 id="mensajeGrafica" class="mensaje-grafica text-center" style="display: none;">No se han realizado movimientos</h6>
            </div>
        </div>

        <!-- Columna para la gráfica de inventario -->
        <div class="col-lg-6">
            <div class="grafica">
            <h6 class="chart-title">Cantidad de Productos existentes</h6>
                <canvas id="chartInventario"></canvas>
            </div>
        </div>
    </div>
</div>







    <script src="<?= asset('./build/js/estadisticas/cantidadestadistica.js') ?>"></script>