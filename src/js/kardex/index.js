// Función para buscar almacenes
const buscar = async () => {
  const url = `/control_inventario/API/kardex/buscar`;
  const config = {
    method: 'GET',
  };

  try {
    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

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
