import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";
import { icon } from "leaflet";



////formulario busqueda////////////
const btnMovimiento = document.getElementById('btnMovimientos');
const formularioBusqueda = document.getElementById('formularioBusqueda');
const datosMovimiento = document.getElementById('DatosMovimiento')
const btnIngreso = document.getElementById('btnRealizarIngreso');
const divIngresoMovimiento = document.getElementById('movimiento_busqueda');
const btnRegresarGestion = document.getElementById('btnRegresarGestion');


////formulario movimiento//////////
const formulario = document.getElementById('formularioMovimiento');
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
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
const movMovimientoDiv = document.getElementById('mov_movimiento');
const divLote = document.getElementById('divLote');
let typingTimeout;

const select = document.getElementById('mov_tipo_trans');



const fechaInput = document.getElementById('mov_fecha');

const establecerFechaActual = () => {
    const fechaHoraActual = new Date();
    const formatoFecha = fechaHoraActual.toISOString().split('T')[0]; // Obtiene la parte de la fecha y la formatea
    fechaInput.value = formatoFecha;
};

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
const detUniSelect = document.getElementById('det_uni_med');
const detLoteInput = document.getElementById('det_lote');
const detFechaInput = document.getElementById('det_fecha_vence');
const detEstadoSelect = document.getElementById('det_estado');
const detCantidadInput = document.getElementById('det_cantidad');
const detCantidadExistenteInput = document.getElementById('det_cantidad_existente');
const detCantidadLoteInput = document.getElementById('det_cantidad_lote');
const fechaCampo = document.getElementById('fechaCampo');
const sinFecha = document.getElementById('sinFecha');
const sinFechaInput = document.getElementById('sin_fecha')

const det_mov_id = document.getElementById('det_mov_id');


const botonImprimir = document.getElementById('btnImprimir');
const botonVolverImprimir = document.getElementById('btnVolverImprimir');

//cont para el modal ver existencias de insumos por almacen 
const btnVerExistenciasInventario = document.getElementById('btnVerExistenciasPorAlmacenModal');
const btnBuscarInventarioExistencias = document.getElementById('btnBuscarExistenciasPorInventario');
const modalExistenciasPorInventario = document.getElementById('ExistenciasInventario');
const cerrarModalExistenciasPorInventario = document.getElementById('btnCerrarModalExistenciasPorInventario');
const formularioExistenciasPorInventario = document.getElementById('formularioExistenciasInventario');


//////formulario existencias//////////////////
const formularioExistencia = document.getElementById('formularioExistencia');
const mov_alma = document.getElementById('mov_alma');
const btnBuscarExistencias = document.getElementById('btnBuscarExistencias');

// ////PARA MANEJAR EL CKECK BOX DE SI Y NO DE LOTE 

const checkboxLoteNo = document.getElementById('tiene_lote_no');
const checkboxLoteSi = document.getElementById('tiene_lote_si');

///////////// para el modal///////

const botonRetirarMas = document.getElementById('btnRetirarMas');
const modalVerExistencias = document.getElementById('verExistencias');
const modalIngresoDetalle = document.getElementById('IngresoDetalle');
const botonCerrarModal = document.getElementById('botonCerrarModalExistencias');
const botonCerrarModalIngresoDetalle = document.getElementById('botonCerrarIngresoDetalleModal');
const formularioModal = document.getElementById('formularioExistencia');

let almaSeleccionadoId;
let IdMovimiento;

// se definen como arrays vacios para utilizarlos despues 
let producto = [];
let medida = [];
let estado = [];
let almacenes = [];
let dependencias = [];

// Oculta el elemento div card formulario detalle
movDetalleDiv.style.display = "none";
movMovimientoDiv.style.display = "none";
sinFecha.style.display = "none";

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
            data: 'pro_id'

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
            title: 'Unidad de medida',
            data: 'det_uni_med'
        },
        {
            title: 'Producto',
            data: 'pro_nom_articulo'
        },
        {
            title: 'Medida',
            data: 'uni_nombre'
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
            data: 'det_fecha_vence',
            render: function (data) {
                // Verifica si la fecha es '7/05/1999' y muestra 'Sin fecha de vencimiento'
                return (data === '1999-05-07') ? 'Sin fecha de vencimiento' : data;
            }
        },
        {
            title: 'Cantidad Existente Por lote',
            data: 'det_cantidad_lote'
        },
        {
            title: 'RETIRAR DEL INVENTARIO',
            data: 'det_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning"  data-proid='${row["pro_id"]}' data-producto='${row["det_pro_id"]}' data-lote='${row["det_lote"]}' data-estado='${row["det_estado"]}' data-fecha='${row["det_fecha_vence"]}' data-medida='${row["det_uni_med"]}'>Retirar</button>`
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
            targets: [1, 2, 3, 4, 12],
            visible: false,
            width: 0,
            searchable: false,

        }

    ]
});


