import Chart from "chart.js/auto";
import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";

const formulario = document.getElementById('formularioBusqueda');
const btnBuscar = document.getElementById('btnBuscar');
const movAlmaIdSelect = document.getElementById('mov_alma_id');
const chartInventario = document.getElementById('chartInventario').getContext('2d');

let chartEstadisticas;
// Generar un color RGB aleatorio
const getRandomColor = () => {
    const r = Math.floor(Math.random() * 255);
    const g = Math.floor(Math.random() * 255);
    const b = Math.floor(Math.random() * 255);
    return `rgba(${r}, ${g}, ${b}, 0.7)`;
};

const buscarAlmacenes = async () => {
    const url = `/control_inventario/API/movimiento/buscarAlmacenes`;
    try {
        const respuesta = await fetch(url);
        const almacenes = await respuesta.json();
        movAlmaIdSelect.innerHTML = '<option value="">SELECCIONE...</option>';
        almacenes.forEach(almacen => {
            const option = document.createElement('option');
            option.value = almacen.alma_id;
            option.textContent = almacen.alma_nombre;
            movAlmaIdSelect.appendChild(option);
        });
    } catch (error) {
        Toast.fire({
            icon: 'error',
            title: 'Error al buscar inventarios'
        });
        console.error('Error al buscar almacenes:', error);
    }
};
const options = {
    maintainAspectRatio: false, 
    responsive: true, 
};
const buscar = async () => {
    if (!movAlmaIdSelect.value) {
        Toast.fire({
            icon: 'info',
            title: 'Seleccione un inventario primero'
        });
        return;
    }
    const url = `/control_inventario/API/estadisticas/buscar?mov_alma_id=${movAlmaIdSelect.value}`;
    try {
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        if (!Array.isArray(resultado) || !resultado.length) {
            Toast.fire({
                icon: 'info',
                title: 'No se encontraron registros'
            });
            return;
        }
    
        if (chartEstadisticas) {
            chartEstadisticas.destroy();
        }
        chartEstadisticas = new Chart(chartInventario, {
            type: 'bar',
            data: {
                labels: resultado.map(item => `${item.pro_nom_articulo} (${item.uni_nombre})`),
                datasets: [{
                    label: 'Cantidad Existente',
                    data: resultado.map(item => item.det_cantidad_existente),
                    backgroundColor: resultado.map(() => getRandomColor()),
                    borderColor: resultado.map(() => getRandomColor()),
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 16,
                            weight: 'bold',
                        },
                        bodyFont: {
                            size: 14,
                        },
                        padding: 10,
                        cornerRadius: 3,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error al buscar:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al procesar la búsqueda'
        });
    }
};




btnBuscar.addEventListener('click', buscar);
buscarAlmacenes();