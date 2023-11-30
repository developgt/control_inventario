const buttonGestion = document.getElementById('buttonGestion');
const nombreAlmacen = document.getElementById('almacenAsignado');

const buscar = async () => {
    const url = `/control_inventario/API/menu/buscar`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        if (data.almacenes && data.almacenes.length > 0) {
            const nombresAlmacen = data.almacenes.map(almacen => almacen.alma_nombre.toUpperCase()).join('<br>');
            nombreAlmacen.innerHTML = `<ol>${nombresAlmacen}</ol>`;
        } else {
            nombreAlmacen.innerHTML = 'No se encontraron registros';
        }
    } catch (error) {
        console.log(error);
    }
};

buscar();

const btnIngresarGuardalmacen = document.getElementById('btnIngresarGuardalmacen');

// Función para mostrar el modal al hacer clic en el botón "Ingresar como Guardalmacén"
btnIngresarGuardalmacen.addEventListener('click', async function() {
    try {
        const respuesta = await fetch('/control_inventario/API/menu/buscar', { method: 'GET' });
        const data = await respuesta.json();
        const almacenes = data.almacenes || [];

        if (almacenes.length > 0) {
            const selectAlmacenes = document.getElementById('selectAlmacenes');
            selectAlmacenes.innerHTML = ''; // Limpiar opciones actuales

            almacenes.forEach(almacen => {
                const option = document.createElement('option');
                option.value = almacen.alma_nombre;
                option.textContent = almacen.alma_nombre.toUpperCase();
                selectAlmacenes.appendChild(option);
            });

            // Mostrar el modal
            $('#modalSeleccionarAlmacen').modal('show');
        } else {
            // Mostrar SweetAlert si no hay registros de almacenes
            Swal.fire({
                icon: 'error',
                title: 'No ha sido registrado en ningún almacén',
                text: 'Por favor, contacte al administrador.',
            });
        }
    } catch (error) {
        console.log(error);
    }
});

// Función para manejar el envío del formulario y redirigir a la página correspondiente
document.getElementById('formSeleccionarAlmacen').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener el valor seleccionado en el select
    const selectedAlmacen = document.getElementById('selectAlmacenes').value;

    // Aquí puedes redirigir a la página correspondiente, por ejemplo:
    window.location.href = `/control_inventario/guardalmacen/`;

    // Cerrar el modal después de redirigir
    $('#modalSeleccionarAlmacen').modal('hide');
});

buttonGestion.addEventListener('click', function () {
    if (usuario && usuario.empleo) {
        if (usuario.empleo.includes('LOGISTICA')) {
            window.location.href = '/control_inventario/gestion';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Usted no posee permisos para la creación de almacenes.',
            });
        }
    } else {
        console.error('El objeto usuario o la propiedad empleo es undefined.');
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // Obtén el elemento div con la clase 'righter'
    var righterDiv = document.getElementById('kardex');
  
    // Agrega un evento de clic al div
    righterDiv.addEventListener('click', function() {
      // Redirige a la URL deseada
      window.location.href = 'control_inventarios/kardex';
    });
  });
  