-- creación de la base de datos
create database proyecto_2;
use proyecto_2;
-- creación de la tabla de registros
create table usuarios(
    -- creación de las columnas
    id INT PRIMARY KEY AUTO_INCREMENT,
    columna_usuario VARCHAR (255) NOT NULL,
    columna_password VARCHAR (255) NOT NULL
)Engine InnoDB default charset=latin1;

