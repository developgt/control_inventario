<div class="container border rounded bg-white">
    <h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">Formulario para Asignar Guarda Almacen</h1>

    <div class="row justify-content-center mb-5">
        <form class="col-lg-8 border rounded bg-light p-3" id="formularioGuarda">
            <input type="hidden" name="guarda_id" id="guarda_id">
            <div class="row mb-3">
                <div class="col">
                    <label for="guarda_catalogo"> <i class="bi bi-file-earmark-text me-2"></i>Catálogo</label>
                    <input type="text" name="guarda_catalogo" id="guarda_catalogo" class="form-control" placeholder="Ingrese su catálogo">
                </div>
                <div class="col">
                    <label for="guarda_nombre"> <i class="bi bi-file-earmark-text me-2"></i>Grado y Nombre del Oficial</label>
                    <input type="text" name="guarda_nombre" id="guarda_nombre" class="form-control" style="background-color: #f2f2f2;" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                <label for="guarda_almacen">ALMACEN AL QUE SE ASIGNARÁ</label>
                <select name="guarda_almacen" id="guarda_almacen" class="form-control">
                    <option value="">SELECCIONE...</option>
                </select>
            </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <button type="submit" form="formularioGuarda" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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
<h1 class="text-center mt-4 mb-4 bg-light p-3 border rounded">OFiciales asignados...</h1>
    <div class="row justify-content-center">
        <div class="col table-responsive">
            <table id="tablaGuarda" class="table table-striped table-bordered table-hover table-light">
            </table>
        </div>
    </div>
</div>



<h2>Factura de Movimiento</h2>
<table>
    <tr>
      <td>mov_id</td>
      <td>4</td>
      <td>mov_tipo_mov</td>
      <td>I</td>
      <td>mov_tipo_trans</td>
      <td>E</td>
    </tr>
    <tr>
      <td>mov_fecha</td>
      <td>2023-11-11</td>
      <td>mov_alma_id</td>
      <td>19</td>
      <td>mov_proce_destino</td>
      <td>2160</td>
    </tr>
    <tr>
      <td>mov_perso_entrega</td>
      <td>635433</td>
      <td>mov_perso_recibe</td>
      <td>665133</td>
      <td>mov_perso_respon</td>
      <td>665133</td>
    </tr>
    <tr>
      <td>mov_descrip</td>
      <td>EJEMPLO</td>
    </tr>
  </table>
  <h2>Detalles del Movimiento</h2>
  <table>
    <tr>
      <th>det_id</th>
      <th>det_mov_id</th>
      <th>det_pro_id</th>
      <th>det_uni_med</th>
      <th>det_estado</th>
      <th>det_fecha_vence</th>
      <th>det_lote</th>
      <th>det_cantidad</th>
      <th>det_cantidad_lote</th>
    </tr>
    <tr>
      <td>3</td>
      <td>4</td>
      <td>6</td>
      <td>11</td>
      <td>1</td>
      <td>2023-11-11</td>
      <td>001</td>
      <td>10.00</td>
      <td>20.00</td>
    </tr>
    <tr>
      <td>3</td>
      <td>4</td>
      <td>7</td>
      <td>5</td>
      <td>2</td>
      <td>2023-11-11</td>
      <td>701</td>
      <td>110.00</td>
      <td>110.00</td>
    </tr>
  </table>
    <script src="<?= asset('./build/js/guarda/index.js') ?>"></script>