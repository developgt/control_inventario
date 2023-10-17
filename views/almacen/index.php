<h1 class="text-center">FORMULARIO PARA INGRESAR ALMACENES</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioAlmacen">
        <input type="hidden" name="alma_id" id="alma_id">
        <div class="row mb-3">
            <div class="col">
                <label for="alma_nombre">Nombre del Almacén</label>
                <input type="text" name="alma_nombre" id="alma_nombre" class="form-control">

            </div>
            <div class="col">
                <label for="alma_descripcion">Descripción</label>
                <input type="text" name="alma_descripcion" id="alma_descripcion" class="form-control">
            </div>
        </div>
 
            <div class="row mb-3">
                <div class="col">
                    <label for="alma_unidad">Dependencia</label>
                    <input type="text" id="alma_unidad" class="form-control" readonly>
                </div>
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

<h1>Datatable de almacenes</h1>
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaAlmacen" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/almacen/index.js') ?>"></script>