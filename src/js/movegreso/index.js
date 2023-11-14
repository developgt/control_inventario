import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";


////formulario movimiento//////////
const formulario = document.getElementById('formularioMovimiento');
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const btnSiguiente = document.getElementById('btnSiguiente');
const btnAnterior = document.getElementById('btnAnterior');
const pro_id = document.getElementById('pro_id');
const alma_nombre = document.getElementById('alma_nombre');
const alma_id = document.getElementById('alma_id');
const nombreAlmacen = document.getElementById('pro_almacen_id')
let almaIdSeleccionado = null;
const mov_perso_entrega = document.getElementById('mov_perso_entrega');
const mov_perso_entrega_nom = document.getElementById('mov_perso_entrega_nom');
const mov_perso_recibe = document.getElementById('mov_perso_recibe');
const mov_perso_recibe_nom = document.getElementById('mov_perso_recibe_nom');
const mov_perso_respon = document.getElementById('mov_perso_respon');
const mov_perso_respon_nom = document.getElementById('mov_perso_respon_nom');
const movMovimientoDiv = document.getElementById('mov_movimiento')
let typingTimeout;


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

////////formulario detalle/////////////////
const formularioDetalle = document.getElementById('formularioDetalle');
const btnGuardarDetalle = document.getElementById('btnGuardarDetalle');
const btnBuscarDetalle = document.getElementById('btnBuscarDetalle');
const btnModificarDetalle = document.getElementById('btnModificarDetalle');
const btnCancelarDetalle = document.getElementById('btnCancelarDetalle');
const movDetalleDiv = document.getElementById('mov_detalle');

//CONST PARA LOS INPUTS 
const detProIdSelect = document.getElementById('det_pro_id');
const detLoteInput = document.getElementById('det_lote');
const detEstadoSelect = document.getElementById('det_estado');
const detCantidadInput = document.getElementById('det_cantidad');
const detCantidadExistenteInput = document.getElementById('det_cantidad_existente');
const detCantidadLoteInput = document.getElementById('det_cantidad_lote');

//////formulario existencias//////////////////
const formularioExistencia = document.getElementById('formularioExistencia');
const mov_alma = document.getElementById('mov_alma');
const btnBuscarExistencias = document.getElementById('btnBuscarExistencias');

// ////PARA MANEJAR EL CKECK BOX DE SI Y NO DE LOTE 

const checkboxLoteNo = document.getElementById('tiene_lote_no');
const checkboxLoteSi = document.getElementById('tiene_lote_si');

// para el modal///////
const botonVerIngresos = document.getElementById('btnVerIngresos');
const modalVerExistencias = document.getElementById('verExistencias');
const botonCerrarModal = document.querySelector('.modal-header .close');
const formularioModal = document.getElementById('formularioExistencia');

let almaSeleccionadoId;// para guardar el id del almacen seleccionado
let producto = [];
let estado = [];// se define estado como un array vacio...
let almacenes = []; // se define almacenes como un array vacio...
let dependencias = [];
// Oculta el elemento div card formulario detalle
movDetalleDiv.style.display = "none";

btnModificarDetalle.disabled = true
btnModificarDetalle.parentElement.style.display = 'none'
btnCancelarDetalle.disabled = true
btnCancelarDetalle.parentElement.style.display = 'none'


//////////DATATABLE//////////////////////////////////////////////////////

let contador = 1;


const datatable = new Datatable('#tablaExistencias', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'Producto',
            data: 'det_pro_id'
        },
        {
            title: 'Estado del insumo',
            data: 'det_estado'
        },
        {
            title: 'Producto',
            data: 'pro_nom_articulo'
        },
        {
            title: 'Medida',
            data: 'pro_medida_nombre'
        },
        {
            title: 'Lote',
            data: 'det_lote'
        },
        {
            title: 'Estado del insumo',
            data: 'est_descripcion'
        },
        {
            title: 'Fecha de Vencimiento',
            data: 'det_fecha_vence'
        },
        {
            title: 'Cantidad Existente',
            data: 'det_cantidad_existente'
        },
        {
            title: 'Cantidad Existente Por lote',
            data: 'det_cantidad_lote'
        },
        {
            title: 'MODIFICAR',
            data: 'det_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${row["est_id"]}' data-descripcion='${row["est_descripcion"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'det_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        }
    ],
    columnDefs: [
        {
            targets: [1, 2],
            visible: false, 
            width: 0,
            searchable: false,
            
        }
      
    ]
});


