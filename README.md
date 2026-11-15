🎮 ARCADIA
Descripción del proyecto
ARCADIA es un sitio web dedicado al mundo de los videojuegos y la tecnología. El objetivo es ofrecer información sobre juegos, emuladores, simuladores y aplicaciones, además de contar con un espacio para compartir opiniones y sugerencias.

El proyecto comenzó como una página desarrollada con HTML y CSS y luego fue migrado a PHP para incorporar contenido dinámico y mejorar la organización del código.

Tecnologías utilizadas
HTML5: estructura de las páginas.
CSS3: diseño y estilos.
Bootstrap: adaptación responsive.
JavaScript: interacciones.
PHP 8.x: procesamiento del lado del servidor.
XAMPP: entorno de desarrollo local.
Git y GitHub: control de versiones.
Estructura del proyecto
index.php: página principal.
includes/: contiene los archivos reutilizables.
header.php: encabezado.
nav.php: menú de navegación.
footer.php: pie de página.
clase5/: actividades de procesamiento de formularios.
estilos.css: estilos de la página.
imagenes/: imágenes utilizadas.
Modularización con PHP (SSI)
Se utilizaron las instrucciones include y require para separar partes del sitio y evitar repetir código.

Los componentes principales son:

Encabezado.
Menú de navegación.
Pie de página.
También se incorporó renderizado del lado del servidor (SSR), permitiendo generar contenido dinámico desde PHP.

Formularios y procesamiento de datos
En la carpeta clase5 se trabaja con formularios HTML y procesamiento mediante PHP.

Método POST: Se utiliza para enviar opiniones y sugerencias de los usuarios.

Método GET: Se utiliza para realizar búsquedas y enviar información mediante la URL.

Se incorporan validaciones para controlar los datos recibidos, utilizando herramientas como:

trim()
htmlspecialchars()
filter_var()
<img width="744" height="139" alt="image" src="https://github.com/user-attachments/assets/2a7611f3-5ff2-4ade-a363-35c4c4137b6d" />
<img width="493" height="315" alt="image" src="https://github.com/user-attachments/assets/65bddded-2ea4-4c0e-9b88-d5254cf294db" />

Configuración
El proyecto incluye un archivo .env.example como ejemplo de configuración de variables de entorno.

No se deben publicar contraseñas ni datos privados en GitHub.

_______________________________________________________________________________________________________________________________________________________________________________________________________________

# ARCADIA – Clase 5

## Procesamiento de formularios con PHP (POST y GET)

En esta clase se incorporaron dos formularios para capturar y procesar datos mediante PHP.

### Formularios implementados

- **POST:** utilizado para enviar sugerencias y opiniones.
- **GET:** utilizado para realizar búsquedas dentro del sitio.

### Seguridad y validación

Se utilizaron funciones como `htmlspecialchars()`, `trim()` y `filter_var()` para sanitizar y validar los datos, evitando posibles ataques XSS.

También se comprobaron los campos obligatorios y el formato del correo electrónico.

### Capturas de pantalla

1. Página principal de ARCADIA.
<img width="1904" height="993" alt="image" src="https://github.com/user-attachments/assets/8e1ece64-f5bb-4a03-96c5-40ab4cfd9c17" />

2. Formulario POST.
<img width="1919" height="985" alt="image" src="https://github.com/user-attachments/assets/df795e59-1fcc-4a77-9862-0366f183f0cf" />

3. Mensaje de envío exitoso.
<img width="1919" height="992" alt="image" src="https://github.com/user-attachments/assets/29e02c15-e480-41f6-95b6-7b4cb32a4e0c" />

4. Mensajes de validación de errores.
<img width="1919" height="983" alt="image" src="https://github.com/user-attachments/assets/14cf6f7d-c140-4822-b4fc-9cae4ba98efa" />

5. Formulario GET.
<img width="1919" height="988" alt="image" src="https://github.com/user-attachments/assets/0e48b1ec-e3a6-4d20-b731-6d8e9455ea85" />

6. Resultado de búsqueda mediante GET.
<img width="1919" height="988" alt="image" src="https://github.com/user-attachments/assets/502a998a-c675-4e11-8b06-7b2412755ce1" />


### Entrega

- Carpeta: `clase5`
- Rama: `main`
- Año: 2026
