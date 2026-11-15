USE arcadia_tp6;

-- CREATE: datos maestros
INSERT INTO roles (nombre, descripcion) VALUES
('Administrador', 'Puede administrar el contenido del sitio'),
('Colaborador', 'Puede publicar y editar recursos');

INSERT INTO categorias (nombre, descripcion) VALUES
('Juegos', 'Juegos disponibles para navegador o descarga'),
('Emuladores', 'Programas para emular consolas'),
('Aplicaciones', 'Programas y herramientas');

-- CREATE: usuarios de prueba
-- Hashes de demostración; en producción generar con password_hash() desde PHP.
INSERT INTO usuarios (id_rol, nombre, apellido, email, password) VALUES
(1, 'Martín', 'González', 'martin@arcadia.test', '$2y$10$abcdefghijklmnopqrstuu123456789012345678901234567890'),
(2, 'Lucía', 'Pérez', 'lucia@arcadia.test', '$2y$10$abcdefghijklmnopqrstuu123456789012345678901234567890');

-- CREATE: etiquetas
INSERT INTO etiquetas (nombre) VALUES
('Retro'),
('Online'),
('PC');

-- CREATE: registros principales vinculados con sus claves foráneas
INSERT INTO recursos
(id_usuario, id_categoria, titulo, descripcion, tipo, url, estado)
VALUES
(1, 1, 'Minecraft Classic', 'Versión clásica de Minecraft para jugar desde el navegador.', 'Juego', 'https://classic.minecraft.net/', 'Activo'),
(2, 2, 'PPSSPP', 'Emulador para jugar títulos de PSP.', 'Emulador', 'https://www.ppsspp.org/', 'Activo'),
(2, 3, 'Visual Studio Code', 'Editor de código para desarrollar proyectos.', 'Aplicacion', 'https://code.visualstudio.com/', 'Activo');

INSERT INTO recurso_etiqueta (id_recurso, id_etiqueta) VALUES
(1, 2),
(1, 3),
(2, 1),
(3, 3);

-- READ: filtrar y ordenar
SELECT id_recurso, titulo, tipo, estado
FROM recursos
WHERE estado = 'Activo'
ORDER BY titulo ASC;

-- READ: INNER JOIN para mostrar recurso, autor y categoría
SELECT
    r.id_recurso,
    r.titulo,
    r.tipo,
    CONCAT(u.nombre, ' ', u.apellido) AS autor,
    c.nombre AS categoria
FROM recursos AS r
INNER JOIN usuarios AS u ON r.id_usuario = u.id_usuario
INNER JOIN categorias AS c ON r.id_categoria = c.id_categoria
ORDER BY r.titulo;

-- READ: mostrar etiquetas de cada recurso
SELECT r.titulo, e.nombre AS etiqueta
FROM recurso_etiqueta AS re
INNER JOIN recursos AS r ON re.id_recurso = r.id_recurso
INNER JOIN etiquetas AS e ON re.id_etiqueta = e.id_etiqueta
ORDER BY r.titulo, e.nombre;

-- UPDATE: modificar un registro específico
UPDATE recursos
SET estado = 'Inactivo'
WHERE id_recurso = 3;

-- DELETE: eliminar el recurso de prueba número 3
-- La relación en recurso_etiqueta se elimina automáticamente por ON DELETE CASCADE.
DELETE FROM recursos
WHERE id_recurso = 3;
