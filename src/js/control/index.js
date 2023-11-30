// Declarar data como variable global
let data;

// Función para buscar almacenes
const buscar = async () => {
  const url = `/control_inventario/API/control/seleccionar`;
  const config = {
    method: 'GET',
  };

  try {
    const respuesta = await fetch(url, config);
    data = await respuesta.json(); // Asignar el resultado a la variable global data

    const selectAlmacen = document.getElementById('control_almacen');

    // Limpiar selectores anteriores
    selectAlmacen.innerHTML = '<option value="">Seleccione el Inventario</option>';

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
        buscarAlmacen(almacenSeleccionado);
      });
    } else {
      // Si no hay registros, mostrar un mensaje
      selectAlmacen.innerHTML = '<option value="">No se encontraron registros</option>';
    }
  } catch (error) {
    console.error('Error al cargar los almacenes:', error);
  }
};

// Llamar a la función al cargar la página
document.addEventListener('DOMContentLoaded', buscar);

// Obtener referencia al botón "Buscar"
const btnBuscar = document.getElementById('btnBuscar');

// Añadir un evento de clic al botón
btnBuscar.addEventListener('click', () => {
  // Obtener los valores seleccionados de los selectores
  const almacenSeleccionado = document.getElementById('control_almacen').value;

  // Verificar si se han seleccionado todos los campos
  if (almacenSeleccionado) {
    // Filtrar la información según los valores seleccionados
    const informacionFiltrada = data.almacenes.filter((almacen) => almacen.alma_id === almacenSeleccionado);

    // Crear y mostrar los resultados en la tabla
    mostrarResultados(informacionFiltrada);
  } else {
    // Mostrar un mensaje indicando que se deben seleccionar todos los campos
    alert('Por favor, seleccione todos los campos antes de buscar.');
  }
});

// Función para buscar productos asociados al almacén
const buscarAlmacen = async (almacenId) => {
  const url = `/control_inventario/API/control/buscarProducto?almaSeleccionadoId=${almacenId}`;
  const config = {
    method: 'GET',
  };

  try {
    const respuesta = await fetch(url, config);

    if (respuesta.ok) {
      const productos = await respuesta.json();

      // Llamar a la función para mostrar los resultados
      mostrarResultados(productos);
    } else {
      console.error('Error en la solicitud GET:', respuesta.statusText);
    }
  } catch (error) {
    console.error('Error en la solicitud GET:', error);
  }
};

// Función para mostrar resultados en la tabla
function mostrarResultados(data) {
  // Limpiar contenido anterior si existe
  const divMostrarResultados = document.getElementById('mostrarResultados');
  divMostrarResultados.innerHTML = '';

  // Verificar si hay datos para mostrar
  if (data && data.length > 0) {
    // Crear la tabla con los datos
    const tablaContenido = data
      .map(
        (producto) => `
        <tr>
          <td>${producto.pro_nom_articulo}</td>
          <td>${producto.est_descripcion}</td>
          <td>${producto.det_fecha_vence === '1999-05-07' ? 'SIN FECHA DE VENCIMIENTO' : producto.det_fecha_vence}</td>
          <td>${producto.uni_nombre}</td>
          <td>${producto.det_lote}</td>
          <td>${producto.det_cantidad_lote}</td>
          <td>${producto.det_cantidad_existente}</td>
        </tr>
      `
      )
      .join('');

    // Crear la tabla en el div "mostrarResultados"
    const tablaHTML = `
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th>Nombre Producto</th>
            <th>Descripción Estado</th>
            <th>Fecha Vencimiento</th>
            <th>Unidad</th>
            <th>Lote</th>
            <th>Cantidad Existente por lote</th>
            <th>Cantidad Existente</th>
          </tr>
        </thead>
        <tbody>
          ${tablaContenido}
        </tbody>
      </table>
    `;

    // Adjuntar la tabla al div "mostrarResultados"
    divMostrarResultados.innerHTML = tablaHTML;

    // Crear el botón de imprimir
    const btnImprimir = document.createElement('button');
    btnImprimir.id = 'btnImprimir';
    btnImprimir.className = 'btn btn-primary mt-3 w-100';
    btnImprimir.innerText = 'Imprimir';

    // Añadir un evento de clic al botón de imprimir
    btnImprimir.addEventListener('click', () => {
      console.log('Se hizo clic en el botón Imprimir');
      // Llamar a la función para buscar el recibo
      buscarRecibo();

    });

    // Adjuntar el botón al div "mostrarResultados"
    divMostrarResultados.appendChild(btnImprimir);

    console.log('Tabla creada y mostrada correctamente.');
  } else {
    Swal.fire({
      icon: "error",
      title: "Error en la Solicitud",
      text: "No existen datos registrados",
      footer: '<a href="/control_inventario">Realice Registros para Operar</a>'
    });
  }
};

// Obtener referencia al botón de imprimir
const btnImprimir = document.getElementById('btnImprimir');


const buscarRecibo = async () => {
  let alma_id = document.getElementById('control_almacen').value;

  console.log('ID del almacén:', alma_id);

  const url = `/control_inventario/API/reportecontrol/buscarRecibo?alma_id=${alma_id}`;
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
        Swal.fire({
          icon: "error",
          title: "Error en la Solicitud",
          text: "No existen datos registrados",
          footer: '<a href="/control_inventario">Realice Registros para Operar</a>'
        });
      }      
    } else {
      console.error('Error en la solicitud GET:', respuesta.statusText);
    }
  } catch (error) {
    console.error('Error en la solicitud GET:', error);
  }
};


const generarPDF = async (datos) => {
  const url = `/control_inventario/reportecontrol/generarPDF`;

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
