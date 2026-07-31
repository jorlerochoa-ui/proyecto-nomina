-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-07-2026 a las 22:53:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nomina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(100) NOT NULL,
  `valor_hora` decimal(10,2) NOT NULL,
  `valor_hora_extra` decimal(10,2) NOT NULL,
  `horas_trabajo_diario` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id_cargo`, `nombre_cargo`, `valor_hora`, `valor_hora_extra`, `horas_trabajo_diario`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Vendedor', 25000.00, 3.00, 3, '2026-07-31 13:59:21', '2026-07-31 20:22:36'),
(2, 'Desarrollador', 25000.00, 6.00, 6, '2026-07-31 14:34:46', '2026-07-31 20:22:39'),
(3, 'Asistente Gerencia', 25000.00, 5.00, 5, '2026-07-31 14:35:39', '2026-07-31 20:22:43'),
(7, 'Gerente', 120000.00, 145000.00, 8, '2026-07-31 20:44:42', '2026-07-31 20:44:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `cedula_empleado` bigint(20) DEFAULT NULL,
  `nombre_empleado` varchar(100) NOT NULL,
  `apellido_empleado` varchar(100) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `cedula_empleado`, `nombre_empleado`, `apellido_empleado`, `id_cargo`, `fecha_creacion`, `fecha_modificacion`) VALUES
(7, 1112322, 'jorler', 'ochoa', 2, '2026-07-31 20:29:26', '2026-07-31 20:29:26'),
(8, 544545, 'Arturo', 'Sabala', 7, '2026-07-31 20:46:12', '2026-07-31 20:46:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion_semanal`
--

CREATE TABLE `liquidacion_semanal` (
  `id_liquidacion` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `horas_extras` decimal(5,2) NOT NULL DEFAULT 0.00,
  `mes` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `semana` int(11) NOT NULL,
  `salario_total` decimal(12,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `liquidacion_semanal`
--

INSERT INTO `liquidacion_semanal` (`id_liquidacion`, `id_empleado`, `id_cargo`, `hora_entrada`, `hora_salida`, `horas_extras`, `mes`, `ano`, `semana`, `salario_total`, `fecha_creacion`, `fecha_modificacion`) VALUES
(17, 7, 2, '15:29:00', '21:29:00', 0.00, 7, 2026, 1, 150000.00, '2026-07-31 20:29:43', '2026-07-31 20:29:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `cedula_empleado` (`cedula_empleado`),
  ADD KEY `fk_empleado_cargo` (`id_cargo`);

--
-- Indices de la tabla `liquidacion_semanal`
--
ALTER TABLE `liquidacion_semanal`
  ADD PRIMARY KEY (`id_liquidacion`),
  ADD UNIQUE KEY `uk_liquidacion_empleado_periodo` (`id_empleado`,`semana`,`mes`,`ano`),
  ADD KEY `fk_liquidacion_cargo` (`id_cargo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `liquidacion_semanal`
--
ALTER TABLE `liquidacion_semanal`
  MODIFY `id_liquidacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_empleado_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `liquidacion_semanal`
--
ALTER TABLE `liquidacion_semanal`
  ADD CONSTRAINT `fk_liquidacion_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id_cargo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_liquidacion_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