//// PARA TRAER LOS DATOS 
const traeDatos = (e) => {
    const button = e.target;
    const producto = button.dataset.producto;
    const lote = button.dataset.lote;
    const estado = button.dataset.estado;
    const fecha = button.dataset.fecha;
    const medida = button.dataset.medida;

    if (fecha === '1999-05-07') {
        // Si la fecha de vencimiento es '1999-05-7', se oculta el campo fecha y muestra sinFecha
        fechaCampo.style.display = 'none';
        sinFecha.style.display = 'block';
    } else {
        // Si la fecha de vencimiento no es '1999-05-7', se muestra campo fecha y oculta sinFecha
        fechaCampo.style.display = 'block';
        sinFecha.style.display = 'none';

    }

    const dataset = {
        det_pro_id: producto,
        det_lote: lote,
        det_estado: estado,
        det_fecha_vence: fecha,
        det_uni_med: medida,


    };
    console.log('Datos en traeDatos:', dataset);
    colocarDatos(dataset);
    modalVerExistencias.style.display = 'none';
    document.body.classList.remove('modal-open');
    // Mostrar el formulario de detalle
    movDetalleDiv.style.display = 'block';
    // Ocultar el formulario de movimiento
    movMovimientoDiv.style.display = 'none';
    //buscar por cantidad y lote
    divLote.style.display = 'none'
    buscarCantidad();
    buscarCantidadLote();
    datatable.clear().draw();
    formularioExistencia.reset();

};

const colocarDatos = (dataset) => {
    console.log('Datos en colocarDatos:', dataset);

    formularioDetalle.det_pro_id.value = dataset.det_pro_id;
    formularioDetalle.det_lote.value = dataset.det_lote;
    formularioDetalle.det_estado.value = dataset.det_estado;
    formularioDetalle.det_uni_med.value = dataset.det_uni_med;
    formularioDetalle.det_fecha_vence.value = dataset.det_fecha_vence;


};

const cancelarAccion = () => {
    formularioDetalle.reset();
    btnGuardar.disabled = false;
    btnGuardar.parentElement.style.display = '';
    btnBuscar.disabled = false;
    btnBuscar.parentElement.style.display = '';
    btnModificar.disabled = true;
    btnModificar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
};



// /////////datatable para mostrar el detalle de ingreso al inventario/////////

// //////////DATATABLE//////////////////////////////////////////////////////

let contadorDetalle = 1;

