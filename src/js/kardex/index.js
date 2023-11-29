// Constante para almacenar la información de seleccionarAlmacen
let seleccionarAlmacenData;

// Constante para almacenar la información de buscarProducto
let buscarProductoData;

// Constante para almacenar la información de buscarUnidadesMedida
let buscarUnidadesMedidaData;

// Conjunto para almacenar IDs únicos de unidades de medida
const idUnidadMedidaSet = new Set();

// Función para buscar productos
const buscarProducto = async () => {
  const url = `/control_inventario/API/kardex/buscarProducto?almaSeleccionadoId=${almaSeleccionadoId}`;
  const config = {
    method: 'GET',
  };

  try {
    const respuesta = await fetch(url, config);
    buscarProductoData = await respuesta.json();

    const selectProducto = document.getElementById('kardex_producto');
    const selectMedida = document.getElementById('kardex_medida');

    selectProducto.innerHTML = '<option value="">Seleccione el Producto</option>';
    selectMedida.innerHTML = '<option value="">Seleccione la Unidad de Medida</option>';

    if (buscarProductoData && buscarProductoData.length > 0) {
      // Utilizar un conjunto para almacenar IDs únicos
      const idSet = new Set();

      buscarProductoData.forEach((producto) => {
        const idProducto = producto.pro_id;

        // Verificar si el ID del producto ya existe en el conjunto
        if (!idSet.has(idProducto)) {
          idSet.add(idProducto);

          const optionProducto = document.createElement('option');
          optionProducto.value = idProducto;
          optionProducto.text = producto.pro_nom_articulo.toUpperCase();
          selectProducto.appendChild(optionProducto);
        }
      });

      // Llamar a buscarUnidadesMedida al cambiar de producto
      selectProducto.addEventListener('change', () => {
        const productoSeleccionado = selectProducto.value;

        // Limpiar conjunto al cambiar de producto
        idUnidadMedidaSet.clear();

        if (productoSeleccionado) {
          // Filtrar unidades de medida por producto
          const unidadesMedidaPorProducto = buscarProductoData.filter(
            (producto) => producto.pro_id === productoSeleccionado
          );

          // Llenar el select de unidades de medida
          buscarUnidadesMedida(unidadesMedidaPorProducto);
        } else {
          // Limpiar select de unidades de medida si no hay producto seleccionado
          selectMedida.innerHTML = '<option value="">Seleccione la Unidad de Medida</option>';
        }
      });
    } else {
      selectProducto.innerHTML = '<option value="">No se encontraron registros</option>';
    }
  } catch (error) {
    console.error('Error al cargar los productos:', error);
  }
};

// Función para buscar unidades de medida
const buscarUnidadesMedida = (productos) => {
  const selectMedida = document.getElementById('kardex_medida');

  // Limpiar select al cambiar de producto
  selectMedida.innerHTML = '<option value="">Seleccione la Unidad de Medida</option>';

  if (productos && productos.length > 0) {
    productos.forEach((producto) => {
      const idUnidadMedida = producto.det_uni_med;

      // Verificar si el ID de la unidad de medida ya existe en el conjunto
      if (!idUnidadMedidaSet.has(idUnidadMedida)) {
        idUnidadMedidaSet.add(idUnidadMedida);

        if (producto.uni_nombre) {
          // Crea una opción para cada unidad de medida
          const optionMedida = document.createElement('option');
          optionMedida.value = idUnidadMedida;
          optionMedida.text = producto.uni_nombre.toUpperCase();
          selectMedida.appendChild(optionMedida);
        } else {
          console.error('La respuesta del servidor no contiene la propiedad "uni_nombre" esperada.');
        }
      }
    });
  } else {
    // Manejar el caso en que no se encuentren unidades de medida
    console.error('La respuesta del servidor no contiene la propiedad "unidadesMedida" esperada.');
  }
};

