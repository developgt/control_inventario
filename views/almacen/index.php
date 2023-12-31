<style>
    .readonly {
        background-color: rgba(173, 216, 230, 0.5);
    }

    .nuevo-contenedor {
        padding: 20px;
        margin-top: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    
    }

    #formularioAlmacen {
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
        width: auto;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        margin-left: auto;
        margin-right: auto;

    }

    .table-responsive {
    padding: 20px;  
    box-shadow: 0 4px 8px rgba(0, 128, 255, 0.3), 0 6px 20px rgba(0, 0, 0, 0.1); 
    margin-top: 10px;
}

    

</style>
<div class="container border rounded bg-white nuevo-contenedor">
    <div class="row justify-content-center mt-1 mb-1">
        <div class="col-lg-8">
            <h1 class="text-center mt-2 mb-2 encabezado-inventario">Creación de Inventario</h1>
        </div>
        <div class="row justify-content-center mb-2">
            <form class="col-lg-9 border rounded bg-light p-3 mt-1" id="formularioAlmacen">
                <input type="hidden" name="alma_id" id="alma_id">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="alma_nombre"><i class="bi bi-archive-fill me-2"></i>Nombre del Inventario</label>
                        <input type="text" name="alma_nombre" id="alma_nombre" class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label for="alma_clase"><i class="bi bi-shield-shaded me-2"></i>Clases</label>
                        <input type="hidden" name="alma_clase" id="alma_clase" class="form-control" readonly>
                        <input type="text" name="alma_clase_descripcion" id="alma_clase_descripcion" readonly class="form-control readonly">
                    </div>
                </div>
                <input type="hidden" name="guarda_id" id="guarda_id">
                <div class="row mb-3">
                    <div class="col">
                        <label for="alma_descripcion"><i class="bi bi-file-earmark-text-fill me-2"></i>Descripción</label>
                        <input type="text" name="alma_descripcion" id="alma_descripcion" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="guarda_catalogo"><i class="bi bi-bookmark-check-fill me-2"></i>Catálogo</label>
                        <input type="text" name="guarda_catalogo" id="guarda_catalogo" class="form-control readonly" readonly>
                    </div>
                    <div class="col-lg-6">
                        <label for="guarda_nombre"><i class="bi bi-person-fill me-2"></i>Grado y Nombre del Oficial</label>
                        <input type="text" name="guarda_nombre" id="guarda_nombre" class="form-control readonly" readonly>
                    </div>
                    <input type="hidden" name="guarda_almacen" id="guarda_almacen">
                    <div class="col-lg-4">
                        <label for="alma_unidad"><i class="bi bi-shield-shaded me-2"></i>Dependencia</label>
                        <input type="hidden" id="alma_unidad" name="alma_unidad" class="form-control">
                        <input type="text" id="alma_unidad_id" class="form-control readonly" readonly>
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
                        <button type="button" id="btnBuscar" class="btn btn-info w-100">Ver inventarios registrados</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- <-- modal para mostrar los inventarios asignados-->
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
                                <div class="col table-responsive">
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
    <script src="<?= asset('./build/js/almacen/index.js') ?>"></script>