const datatableDetalle = new Datatable('#tablaDetalles', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contadorDetalle++
        },
        {
            title: 'ID',
            data: 'det_id'
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
            title: 'Estado del insumo',
            data: 'det_uni_med'
        },
        {
            title: 'Producto',
            data: 'pro_nom_articulo'
        },
        {
            title: 'Medida',
            data: 'uni_nombre'
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
            data: 'det_fecha_vence',
            render: function (data) {
                // Verifica si la fecha es '7/05/1999' y muestra 'Sin fecha de vencimiento'
                return (data === '1999-05-07') ? 'Sin fecha de vencimiento' : data;
            }
        },
        {
            title: 'Cantidad Retirada',
            data: 'det_cantidad'
        },
        {
            title: 'Cantidad Existente Por lote',
            data: 'det_cantidad_lote'
        },
        {
            title: 'Observaciones',
            data: 'det_observaciones'
        },
        {
            title: 'EDITAR DETALLE',
            data: 'det_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${row["det_id"]}'data-producto='${row["det_pro_id"]}' data-lote='${row["det_lote"]}' data-estado='${row["det_estado"]}' data-fecha='${row["det_fecha_vence"]}' data-medida='${row["det_uni_med"]}' data-cantidad='${row["det_cantidad"]}' data-observaciones='${row["det_observaciones"]}'>Editar</button>`
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
            targets: [1, 2, 3, 4],
            visible: false,
            searchable: false,

        }

    ]
});

//// PARA TRAER LOS DATOS 
const traeDatosDetalle = (e) => {
    const button = e.target;
    const producto = button.dataset.producto;
    const lote = button.dataset.lote;
    const estado = button.dataset.estado;
    const fecha = button.dataset.fecha;
    const medida = button.dataset.medida;
    const observaciones = button.dataset.observaciones;
    const cantidad = button.dataset.cantidad;
    const id = button.dataset.id

    if (lote === 'SIN/L') {

        checkboxLoteSi.checked = false;
        checkboxLoteNo.checked = true;

    } else {
        checkboxLoteNo.checked = false;
        checkboxLoteSi.checked = true;
    }

    if (fecha === '1999-05-07') {
        checkboxFechaSi.checked = false;
        checkboxFechaNo.checked = true;
    } else {
        checkboxFechaNo.checked = false;
        checkboxFechaSi.checked = true;
    }

    const dataset = {
        det_pro_id: producto,
        det_lote: lote,
        det_estado: estado,
        det_fecha_vence: fecha,
        det_uni_med: medida,
        det_observaciones: observaciones,
        det_cantidad: cantidad,
        det_id: id,
    };
    console.log('Datos en traeDatos:', dataset);
    colocarDatosDetalle(dataset);
    buscarCantidad();
    buscarCantidadLote();
 
};

const colocarDatosDetalle = (dataset) => {
    console.log('Datos en colocarDatos:', dataset);

    formularioDetalle.det_pro_id.value = dataset.det_pro_id;
    formularioDetalle.det_lote.value = dataset.det_lote;
    formularioDetalle.det_estado.value = dataset.det_estado;
    formularioDetalle.det_uni_med.value = dataset.det_uni_med;
    formularioDetalle.det_fecha_vence.value = dataset.det_fecha_vence;
    formularioDetalle.det_observaciones.value = dataset.det_observaciones;
    formularioDetalle.det_cantidad.value = dataset.det_cantidad;
    formularioDetalle.det_id.value = dataset.det_id;


    btnGuardarDetalle.disabled = true;
    btnGuardarDetalle.parentElement.style.display = 'none';
    btnModificarDetalle.disabled = false;
    btnModificarDetalle.parentElement.style.display = '';
    btnCancelarDetalle.disabled = false;
    btnCancelarDetalle.parentElement.style.display = '';
};

const cancelarAccionDetalle = () => {
    formularioDetalle.reset();
    btnGuardarDetalle.disabled = false;
    btnGuardarDetalle.parentElement.style.display = '';
    btnModificarDetalle.disabled = true;
    btnModificarDetalle.parentElement.style.display = 'none';
    btnCancelarDetalle.disabled = true;
    btnCancelarDetalle.parentElement.style.display = 'none';
    campoLote.style.display = "none";
    fechaCampo.style.display = "none";
};




let contadorMovimiento;

const datatableMovimiento = new Datatable('#tablaMovimientos', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contadorMovimiento++
        },
        // Columnas del movimiento
        {
            title: 'ID MOVIMIENTO',
            data: 'mov_id',
        },
        {
            title: 'ID del inventario',
            data: 'mov_alma_id'
        },
        {
            title: 'ID del inventario',
            data: 'mov_tipo_mov'
        },
        {
            title: 'Persona que Entregó',
            data: 'mov_perso_entrega'
        },
        {
            title: 'Persona que Recibio',
            data: 'mov_perso_recibe'
        },
        {
            title: 'Persona Responsable',
            data: 'mov_perso_respon'
        },
        {
            title: 'Procedencia o destino',
            data: 'mov_proce_destino'
        },
        {
            title: 'Inventario del que Egreso',
            data: 'alma_nombre'
        },
        {
            title: 'Datos de quien Entregó',
            data: 'mov_perso_entrega_nom'
        },
        {
            title: 'Datos de quien Recibio',
            data: 'mov_perso_recibe_nom'
        },
        {
            title: 'Datos del Responsable',
            data: 'mov_perso_respon_nom'
        },
        {
            title: 'Fecha de Egreso',
            data: 'mov_fecha'
        },
        {
            title: 'Tipo de transaccion',
            data: 'mov_tipo_trans',
            render: function (data) {
                return (data === 'I') ? 'EGRESO INTERNO' : (data === 'E') ? 'EGRESO EXTERNO' : data;
            }
        },
        {
            title: 'Destino',
            data: 'dep_desc_md'
        },
        {
            title: 'Estado del Ingreso',
            'render': function (data, type, row) {
                if (row.mov_situacion == '1') {
                    return '<div class="estado-pendiente">EGRESO PENDIENTE</div>';
                } else if (row.mov_situacion == '2') {
                    return '<div class="estado-ingresado">EGRESADO</div>';
                } else {
                    return data;
                }
            }
        },
        {
            title: 'FINALIZAR EGRESO',
            data: 'mov_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                if (row.mov_situacion == '2') {
                    return '';
                }
                return `<button class="btn btn-success" data-id='${data}' data-almacen='${row["mov_alma_id"]}'>Continuar Egreso</button>`;
            }
        },
        {
            title: 'VER DETALLES DE ESTE INGRESO',
            data: 'mov_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-info" data-id='${data}'>Ver Detalles de Este Egreso</button>`
        },
    ],
    columnDefs: [
        {
            targets: [1, 2, 3, 4, 5, 6, 7],
            visible: false,
            searchable: false,

        }
    ]

});


//// PARA TRAER LOS DATOS 
const traeDatosVerDetalle = (e) => {
    const button = e.target;
    const id = button.dataset.id;

    const dataset = {
        det_mov_id: id,
    };
    console.log('Datos en traeDatos:', dataset);
    colocarDatosVerDetalle(dataset);
    botonVolverImprimir.value = dataset.det_mov_id;
    modalIngresoDetalle.classList.add('show');
    modalIngresoDetalle.style.display = 'block';


};

const colocarDatosVerDetalle = (dataset) => {
    console.log('Datos en colocarDatos:', dataset);
    IdMovimiento = dataset.det_mov_id;
    buscarDetallePorIngreso();

};

//// PARA TRAER LOS DATOS 
const traeDatosFinalizacion = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const almacen = button.dataset.almacen

    const dataset = {
        det_mov_id: id,
        mov_alma_id: almacen,
    };
    console.log('Datos en traeDatos:', dataset);
    colocarDatosFinalizacion(dataset);
    modalVerExistencias.classList.add('show');
    modalVerExistencias.style.display = 'block';
    movDetalleDiv.style.display = 'block';
    movMovimientoDiv.style.display = 'none';
    divIngresoMovimiento.style.display = 'none';
    datosMovimiento.style.display = 'none';
};

