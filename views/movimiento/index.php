<style>
    .table-responsive {
        margin: 0 auto;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody+tbody {
        border-top: 2px solid #dee2e6;
    }

    h5 {
        text-align: center;
        background-color: #f8f9fa;
        /* Color de fondo claro */
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-bottom: 20px;
     
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-hover tbody tr:hover {
        color: #212529;
        background-color: rgba(0, 0, 0, 0.075);
    }


    .readonly {
        background-color: rgba(173, 216, 230, 0.5);
    }

    .nuevo-contenedor {
        padding: 20px;
        margin-top: 5px;
        background-color: beige;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        min-height: 100vh;
        justify-content: center;
    }

    
    .tabla-contenedor {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .busqueda-contenedor {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .encabezado-inventario {
        background-color: #007bff;
        color: white;
        margin-bottom: 0;
    }

  
    .card {
        border: none;
        border-radius: 10px;
    }
    .card-body {
        padding: 2rem;
    }
    .form-select {
        margin-left: 0.5rem;
    }
    /* .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    } */
    .btn-ingreso {
        position: absolute;
        right: 25px; /* Ajustar según necesidad */
        top: 120px; /* Ajustar según necesidad */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    #formularioMovimiento {
        padding: 20px;
        margin: auto;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    #formularioExistencia {
        padding: 20px;
        margin: auto;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Sombra */

    }

    #formularioDetalle {
        padding: 20px;
        margin: auto;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Sombra */

    }

    .encabezado-inventario {
        background-color: #007bff;
        color: #ffffff;
        padding: 20px;
        margin-top: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
   
    }

    .encabezado-busqueda {
    background-color: #e9ecef; /* Un gris claro que no compite con el azul del encabezado principal */
    color: #495057; /* Un color oscuro para el texto que garantiza legibilidad */
    padding: 20px;
    margin-top: 10px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Un sombreado más suave */
    border: 1px solid #dee2e6; /* Un borde sutil para definir los límites del encabezado */
    transition: background-color 0.3s; /* Suaviza la transición de color al pasar el mouse */
}

.encabezado-busqueda:hover {
    background-color: #dde1e6; /* Un tono ligeramente más oscuro para el hover, manteniéndolo suave */
    /* No es necesario un cambio drástico de color al pasar el mouse, solo un toque sutil */
}

    .encabezado-inventario:hover {
        background-color: #0056b3;
       
    }

    /* Estilo para el fondo oscuro del modal */
    .modal-with-backdrop:before {
        content: "";
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1030;
        background-color: #000;
        opacity: 0.5;
    }

    /* Estilo para el modal */
    .modal-with-backdrop .modal-content {
        z-index: 1031;
        /* Asegura que el modal esté sobre el fondo oscuro */
    }

    /* Estilo para el encabezado del modal */
    .custom-modal-header {
        background: linear-gradient(to right, rgba(70, 130, 180, 0.8), rgba(30, 144, 255, 0.8));
        color: #fff;
        border-bottom: 2px solid #fff;

    }

    /* Estilo para el título del modal */
    .custom-modal-title {
        margin: 0;

    }

    .mi-tabla {
        width: 110%;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        margin-left: auto;
        margin-right: auto;

    }
</style>
<div class="container bg-light border rounded mx-auto mt-2 busqueda-contenedor" id="movimiento_busqueda">
    <div class="row justify-content-center">
        <div class="col-12 mb-4">
            <div class="card mb-4 mt-4">
                <h2 class="card-title text-center p-3 encabezado-inventario">Gestione su inventario</h2>
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-9">
                            <form class="border rounded bg-light p-3" id="formularioBusqueda">
                                <h5 class="card-title text-center p-3 encabezado-busqueda">Ver Ingresos</h5>
                                <div class="mb-3">
                                    <label for="mov_alma" class="form-label">Seleccione el inventario</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                        <select name="mov_alma" id="mov_alma" class="form-select">
                                            <option value="">SELECCIONE...</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" id="btnMovimientos" class="btn btn-info w-100">VER INGRESOS</button>
                            </form>
                        </div>
                        <div class="col-lg-3 d-flex justify-content-end">
                            <button type="button" id="btnRealizarIngreso" class="btn btn-success btn-ingreso">REALIZAR EGRESO</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container border rounded mt-2 bg-white tabla-contenedor" id="DatosMovimiento">
    <div class="row justify-content-center">
        <div class="col-12">
            <h5 class="text-center mt-4 mb-1 bg-light p-3 border rounded">Ingresos realizados</h5>
            <div class="table-responsive">
                <table id="tablaMovimientos" class="table table-striped table-bordered table-hover table-light mb-1 w-100">
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container bg-light border rounded mx-auto mt-2" id="mov_movimiento">
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-2">
            <div class="card mb-4 mt-4">
                <h2 class="card-title text-center mb-4 p-3 rounded encabezado-inventario">Formulario para el ingreso al Almacén</h2>
                <div class="card-body">
                    <form class="col-lg-10 border rounded bg-light p-3" id="formularioMovimiento">
                        <input type="hidden" name="mov_id" id="mov_id">
                        <!-- tipo de movimiento ingreso "I" -->
                        <input type="hidden" value="I" name="mov_tipo_mov" id="mov_tipo_mov">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="mov_tipo_trans"><i class="bi bi-shield-check me-2""></i>Seleccione el tipo de transacción</label>
                                    <div class=" d-flex align-items-center">
                                            <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                            <select name="mov_tipo_trans" id="mov_tipo_trans" class="form-select" required>
                                                <option value="">SELECCIONE...</option>
                                                <option value="I">Ingreso Interno</option>
                                                <option value="E">Ingreso Externo</option>
                                            </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="mov_alma_id">Seleccione el almacén al que ingresará</label>
                                <div class="d-flex align-items-center">
                                    <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                    <select name="mov_alma_id" id="mov_alma_id" class="form-select" required>
                                        <option value="">SELECCIONE...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="mov_perso_entrega" class="col col-form-label">Ingrese el Catálogo de la persona que entrega</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="number" name="mov_perso_entrega" id="mov_perso_entrega" class="form-control" placeholder="Catálogo de quien entrega" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="mov_perso_entrega_nom" id="mov_perso_entrega_nom" class="form-control" placeholder="Nombre de quien entrega" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="mov_perso_recibe">Ingrese el Catálogo de la persona que recibe</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="mov_perso_recibe" id="mov_perso_recibe" class="form-control" placeholder="Catálogo de quien recibe" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="mov_perso_recibe_nom" id="mov_perso_recibe_nom" class="form-control" placeholder="Nombre de quien recibe" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="mov_perso_recibe">Ingrese el Catálogo de la persona responsable</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="mov_perso_respon" id="mov_perso_respon" class="form-control" placeholder="Catálogo responsable" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="mov_perso_respon_nom" id="mov_perso_respon_nom" class="form-control" placeholder="Nombre del responsable" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="mov_fecha">Seleccione la fecha</label>
                            <div class="d-flex align-items-center">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" name="mov_fecha" id="mov_fecha" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col" id="dep_externa">
                        <div class="form-group">
                            <label for="mov_proce_destino">Seleccione la procedencia</label>
                            <div class="d-flex align-items-center">
                                <span class="input-group-text"><i class="bi bi-shield-check me-2"></i></span>
                                <select name="mov_proce_destino" id="mov_proce_destino" class="form-select" required>
                                    <option value="">SELECCIONE...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="mov_descrip">Escriba una descripción u Observación del Ingreso</label>
                        <div class="d-flex align-items-center">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <textarea name="mov_descrip" id="mov_descrip" class="form-control" placeholder="Descripción" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button form="formularioMovimiento" type="submit" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnSiguiente" class="btn btn-success w-100">Siguiente</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-4">
        <!-- <div class="card" style="background-color: rgba(0, 0, 255, 0.2);">
            <div class="card-body">
                <h5 class="card-title">Detalle de Ingresos</h5>
                <p class="card-text">Haz clic en el botón para ver el detalle de ingresos.</p>
                <button type="button" id="btnVerIngresos" class="btn btn-success w-100">VER INGRESOS</button>
            </div>
        </div> -->


    <!-- </div> -->
</div>
</div>
<div class="container bg-light border rounded mx-auto mt-2" id="mov_detalle">
    <div class="row justify-content-center"> <!-- aqui empieza la siguiente div para el formulario de detalle -->
        <div class="col-lg-9">
            <div class="card mb-4 mt-4"">
            <h2 class=" card-header text-center p-3 rounded encabezado-inventario">Detalle del Ingreso del Almacén</h2>
                <div class="card-body">
                    <form class="col-lg-10 border rounded bg-light p-3" id="formularioDetalle">
                        <input type="text" name="det_id" id="det_id">
                        <input type="text" name="det_mov_id" id="det_mov_id">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="det_pro_id">Seleccione el producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <select name="det_pro_id" id="det_pro_id" class="form-select" required>
                                        <option value="">SELECCIONE...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="det_uni_med" class="form-label">Seleccione la unidad de medida</label>
                                <select name="det_uni_med" id="det_uni_med" class="form-select">
                                    <option value="">SELECCIONE...</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="tiene_lote" class="form-label">¿El INSUMO tiene No. de lote o Serie?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" id="tiene_lote_si" value="si">
                                        <label class="form-check-label" for="tiene_lote_si">Sí</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tiene_lote_no" value="no">
                                        <label class="form-check-label" for="tiene_lote_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col md-4" id="campoLote">
                                <label for="det_lote">Ingrese el lote</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <input type="text" name="det_lote" id="det_lote" class="form-control" placeholder="Lote">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="det_estado">Seleccione el estado</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <select name="det_estado" id="det_estado" class="form-select" required>
                                        <option value="">SELECCIONE...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="tiene_fecja" class="form-label">¿El Insumo tiene Fecha de vencimiento?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" id="tiene_fecha_si" value="si">
                                        <label class="form-check-label" for="tiene_fecha_si">Sí</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tiene_fecha_no" value="no">
                                        <label class="form-check-label" for="tiene_fecha_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col md-4" id="fechaCampo">
                                <label for="det_fecha_vence">Seleccione la fecha de vencimiento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <input type="date" name="det_fecha_vence" id="det_fecha_vence" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="det_cantidad_existente">Ingrese la Cantidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="number" name="det_cantidad" id="det_cantidad" class="form-control" placeholder="Cantidad" required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="det_cantidad_existente">Cantidad Existente</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="number" name="det_cantidad_existente" id="det_cantidad_existente" class="form-control" placeholder="Cantidad" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label for="det_cantidad">Cantidad Lote</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="number" name="det_cantidad_lote" id="det_cantidad_lote" class="form-control" placeholder="Cantidad" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="det_observaciones">Escriba observaciones</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                    <input type="text" name="det_observaciones" id="det_observaciones" class="form-control" placeholder="Observaciones" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" form="formularioDetalle" id="btnGuardarDetalle" class="btn btn-primary w-100">Guardar</button>
                                </div>
                                <div class="col">
                                    <button type="button" id="btnModificarDetalle" class="btn btn-warning w-100">Modificar</button>
                                </div>
                                <div class="col">
                                    <button type="button" id="btnAnterior" class="btn btn-warning w-100">Anterior</button>
                                </div>
                                <div class="col">
                                    <button type="button" id="btnVerIngresos" class="btn btn-success w-100">VER INGRESOS</button>
                                </div>
                                <div class="col">
                                    <button type="button" id="btnCancelarDetalle" class="btn btn-danger w-100">Cancelar</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container border rounded bg-white mt-5" id="DatosDetalle">
    <div class="row justify-content-center">
        <div class="col-12">
            <h5 class="text-center mt-4 mb-1 bg-light p-3 border rounded">Insumos ingresados</h5>
            <div class="table-responsive">
                <table id="tablaDetalles" class="table table-striped table-bordered table-hover table-light w-100">
                </table>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-3">
            <button type="button" id="btnImprimir" class="btn btn-primary w-100">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
</div>



<!-- <-- modal para mostrar la vista para asignar guarda almacén -->
<div class="modal fade modal-with-backdrop" id="verExistencias" name="verExistencias" tabindex="-1" role="dialog" aria-labelledby="verExistenciasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h4 class="modal-title custom-modal-title" id="verExistenciasLabel">Ver Ingresos</h4>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Salir de esta ventana</span>
                </button>
            </div>
            <div class="modal-body" id="verExistenciasBody">
                <h3 class="text-center border rounded encabezado-inventario">Buscar Ingresos</h3>
                <div class="row justify-content-center mb-5">
                    <form class="col-lg-8 border rounded bg-light p-3" id="formularioExistencia">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="mov_alma">Seleccione el almacén del que buscará</label>
                                    <div class="d-flex align-items-center">
                                        <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                        <select name="mov_alma" id="mov_alma" class="form-select" required>
                                            <option value="">SELECCIONE...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label class="sm-4" for="det_pro">Seleccione el producto</label>
                                    <div class="d-flex align-items-center">
                                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                                        <select name="det_pro" id="det_pro" class="form-select" required>
                                            <option value="">SELECCIONE...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" id="btnBuscarExistencias" class="btn btn-info w-100">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="container border rounded bg-white mt-5"> -->
                <div class="container d-flex flex-column align-items-center justify-content-center border rounded bg-white mt-5">
                    <h3 class="text-center mt-4 mb-4  p-3 border rounded encabezado-inventario">Ingresos Realizados</h3>
                    <div class="row justify-content-center">
                        <div class="table-responsive">
                            <table id="tablaExistencias" class="table table-striped table-bordered table-hover table-light w-auto">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/movimiento/index.js') ?>"></script>