// Función para seleccionar almacenes
const seleccionarAlmacen = async () => {
  const url = `/control_inventario/API/kardex/seleccionar`;
  const config = {
    method: 'GET',
  };

  try {
    const respuesta = await fetch(url, config);
    seleccionarAlmacenData = await respuesta.json();

    const selectAlmacen = document.getElementById('kardex_almacen');

    selectAlmacen.innerHTML = '<option value="">Seleccione el Inventario</option>';

    if (seleccionarAlmacenData.almacenes && seleccionarAlmacenData.almacenes.length > 0) {
      // Utilizar un conjunto para almacenar IDs únicos
      const idSet = new Set();

      seleccionarAlmacenData.almacenes.forEach((almacen) => {
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
    } else {
      selectAlmacen.innerHTML = '<option value="">No se encontraron registros</option>';
    }
  } catch (error) {
    console.error('Error al cargar los almacenes:', error);
  }
};

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', seleccionarAlmacen);

// Obtener referencia al select "kardex_almacen"
const selectAlmacen = document.getElementById('kardex_almacen');

// Añadir un evento de cambio al select "kardex_almacen"
selectAlmacen.addEventListener('change', function () {
  // Obtener el ID del almacén seleccionado
  almaSeleccionadoId = this.value;

  // Imprimir el valor en la consola para verificar
  console.log('Alma ID seleccionado:', almaSeleccionadoId);

  // Llamar a buscarProducto pasando el ID del almacén
  buscarProducto();
});

// Obtener referencia al botón "Buscar"
const btnBuscar = document.getElementById('btnBuscar');

// Obtener referencia al div de resultados
const divMostrarResultados = document.getElementById('mostrarResultados');

// Añadir un evento de clic al botón
btnBuscar.addEventListener('click', () => {
  // Obtener los valores seleccionados de los selectores
  const almacenSeleccionado = document.getElementById('kardex_almacen').value;
  const productoSeleccionado = document.getElementById('kardex_producto').value;
  const medidaSeleccionada = document.getElementById('kardex_medida').value;

  // Verificar si se han seleccionado todos los campos
  if (almacenSeleccionado && productoSeleccionado && medidaSeleccionada) {
    // Filtrar la información según los valores seleccionados
    const informacionFiltrada = buscarProductoData.filter((producto) => (
      producto.alma_id === almacenSeleccionado &&
      producto.pro_id === productoSeleccionado &&
      producto.det_uni_med === medidaSeleccionada
    ));

    // Realizar las acciones necesarias con la información filtrada
    console.log('Información Filtrada:', informacionFiltrada);


    // Llamar a mostrarResultados con los datos filtrados
    mostrarResultados(informacionFiltrada);

  } else {

    console.warn('Por favor, seleccione todos los campos.');
  }
});

// Función para mostrar resultados en la tabla
function mostrarResultados(data) {
  // Limpiar contenido anterior si existe
  divMostrarResultados.innerHTML = '';

  // Verificar si hay datos para mostrar
  if (data && data.length > 0) {

    const tablaContenido = data
      .map(
        (almacen) => `
        <tr>
           
           <td>${almacen.mov_id}</td>
           <td>${almacen.mov_tipo_mov === 'I' ? 'Ingreso' : (almacen.mov_tipo_mov === 'E' ? 'Egreso' : 'Invalido')}</td>
           <td>${almacen.mov_fecha}</td>
           <td>${almacen.mov_descrip}</td>
           <td>${almacen.dep_desc_md}</td>
           <td>${almacen.det_cantidad}</td>
           <td>${almacen.uni_nombre}</td>
           <td>${almacen.pro_nom_articulo}</td>
           <td>${almacen.det_lote}</td>
           <td>${almacen.est_descripcion}</td>
           <td>${almacen.det_cantidad_existente}</td>
         </tr>
      `
      )
      .join('');

    // Crear la tabla en el div "mostrarResultados"
    const tablaHTML = `
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th>No. de Gestion</th>
            <th>Tipo del Movimiento</th>
            <th>Fecha</th>
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
    `;

    // Adjuntar la tabla al div "mostrarResultados"
    divMostrarResultados.innerHTML = tablaHTML;


    const btnImprimir = document.createElement('button');
    btnImprimir.id = 'btnImprimir';
    btnImprimir.className = 'btn btn-primary mt-3 w-100';
    btnImprimir.innerText = 'Imprimir';


    btnImprimir.addEventListener('click', () => {
      console.log('Se hizo clic en el botón Imprimir');

      buscarRecibo();

      

    });


    // Adjuntar el botón al div "mostrarResultados"
    divMostrarResultados.appendChild(btnImprimir);


    console.log('Tabla creada y mostrada correctamente.');
  } else {
    console.warn('No hay datos para mostrar.');
  }

  // Obtener referencia al botón de imprimir
const btnImprimir = document.getElementById('btnImprimir');

}

// Obtener referencia al botón de imprimir
const btnImprimir = document.getElementById('btnImprimir');

const buscarRecibo = async () => {
  let alma_id = document.getElementById('kardex_almacen').value;
  let pro_id = document.getElementById('kardex_producto').value;
  let uni_id = document.getElementById('kardex_medida').value;

  console.log('ID del almacén:', alma_id);
  console.log('ID del producto:', pro_id);
  console.log('ID de la medida:', uni_id);

  const url = `/control_inventario/API/reportekardex/buscarRecibo?alma_id=${alma_id}&pro_id=${pro_id}&uni_id=${uni_id}`;
  const config = {
    method: 'GET',
  };

  try {
    const respuesta = await fetch(url, config);

    if (respuesta.ok) {
      const data = await respuesta.json();

      if (data && data.almacenes && data.almacenes.length > 0) {
        console.log('Número de registros:', data.almacenes.length);
        await generarPDF(data.almacenes);
      } else {
        console.error('No se encontraron registros');
      }      
    } else {
      console.error('Error en la solicitud GET:', respuesta.statusText);
    }
  } catch (error) {
    console.error('Error en la solicitud GET:', error);
  }
};

const generarPDF = async (datos) => {
  const url = `/control_inventario/reportekardex/generarPDF`;

  let timerInterval;
  Swal.fire({
      title: 'Generando PDF...',
      html: 'Por favor espera <b></b> milisegundos.',
      timer: 4000,
      timerProgressBar: true,
      didOpen: () => {
          Swal.showLoading();
          const b = Swal.getHtmlContainer().querySelector('b');
          timerInterval = setInterval(() => {
              b.textContent = Swal.getTimerLeft();
          }, 100);
      },
      willClose: () => {
          clearInterval(timerInterval);
      }
  });


  const formData = new FormData();
  formData.append('almacenes', JSON.stringify(datos));

  const config = {
    method: 'POST',
    body: formData,
  };

  try {
    const respuesta = await fetch(url, config);
    Swal.close();
    if (respuesta.ok) {
      const blob = await respuesta.blob();

      if (blob) {
        const urlBlob = window.URL.createObjectURL(blob);

        window.open(urlBlob, '_blank');
      } else {
        console.error('No se pudo obtener el blob del PDF.');
        Swal.close();
      }
    } else {
      console.error('Error al generar el PDF.');
    }
  } catch (error) {
    console.error(error);
    Swal.close();
  }
};
