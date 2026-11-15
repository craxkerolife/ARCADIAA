# ARCADIA — Proyecto desde cero

Sitio educativo desarrollado con PHP, HTML, CSS y JavaScript.

## Funcionalidades
- Navegación por secciones: inicio, juegos, emuladores, simuladores, aplicaciones, curso HTML, blog, búsqueda, sugerencias, comunidad y contacto.
- Buscador con método GET sobre un catálogo local.
- Formulario de sugerencias/contacto con método POST y validación de campos y correo.
- Sanitización de datos con `htmlspecialchars()` y limpieza con `trim()`.
- Diseño adaptable a computadoras, tablets y celulares.

## Cómo ejecutarlo con XAMPP
1. Descomprimí la carpeta `ARCADIA_desde_cero`.
2. Copiala dentro de `C:\xampp\htdocs\`.
3. Abrí XAMPP e iniciá Apache.
4. Entrá desde el navegador a `http://localhost/ARCADIA_desde_cero/`.

El formulario POST valida los datos y muestra una confirmación. Es una práctica educativa: no envía correos reales ni guarda información en una base de datos. La votación de comunidad muestra una confirmación en el navegador y no almacena votos.
