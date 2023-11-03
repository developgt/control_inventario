<div class="container border rounded bg-light mt-4">
    <h1 class="text-center mt-4 mb-4 bg-primary text-white p-3 rounded">Formulario para Ingresar los Productos</h1>

    <div class="row justify-content-center mb-5">
        <form class="col-lg-10 p-4" id="formularioProducto">
            <input type="hidden" name="pro_id" id="pro_id">
            <div class="row mb-3">
                <div class="col">
                    <label for="pro_almacen_id" class="form-label">Almacén al que agregará el producto</label>
                    <select name="pro_almacen_id" id="pro_almacen_id" class="form-select">
                        <option value="">SELECCIONE...</option>
                    </select>
                </div>
                <div class="col">
                    <label for="pro_medida" class="form-label">Seleccione la unidad de medida</label>
                    <select name="pro_medida" id="pro_medida" class="form-select">
                        <option value="">SELECCIONE...</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="pro_nom_articulo" class="form-label">Nombre del Producto</label>
                    <input type="text" name="pro_nom_articulo" id="pro_nom_articulo" class="form-control">
                </div>
                <div class="col">
                    <label for="pro_estado" class="form-label">Seleccione el Estado del Producto</label>
                    <select name="pro_estado" id="pro_estado" class="form-select">
                        <option value="">SELECCIONE...</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="tiene_lote" class="form-label">¿El producto tiene No. de lote o serie?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tiene_lote_si">
                        <label class="form-check-label" for="tiene_lote_si">Sí</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tiene_lote_no">
                        <label class="form-check-label" for="tiene_lote_no">No</label>
                    </div>
                </div>
                <div class="col" id="campo_lote">
                    <label for="pro_no_serie" class="form-label">Número de serie o Lote del Producto</label>
                    <input type="text" name="pro_no_serie" id="pro_no_serie" class="form-control">
                </div>
                <div class="col">
                    <label for="tiene_fecha_vencimiento" class="form-label">¿El producto tiene fecha de vencimiento?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tiene_fecha_si">
                        <label class="form-check-label" for="tiene_fecha_si">Sí</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tiene_fecha_no">
                        <label class="form-check-label" for="tiene_fecha_no">No</label>
                    </div>
                </div>
                <div class="col" id="campo_fecha_vencimiento">
                    <label for="pro_vencimiento" class="form-label">Fecha de Vencimiento</label>
                    <input type="date" name="pro_vencimiento" id="pro_vencimiento" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label for="pro_descripcion" class="form-label">Descripción del Producto</label>
                <textarea name="pro_descripcion" id="pro_descripcion" class="form-control"></textarea>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" form="formularioProducto" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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
    <h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Productos registrados</h1>
    <div class="row justify-content-center">
        <div class="col table-responsive">
            <table id="tablaProducto" class="table table-striped table-bordered table-hover table-light">
            </table>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/producto/index.js') ?>"></script>