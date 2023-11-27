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
const chartIngresoContext = document.getElementById('chartIngreso').getContext('2d');
const chartEgresoContext = document.getElementById('chartEgreso').getContext('2d');

let chartIngresos, chartEgresos;

const limpiarGraficas = () => {
    if (chartIngresos) {
        chartIngresos.destroy();
        chartIngresos = null;
    }
    if (chartEgresos) {
        chartEgresos.destroy();
        chartEgresos = null;
    }
};
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
            title: 'Error al buscar almacenes'
        });
        console.error('Error al buscar almacenes:', error);
    }
};



// Opciones comunes para las gráficas
const chartOptions = {
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
};

// Función para buscar y cargar la gráfica de ingresos
const buscarIngreso = async () => {
    if (!movAlmaIdSelect.value) {
        Toast.fire({
            icon: 'info',
            title: 'Seleccione un inventario primero'
        });
        return;
    }

    const url = `/control_inventario/API/estadisticas/buscarIngreso?mov_alma_id=${movAlmaIdSelect.value}`;
    try {
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        if (!Array.isArray(resultado) || !resultado.length) {
            Toast.fire({
                icon: 'info',
                title: 'No se encontraron registros de ingreso'
            });
            document.getElementById('mensajeIngreso').style.display = 'block';
            if (chartIngresos) {
                chartIngresos.destroy();
                chartIngresos = null;
            }
            return;
        } else {
            document.getElementById('mensajeIngreso').style.display = 'none';
        }

        chartIngresos = new Chart(chartIngresoContext, {
            type: 'bar',
            data: {
                labels: resultado.map(item => `${item.producto}`),
                datasets: [{
                    label: 'Cantidad de Ingresos',
                    data: resultado.map(item => item.totalingresos),
                    backgroundColor: resultado.map(() => getRandomColor()),
                    borderColor: resultado.map(() => getRandomColor()),
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });
    } catch (error) {
        console.error('Error al buscar ingresos:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al procesar la búsqueda de ingresos'
        });
    }
};

// Función para buscar y cargar la gráfica de egresos
const buscarEgreso = async () => {
    if (!movAlmaIdSelect.value) {
        Toast.fire({
            icon: 'info',
            title: 'Seleccione un inventario primero'
        });
        return;
    }

    const url = `/control_inventario/API/estadisticas/buscarEgreso?mov_alma_id=${movAlmaIdSelect.value}`;
    try {
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();

        if (!Array.isArray(resultado) || !resultado.length) {
            Toast.fire({
                icon: 'info',
                title: 'No se encontraron registros de egreso'
            });
            document.getElementById('mensajeEgreso').style.display = 'block';
            if (chartEgresos) {
                chartEgresos.destroy();
                chartEgresos = null;
            }
            return;
        } else {
            document.getElementById('mensajeEgreso').style.display = 'none';
        }
        chartEgresos = new Chart(chartEgresoContext, {
            type: 'bar',
            data: {
                labels: resultado.map(item => `${item.producto}`),
                datasets: [{
                    label: 'Cantidad de Egresos',
                    data: resultado.map(item => item.totalegresos),
                    backgroundColor: resultado.map(() => getRandomColor()),
                    borderColor: resultado.map(() => getRandomColor()),
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });
    } catch (error) {

        console.error('Error al buscar egresos:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al procesar la búsqueda de egresos'
        });
    }
 }
    


 btnBuscar.addEventListener('click', () => {
    limpiarGraficas(); 
    buscarIngreso();
    buscarEgreso();
    });
buscarAlmacenes();