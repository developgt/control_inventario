import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";

//const para la vista 
const formulario = document.getElementById('formularioAlmacen');
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const alma_id = document.getElementById('alma_id');
const asignarOficialModal = document.getElementById('asignarOficialModal');



btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'



//////////////////////////CONST PARA EL MODAL/////////////////////////////////////////////////////////
const formularioGuarda = document.getElementById('formularioGuarda');
const btnGuardarAsignar = document.getElementById('btnGuardarAsignar');
const btnModificarAsignar = document.getElementById('btnModificarAsignar');
const btnBuscarAsignar = document.getElementById('btnBuscarAsignar');
const btnCancelarAsignar = document.getElementById('btnCancelarAsignar');
const guarda_id = document.getElementById('guarda_id');
const guarda_catalogo = document.getElementById('guarda_catalogo');
const guarda_nombre = document.getElementById('guarda_nombre')
let typingTimeout;
const botonCerrarModal = document.querySelector('.modal-header .close');
const guarda_almacen = document.getElementById('guarda_almacen');




const guardaAlmacenInput = document.getElementById('guarda_almacen');
const guardaAlmacenNombreInput = document.getElementById('guarda_almacen_nombre');


btnModificarAsignar.disabled = true
btnModificarAsignar.parentElement.style.display = 'none'
btnCancelarAsignar.disabled = true
btnCancelarAsignar.parentElement.style.display = 'none'


/////////////////////////////////////////////////////////////////////////////////////////////////////

///para que se autocomplete el campo de dependencia en automatico. 

const almaUnidad = document.getElementById('alma_unidad');
const almaUnidadId = document.getElementById('alma_unidad_id');

///PARA ABRIR EL MODAL

const tablaAlmacen = document.getElementById('tablaAlmacen');


tablaAlmacen.addEventListener('click', async function (event) {
    if (event.target.classList.contains('btn-asignar-oficial')) {
        const almaId = event.target.dataset.id;
        const almaInfo = await obtenerNombreAlmacen(almaId);
        guardaAlmacenInput.value = almaInfo.alma_id;
        guardaAlmacenNombreInput.value = almaInfo.alma_nombre;
        asignarOficialModal.classList.add('show');
        asignarOficialModal.style.display = 'block';
        document.body.classList.add('modal-open');
    } else {
        console.error('El botón "btn-asignar-oficial" no se encontró en el DOM.');
    }
});

///////////AQUI TERMINA PARA ABRIR EL MODAL DE ASIGNAR OFICIAL///////////////

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
            title: 'NOMBRE',
            data: 'alma_nombre'
        },
        {
            title: 'DESCRIPCION',
            data: 'alma_descripcion'
        },
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
            width: 'auto',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        },
        {
            title: 'ASIGNAR ENCARGADO A ESTE ALMACEN',
            data: 'alma_id',
            width: 'auto',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-info btn-asignar-oficial" data-id='${data}' data-target='asignarOficial'>Asignar Oficial</button>`
        }
    ],
    // columnDefs: [

    //     {
    //         targets: 5, 
    //         className: 'col-1'
    //         //width: "400%"
    //     }
    // ],
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
    actualizarDependencia();
};

//// Función para buscar las dependencias y colocarlas en el input alma_unidad

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


// document.addEventListener('DOMContentLoaded', async function() {

//     try {
//         await buscarDependencia();

//         buscar();
//     } catch (error) {
//         console.error(error);
//         // Manejar el error, si es necesario.
//     }
// });



// Función para buscar la dependencia y actualizar el campo alma_unidad
const actualizarDependencia = async () => {
    try {
        await buscarDependencia();
    } catch (error) {
        console.error(error);
        // Manejar el error si es necesario.
    }
};


