USE arcadia_tp6;
-- Consultas de prueba del TP6. Ejecutar schema.sql primero.
INSERT IGNORE INTO etiquetas(nombre) VALUES ('Retro'),('Online'),('PC');
-- SELECT con WHERE y ORDER BY
SELECT * FROM recursos WHERE estado='Activo' ORDER BY titulo ASC;
-- INNER JOIN entre recursos, usuarios y categorías
SELECT r.titulo, r.tipo, c.nombre AS categoria, u.nombre AS publicado_por
FROM recursos r
INNER JOIN categorias c ON r.id_categoria=c.id_categoria
INNER JOIN usuarios u ON r.id_usuario=u.id_usuario
ORDER BY r.titulo;
-- Ver sugerencias recibidas
SELECT nombre,email,asunto,created_at FROM sugerencias ORDER BY created_at DESC;
-- Ejemplos de UPDATE y DELETE: reemplazar el ID por uno existente antes de ejecutarlos.
-- UPDATE recursos SET estado='Inactivo' WHERE id_recurso=1;
-- DELETE FROM recursos WHERE id_recurso=1;
