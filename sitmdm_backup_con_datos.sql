-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2024 a las 01:48:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sitmdm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_Asistencia` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_Materia` int(11) NOT NULL,
  `presente` tinyint(4) NOT NULL,
  `horas_asistidas` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id_Asistencia`, `id_estudiante`, `id_Materia`, `presente`, `horas_asistidas`, `fecha`) VALUES
(1, 1, 1, 1, 100, '2024-10-31 09:08:26'),
(2, 8, 1, 0, 0, '2024-10-31 09:14:27'),
(4, 2, 1, 1, 0, '2024-11-04 18:09:49'),
(5, 3, 1, 1, 0, '2024-11-04 18:10:07'),
(6, 4, 1, 1, 1, '2024-11-04 18:10:11'),
(7, 5, 1, 0, 2, '2024-11-04 18:10:21'),
(8, 6, 1, 1, 0, '2024-11-04 18:10:26'),
(9, 9, 1, 0, 0, '2024-11-04 18:12:02'),
(10, 7, 1, 1, 0, '2024-11-04 18:12:06'),
(11, 8, 1, 0, 0, '2024-11-04 18:28:53'),
(12, 1, 3, 1, 100, '2024-11-04 18:31:15'),
(13, 10, 1, 1, 1, '2024-11-04 18:44:15'),
(14, 2, 3, 0, 0, '2024-11-04 18:45:18'),
(15, 1, 2, 1, 100, '2024-11-12 18:53:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `idCertificado` int(20) NOT NULL,
  `id_estudiante` int(20) NOT NULL,
  `FechaSolicitud` date NOT NULL,
  `TipoCertificado` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `idEstado` int(20) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_Tecnicatura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificados`
--

