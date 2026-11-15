# TP6 – Normalización de la base de datos ARCADIA

## Parte 1: Normalización aplicada al proyecto

ARCADIA es un sitio web que reúne juegos, emuladores, simuladores y aplicaciones. Para organizar su contenido se propone un catálogo de recursos que pueden pertenecer a una categoría y tener varias etiquetas. Los usuarios pueden publicar y administrar recursos.

### 1. Tabla principal sin normalizar

Ejemplo hipotético de un recurso:

| id_recurso | titulo | tipo | categoria | autor | email_autor | etiquetas |
|---|---|---|---|---|---|---|
| 1 | Minecraft Classic | Juego | Juegos online | Martín | martin@email.com | aventura, construcción, navegador |

Esta estructura presenta problemas: las etiquetas están guardadas juntas en un solo campo y los datos del autor y de la categoría podrían repetirse en muchos registros.

### 2. Proceso de normalización

#### Primera Forma Normal (1FN)

Se eliminan las listas dentro de un campo. Cada valor debe ser atómico. Las etiquetas se separan en registros individuales.

| id_recurso | titulo | tipo | categoria | autor | email_autor |
|---|---|---|---|---|---|
| 1 | Minecraft Classic | Juego | Juegos online | Martín | martin@email.com |

| id_recurso | etiqueta |
|---|---|
| 1 | aventura |
| 1 | construcción |
| 1 | navegador |

#### Segunda Forma Normal (2FN)

La tabla de relación entre recursos y etiquetas utiliza una clave primaria compuesta (`id_recurso`, `id_etiqueta`). No se guardan allí datos que dependan solamente de una parte de esa clave. El nombre de la etiqueta se almacena en `etiquetas` y los datos del recurso en `recursos`.

La relación queda separada en:
- `recursos`: información propia de cada recurso.
- `etiquetas`: nombre de cada etiqueta.
- `recurso_etiqueta`: relación entre recursos y etiquetas.

#### Tercera Forma Normal (3FN)

Se eliminan dependencias transitivas. Los datos del usuario no se repiten en cada recurso y el nombre de la categoría no se guarda directamente en el recurso. Se trasladan a tablas propias:
- `usuarios`: datos personales y correo.
- `roles`: nombre del rol.
- `categorias`: nombre de la categoría.
- `recursos`: referencia al usuario y a la categoría mediante claves foráneas.

### 3. Tablas resultantes, claves y relaciones

| Tabla | Clave primaria (PK) | Claves foráneas (FK) |
|---|---|---|
| roles | id_rol | — |
| usuarios | id_usuario | id_rol → roles.id_rol |
| categorias | id_categoria | — |
| recursos | id_recurso | id_usuario → usuarios.id_usuario; id_categoria → categorias.id_categoria |
| etiquetas | id_etiqueta | — |
| recurso_etiqueta | id_recurso + id_etiqueta | id_recurso → recursos.id_recurso; id_etiqueta → etiquetas.id_etiqueta |

La tabla `recurso_etiqueta` resuelve la relación muchos a muchos: un recurso puede tener varias etiquetas y una etiqueta puede pertenecer a varios recursos.

---

## Parte 2: Script DDL

El archivo `schema.sql` crea la base de datos `arcadia_tp6` y las tablas con claves primarias, claves foráneas, campos de auditoría e índices.

## Parte 3: Consultas CRUD

El archivo `consultas.sql` contiene datos de prueba y consultas para:
- **Create:** inserción de roles, usuarios, categorías, etiquetas y recursos.
- **Read:** búsquedas con `WHERE`, ordenamiento con `ORDER BY` y unión con `INNER JOIN`.
- **Update:** modificación de un recurso usando `WHERE`.
- **Delete:** eliminación de un recurso de prueba usando `WHERE`.

## Ejecución local

1. Abrir phpMyAdmin desde XAMPP.
2. Seleccionar la pestaña **Importar**.
3. Importar primero `schema.sql`.
4. Importar después `consultas.sql`.
5. Comprobar las tablas y ejecutar las consultas de prueba.

Los valores de contraseña incluidos en `consultas.sql` son hashes de demostración. En una aplicación real deben generarse desde PHP usando `password_hash()`.
