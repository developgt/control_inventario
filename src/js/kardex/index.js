let data; // Declarar data como variable global

// Función para buscar almacenes
const buscar = async () => {
  const url = `/control_inventario/API/kardex/buscar`;
  const config = {
    method: 'GET',
  };

  // Utilizar conjuntos separados para productos y unidades de medida
  const idProductoSet = new Set();
  const idMedidaSet = new Set();

  try {
    const respuesta = await fetch(url, config);
    data = await respuesta.json(); // Asignar el resultado a la variable global data

    const selectAlmacen = document.getElementById('kardex_almacen');
    const selectProducto = document.getElementById('kardex_producto');
    const selectMedida = document.getElementById('kardex_medida');

    // Limpiar selectores anteriores
    selectAlmacen.innerHTML = '<option value="">Seleccione el Inventario</option>';
    selectProducto.innerHTML = '<option value="">Seleccione el Producto</option>';
    selectMedida.innerHTML = '<option value="">Seleccione la Unidad de Medida</option>';

    if (data.almacenes && data.almacenes.length > 0) {
      // Utilizar un conjunto para almacenar IDs únicos
      const idSet = new Set();

      data.almacenes.forEach((almacen) => {
        const idAlmacen = almacen.alma_id;

        // Verificar si el ID del almacén ya existe en el conjunto
        if (!idSet.has(idAlmacen)) {
          idSet.add(idAlmacen);

          const option = document.createElement('option');
          option.value = idAlmacen;
          option.text = almacen.nombre_almacen.toUpperCase();
          selectAlmacen.appendChild(option);
        }
      });

      // Llamar a la función que carga productos cuando se selecciona un almacén
      selectAlmacen.addEventListener('change', () => {
        const almacenSeleccionado = selectAlmacen.value;

        // Limpiar conjuntos al cambiar de almacén
        idProductoSet.clear();
        idMedidaSet.clear();

        if (almacenSeleccionado) {
          // Filtrar productos por almacén
          const productosPorAlmacen = data.almacenes.filter(
            (almacen) => almacen.alma_id === almacenSeleccionado
          );

          // Llenar el select de productos
          cargarProductos(productosPorAlmacen);
        }
      });
    } else {
      // Si no hay registros, mostrar un mensaje
      selectAlmacen.innerHTML = '<option value="">No se encontraron registros</option>';
    }
  } catch (error) {
    console.error('Error al cargar los almacenes:', error);
  }
};

// Función para cargar productos desde la API
function cargarProductos(productos) {
  const selectProducto = document.getElementById('kardex_producto');
  const selectMedida = document.getElementById('kardex_medida');

  // Limpiar selectores anteriores
  selectProducto.innerHTML = '<option value="">Seleccione el Producto</option>';
  selectMedida.innerHTML = '<option value="">Seleccione la Unidad de Medida</option>';

  // Utilizar conjuntos separados para productos y unidades de medida
  const idProductoSet = new Set();
  const idMedidaSet = new Set();

  if (productos && productos.length > 0) {
    productos.forEach((almacen) => {
      const idProducto = almacen.id_producto;
      const idMedida = almacen.det_uni_med;

      // Verificar si el ID del producto ya existe en el conjunto
      if (!idProductoSet.has(idProducto)) {
        idProductoSet.add(idProducto);

        if (almacen.nombre_producto) {
          // Crea una opción para cada producto
          const optionProducto = document.createElement('option');
          optionProducto.value = idProducto;
          optionProducto.text = almacen.nombre_producto;
          selectProducto.appendChild(optionProducto);
        } else {
          console.error('La respuesta del servidor no contiene la propiedad "nombre_producto" esperada.');
        }
      }

      // Verificar si el ID de la unidad de medida ya existe en el conjunto
      if (!idMedidaSet.has(idMedida)) {
        idMedidaSet.add(idMedida);

        // Crea una opción para cada unidad de medida
        const optionMedida = document.createElement('option');
        optionMedida.value = idMedida;
        optionMedida.text = almacen.nombre_unidad_medida || 'Sin Unidad';
        selectMedida.appendChild(optionMedida);
      }
    });
  } else {
    // Manejar el caso en que no se encuentren productos
    console.error('La respuesta del servidor no contiene la propiedad "almacenes" esperada.');
  }
}

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', buscar);

// Obtener referencia al botón "Buscar"
const btnBuscar = document.getElementById('btnBuscar');

// Añadir un evento de clic al botón
btnBuscar.addEventListener('click', () => {
  // Obtener los valores seleccionados de los selectores
  const almacenSeleccionado = document.getElementById('kardex_almacen').value;
  const productoSeleccionado = document.getElementById('kardex_producto').value;
  const medidaSeleccionada = document.getElementById('kardex_medida').value;

  // Verificar si se han seleccionado todos los campos
  if (almacenSeleccionado && productoSeleccionado && medidaSeleccionada) {
    // Filtrar la información según los valores seleccionados
    const informacionFiltrada = data.almacenes.filter((almacen) => (
      almacen.alma_id === almacenSeleccionado &&
      almacen.id_producto === productoSeleccionado &&
      almacen.det_uni_med === medidaSeleccionada
    ));

    // Crear y mostrar el modal con la tabla
    mostrarModal(informacionFiltrada);
  } else {
    // Mostrar un mensaje indicando que se deben seleccionar todos los campos
    alert('Por favor, seleccione todos los campos antes de buscar.');
  }
});

