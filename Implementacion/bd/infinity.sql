-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-01-2019 a las 07:52:25
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
-- Estructura de tabla para la tabla `advertisers`
--

CREATE TABLE `advertisers` (
  `id` int(9) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `organization` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `alias` varchar(12) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `advertisers`
--

INSERT INTO `advertisers` (`id`, `name`, `organization`, `alias`) VALUES
(11, 'Javier', 'Sngular', 'Sr. Javi'),
(12, 'Andres', 'Ayesa', 'Sr. Andres'),
(13, 'Ander', 'The Coca Cola Company', 'Sr. Lak'),
(14, 'Irene', 'Oracle', 'Sra. Irene');

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
  `idLocation` int(11) NOT NULL COMMENT 'id de la localizacion donde se celebra el evento',
  `idAdvertisers` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `date_creation`, `date_celebration`, `host`, `rutaimagen`, `idLocation`, `idAdvertisers`, `group_id`) VALUES
(23, 'Festival On the Beach', 'asd', '2019-01-31 02:59:43', '2019-07-08 10:00:00', 'admin', 'eventPhotos/1548903583Horarios OTB.jpg', 27, 13, 0),
(24, 'BootCamp AYESA', 'Qué tecnología debes aprender? HTML y CSS son las obvias, pero... qué estudiar luego? Javascript, Ruby, PHP...? Qué tecnología te conviene aprender? Ven a nuestro bootcamp y descúbrelo!', '2019-01-31 03:04:49', '2019-02-13 16:00:00', 'admin', 'eventPhotos/1548903889pexels-photo-711009.jpeg', 28, 12, 0),
(25, 'Charla Blockchain', 'Descubre las últimas novedades', '2019-01-31 03:07:32', '2019-02-07 17:00:00', 'admin', 'eventPhotos/1548904052pexels-photo-942418.jpeg', 29, 0, 0),
(26, 'Fiesta online', 'Despues del examen', '2019-01-31 03:57:42', '2019-02-02 23:00:00', 'andresloko', 'eventPhotos/default.jpg', 0, 0, 0),
(27, 'El cielo del mes de febrero de 2019', 'Conoce los eventos astronómicos mas importantes del febrero', '2019-01-31 04:09:33', '2019-02-14 18:30:00', 'irene', 'eventPhotos/1548907773night-photograph-starry-sky-night-sky-star-957040.jpeg', 30, 0, 8),
(28, 'Primeros pasos en la creación de un website', 'Conoce todo lo que necesitas saber para tener el mejor sitede internet', '2019-01-31 04:20:45', '2019-02-28 17:00:00', 'pedrog', 'eventPhotos/1548908445pexels-photo-1181622.jpeg', 31, 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  `rutaImagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ruta de la imagen del grupo.',
  `encabezado` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gallery`
--

INSERT INTO `gallery` (`id`, `grupo`, `rutaImagen`, `encabezado`) VALUES
(49, 4, 'groupPhotos/4/1548906573pexels-photo-1015568.jpeg', 'Descanso'),
(50, 4, 'groupPhotos/4/1548906592pexels-photo-1595385.jpeg', 'Se nos alargó la reunion'),
(51, 4, 'groupPhotos/4/1548906606pexels-photo-1054974.jpeg', 'Hablando de blockchain'),
(52, 4, 'groupPhotos/4/1548906653pexels-photo-1407472.jpeg', 'En la playa'),
(53, 5, 'groupPhotos/5/1548906953pexels-photo-1530313.jpeg', 'Descanso tras la charla'),
(54, 5, 'groupPhotos/5/1548906993black-and-white-city-crosswalk-842339.jpg', 'Anonymous people'),
(55, 5, 'groupPhotos/5/1548907134workplace-1245776_1280.jpg', 'Divagando'),
(56, 6, 'groupPhotos/6/1548907228pexels-photo-716276.jpeg', 'Gran ponente'),
(57, 7, 'groupPhotos/7/1548907494pexels-photo-910330.jpeg', 'Torneo y programacion'),
(58, 7, 'groupPhotos/7/1548907519pexels-photo-951229.jpeg', 'Concentracion'),
(59, 7, 'groupPhotos/7/1548907560pexels-photo-1376866.jpeg', 'Jejeje'),
(60, 8, 'groupPhotos/8/1548907632nebula_pequeña.jpg', 'Nebulosa de Orión'),
(61, 8, 'groupPhotos/8/1548907676pexels-photo-1567069.jpeg', 'Salida 4/1/2019'),
(62, 8, 'groupPhotos/8/1548907702pexels-photo-712067.jpeg', 'Acampada'),
(63, 4, 'groupPhotos/4/1548914722pexels-photo-577585.jpeg', 'Programando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL,
  `name` varchar(140) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombe grupo',
  `descripcion` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `image_path` varchar(260) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `name`, `descripcion`, `image_path`) VALUES
(4, 'Databeers - Sevilla', 'Si eres programador, adicto a los datos, curioso innato', 'img/600_467439404.jpeg'),
(5, 'Hacking Sevilla', 'Grupo organizado por personas que son apasionadas de la tecnología y la seguridad informática en Sevilla. El objetivo es crear un comunidad local que permita realizar formación, charlas, quedadas y sobre todo aprender uno de los otros.', 'img/600_459134084.jpeg'),
(6, 'PHP Sevilla', 'En PHP Sevilla queremos crear una comunidad de desarrolladores en Sevilla que utilicen la tecnología relacionada con PHP para crear aplicaciones, herramientas y sitios web.', 'img/600_449416250.jpeg'),
(7, 'Ajedrez Sevilla', 'Vente a nuestros torneos', 'img/pexels-photo-1040157.jpeg'),
(8, 'Astronomía Sevilla', 'Conoce las efemérides de cada mes con nosotros', 'img/cosmos-1866583_1920.jpg'),
(9, 'Sunrise Blog Club', 'Sunrise Blog Club es una iniciativa de Nativo Social desarrollada para la creación de una comunidad de profesionales que quieran desarrollar técnicas y hábitos de redacción de posts y para la elaboración de blogs personales.', 'img/600_434867119.jpeg');

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
(27, 'Sacaba Beach', 'Sacaba Beach Málaga', 'Málaga', 36.678787, -4.446992),
(28, 'AYESA', '2 Calle Marie Curie', 'Sevilla', 37.405357, -6.005651),
(29, 'Bitnami', '31B Av. de la República Argentina', 'Sevilla', 37.376968, -6.002842),
(30, 'Casa de la Ciencia', '8 Av. de María Luisa', 'Sevilla', 37.377518, -5.991264),
(31, 'Bar Sevilla Cádiz', '15 Av. de Cádiz', 'Sevilla', 37.382996, -5.985318);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logro`
--

CREATE TABLE `logro` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `icon_path` varchar(260) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(2) NOT NULL COMMENT 'especificar que relacion consultar',
  `valor` int(10) NOT NULL COMMENT 'limite para activar el logro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `logro`
--

INSERT INTO `logro` (`id`, `name`, `icon_path`, `descripcion`, `tipo`, `valor`) VALUES
(1, 'coments', 'img/cup.png', 'muchos coments', 1, 3),
(2, 'Fotos', 'img/cup.png', 'Muchas fotos', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logros_grupo`
--

CREATE TABLE `logros_grupo` (
  `group_id` int(11) NOT NULL,
  `logro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `logros_grupo`
--

INSERT INTO `logros_grupo` (`group_id`, `logro_id`) VALUES
(4, 2);

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
(68, 'andresloko', 25, '2019-01-31 04:14:41', 'Me apunto'),
(69, 'andresloko', 27, '2019-01-31 04:15:01', 'Me vereis por alli'),
(70, 'irene', 27, '2019-01-31 04:16:12', 'Nos encantará verte por allí Andres'),
(71, 'irene', 23, '2019-01-31 04:16:31', 'Me flipa esto!!!'),
(72, 'pedrog', 26, '2019-01-31 04:17:44', 'yo estaré por ahi'),
(73, 'pedrog', 23, '2019-01-31 04:17:55', 'y a mi!!!!'),
(74, 'pedrog', 28, '2019-01-31 04:21:13', 'Me gustaría mucho participar, estaré por allí');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id`, `username`, `id_evento`) VALUES
(3, 'andresloko', 27),
(4, 'andresloko', 25),
(5, 'pedrog', 28),
(6, 'pedrog', 25),
(7, 'pedrog', 27),
(8, 'irene', 27),
(9, 'admin', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripcion_grupo`
--

CREATE TABLE `suscripcion_grupo` (
  `user_id` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'id usuario que se suscribe',
  `grupo_id` int(11) NOT NULL COMMENT 'id del grupo suscrito',
  `id` int(11) NOT NULL COMMENT 'ID de la relación',
  `rol` int(11) NOT NULL COMMENT '0 usuario normal, 1 administrador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `suscripcion_grupo`
--

INSERT INTO `suscripcion_grupo` (`user_id`, `grupo_id`, `id`, `rol`) VALUES
('andresloko', 0, 2, 1),
('admin', 0, 6, 1),
('admin', 4, 9, 1),
('andresloko', 5, 10, 1),
('javig', 6, 11, 1),
('javig', 0, 12, 1),
('javig', 7, 14, 1),
('irene', 8, 15, 1),
('pedrog', 9, 16, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `username` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `date_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` int(11) NOT NULL COMMENT '0 sera usuario normal, 1 administrador',
  `rutaimagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ruta de la imagen del usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`username`, `name`, `password`, `email`, `date_register`, `tipo`, `rutaimagen`) VALUES
('admin', 'Admin Infinity', '$2y$10$89WyLwCqq4YeaYB3hCOdkOg3sA3S44FQ4xx3ddkXc4.JpFir/QOui', 'infinity-no-reply@infinityevents.es', '2019-01-31 02:32:12', 1, 'userPhotos/1548901932pexels-photo-374720.jpeg'),
('andresloko', 'Andres Carvajal', '$2y$10$ocL0P4RWGJBa0qPLPe/f5.B4u2RqTBKewQFRAyTcFgMcOoX0uoisW', 'andresloko@fakemail.com', '2019-01-31 02:42:38', 0, 'userPhotos/1548902558pexels-photo-105017.jpeg'),
('carlosbar', 'Carlos Barroso', '$2y$10$AEGelmmG.6QXB5SoLQy0buD.NWyJ9FwwVFOB4PEDqk9n2ChOiGvvG', 'carlosbarr@fakemail.com', '2019-01-31 02:36:55', 0, 'userPhotos/1548902215pexels-photo-1308625.jpeg'),
('irene', 'Irene Ruiz', '$2y$10$JGEh2wLWgC8Mr/Ve8RPw5OKPO2DI3b149LJhL7Jnrnr8MoT/.tFZu', 'lapizrojo13@gmail.com', '2019-01-31 02:40:21', 0, 'userPhotos/1548902421pexels-photo-96886.jpeg'),
('javig', 'Javi G', '$2y$10$ZzbBxbXj4OQZJZqLl7U8QOVW.fSRw4X32QlEKMjXyIQyTFhU0jM3G', 'javiG@fakemail.com', '2019-01-31 02:43:44', 0, 'userPhotos/1548902624pexels-photo-845457.jpeg'),
('pedrog', 'Pedro Gomez', '$2y$10$tzTXJaZom34CLFXgEnnn3eCzwsqMe5Il1jQqQQBACzNY7GaiXZbzq', 'pedrog@fakemail.com', '2019-01-31 04:17:07', 0, 'userPhotos/1548908227pexels-photo-845457.jpeg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `advertisers`
--
ALTER TABLE `advertisers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logro`
--
ALTER TABLE `logro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `logros_grupo`
--
ALTER TABLE `logros_grupo`
  ADD UNIQUE KEY `group_id` (`group_id`,`logro_id`),
  ADD KEY `group_id_2` (`group_id`,`logro_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postedBy` (`postedBy`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `suscripcion_grupo`
--
ALTER TABLE `suscripcion_grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`grupo_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `advertisers`
--
ALTER TABLE `advertisers`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la localizacion', AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `logro`
--
ALTER TABLE `logro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del post', AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `suscripcion_grupo`
--
ALTER TABLE `suscripcion_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID de la relación', AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
