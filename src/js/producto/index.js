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
////PARA MANEJAR EL CKECK BOX DE SI Y NO DE FECHA
const checkboxSi = document.getElementById('tiene_fecha_si');
const checkboxNo = document.getElementById('tiene_fecha_no');
const campoFechaVencimiento = document.getElementById('campo_fecha_vencimiento');

////PARA MANEJAR EL CKECK BOX DE SI Y NO DE LOTE 
const checkboxLoteSi = document.getElementById('tiene_lote_si');
const checkboxLoteNo = document.getElementById('tiene_lote_no');
const campoLote = document.getElementById('campo_lote');


let almacenes = [];
let medida = [];
let estado = [] // se define almacenes como un array vacio...
// se define almacenes como un array vacio...
//console.log('almacenes:', almacenes);

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

//OCULTAR EL CAMPOD DE FECHA DE VENCIMIENTO
campoFechaVencimiento.style.display = 'none';
campoLote.style.display = 'none';


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
    console.log(dataset)
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

document.addEventListener('DOMContentLoaded', async function () {

    try {
        await buscarAlmacenes();
        await buscarUnidades();


        const selectAlmacen = formulario.pro_almacen_id;
        const selectMedida = formulario.pro_medida;
        const selectEstado = formulario.pro_estado;

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


const buscarEstados = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formulario.est_descripcion && formulario.est_id) {
        let est_descripcion = formulario.est_descripcion.value;
        let est_id = formulario.est_id.value;
    }
    const url = `/control_inventario/API/producto/buscarEstados`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de estados', data); // Imprimir datos en la consola

        estado = data;
        // Limpiar el contenido del select
        formulario.pro_estado.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formulario.pro_estado.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(estado => {
            const option = document.createElement('option');
            option.value = estado.est_id;
            option.textContent = estado.est_descripcion;
            formulario.pro_estado.appendChild(option);
        });



        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formulario.reset();
}


const guardar = async (evento) => {
    evento.preventDefault();

   
     // Obtener los valores de los checkboxes "Sí" para No. de serie y Fecha de vencimiento
     const tieneNoSerie = checkboxLoteSi.checked;
     const tieneFechaVencimiento = checkboxSi.checked;
 

    // Obtener los valores de los campos pro_no_serie y pro_vencimiento
    const noSerie = formulario.pro_no_serie.value;
    const vencimiento = formulario.pro_vencimiento.value;

    // Validar campos comunes a todos los casos
    if (!validarFormulario(formulario, ['pro_id', 'pro_no_serie', 'pro_vencimiento'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos obligatorios'
        });
        return;
    }

    // Validar campos adicionales si el checkbox "Sí" está marcado para No. de serie
    if (tieneNoSerie && !noSerie) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar el campo No. de serie'
        });
        return;
    }

    // Validar campos adicionales si el checkbox "Sí" está marcado para Fecha de vencimiento
    if (tieneFechaVencimiento && !vencimiento) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar el campo Fecha de vencimiento'
        });
        return;
    }

    // Validar si ningún checkbox está seleccionado
    if (!checkboxLoteSi.checked && !checkboxLoteNo.checked) {
        Toast.fire({
            icon: 'info',
            text: 'Debe seleccionar si tiene o no tiene No. de lote o serie'
        });
        return;
    }
    
    if(!checkboxSi.checked && !checkboxNo.checked) {
        Toast.fire({
            icon: 'info',
            text: 'Debe seleccionar si tiene o no tiene fecha de vencimiento'
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


buscarEstados();
////////PARA MOSTRAR EL INPUT DE FECHA DE VENCIMIENTO SI DAN CLIC EN SI 
checkboxSi.addEventListener('click', function () {
    if (checkboxSi.checked) {
        checkboxNo.checked = false; // Desmarcar el checkbox "No"
        campoFechaVencimiento.style.display = 'block';
    } else {
        campoFechaVencimiento.style.display = 'none';
    }
});

checkboxNo.addEventListener('click', function () {
    if (checkboxNo.checked) {
        checkboxSi.checked = false; // Desmarcar el checkbox "Sí"
        campoFechaVencimiento.style.display = 'none';
    } else {
        campoFechaVencimiento.style.display = 'block';
    }
});
//////////////////////////////////////////////////////////

////////PARA MOSTRAR EL INPUT DE LOTE SI DAN CLIC EN SI 
checkboxLoteSi.addEventListener('click', function () {
    if (checkboxLoteSi.checked) {
        checkboxLoteNo.checked = false; // Desmarcar el checkbox "No"
        campoLote.style.display = 'block';
    } else {
        campoLote.style.display = 'none';
    }
});

checkboxLoteNo.addEventListener('click', function () {
    if (checkboxLoteNo.checked) {
        checkboxLoteSi.checked = false; // Desmarcar el checkbox "Sí"
        campoLote.style.display = 'none';
    } else {
        campoLote.style.display = 'block';
    }
});

////////////////////////////////////////////////////////////////

formulario.addEventListener('submit', guardar);