//// PARA TRAER LOS DATOS 
const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const descripcion = button.dataset.descripcion;




    const dataset = {
        est_id: id,
        est_descripcion: descripcion,

    };

    colocarDatos(dataset);
};

const colocarDatos = (dataset) => {
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




//////////para buscar oficiales y llenar el campo de la persona que entrega////////

const buscarOficiales = async () => {
    let mov_perso_entrega = formularioMovimiento.mov_perso_entrega.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    // Función que se ejecutará después del retraso
    const fetchData = async () => {
        const url = `/control_inventario/API/movegreso/buscarOficiales?mov_perso_entrega=${mov_perso_entrega}`;
        const config = {
            method: 'GET'
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            console.log(data);

            if (data && data.length > 0) {
                const entregaNombre = data[0].mov_perso_entrega_nom;
                mov_perso_entrega_nom.value = entregaNombre;
                Toast.fire({
                    icon: 'success',
                    title: 'El catálogo ingresado es correcto, se muestran los siguientes datos.'
                });
            } else {
                mov_perso_entrega_nom.value = '';
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


//////////para buscar oficiales y llenar el campo de la persona que recibe////////

const buscarOficialesRecibe = async () => {
    let mov_perso_recibe = formularioMovimiento.mov_perso_recibe.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    // Función que se ejecutará después del retraso
    const fetchData = async () => {
        const url = `/control_inventario/API/movegreso/buscarOficialesRecibe?mov_perso_recibe=${mov_perso_recibe}`;
        const config = {
            method: 'GET'
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            console.log(data);

            if (data && data.length > 0) {
                const recibeNombre = data[0].mov_perso_recibe_nom;
                mov_perso_recibe_nom.value = recibeNombre;
                Toast.fire({
                    icon: 'success',
                    title: 'El catálogo ingresado es correcto, se muestran los siguientes datos.'
                });
            } else {
                mov_perso_recibe_nom.value = '';
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


//////////para buscar oficiales y llenar el campo de la persona que entrega////////

const buscarOficialesResponsable = async () => {
    let mov_perso_respon = formularioMovimiento.mov_perso_respon.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    // Función que se ejecutará después del retraso
    const fetchData = async () => {
        const url = `/control_inventario/API/movegreso/buscarOficialesResponsable?mov_perso_respon=${mov_perso_respon}`;
        const config = {
            method: 'GET'
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            console.log(data);

            if (data && data.length > 0) {
                const responsableNombre = data[0].mov_perso_respon_nom;
                mov_perso_respon_nom.value = responsableNombre;
                Toast.fire({
                    icon: 'success',
                    title: 'El catálogo ingresado es correcto, se muestran los siguientes datos.'
                });
            } else {
                mov_perso_respon_nom.value = '';
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



const buscarAlmacenes = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formulario.alma_nombre && formulario.alma_id) {
        let alma_nombre = formulario.alma_nombre.value;
        let alma_id = formulario.alma_id.value;
    }
    const url = `/control_inventario/API/movegreso/buscarAlmacenes`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); // Imprimir datos en la consola

        almacenes = data;
        // Limpiar el contenido del select
        formulario.mov_alma_id.innerHTML = '';

         // Agregar opción predeterminada
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'SELECCIONE...';
    formulario.mov_alma_id.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formulario.mov_alma_id.appendChild(option);
        });

   

        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formulario.reset();
};



const buscarDependencia = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formulario.dep_desc_md && formulario.dep_llave) {
        let dep_desc_md = formulario.dep_desc_md.value;
        let dep_llave = formulario.dep_llave.value;
    }
    const url = `/control_inventario/API/movegreso/buscarDependencia`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de dependencias', data); // Imprimir datos en la consola

        dependencias = data;
        // Limpiar el contenido del select
        formularioMovimiento.mov_proce_destino.innerHTML = '';

         // Agregar opción predeterminada
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'SELECCIONE...';
    formularioMovimiento.mov_proce_destino.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(dependencias => {
            const option = document.createElement('option');
            option.value = dependencias.dep_llave;
            option.textContent = dependencias.dep_desc_md;
            formularioMovimiento.mov_proce_destino.appendChild(option);
        });

   

        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formularioMovimiento.reset();
};



const buscarEstados = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formularioDetalle.est_descripcion && formularioDetalle.est_id) {
        let est_descripcion = formularioDetalle.est_descripcion.value;
        let est_id = formularioDetalle.est_id.value;
    }
    const url = `/control_inventario/API/movimiento/buscarEstados`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de estados', data); // Imprimir datos en la consola

        estado = data;
        // Limpiar el contenido del select
        formularioDetalle.det_estado.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioDetalle.det_estado.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(estado => {
            const option = document.createElement('option');
            option.value = estado.est_id;
            option.textContent = estado.est_descripcion;
            formularioDetalle.det_estado.appendChild(option);
        });
        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formularioDetalle.reset();
};

////para buscar almacenes en el formulario existencia/////////////

const buscarAlmacenesEgreso = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formularioExistencia.alma_nombre && formularioExistencia.alma_id) {
        let alma_nombre = formularioExistencia.alma_nombre.value;
        let alma_id = formularioExistencia.alma_id.value;
    }
    const url = `/control_inventario/API/movimiento/buscarAlmacenes`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); // Imprimir datos en la consola

        almacenes = data;
        // Limpiar el contenido del select
        formularioExistencia.mov_alma.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioExistencia.mov_alma.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formularioExistencia.mov_alma.appendChild(option);
        });



        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formularioExistencia.reset();
};

