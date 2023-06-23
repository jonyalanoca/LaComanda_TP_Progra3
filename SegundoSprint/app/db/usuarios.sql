-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-03-2021 a las 21:21:28
-- Versión del servidor: 8.0.13-4
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda_db`
--

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS mesas(
    idMesa INT AUTO_INCREMENT,
    PRIMARY KEY(idMesa),
    estado VARCHAR(50)
);
CREATE TABLE IF NOT EXISTS productos(
    idProducto INT AUTO_INCREMENT,
    PRIMARY KEY(idProducto),
    nombre VARCHAR(20),
    precio DECIMAL(10, 2),
    stock INT,
    seccion VARCHAR(50),
    tiempoPreparacion INT,
    descripcion VARCHAR(100)
) AUTO_INCREMENT = 1000;
CREATE TABLE IF NOT EXISTS empleados(
    idEmpleado INT AUTO_INCREMENT,
    PRIMARY KEY(idEmpleado),
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    edad INT,
    dni INT,
    email VARCHAR(100),
    clave VARCHAR(150),
    seccion VARCHAR(50),
    sueldo DECIMAL(10, 2),
    fechaIngreso DATE,
    fechaEgreso DATE,
    estado VARCHAR(50)
) AUTO_INCREMENT = 2000;
CREATE TABLE IF NOT EXISTS socios(
    idSocio INT AUTO_INCREMENT,
    PRIMARY KEY(idSocio),
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    edad INT,
    dni INT,
    email VARCHAR(100),
    clave VARCHAR(150),
    recaudacion DECIMAL(10, 2)
) AUTO_INCREMENT = 2500;
CREATE TABLE IF NOT EXISTS comandas(
    idComanda INT AUTO_INCREMENT,
    PRIMARY KEY(idComanda),
    id_Mesa INT,
    id_Empleado INT,
    nombreCliente VARCHAR(50),
    fotoMesa VARCHAR(200),
    fechaHora DATETIME,
    observacion VARCHAR(200)
) AUTO_INCREMENT = 10000;
CREATE TABLE IF NOT EXISTS ordenes(
    idOrden INT AUTO_INCREMENT,
    PRIMARY KEY(idOrden),
    id_Comanda INT,
    id_Producto INT,
    tiempoEstimado INT,
    estado VARCHAR(50)
) AUTO_INCREMENT = 20000;

/*Creacion de un socio para pruebas:*/;
/*Autentificacion- email:socioAdmin123@gmail.com clave:socioAdmin123*/;
insert into socios(nombre, apellido, edad, dni,email, clave, recaudacion)values('Jonathan','Alanoca',30,38375511,'socioAdmin123@gmail.com','$2y$10$PQU90Q9Vl7v5Cj9B1CglzuGl8w9gEJG3K3yPQCsDw/U6eb4IjldAW',0);


