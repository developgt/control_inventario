<div class="container border rounded bg-white">
    <h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Formulario para Ingresar el estado de los productos</h1>

    <div class="row justify-content-center mb-5">
        <form class="col-lg-8 border rounded bg-light p-3" id="formularioEstado">
            <input type="hidden" name="est_id" id="est_id">
            <div class="row mb-3">
                <div class="col">
                    <label for="est_descripcion"> <i class="bi bi-file-earmark-text me-2"></i> Descripción</label>
                    <input type="text" name="est_descripcion" id="est_descripcion" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" form="formularioEstado" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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
<h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Estados registrados...</h1>
    <div class="row justify-content-center">
        <div class="col table-responsive">
            <table id="tablaEstado" class="table table-striped table-bordered table-hover table-light">
            </table>
        </div>
    </div>
</div>
    <script src="<?= asset('./build/js/estado/index.js') ?>"></script>