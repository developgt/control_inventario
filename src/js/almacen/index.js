import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const formulario = document.querySelector('form');
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'


///para que se autocomplete el campo de dependencia en automatico. 

const almaUnidad = document.getElementById('alma_unidad');
const almaUnidadId = document.getElementById('alma_unidad_id');

document.addEventListener('DOMContentLoaded', function() {
    buscarDependencia();
});



//     // Función para buscar 

 const buscarDependencia = async () => {
 
    const url = `/control_inventario/API/almacen/buscarDependencia?`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        if (data && data.length > 0 && data[0].dep_desc_md && data[0].dep_llave) {
            // Mostrar el nombre de la dependencia en el campo alma_unidad
            almaUnidad.value = data[0].dep_llave;
            // Almacenar dep_llave en alma_unidad_id (oculto)
            almaUnidadId.value = data[0].dep_desc_md;
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





const guardar = async (evento) => {
    evento.preventDefault();

    //await almaUnidad();

    if (!validarFormulario(formulario, ['alma_id', 'alma_unidad'])) {
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
}



formulario.addEventListener('submit', guardar)


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