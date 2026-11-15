CREATE DATABASE IF NOT EXISTS arcadia_tp6
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE arcadia_tp6;

CREATE TABLE IF NOT EXISTS roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(150)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuarios_roles
        FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL UNIQUE,
    descripcion VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recursos (
    id_recurso INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_categoria INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    tipo ENUM('Juego', 'Emulador', 'Simulador', 'Aplicacion') NOT NULL,
    url VARCHAR(500),
    estado ENUM('Activo', 'Inactivo') NOT NULL DEFAULT 'Activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_recursos_usuarios
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_recursos_categorias
        FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS etiquetas (
    id_etiqueta INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recurso_etiqueta (
    id_recurso INT NOT NULL,
    id_etiqueta INT NOT NULL,
    PRIMARY KEY (id_recurso, id_etiqueta),
    CONSTRAINT fk_recurso_etiqueta_recurso
        FOREIGN KEY (id_recurso) REFERENCES recursos(id_recurso)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_recurso_etiqueta_etiqueta
        FOREIGN KEY (id_etiqueta) REFERENCES etiquetas(id_etiqueta)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_recursos_categoria_estado ON recursos(id_categoria, estado);
CREATE INDEX idx_recursos_titulo ON recursos(titulo);