const colocarDatosFinalizacion = (dataset) => {
    console.log('Datos en colocarDatos:', dataset);
    formularioDetalle.det_mov_id.value = dataset.det_mov_id;
    formularioMovimiento.mov_alma_id.value = dataset.mov_alma_id;
    almaSeleccionadoId = dataset.mov_alma_id;
    buscarProducto();
    buscarUnidades();
    buscarProductoDetalle();
};


const cancelarAccionFinalizacion = () => {
    formularioDetalle.reset();
    movDetalleDiv.style.display = 'none';
    movMovimientoDiv.style.display = 'none';
    divIngresoMovimiento.style.display = 'block';
    datosMovimiento.style.display = 'block';
};

//////////DATATABLE//////////////////////////////////////////////////////

let contadorEgresoDetalle = 1;

const datatableEgresoDetalle = new Datatable('#tablaEgresoDetalle', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contadorEgresoDetalle++
        },

        {
            title: 'ID',
            data: 'det_id'
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
            title: 'Tipo de transaccion',
            data: 'mov_tipo_trans',
            render: function (data) {
                return (data === 'I') ? 'EGRESO INTERNO' : (data === 'E') ? 'EGRESO EXTERNO' : data;
            }
        },
        {
            title: 'Producto',
            data: 'pro_nom_articulo'
        },
        {
            title: 'Medida',
            data: 'uni_nombre'
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
            data: 'det_fecha_vence',
            render: function (data) {
                // Verifica si la fecha es '7/05/1999' y muestra 'Sin fecha de vencimiento'
                return (data === '1999-05-07') ? 'Sin fecha de vencimiento' : data;
            }
        },
        {
            title: 'Cantidad que egreso',
            data: 'det_cantidad'
        },
        {
            title: 'Cantidad Existente Por lote',
            data: 'det_cantidad_lote'
        },

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




//////////DATATABLE PARA MOSTRAR LAS EXISTENCIAS POR INVENTARIO//////////////////////////////////////////////////////

let contadorExistenciasPorInventario = 1;


const datatableExistenciasPorInventario = new Datatable('#tablaExistenciasPorInventario', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contadorExistenciasPorInventario++
        },
        {
            title: 'Producto',
            data: 'pro_id'

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
            title: 'Unidad de medida',
            data: 'det_uni_med'
        },
        {
            title: 'Producto',
            data: 'pro_nom_articulo'
        },
        {
            title: 'Medida',
            data: 'uni_nombre'
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
            data: 'det_fecha_vence',
            render: function (data) {
                // Verifica si la fecha es '7/05/1999' y muestra 'Sin fecha de vencimiento'
                return (data === '1999-05-07') ? 'Sin fecha de vencimiento' : data;
            }
        },
        {
            title: 'Cantidad Existente Por lote',
            data: 'det_cantidad_lote'
        },

    ],
    columnDefs: [
        {
            targets: [1, 2, 3, 4],
            visible: false,
            width: 0,
            searchable: false,

        }

    ]
});


////funcion para cambiar de situacion un detalle

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const det_id = document.getElementById('det_id');
    const valor = det_id.value;




    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData();
        body.append('det_id', id);
        const url = '/control_inventario/API/movimiento/eliminar';
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
                    buscarDetalleMovimiento();
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
    buscarDetalleMovimiento();


};


/// PARA buscar el DETALLE DE INSUMOS EGRESADOS por egreso

