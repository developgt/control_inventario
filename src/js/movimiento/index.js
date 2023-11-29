import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";
import { icon } from "leaflet";


////formulario busqueda////////////
const btnMovimiento = document.getElementById('btnMovimientos');
const mov_alma = document.getElementById('mov_alma')
const formularioBusqueda = document.getElementById('formularioBusqueda');
const btnRegresarGestion = document.getElementById('btnRegresarGestion');


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
const select = document.getElementById('mov_tipo_trans');


let typingTimeout;

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
const detEstadoSelect = document.getElementById('det_estado');
const detCantidadInput = document.getElementById('det_cantidad');
const detFechaInput = document.getElementById('det_fecha_vence');
const detCantidadExistenteInput = document.getElementById('det_cantidad_existente');
const detCantidadLoteInput = document.getElementById('det_cantidad_lote');
const det_mov_id = document.getElementById('det_mov_id');

const campoLote = document.getElementById('campoLote');
const fechaCampo = document.getElementById('fechaCampo');

const botonImprimir = document.getElementById('btnImprimir');
const botonVolverImprimir = document.getElementById('btnVolverImprimir');


// ////PARA MANEJAR EL CKECK BOX DE SI Y NO DE LOTE 

const checkboxLoteNo = document.getElementById('tiene_lote_no');
const checkboxLoteSi = document.getElementById('tiene_lote_si');

const checkboxFechaNo = document.getElementById('tiene_fecha_no');
const checkboxFechaSi = document.getElementById('tiene_fecha_si')
// para el modal///////
const botonVerIngresos = document.getElementById('btnVerIngresos');
const modalVerExistencias = document.getElementById('verExistencias');
const botonCerrarModal = document.getElementById('cerrarModalExistencias');
const formularioModal = document.getElementById('formularioExistencia');
const btnBuscarExistencias = document.getElementById('btnBuscarExistencias');
const det_pro = document.getElementById('det_pro');
const datosMovimiento = document.getElementById('DatosMovimiento')
const btnIngreso = document.getElementById('btnRealizarIngreso');
const divIngresoMovimiento = document.getElementById('movimiento_busqueda');


//cont para el modal ver existencias de insumos por almacen 
const btnVerExistenciasInventario = document.getElementById('btnVerExistenciasPorAlmacenModal');
const btnBuscarInventarioExistencias = document.getElementById('btnBuscarExistenciasPorInventario');
const modalExistenciasPorInventario = document.getElementById('ExistenciasInventario');
const cerrarModalExistenciasPorInventario = document.getElementById('btnCerrarModalExistenciasPorInventario');
const formularioExistenciasPorInventario = document.getElementById('formularioExistenciasInventario');
const divImprimirExistencias = document.getElementById('divImprimirExistencias');
const btnImprimirExistencias = document.getElementById('btnImprimirExistencias');



let almaSeleccionId;
let IdMovimiento;
let almaSeleccionadoId;// para guardar el id del almacen seleccionado
// se definen como un array vacio para utilizarlos en las busquedas...
let estado = [];
let producto = [];
let almacenes = []; 
let dependencias = [];
let medida = [];


// Oculta el elemento div card formulario detalle
movDetalleDiv.style.display = "none";
movMovimientoDiv.style.display = "none";
campoLote.style.display = "none";
fechaCampo.style.display = "none";
divImprimirExistencias.style.display = "none";


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
                return (data === 'I') ? 'INGRESO INTERNO' : (data === 'E') ? 'INGRESO EXTERNO' : data;
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
            title: 'Cantidad que Ingresó',
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