// Función para obtener el nombre del almacén por su ID
const obtenerNombreAlmacen = async (almaId) => {
    const url = `/control_inventario/API/almacen/obtenerNombreAlmacen?alma_id=${almaId}`;
    try {
        const respuesta = await fetch(url);
        //console.log(respuesta);
        const data = await respuesta.json();
        console.log(data);


        if (data.length > 0 && data[0].alma_nombre) {
            // Si se encontró el almacén, devolver el nombre
            return {
                alma_nombre: data[0].alma_nombre,
                alma_id: data[0].alma_id,


                 };
        } else {
            // Si no se encontró el almacén, devolver un mensaje indicando que no se encontró
            return {
                alma_nombre: 'Nombre no encontrado',
                alma_id: null,
                };
        }


    } catch (error) {
        console.error(error);
        // Si hay un error, devolver un mensaje indicando el error
        return 'Error al obtener el nombre';
    }
};



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
    actualizarDependencia();
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
    actualizarDependencia();
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
    //actualizarDependencia();
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
    actualizarDependencia();
    buscar();
};


///////////////////FUNCIONES PARA EJECUTAR EN EL MODAL//////////////////////////////////


///// GUARDAR CAMPOS DEL FORMULARIO

const GuardarAsignar = async (evento) => {
    evento.preventDefault();

    let guarda_nombre = formularioGuarda.guarda_nombre.value;
    

    if (!validarFormulario(formularioGuarda, ['guarda_id', 'guarda_nombre', 'guarda_nombre_almacen'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formularioGuarda)
    body.delete('guarda_id')
    body.delete('guarda_nombre')
    const url = '/control_inventario/API/almacen/guardarAsignar';
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
                formularioGuarda.reset();
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


const buscarOficiales = async () => {
    let guarda_catalogo = formularioGuarda.guarda_catalogo.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    // Función que se ejecutará después del retraso
    const fetchData = async () => {
        const url = `/control_inventario/API/almacen/buscarOficiales?guarda_catalogo=${guarda_catalogo}`;
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
    // Establecer un retraso de 500 ms antes de realizar la solicitud a la API
    typingTimeout = setTimeout(fetchData, 1200);

};

//////////evento para cerrar el modal haciendo clic

botonCerrarModal.addEventListener('click', function () {
    // Cierra el modal
    asignarOficialModal.style.display = 'none';
    document.body.classList.remove('modal-open');
    formularioGuarda.reset();
    cancelarAccionAsignar();
    actualizarDependencia();

});

////cerrar el modal cuando se hace clic fuera del modal...
asignarOficialModal.addEventListener('click', function (event) {
    if (event.target === asignarOficialModal) {
        asignarOficialModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        formularioGuarda.reset();
        cancelarAccionAsignar();
        actualizarDependencia();
        //buscarDependencia();
    }
});
//////////DATATABLE//////////////////////////

let contadorAsignar = 1;
btnModificarAsignar.disabled = true;
btnModificarAsignar.parentElement.style.display = 'none';
btnCancelarAsignar.disabled = true;
btnCancelarAsignar.parentElement.style.display = 'none';

const datatableAsignar = new Datatable('#tablaGuarda', {
    language: lenguaje,
    data: null,
    autoWidth: true,
    columns: [
        {
            title: 'NO',
            render: () => contadorAsignar++
        },
        { 
            title: 'ID',
            data: 'guarda_id'
        },
        { 
            title: 'catalogo',
            data: 'guarda_catalogo'
        },
        { 
            title: 'ID ALMACEN',
            data: 'guarda_almacen'
        },
        {
            title: 'NOMBRE',
            data: 'guarda_nombre',
            width: 120,

        },
        {
            title: 'ALMACÉN ASIGNADO',
            data: 'guarda_almacen_nombre'
        },
        {
            title: 'MODIFICAR CATÁLOGO',
            data: 'guarda_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning border border-dark" data-idguarda='${row["guarda_id"]}' data-catalogo='${row["guarda_catalogo"]}' data-almacen='${row["guarda_almacen"]}' data-nombre='${row["guarda_nombre"]}' data-almanom='${row["guarda_almacen_nombre"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'guarda_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger border border-dark" data-id='${data}'>Eliminar</button>`
        }
    ],
    columnDefs: [
        {
            targets: [1, 2, 3],
            visible: false, 
            width: 0,
            searchable: false,
            
        }
      
    ]
    
});

//// PARA TRAER LOS DATOS 
const traeDatosAsignar = (e) => {
    const button = e.target;
    const idguarda = button.dataset.idguarda;
    const catalogo= button.dataset.catalogo;
    const nombre = button.dataset.nombre;
    const almacen = button.dataset.almacen;
    const almanom = button.dataset.almanom;


    const datasetAsignar = {
        guarda_id: idguarda,
        guarda_catalogo: catalogo,
        guarda_nombre: nombre,
        guarda_almacen: almacen,
        guarda_almacen_nombre : almanom,
       
    };

    colocarDatosAsignar(datasetAsignar);
};

const colocarDatosAsignar = (datasetAsignar) => {
    formularioGuarda.guarda_id.value = datasetAsignar.guarda_id;
    formularioGuarda.guarda_catalogo.value = datasetAsignar.guarda_catalogo;
    formularioGuarda.guarda_nombre.value = datasetAsignar.guarda_nombre;
    formularioGuarda.guarda_almacen.value = datasetAsignar.guarda_almacen;
    formularioGuarda.guarda_almacen_nombre.value = datasetAsignar.guarda_almacen_nombre;
    console.log(datasetAsignar)
    

    btnGuardarAsignar.disabled = true;
    btnGuardarAsignar.parentElement.style.display = 'none';
    btnBuscarAsignar.disabled = true;
    btnBuscarAsignar.parentElement.style.display = 'none';
    btnModificarAsignar.disabled = false;
    btnModificarAsignar.parentElement.style.display = '';
    btnCancelarAsignar.disabled = false;
    btnCancelarAsignar.parentElement.style.display = '';
};

const cancelarAccionAsignar = () => {
    formularioGuarda.reset();
    btnGuardarAsignar.disabled = false;
    btnGuardarAsignar.parentElement.style.display = '';
    btnBuscarAsignar.disabled = false;
    btnBuscarAsignar.parentElement.style.display = '';
    btnModificarAsignar.disabled = true;
    btnModificarAsignar.parentElement.style.display = 'none';
    btnCancelarAsignar.disabled = true;
    btnCancelarAsignar.parentElement.style.display = 'none';
};

////////////////////////// funcion para modificar un guarda almacen/////////////////////////////////////////

const ModificarAsignar = async () => {
 
    if (!formularioGuarda.checkValidity()) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }

    const body = new FormData(formularioGuarda);
    body.append('guarda_id', guarda_id.value);
    //body.append('guarda_catalogo', guarda_catalogo.value);

    const url = '/control_inventario/API/almacen/modificarAsignar';
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
                formularioGuarda.reset();
                icon = 'success';
                BuscarAsignar();
                cancelarAccionAsignar();
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
    formularioGuarda.reset();
};

////////////////////////funcion para buscar los oficiales asignados como guarda almacen////////////////////////////////////////
const BuscarAsignar= async () => {

    // let guarda_nombre = formularioGuarda.guarda_nombre.value;
    // let guarda_almacen = formularioGuarda.guarda_almacen.value;
    // let guarda_catalogo = formularioGuarda.guarda_catalogo.value;


    const url = `/control_inventario/API/almacen/buscarAsignar?`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        datatableAsignar.clear().draw();
        if (data) {
            contadorAsignar = 1;
            datatableAsignar.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }

    } catch (error) {
        console.log(error);
    }
    formularioGuarda.reset();
    //actualizarDependencia();
};





actualizarDependencia();
buscar();
//BuscarAsignar();
//eventos de la vista general
formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);
btnCancelar.addEventListener('click', cancelarAccion);
btnModificar.addEventListener('click', modificar);
datatable.on('click', '.btn-warning', traeDatos);
datatable.on('click', '.btn-danger', eliminar);


//eventos del modal
guarda_catalogo.addEventListener('input', buscarOficiales);
formularioGuarda.addEventListener('submit', GuardarAsignar);
btnBuscarAsignar.addEventListener('click', BuscarAsignar);
btnModificarAsignar.addEventListener('click', ModificarAsignar);
datatableAsignar.on('click', '.btn-warning', traeDatosAsignar);
btnCancelarAsignar.addEventListener('click', cancelarAccionAsignar);

//datatable.on('click', '.btn-danger', eliminar);