const buscarDetallePorIngreso = async () => {


    const url = `/control_inventario/API/movimiento/buscarDetallePorIngreso?IdMovimiento=${IdMovimiento}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data)

        datatableEgresoDetalle.clear().draw();
        if (data) {
            contadorEgresoDetalle = 1;
            datatableEgresoDetalle.rows.add(data).draw();
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

// Para buscar los detalles de los egresos 

const buscarDetalleMovimiento = async () => {
    let det_mov_id = formularioDetalle.det_mov_id.value;

    const url = `/control_inventario/API/movimiento/buscarDetalleMovimiento?det_mov_id=${det_mov_id}`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        datatableDetalle.clear().draw();
        if (data && data.length > 0) {
            contadorDetalle = 1;
            datatableDetalle.rows.add(data).draw();

        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
};

// para buscar los movimientos de los egresos

const buscarDetalleIngresado = async () => {
    let det_mov_id = formularioDetalle.det_mov_id.value;

    const url = `/control_inventario/API/movimiento/buscarDetalleIngresado?det_mov_id=${det_mov_id}`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        datatableMovimiento.clear().draw();
        if (data) {
            contadorMovimiento = 1;
            datatableMovimiento.rows.add(data).draw();

        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
    // 
};



//////////para buscar oficiales y llenar el campo de la persona que entrega////////

const buscarOficiales = async () => {
    let mov_perso_entrega = formulario.mov_perso_entrega.value;
    clearTimeout(typingTimeout);


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

    typingTimeout = setTimeout(fetchData, 1200);

};


//////////para buscar oficiales y llenar el campo de la persona que recibe////////

const buscarOficialesRecibe = async () => {
    let mov_perso_recibe = formulario.mov_perso_recibe.value;
    clearTimeout(typingTimeout);

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
    typingTimeout = setTimeout(fetchData, 1200);

};


//////////para buscar oficiales y llenar el campo de la persona que entrega////////

const buscarOficialesResponsable = async () => {
    let mov_perso_respon = formulario.mov_perso_respon.value;
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

        formulario.mov_alma_id.innerHTML = '';


        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formulario.mov_alma_id.appendChild(defaultOption);

        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formulario.mov_alma_id.appendChild(option);
        });



    } catch (error) {
        console.log(error);
    }

};



const buscarAlmacenesInventario = async () => {

    if (formularioExistenciasPorInventario.alma_nombre && formularioExistenciasPorInventario.alma_id) {
        let alma_nombre = formularioExistenciasPorInventario.alma_nombre.value;
        let alma_id = formularioExistenciasPorInventario.alma_id.value;
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

        formularioExistenciasPorInventario.mov_almacen.innerHTML = '';


        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioExistenciasPorInventario.mov_almacen.appendChild(defaultOption);

        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formularioExistenciasPorInventario.mov_almacen.appendChild(option);
        });

    } catch (error) {
        console.log(error);
    }

};




////////////// FUNCION PARA BUSCAR LOS ELEMENTOS GUARDADOS

const buscarExistenciasPorInventario = async () => {

    let mov_almacen = formularioExistenciasPorInventario.mov_almacen.value;

    const url = `/control_inventario/API/movegreso/buscarExistenciasPorInventario?mov_almacen=${mov_almacen}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        datatableExistenciasPorInventario.clear().draw();
        if (data) {
            contadorExistenciasPorInventario = 1;
            datatableExistenciasPorInventario.rows.add(data).draw();
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

const buscarDependencia = async () => {

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
        console.log('data de dependencias', data);

        dependencias = data;

        formulario.mov_proce_destino.innerHTML = '';


        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formulario.mov_proce_destino.appendChild(defaultOption);

        data.forEach(dependencias => {
            const option = document.createElement('option');
            option.value = dependencias.dep_llave;
            option.textContent = dependencias.dep_desc_md;
            formulario.mov_proce_destino.appendChild(option);
        });


    } catch (error) {
        console.log(error);
    }

};



const buscarEstados = async () => {

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
        console.log('data de estados', data);

        estado = data;

        formularioDetalle.det_estado.innerHTML = '';


        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioDetalle.det_estado.appendChild(defaultOption);

        data.forEach(estado => {
            const option = document.createElement('option');
            option.value = estado.est_id;
            option.textContent = estado.est_descripcion;
            formularioDetalle.det_estado.appendChild(option);
        });

    } catch (error) {
        console.log(error);
    }

};


/////////////////////////////almacenar el id//////////////////////////////////////
// Agregar evento al cambio del select para almacenar el ID del almacén
formulario.mov_alma_id.addEventListener('change', function () {

    almaSeleccionadoId = this.value;

    console.log('Alma ID seleccionado:', almaSeleccionadoId);

    buscarProducto();
    buscarProductoDetalle();
    buscarUnidades();
});


////////////////buscar producto de acuerdo al id del almacen seleccionado/////////////////////////////

const buscarProducto = async () => {

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
        console.log('data de productos', data);

        producto = data;

        formularioExistencia.det_pro.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioExistencia.det_pro.appendChild(defaultOption);

        data.forEach(producto => {
            const option = document.createElement('option');
            option.value = producto.pro_id;
            option.textContent = producto.pro_nom_articulo;
            formularioExistencia.det_pro.appendChild(option);
        });


    } catch (error) {
        console.log(error);
    }
    formularioExistencia.reset();
};

/// buscar unidades de acuerdo al id del almacen seleccionado