// Función para mostrar el modal con la tabla
function mostrarModal(data) {
  // Limpiar el contenido del modal anterior si existe
  const modalExistente = document.getElementById('resultadoModal');
  if (modalExistente) {
    modalExistente.remove();
  }

// Crear el contenido de la tabla
const tablaContenido = data.map((almacen) => (
  `<tr>
     <td>${almacen.mov_fecha}</td>
     <td>${almacen.mov_tipo_mov === 'I' ? 'Ingreso' : (almacen.mov_tipo_mov === 'E' ? 'Egreso' : 'Invalido')}</td>
     <td>${almacen.mov_id}</td>
     <td>${almacen.mov_descrip}</td>
     <td>${almacen.descripcion_proce_destino}</td>
     <td>${almacen.det_cantidad}</td>
     <td>${almacen.nombre_unidad_medida}</td>
     <td>${almacen.nombre_producto}</td>
     <td>${almacen.det_lote}</td>
     <td>${almacen.descripcion_estado}</td>
     <td>${almacen.det_cantidad_existente}</td>
   </tr>`
)).join('');

// Crear el modal con la tabla
const modalHTML = `
  <div class="modal" id="resultadoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" style="width: 80%;" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <div class="row">
            <div class="col-12 modal-info">
              <h5 class="modal-title" style="font-size: 1.5rem;">Nombre del Almacen: ${data.length > 0 ? data[0].alma_nombre : ''} - ${data.length > 0 ? data[0].descripcion_clase: ''}</h5>
            </div>
        </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Tipo del Movimiento</th>
                <th>No. de Gestion</th>
                <th>Descripcion del Movimiento</th>
                <th>Procedencia/Destino</th>
                <th>Cantidad</th>
                <th>Unidad de Medida</th>
                <th>Articulo</th>
                <th>No. Serie/Lote</th>
                <th>Estado</th>
                <th>Nueva Cantidad Existente</th>
              </tr>
            </thead>
            <tbody>
              ${tablaContenido}
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-block  bi bi-x-lg" data-dismiss="modal" style="width: 49%;">   Cerrar</button>
        <button type="button" id="btnImprimir" class="btn btn-primary btn-block bi bi-printer-fill" style="width: 49%;">Imprimir</button>
        </div>
      </div>
    </div>
  </div>
`;

  // Adjuntar el modal al cuerpo del documento
  document.body.insertAdjacentHTML('beforeend', modalHTML);

  // Obtener referencia al modal
  const resultadoModal = document.getElementById('resultadoModal');

  // Inicializar el modal con Bootstrap
  const modal = new bootstrap.Modal(resultadoModal);

  // Mostrar el modal
  modal.show();

  // Obtener referencia al botón de imprimir
  const btnImprimir = document.getElementById('btnImprimir');

  // Añadir un evento de clic al botón de imprimir
  btnImprimir.addEventListener('click', buscarRecibo);
}

// Obtener referencia al botón de imprimir
const btnImprimir = document.getElementById('btnImprimir');

/////////////////////////////////////////////////////////

const buscarRecibo = async () => {
  let alma_id = document.getElementById('kardex_almacen').value;
  let pro_id = document.getElementById('kardex_producto').value;
  let uni_id = document.getElementById('kardex_medida').value;

  // Imprimir los valores en la consola
  console.log('ID del almacén:', alma_id);
  console.log('ID del producto:', pro_id);
  console.log('ID de la medida:', uni_id);

  const url = `/control_inventario/API/reportekardex/buscarRecibo?alma_id=${alma_id}&pro_id=${pro_id}&uni_id=${uni_id}`;
  const config = {
    method: 'GET',
  };

  try {
    const respuesta = await fetch(url, config);
    const data = await respuesta.json();
    console.log(data);

    if (data && data.length > 0) {
      generarPDF(data);

    } else {
      // Toast.fire({
      //   title: 'No se encontraron registros',
      //   icon: 'info',
      // });
    }
  } catch (error) {
    console.log(error);
  }
};

////////////////generar pdf /////////////

const generarPDF = async (datos) => {
  const url = `/control_inventario/reportekardex/generarPDF`;

  const config = {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(datos),
  };

  try {
      const respuesta = await fetch(url, config);

      if (respuesta.ok) {
          const blob = await respuesta.blob();

          if (blob) {
              const urlBlob = window.URL.createObjectURL(blob);

              // Abre el PDF en una nueva ventana o pestaña
              window.open(urlBlob, '_blank');
          } else {
              console.error('No se pudo obtener el blob del PDF.');
          }
      } else {
          console.error('Error al generar el PDF.');
      }
  } catch (error) {
      console.error(error);
  }
};