//// PARA TRAER LOS DATOS 
const traeDatos = (e) => {
    const button = e.target;
    const producto = button.dataset.producto;
    const lote = button.dataset.lote;
    const estado = button.dataset.estado;
    const fecha = button.dataset.fecha;


    
    const dataset = {
        det_pro_id: producto,
        det_lote: lote,
        det_estado: estado,
        det_fecha_vence: fecha,
       

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
        buscarCantidad();
        buscarCantidadLote();
       
};

const colocarDatos = (dataset) => {
    console.log('Datos en colocarDatos:', dataset);

    formularioDetalle.det_pro_id.value = dataset.det_pro_id;
    formularioDetalle.det_lote.value = dataset.det_lote;
    formularioDetalle.det_estado.value = dataset.det_estado;
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
                // Verifica si la fecha es '7/05/1999' y muestra ...
                return (data === '1999-05-07') ? 'Sin fecha de vencimiento' : data;
            }
        },
        {
            title: 'Cantidad Ingresada',
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
            title: 'Inventario al que Ingreso',
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
            title: 'Fecha de Ingreso',
            data: 'mov_fecha'
        },
        {
            title: 'Tipo de transaccion',
            data: 'mov_tipo_trans',
            render: function (data) {
                return (data === 'I') ? 'INGRESO INTERNO' : (data === 'E') ? 'INGRESO EXTERNO' : data;
            }
        },
        {
            title: 'Procedencia',
            data: 'dep_desc_md'
        },
        {
            title: 'Estado del Ingreso',
            'render': function(data, type, row) {
                if (row.mov_situacion == '1') {
                    return '<div class="estado-pendiente">PENDIENTE DE INGRESAR</div>';
                } else if (row.mov_situacion == '2') {
                    return '<div class="estado-ingresado">INGRESADO</div>';
                } else {
                    return data; 
                }
            }
        },
        {
            title: 'FINALIZAR INGRESO',
            data: 'mov_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                if (row.mov_situacion == '2') {
                    return ''; 
                } 
            return `<button class="btn btn-success"  data-id='${data}' data-almacen='${row["mov_alma_id"]}'>Continuar Ingreso</button>`
             }
        },
        {
            title: 'VER DETALLES DE ESTE INGRESO',
            data: 'mov_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-info" data-id='${data}'>Ver Detalles de Este Ingreso</button>`
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
        modalVerExistencias.classList.add('show');
        modalVerExistencias.style.display = 'block';


};

const colocarDatosVerDetalle = (dataset) => {
    console.log('Datos en colocarDatos:', dataset);
    botonVolverImprimir.value = dataset.det_mov_id;
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
        movDetalleDiv.style.display = 'block';
        movMovimientoDiv.style.display = 'none';
        divIngresoMovimiento.style.display = 'none';
        datosMovimiento.style.display = 'none';
};

const colocarDatosFinalizacion = (dataset) => {
    console.log('Datos en colocarDatos:', dataset);
    formularioDetalle.det_mov_id.value = dataset.det_mov_id;
    formulario.mov_alma_id.value = dataset.mov_alma_id;
    almaSeleccionadoId = dataset.mov_alma_id;
    buscarProducto();
    buscarUnidades();
    buscarDetalleMovimiento();
};


const cancelarAccionFinalizacion = () => {
    formularioDetalle.reset();
    movDetalleDiv.style.display = 'none';
    movMovimientoDiv.style.display = 'none';
    divIngresoMovimiento.style.display = 'block';
    datosMovimiento.style.display = 'block';
};



//////////DATATABLE PARA MOSTRAR LAS EXISTENCIAS DE INSUMOS POR INVENTARIO//////////////////////////////////////////////////////

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
            targets: [1, 2, 3, 4 ],
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

};


