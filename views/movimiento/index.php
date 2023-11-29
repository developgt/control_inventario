<style>
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }


    .contenedor-modal {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);


    }


    .tabla-contenedor {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        padding: 20px;

    }

    .busqueda-contenedor {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .encabezado-inventario {
        background-color: #007bff;
        color: white;
        margin-bottom: 0;
    }




    .form-select {
        margin-left: 0.5rem;
    }


    #formularioMovimiento {
        padding: 20px;
        margin: auto;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    #formularioExistencia {
        padding: 20px;
        margin: auto;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }

    #formularioDetalle {
        padding: 20px;
        margin: auto;
        background-color: #f2f2f2;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);


    }

    #formularioBusqueda {
        padding: 20px;
        margin: auto;
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

    .encabezado-busqueda {
        background-color: rgba(173, 216, 230, 0.8);
        color: #2c3e50;
        padding: 20px;
        margin-top: 10px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #dee2e6;
        transition: background-color 0.3s;

    }

    .encabezado-busqueda:hover {
        background-color: #dde1e6;
    }

    .encabezado-inventario:hover {
        background-color: #0056b3;

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

    .estado-pendiente {
        color: red;

    }

    .estado-ingresado {
        color: green;

    }

    /* Estilos adicionales */
    #btnRealizarIngreso,
    #btnVerExistenciasPorAlmacenModal {
        width: 100%;
        height: 80px;
        margin-bottom: 10px;
        /* Espacio entre botones */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }


    .derecha-container {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        padding: 0 15px;

    }


    .table-responsive {
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 128, 255, 0.3), 0 6px 20px rgba(0, 0, 0, 0.1);
        margin-top: 10px;
    }
</style>
<div class="container bg-white border rounded mx-auto mt-2 nuevo-contenedor" id="movimiento_busqueda">
    <div class="row">
        <div class="col-md-8 mb-4">
            <h2 class="card-title text-center p-3 encabezado-inventario">Gestione su inventario</h2>
            <form class="border rounded bg-white p-3" id="formularioBusqueda">
                <h5 class="card-title text-center p-3 encabezado-busqueda">Ver Ingresos</h5>
                <div class="mb-3">
                    <label for="mov_alma" class="form-label">Seleccione el inventario</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                        <select name="mov_alma" id="mov_alma" class="form-select">
                            <option value="">SELECCIONE...</option>
                        </select>
                    </div>
                </div>
                <button type="button" id="btnMovimientos" class="btn btn-info w-100">VER INGRESOS</button>
            </form>
        </div>
        <div class="col-md-4 derecha-container">
            <button type="button" id="btnRealizarIngreso" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>REALIZAR INGRESO
            </button>
            <button type="button" id="btnVerExistenciasPorAlmacenModal" class="btn btn-secondary">
                <i class="bi bi-eye me-2"></i>Ver Existencias de Insumos por Inventario
            </button>
        </div>
    </div>
</div>



<!-- <-- modal para mostrar la vista de existencias de productos por inventario-->
<div class="modal fade  modal-with-backdrop" id="ExistenciasInventario" name="ExistenciasInventario" tabindex="-1" role="dialog" aria-labelledby="ExistenciasInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h6 class="modal-title" id="ExistenciasInventarioLabel">Ver existencias</h6>
                <button type="button" id="btnCerrarModalExistenciasPorInventario" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Salir de esta ventana</span>
                </button>
            </div>
            <div class="modal-body" id="ExistenciasInventarioBody">
                <div class="container bg-light border rounded mx-auto mt-2 nuevo-contenedor">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card mt-3 mb-3" id="ExistenciasInventarioBody">
                                <h4 class="text-center mt-4 mb-4 p-3 border rounded encabezado-inventario">Busqueda de Insumos por Inventario</h4>
                                <div class="row justify-content-center mb-5">
                                    <form class="col-lg-11 border rounded bg-light p-3" id="formularioExistenciasInventario">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="mov_almacen">Seleccione el inventario</label>
                                                    <div class="d-flex align-items-center">
                                                        <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                                        <select name="mov_almacen" id="mov_almacen" class="form-select" required>
                                                            <option value="">SELECCIONE...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <button type="button" id="btnBuscarExistenciasPorInventario" class="btn btn-info w-100">Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row justify-content-center mb-4" id="divImprimirExistencias">
                                    <div class="col-lg-12 text-center mb-3 justify-content-center">
                                        <h4 class="card-title text-center p-3 encabezado-busqueda">Impresión de Registro</h4>
                                        <p class="text-center">Si desea imprimir el registro de este inventario, haga clic en el botón "Imprimir".</p>
                                    </div>
                                    <div class="col-lg-12 text-center justify-content-center">
                                        <button type="button" id="btnImprimirExistencias" class="btn btn-primary w-100">
                                            <i class="bi bi-printer"></i> Imprimir el registro de insumos
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <div class="card mt-2 mb-2" id="ExistenciasInventarioBody">
                                <h4 class="text-center mt-4 mb-4 p-3 border rounded encabezado-inventario">Existencias de Productos de acuerdo al almacén seleccionado</h4>
                                <div class="col table-responsive">
                                    <table id="tablaExistenciasPorInventario" class="table table-striped table-bordered table-hover table-light mi-tabla">
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

