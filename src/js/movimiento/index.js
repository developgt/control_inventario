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

let estado = [];// se define estado como un array vacio...
let producto = [];



// Oculta el elemento div card formulario detalle
movDetalleDiv.style.display = "none";

btnModificarDetalle.disabled = true
btnModificarDetalle.parentElement.style.display = 'none'
btnCancelarDetalle.disabled = true
btnCancelarDetalle.parentElement.style.display = 'none'

let almacenes = []; // se define almacenes como un array vacio...
let dependencias = [];
//////////DATATABLE//////////////////////////////////////////////////////

let contador = 1;
btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';



//////////para buscar oficiales y llenar el campo de la persona que entrega////////

const buscarOficiales = async () => {
    let mov_perso_entrega = formularioMovimiento.mov_perso_entrega.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    // Función que se ejecutará después del retraso
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
    // Establecer un retraso de 500 ms antes de realizar la solicitud a la API
    typingTimeout = setTimeout(fetchData, 1200);

};


//////////para buscar oficiales y llenar el campo de la persona que recibe////////

const buscarOficialesRecibe = async () => {
    let mov_perso_recibe = formularioMovimiento.mov_perso_recibe.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    // Función que se ejecutará después del retraso
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
    // Establecer un retraso de 500 ms antes de realizar la solicitud a la API
    typingTimeout = setTimeout(fetchData, 1200);

};


//////////para buscar oficiales y llenar el campo de la persona que entrega////////

const buscarOficialesResponsable = async () => {
    let mov_perso_respon = formularioMovimiento.mov_perso_respon.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  

    // Función que se ejecutará después del retraso
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
    // Establecer un retraso de 500 ms antes de realizar la solicitud a la API
    typingTimeout = setTimeout(fetchData, 1200);

};



const buscarAlmacenes = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
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
    const url = `/control_inventario/API/movimiento/buscarDependencia`;
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
}


const buscarProducto = async () => {
    // Verificar si los elementos del formulario existen antes de acceder a sus propiedades
    if (formularioDetalle.pro_nom_articulo && formularioDetalle.pro_id) {
        let pro_nom_articulo = formularioDetalle.pro_nom_articulo.value;
        let pro_id = formularioDetalle.pro_id.value;
    }
    const url = `/control_inventario/API/movimiento/buscarProducto`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de productos', data); // Imprimir datos en la consola

        producto = data;
        // Limpiar el contenido del select
        formularioDetalle.det_pro_id.innerHTML = '';

        // Agregar opción predeterminada
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'SELECCIONE...';
        formularioDetalle.det_pro_id.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(producto => {
            const option = document.createElement('option');
            option.value = producto.pro_id;
            option.textContent = producto.pro_nom_articulo;
            formularioDetalle.det_pro_id.appendChild(option);
        });



        //contador = 1;
        //datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formularioDetalle.reset();
}


////// GUARDAR CAMPOS DEL FORMULARIO

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formularioMovimiento, ['mov_id', 'mov_tipo_mov'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formularioMovimiento)
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

        const { codigo, mensaje, id, detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                const movimientoId = id;
                formularioMovimiento.reset();
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
    //buscar();
}



buscarAlmacenes();
buscarDependencia();
buscarEstados();
buscarProducto();

mov_perso_entrega.addEventListener('input', buscarOficiales);
mov_perso_recibe.addEventListener('input', buscarOficialesRecibe);
mov_perso_respon.addEventListener('input', buscarOficialesResponsable);
formularioMovimiento.addEventListener('submit', guardar)

  
    btnSiguiente.addEventListener('click', function(event) {
    //     // Prevenir el envío normal del formulario

        event.preventDefault();
    //     guardar();

     

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

