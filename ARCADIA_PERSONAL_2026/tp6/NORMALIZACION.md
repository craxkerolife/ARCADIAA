# TP6 - Normalización de ARCADIA

## Situación inicial (sin normalizar)
Un catálogo simple podía guardar en una misma fila el recurso, la categoría, el usuario que lo publicó y varias etiquetas separadas por comas. Esto repetía nombres y dificultaba buscar o actualizar datos.

## Primera forma normal (1FN)
Cada campo contiene un solo valor. Las etiquetas múltiples se separan en registros individuales. No se guardan listas separadas por comas en una celda.

## Segunda forma normal (2FN)
Los datos que dependen de una parte de una clave compuesta se separan. La relación entre recursos y etiquetas se representa mediante `recurso_etiqueta`, con clave primaria compuesta (`id_recurso`, `id_etiqueta`).

## Tercera forma normal (3FN)
Los datos que no dependen directamente de la clave se separan en sus propias tablas. Los nombres de roles y categorías no se repiten dentro de cada usuario o recurso.

## Tablas resultantes
- `roles`: PK `id_rol`.
- `usuarios`: PK `id_usuario`; FK `id_rol`.
- `categorias`: PK `id_categoria`.
- `recursos`: PK `id_recurso`; FK `id_usuario` y FK `id_categoria`.
- `etiquetas`: PK `id_etiqueta`.
- `recurso_etiqueta`: PK compuesta `id_recurso` + `id_etiqueta`; ambas son FK.
- `sugerencias`: PK `id_sugerencia`; FK opcional `id_usuario`.

## Relación general
Un rol puede corresponder a muchos usuarios. Un usuario puede publicar muchos recursos. Una categoría puede clasificar muchos recursos. Recursos y etiquetas tienen relación muchos a muchos, resuelta con `recurso_etiqueta`.

La tabla `sugerencias` guarda los mensajes enviados desde los formularios POST. Las contraseñas se almacenan con hash generado por `password_hash()` de PHP, nunca en texto plano.