/////////////////////////////almacenar el id del formulario existencia//////////////////////////////////////
// Agregar evento al cambio del select para almacenar el ID del almacén
formularioExistencia.mov_alma.addEventListener('change', function () {
    // Obtener el ID del almacén seleccionado
    almaSeleccionadoId = this.value;

    // Imprimir el valor en la consola para verificar
    console.log('Alma ID seleccionado:', almaSeleccionadoId);

    // Llamar a buscarProducto pasando el ID del almacén
    buscarProducto();
});




/////////////////////////////almacenar el id//////////////////////////////////////
// Agregar evento al cambio del select para almacenar el ID del almacén
formulario.mov_alma_id.addEventListener('change', function () {
    // Obtener el ID del almacén seleccionado
    almaSeleccionadoId = this.value;

    // Imprimir el valor en la consola para verificar
    console.log('Alma ID seleccionado:', almaSeleccionadoId);

    // Llamar a buscarProducto pasando el ID del almacén
    buscarProducto();
});


////////////////buscar producto de acuerdo al id del almacen seleccionado/////////////////////////////

const buscarProducto = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formularioExistencia.pro_nom_articulo && formularioExistencia.pro_id) {
        let pro_nom_articulo = formularioExistencia.pro_nom_articulo.value;
        let pro_id = formularioExistencia.pro_id.value;
    }

    const url = `/control_inventario/API/movimiento/buscarProducto?almaSeleccionadoId=${almaSeleccionadoId}`;
    const config = {
        method: 'GET'
    };

    console.log(data)

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de productos', data); // Imprimir datos en la consola

        producto = data;
        // Limpiar el contenido del select
        formularioExistencia.det_pro_id.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioExistencia.det_pro_id.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(producto => {
            const option = document.createElement('option');
            option.value = producto.pro_id;
            option.textContent = producto.pro_nom_articulo;
            formularioExistencia.det_pro_id.appendChild(option);
        });

        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formularioDetalle.reset();
};

////////////// FUNCION PARA BUSCAR LOS ELEMENTOS GUARDADOS

const buscarExistencias = async () => {
    
   
    let mov_alma = formularioExistencia.mov_alma.value;
    let det_pro_id = formularioExistencia.det_pro_id.value;

    const url = `/control_inventario/API/movegreso/buscarExistencias?mov_alma=${mov_alma}&det_pro_id=${det_pro_id}`;
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
    formularioExistencia.reset();

    //actualizarDependencia();
};


///////////////////////////

////// GUARDAR CAMPOS DEL FORMULARIO MOVIMIENTO

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['mov_id', 'mov_tipo_mov'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formulario)
    body.delete('mov_id')
    const url = '/control_inventario/API/movimiento/guardar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        // return

        const { codigo, mensaje, id, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                const movimientoId = id;
                formulario.reset();
                icon = 'success'
                document.getElementById('det_mov_id').value = movimientoId;
                // Ocultar el formulario de movimiento
                movMovimientoDiv.style.display = 'none';
                // Mostrar el formulario de detalle
                movDetalleDiv.style.display = 'block';

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

}




