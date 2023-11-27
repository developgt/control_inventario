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
let estado = [];


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
        console.log('data de almacenes', data); 

        almacenes = data;
    
        formulario.pro_almacen_id.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formulario.pro_almacen_id.appendChild(defaultOption);
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formulario.pro_almacen_id.appendChild(option);
        });

    } catch (error) {
        console.log(error);
    }
    formulario.reset();
};


const buscarUnidades = async () => {
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
        console.log('data de medidas', data); 

        medida = data;
        
        formulario.pro_medida.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formulario.pro_medida.appendChild(defaultOption);
    
        data.forEach(medida => {
            const option = document.createElement('option');
            option.value = medida.uni_id;
            option.textContent = medida.uni_nombre;
            formulario.pro_medida.appendChild(option);
        });


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


     
    } catch (error) {
        console.error(error);
       
    }
});


const guardar = async (evento) => {
    evento.preventDefault();

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
       

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
               
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

};

buscar();






////////////////////////////////////////////////////////////////

formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);




































