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
const guarda_id = document.getElementById('guarda_id');
const guarda_catalogo = document.getElementById('guarda_catalogo');
const guarda_nombre = document.getElementById('guarda_nombre')
const alma_nombre = document.getElementById('alma_nombre');
const alma_id = document.getElementById('alma_id');
const nombreAlmacen = document.getElementById('guarda_almacen')
let almaIdSeleccionado = null;
//declaracion de variable typingtimeout
let typingTimeout;
let almacenes = []; // se define almacenes como un array vacio...
console.log('almacenes:', almacenes);

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'




//cargar contenido cuando se cargue la pagina

document.addEventListener('DOMContentLoaded', async function() {

    try {
        await buscarAlmacenes();
      
        //buscar();
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
    const url = `/control_inventario/API/medida/buscarAlmacenes`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log('data de almacenes', data); // Imprimir datos en la consola

        almacenes = data;
        // Limpiar el contenido del select
        formulario.guarda_almacen.innerHTML = '';

         // Agregar opción predeterminada
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'SELECCIONE...';
    formulario.guarda_almacen.appendChild(defaultOption);
        // Iterar sobre cada objeto en el arreglo y crear opciones para el select
        data.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            formulario.guarda_almacen.appendChild(option);
        });

   

        // contador = 1;
        // datatable.clear().draw();
    } catch (error) {
        console.log(error);
    }
    formulario.reset();
};





const buscarOficiales = async () => {
    let guarda_catalogo = formulario.guarda_catalogo.value;
    clearTimeout(typingTimeout); // Limpiar el temporizador anterior (si existe)  
    
    // Función que se ejecutará después del retraso
    const fetchData = async () => {
        const url = `/control_inventario/API/guarda/buscarOficiales?guarda_catalogo=${guarda_catalogo}`;
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

guarda_catalogo.addEventListener('input', buscarOficiales);



////// GUARDAR CAMPOS DEL FORMULARIO

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['guarda_id', 'guarda_nombre'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formulario)
    body.delete('uni_id')
    const url = '/control_inventario/API/guarda/guardar';
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











buscarAlmacenes();

formulario.addEventListener('submit', guardar);
// btnBuscar.addEventListener('click', buscar);
// btnCancelar.addEventListener('click', cancelarAccion);
// btnModificar.addEventListener('click', modificar);
// datatable.on('click', '.btn-warning', traeDatos );
// datatable.on('click', '.btn-danger', eliminar);






