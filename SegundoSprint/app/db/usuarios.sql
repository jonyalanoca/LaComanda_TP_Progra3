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

//creacion de tablas
create table if not EXISTS mesas(
    idMesa int AUTO_INCREMENT,
    estado varchar(50)
)

create table if not EXISTS productos(
    idProducto int AUTO_INCREMENT,
    PRIMARY KEY(idProducto),
    nombre varchar(20),
    precio decimal(10,2),
    stock int,
    seccion varchar(50),
    tiempoPreparacion int,
    descripcion varchar(100)
)AUTO_INCREMENT=1000

create table if not EXISTS empleados(
    idEmpleado int AUTO_INCREMENT,
    PRIMARY KEY(idEmpleado),
	nombre varchar(50),
    apellido varchar(50),
    edad int,
    dni int,
    email varchar(100),
    clave varchar(50),
    seccion varchar(50),
    sueldo decimal(10,2),
    fechaIngreso date,
    fechaEgreso date
)AUTO_INCREMENT=2000

create table if not EXISTS socios(
    idSocio int AUTO_INCREMENT,
    PRIMARY KEY(idSocio),
	nombre varchar(50),
    apellido varchar(50),
    edad int,
    dni int,
    email varchar(100),
    clave varchar(50),
	recaudacion decimal(10,2)
)AUTO_INCREMENT=2500

create table if not EXISTS comandas(
    idComanda int AUTO_INCREMENT,
    PRIMARY KEY(idComanda),
	id_Mesa int,
    id_Empleado int,
    nombreCliente varchar(50),
    fotoMesa varchar(200),
    fechaHora datetime,
    observacion varchar(200),
    FOREIGN KEY(id_Mesa) REFERENCES mesas(idMesa),
    FOREIGN KEY(id_Empleado) REFERENCES empleados(idEmpleado)
)AUTO_INCREMENT=10000

create table if not EXISTS ordenes(
    idOrden int AUTO_INCREMENT,
    PRIMARY KEY(idOrden),
    id_Comanda int,
    id_Producto int,
    FOREIGN KEY(id_Comanda) REFERENCES comandas(idComanda),
    FOREIGN KEY(id_Producto) REFERENCES productos(idProducto)
)AUTO_INCREMENT=20000





