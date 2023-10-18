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
        <div class="col table-responsive">
            <table id="tablaAlmacen" class="table table-striped table-bordered table-hover table-light">
            </table>
        </div>
    </div>
</div>
    <script src="<?= asset('./build/js/almacen/index.js') ?>"></script>