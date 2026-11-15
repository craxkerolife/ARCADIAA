const comunidad = document.getElementById('form-comunidad');
if (comunidad) {
  comunidad.addEventListener('submit', (evento) => {
    evento.preventDefault();
    const seleccion = comunidad.querySelector('input[name="contenido"]:checked');
    const respuesta = document.getElementById('respuesta-comunidad');
    if (!seleccion) return;
    respuesta.textContent = `¡Gracias por participar! Tu elección fue: ${seleccion.value}.`;
    comunidad.reset();
  });
}