INSERT INTO `certificados` (`idCertificado`, `id_estudiante`, `FechaSolicitud`, `TipoCertificado`, `idEstado`, `fecha`, `id_Tecnicatura`) VALUES
(1, 1, '2024-10-07', 'Espacios Acreditados', 1, '2024-10-23 21:03:23', 1),
(2, 1, '2024-10-07', 'Porcentaje de Materias', 1, '2024-10-23 20:39:26', 1),
(3, 1, '2024-10-07', 'Alumno Regular', 1, '2024-10-23 20:49:42', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativas`
--

CREATE TABLE `correlativas` (
  `id_corr` int(11) NOT NULL,
  `idTec` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  `idCorrelativas` int(11) NOT NULL,
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `correlativas`
--

INSERT INTO `correlativas` (`id_corr`, `idTec`, `idMateria`, `idCorrelativas`, `FechaMod`) VALUES
(1, 1, 3, 2, '2024-10-21 06:11:11'),
(2, 2, 6, 5, '2024-10-21 06:11:11'),
(3, 3, 9, 8, '2024-10-21 06:11:11'),
(4, 4, 12, 10, '2024-10-21 06:11:11'),
(5, 5, 14, 11, '2024-10-21 06:11:11'),
(6, 6, 17, 15, '2024-10-21 06:11:11'),
(7, 7, 19, 18, '2024-10-21 06:11:11'),
(8, 8, 21, 20, '2024-10-21 06:11:11'),
(9, 9, 22, 21, '2024-10-21 06:11:11'),
(10, 10, 23, 22, '2024-10-21 06:11:11'),
(11, 11, 24, 23, '2024-10-21 06:11:11'),
(12, 12, 25, 24, '2024-10-21 06:11:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentesmaterias`
--

CREATE TABLE `docentesmaterias` (
  `iddocentesmaterias` int(11) NOT NULL,
  `id_Persona` int(10) UNSIGNED NOT NULL,
  `id_Materia` int(11) NOT NULL,
  `Estado` tinyint(4) NOT NULL DEFAULT 1,
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentesmaterias`
--

INSERT INTO `docentesmaterias` (`iddocentesmaterias`, `id_Persona`, `id_Materia`, `Estado`, `FechaMod`) VALUES
(1, 6, 29, 1, '2024-11-05 05:45:24'),
(2, 6, 30, 1, '2024-11-05 05:45:35'),
(3, 7, 10, 1, '2024-11-05 05:45:49'),
(4, 7, 21, 1, '2024-11-05 05:46:21'),
(5, 5, 1, 1, '2024-11-12 12:32:13'),
(6, 5, 2, 1, '2024-11-12 12:32:13'),
(7, 5, 3, 1, '2024-11-12 12:32:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idEstado` int(11) NOT NULL,
  `estado` varchar(12) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idEstado`, `estado`, `fecha`) VALUES
(1, 'pendiente', '2024-10-23 20:47:04'),
(2, 'aprobado', '2024-10-23 20:46:57'),
(3, 'caducado', '2024-10-23 20:46:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL,
  `numero_establecimiento` varchar(50) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `posee_dni` varchar(1) DEFAULT NULL,
  `dni_numero` varchar(8) DEFAULT NULL,
  `cuil` varchar(11) DEFAULT NULL,
  `tiene_cpi` varchar(2) DEFAULT NULL,
  `documento_extranjero` varchar(2) DEFAULT NULL,
  `tipo_documento_extranjero` varchar(100) DEFAULT NULL,
  `numero_documento_extranjero` varchar(50) DEFAULT NULL,
  `identidad_genero` varchar(2) DEFAULT NULL,
  `lugar_nacimiento` varchar(2) DEFAULT NULL,
  `especificar_pais` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `piso` varchar(10) DEFAULT NULL,
  `torre` varchar(10) DEFAULT NULL,
  `departamento` varchar(10) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUsuario` int(10) UNSIGNED DEFAULT NULL,
  `Estado` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `numero_establecimiento`, `apellido`, `nombre`, `telefono`, `email`, `posee_dni`, `dni_numero`, `cuil`, `tiene_cpi`, `documento_extranjero`, `tipo_documento_extranjero`, `numero_documento_extranjero`, `identidad_genero`, `lugar_nacimiento`, `especificar_pais`, `provincia`, `ciudad`, `codigo_postal`, `calle`, `localidad`, `distrito`, `numero`, `piso`, `torre`, `departamento`, `fecha_registro`, `idUsuario`, `Estado`) VALUES
(1, '1001', 'González', 'Carlos', '1234567890', 'carlos.gonzalez@example.com', '1', '12345678', '20123456789', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'CABA', '1000', 'Calle Falsa', NULL, NULL, '123', '1', NULL, 'A', '2024-09-01 09:00:00', 6, 1),
(2, '1002', 'Pérez', 'Ana', '9876543210', 'ana.perez@example.com', '1', '87654321', '20987654321', 'SI', 'NO', NULL, NULL, '2', '1', NULL, 'Buenos Aires', 'La Plata', '1900', 'Avenida Siempreviva', NULL, NULL, '456', '2', NULL, 'B', '2024-09-01 09:00:00', NULL, 1),
(3, '1003', 'López', 'Martín', '2223334440', 'martin.lopez@example.com', '1', '13579246', '20135792468', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'Tigre', '1600', 'Calle 13', NULL, NULL, '789', '3', NULL, 'C', '2024-09-01 09:00:00', NULL, 1),
(4, '1004', 'Fernández', 'Lucía', '3334445550', 'lucia.fernandez@example.com', '1', '24681357', '20246813579', 'SI', 'NO', NULL, NULL, '2', '1', NULL, 'Buenos Aires', 'Quilmes', '1876', 'Calle 9', NULL, NULL, '159', '4', NULL, 'D', '2024-09-01 09:00:00', NULL, 1),
(5, '1005', 'Gómez', 'Juan', '4445556660', 'juan.gomez@example.com', '1', '35715948', '20357159482', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'San Isidro', '1642', 'Calle 10', NULL, NULL, '753', '5', NULL, 'E', '2024-09-01 09:00:00', NULL, 0),
(6, '1006', 'Rodríguez', 'María', '5556667770', 'maria.rodriguez@example.com', '1', '46825713', '20468257135', 'SI', 'NO', NULL, NULL, '2', '1', NULL, 'Buenos Aires', 'Morón', '1708', 'Avenida del Libertador', NULL, NULL, '202', '6', NULL, 'F', '2024-09-01 09:00:00', NULL, 1),
(7, '1007', 'Martínez', 'Javier', '6667778880', 'javier.martinez@example.com', '1', '57931524', '20579315246', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'Lomas de Zamora', '1832', 'Avenida Mitre', NULL, NULL, '666', '7', NULL, 'G', '2024-09-01 09:00:00', NULL, 1),
(8, '1008', 'Sosa', 'Sofía', '7778889990', 'sofia.sosa@example.com', '1', '68024635', '20680246357', 'SI', 'NO', NULL, NULL, '2', '1', NULL, 'Buenos Aires', 'Lanús', '1824', 'Calle Libertad', NULL, NULL, '111', '8', NULL, 'H', '2024-09-01 09:00:00', NULL, 1),
(9, '1009', 'Álvarez', 'Matías', '8889990000', 'matias.alvarez@example.com', '1', '79135746', '20791357468', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'Avellaneda', '1870', 'Calle Independencia', NULL, NULL, '222', '9', NULL, 'I', '2024-09-01 09:00:00', NULL, 1),
(10, '1010', 'Ramírez', 'Laura', '9990001110', 'laura.ramirez@example.com', '1', '80246857', '20802468579', 'SI', 'NO', NULL, NULL, '2', '1', NULL, 'Buenos Aires', 'Escobar', '1625', 'Calle República', NULL, NULL, '333', '10', NULL, 'J', '2024-09-01 09:00:00', NULL, 1),
(11, '1011', 'Torres', 'Lucas', '0001112220', 'lucas.torres@example.com', '1', '91357968', '20913579680', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'San Fernando', '1646', 'Avenida Perón', NULL, NULL, '444', '11', NULL, 'K', '2024-09-01 09:00:00', NULL, 1),
(12, '1012', 'Díaz', 'Clara', '1112223330', 'clara.diaz@example.com', '1', '02468135', '20024681357', 'SI', 'NO', NULL, NULL, '2', '1', NULL, 'Buenos Aires', 'San Miguel', '1663', 'Avenida San Martín', NULL, NULL, '555', '12', NULL, 'L', '2024-09-01 09:00:00', NULL, 1),
(13, '1013', 'Moreno', 'Ignacio', '2223334440', 'ignacio.moreno@example.com', '1', '13579246', '20135792468', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'San Martín', '1650', 'Calle Buenos Aires', NULL, NULL, '666', '13', NULL, 'M', '2024-09-01 09:00:00', NULL, 1),
(14, '1014', 'Muñoz', 'Valentina', '3334445550', 'valentina.munoz@example.com', '1', '24681357', '20246813579', 'SI', 'NO', NULL, NULL, '2', '1', NULL, 'Buenos Aires', 'José C. Paz', '1665', 'Avenida Presidente Perón', NULL, NULL, '777', '14', NULL, 'N', '2024-09-01 09:00:00', NULL, 1),
(15, '1015', 'Rojas', 'Federico', '4445556660', 'federico.rojas@example.com', '1', '35715948', '20357159482', 'SI', 'NO', NULL, NULL, '3', '1', NULL, 'Buenos Aires', 'Vicente López', '1638', 'Calle Italia', NULL, NULL, '888', '15', NULL, 'O', '2024-09-01 09:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes_planillas`
--

CREATE TABLE `estudiantes_planillas` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `entrega_dni` tinyint(1) NOT NULL,
  `entrega_partida` tinyint(1) NOT NULL,
  `entrega_fotos` tinyint(1) NOT NULL,
  `entrega_titulo` tinyint(1) NOT NULL,
  `entrega_certificado` tinyint(1) NOT NULL,
  `entrega_inscripcion` tinyint(1) NOT NULL,
  `entrega_carpeta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_materia`
--

CREATE TABLE `estudiante_materia` (
  `id_estudiante_materia` int(11) NOT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `id_Materia` int(11) DEFAULT NULL,
  `nota_primer_cuatrimestre` decimal(5,2) DEFAULT NULL,
  `nota_segundo_cuatrimestre` decimal(5,2) DEFAULT NULL,
  `id_Tipocursada` int(11) NOT NULL,
  `observaciones` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiante_materia`
--

INSERT INTO `estudiante_materia` (`id_estudiante_materia`, `id_estudiante`, `id_Materia`, `nota_primer_cuatrimestre`, `nota_segundo_cuatrimestre`, `id_Tipocursada`, `observaciones`) VALUES
(1, 1, 1, 8.50, 7.00, 3, ''),
(2, 1, 2, 5.00, 5.00, 3, ''),
(3, 1, 3, 7.50, 6.50, 3, ''),
(4, 2, 1, 6.00, 7.00, 3, ''),
(5, 2, 2, 8.50, 7.50, 3, ''),
(6, 2, 3, 7.00, 6.00, 3, ''),
(7, 3, 1, 2.00, 8.50, 3, ''),
(8, 3, 2, 8.00, 7.00, 3, ''),
(9, 3, 3, 6.50, 7.50, 3, ''),
(10, 4, 1, 8.00, 7.50, 3, ''),
(11, 4, 2, 7.00, 6.50, 3, ''),
(12, 4, 3, 8.50, 7.00, 3, ''),
(13, 5, 1, 7.50, 8.00, 3, ''),
(14, 5, 2, 6.50, 7.00, 3, ''),
(15, 5, 3, 9.00, 8.50, 3, ''),
(16, 6, 1, 7.00, 6.50, 3, ''),
(17, 6, 2, 8.00, 7.50, 3, ''),
(18, 6, 3, 8.50, 7.00, 3, ''),
(19, 7, 1, 2.00, 3.00, 3, ''),
(20, 7, 2, 7.50, 8.50, 3, ''),
(21, 7, 3, 8.00, 7.50, 3, ''),
(22, 8, 1, 8.50, 9.00, 3, ''),
(23, 8, 2, 7.00, 6.50, 3, ''),
(24, 8, 3, 6.50, 7.00, 3, ''),
(25, 9, 1, 7.50, 8.00, 3, ''),
(26, 9, 2, 8.00, 9.00, 3, ''),
(27, 9, 3, 6.00, 6.50, 3, ''),
(28, 10, 1, 8.00, 8.50, 3, ''),
(29, 10, 2, 7.50, 7.00, 3, ''),
(30, 10, 3, 9.00, 8.50, 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_tecnicatura`
--

CREATE TABLE `estudiante_tecnicatura` (
  `id` int(11) NOT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `id_Tecnicatura` int(11) DEFAULT NULL,
  `inscripto` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiante_tecnicatura`
--

INSERT INTO `estudiante_tecnicatura` (`id`, `id_estudiante`, `id_Tecnicatura`, `inscripto`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 4, 1, 1),
(5, 5, 2, 1),
(6, 6, 3, 1),
(7, 7, 1, 1),
(8, 8, 2, 1),
(9, 9, 3, 1),
(10, 10, 1, 1),
(11, 11, 2, 1),
(12, 12, 3, 1),
(13, 13, 1, 1),
(14, 14, 2, 1),
(15, 15, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_materias`
--

CREATE TABLE `fechas_materias` (
  `id` int(11) NOT NULL,
  `id_Tecnicatura` int(11) NOT NULL,
  `id_Materia` int(11) NOT NULL,
  `fecha1` date DEFAULT NULL,
  `fecha2` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fechas_materias`
--

INSERT INTO `fechas_materias` (`id`, `id_Tecnicatura`, `id_Materia`, `fecha1`, `fecha2`) VALUES
(77, 1, 2, '2024-10-08', '2024-10-29'),
(79, 2, 3, '2024-10-03', '2024-10-04'),
(81, 1, 1, '2024-10-14', '2024-10-15'),
(85, 5, 29, NULL, NULL),
(87, 1, 4, '2024-11-19', '2024-11-25'),
(89, 11, 22, NULL, '2024-11-21'),
(91, 1, 3, '2024-11-27', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `finales`
--

CREATE TABLE `finales` (
  `id_final` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_tecnicatura` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nota` decimal(5,2) NOT NULL,
  `fecha1` date DEFAULT NULL,
  `fecha2` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `finales`
--

INSERT INTO `finales` (`id_final`, `id_estudiante`, `id_tecnicatura`, `id_materia`, `fecha`, `nota`, `fecha1`, `fecha2`) VALUES
(1, 1, 1, 1, '2024-06-01', 7.99, NULL, NULL),
(2, 1, 1, 2, '2024-06-02', 7.75, NULL, NULL),
(3, 1, 2, 1, '2024-06-03', 9.00, NULL, NULL),
(4, 1, 1, 3, '2024-06-04', 6.50, NULL, NULL),
(5, 1, 3, 2, '2024-06-05', 8.00, NULL, NULL),
(6, 6, 3, 4, '2024-06-06', 7.25, NULL, NULL),
(7, 7, 1, 5, '2024-06-07', 9.50, NULL, NULL),
(8, 8, 2, 1, '2024-06-08', 5.00, NULL, NULL),
(9, 9, 1, 3, '2024-06-09', 8.75, NULL, NULL),
(10, 1, 1, 1, '2024-06-25', 6.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_examenes`
--

CREATE TABLE `inscripciones_examenes` (
  `id_inscripcion` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `materia` varchar(100) NOT NULL,
  `fecha_tipo` date NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones_examenes`
--

INSERT INTO `inscripciones_examenes` (`id_inscripcion`, `id_estudiante`, `materia`, `fecha_tipo`, `fecha_inscripcion`) VALUES
(13, 1, 'Inglés I', '0000-00-00', '2024-11-22 00:26:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_Materia` int(11) NOT NULL,
  `Materia` varchar(30) NOT NULL,
  `IdTec` int(11) NOT NULL,
  `AnioCursada` varchar(15) NOT NULL,
  `Horas` tinyint(4) NOT NULL,
  `Estado` tinyint(4) NOT NULL DEFAULT 1,
  `IdCorrelativas` int(11) DEFAULT NULL,
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_Materia`, `Materia`, `IdTec`, `AnioCursada`, `Horas`, `Estado`, `IdCorrelativas`, `FechaMod`) VALUES
(1, 'Prácticas profesionalizantes', 1, 'Primero', 4, 1, NULL, '2024-10-21 06:11:11'),
(2, 'Inglés I', 1, 'Primero', 2, 1, NULL, '2024-10-21 06:11:11'),
(3, 'Inglés II', 1, 'Segundo', 2, 1, 2, '2024-10-21 06:11:11'),
(4, 'Estadísticas y Probabilidad', 1, 'Segundo', 3, 1, NULL, '2024-10-21 06:11:11'),
(5, 'Álgebra Lineal', 2, 'Tercero', 4, 1, 5, '2024-10-21 06:11:11'),
(6, 'Cálculo Diferencial', 2, 'Tercero', 4, 1, 6, '2024-10-21 06:11:11'),
(7, 'Gestión de Empresas', 2, 'Segundo', 3, 1, NULL, '2024-10-21 06:11:11'),
(8, 'Física I', 3, 'Primero', 2, 1, NULL, '2024-10-21 06:11:11'),
(9, 'Química General', 3, 'Primero', 3, 1, NULL, '2024-10-21 06:11:11'),
(10, 'Biología Celular', 4, 'Primero', 2, 1, NULL, '2024-10-21 06:11:11'),
(11, 'Ingeniería de Software', 5, 'Tercero', 4, 1, 10, '2024-10-21 06:11:11'),
(12, 'Redes de Computadoras', 5, 'Tercero', 3, 1, 11, '2024-10-21 06:11:11'),
(13, 'Economía Micro', 6, 'Segundo', 2, 1, NULL, '2024-10-21 06:11:11'),
(14, 'Economía Macro', 6, 'Tercero', 2, 1, 13, '2024-10-21 06:11:11'),
(15, 'Psicología del Desarrollo', 7, 'Primero', 2, 1, NULL, '2024-10-21 06:11:11'),
(16, 'Sociología', 7, 'Segundo', 3, 1, NULL, '2024-10-21 06:11:11'),
(17, 'Filosofía de la Ciencia', 8, 'Tercero', 4, 1, 16, '2024-10-21 06:11:11'),
(18, 'Geografía Humana', 9, 'Primero', 3, 1, NULL, '2024-10-21 06:11:11'),
(19, 'Geografía Física', 9, 'Segundo', 3, 1, 18, '2024-10-21 06:11:11'),
(20, 'Materia Técnica I', 10, 'Primero', 4, 1, NULL, '2024-10-21 06:11:11'),
(21, 'Materia Técnica II', 10, 'Segundo', 2, 1, 20, '2024-10-21 06:11:11'),
(22, 'Prácticas Profesionalizantes', 11, 'Tercero', 4, 1, NULL, '2024-10-21 06:11:11'),
(23, 'Taller de Investigación', 12, 'Tercero', 3, 1, NULL, '2024-10-21 06:11:11'),
(24, 'Matemáticas Avanzadas', 1, 'Tercero', 2, 1, 5, '2024-10-21 06:11:11'),
(25, 'Inglés III', 1, 'Tercero', 2, 1, 3, '2024-10-21 06:11:11'),
(26, 'Física II', 3, 'Segundo', 3, 1, 8, '2024-10-21 06:11:11'),
(27, 'Química Orgánica', 3, 'Segundo', 2, 1, 9, '2024-10-21 06:11:11'),
(28, 'Biología Molecular', 4, 'Segundo', 2, 1, 12, '2024-10-21 06:11:11'),
(29, 'Ingeniería de Sistemas', 5, 'Tercero', 2, 1, 14, '2024-10-21 06:11:11'),
(30, 'Redes de Sensores', 5, 'Tercero', 2, 1, 15, '2024-10-21 06:11:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `content` text NOT NULL,
  `images` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `news`
--

INSERT INTO `news` (`id`, `title`, `date`, `content`, `images`, `created_at`, `updated_at`) VALUES
(10, 'prueba', '2024-11-22', 'asda\r\nasdas\r\nasd\r\nadas\r\ndas', 'background.webp', '2024-11-22 00:37:11', '2024-11-22 00:37:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_Persona` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codRol` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `cuil` varchar(12) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nacionalidad` varchar(20) DEFAULT NULL,
  `estado_civil` varchar(15) DEFAULT NULL,
  `domicilio` varchar(150) DEFAULT NULL,
  `pais` varchar(170) DEFAULT NULL,
  `telefono_1` varchar(30) DEFAULT NULL,
  `telefono_2` varchar(30) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `Estado` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_Persona`, `idUsuario`, `nombre`, `apellido`, `email`, `codRol`, `dni`, `cuil`, `fecha_nacimiento`, `nacionalidad`, `estado_civil`, `domicilio`, `pais`, `telefono_1`, `telefono_2`, `titulo`, `Estado`, `fecha_registro`, `FechaMod`) VALUES
(1, 1, 'Programador', 'Administrador', 'admin@example.com', 1, '12345678', '12345678901', '1990-01-01', 'Argentina', 'Soltero', 'Calle 123', 'Argentina', '1234567890', '0987654321', 'Ingeniero', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(2, 2, 'Usuario', 'User', 'user@example.com', 2, '23456789', '23456789012', '1991-02-02', 'Argentina', 'Casado', 'Calle 456', 'Argentina', '2345678901', '0987654322', 'Abogada', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(3, 3, 'Silvio', 'Garbarino', 'garbarino@example.com', 3, '34567890', '34567890123', '1992-03-03', 'Argentina', 'Casado', 'Calle 789', 'Argentina', '3456789012', '0987654323', 'Médica', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(4, 4, 'Preceptor', 'EjemploPrecep', 'preceptor@example.com', 4, '45678901', '45678901234', '1993-04-04', 'Argentina', 'Casada', 'Calle 012', 'Argentina', '4567890123', '0987654324', 'Contadora', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(5, 5, 'Docente', 'EjemploDoc', 'docente@example.com', 5, '56789012', '56789012345', '1994-05-05', 'Argentina', 'Soltero', 'Calle 345', 'Argentina', '5678901234', '0987654325', 'Ingeniero', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(6, 7, 'Carlos', 'Sanchez', 'sanchez@gmail.com', 5, '30123456', '0', '2024-01-11', 'Argentino/a', '', 'Rivadavia 123', '', '2345112233', '', 'Docente de historia', 1, '2024-11-04 22:29:54', '2024-11-04 22:29:54'),
(7, 8, 'Ana', 'Perez', 'anaperez@gmail.com', 5, '30113355', '0', '2024-01-11', 'Argentino/a', '', 'Belgrano 123', '', '2344224488', '', 'Contador', 1, '2024-11-04 22:33:11', '2024-11-04 22:33:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preinscripciones`
--

CREATE TABLE `preinscripciones` (
  `idPreinscripcion` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `preinscripciones`
--

INSERT INTO `preinscripciones` (`idPreinscripcion`, `idEstado`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `codRol` int(11) NOT NULL,
  `nombreRol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`codRol`, `nombreRol`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'director'),
(4, 'preceptor'),
(5, 'docente'),
(6, 'alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicaturas`
--

CREATE TABLE `tecnicaturas` (
  `id_Tecnicatura` int(11) NOT NULL,
  `nombreTec` varchar(100) NOT NULL,
  `Resolucion` varchar(100) NOT NULL,
  `Ciclo` int(11) DEFAULT NULL,
  `EstadoTec` tinyint(4) NOT NULL DEFAULT 1,
  `FechaModificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tecnicaturas`
--

INSERT INTO `tecnicaturas` (`id_Tecnicatura`, `nombreTec`, `Resolucion`, `Ciclo`, `EstadoTec`, `FechaModificacion`) VALUES
(1, 'Tecnicatura superior en desarrollo de software', '123-abc', 2024, 1, '2024-10-21 06:11:11'),
(2, 'Tecnicatura en Recursos Humanos', '456-def', 2024, 1, '2024-10-21 06:11:11'),
(3, 'Tecnicatura en Gastronomia', '789-ghi', 2024, 1, '2024-10-21 06:11:11'),
(4, 'Tecnicatura en Administracion General', '901-jkl', 2024, 1, '2024-10-21 06:11:11'),
(5, 'Tecnicatura en Administracion Agricola', '234-mno', 2022, 1, '2024-10-21 06:11:11'),
(6, 'Tecnicatura en Agroecologia', '567-pqr', 2022, 1, '2024-10-21 06:11:11'),
(7, 'Tecnicatura en Diseño Grafico', '890-stu', 2023, 1, '2024-10-21 06:11:11'),
(8, 'Tecnicatura en Marketing Digital', '345-vwx', 2023, 1, '2024-10-21 06:11:11'),
(9, 'Tecnicatura en Contabilidad', '678-yza', 2023, 1, '2024-10-21 06:11:11'),
(10, 'Tecnicatura en Analisis de Sistemas', '456-bcd', 2023, 1, '2024-10-21 06:11:11'),
(11, 'Tecnicatura en Logistica y Transporte', '901-efg', 2025, 1, '2024-10-21 06:11:11'),
(12, 'Tecnicatura en Turismo Sostenible', '234-hij', 2025, 1, '2024-10-21 06:11:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temario`
--

CREATE TABLE `temario` (
  `id_temario` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `fecha_actual` date NOT NULL,
  `Clase` int(4) NOT NULL,
  `Unidad` int(4) NOT NULL,
  `Caracter` varchar(30) NOT NULL,
  `Contenidos` varchar(500) NOT NULL,
  `Actividad` varchar(500) NOT NULL,
  `Observaciones` varchar(500) NOT NULL,
  `horas_dadas` int(10) NOT NULL,
  `id_Materia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temario`
--

INSERT INTO `temario` (`id_temario`, `Fecha`, `fecha_actual`, `Clase`, `Unidad`, `Caracter`, `Contenidos`, `Actividad`, `Observaciones`, `horas_dadas`, `id_Materia`) VALUES
(1, '2024-11-04', '2024-11-04', 1, 1, 'TEORIA', 'cont 1', 'act 1', 'obs 1', 100, 1),
(2, '2024-09-24', '2024-09-24', 11, 11, 'RECUPERATORIO', 'cont11', 'act11', 'obs11', 100, 2),
(3, '2024-09-24', '2024-09-24', 12, 12, 'PARCIAL', 'cont 12', 'act 12', 'obs 12', 100, 3),
(4, '2024-09-24', '2024-09-24', 13, 13, 'PARCIAL', 'cont 13', 'act 13', 'obs 13', 0, 4),
(5, '2024-09-24', '2024-09-24', 14, 14, 'PRACTICA', 'cont 14', 'act 14', 'obs 14', 0, 5),
(6, '2024-09-24', '2024-09-24', 15, 15, 'OTROS', 'cont 15', 'act 15', 'obs 15', 0, 6),
(7, '2024-09-24', '2024-09-24', 16, 16, 'PARCIAL', 'cont 16', 'act 16', 'obs 16', 0, 7),
(8, '2024-11-12', '0000-00-00', 2, 2, 'PARCIAL', 'cont 2', 'act 2', 'obs 2', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocursada`
--

CREATE TABLE `tipocursada` (
  `id_Tipocursada` int(11) NOT NULL,
  `tipocursada` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipocursada`
--

INSERT INTO `tipocursada` (`id_Tipocursada`, `tipocursada`) VALUES
(1, 'No asignado'),
(2, 'Preinscripto'),
(3, 'Regular'),
(4, 'Libre'),
(5, 'Libre Desaprobado'),
(6, 'Equivalencia'),
(7, 'Oyente'),
(8, 'Vocacional'),
(9, 'Itinerante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `codRol` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasenia` varchar(50) NOT NULL,
  `Estado` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `FechaMod` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `codRol`, `usuario`, `contrasenia`, `Estado`, `fecha_registro`, `FechaMod`) VALUES
(1, 1, 'admin', 'admin2024', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(2, 2, 'user', 'user2024', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(3, 3, 'director', 'director2024', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(4, 4, 'preceptor', 'preceptor2024', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(5, 5, 'docente', 'docente2024', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11'),
(6, 6, 'estudiante', 'estudiante2024', 1, '2024-10-21 06:13:06', '2024-10-21 06:13:06'),
(7, 5, 'sanchez@gmail.com', '30123456', 1, '2024-11-04 22:29:54', '2024-11-04 22:29:54'),
(8, 5, 'anaperez@gmail.com', '30113355', 1, '2024-11-04 22:33:11', '2024-11-04 22:33:11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_Asistencia`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_Materia` (`id_Materia`);

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`idCertificado`),
  ADD KEY `fk_id_tecnicatura` (`id_Tecnicatura`);

--
-- Indices de la tabla `correlativas`
--
ALTER TABLE `correlativas`
  ADD PRIMARY KEY (`id_corr`),
  ADD KEY `idTec` (`idTec`),
  ADD KEY `idMateria` (`idMateria`);

--
-- Indices de la tabla `docentesmaterias`
--
ALTER TABLE `docentesmaterias`
  ADD PRIMARY KEY (`iddocentesmaterias`),
  ADD KEY `id_Persona` (`id_Persona`),
  ADD KEY `id_Materia` (`id_Materia`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD KEY `idx_idUsuario` (`idUsuario`);

--
-- Indices de la tabla `estudiantes_planillas`
--
ALTER TABLE `estudiantes_planillas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  ADD PRIMARY KEY (`id_estudiante_materia`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_Materia` (`id_Materia`),
  ADD KEY `id_Tipocursada` (`id_Tipocursada`);

--
-- Indices de la tabla `estudiante_tecnicatura`
--
ALTER TABLE `estudiante_tecnicatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_Tecnicatura` (`id_Tecnicatura`);

--
-- Indices de la tabla `fechas_materias`
--
ALTER TABLE `fechas_materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_fecha` (`id_Tecnicatura`,`id_Materia`),
  ADD KEY `id_Materia` (`id_Materia`);

--
-- Indices de la tabla `finales`
--
ALTER TABLE `finales`
  ADD PRIMARY KEY (`id_final`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_tecnicatura` (`id_tecnicatura`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `inscripciones_examenes`
--
ALTER TABLE `inscripciones_examenes`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_Materia`);

--
-- Indices de la tabla `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_Persona`),
  ADD UNIQUE KEY `idUsuario` (`idUsuario`),
  ADD KEY `codRol` (`codRol`);

--
-- Indices de la tabla `preinscripciones`
--
ALTER TABLE `preinscripciones`
  ADD PRIMARY KEY (`idPreinscripcion`),
  ADD KEY `preinscripciones_ibfk_1` (`idEstado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`codRol`);

--
-- Indices de la tabla `tecnicaturas`
--
ALTER TABLE `tecnicaturas`
  ADD PRIMARY KEY (`id_Tecnicatura`);

--
-- Indices de la tabla `temario`
--
ALTER TABLE `temario`
  ADD PRIMARY KEY (`id_temario`),
  ADD KEY `id_Materia` (`id_Materia`);

--
-- Indices de la tabla `tipocursada`
--
ALTER TABLE `tipocursada`
  ADD PRIMARY KEY (`id_Tipocursada`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `codRol` (`codRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_Asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `idCertificado` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `correlativas`
--
ALTER TABLE `correlativas`
  MODIFY `id_corr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `docentesmaterias`
--
ALTER TABLE `docentesmaterias`
  MODIFY `iddocentesmaterias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `estudiantes_planillas`
--
ALTER TABLE `estudiantes_planillas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  MODIFY `id_estudiante_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `estudiante_tecnicatura`
--
ALTER TABLE `estudiante_tecnicatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `fechas_materias`
--
ALTER TABLE `fechas_materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `finales`
--
ALTER TABLE `finales`
  MODIFY `id_final` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `inscripciones_examenes`
--
ALTER TABLE `inscripciones_examenes`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_Materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_Persona` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `preinscripciones`
--
ALTER TABLE `preinscripciones`
  MODIFY `idPreinscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `codRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tecnicaturas`
--
ALTER TABLE `tecnicaturas`
  MODIFY `id_Tecnicatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `temario`
--
ALTER TABLE `temario`
  MODIFY `id_temario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tipocursada`
--
ALTER TABLE `tipocursada`
  MODIFY `id_Tipocursada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`),
  ADD CONSTRAINT `asistencia_ibfk_2` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`);

--
-- Filtros para la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD CONSTRAINT `fk_id_tecnicatura` FOREIGN KEY (`id_Tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `correlativas`
--
ALTER TABLE `correlativas`
  ADD CONSTRAINT `correlativas_ibfk_1` FOREIGN KEY (`idTec`) REFERENCES `tecnicaturas` (`id_Tecnicatura`),
  ADD CONSTRAINT `correlativas_ibfk_2` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`id_Materia`);

--
-- Filtros para la tabla `docentesmaterias`
--
ALTER TABLE `docentesmaterias`
  ADD CONSTRAINT `docentesmaterias_ibfk_1` FOREIGN KEY (`id_Persona`) REFERENCES `personas` (`id_Persona`),
  ADD CONSTRAINT `docentesmaterias_ibfk_2` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `fk_estudiantes_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes_planillas`
--
ALTER TABLE `estudiantes_planillas`
  ADD CONSTRAINT `estudiantes_planillas_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`);

--
-- Filtros para la tabla `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  ADD CONSTRAINT `estudiante_materia_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`),
  ADD CONSTRAINT `estudiante_materia_ibfk_2` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`),
  ADD CONSTRAINT `estudiante_materia_ibfk_3` FOREIGN KEY (`id_Tipocursada`) REFERENCES `tipocursada` (`id_Tipocursada`);

--
-- Filtros para la tabla `estudiante_tecnicatura`
--
ALTER TABLE `estudiante_tecnicatura`
  ADD CONSTRAINT `estudiante_tecnicatura_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`),
  ADD CONSTRAINT `estudiante_tecnicatura_ibfk_2` FOREIGN KEY (`id_Tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`);

--
-- Filtros para la tabla `fechas_materias`
--
ALTER TABLE `fechas_materias`
  ADD CONSTRAINT `fechas_materias_ibfk_1` FOREIGN KEY (`id_Tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`) ON DELETE CASCADE,
  ADD CONSTRAINT `fechas_materias_ibfk_2` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_materia` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`),
  ADD CONSTRAINT `fk_tecnicatura` FOREIGN KEY (`id_Tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`);

--
-- Filtros para la tabla `finales`
--
ALTER TABLE `finales`
  ADD CONSTRAINT `finales_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`) ON DELETE CASCADE,
  ADD CONSTRAINT `finales_ibfk_2` FOREIGN KEY (`id_tecnicatura`) REFERENCES `tecnicaturas` (`id_Tecnicatura`) ON DELETE CASCADE,
  ADD CONSTRAINT `finales_ibfk_3` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_Materia`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones_examenes`
--
ALTER TABLE `inscripciones_examenes`
  ADD CONSTRAINT `inscripciones_examenes_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`codRol`) REFERENCES `roles` (`codRol`);

--
-- Filtros para la tabla `preinscripciones`
--
ALTER TABLE `preinscripciones`
  ADD CONSTRAINT `preinscripciones_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `estados` (`idEstado`);

--
-- Filtros para la tabla `temario`
--
ALTER TABLE `temario`
  ADD CONSTRAINT `temario_ibfk_1` FOREIGN KEY (`id_Materia`) REFERENCES `materias` (`id_Materia`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`codRol`) REFERENCES `roles` (`codRol`);


CREATE TABLE inscripciones_examenes (
    id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT NOT NULL,
    materia VARCHAR(100) NOT NULL,
    fecha_tipo VARCHAR(50) NOT NULL,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
COMMIT;