import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";


const clase1 = document.getElementById('clase1');
const clase2 = document.getElementById('clase2');
const clase3 = document.getElementById('clase3');
const clase4 = document.getElementById('clase4');
const clase5 = document.getElementById('clase5');
const clase6 = document.getElementById('clase6');
const clase7 = document.getElementById('clase7');
const clase8 = document.getElementById('clase8');
const clase9 = document.getElementById('clase9');


clase1.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    // Guarda el valor en localStorage
    localStorage.setItem('alma_clase', '1');
    window.location.href = url; 
   
})

clase2.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
     // Guarda el valor en localStorage
     localStorage.setItem('alma_clase', '2');
    window.location.href = url;
})

clase3.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    localStorage.setItem('alma_clase', '3');

    window.location.href = url;
})
clase4.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    localStorage.setItem('alma_clase', '4');

    window.location.href = url;
})
clase5.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    localStorage.setItem('alma_clase', '5');

    window.location.href = url;
})
clase6.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    localStorage.setItem('alma_clase', '6');

    window.location.href = url;
})
clase7.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    localStorage.setItem('alma_clase', '7');

    window.location.href = url;
})
clase8.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    localStorage.setItem('alma_clase', '8');

    window.location.href = url;
})
clase9.addEventListener('click', function () {
    let url = '/control_inventario/almacen';
    localStorage.setItem('alma_clase', '9');

    window.location.href = url;
})