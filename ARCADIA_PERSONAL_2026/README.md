# ARCADIA - Proyecto integrador

Sitio web educativo de juegos, emuladores, simuladores, aplicaciones y aprendizaje tecnológico. Mantiene el estilo violeta y las secciones del proyecto anterior, y agrega registro, inicio de sesión, base de datos y panel de administración.

## Requisitos
- XAMPP con Apache, MySQL y PHP 8 o superior.
- Navegador web.

## Instalación en XAMPP
1. Copiá la carpeta `ARCADIA_PERSONAL_2026` dentro de `C:\xampp\htdocs\`.
2. Abrí XAMPP e iniciá Apache y MySQL.
3. Entrá a `http://localhost/phpmyadmin/`.
4. Elegí **Importar** y seleccioná `tp6/schema.sql`.
5. Abrí `http://localhost/ARCADIA_PERSONAL_2026/arcadia_inicio.php`.

La configuración de conexión está en `config/arcadia_configuracion.php`. En XAMPP estándar usa usuario `root` y contraseña vacía.

## Crear la cuenta administradora
1. Registrá una cuenta desde el botón **Registrarse**.
2. Abrí `http://localhost/ARCADIA_PERSONAL_2026/arcadia_setup_admin.php`.
3. Escribí el correo de la cuenta que registraste y enviá.
4. Cerrá sesión y volvé a iniciar sesión.
5. **Eliminá `arcadia_setup_admin.php` después de usarlo.** No lo dejes publicado.

## Funciones
- Catálogo por secciones: juegos, emuladores, simuladores y aplicaciones.
- Buscador GET.
- Formularios POST de sugerencias/contacto con validación, escape HTML y guardado en MySQL.
- Registro e inicio/cierre de sesión.
- Contraseñas protegidas con `password_hash()` y `password_verify()`.
- Panel privado para administrador: agregar, desactivar/activar y eliminar recursos.
- Diseño adaptable a celulares y computadoras.

## Carpetas
- `assets/`: CSS y JavaScript.
- `config/`: conexión y configuración.
- `includes/`: cabecera, menú, pie y funciones.
- `clase5/`: documentación del TP5.
- `tp6/`: normalización y SQL del TP6.

## GitHub
Subí la carpeta completa al repositorio, en la rama `main`. No subas contraseñas reales ni datos personales. Las capturas de `clase5/capturas/` se agregan después de probar el sitio.
