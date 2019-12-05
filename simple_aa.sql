-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-07-2019 a las 01:00:57
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `simple_aa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cert_cert`
--

CREATE TABLE `cert_cert` (
  `id_cert` int(11) NOT NULL,
  `id_participa` int(11) NOT NULL,
  `participa` varchar(25) NOT NULL,
  `nivel_ponencia` varchar(255) NOT NULL,
  `validador` varchar(20) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `usuario` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cert_cert`
--

INSERT INTO `cert_cert` (`id_cert`, `id_participa`, `participa`, `nivel_ponencia`, `validador`, `id_evento`, `date_added`, `usuario`) VALUES
(1, 39, 'organizador', '', '62', 16, '2019-07-25 16:17:12', 'admin'),
(2, 13, 'participante', '', '9EEB5F', 16, '2019-07-25 16:21:42', 'joe'),
(3, 17, 'participante', '', '77310C', 16, '2019-07-25 16:36:15', 'joe'),
(4, 4, 'participante', '', '1E244', 16, '2019-07-25 16:36:15', 'joe'),
(5, 1, 'participante', '', '5AB360', 16, '2019-07-25 16:36:15', 'joe'),
(6, 45, 'facilitador', '', '4D48F9', 5, '2019-07-25 16:21:42', 'joe'),
(7, 13, 'asistido', '', '9EEB5F', 5, '2019-07-25 16:21:42', 'joe'),
(8, 21, 'asistido', '', '63E1EB', 5, '2019-07-25 16:21:42', 'joe'),
(9, 22, 'asistido', '', '143A8F', 5, '2019-07-25 16:21:42', 'joe'),
(10, 42, 'facilitador', '', '941B4F', 4, '2019-07-25 16:36:15', 'joe'),
(11, 17, 'aprobado', 'Autónomo Plus', '77310C', 4, '2019-07-25 16:36:15', 'joe'),
(12, 4, 'aprobado', 'Resolutivo', '1E244', 4, '2019-07-25 16:36:15', 'joe'),
(13, 1, 'aprobado', 'Autónomo Plus', '5AB360', 4, '2019-07-25 16:36:15', 'joe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cert_evento`
--

CREATE TABLE `cert_evento` (
  `id_evento` int(11) NOT NULL,
  `tipo_evento` varchar(20) NOT NULL,
  `nombre_evento` varchar(255) NOT NULL,
  `fecha_evento` date NOT NULL,
  `fechaletras` varchar(100) NOT NULL,
  `duracion` varchar(50) NOT NULL,
  `formato` varchar(20) NOT NULL,
  `tipo_firmas` double NOT NULL,
  `id_facilita` int(11) NOT NULL,
  `cert_public` double NOT NULL,
  `date_added` datetime NOT NULL,
  `usuario` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cert_evento`
--

INSERT INTO `cert_evento` (`id_evento`, `tipo_evento`, `nombre_evento`, `fecha_evento`, `fechaletras`, `duracion`, `formato`, `tipo_firmas`, `id_facilita`, `cert_public`, `date_added`, `usuario`) VALUES
(1, 'taller', 'Los 7 hábitos de la gente altamente efectiva', '2017-12-13', 'el 29 de abril de 2015', '16 horas', 'C03.jpg', 2, 5, 0, '2019-06-30 10:35:51', 'admin'),
(2, 'taller', 'Equipos de Alto Rendimiento', '2016-03-09', 'el 09 de marzo de 2016', '8 horas', 'A01.jpg', 2, 5, 0, '2019-06-30 10:38:02', 'admin'),
(3, 'simposio', 'La universidad que tenemos, la universidad que queremos', '2015-11-26', 'el día 26 de noviembre de 2015', '6 horas', 'C01.jpg', 2, 5, 0, '2019-06-30 10:40:38', 'admin'),
(4, 'taller', 'El docente y la formacion en valores', '2016-02-23', 'del 23 al 26 de febrero de 2016', '6 horas', 'C01.jpg', 2, 2, 1, '2019-06-30 14:02:58', 'admin'),
(5, 'taller', 'Cartografía General', '2019-07-15', 'los dias 15, 16 y 18 de julio de 2019', '40 horas', 'C02.jpg', 2, 5, 1, '2019-06-30 14:10:59', 'admin'),
(9, 'curso', 'PowerPoint Básico', '2017-05-20', 'los dias 15, 16 y 18 de julio de 2019', '6 horas', 'C02.jpg', 2, 5, 0, '2019-06-30 14:37:38', 'admin'),
(11, 'taller', 'word para windows ver 16', '2017-05-20', 'los dias 15, 16 y 18 de julio de 2019', '40 horas', 'C01.jpg', 2, 5, 0, '2019-06-30 14:44:49', 'admin'),
(12, 'taller', 'excel', '2017-05-20', 'los dias 15, 16 y 18 de julio de 2019', '40 horas', 'C01.jpg', 2, 2, 0, '2019-06-30 14:57:15', 'admin'),
(13, 'curso', 'Ionic 4', '2017-05-20', 'los dias 15, 16 y 18 de julio de 2019', '40 horas', 'C01.jpg', 2, 6, 0, '2019-06-30 17:42:23', 'admin'),
(14, 'curso', 'Flutter', '2017-05-20', 'los dias 15, 16 y 18 de julio de 2019', '6 horas', 'B04.jpg', 2, 1, 0, '2019-06-30 17:44:53', 'admin'),
(16, 'jornada', 'Anestesia y sutura', '2019-07-30', 'los días 30 y 31 de julio de 2019', '20 horas', 'C01.jpg', 3, 1, 1, '2019-07-01 18:33:53', 'admin'),
(18, 'jornada', 'Gerencia de producción', '2019-07-04', 'el día 04 de julio de 2019', '8 horas', 'C03.jpg', 3, 5, 0, '2019-07-09 22:45:21', 'admin'),
(21, 'curso', 'Geografía Universal', '2019-07-04', 'el dia 04 de julio de 2019', '6 horas', 'C01.jpg', 3, 1, 0, '2019-07-19 00:23:40', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cert_facilita`
--

CREATE TABLE `cert_facilita` (
  `id_facilita` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `titulo` varchar(10) NOT NULL,
  `nombres` char(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(64) NOT NULL,
  `firma` varchar(20) NOT NULL,
  `date_added` datetime NOT NULL,
  `usuario` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cert_facilita`
--

INSERT INTO `cert_facilita` (`id_facilita`, `cedula`, `titulo`, `nombres`, `telefono`, `correo`, `firma`, `date_added`, `usuario`) VALUES
(1, '59', 'Prof.', 'Hector Medina', '0412-', 'hectormedina@gmail.com', 'hectormedina.png', '2019-06-30 00:18:00', 'admin'),
(2, '9706277', 'Prof.', 'Flor Ledesma', '555', 'minervacoro@gmail.com', '', '2019-06-30 00:19:20', 'admin'),
(3, '5778501', 'Prof.', 'Milagro Matheus Barrios', '5555', 'mila.matheus44@gmail.com', '', '2019-06-30 00:20:44', 'admin'),
(4, '18921961', 'Dr.', 'Diego Muñoz Cabas', '5', 'diego_smc77@hotmail.com', 'hectormedina.png', '2019-06-30 00:21:54', 'admin'),
(5, '5064908', 'Dra.', 'Yasmile Navarro', '0412-1709460', 'yasmile.ccp@gmail.com', 'yasmilenavarro.png', '2019-06-30 00:23:32', 'admin'),
(6, '13609741', 'Lcdo.', 'Reynaldo Meza', '6', 'reyorientador@gmail.com', 'reynaldomeza.png', '2019-06-30 00:24:47', 'admin'),
(7, '2894078', 'MSc.', 'Carmen Victoria Flores', '7', 'carviflor@gmail.com ', 'carmenflores.png', '2019-06-30 01:02:49', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cert_participa`
--

CREATE TABLE `cert_participa` (
  `id_participa` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(64) NOT NULL,
  `date_added` datetime NOT NULL,
  `usuario` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cert_participa`
--

INSERT INTO `cert_participa` (`id_participa`, `cedula`, `nombres`, `telefono`, `correo`, `date_added`, `usuario`) VALUES
(1, '5944159', 'José Luis Aguilar Gómez', '04125460954', 'jaguilarphp@gmail.com', '2019-06-15 15:29:43', ''),
(4, '123456', 'José Ramón Pérez Gómez', '04125730028', 'alegdy@gmail.com', '2019-06-18 20:24:20', ''),
(13, '10414930', 'Cristofer Jesús Aguilar Hernández', '04125730025', 'crisjaguilarh@gmail.com', '2019-06-22 23:48:32', ''),
(17, '7811323', 'Aida Villarroel', '04148584841', 'aida@gmail.com', '2019-06-23 02:10:07', ''),
(23, '7833333', 'Maritza Guerrero', '04148584841', 'maritzaguerrero@gmail.com', '2019-06-23 05:04:59', ''),
(20, '5944162', 'José Francisco Aguilar Gómez', '04148584875', 'joseluisaguilar@gmail.com', '2019-06-23 04:03:33', ''),
(21, '6545878', 'Mary Luz Aguilar Gómez', '04146258478', 'joseluisaguilar@gmail.com', '2019-06-23 04:07:49', ''),
(24, '555556', 'José José González', '04148584875', 'joseluisaguilar@gmail.com', '2019-06-23 19:06:10', ''),
(22, '1325689', 'Ana Karina Montilla Gómez', '04148584841', 'anakarinamontilla@gmail.com', '2019-06-23 04:35:15', ''),
(36, '2525', 'José Alberto Sierra', '0414', 'josesierra@gmail.com', '2019-06-30 10:58:47', 'admin'),
(37, '7832813', 'Benilde Hernández', '04148584875', 'benildehernandez@gmail.com', '2019-07-01 16:34:17', 'admin'),
(38, '29', 'Luis Andrés Rodríguez', '04148584875', 'joseluisaguilar@gmail.com', '2019-07-08 08:13:48', 'admin'),
(39, '59', 'Hector Medina', '0414', 'hectormedina@gmail.com', '2019-07-24 22:19:57', 'joe'),
(40, '2894078', 'Carmen Victoria Flores', '7', 'carviflor@gmail.com', '2019-07-24 23:10:00', 'joe'),
(41, '18921961', 'Diego Muñoz Cabas	', '5', 'diego_smc77@hotmail.com', '2019-07-24 23:11:24', 'joe'),
(42, '9706277', 'Flor Ledesma	', '555', 'minervacoro@gmail.com', '2019-07-24 23:12:59', 'joe'),
(43, '5778501', 'Milagro Matheus Barrios', '5555', 'mila.matheus44@gmail.com', '2019-07-24 23:14:35', 'joe'),
(44, '13609741', 'Reynaldo Meza', '6', 'reyorientador@gmail.com', '2019-07-24 23:15:52', 'joe'),
(45, '5064908', 'Yasmile Navarro', '0412-1709460	', 'yasmile.ccp@gmail.com', '2019-07-24 23:17:40', 'joe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cert_temp`
--

CREATE TABLE `cert_temp` (
  `id_cert` int(11) NOT NULL,
  `id_participa` int(11) NOT NULL,
  `participa` varchar(25) NOT NULL,
  `nivel_ponencia` varchar(255) NOT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cert_users`
--

CREATE TABLE `cert_users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `cert_users`
--

INSERT INTO `cert_users` (`user_id`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `date_added`) VALUES
(1, 'Obed', 'Alvarado', 'admin', '$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO', 'admin@admin.com', '2016-05-21 15:06:00'),
(5, 'José Luis', 'Aguilar Gómez', 'joe', '$2y$10$DSsdsMbWDuzOdAGi0zsFqu0MB9czhAyl61rnZqKl7XDdLsOArKPRK', 'jaguilarphp@gmail.com', '2019-06-23 05:23:50'),
(6, 'Cristrofer Jesús', 'Aguilar Hernández', 'cristofer', '$2y$10$J0X01XVCGXQNgM1pBOreIeBuppbsvRBA0UsfWzp099NGBNuUQ0.gW', 'crist@gmail.com', '2019-06-23 05:30:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` int(11) NOT NULL,
  `id_facilita` int(11) NOT NULL,
  `id_participa` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_cert` int(11) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp`
--

CREATE TABLE `tmp` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` int(11) NOT NULL,
  `precio_tmp` double(8,2) DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tmp`
--

INSERT INTO `tmp` (`id_tmp`, `id_producto`, `cantidad_tmp`, `precio_tmp`, `session_id`) VALUES
(1, 1, 1, 12000.00, '8gmkd1stgi73v4g3i4o21rkg1a');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cert_cert`
--
ALTER TABLE `cert_cert`
  ADD PRIMARY KEY (`id_cert`),
  ADD KEY `id_participa` (`id_participa`);

--
-- Indices de la tabla `cert_evento`
--
ALTER TABLE `cert_evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD UNIQUE KEY `codigo_producto` (`nombre_evento`);

--
-- Indices de la tabla `cert_facilita`
--
ALTER TABLE `cert_facilita`
  ADD PRIMARY KEY (`id_facilita`),
  ADD UNIQUE KEY `codigo_producto` (`cedula`);

--
-- Indices de la tabla `cert_participa`
--
ALTER TABLE `cert_participa`
  ADD PRIMARY KEY (`id_participa`),
  ADD UNIQUE KEY `codigo_producto` (`cedula`);

--
-- Indices de la tabla `cert_temp`
--
ALTER TABLE `cert_temp`
  ADD PRIMARY KEY (`id_cert`),
  ADD KEY `id_participa` (`id_participa`);

--
-- Indices de la tabla `cert_users`
--
ALTER TABLE `cert_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`id_facilita`,`id_participa`),
  ADD KEY `cantidad` (`id_evento`),
  ADD KEY `id_cert` (`id_cert`);

--
-- Indices de la tabla `tmp`
--
ALTER TABLE `tmp`
  ADD PRIMARY KEY (`id_tmp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cert_cert`
--
ALTER TABLE `cert_cert`
  MODIFY `id_cert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cert_evento`
--
ALTER TABLE `cert_evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cert_facilita`
--
ALTER TABLE `cert_facilita`
  MODIFY `id_facilita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cert_participa`
--
ALTER TABLE `cert_participa`
  MODIFY `id_participa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `cert_temp`
--
ALTER TABLE `cert_temp`
  MODIFY `id_cert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `cert_users`
--
ALTER TABLE `cert_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tmp`
--
ALTER TABLE `tmp`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
