-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-12-2018 a las 19:02:35
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `infinity`
--
CREATE DATABASE IF NOT EXISTS `infinity` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `infinity`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL COMMENT 'Identificador',
  `name` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del evento',
  `description` varchar(500) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Descripcion sobre como sera el evento',
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion del evento',
  `date_celebration` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha cuando se celebrara el evento',
  `host` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario creador del evento',
  `rutaimagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ruta de la imagen de un evento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `date_creation`, `date_celebration`, `host`, `rutaimagen`) VALUES
(2, 'Fiesta Playa', 'No olvides la sombrilla!', '2018-12-25 16:17:50', '2018-01-01 23:00:00', 'irelia', 'eventPhotos/default.jpg'),
(3, 'Flemus', 'Introduzca una breve descripcion sobre el evento a realizar', '2018-12-25 16:18:15', '2018-01-02 01:05:00', 'irelia', 'eventPhotos/1546016255banquet-wedding-society-deco-50675.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `username` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `date_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` int(11) NOT NULL COMMENT '0 sera usuario normal, 1 administrador',
  `rutaimagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ruta de la imagen del usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`username`, `name`, `password`, `email`, `date_register`, `tipo`, `rutaimagen`) VALUES
('irelia', 'Pepe Lolo', '$2y$10$jvB2pCGSiZes6yIKpF.iNeOs/cGmcTtKfx8PAjR8uQCjGs/mSc4Gu', 'pepeyu@hotmail.com', '2018-12-24 23:41:32', 0, 'userPhotos/default.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
