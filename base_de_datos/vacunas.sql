-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-08-2023 a las 21:12:06
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vacunas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_vacuna`
--

CREATE TABLE `detalle_vacuna` (
  `id_detalle_vacuna` int(10) NOT NULL,
  `documento` int(10) NOT NULL,
  `documento_user` int(10) NOT NULL,
  `vacuna` tinytext NOT NULL,
  `fecha_vacuna` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `estado` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_vacuna`
--

INSERT INTO `detalle_vacuna` (`id_detalle_vacuna`, `documento`, `documento_user`, `vacuna`, `fecha_vacuna`, `fecha_fin`, `estado`) VALUES
(2, 79464482, 1302020202, 'Gripe', '2023-08-12 16:53:09', '2024-08-12 16:53:09', 1),
(3, 79464482, 1302020202, 'yyyy', '2023-08-12 18:40:25', '2024-08-12 18:40:25', 1),
(4, 79464482, 1302020202, 'Malaria', '2023-08-12 21:11:02', '2024-08-12 21:11:02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `document` int(10) NOT NULL,
  `nombre_completo` tinytext NOT NULL,
  `telefono` varchar(40) NOT NULL,
  `tipo_usuario` int(3) NOT NULL,
  `estado` int(2) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`document`, `nombre_completo`, `telefono`, `tipo_usuario`, `estado`, `correo`, `fecha_registro`) VALUES
(79464482, 'Daniel Alvarez', '3210302030', 1, 1, 'alvarez@misena.edu.co', '2023-08-12 09:15:57'),
(1302020202, 'marcela saldarr', '3213525565', 2, 1, 'marcela@gmail.com', '2023-08-12 09:18:31');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_vacuna`
--
ALTER TABLE `detalle_vacuna`
  ADD PRIMARY KEY (`id_detalle_vacuna`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`document`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_vacuna`
--
ALTER TABLE `detalle_vacuna`
  MODIFY `id_detalle_vacuna` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
