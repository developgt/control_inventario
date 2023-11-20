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
<div class="container bg-light border rounded mx-auto mt-2" id="mov_movimiento">
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-4">
            <div class="card mb-4 mt-4">
                <h2 class="card-title text-center mb-4 bg-primary text-white p-3 rounded">Formulario para el Egreso del Almacén</h2>
                <div class="card-body">
                    <form id="formularioMovimiento">
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
<div class="modal fade" id="verExistencias" name="verExistencias" tabindex="-1" role="dialog" aria-labelledby="verExistenciasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verExistenciasLabel">Ver existencias</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Salir de esta ventana</span>
                </button>
            </div>
            <div class="modal-body" id="verExistenciasBody">
                <div class="container bg-light border rounded mx-auto mt-2">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card mt-3 mb-3" id="verExistenciasBody">
                                <h3 class="text-center mt-4 mb-4 bg-primary text-white p-3 border rounded">Realizar Egresos</h3>
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
                                <h3 class="text-center mt-4 mb-4 bg-primary text-white p-3 border rounded">Existencias de Productos de acuerdo al almacén seleccionado</h3>
                                <div class="col table-responsive">
                                    <table id="tablaExistencias" class="table table-striped table-bordered table-hover table-light">
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

<div class="container bg-light border rounded mx-auto mt-2" id="mov_detalle">
    <div class="row justify-content-center"> <!-- aqui empieza la siguiente div para el formulario de detalle -->
        <div class="col-lg-9">
            <div class="card mb-4 mt-4"">
            <h2 class=" card-header bg-primary text-white text-center p-3 rounded">Detalle del Egreso del Almacén</h2>
                <div class="card-body">
                    <form id="formularioDetalle">
                        <input type="hidden" name="det_id" id="det_id">
                        <input type="text" name="det_mov_id" id="det_mov_id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="det_pro_id">Seleccione el producto</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <select name="det_pro_id" id="det_pro_id" class="form-select" required>
                                        <option value="">SELECCIONE...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                        <input type="text"  class="form-control" placeholder="SIN FECHA" readonly>
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
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container border rounded bg-white mt-5">
    <h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Productos registrados</h1>
    <div class="row justify-content-center">
        <div class="col table-responsive">
            <table id="tablaProducto" class="table table-striped table-bordered table-hover table-light">
            </table>
        </div>
    </div>
</div>

<script src="<?= asset('./build/js/movegreso/index.js') ?>"></script>