<div class="container border rounded mt-2 bg-white tabla-contenedor" id="DatosMovimiento">
    <div class="row justify-content-center">
        <div class="col-12">
            <h5 class="text-center mt-4 mb-1 p-3 border rounded encabezado-busqueda">Ingresos realizados</h5>
            <div class="table-responsive">
                <table id="tablaMovimientos" class="table table-striped table-bordered table-hover table-light mb-1 w-100">
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-with-backdrop" id="verExistencias" tabindex="-1" role="dialog" aria-labelledby="verExistenciasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h4 class="modal-title custom-modal-title" id="verExistenciasLabel">Ver Ingresos</h4>
                <button type="button" id="cerrarModalExistencias" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Salir de esta ventana</span>
                </button>
            </div>
            <div class="modal-body" id="verExistenciasBody">
                <div class="container border rounded bg-white mt-5 contenedor-modal">
                    <h3 class="text-center mt-4 mb-4  p-3 border rounded encabezado-inventario">Ingresos Realizados</h3>
                    <div class="row justify-content-center">
                        <div class="col-12 table-responsive">
                            <table id="tablaExistencias" class="table table-striped table-bordered table-hover mi-tabla table-light">
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-6">
                            <button type="button" id="btnVolverImprimir" class="btn btn-primary w-100">
                                <i class="bi bi-printer"></i>Imprimir este Ingreso
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container bg-light border rounded mx-auto mt-2" id="mov_movimiento">
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-2">
            <div class="card mb-4 mt-4">
                <h2 class="card-title text-center mb-4 p-3 rounded encabezado-inventario">Formulario para el ingreso al Almacén</h2>
                <div class="card-body">
                    <form class="col-lg-10 border rounded bg-light p-3" id="formularioMovimiento">
                        <input type="hidden" name="mov_id" id="mov_id">
                        <!-- tipo de movimiento ingreso "I" -->
                        <input type="hidden" value="I" name="mov_tipo_mov" id="mov_tipo_mov">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="mov_tipo_trans"><i class="bi bi-shield-check me-2""></i>Seleccione el tipo de transacción</label>
                                    <div class=" d-flex align-items-center">
                                            <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
                                            <select name="mov_tipo_trans" id="mov_tipo_trans" class="form-select" required>
                                                <option value="">SELECCIONE...</option>
                                                <option value="I">Ingreso Interno</option>
                                                <option value="E">Ingreso Externo</option>
                                            </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="mov_alma_id">Seleccione el almacén al que ingresará</label>
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
                    <div class="col" id="dep_externa">
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
                        <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnRegresarGestion" class="btn btn-danger w-100">Cancelar Ingreso</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div class="container bg-light border rounded mx-auto mt-2" id="mov_detalle">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card mb-4 mt-4"">
            <h2 class=" card-header text-center p-3 rounded encabezado-inventario">Detalle del Ingreso del Almacén</h2>
                <div class="card-body">
                    <form class="col-lg-10 border rounded bg-light p-3" id="formularioDetalle">
                        <input type="hidden" name="det_id" id="det_id">
                        <input type="hidden" name="det_mov_id" id="det_mov_id">
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
                            <div class="col md-4" id="campoLote">
                                <label for="det_lote">Ingrese el lote</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <input type="text" name="det_lote" id="det_lote" class="form-control" placeholder="Lote">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="det_estado">Seleccione el estado</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <select name="det_estado" id="det_estado" class="form-select" required>
                                        <option value="">SELECCIONE...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="tiene_fecja" class="form-label">¿El Insumo tiene Fecha de vencimiento?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" id="tiene_fecha_si" value="si">
                                        <label class="form-check-label" for="tiene_fecha_si">Sí</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tiene_fecha_no" value="no">
                                        <label class="form-check-label" for="tiene_fecha_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col md-4" id="fechaCampo">
                                <label for="det_fecha_vence">Seleccione la fecha de vencimiento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                                    <input type="date" name="det_fecha_vence" id="det_fecha_vence" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
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
                            <div class="col">
                                <label for="det_cantidad_existente">Ingrese la Cantidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="number" name="det_cantidad" id="det_cantidad" class="form-control" placeholder="Cantidad" required>
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
                                    <button type="button" id="btnAnterior" class="btn btn-danger w-100">Cancelar Ingreso</button>
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


<div class="container border rounded bg-white mt-5" id="DatosDetalle">
    <div class="row justify-content-center">
        <div class="col-12">
            <h5 class="text-center mt-4 mb-1 bg-light p-3 border rounded">Insumos ingresados</h5>
            <div class="table-responsive">
                <table id="tablaDetalles" class="table table-striped table-bordered table-hover table-light w-100">
                </table>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-3">
            <button type="button" id="btnImprimir" class="btn btn-primary w-100">
                <i class="bi bi-printer"></i> Finalizar Ingreso
            </button>
        </div>
    </div>
</div>



<script src="<?= asset('./build/js/movimiento/index.js') ?>"></script>