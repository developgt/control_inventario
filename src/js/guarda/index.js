import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";


const formulario = document.querySelector('form');
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const guarda_id = document.getElementById('guarda_id');
const guarda_id2 = document.getElementById('guarda_id2');
const guarda_catalogo = document.getElementById('guarda_catalogo');
const guarda_catalogo2 = document.getElementById('guarda_catalogo2');
const guarda_nombre = document.getElementById('guarda_nombre')
const guarda_nombre2 = document.getElementById('guarda_nombre2')
const guarda_almacen = document.getElementById('guarda_almacen');
const alma_nombre = document.getElementById('alma_nombre');
const alma_id = document.getElementById('alma_id');
const nombreAlmacen = document.getElementById('guarda_almacen')
let almaIdSeleccionado = null;
let typingTimeout;
let almacenes = []; 
let almaSeleccionadoId;
const botonCerrarModal = document.querySelector('.modal-header .close');
const modalVerRegistros = document.getElementById('modalVerRegistros');




//////////DATATABLE//////////////////////////

let contador = 1;

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
            title: 'Situación del Inventario',
            data: 'guarda_situacion',
            render: function (data) {
                if (data == 0) {
                    return '<span style="color: red;">INVENTARIO ENTREGADO</span>';
                } else {
                    return 'Verifique la entrega del inventario. Si aparece aquí, contacte al administrador.';
                }
            }
        },
        
        

    ],
});





const buscarAlmacenes = async () => {
  
    if (formulario.alma_nombre && formulario.alma_id) {
        let alma_nombre = formulario.alma_nombre.value;
        let alma_id = formulario.alma_id.value;
    }
    const url = `/control_inventario/API/guarda/buscarAlmacenes`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); 

        almacenes = data;
        formulario.guarda_almacen.innerHTML = '';
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'SELECCIONE...';
    formulario.guarda_almacen.appendChild(defaultOption);
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formulario.guarda_almacen.appendChild(option);
        });
    } catch (error) {
        console.log(error);
    }

};



const buscarOficialesEntrega = async () => {
    let guarda_catalogo2 = formulario.guarda_catalogo2.value;
    clearTimeout(typingTimeout); 

    const fetchData = async () => {
        const url = `/control_inventario/API/guarda/buscarOficialesEntrega?guarda_catalogo2=${guarda_catalogo2}`;
        const config = {
            method: 'GET'
        };    

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            console.log(data);

            if (data && data.length > 0) {
                const guardaNombre2 = data[0].guarda_nombre2; 
                guarda_nombre2.value = guardaNombre2;
                Toast.fire({
                    icon: 'success',
                    title: 'El catálogo ingresado es correcto, se muestran los siguientes datos.'
                });    
            } else {
                guarda_nombre.value = ''; 
                Toast.fire({
                    icon: 'info',
                    title: 'Ingrese un catálogo válido.'
                });    
            }    
        } catch (error) {
            console.log(error);
            Toast.fire({
                icon: 'error',
                title: 'Ocurrió un error al buscar los datos.'
            });    
        }    
    };    

     typingTimeout = setTimeout(fetchData, 1200);

};     


const buscarOficiales = async () => {
  
    const url = `/control_inventario/API/guarda/buscarOficiales`;
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

// Agregar evento al cambio del select para almacenar el ID del almacén
formulario.guarda_almacen.addEventListener('change', function () {
    almaSeleccionadoId = this.value;
    console.log('Alma ID seleccionado:', almaSeleccionadoId);
    buscarIdGuarda();
});


const buscarIdGuarda = async () => {
  
    const url = `/control_inventario/API/guarda/buscarIdGuarda?almaSeleccionadoId=${almaSeleccionadoId}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        if (data && data.length > 0) {
            const guardaId = data[0].guarda_id;
            guarda_id2.value = guardaId;

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







// Función para manejar tanto la modificación como el guardado
const modificarYGuardar = async () => {
    if (!validarFormulario(formulario, ['guarda_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario);
    const url = '/control_inventario/API/guarda/modificarYGuardar';
    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        const { codigo, mensaje, detalle } = data;
        let icon = (codigo === 1) ? 'success' : 'error';

        Toast.fire({
            icon,
            text: mensaje
        });

        if (codigo === 1) {
            formulario.reset();
            buscarAlmacenes();
        }
    } catch (error) {
        console.log(error);
        Toast.fire({
            icon: 'error',
            text: 'Ocurrió un error al realizar la operación'
        });
    }
}


////////////// FUNCION PARA BUSCAR LOS ELEMENTOS GUARDADOS

const buscar = async () => {

    const url = `/control_inventario/API/guarda/buscar`;
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


buscarOficiales();
buscarAlmacenes();
guarda_catalogo2.addEventListener('input', buscarOficialesEntrega);


btnBuscar.addEventListener('click', () => {
    modalVerRegistros.classList.add('show');
    modalVerRegistros.style.display = 'block';

    buscar();
});




btnGuardar.addEventListener('click', async (e) => {
    e.preventDefault();
     Swal.fire({
        title: 'Confirmar Entrega',
        text: "Se entregará el inventario seleccionado. ¿Desea continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, entregar',
        cancelButtonText: 'Cancelar acción'
    }).then((result) => {
        if (result.isConfirmed) {
            modificarYGuardar();
        }
    });
});


//////////evento para cerrar el modal haciendo clic

botonCerrarModal.addEventListener('click', function () {
    modalVerRegistros.style.display = 'none';
    

});

////cerrar el modal cuando se hace clic fuera del modal...
modalVerRegistros.addEventListener('click', function (event) {
    if (event.target === modalVerRegistros) {
        modalVerRegistros.style.display = 'none';
     
    }
});





