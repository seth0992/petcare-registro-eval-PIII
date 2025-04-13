-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS bd_veterinaria;

-- Usar la base de datos
USE bd_veterinaria;

-- Crear la tabla de mascotas
CREATE TABLE IF NOT EXISTS tbl_mascotas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    especie ENUM('perro', 'gato', 'ave', 'otro') NOT NULL,
    raza VARCHAR(50) NOT NULL,
    edad INT NOT NULL,
    propietario VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha_registro DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;