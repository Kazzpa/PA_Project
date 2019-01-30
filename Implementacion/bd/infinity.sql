-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-01-2019 a las 16:33:01
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.2.5

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
(1, 'javier', 'Sngular', 'Sr. Javi'),
(8, 'Andres', 'Ayesa', 'Sr. Andrés'),
(9, 'Ander', 'The Coca Cola Company', 'alias3'),
(10, 'Irene', 'Oracle', 'Sra. Irene');

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
(20, 'Hack and Beers #SVQ10FEB', 'Evento  de Hack and Beers en Sevilla.', '2019-01-21 11:05:45', '2019-02-10 16:30:00', 'irene', 'eventPhotos/default.jpg', 26, 0, 3),
(21, 'Hack and Beers #SVQ20FEB', 'Vamos a quedar para hablar sobre seguridad informatica en IOT', '2019-01-21 12:48:55', '2019-02-20 18:30:00', 'irene', 'eventPhotos/default.jpg', 0, 0, 0),
(22, 'Hack and Beers #SVQ10MAR', 'bebemo servesa', '2019-01-21 13:39:51', '2019-03-10 18:30:00', 'irene', 'eventPhotos/default.jpg', 0, 0, 3);

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
(20, 3, 'groupPhotos/3/1547581417201279_ml.jpg', 'Charla de Steve Jobs'),
(41, 3, 'groupPhotos/3/1547941321pexels-photo-716276.jpeg', 'Charla sobre arte'),
(42, 3, 'groupPhotos/3/1547941332pexels-photo-1530313.jpeg', 'Descanso'),
(43, 3, 'groupPhotos/3/1547941368pexels-photo-711009.jpeg', 'conociendo gente'),
(44, 3, 'groupPhotos/3/1547941379pexels-photo-1181622.jpeg', 'nuevas tecnologias'),
(45, 3, 'groupPhotos/3/1547941405pexels-photo-942418.jpeg', 'tazas gratis'),
(46, 3, 'groupPhotos/3/1547941435pexels-photo-1595385.jpeg', 'se alargo la reunion'),
(47, 3, 'groupPhotos/3/1547941531pexels-photo-1015568.jpeg', 'de risas'),
(48, 3, 'groupPhotos/3/1547941589pexels-photo-1054974.jpeg', 'sala de descanso');

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
(3, 'Hack and Beers', 'Ponencias gratuitas para interesados en la seguridad informática. Ambiente distendido y acompañando las charlas con unas Beers. ¡Únete a la comunidad H&B!', 'img/hackandbeers.png'),
(7, 'DataBeers Sevilla', 'Si eres programador, adicto a los datos, curioso innato, fisgón de la tecnología, amante de las charlas, futurólogo de la tecnología', 'img/600_467439404.jpg');

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
(16, 'Casa de la Ciencia', '8 Av. de MarÃ­a Luisa', 'Sevilla', 37.377518, -5.991264),
(21, 'Sala X', '7 Calle JosÃ© DÃ­az', 'Sevilla', 37.408699, -5.990033),
(22, 'Ashford', 'Ashford Ashford', 'Kent', 51.146465, 0.875019),
(23, 'Principado de Asturias', 'Principado de Asturias O', 'ES', 43.361397, -5.859327),
(24, 'Leonberg', 'Leonberg BB', 'SÃ¼d', 48.796043, 9.009571),
(25, 'Torre del Oro', 's/n Paseo de CristÃ³bal ColÃ³n', 'Sevilla', 37.382412, -5.996490),
(26, 'Tea&Coffee', '2 Av. de Ramón y Cajal', 'Sevilla', 37.377411, -5.976763);

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
(1, 'medalla oro fotos', 'img/trophy.png', 'obtener 2 fotos en la galeria', 2, 2),
(2, 'test', 'img/trophy.png', 'test', 3, 2);

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
(3, 1),
(4, 1);

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
(70, 0, 'andres', 20, '2019-01-30 15:16:52', 'Podemos quedar un rato antes y tomar una cerveza! quien se apunta?');

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
(1, 'irelia', 20),
(3, 'german', 20),
(4, 'irene', 20),
(5, 'javi', 20),
(6, 'paco', 20);

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
('irene', 3, 1, 1),
('german', 3, 2, 0),
('andres', 3, 16, 0),
('andres', 7, 24, 1);

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
('andres', 'andres loco', '$2y$10$IG59GcIikLNPfFTuUJ8w8eOkXUEbQDLZsIXrtXLmtDdJZJEQ1rIZq', 'andres97cb@hotmail.com', '2019-01-30 11:36:14', 0, 'userPhotos/default.png'),
('irene', 'Irene Glez', '$2y$10$GpTL5a3SmldpvhC8ZY/a4OzUE0nhIcpeLuuphI8XhGNHX02AsocWC', 'irene@irene.com', '2018-12-30 15:59:42', 1, 'userPhotos/default.png');

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
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la localizacion', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `logro`
--
ALTER TABLE `logro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del post', AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `suscripcion_grupo`
--
ALTER TABLE `suscripcion_grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID de la relación', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
