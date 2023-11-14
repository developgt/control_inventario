<div class="container border rounded bg-white">
    <h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Formulario para Ingresar Almacenes</h1>

    <div class="row justify-content-center mb-5">
        <form class="col-lg-8 border rounded bg-light p-3" id="formularioAlmacen">
            <input type="hidden" name="alma_id" id="alma_id">
            <div class="row mb-3">
                <div class="col">
                    <label for="alma_nombre"><i class="bi bi-archive me-2"></i>Nombre del Almacén</label>
                    <input type="text" name="alma_nombre" id="alma_nombre" class="form-control">
                </div>
                <div class="col">
                    <label for="alma_descripcion"> <i class="bi bi-file-earmark-text me-2"></i> Descripción</label>
                    <input type="text" name="alma_descripcion" id="alma_descripcion" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="alma_unidad"><i class="bi bi-shield-check me-2""></i>Dependencia</label>
                    <input type="hidden" id="alma_unidad" name="alma_unidad" class="form-control" readonly>
                            <input type="text" id="alma_unidad_id" class="form-control" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" form="formularioAlmacen" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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
<div class="container border rounded bg-white mt-5">
    <h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Almacenes registrados</h1>
    <div class="row justify-content-center">
        <div class="table-responsive">
            <table id="tablaAlmacen" class="table table-striped table-bordered table-hover table-light">
            </table>
        </div>
    </div>
</div>


<!-- <-- modal para mostrar la vista para asignar guarda almacén -->
<div class="modal fade" id="asignarOficialModal" name="asignarOficialModal" tabindex="-1" role="dialog" aria-labelledby="asignarOficialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignarOficialModalLabel">Asignar Oficial</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Salir de esta ventana</span>
                </button>
            </div>
            <div class="modal-body" id="asignarOficialModalBody">
                <h3 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Formulario para Asignar Guarda Almacen</h3>
                <div class="row justify-content-center mb-5">
                    <form class="col-lg-8 border rounded bg-light p-3" id="formularioGuarda">
                        <input type="hidden" name="guarda_id" id="guarda_id">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="guarda_catalogo"> <i class="bi bi-file-earmark-text me-2"></i>Catálogo</label>
                                <input type="text" name="guarda_catalogo" id="guarda_catalogo" class="form-control" placeholder="Ingrese su catálogo">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="guarda_almacen">ALMACEN AL QUE SE ASIGNARÁ</label>
                                <input type="hidden" name="guarda_almacen" id="guarda_almacen">
                                <input type="text" name="guarda_almacen_nombre" id="guarda_almacen_nombre" class="form-control" style="background-color: #f2f2f2;" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="guarda_nombre"> <i class="bi bi-file-earmark-text me-2"></i>Grado y Nombre del Oficial</label>
                                <input type="text" name="guarda_nombre" id="guarda_nombre" class="form-control" style="background-color: #f2f2f2;" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <button type="submit" form="formularioGuarda" id="btnGuardarAsignar" class="btn btn-primary w-100">Guardar</button>
                            </div>
                            <div class="col">
                                <button type="button" id="btnModificarAsignar" class="btn btn-warning w-100">Modificar</button>
                            </div>
                            <div class="col">
                                <button type="button" id="btnBuscarAsignar" class="btn btn-info w-100">Buscar</button>
                            </div>
                            <div class="col">
                                <button type="button" id="btnCancelarAsignar" class="btn btn-danger w-100">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="container border rounded bg-white mt-5"> -->
                <div class="container d-flex flex-column align-items-center justify-content-center border rounded bg-white mt-5">
                    <h3 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Oficiales asignados...</h3>
                    <div class="row justify-content-center">
                        <div class="table-responsive">
                            <table id="tablaGuarda" class="table table-striped table-bordered table-hover table-light w-auto">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/almacen/index.js') ?>"></script>