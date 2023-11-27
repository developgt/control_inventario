<style>
    .readonly {
        background-color: rgba(173, 216, 230, 0.5);
    }

    .nuevo-contenedor {
        padding: 20px;
        margin-top: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    #formularioGuarda {
        padding: 20px;
        margin: 10px;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);


    }

    .encabezado-inventario {
        background-color: #007bff;
        color: #ffffff;
        padding: 20px;
        margin-top: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    .encabezado-inventario:hover {
        background-color: #0056b3;

    }
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
    .modal-with-backdrop .modal-content {
        z-index: 1031;
    }

    .custom-modal-header {
        background: linear-gradient(to right, rgba(70, 130, 180, 0.8), rgba(30, 144, 255, 0.8));
        color: #fff;
        border-bottom: 2px solid #fff;

    }


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
<div class="container border rounded bg-white nuevo-contenedor">
    <h1 class="text-center mt-4 mb-4 p-3 border rounded encabezado-inventario">Formulario para Entregar Inventario</h1>
    <div class="row justify-content-center mb-5">
        <form class="col-lg-9 border rounded bg-light p-3" id="formularioGuarda">
            <input type="hidden" name="guarda_id2" id="guarda_id2">
            <div class="row mb-3">
                <div class="col-sm-5">
                    <label for="guarda_catalogo"> <i class="bi bi-file-earmark-text me-2"></i>Catálogo de quien entrega el Inventario</label>
                    <input type="text" name="guarda_catalogo" id="guarda_catalogo" class="form-control readonly" readonly>
                </div>
                <div class="col">
                    <label for="guarda_nombre"> <i class="bi bi-file-earmark-text me-2"></i>Grado y Nombre del Oficial</label>
                    <input type="text" name="guarda_nombre" id="guarda_nombre" class="form-control readonly" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <input type="hidden" name="guarda_id" id="guarda_id">
                <div class="col-sm-5">
                    <label for="guarda_catalogo2"> <i class="bi bi-file-earmark-text me-2"></i>Ingrese el Catálogo de quien recibirá el Inventario</label>
                    <input type="text" name="guarda_catalogo2" id="guarda_catalogo2" class="form-control" placeholder="Ingrese el catálogo">
                </div>
                <div class="col">
                    <label for="guarda_nombre2"> <i class="bi bi-file-earmark-text me-2"></i>Grado y Nombre del Oficial</label>
                    <input type="text" name="guarda_nombre2" id="guarda_nombre2" class="form-control readonly" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="guarda_almacen">SELECCIONE EL INVENTARIO QUE ENTREGARÁ</label>
                    <select name="guarda_almacen" id="guarda_almacen" class="form-control">
                        <option value="">SELECCIONE...</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" form="formularioGuarda" id="btnGuardar" class="btn btn-success w-100">Realizar Entrega</button>
                </div>
                <div class="col">
                    <button type="button" id="btnBuscar" class="btn btn-info w-100">Ver Inventarios Entregados</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <-- modal para mostrar la vista de inventarios entregados -->
<div class="modal fade modal-with-backdrop" id="modalVerRegistros" name="modalVerRegistros" tabindex="-1" role="dialog" aria-labelledby="modalVerRegistrosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title custom-modal-title" id="modalVerRegistrosLabel">Inventarios registrados</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Salir de esta ventana</span>
                </button>
            </div>
            <div class="modal-body" id="modalVerRegistrosBody">
                <div class="container border rounded bg-white mt-1 tabla-container nuevo-contenedor">
                    <h1 class="text-center mt-4 mb-4 encabezado-inventario">Inventarios Registrados</h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="table">
                                <table id="tablaAlmacen" class="table table-striped table-bordered table-light mi-tabla">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/guarda/index.js') ?>"></script>