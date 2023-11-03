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
const est_id = document.getElementById('est_id');


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'



///para que se autocomplete el campo de dependencia en automatico. 

const almaEstado = document.getElementById('est_dependencia');
const almaEstadoId = document.getElementById('est_dependencia_id');


//////////DATATABLE//////////////////////////////////////////////////////

let contador = 1;
btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

const datatable = new Datatable('#tablaEstado', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'DESCRIPCION',
            data: 'est_descripcion'
        },
        {
            title: 'DESCRIPCION',
            data: 'est_dependencia'
        },
        {
            title: 'MODIFICAR',
            data: 'est_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${row["est_id"]}' data-descripcion='${row["est_descripcion"]}' data-dependencia='${row["est_dependencia"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'est_id',
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
    const descripcion = button.dataset.descripcion;
    const dependencia = button.dataset.dependencia;



    const dataset = {
        est_id: id,
        est_descripcion: descripcion,
        est_dependencia: dependencia
    };

    colocarDatos(dataset);
};

const colocarDatos = (dataset) => {
    formulario.est_dependencia.value = dataset.est_dependencia;
    formulario.est_descripcion.value = dataset.est_descripcion;
    formulario.est_id.value = dataset.est_id;

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


//// Función para buscar las dependencias y colocarlas en el input alma_unidad

const buscarDependencia = async () => {
    //return new Promise(async (resolve, reject) => {
    const url = `/control_inventario/API/estado/buscarDependencia?`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        //console.log(data);

        if (data && data.length > 0 && data[0].dep_desc_md && data[0].dep_llave) {
            // Mostrar el nombre de la dependencia en el campo dep_desc_md
            almaEstado.value = data[0].dep_llave;
            // Almacenar dep_llave en alma_unidad_id 
            almaEstadoId.value = data[0].dep_desc_md;

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


// Función para buscar la dependencia y actualizar el campo alma_unidad
// const actualizarDependencia = async () => {
//     try {
//         await buscarDependencia();
//     } catch (error) {
//         console.error(error);
//         Manejar el error si es necesario.
//     }
// };

////// GUARDAR CAMPOS DEL FORMULARIO

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['est_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formulario)
    body.delete('alma_id')
    const url = '/control_inventario/API/estado/guardar';
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
    buscarDependencia();
    //actualizarDependencia();
}




////////////// FUNCION PARA BUSCAR LOS ELEMENTOS GUARDADOS

const buscar = async () => {
    
   
    let est_descripcion = formulario.est_descripcion.value;



    const url = `/control_inventario/API/estado/buscar?est_descripcion=${est_descripcion}`;
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
    //actualizarDependencia();
};

////funcion para cambiar de situacion un almacen (eliminado)

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const est_id = document.getElementById('est_id');
    const valor = est_id.value;




    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData();
        body.append('est_id', id);
        const url = '/control_inventario/API/estado/eliminar';
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


// funcion para modificar un estado

const modificar = async () => {
  
let valor = est_id.value
    if (!formulario.checkValidity()) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.append('est_id', est_id.value);
    const url = '/control_inventario/API/estado/modificar';
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

//buscar();
buscarDependencia();
//actualizarDependencia();

formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);
btnCancelar.addEventListener('click', cancelarAccion);
btnModificar.addEventListener('click', modificar);
datatable.on('click', '.btn-warning', traeDatos );
datatable.on('click', '.btn-danger', eliminar);






