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
const pro_id = document.getElementById('pro_id');
const alma_nombre = document.getElementById('alma_nombre');
const alma_id = document.getElementById('alma_id');
const nombreAlmacen = document.getElementById('pro_almacen_id')
let almaIdSeleccionado = null;



let almacenes = [];
let medida = [];
let estado = [] // se define almacenes como un array vacio...
// se define almacenes como un array vacio...
//console.log('almacenes:', almacenes);

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

const datatable = new Datatable('#tablaProducto', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'Nombre del Producto',
            data: 'pro_id'
        },
        {
            title: 'Nombre del Producto',
            data: 'pro_nom_articulo'
        },
        {
            title: 'Descripcion del producto',
            data: 'pro_descripcion'
        },
        {
            title: 'Medida del almacén',
            data: 'pro_medida'
        },
        {
            title: 'Almacén al que pertenecen los productos',
            data: 'pro_almacen_id'
        },
        {
            title: 'MODIFICAR',
            data: 'pro_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${row["pro_id"]}' data-nombre='${row["uni_nombre"]}' data-almacen='${row["alma_id"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'pro_id',
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
    console.log(dataset)
    colocarDatos(dataset);


};


const colocarDatos = (dataset) => {
    formulario.uni_nombre.value = dataset.nombre;
    formulario.pro_id.value = dataset.id;
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



const buscarAlmacenes = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formulario.pro_almacen_id && formulario.alma_id) {
        let alma_nombre = formulario.alma_nombre.value;
        let alma_id = formulario.alma_id.value;
    }
    const url = `/control_inventario/API/producto/buscarAlmacenes`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); // Imprimir datos en la consola

        almacenes = data;
        // Limpiar el contenido del select
        formulario.pro_almacen_id.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formulario.pro_almacen_id.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formulario.pro_almacen_id.appendChild(option);
        });



        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formulario.reset();
};


const buscarUnidades = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formulario.uni_nombre && formulario.uni_id) {
        let uni_nombre = formulario.uni_nombre.value;
        let uni_id = formulario.uni_id.value;
    }
    const url = `/control_inventario/API/producto/buscarUnidades`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de medidas', data); // Imprimir datos en la consola

        medida = data;
        // Limpiar el contenido del select
        formulario.pro_medida.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formulario.pro_medida.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(medida => {
            const option = document.createElement('option');
            option.value = medida.uni_id;
            option.textContent = medida.uni_nombre;
            formulario.pro_medida.appendChild(option);
        });



        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formulario.reset();
};


//cargar contenido cuando se cargue la pagina

document.addEventListener('DOMContentLoaded', async function () {

    try {
        await buscarAlmacenes();
        await buscarUnidades();


        const selectAlmacen = formulario.pro_almacen_id;
        const selectMedida = formulario.pro_medida;


        selectAlmacen.addEventListener('change', () => {
            const almacenSeleccionado = selectAlmacen.value;
            const unidadesFiltradas = medida.filter(medida => medida.alma_id == almacenSeleccionado);
            selectMedida.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'SELECCIONE...';
            selectMedida.appendChild(defaultOption);

            unidadesFiltradas.forEach(unidad => {
                const option = document.createElement('option');
                option.value = unidad.uni_id;
                option.textContent = unidad.uni_nombre;
                selectMedida.appendChild(option);
            });
        });


        //buscar();
    } catch (error) {
        console.error(error);
        // Manejar el error, si es necesario.
    }
});

// const buscarEstados = async () => {
//     // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
//     if (formulario.est_descripcion && formulario.est_id) {
//         let est_descripcion = formulario.est_descripcion.value;
//         let est_id = formulario.est_id.value;
//     }
//     const url = `/control_inventario/API/producto/buscarEstados`;
//     const config = {
//         method: 'GET'
//     };

//     try {
//         const respuesta = await fetch(url, config);
//         const data = await respuesta.json();
//         console.log('data de estados', data); // Imprimir datos en la consola

//         estado = data;
//         // Limpiar el contenido del select
//         formulario.pro_estado.innerHTML = '';

//         // Agregar opción predeterminada
//         const defaultOption = document.createElement('option');
//         defaultOption.value = '';
//         defaultOption.textContent = 'SELECCIONE...';
//         formulario.pro_estado.appendChild(defaultOption);
//         // Iterar sobre cada objeto en el arreglo y crear opciones para el select
//         data.forEach(estado => {
//             const option = document.createElement('option');
//             option.value = estado.est_id;
//             option.textContent = estado.est_descripcion;
//             formulario.pro_estado.appendChild(option);
//         });



//         //contador = 1;
//         //datatable.clear().draw();
//     } catch (error) {
//         console.log(error);
//     }
//     formulario.reset();
// }


const guardar = async (evento) => {
    evento.preventDefault();

    // Validar campos comunes a todos los casos
    if (!validarFormulario(formulario, ['pro_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos obligatorios'
        });
        return;
    }

    const body = new FormData(formulario)
    body.delete('pro_id')
    const url = '/control_inventario/API/producto/guardar';
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
                //buscar();
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
    //buscar();

}

const buscar = async () => {


    let pro_almacen_id = formulario.pro_almacen_id.value;
    let pro_medida = formulario.pro_medida.value;
    let pro_nom_articulo = formulario.pro_nom_articulo.value;
    let pro_descripcion = formulario.pro_descripcion.value;

    const url = `/control_inventario/API/producto/buscar?pro_almacen_id=${pro_almacen_id}&pro_medida=${pro_medida}&pro_nom_articulo=${pro_nom_articulo}&pro_descripcion=${pro_descripcion}`;

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
    formulario.reset();

    //actualizarDependencia();
};

buscar();






////////////////////////////////////////////////////////////////

formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);




































