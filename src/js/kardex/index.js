document.addEventListener('DOMContentLoaded', function() {
    // Obtener el valor almacenado en localStorage
    const almacenSeleccionado = localStorage.getItem('almacenSeleccionado');

    // Hacer algo con el valor del almacén
    if (almacenSeleccionado) {
        // Imprimir el valor en la consola
        console.log('Almacén Seleccionado:', almacenSeleccionado);

        // También puedes colocar el valor en algún elemento HTML si es necesario
        document.getElementById('nombreAlmacen').innerText = almacenSeleccionado;
    } else {
        console.warn('No se encontró un almacén seleccionado en localStorage.');
    }
});

document.addEventListener('DOMContentLoaded', function() {
  // Obtén el elemento div con la clase 'righter'
  var righterDiv = document.getElementById('kardex');

  // Agrega un evento de clic al div
  righterDiv.addEventListener('click', function() {
    // Redirige a la URL deseada
    window.location.href = 'kardex';
  });
});