const buscarDetallePorIngreso = async () => {
    

    const url = `/control_inventario/API/movimiento/buscarDetallePorIngreso?IdMovimiento=${IdMovimiento}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data)

        datatable.clear().draw();
        if (data) {
            contador = 1;
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros! Asegurese de no tener un ingreso pendiente',
                icon: 'info'
            });
        }

    } catch (error) {
        console.log(error);
    }
   
};



//////////para buscar oficiales y llenar el campo de la persona que entrega////////

const buscarOficiales = async () => {
    let mov_perso_entrega = formulario.mov_perso_entrega.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    const fetchData = async () => {
        const url = `/control_inventario/API/movimiento/buscarOficiales?mov_perso_entrega=${mov_perso_entrega}`;
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
        const url = `/control_inventario/API/movimiento/buscarOficialesRecibe?mov_perso_recibe=${mov_perso_recibe}`;
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
    clearTimeout(typingTimeout); 
    const fetchData = async () => {
        const url = `/control_inventario/API/movimiento/buscarOficialesResponsable?mov_perso_respon=${mov_perso_respon}`;
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
    typingTimeout = setTimeout(fetchData, 1200);

};



const buscarDependencia = async () => {
   
    if (formulario.dep_desc_md && formulario.dep_llave) {
        let dep_desc_md = formulario.dep_desc_md.value;
        let dep_llave = formulario.dep_llave.value;
    }
    const url = `/control_inventario/API/movimiento/buscarDependencia`;
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
        console.log('data de dependencias', data); 

        dependencias = data;
       
        formulario.mov_proce_destino.innerHTML = '';

       
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

const buscarAlmacenes = async () => {
 
    if (formulario.alma_nombre && formulario.alma_id) {
        let alma_nombre = formulario.alma_nombre.value;
        let alma_id = formulario.alma_id.value;
    }
    const url = `/control_inventario/API/movimiento/buscarAlmacenes`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); 
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
        console.log('data de almacenes', data); 
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
            divImprimirExistencias.style.display = 'block';
            let mov_alma_id = data[0].mov_alma_id;
            btnImprimirExistencias.value = mov_alma_id;
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

/////////////////////////////almacenar el id//////////////////////////////////////
// Agregar evento al cambio del select para almacenar el ID del almacén
formulario.mov_alma_id.addEventListener('change', function () {
   
    almaSeleccionadoId = this.value;

    console.log('Alma ID seleccionado:', almaSeleccionadoId);

    buscarProducto();
    buscarUnidades();
    
});


////////////////buscar producto de acuerdo al id del almacen seleccionado/////////////////////////////

const buscarProducto = async () => {
   
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
   
}

///////////////////////////BUSCAR PRODUCTOS EN EL MODAL/////////////


const buscarProductoModal = async () => {
  
    if (formularioModal.pro_nom_articulo && formularioModal.pro_id) {
        let pro_nom_articulo = formularioModal.pro_nom_articulo.value;
        let pro_id = formularioModal.pro_id.value;
    }

    const url = `/control_inventario/API/movimiento/buscarProductoModal?almaSeleccionId=${almaSeleccionId}`;
    const config = {
        method: 'GET'
    };

    console.log(data)

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de productos', data); 

        producto = data;
     
        formularioModal.det_pro.innerHTML = '';

     
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioModal.det_pro.appendChild(defaultOption);
     
        data.forEach(producto => {
            const option = document.createElement('option');
            option.value = producto.pro_id;
            option.textContent = producto.pro_nom_articulo;
            formularioModal.det_pro.appendChild(option);
        });

    } catch (error) {
        console.log(error);
    }
   
};


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


////// GUARDAR CAMPOS DEL FORMULARIO MOVIMIENTO

const guardar = async (evento) => {
    evento.preventDefault();

    btnGuardar.disabled = true;

    if (!validarFormulario(formulario, ['mov_id', 'mov_tipo_mov'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        btnGuardar.disabled = false;
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
    btnGuardar.disabled = false;
    establecerFechaActual(); 
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
           
            formularioDetalle.det_cantidad_existente.value = data[0].det_cantidad_existente;
           

            // Actualizar los valores iniciales después de la búsqueda
            valorInicialCantidadExistente = parseFloat(data[0].det_cantidad_existente) || 0;
           ;

        } else {
            // Si no se encontraron registros, establecer los inputs en 0
            formularioDetalle.det_cantidad_existente.value = 0;
           
            // Si no se encontraron registros, los valores iniciales serán 0
            valorInicialCantidadExistente = 0;
           
        }

    } catch (error) {
        console.log(error);
    }


};



const guardarDetalle = async (evento) => {
    evento.preventDefault();
    btnGuardarDetalle.disabled = true;
    if (!validarFormulario(formularioDetalle, ['det_id', 'det_fecha_vence'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        btnGuardarDetalle.disabled = false;
        return;
    }
    //  // Guarda el valor actual del campo det_mov_id
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

    btnGuardarDetalle.disabled = false;

  
};


///////////funciones para el formulario de busqueda de ingresos

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
        console.log('data de almacenes', data); 
        almacenes = data;
      
        formularioBusqueda.mov_alma.innerHTML = '';

      
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioBusqueda.mov_alma.appendChild(defaultOption);
       
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

    const url = `/control_inventario/API/movimiento/buscarMovimientos?mov_alma=${mov_alma}`;
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


//FUNCION PARA LLAMAR LAS BUSQUEDAS DE ACUERDO SI SELECCIONAN INGRESO INTERNO O EGRESO EXTERNO


function mostrarDependencia() {
    if (select.value === "I") {
      
        buscarDependenciaInterna();
    } else if (select.value === "E") {
    
        buscarDependencia();
    } else {
       
    }
}

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
            //await buscarDependencia();
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
                text: 'Finalizó con éxito el proceso de ingreso al inventario',
                icon: 'success',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6',
                timer: 8000, 
                timerProgressBar: true, 

              });
        } catch (error) {
            console.log(error);
        }

        establecerFechaActual();
  
    };
//////////////función buscar para imprimir recibo

const buscarRecibo = async () => {
    let det_mov_id = formularioDetalle.det_mov_id.value;

    const url = `/control_inventario/API/reporte/buscarRecibo?det_mov_id=${det_mov_id}`;
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
            formulario.reset();
            datatableDetalle.clear().draw();
            establecerFechaActual();

        } else {
            Toast.fire({
                title: 'No se encontrararon registros',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
};




//////////////función buscar para imprimir recibo

const buscarRecibo2 = async () => {
    let det_mov_id = botonVolverImprimir.value;
    console.log('Valor del botón al iniciar buscarRecibo2:', det_mov_id);
 

    const url = `/control_inventario/API/reporte/buscarRecibo2?det_mov_id=${det_mov_id}`;
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
                title: 'No se encontraron registros o usted tiene un ingreso pendiente',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
};

const buscarExistenciasPorInventarioImprimir = async () => {

    let inventarioId = btnImprimirExistencias.value;

    const url = `/control_inventario/API/existenciasreporte/buscarExistenciasPorInventarioImprimir?inventarioId=${inventarioId}`;
    const config = {
        method: 'GET',
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        if (data && data.length > 0) {
            generarExistenciasPDF(data);

        } else {
            Toast.fire({
                title: 'No se encontrararon registros',
                icon: 'info',
            });
        }
    } catch (error) {
        console.log(error);
    }
};



////////////////generar pdf para entregar hoja de responsabilidad/////////////

const generarPDF = async (datos) => {

    let timerInterval;
    Swal.fire({
        title: 'Generando PDF...',
        html: 'Por favor espera <b></b> milisegundos.',
        timer: 4000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    });

    const url = `/control_inventario/reporte/generarPDF`;

    const config = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos),
    };

    try {
        const respuesta = await fetch(url, config);
        Swal.close();
        if (respuesta.ok) {
            const blob = await respuesta.blob();

            if (blob) {
                const urlBlob = window.URL.createObjectURL(blob);

                // Abre el PDF en una nueva ventana o pestaña
                window.open(urlBlob, '_blank');
            } else {
                console.error('No se pudo obtener el blob del PDF.');
            }
        } else {
            console.error('Error al generar el PDF.');
            Swal.close();

        }
    } catch (error) {
        console.error(error);
        Swal.close();
    }
};



const generarExistenciasPDF = async (datos) => {

    let timerInterval;
    Swal.fire({
        title: 'Generando PDF...',
        html: 'Por favor espera <b></b> milisegundos.',
        timer: 4000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    });

    const url = `/control_inventario/existenciasreporte/generarExistenciasPDF`;

    const config = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos),
    };

    try {
        const respuesta = await fetch(url, config);
        Swal.close();
        if (respuesta.ok) {
            const blob = await respuesta.blob();

            if (blob) {
                const urlBlob = window.URL.createObjectURL(blob);

                // Abre el PDF en una nueva ventana o pestaña
                window.open(urlBlob, '_blank');
            } else {
                console.error('No se pudo obtener el blob del PDF.');
            }
        } else {
            console.error('Error al generar el PDF.');
            Swal.close();

        }
    } catch (error) {
        console.error(error);
        Swal.close();
    }
};


const manejarConfirmacionImpresion = async () => {
    try {
        await buscarRecibo2();
    } catch (error) {
        console.error('Error al ejecutar la impresión:', error);
    }
};



const manejarConfirmacionImpresionExistencias = async () => {
    try {
        await buscarExistenciasPorInventarioImprimir();
    } catch (error) {
        console.error('Error al ejecutar la impresión:', error);
    }
};





///evento para detectar el cambio del select 
select.addEventListener('change', mostrarDependencia);




//////////////////
///////////////LLAMAR A LAS FUNCIONES///////////
establecerFechaActual();
buscarAlmacenes();
buscarAlmacenesInventario();
buscarEstados();
buscarAlmacenesMovimientos();






///////////// EVENTOS///////////////////////////////////
mov_perso_entrega.addEventListener('input', buscarOficiales);
mov_perso_recibe.addEventListener('input', buscarOficialesRecibe);
mov_perso_respon.addEventListener('input', buscarOficialesResponsable);
formulario.addEventListener('submit', guardar);
formularioDetalle.addEventListener('submit', guardarDetalle);
btnMovimiento.addEventListener('click', buscarMovimientos);
datatableDetalle.on('click', '.btn-warning', traeDatosDetalle );
datatableDetalle.on('click', '.btn-danger', eliminar);
datatableMovimiento.on('click', '.btn-success', traeDatosFinalizacion);
datatableMovimiento.on('click', '.btn-info', traeDatosVerDetalle);
btnBuscarInventarioExistencias.addEventListener('click', buscarExistenciasPorInventario);

//PARA IMPRIMIR 
botonVolverImprimir.addEventListener('click', (e) => {
    e.preventDefault();
    Swal.fire({
        title: "¿Desea imprimir este detalle?",
        text: "Si acepta, se procederá a imprimir el detalle del recibo.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Imprimir',
        cancelButtonText: 'Cancelar acción'

    }).then((result) => {
        if (result.isConfirmed) {
          manejarConfirmacionImpresion();
        }
    });
});

btnImprimirExistencias.addEventListener('click', (e) => {
    e.preventDefault();
    Swal.fire({
        title: "¿Desea imprimir las Existencias de este Inventario?",
        text: "Si acepta, se procederá a imprimir el detalle de las existencias.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Imprimir',
        cancelButtonText: 'Cancelar acción'

    }).then((result) => {
        if (result.isConfirmed) {
          manejarConfirmacionImpresionExistencias();
        }
    });
});

botonImprimir.addEventListener('click', buscarRecibo);


///evento para detectar el cambio del select 
select.addEventListener('change', mostrarDependencia);


// Agrega un oyente de eventos al botón "Anterior" del formulario de detalle
btnAnterior.addEventListener('click', function (event) {
    event.preventDefault();
    // Ocultar el formulario de detalle
    divIngresoMovimiento.style.display = 'block';
    movMovimientoDiv.style.display = 'none';
    datosMovimiento.style.display = 'block';
    movDetalleDiv.style.display = 'none';
    formularioDetalle.reset();
    formulario.reset();
    establecerFechaActual();
});

//EVENTOS PARA BUSCAR LA CANTIDAD EXISTENTE

detProIdSelect.addEventListener('input', buscarCantidad);
detUniSelect.addEventListener('input', buscarCantidad);
detProIdSelect.addEventListener('input', buscarCantidadLote);
detUniSelect.addEventListener('input', buscarCantidadLote);
detLoteInput.addEventListener('input', buscarCantidadLote);
detFechaInput.addEventListener('input', buscarCantidadLote);
detEstadoSelect.addEventListener('input', buscarCantidadLote);
det_mov_id.addEventListener('input', buscarDetalleMovimiento);


btnIngreso.addEventListener('click', function() {
    divIngresoMovimiento.style.display = 'none';
    datosMovimiento.style.display = 'none';
    movMovimientoDiv.style.display = 'block';
});


btnRegresarGestion.addEventListener('click', function() {
    divIngresoMovimiento.style.display = 'block';
    movMovimientoDiv.style.display = 'none';
    datosMovimiento.style.display = 'block';
    formulario.reset();
    establecerFechaActual();

})




// Almacenar los valores originales cuando la página se carga
let valorInicialCantidadExistente = parseFloat(detCantidadExistenteInput.value) || 0;
let valorInicialCantidadLote = parseFloat(detCantidadLoteInput.value) || 0;

// Función para actualizar la sumatoria
const actualizarSumatoria = () => {
    // Obtener el valor actual del campo det_cantidad
    const cantidad = parseFloat(detCantidadInput.value) || 0;

        const nuevaCantidadLote = cantidad + valorInicialCantidadLote;
        const nuevaCantidadExistente = cantidad + valorInicialCantidadExistente;

        // Actualizar los campos con las nuevas sumas
        detCantidadLoteInput.value = nuevaCantidadLote.toFixed(2);
        detCantidadExistenteInput.value = nuevaCantidadExistente.toFixed(2);
    };

// Escuchador de eventos 'input' al campo det_cantidad
detCantidadInput.addEventListener('input', actualizarSumatoria);

// Escuchador de eventos 'change' al campo det_cantidad
detCantidadInput.addEventListener('change', () => {
    // Obtener el valor actual del campo det_cantidad
    const cantidad = parseFloat(detCantidadInput.value) || 0;

});

checkboxLoteNo.addEventListener('change', function() {
    if (this.checked) {
        checkboxLoteSi.checked = false;
        detLoteInput.value = 'SIN/L';
        campoLote.style.display = "none";

      
    } else {
        detLoteInput.value = '';
       
    }
});

checkboxLoteSi.addEventListener('change', function() {
    if (this.checked) {
        checkboxLoteNo.checked = false; 
        detLoteInput.value = '';
        campoLote.style.display = "block";

    }
});

checkboxFechaNo.addEventListener('change', function() {
    if (this.checked) {
        checkboxFechaSi.checked = false;
        detFechaInput.value = '1999-05-07'
        buscarCantidadLote(); /// si esta checkeado despues de que se coloque la fecha que se ejecute la funcion///////

        fechaCampo.style.display = "none"
        
    } else {
        detFechaInput.value = '';
        detCantidadLoteInput.value = '';

    }
});

checkboxFechaSi.addEventListener('change', function() {
    if (this.checked) {
        checkboxFechaNo.checked = false; 
        detFechaInput.value = '';
        fechaCampo.style.display = "block";
        detCantidadLoteInput.value = '';


    }
});


// Llamamos a la función inicial para configurar correctamente el estado inicial
actualizarSumatoria();


//////////evento para cerrar el modal haciendo clic

botonCerrarModal.addEventListener('click', function () {
    // Cierra el modal
    modalVerExistencias.style.display = 'none';
    document.body.classList.remove('modal-open');
    //formularioGuarda.reset();


});

////cerrar el modal cuando se hace clic fuera del modal...
modalVerExistencias.addEventListener('click', function (event) {
    if (event.target === modalVerExistencias) {
        modalVerExistencias.style.display = 'none';
        document.body.classList.remove('modal-open');
        //buscarDependencia();
    }
});


btnVerExistenciasInventario.addEventListener('click', () => {
    // Abre el modal al hacer clic en el botón
    modalExistenciasPorInventario.classList.add('show');
    modalExistenciasPorInventario.style.display = 'block';

});

////cerrar el modal cuando se hace clic fuera del modal...
modalExistenciasPorInventario.addEventListener('click', function (event) {
    if (event.target === modalExistenciasPorInventario) {
        modalExistenciasPorInventario.style.display = 'none';
        document.body.classList.remove('modal-open');
        datatableExistenciasPorInventario.clear().draw();
        divImprimirExistencias.style.display = 'none';
        formularioExistenciasPorInventario.reset();

    }

});

cerrarModalExistenciasPorInventario.addEventListener('click', function () {
    
    modalExistenciasPorInventario.style.display = 'none';
    document.body.classList.remove('modal-open');
    datatableExistenciasPorInventario.clear().draw();
    divImprimirExistencias.style.display = 'none';
    formularioExistenciasPorInventario.reset();


});




