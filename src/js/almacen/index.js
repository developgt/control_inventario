import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";

//const para la vista 
const formulario = document.getElementById('formularioAlmacen');
const alma_clase = document.getElementById('alma_clase')
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const alma_id = document.getElementById('alma_id');
const modalVerRegistros = document.getElementById('modalVerRegistros');

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'



//////////////////////////CONST PARA EL MODAL/////////////////////////////////////////////////////////

const guarda_id = document.getElementById('guarda_id');
const guarda_catalogo = document.getElementById('guarda_catalogo');
const guarda_nombre = document.getElementById('guarda_nombre')
let typingTimeout;
const botonCerrarModal = document.querySelector('.modal-header .close');
const guarda_almacen = document.getElementById('guarda_almacen');
const guardaAlmacenInput = document.getElementById('guarda_almacen');
const guardaAlmacenNombreInput = document.getElementById('guarda_almacen_nombre');



/////////////////////////////////////////////////////////////////////////////////////////////////////

///para que se autocomplete el campo de dependencia en automatico. 

const almaUnidad = document.getElementById('alma_unidad');
const almaUnidadId = document.getElementById('alma_unidad_id');


//////////DATATABLE//////////////////////////

let contador = 1;
btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

const datatable = new Datatable('#tablaAlmacen', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'Nombre del Inventario',
            data: 'alma_nombre'
        },
        {
            title: 'Descripción',
            data: 'alma_descripcion'
        },
        {
            title: 'Clase de Inventario',
            data: 'clase_nombre'
        },

        {
            title: 'MODIFICAR',
            data: 'alma_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${row["alma_id"]}' data-nombre='${row["alma_nombre"]}' data-clase='${row["alma_clase"]}' data-descripcion='${row["alma_descripcion"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'alma_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        },
    ],
    columnDefs: [
        {  
        targets: [4, 5], 
        className: 'col-1'
      },
    ],
});


//// PARA TRAER LOS DATOS 
const traeDatos = (e) => {
    const button = e.target;
    const alma_id = button.dataset.id;
    const alma_clase = button.dataset.clase;
    const alma_nombre = button.dataset.nombre;
    const alma_descripcion = button.dataset.descripcion;

    const dataset = {
        alma_id: alma_id,
        alma_nombre: alma_nombre,
        alma_descripcion: alma_descripcion,
        alma_clase: alma_clase
    };
    modalVerRegistros.style.display = 'none';
    document.body.classList.remove('modal-open');
    colocarDatos(dataset);

};

const colocarDatos = (dataset) => {
    formulario.alma_nombre.value = dataset.alma_nombre;
    formulario.alma_descripcion.value = dataset.alma_descripcion;
    formulario.alma_id.value = dataset.alma_id;
    formulario.alma_clase.value = dataset.alma_clase;

    btnGuardar.disabled = true;
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';
    btnModificar.disabled = false;
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false;
    btnCancelar.parentElement.style.display = '';
};

const cancelarAccion = () => {
    formulario.reset();
    btnGuardar.disabled = false;
    btnGuardar.parentElement.style.display = '';
    btnBuscar.disabled = false;
    btnBuscar.parentElement.style.display = '';
    btnModificar.disabled = true;
    btnModificar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
    actualizarDependencia();
    

  
};

//// Función para buscar las dependencias y colocarlas en el input alma_unidad

const buscarDependencia = async () => {

    const url = `/control_inventario/API/almacen/buscarDependencia?`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
    

        if (data && data.length > 0 && data[0].dep_desc_md && data[0].dep_llave) {
            almaUnidad.value = data[0].dep_llave;
            almaUnidadId.value = data[0].dep_desc_md;
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }

    } catch (error) {
        console.log(error);
    }

};



// Función para buscar la dependencia y actualizar el campo alma_unidad
const actualizarDependencia = async () => {
    try {
        await buscarDependencia();
        await buscarOficiales();
    } catch (error) {
        console.error(error);
   
    }
};


// Función para obtener el nombre del almacén por su ID
const obtenerNombreAlmacen = async (almaId) => {
    const url = `/control_inventario/API/almacen/obtenerNombreAlmacen?alma_id=${almaId}`;
    try {
        const respuesta = await fetch(url);
        const data = await respuesta.json();
        console.log(data);


        if (data.length > 0 && data[0].alma_nombre) {
            return {
                alma_nombre: data[0].alma_nombre,
                alma_id: data[0].alma_id,


                 };
        } else {
            return {
                alma_nombre: 'Nombre no encontrado',
                alma_id: null,
                };
        }


    } catch (error) {
        console.error(error);
        return 'Error al obtener el nombre';
    }
};



////// GUARDAR CAMPOS DEL FORMULARIO

