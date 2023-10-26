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
const uni_id = document.getElementById('uni_id');
const alma_nombre = document.getElementById('alma_nombre');
const alma_id = document.getElementById('alma_id');
const nombreAlmacen = document.getElementById('uni_almacen')
let almaIdSeleccionado = null;

let almacenes = []; // se define almacenes como un array vacio...
console.log('almacenes:', almacenes);

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

//////////DATATABLE//////////////////////////////////////////////////////

let contador = 1;
btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

const datatable = new Datatable('#tablaMedida', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'ID',
            data: 'alma_id'
        },
        {
            title: 'Medidas de las unidades',
            data: 'uni_nombre'
        },
        {
            title: 'Almacen al que pertenecen las unidades',
            data: 'uni_almacen'
        },
        {
            title: 'MODIFICAR',
            data: 'uni_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${row["uni_id"]}' data-nombre='${row["uni_nombre"]}' data-almacen='${row["alma_id"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'uni_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        }
    ],
    columnDefs: [
        {
            targets: 1,
            visible: false, 
            searchable: false, 
        }
    ]

});


const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const nombre = button.dataset.nombre;
    const almacen = button.dataset.almacen;


    const dataset = {
         id,
         nombre,
         almacen
    };
console.log (dataset)
    colocarDatos(dataset);

  
};


const colocarDatos = (dataset) => {
    formulario.uni_nombre.value = dataset.nombre;
    formulario.uni_id.value = dataset.id;
    nombreAlmacen.value = dataset.almacen; 


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
};


//cargar contenido cuando se cargue la pagina

document.addEventListener('DOMContentLoaded', async function() {

    try {
        await buscarAlmacenes();
      
        buscar();
    } catch (error) {
        console.error(error);
        // Manejar el error, si es necesario.
    }
});

const buscarAlmacenes = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formulario.alma_nombre && formulario.alma_id) {
        let alma_nombre = formulario.alma_nombre.value;
        let alma_id = formulario.alma_id.value;
    }
    const url = `/control_inventario/API/medida/buscarAlmacenes`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); // Imprimir datos en la consola

        almacenes = data;
        // Limpiar el contenido del select
        formulario.uni_almacen.innerHTML = '';

         // Agregar opción predeterminada
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'SELECCIONE...';
    formulario.uni_almacen.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formulario.uni_almacen.appendChild(option);
        });

   

        contador = 1;
        datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formulario.reset();
};


////// GUARDAR CAMPOS DEL FORMULARIO

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['uni_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formulario)
    body.delete('uni_id')
    const url = '/control_inventario/API/medida/guardar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        // return

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
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
    buscar();
}




////////////// FUNCION PARA BUSCAR LOS ELEMENTOS GUARDADOS

const buscar = async () => {
    
   
    let uni_nombre = formulario.uni_nombre.value;
    let uni_almacen = formulario.uni_almacen.value;


    const url = `/control_inventario/API/medida/buscar?uni_nombre=${uni_nombre}&uni_almacen=${uni_almacen}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

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
    formulario.reset();
};

////funcion para cambiar de situacion un almacen (eliminado)

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const uni_id = document.getElementById('uni_id');
    const valor = uni_id.value;




    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData();
        body.append('uni_id', id);
        const url = '/control_inventario/API/medida/eliminar';
        const config = {
            method: 'POST',
            body
        };
        try {
            //await buscarDependencia();
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


// funcion para modificar un medida

const modificar = async () => {
  
let valor = uni_id.value
    if (!formulario.checkValidity()) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.append('uni_id', uni_id.value);
    body.append('alma_id', almaIdSeleccionado); 
    const url = '/control_inventario/API/medida/modificar';
    const config = {
        method: 'POST',
        body
    };
    try {
        //await buscarDependencia();
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data)
        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success';
                buscar();
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
        console.log(error);
    }
    formulario.reset();
    buscar();
};

buscar();
buscarAlmacenes();

formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);
btnCancelar.addEventListener('click', cancelarAccion);
btnModificar.addEventListener('click', modificar);
datatable.on('click', '.btn-warning', traeDatos );
datatable.on('click', '.btn-danger', eliminar);






