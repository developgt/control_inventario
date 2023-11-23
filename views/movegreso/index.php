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
        /* Espacio entre la cabecera y la tabla */
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
        margin-top: 10px;
        background-color: beige;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Sombra */
    }

    #formularioMovimiento {
        padding: 20px;
        margin: auto;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Sombra */

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
        /* Sombra */
    }

    .encabezado-inventario:hover {
        background-color: #0056b3;
        /* Cambio de color al pasar el mouse */
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
<!-- <div class="container bg-light border rounded mx-auto mt-2" id="mov_movimiento">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card mt-3 mb-3" id="verExistenciasBody">
                <h3 class="text-center mt-4 mb-4 bg-primary text-white p-3 border rounded">Realizar Egresos</h3>
                <div class="row justify-content-center mb-5">
                    <form class="col-lg-11 border rounded bg-light p-3" id="formularioExistencia">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label class="sm-4" for="mov_alma">Seleccione el almacén del que realizara el egreso</label>
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
                                    <label class="sm-4" for="det_pro_id">Seleccione el producto</label>
                                    <div class="d-flex align-items-center">
                                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                                        <select name="det_pro_id" id="det_pro_id" class="form-select" required>
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
            </div>
        </div>
        <div class="col-lg-8 mb-4">
            <div class="card mt-3 mb-3" id="verExistenciasBody">
                <h3 class="text-center mt-4 mb-4 bg-primary text-white p-3 border rounded">Existencias de Productos de acuerdo al almacén seleccionado</h3>
                <div class="col table-responsive">
                    <table id="tablaExistencias" class="table table-striped table-bordered table-hover table-light">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container bg-light border rounded mx-auto mt-2 nuevo-contenedor" id="mov_movimiento">
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-4">
            <div class="card mb-4 mt-4">
                <h2 class="card-title text-center mb-4 p-3 encabezado-inventario">Formulario para el Egreso del Almacén</h2>
                <div class="card-body">
                    <form class="col-lg-11 border rounded bg-light p-3" id="formularioMovimiento">
                        <input type="hidden" name="mov_id" id="mov_id">
                        <!-- tipo de movimiento egreso "E" -->
                        <input type="hidden" value="E" name="mov_tipo_mov" id="mov_tipo_mov">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="mov_tipo_trans"><i class="bi bi-shield-check me-2""></i>Seleccione el tipo de transacción</label>
                                    <div class=" d-flex align-items-center">
                                            <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                            <select name="mov_tipo_trans" id="mov_tipo_trans" class="form-select" required>
                                                <option value="">SELECCIONE...</option>
                                                <option value="I">Egreso Interno</option>
                                                <option value="E">Egreso Externo</option>
                                            </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="mov_alma_id">Seleccione el almacén del cual egresará</label>
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
                    <div class="col">
                        <div class="form-group">
                            <label for="mov_proce_destino">Seleccione el Destino</label>
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
                    <div class="col">
                        <button type="button" id="btnVerIngresos" class="btn btn-success w-100">VER INGRESOS</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- <-- modal para mostrar la vista de existencias -->
<div class="modal fade  modal-with-backdrop" id="verExistencias" name="verExistencias" tabindex="-1" role="dialog" aria-labelledby="verExistenciasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h6 class="modal-title" id="verExistenciasLabel">Ver existencias</h6>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Salir de esta ventana</span>
                </button>
            </div>
            <div class="modal-body" id="verExistenciasBody">
                <div class="container bg-light border rounded mx-auto mt-2 nuevo-contenedor">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card mt-3 mb-3" id="verExistenciasBody">
                                <h4 class="text-center mt-4 mb-4 p-3 border rounded encabezado-inventario">Realizar Egresos</h4>
                                <div class="row justify-content-center mb-5">
                                    <form class="col-lg-11 border rounded bg-light p-3" id="formularioExistencia">
                                        <!-- <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="sm-4" for="mov_alma">Seleccione el almacén del que realizara el egreso</label>
                                                    <div class="d-flex align-items-center">
                                                        <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                                        <select name="mov_alma" id="mov_alma" class="form-select" required>
                                                            <option value="">SELECCIONE...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
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
                            </div>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <div class="card mt-2 mb-2" id="verExistenciasBody">
                                <h4 class="text-center mt-4 mb-4 p-3 border rounded encabezado-inventario">Existencias de Productos de acuerdo al almacén seleccionado</h4>
                                <div class="col table-responsive">
                                    <table id="tablaExistencias" class="table table-striped table-bordered table-hover table-light mi-tabla">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container bg-light border rounded mx-auto mt-2 nuevo-contenedor" id="mov_detalle">
    <div class="row justify-content-center"> <!-- aqui empieza la siguiente div para el formulario de detalle -->
        <div class="col-lg-9">
            <div class="card mb-4 mt-4"">
            <h2 class=" card-header text-center p-3 rounded encabezado-inventario">Detalle del Egreso del Almacén</h2>
                <div class="card-body">
                    <form class="col-lg-11 border rounded bg-light p-3" id="formularioDetalle">
                        <input type="hidden" name="det_id" id="det_id">
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
                            <div class="row mb-3">
                                <div class="col md-4">
                                    <label for="det_lote">Ingrese el lote</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                                        <input type="text" name="det_lote" id="det_lote" class="form-control" placeholder="Lote">
                                    </div>
                                </div>
                                <div class="col md-4">
                                    <label for="det_estado">Seleccione el estado</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                                        <select name="det_estado" id="det_estado" class="form-select" required>
                                            <option value="">SELECCIONE...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col md-4" id="fechaCampo">
                                    <label for="det_fecha_vence">Seleccione la fecha de vencimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                                        <input type="date" name="det_fecha_vence" id="det_fecha_vence" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col md-4" id="sinFecha">
                                    <label for="det_fecha_vence">Sin fecha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                                        <input type="text" class="form-control" placeholder="SIN FECHA" id="sin_fecha" readonly>
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
                                    <!-- <div class="col">
                                        <button type="button" id="btnVerIngresos" class="btn btn-success w-100">VER INGRESOS</button>
                                    </div> -->
                                    <div class="col">
                                        <button type="button" id="btnBuscarDetalle" class="btn btn-info w-100">Buscar</button>
                                    </div>
                                    <div class="col">
                                        <button type="button" id="btnCancelarDetalle" class="btn btn-danger w-100">Cancelar</button>
                                    </div>
                                    <div class="col">
                                        <button type="button" id="btnRetirarMas" class="btn btn-success w-100">Retirar más Insumos</button>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container border rounded mt-2 bg-light nuevo-contenedor" id="DatosMovimiento">
    <div class="row justify-content-center"> 
        <div class="col-12">
            <h5 class="text-center mt-4 mb-1 bg-light p-3 border rounded">Egresos realizados</h5>
            <div class="table-responsive">
                <table id="tablaMovimientos" class="table table-striped table-bordered table-hover table-light mb-1 w-100">
                </table>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <h5 class="text-center mt-4 mb-1 bg-light p-3 border rounded">Insumos retirados</h5>
            <div class="table-responsive">
                <table id="tablaDetalles" class="table table-striped table-bordered table-hover table-light w-100">
                </table>
            </div>
        </div>
    </div>
</div>


<script src="<?= asset('./build/js/movegreso/index.js') ?>"></script>