const guardar = async (evento) => {
    evento.preventDefault();

    const almaUnidadValor = almaUnidad.value;

    const claseValueVerificar = document.getElementById('alma_clase').value;
    if (!claseValueVerificar) {
        Swal.fire({
            title: 'Información faltante',
            text: 'Para registrar un inventario, es necesario seleccionar la clase en el módulo de Registro de Inventario. Por favor, asegúrate de completar este paso antes de continuar.',
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
        return;
    }

    if (!validarFormulario(formulario, ['alma_id', 'guarda_id','guarda_almacen'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }

       const claseValue = document.getElementById('alma_clase').value;
       const claseValueDescripcion = document.getElementById('alma_clase_descripcion').value;

    const body = new FormData(formulario)
    body.delete('alma_id')
    const url = '/control_inventario/API/almacen/guardar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
     
        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                document.getElementById('alma_clase').value = claseValue;
                document.getElementById('alma_clase_descripcion').value = claseValueDescripcion;
                break;

            case 0:
                icon = 'error'
                console.log(detalle)
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
    actualizarDependencia();
   
};




////////////// FUNCION PARA BUSCAR LOS ELEMENTOS GUARDADOS

const buscar = async () => {

    let alma_nombre = formulario.alma_nombre.value;
    let alma_descripcion = formulario.alma_descripcion.value;
    let alma_unidad = formulario.alma_unidad.value;


    const url = `/control_inventario/API/almacen/buscar?alma_nombre=${alma_nombre}&alma_descripcion=${alma_descripcion}&alma_unidad=${alma_unidad}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        datatable.clear().draw();
        if (data) {
            contador = 1;
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }

    } catch (error) {
        console.log(error);
    }

};

////funcion para cambiar de situacion un almacen

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const almaUnidadValor = almaUnidad.value;
    const alma_id = document.getElementById('alma_id');
    const valor = alma_id.value;




    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData();
        body.append('alma_id', id);
        const url = '/control_inventario/API/almacen/eliminar';
        const config = {
            method: 'POST',
            body
        };
        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            console.log(data);
            const { codigo, mensaje, detalle } = data;
            let icon = 'info';
            switch (codigo) {
                case 1:
                    icon = 'success';
                    buscar();
                    break;
                case 0:
                    icon = 'error';
                    console.log(detalle);
                    break;
                default:
                    break;
            }
            Toast.fire({
                icon,
                text: mensaje
            });
        } catch (error) {
            console.log(error);
        }
    }
    buscar();
};


// funcion para modificar un almacen

const modificar = async () => {

    let valor = alma_id.value
    if (!formulario.checkValidity()) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }
    const claseValue = document.getElementById('alma_clase').value;
    const body = new FormData(formulario);
    body.delete('guarda_almacen');
    body.delete('guarda_catalogo');
    body.delete('guarda_id');
    body.delete('guarda_nombre');
    const url = '/control_inventario/API/almacen/modificar';
    const config = {
        method: 'POST',
        body
    };
    try {

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data)
        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success';
                cancelarAccion();
                break;
            case 0:
                icon = 'error';
                console.log(detalle);
                break;
            default:
                break;
        }
        Toast.fire({
            icon,
            text: mensaje
        });
    } catch (error) {
        console.log(error)
    }
    actualizarDependencia();
    buscar();
    modalVerRegistros.classList.add('show');
    modalVerRegistros.style.display = 'block';
   
};




const buscarOficiales = async () => {
  
        const url = `/control_inventario/API/almacen/buscarOficiales`;
        const config = {
            method: 'GET'
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            console.log(data);

            if (data && data.length > 0) {
                const guardaNombre = data[0].guarda_nombre;
                guarda_nombre.value = guardaNombre;
                const GuardaCatalogo = data[0].per_catalogo;
                guarda_catalogo.value = GuardaCatalogo;
          
            } else {
                guarda_nombre.value = '';
            }
        } catch (error) {
            console.log(error);
            Toast.fire({
                icon: 'error',
                title: 'Ocurrió un error al buscar los datos.'
            });
        }
};

function actualizarClase(valor) {
    const clases = {
        '1': 'Alimentos y Comestibles',
        '2': 'Vestuario y Equipo Individual',
        '3': 'Carburantes y Lubricantes',
        '4': 'Material de Construcción',
        '5': 'Artículos Personales',
        '6': 'Artículos Terminados',
        '7': 'Repuestos y Accesorios',
        '8': 'Apoyo Asuntos Civiles',
        '9': 'Material Capturado/Recuperable'
    };

    const mensajePorDefecto = "SELECCIONE LA CLASE EN 'REGISTRAR INVENTARIO'";

  // Actualiza el valor del input con el número para el envío del formulario
  document.getElementById('alma_clase').value = valor || '';

  // Muestra la descripción correspondiente o el mensaje por defecto
  document.getElementById('alma_clase_descripcion').value = clases[valor] || mensajePorDefecto;
}


let alma_clase_value;

document.addEventListener('DOMContentLoaded', function () {

    // Obtiene el valor de localStorage
    alma_clase_value = localStorage.getItem('alma_clase');

    // Verifica si el valor existe y actualiza el campo
    if (alma_clase_value) {
        actualizarClase(alma_clase_value);
    } else {
        actualizarClase(''); // Esto establecerá el mensaje por defecto
    }

          // Limpia alma_clase_value antes de abandonar la página
        window.addEventListener('beforeunload', function () {
        alma_clase_value = null;
        localStorage.removeItem('alma_clase');
    });
    
});


actualizarDependencia();

//eventos de la vista general
formulario.addEventListener('submit', guardar);
btnCancelar.addEventListener('click', cancelarAccion);
btnModificar.addEventListener('click', modificar);
datatable.on('click', '.btn-warning', traeDatos);
datatable.on('click', '.btn-danger', eliminar);

///PARA ABRIR EL MODAL


// Agrega un evento de clic al botón
btnBuscar.addEventListener('click', () => {
    modalVerRegistros.classList.add('show');
    modalVerRegistros.style.display = 'block';

    buscar();
});


//////////evento para cerrar el modal haciendo clic

botonCerrarModal.addEventListener('click', function () {
    modalVerRegistros.style.display = 'none';
    actualizarDependencia();

});

////cerrar el modal cuando se hace clic fuera del modal...
modalVerRegistros.addEventListener('click', function (event) {
    if (event.target === modalVerRegistros) {
        modalVerRegistros.style.display = 'none';
        actualizarDependencia();
     
    }
});







