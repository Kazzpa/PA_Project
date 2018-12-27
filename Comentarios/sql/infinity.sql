-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2018 a las 18:36:43
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
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL COMMENT 'id del post',
  `postedBy` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id usuario que realiza el comentario',
  `eventId` int(11) NOT NULL,
  `postedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha del comentario',
  `message` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'contenido del comentario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `postedBy`, `eventId`, `postedDate`, `message`) VALUES
(13, 'Linger', 0, '2018-12-26 17:36:45', 'ni idea '),
(34, 'irene', 0, '2018-12-27 00:28:41', 'Funciona?'),
(41, 'irene', 0, '2018-12-26 22:54:44', 'no se que opinar'),
(46, 'irene', 0, '2018-12-27 00:42:49', 'funciona por fin'),
(48, 'irene', 0, '2018-12-27 00:59:43', 'me quedo por aqui'),
(51, 'irene', 0, '2018-12-27 17:31:41', 'opinion random');

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
  `tipo` int(11) NOT NULL COMMENT '0 sera usuario normal, 1 administrador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`username`, `name`, `password`, `email`, `date_register`, `tipo`) VALUES
('irelia', 'Pepe Lolo', '$2y$10$jvB2pCGSiZes6yIKpF.iNeOs/cGmcTtKfx8PAjR8uQCjGs/mSc4Gu', 'pepeyu@hotmail.com', '2018-12-24 23:41:32', 0),
('irene', 'Irene Gonzalez', '$2y$10$aGUG4HIBVPE5oF8MF9r10efGxUXp9KVMBbIGAOtsylrNOulvfkI02', 'lapizrojo13@gmail.co', '2018-12-25 12:55:30', 0),
('Linger', 'Irene Gon', '$2y$10$3HcWKP.oVZ5VPQ79woO.1Ofh1ilmd1TFXqphkvp7Mzw/Inq2emYK6', 'lapizrojo13@gmail.co', '2018-12-25 15:41:06', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postedBy` (`postedBy`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del post', AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`postedBy`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
