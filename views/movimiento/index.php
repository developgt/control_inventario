
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4 bg-primary text-white p-3 rounded">Formulario para el ingreso y egreso del Almacén</h2>
                    <form id="formularioMovimiento">
                        <input type="hidden" name="mov_id" id="mov_id">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                <select name="mov_tipo_mov" id="mov_tipo_mov" class="form-select" required>
                                    <option value="">SELECCIONE...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                    <select name="mov_tipo_trans" id="mov_tipo_trans" class="form-select" required>
                                        <option value="">SELECCIONE...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                    <select name="mov_alma_id" id="mov_alma_id" class="form-select" required>
                                        <option value="">SELECCIONE...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="mov_perso_entrega" id="mov_perso_entrega" class="form-control" placeholder="Nombre de quien entrega" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="mov_perso_recibe" id="mov_perso_recibe" class="form-control" placeholder="Nombre de quien recibe" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="mov_perso_respon" id="mov_perso_respon" class="form-control" placeholder="Persona responsable" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" name="mov_fecha" id="mov_fecha" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box"></i></span>
                                <textarea name="mov_proce_destino" id="mov_proce_destino" class="form-control" placeholder="Procedencia o Destino" required></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <textarea name="mov_descrip" id="mov_descrip" class="form-control" placeholder="Descripción" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" form="formularioMovimiento" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
                            </div>
                            <div class="col">
                                <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
                            </div>
                            <div class="col">
                                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
                            </div>
                            <div class="col">
                                <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <h2 class="card-header bg-primary text-white text-center p-3 rounded">Detalle del Ingreso o Egreso del Almacén</h2>
                <div class="card-body">
                    <form id="formularioDetalle">
                        <input type="hidden" name="det_id" id="det_id">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                <select name="det_mov_id" id="det_mov_id" class="form-select" required>
                                    <option value="">SELECCIONE...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box"></i></span>
                                <select name="det_pro_id" id="det_pro_id" class="form-select" required>
                                    <option value="">SELECCIONE...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="number" name="det_cantidad" id="det_cantidad" class="form-control" placeholder="Cantidad" required>
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
<script src="<?= asset('./build/js/producto/index.js') ?>"></script>