//////////////////////////////////////////////
////buscar cantidad existentes por lotes y cantidad existentes del formulario detalle//////


const buscarCantidadLote = async () => {


    let det_pro_id = detProIdSelect.value;
    let det_lote = detLoteInput.value;
    let det_estado = detEstadoSelect.value;

    //if (det_pro_id && det_lote && det_estado) {
    //     if (det_pro_id && det_estado) {
    //         // Comprobar si el campo de lote está lleno (ignorar si es nulo)
    //         if (det_lote !== null && det_lote.trim() === '') {
    //             //return;
    //         }

    const url = `/control_inventario/API/movimiento/buscarCantidadLote?det_pro_id=${det_pro_id}&det_lote=${det_lote}&det_estado=${det_estado}`;


    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        // Verificar si se encontraron registros
        if (data && data.length > 0) {
            // Asignar los valores a los inputs
            //formularioDetalle.det_cantidad_existente.value = data[0].det_cantidad_existente;
            formularioDetalle.det_cantidad_lote.value = data[0].det_cantidad_lote;

            // Actualizar los valores iniciales después de la búsqueda
            //valorInicialCantidadExistente = parseFloat(data[0].det_cantidad_existente) || 0;
            valorInicialCantidadLote = parseFloat(data[0].det_cantidad_lote) || 0;

        } else {
            // Si no se encontraron registros, establecer los inputs en 0
            //formularioDetalle.det_cantidad_existente.value = 0;
            formularioDetalle.det_cantidad_lote.value = 0;

            // Si no se encontraron registros, los valores iniciales serán 0
            //valorInicialCantidadExistente = 0;
            valorInicialCantidadLote = 0;

        }

    } catch (error) {
        console.log(error);
    }
    //   } else {

    //   }

};



const buscarCantidad = async () => {


    let det_pro_id = detProIdSelect.value;

    const url = `/control_inventario/API/movimiento/buscarCantidad?det_pro_id=${det_pro_id}`;


    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        // Verificar si se encontraron registros
        if (data && data.length > 0) {
            // Asignar los valores a los inputs
            formularioDetalle.det_cantidad_existente.value = data[0].det_cantidad_existente;
            //formularioDetalle.det_cantidad_lote.value = data[0].det_cantidad_lote;

            // Actualizar los valores iniciales después de la búsqueda
            valorInicialCantidadExistente = parseFloat(data[0].det_cantidad_existente) || 0;
            //valorInicialCantidadLote = parseFloat(data[0].det_cantidad_lote) || 0;

        } else {
            // Si no se encontraron registros, establecer los inputs en 0
            formularioDetalle.det_cantidad_existente.value = 0;
            //formularioDetalle.det_cantidad_lote.value = 0;

            // Si no se encontraron registros, los valores iniciales serán 0
            valorInicialCantidadExistente = 0;
            //valorInicialCantidadLote = 0;



            // Toast.fire({
            //     title: 'No se encontraron registros',
            //     icon: 'info'
            // });
        }

    } catch (error) {
        console.log(error);
    }


};


const guardarDetalle = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formularioDetalle, ['det_id', 'det_lote'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formularioDetalle)
    body.delete('det_id')
    //  const url = '/control_inventario/API/movimiento/guardarDetalle';
    const url = '/control_inventario/API/movimiento/guardarDetalle';

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
                formularioDetalle.reset();
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

        if (!error.response || !error.response.ok) {
            console.log('Error de red o servidor:', error.message);
            return;
        }

        console.log('Respuesta completa:', await error.text());

        //console.log('Respuesta completa:', error.response);
    }
    //buscar();
    //buscarProducto();
};



buscarAlmacenes();
buscarAlmacenesEgreso();
buscarDependencia();
buscarEstados();
//buscarAlmacenesEgreso();

////////eventos/////////////////////////////////////
mov_perso_entrega.addEventListener('input', buscarOficiales);
mov_perso_recibe.addEventListener('input', buscarOficialesRecibe);
mov_perso_respon.addEventListener('input', buscarOficialesResponsable);
btnBuscarExistencias.addEventListener('click', buscarExistencias);
formulario.addEventListener('submit', guardar);
formularioDetalle.addEventListener('submit', guardarDetalle);

  
    btnSiguiente.addEventListener('click', function(event) {
        // Prevenir el envío normal del formulario
        event.preventDefault();


        // Ocultar el formulario de movimiento
        movMovimientoDiv.style.display = 'none';

        // Mostrar el formulario de detalle
        movDetalleDiv.style.display = 'block';
    });

    // Agrega un oyente de eventos al botón "Anterior" del formulario de detalle
    btnAnterior.addEventListener('click', function(event) {
        // Prevenir el envío normal del formulario
        event.preventDefault();



        // Ocultar el formulario de detalle
        movDetalleDiv.style.display = 'none';

        // Mostrar el formulario de movimiento
        movMovimientoDiv.style.display = 'block';
    });


