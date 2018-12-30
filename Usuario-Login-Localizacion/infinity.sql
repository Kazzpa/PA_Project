-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-12-2018 a las 05:38:29
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
  `rutaimagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ruta de la imagen de un evento',
  `idLocation` int(11) NOT NULL COMMENT 'id de la localizacion donde se celebra el evento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `date_creation`, `date_celebration`, `host`, `rutaimagen`, `idLocation`) VALUES
(2, 'Fiesta Playa', 'No olvides la sombrilla!', '2018-12-25 16:17:50', '2018-01-01 23:00:00', 'irelia', 'eventPhotos/default.jpg', 1),
(3, 'Flemus', 'Introduzca una breve descripcion sobre el evento a realizar', '2018-12-25 16:18:15', '2018-01-02 01:05:00', 'irelia', 'eventPhotos/1546016255banquet-wedding-society-deco-50675.jpeg', 9),
(5, 'El cielo del mes de enero 2019', 'Charla sobre las efemÃ©rides del mes de enero de 2019', '2018-12-30 04:24:45', '2019-01-10 18:00:00', 'irelia', 'eventPhotos/1546143885nebula_pequeÃ±a.jpg', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL COMMENT 'id de la localizacion',
  `name` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre de la localizacion',
  `address` varchar(80) COLLATE utf8_spanish_ci NOT NULL COMMENT 'direccion de la localizacion',
  `city` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ciudad de la localizacion',
  `lat` float(10,6) NOT NULL COMMENT 'coordenadas latitud',
  `lng` float(10,6) NOT NULL COMMENT 'coordenadas longitud'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `locations`
--

INSERT INTO `locations` (`id`, `name`, `address`, `city`, `lat`, `lng`) VALUES
(1, 'FIBES - Palacio de Congresos', 'Av. Alcalde Luis Uruñuela', 'Sevilla', 37.403526, -5.936950),
(9, 'WiZink Center', 'S/N Av. Felipe II', 'Madrid', 40.423878, -3.671750),
(10, 'CafeterÃ­a HD', '67 Calle de GuzmÃ¡n el Bueno', 'Madrid', 40.436001, -3.713221),
(12, 'Sevilla (Plaza de Armas)', 's/n Puente del Cristo de la ExpiraciÃ³n el Cachorro', 'Sevilla', 37.391872, -6.003953),
(15, 'Bar Galleta', '31 Calle Corredera Baja de San Pablo', 'Madrid', 40.422684, -3.703638),
(16, 'Casa de la Ciencia', '8 Av. de MarÃ­a Luisa', 'Sevilla', 37.377518, -5.991264);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL COMMENT 'id del post',
  `idReply` int(11) NOT NULL COMMENT '0 si es comentario normal, >1 si es una respuesta a un comentario (y aqui se mostrara el id del comentario que responde)',
  `postedBy` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id usuario que realiza el comentario',
  `eventId` int(11) NOT NULL,
  `postedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha del comentario',
  `message` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'contenido del comentario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `idReply`, `postedBy`, `eventId`, `postedDate`, `message`) VALUES
(13, 0, 'Linger', 0, '2018-12-26 17:36:45', 'ni idea '),
(34, 0, 'irene', 0, '2018-12-27 00:28:41', 'Funciona?'),
(41, 0, 'irene', 0, '2018-12-26 22:54:44', 'no se que opinar'),
(46, 0, 'irene', 0, '2018-12-27 00:42:49', 'funciona por fin'),
(48, 0, 'irene', 0, '2018-12-27 00:59:43', 'me quedo por aqui'),
(51, 0, 'irene', 0, '2018-12-27 17:31:41', 'no se'),
(52, 0, 'irene', 0, '2018-12-28 02:19:23', 'ashdasdkahsdkahsdkahdkasjhdaksdhaksdÃ§jashÃ§\r\nÃ§ashdaksjdha\r\n\r\n\r\najsdhaksdha\r\n\r\n\r\nahsdjkasdha\r\njhsdkjas\r\n\r\n\r\nashdaksjda');

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
-- Indices de la tabla `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la localizacion', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del post', AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
