document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-comunidad');
  if (form) form.addEventListener('submit', (event) => {
    event.preventDefault();
    const seleccion = form.querySelector('input[name="contenido"]:checked');
    const respuesta = document.getElementById('respuesta-comunidad');
    if (!seleccion) { respuesta.textContent = 'Elegí una opción para participar.'; return; }
    respuesta.textContent = `¡Gracias por participar! Elegiste: ${seleccion.value}.`;
  });
});
