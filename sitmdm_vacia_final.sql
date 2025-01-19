-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2024 a las 20:06:39
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_justificada`
--

CREATE TABLE `asistencia_justificada` (
  `id_asistencia_justificada` int(11) NOT NULL,
  `id_Asistencia` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `nota_primer_cuatrimestre` decimal(5,2) DEFAULT 0.00,
  `nota_segundo_cuatrimestre` decimal(5,2) DEFAULT 0.00,
  `id_Tipocursada` int(11) NOT NULL,
  `observaciones` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `nota` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_examenes`
--

CREATE TABLE `inscripciones_examenes` (
  `id_inscripcion` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `materia` varchar(100) NOT NULL,
  `fecha_tipo` varchar(50) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 3, 'Silvio', 'Garbarino', 'garbarino@example.com', 3, '34567890', '34567890123', '1992-03-03', 'Argentina', 'Casado', 'Calle 789', 'Argentina', '3456789012', '0987654323', 'Médica', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11');

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
(3, 3, 'director', 'director2024', 1, '2024-10-21 06:11:11', '2024-10-21 06:11:11');

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
-- Indices de la tabla `asistencia_justificada`
--
ALTER TABLE `asistencia_justificada`
  ADD PRIMARY KEY (`id_asistencia_justificada`),
  ADD KEY `id_Asistencia` (`id_Asistencia`);

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
  MODIFY `id_Asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `asistencia_justificada`
--
ALTER TABLE `asistencia_justificada`
  MODIFY `id_asistencia_justificada` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `idCertificado` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correlativas`
--
ALTER TABLE `correlativas`
  MODIFY `id_corr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `docentesmaterias`
--
ALTER TABLE `docentesmaterias`
  MODIFY `iddocentesmaterias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiantes_planillas`
--
ALTER TABLE `estudiantes_planillas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  MODIFY `id_estudiante_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante_tecnicatura`
--
ALTER TABLE `estudiante_tecnicatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `fechas_materias`
--
ALTER TABLE `fechas_materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `finales`
--
ALTER TABLE `finales`
  MODIFY `id_final` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripciones_examenes`
--
ALTER TABLE `inscripciones_examenes`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_Materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_Persona` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id_Tecnicatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `temario`
--
ALTER TABLE `temario`
  MODIFY `id_temario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipocursada`
--
ALTER TABLE `tipocursada`
  MODIFY `id_Tipocursada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Filtros para la tabla `asistencia_justificada`
--
ALTER TABLE `asistencia_justificada`
  ADD CONSTRAINT `id_Asistencia_ibfk_1` FOREIGN KEY (`id_Asistencia`) REFERENCES `asistencia` (`id_Asistencia`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