const buscarUnidades = async () => {

    if (formularioDetalle.uni_nombre && formularioDetalle.uni_id) {
        let uni_nombre = formularioDetalle.uni_nombre.value;
        let uni_id = formularioDetalle.uni_id.value;
    }
    const url = `/control_inventario/API/movimiento/buscarUnidades?almaSeleccionadoId=${almaSeleccionadoId}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de medidas', data);

        medida = data;

        formularioDetalle.det_uni_med.innerHTML = '';


        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioDetalle.det_uni_med.appendChild(defaultOption);

        data.forEach(medida => {
            const option = document.createElement('option');
            option.value = medida.uni_id;
            option.textContent = medida.uni_nombre;
            formularioDetalle.det_uni_med.appendChild(option);
        });

    } catch (error) {
        console.log(error);
    }

};

const buscarProductoDetalle = async () => {

    if (formularioDetalle.pro_nom_articulo && formularioDetalle.pro_id) {
        let pro_nom_articulo = formularioDetalle.pro_nom_articulo.value;
        let pro_id = formularioDetalle.pro_id.value;
    }

    const url = `/control_inventario/API/movimiento/buscarProducto?almaSeleccionadoId=${almaSeleccionadoId}`;
    const config = {
        method: 'GET'
    };

    console.log(data)

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de productos', data);

        producto = data;

        formularioDetalle.det_pro_id.innerHTML = '';


        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioDetalle.det_pro_id.appendChild(defaultOption);

        data.forEach(producto => {
            const option = document.createElement('option');
            option.value = producto.pro_id;
            option.textContent = producto.pro_nom_articulo;
            formularioDetalle.det_pro_id.appendChild(option);
        });


    } catch (error) {
        console.log(error);
    }

};



////////////// FUNCION PARA BUSCAR LOS ELEMENTOS GUARDADOS

const buscarExistencias = async () => {

    let det_pro = formularioExistencia.det_pro.value;

    const url = `/control_inventario/API/movegreso/buscarExistencias?det_pro=${det_pro}`;
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

};



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
                buscarProducto();
                modalVerExistencias.classList.add('show');
                modalVerExistencias.style.display = 'block';
                document.body.classList.add('modal-open');
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
    buscarDetalleIngresado();

}




//////////////////////////////////////////////
////buscar cantidad existentes por lotes y cantidad existentes del formulario detalle//////


const buscarCantidadLote = async () => {


    let det_pro_id = detProIdSelect.value;
    let det_uni_med = detUniSelect.value;
    let det_lote = detLoteInput.value;
    let det_estado = detEstadoSelect.value;
    let det_fecha_vence = detFechaInput.value;


    const url = `/control_inventario/API/movimiento/buscarCantidadLote?det_pro_id=${det_pro_id}&det_uni_med=${det_uni_med}&det_lote=${det_lote}&det_estado=${det_estado}&det_fecha_vence=${det_fecha_vence}`;


    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);


        if (data && data.length > 0) {

            formularioDetalle.det_cantidad_lote.value = data[0].det_cantidad_lote;

            valorInicialCantidadLote = parseFloat(data[0].det_cantidad_lote) || 0;

        } else {

            formularioDetalle.det_cantidad_lote.value = 0;

            valorInicialCantidadLote = 0;

        }

    } catch (error) {
        console.log(error);
    }

};

/// funcion para buscar la cantidad existente 

const buscarCantidad = async () => {


    let det_pro_id = detProIdSelect.value;
    let det_uni_med = detUniSelect.value;


    const url = `/control_inventario/API/movimiento/buscarCantidad?det_pro_id=${det_pro_id}&det_uni_med=${det_uni_med}`;


    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);


        if (data && data.length > 0) {
            // se asignan los valores a los inputs
            formularioDetalle.det_cantidad_existente.value = data[0].det_cantidad_existente;

            valorInicialCantidadExistente = parseFloat(data[0].det_cantidad_existente) || 0;


        } else {

            formularioDetalle.det_cantidad_existente.value = 0;

            valorInicialCantidadExistente = 0;

        }

    } catch (error) {
        console.log(error);
    }


};

/// funcion para guardar el detalle del egreso

const guardarDetalle = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formularioDetalle, ['det_id', 'det_lote', 'sin_fecha'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }

    const detMovIdValue = document.getElementById('det_mov_id').value;
    const body = new FormData(formularioDetalle)
    body.delete('det_id')

    const url = '/control_inventario/API/movimiento/guardarDetalle';

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
                formularioDetalle.reset();
                icon = 'success'
                // Restaura el valor del campo det_mov_id
                document.getElementById('det_mov_id').value = detMovIdValue;
                buscarDetalleMovimiento();
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
    }
    buscarDetalleMovimiento();

};

//funcion para buscar si seleccionan egreso interno

const buscarDependenciaInterna = async () => {

    if (formulario.dep_desc_md && formulario.dep_llave) {
        let dep_desc_md = formulario.dep_desc_md.value;
        let dep_llave = formulario.dep_llave.value;
    }
    const url = `/control_inventario/API/movimiento/buscarDependenciaInterna`;
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

        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(dependencias => {
            const option = document.createElement('option');
            option.value = dependencias.dep_llave;
            option.textContent = dependencias.dep_desc_md;
            formularioMovimiento.mov_proce_destino.appendChild(option);
        });

    } catch (error) {
        console.log(error);
    }

};

/// para llamar a las funciones de acuerdo a si seleccionan Egreso Interno y Egreso Externo

function mostrarDependencia() {
    if (select.value === "I") {

        buscarDependenciaInterna();
    } else if (select.value === "E") {

        buscarDependencia();
    } else {

    }
}

//////////////función buscar para imprimir recibo

const buscarRecibo = async () => {
    let det_mov_id = formularioDetalle.det_mov_id.value;

    const url = `/control_inventario/API/egresoreporte/buscarRecibo?det_mov_id=${det_mov_id}`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        if (data && data.length > 0) {
            generarPDF(data);
            modificar();
            divIngresoMovimiento.style.display = 'block';
            movMovimientoDiv.style.display = 'none';
            datosMovimiento.style.display = 'block';
            movDetalleDiv.style.display = 'none';
            datatableMovimiento.clear().draw();
            formularioDetalle.reset();
            formularioMovimiento.reset();
            datatableDetalle.clear().draw();


        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
};

//funcion para volver imprimir el recibo desde la dt detalle por ingreso

const buscarRecibo2 = async () => {
    let det_mov_id = botonVolverImprimir.value;
    console.log('Valor del botón al iniciar buscarRecibo2:', det_mov_id);


    const url = `/control_inventario/API/egresoreporte/buscarRecibo2?det_mov_id=${det_mov_id}`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        if (data && data.length > 0) {
            generarPDF(data);


        } else {
            Toast.fire({
                title: 'No se encontraron registros ',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
};

////////////////generar pdf para entregar hoja de responsabilidad/////////////

const generarPDF = async (datos) => {
    const url = `/control_inventario/egresoreporte/generarPDF`;

    const config = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos),
    };

    try {
        const respuesta = await fetch(url, config);

        if (respuesta.ok) {
            const blob = await respuesta.blob();

            if (blob) {
                const urlBlob = window.URL.createObjectURL(blob);

                // Abre el PDF en una nueva  pestaña
                window.open(urlBlob, '_blank');
            } else {
                console.error('No se pudo obtener el blob del PDF.');
            }
        } else {
            console.error('Error al generar el PDF.');
        }
    } catch (error) {
        console.error(error);
    }
};




///////////funciones para el formulario de busqueda de ingresos

////para buscar almacenes en el modal/////////////

const buscarAlmacenesMovimientos = async () => {

    if (formularioBusqueda.alma_nombre && formularioBusqueda.alma_id) {
        let alma_nombre = formularioBusqueda.alma_nombre.value;
        let alma_id = formularioBusqueda.alma_id.value;
    }
    const url = `/control_inventario/API/movimiento/buscarAlmacenesMovimientos`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); // Imprimir datos en la consola

        almacenes = data;

        formularioBusqueda.mov_alma.innerHTML = '';


        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioBusqueda.mov_alma.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formularioBusqueda.mov_alma.appendChild(option);
        });


    } catch (error) {
        console.log(error);
    }

};

//////////////función buscar para imprimir recibo

const buscarMovimientos = async () => {
    let mov_alma = formularioBusqueda.mov_alma.value;

    const url = `/control_inventario/API/movegreso/buscarMovimientos?mov_alma=${mov_alma}`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        datatableMovimiento.clear().draw();
        if (data) {
            contadorMovimiento = 1;
            datatableMovimiento.rows.add(data).draw();

        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
};



// funcion para modificar un estado

const modificar = async () => {

    let det_mov_id = formularioDetalle.det_mov_id.value;

    const body = new FormData();
    body.append('mov_id', det_mov_id);
    const url = '/control_inventario/API/movimiento/modificar';
    const config = {
        method: 'POST',
        body
    };
    try {

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data)
        let icon = 'info'

        const { codigo, mensaje, detalle } = data;

        switch (codigo) {
            case 1:

                break;
            case 0:
                icon = 'error';
                console.log(detalle);
                break;
            default:
                break;
        }
        Swal.fire({
            title: '¡Proceso Completado!',
            text: 'Finalizó con éxito el proceso de ingreso al inventario. Su PDF se generará en un momento.',
            icon: 'success',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#3085d6',
            timer: 8000,
            timerProgressBar: true,
        });
    } catch (error) {
        console.log(error);
    }

};



buscarAlmacenes();
buscarAlmacenesMovimientos();
buscarAlmacenesInventario();

buscarEstados();
establecerFechaActual();



////////eventos/////////////////////////////////////
//imprimir
botonImprimir.addEventListener('click', buscarRecibo);
botonVolverImprimir.addEventListener('click', buscarRecibo2);
//formulario movimiento
mov_perso_entrega.addEventListener('input', buscarOficiales);
mov_perso_recibe.addEventListener('input', buscarOficialesRecibe);
mov_perso_respon.addEventListener('input', buscarOficialesResponsable);
btnBuscarExistencias.addEventListener('click', buscarExistencias);
btnMovimiento.addEventListener('click', buscarMovimientos);
formulario.addEventListener('submit', guardar);
formularioDetalle.addEventListener('submit', guardarDetalle);
select.addEventListener('change', mostrarDependencia);
datatableMovimiento.on('click', '.btn-success', traeDatosFinalizacion);
datatableMovimiento.on('click', '.btn-info', traeDatosVerDetalle);
btnBuscarInventarioExistencias.addEventListener('click', buscarExistenciasPorInventario);



det_mov_id.addEventListener('input', buscarDetalleMovimiento);


btnIngreso.addEventListener('click', function () {
    divIngresoMovimiento.style.display = 'none';
    datosMovimiento.style.display = 'none';
    movMovimientoDiv.style.display = 'block';
});



btnRegresarGestion.addEventListener('click', function () {
    divIngresoMovimiento.style.display = 'block';
    movMovimientoDiv.style.display = 'none';
    datosMovimiento.style.display = 'block';

})


// Agrega un oyente de eventos al botón "Anterior" del formulario de detalle
btnAnterior.addEventListener('click', function () {
    divIngresoMovimiento.style.display = 'block';
    movMovimientoDiv.style.display = 'none';
    datosMovimiento.style.display = 'block';
    movDetalleDiv.style.display = 'none';
    formularioDetalle.reset();
    formularioMovimiento.reset();
    datatableDetalle.clear().draw();
    
});


//EVENTOS PARA BUSCAR LA CANTIDAD EXISTENTE

detProIdSelect.addEventListener('input', buscarCantidad);
detUniSelect.addEventListener('input', buscarCantidad);
detProIdSelect.addEventListener('input', buscarCantidadLote);
detUniSelect.addEventListener('input', buscarCantidadLote);
detLoteInput.addEventListener('input', buscarCantidadLote);
detEstadoSelect.addEventListener('input', buscarCantidadLote);
datatable.on('click', '.btn-warning', traeDatos);

//////para realizar la resta en los campos det_cantidad.///////////////

// Almacenar los valores originales cuando la página se carga
let valorInicialCantidadExistente = parseFloat(detCantidadExistenteInput.value) || 0;
let valorInicialCantidadLote = parseFloat(detCantidadLoteInput.value) || 0;

// Función para actualizar la sumatoria
const actualizarSumatoria = () => {
    // Obtener el valor actual del campo det_cantidad
    const cantidad = parseFloat(detCantidadInput.value) || 0;

    // Validar que la cantidad ingresada no sea mayor que la cantidad existente y la cantidad por lote
    if (cantidad > valorInicialCantidadExistente || cantidad > valorInicialCantidadLote) {

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La cantidad ingresada no puede ser mayor que la cantidad existente o la cantidad por lote.'

        });
        // se coloca el campo detcantidad igual a vacio
        detCantidadInput.value = '';

    } else {

        const nuevaCantidadLote = valorInicialCantidadLote - cantidad;
        const nuevaCantidadExistente = valorInicialCantidadExistente - cantidad;

        // Actualizar los campos con las nuevas sumas
        detCantidadLoteInput.value = nuevaCantidadLote.toFixed(2);
        detCantidadExistenteInput.value = nuevaCantidadExistente.toFixed(2);
    };
}

// eventos 'input' al campo det_cantidad
detCantidadInput.addEventListener('change', actualizarSumatoria);

// eventos 'change' al campo det_cantidad
detCantidadInput.addEventListener('change', () => {
    // se obtiene el valor actual del campo det_cantidad
    const cantidad = parseFloat(detCantidadInput.value) || 0;

});

// Se llama a la funci[on] para configurar correctamente el estado inicial
actualizarSumatoria();


checkboxLoteNo.addEventListener('change', function () {
    if (this.checked) {
        checkboxLoteSi.checked = false;
        detLoteInput.value = 'SIN/L';
    } else {
        detLoteInput.value = '';
    }
});

checkboxLoteSi.addEventListener('change', function () {
    if (this.checked) {
        checkboxLoteNo.checked = false;
        detLoteInput.value = '';

    }
});




// Agrega un evento de clic al botón
botonRetirarMas.addEventListener('click', () => {
    modalVerExistencias.classList.add('show');
    modalVerExistencias.style.display = 'block';

});

btnVerExistenciasInventario.addEventListener('click', () => {

    modalExistenciasPorInventario.classList.add('show');
    modalExistenciasPorInventario.style.display = 'block';

});

////cerrar el modal cuando se hace clic fuera del modal...
modalExistenciasPorInventario.addEventListener('click', function (event) {
    if (event.target === modalExistenciasPorInventario) {
        modalExistenciasPorInventario.style.display = 'none';
        document.body.classList.remove('modal-open');
        datatableExistenciasPorInventario.clear().draw();


    }

});


// cerrar modal con el boton ...
cerrarModalExistenciasPorInventario.addEventListener('click', function () {

    modalExistenciasPorInventario.style.display = 'none';
    document.body.classList.remove('modal-open');
    datatableExistenciasPorInventario.clear().draw();


});

//////////evento para cerrar el modal haciendo clic

botonCerrarModal.addEventListener('click', function () {

    modalVerExistencias.style.display = 'none';
    document.body.classList.remove('modal-open');
    datatable.clear().draw();



});

////cerrar el modal cuando se hace clic fuera del modal...
modalVerExistencias.addEventListener('click', function (event) {
    if (event.target === modalVerExistencias) {
        modalVerExistencias.style.display = 'none';
        document.body.classList.remove('modal-open');
        datatable.clear().draw();


    }

});

// cerrar modal con el boton
botonCerrarModalIngresoDetalle.addEventListener('click', function () {
    modalIngresoDetalle.style.display = 'none';
    document.body.classList.remove('modal-open');
});


// cerral el modal cuando se da clic fuera de ...
modalIngresoDetalle.addEventListener('click', function (event) {
    if (event.target === modalIngresoDetalle) {
        modalIngresoDetalle.style.display = 'none';
        document.body.classList.remove('modal-open');
    }
});