//EVENTOS PARA BUSCAR LA CANTIDAD EXISTENTE

detProIdSelect.addEventListener('input', buscarCantidad);
detProIdSelect.addEventListener('input', buscarCantidadLote);
detLoteInput.addEventListener('input', buscarCantidadLote);
detEstadoSelect.addEventListener('input', buscarCantidadLote);

//buscarProducto();


// Almacenar los valores originales cuando la página se carga
let valorInicialCantidadExistente = parseFloat(detCantidadExistenteInput.value) || 0;
let valorInicialCantidadLote = parseFloat(detCantidadLoteInput.value) || 0;

// Función para actualizar la sumatoria
const actualizarSumatoria = () => {
    // Obtener el valor actual del campo det_cantidad
    const cantidad = parseFloat(detCantidadInput.value) || 0;

    // Verificar si el campo det_lote está vacío
    // if (detLoteInput.value.trim() === '') {
    //     // Si está vacío, solo hacer la suma en det_cantidad_existente
    //     const nuevaCantidadExistente = cantidad + valorInicialCantidadExistente;
    //     detCantidadExistenteInput.value = nuevaCantidadExistente.toFixed(2);

    //     // Restablecer el valor de det_cantidad_lote a su valor inicial
    //     detCantidadLoteInput.value = valorInicialCantidadLote.toFixed(2);
    // } else {
        // Si no está vacío, hacer la suma en ambos campos
      
        const nuevaCantidadLote = valorInicialCantidadLote - cantidad;
        const nuevaCantidadExistente = valorInicialCantidadExistente - cantidad;

        // Actualizar los campos con las nuevas sumas
        detCantidadLoteInput.value = nuevaCantidadLote.toFixed(2);
        detCantidadExistenteInput.value = nuevaCantidadExistente.toFixed(2);
    };
//};

// Escuchador de eventos 'input' al campo det_cantidad
detCantidadInput.addEventListener('input', actualizarSumatoria);

// Escuchador de eventos 'change' al campo det_cantidad
detCantidadInput.addEventListener('change', () => {
    // Obtener el valor actual del campo det_cantidad
    const cantidad = parseFloat(detCantidadInput.value) || 0;

    // Verificar si el campo det_lote está vacío
    //if (detLoteInput.value.trim() === '') {
        // Si está vacío, restablecer los valores a sus estados iniciales
        //detCantidadExistenteInput.value = valorInicialCantidadExistente.toFixed(2);
        //detCantidadLoteInput.value = valorInicialCantidadLote.toFixed(2);
    //}
});

checkboxLoteNo.addEventListener('change', function() {
    if (this.checked) {
        checkboxLoteSi.checked = false;
        detLoteInput.value = 'SIN/L';
    } else {
        detLoteInput.value = '';
    }
});

checkboxLoteSi.addEventListener('change', function() {
    if (this.checked) {
        checkboxLoteNo.checked = false; 
        detLoteInput.value = '';

    }
});



// Llamamos a la función inicial para configurar correctamente el estado inicial
actualizarSumatoria();

// Agrega un evento de clic al botón
botonVerIngresos.addEventListener('click', () => {
    // Abre el modal al hacer clic en el botón
    modalVerExistencias.classList.add('show');
    modalVerExistencias.style.display = 'block';
    document.body.classList.add('modal-open');
});

//////////evento para cerrar el modal haciendo clic

botonCerrarModal.addEventListener('click', function () {
    // Cierra el modal
    modalVerExistencias.style.display = 'none';
    document.body.classList.remove('modal-open');
    //formularioGuarda.reset();

});

////cerrar el modal cuando se hace clic fuera del modal...
modalVerExistencias.addEventListener('click', function (event) {
    if (event.target === asignarOficialModal) {
        asignarOficialModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        //buscarDependencia();
    }

});
