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
const alma_id = document.getElementById('alma_id');


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'


///para que se autocomplete el campo de dependencia en automatico. 

const almaUnidad = document.getElementById('alma_unidad');
const almaUnidadId = document.getElementById('alma_unidad_id');

//////////DATATABLE//////////////////////////////////////////////////////

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
            title: 'NOMBRE',
            data: 'alma_nombre'
        },
        {
            title: 'DESCRIPCION',
            data: 'alma_descripcion'
        },
        // {
        //     title: 'DEPENDENDENCIA',
        //     data: 'alma_unidad'
        // },
        {
            title: 'MODIFICAR',
            data: 'alma_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${row["alma_id"]}' data-nombre='${row["alma_nombre"]}' data-descripcion='${row["alma_descripcion"]}' data-unidad='${row["alma_unidad"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'alma_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        }
    ]
});


//// PARA TRAER LOS DATOS 
const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const nombre = button.dataset.nombre;
    const descripcion = button.dataset.descripcion;
    const unidad = button.dataset.unidad;

    const dataset = {
        alma_id: id,
        alma_nombre: nombre,
        alma_descripcion: descripcion,
        alma_unidad: unidad,
    };

    colocarDatos(dataset);
};

const colocarDatos = (dataset) => {
    formulario.alma_nombre.value = dataset.alma_nombre;
    formulario.alma_descripcion.value = dataset.alma_descripcion;
    formulario.alma_unidad.value = dataset.alma_unidad;
    formulario.alma_id.value = dataset.alma_id;

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

//     // Función para buscar 

 const buscarDependencia = async () => {
    //return new Promise(async (resolve, reject) => {
    const url = `/control_inventario/API/almacen/buscarDependencia?`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        //console.log(data);

        if (data && data.length > 0 && data[0].dep_desc_md && data[0].dep_llave) {
            // Mostrar el nombre de la dependencia en el campo dep_desc_md
            almaUnidad.value = data[0].dep_llave;
            // Almacenar dep_llave en alma_unidad_id 
            almaUnidadId.value = data[0].dep_desc_md;


            // if (data && data.dep_desc_md) {
            //     almaUnidad.value = data.dep_desc_md;
            //     resolve(data);
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



document.addEventListener('DOMContentLoaded', async function() {

    try {
        await buscarDependencia();
      
        buscar();
    } catch (error) {
        console.error(error);
        // Manejar el error, si es necesario.
    }
});


////// GUARDAR CAMPOS DEL FORMULARIO

const guardar = async (evento) => {
    evento.preventDefault();

    const almaUnidadValor = almaUnidad.value;


    //await almaUnidad();
    // if (!almaUnidadValor) {
    //     Toast.fire({
    //         icon: 'info',
    //         text: 'Seleccione una dependencia válida'
    //     });
    //     return;
    // }

    if (!validarFormulario(formulario, ['alma_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
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
    buscarDependencia();
    buscar();
}




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
    buscarDependencia();
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
    buscarDependencia();
    buscar();
};


// funcion para modificar un almacen

const modificar = async () => {
    //const almaUnidadValor = almaUnidad.value;
    //console.log(alma_id)
let valor = alma_id.value
    if (!formulario.checkValidity()) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.append('alma_id', alma_id.value);
    const url = '/control_inventario/API/almacen/modificar';
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
    buscarDependencia();
    buscar();
};

buscar();

formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);
btnCancelar.addEventListener('click', cancelarAccion);
btnModificar.addEventListener('click', modificar);
datatable.on('click', '.btn-warning', traeDatos );
datatable.on('click', '.btn-danger', eliminar);






// const almaUnidad = document.getElementById('alma_unidad');

// document.addEventListener('DOMContentLoaded', function() {
//     buscarDependencia();
// // });

// const buscarDependencia = async () => {
//     const url = `/control_inventario/API/almacen/buscarDependencia`;
//     const config = {
//         method: 'GET'
//     };

//     try {
//         const respuesta = await fetch(url, config);
//         const data = await respuesta.json();

//         if (data && data.dep_desc_md) {
//             almaUnidad.value = data.dep_desc_md;
//         } else {
//             almaUnidad.value = ''; // Otra acción para manejar el caso donde no se encuentra la dependencia
//             Toast.fire({
//                 title: 'No se encontraron registros',
//                 icon: 'info'
//             });
//         }
//     } catch (error) {
//         console.error(error);
//         Toast.fire({
//             title: 'Error al obtener los datos',
//             icon: 'error'
//         });
//     }
// };