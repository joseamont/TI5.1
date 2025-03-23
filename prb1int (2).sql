-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-03-2025 a las 15:52:46
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
-- Base de datos: `prb1int`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion`
--

CREATE TABLE `accion` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_seccion` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `identificador` varchar(80) NOT NULL,
  `estatus` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` (`id`, `id_seccion`, `nombre`, `identificador`, `estatus`) VALUES
(1, 2, 'Listar roles', 'index', '1'),
(2, 2, 'Detalle del rol', 'view', '1'),
(3, 2, 'Nuevo rol', 'create', '1'),
(4, 2, 'Editar rol', 'update', '1'),
(5, 2, 'Eliminar rol', 'delete', '1'),
(6, 2, 'Actualizar estatus del rol', 'update-estatus', '1'),
(7, 3, 'Listar privilegios', 'index', '1'),
(8, 3, 'Detalle del privilegio', 'view', '1'),
(9, 3, 'Nuevo privilegio', 'create', '1'),
(10, 3, 'Editar privilegio', 'update', '1'),
(11, 3, 'Eliminar privilegio', 'delete', '1'),
(12, 3, 'Actualizar estatus del privilegio', 'update-estatus', '1'),
(13, 4, 'Listar secciones', 'index', '1'),
(14, 4, 'Detalle de la sección', 'view', '1'),
(15, 4, 'Nueva sección', 'create', '1'),
(16, 4, 'Editar sección', 'update', '1'),
(17, 4, 'Eliminar sección', 'delete', '1'),
(18, 4, 'Actualizar estatus de la sección', 'update-estatus', '1'),
(19, 5, 'Listar acciones', 'index', '1'),
(20, 5, 'Detalle de la acción', 'view', '1'),
(21, 5, 'Nueva acción', 'create', '1'),
(22, 5, 'Editar acción', 'update', '1'),
(23, 5, 'Eliminar acción', 'delete', '1'),
(24, 5, 'Actualizar estatus de la acción', 'update-estatus', '1'),
(25, 6, 'Lista de usuarios', 'index', '1'),
(26, 6, 'Detalle del usuario', 'view', '1'),
(27, 6, 'Nuevo usuario', 'create', '1'),
(28, 6, 'Editar usuario', 'update', '1'),
(29, 6, 'Eliminar usuario', 'delete', '1'),
(30, 6, 'Actualizar estatus del usuario', 'update-estatus', '1'),
(31, 7, 'Lista de tickets', 'index', '1'),
(32, 7, 'Detalle ticket', 'view', '1'),
(33, 7, 'Nuevo ticket', 'create', '1'),
(34, 7, 'Editar ticket', 'update', '1'),
(35, 7, 'Borrar ticket', 'delete', '1'),
(36, 7, 'Actualizar status del ticket', 'update-estatus', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `STATUS` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `calificacion` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `puntuacion` enum('Malo','Regular','Bueno','Muy Bueno') NOT NULL DEFAULT 'Regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `dias` enum('Lunes-Viernes','sabado-domingo') DEFAULT 'Lunes-Viernes',
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tipo` enum('matutino','vespertino') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `dias`, `hora_inicio`, `hora_fin`, `tipo`) VALUES
(1, 'Lunes-Viernes', '07:30:00', '15:30:00', 'matutino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido_paterno` varchar(60) NOT NULL,
  `apellido_materno` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`) VALUES
(1, 'Jose', 'Aguirre', 'Montiel'),
(33, 'Victor Uriel', 'Perez', 'Perez'),
(34, 'Osbaldo', 'Alonso', 'Cortes'),
(35, 'David', 'Calleja', 'Duran');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegio`
--

CREATE TABLE `privilegio` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_rol` int(10) UNSIGNED NOT NULL,
  `id_seccion` int(10) UNSIGNED NOT NULL,
  `id_accion` int(10) UNSIGNED DEFAULT NULL,
  `estatus` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `privilegio`
--

INSERT INTO `privilegio` (`id`, `id_rol`, `id_seccion`, `id_accion`, `estatus`) VALUES
(1, 1, 1, NULL, '1'),
(2, 1, 2, NULL, '1'),
(3, 1, 2, 1, '1'),
(4, 1, 2, 2, '1'),
(5, 1, 2, 3, '1'),
(6, 1, 2, 4, '1'),
(7, 1, 2, 5, '1'),
(8, 1, 2, 6, '1'),
(9, 1, 3, NULL, '1'),
(10, 1, 3, 7, '1'),
(11, 1, 3, 8, '1'),
(12, 1, 3, 9, '1'),
(13, 1, 3, 10, '1'),
(14, 1, 3, 11, '1'),
(15, 1, 3, 12, '1'),
(16, 1, 4, NULL, '1'),
(17, 1, 4, 13, '1'),
(18, 1, 4, 14, '1'),
(19, 1, 4, 15, '1'),
(20, 1, 4, 16, '1'),
(21, 1, 4, 17, '1'),
(22, 1, 4, 18, '1'),
(23, 1, 5, NULL, '1'),
(24, 1, 5, 19, '1'),
(25, 1, 5, 20, '1'),
(26, 1, 5, 21, '1'),
(27, 1, 5, 22, '1'),
(28, 1, 5, 23, '1'),
(29, 1, 5, 24, '1'),
(30, 1, 6, NULL, '1'),
(32, 1, 6, 26, '1'),
(33, 1, 6, 27, '1'),
(34, 1, 6, 28, '1'),
(35, 1, 6, 29, '1'),
(36, 1, 6, 30, '1'),
(37, 2, 1, NULL, '1'),
(38, 2, 2, NULL, '0'),
(39, 2, 2, 1, '0'),
(40, 2, 2, 2, '0'),
(41, 2, 2, 3, '0'),
(42, 2, 2, 4, '0'),
(43, 2, 2, 5, '0'),
(44, 2, 2, 6, '0'),
(45, 2, 3, NULL, '1'),
(46, 2, 3, 7, '1'),
(47, 2, 3, 8, '1'),
(48, 2, 3, 9, '0'),
(49, 2, 3, 10, '0'),
(50, 2, 3, 11, '0'),
(51, 2, 3, 12, '0'),
(52, 2, 4, NULL, '1'),
(53, 2, 4, 13, '1'),
(54, 2, 4, 14, '1'),
(55, 2, 4, 15, '0'),
(56, 2, 4, 16, '0'),
(57, 2, 4, 17, '0'),
(58, 2, 4, 18, '0'),
(59, 2, 5, NULL, '1'),
(60, 2, 5, 19, '1'),
(61, 2, 5, 20, '1'),
(62, 2, 5, 21, '0'),
(63, 2, 5, 22, '0'),
(64, 2, 5, 23, '0'),
(65, 2, 5, 24, '0'),
(66, 2, 6, NULL, '1'),
(68, 2, 6, 26, '1'),
(69, 2, 6, 27, '0'),
(70, 2, 6, 28, '0'),
(71, 2, 6, 29, '0'),
(72, 2, 6, 30, '0'),
(73, 3, 1, NULL, '0'),
(74, 3, 2, NULL, '0'),
(75, 3, 2, 1, '0'),
(76, 3, 2, 2, '0'),
(77, 3, 2, 3, '0'),
(78, 3, 2, 4, '0'),
(79, 3, 2, 5, '0'),
(80, 3, 2, 6, '0'),
(81, 3, 3, NULL, '0'),
(82, 3, 3, 7, '0'),
(83, 3, 3, 8, '0'),
(84, 3, 3, 9, '0'),
(85, 3, 3, 10, '0'),
(86, 3, 3, 11, '0'),
(87, 3, 3, 12, '0'),
(88, 3, 4, NULL, '0'),
(89, 3, 4, 13, '0'),
(90, 3, 4, 14, '0'),
(100, 3, 4, 15, '0'),
(101, 3, 4, 16, '0'),
(102, 3, 4, 17, '0'),
(103, 3, 4, 18, '0'),
(104, 3, 5, NULL, '0'),
(105, 3, 5, 19, '0'),
(106, 3, 5, 20, '0'),
(107, 3, 5, 21, '0'),
(108, 3, 5, 22, '0'),
(109, 3, 5, 23, '0'),
(110, 3, 5, 24, '0'),
(111, 3, 6, NULL, '0'),
(113, 3, 6, 26, '1'),
(114, 3, 6, 27, '0'),
(115, 3, 6, 28, '0'),
(116, 3, 6, 29, '0'),
(117, 3, 6, 30, '0'),
(123, 1, 7, NULL, '1'),
(124, 1, 7, 31, '1'),
(125, 1, 7, 33, '1'),
(126, 1, 7, 32, '1'),
(127, 1, 7, 34, '1'),
(128, 1, 7, 35, '1'),
(129, 1, 7, 36, '1'),
(130, 1, 6, 25, '1'),
(131, 4, 1, NULL, '1'),
(132, 4, 7, NULL, '1'),
(133, 4, 7, 31, '1'),
(134, 4, 7, 32, '1'),
(1128, 1, 16, NULL, '1'),
(1129, 1, 16, NULL, '1'),
(1130, 1, 15, NULL, ''),
(1131, 1, 15, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respaldo`
--

CREATE TABLE `respaldo` (
  `id` int(11) NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `respuesta` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estatus` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `estatus`) VALUES
(1, 'Administrador del Sistema', '1'),
(2, 'Administrador', '1'),
(3, 'Operativo', '1'),
(4, 'Cliente', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_seccion_superior` int(10) UNSIGNED DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `identificador` varchar(80) NOT NULL,
  `estatus` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id`, `id_seccion_superior`, `nombre`, `identificador`, `estatus`) VALUES
(1, NULL, 'Configuración', 'configuracion', '1'),
(2, 1, 'Roles', 'rol', '1'),
(3, 1, 'Privilegios', 'privilegio', '1'),
(4, 1, 'Secciones', 'seccion', '1'),
(5, 4, 'Acciones', 'accion', '1'),
(6, NULL, 'Usuarios', 'user', '1'),
(7, NULL, 'Tickets', 'ticket', '1'),
(14, NULL, 'Asistencias', 'asistencia', '1'),
(15, NULL, 'Suscripciones', 'suscripciones', '1'),
(16, NULL, 'Horarios', 'horario', '1'),
(17, NULL, 'Calificaciones', 'calificaciones', '1'),
(18, 16, 'Horarios Trabajadores', 'usuario_hor', '1'),
(19, 15, 'Planes Usuario', 'usuario_pla', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

CREATE TABLE `suscripciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `resolucion` enum('SD','HD','Full HD','4K') NOT NULL,
  `dispositivos` int(11) NOT NULL,
  `duracion` enum('mensual','trimestral','anual') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `suscripciones`
--

INSERT INTO `suscripciones` (`id`, `nombre`, `precio`, `resolucion`, `dispositivos`, `duracion`) VALUES
(1, 'Básico', 99.00, 'SD', 1, 'mensual'),
(2, 'Estándar', 149.00, 'HD', 2, 'mensual'),
(3, 'Premium', 199.00, 'Full HD', 4, 'mensual'),
(4, 'Familiar', 249.00, '4K', 6, 'mensual'),
(5, 'Trimestral HD', 399.00, 'HD', 2, 'trimestral'),
(6, 'Anual 4K', 1999.00, '4K', 6, 'anual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `id_suscripcion` int(11) NOT NULL,
  `tipo` enum('Estado de Suscripción','Problemas de Reproducción','Informe de Reembolsos y Soporte','Otros') DEFAULT NULL,
  `fecha_apertura` datetime DEFAULT current_timestamp(),
  `fecha_cierre` datetime DEFAULT NULL,
  `status` enum('sin abrir','abierto','cerrado') DEFAULT 'sin abrir',
  `descripcion` text DEFAULT NULL,
  `id_calificacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ticket`
--

INSERT INTO `ticket` (`id`, `id_usuario`, `id_suscripcion`, `tipo`, `fecha_apertura`, `fecha_cierre`, `status`, `descripcion`, `id_calificacion`) VALUES
(1, 23, 1, 'Estado de Suscripción', '2025-03-22 13:52:39', NULL, 'sin abrir', 'necesitoooooooooooo ayudaaaaaaaaaaa', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_persona` int(10) UNSIGNED NOT NULL,
  `id_rol` int(10) UNSIGNED NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `authKey` varchar(255) DEFAULT NULL,
  `accessToken` varchar(255) DEFAULT NULL,
  `estatus` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `id_persona`, `id_rol`, `username`, `password`, `authKey`, `accessToken`, `estatus`) VALUES
(1, 1, 1, 'jose123', '123456', NULL, NULL, '1'),
(21, 33, 3, 'Victor123', '123456', NULL, NULL, '1'),
(22, 34, 2, 'osbaldo123', '123456', NULL, NULL, '1'),
(23, 35, 4, 'david123', '123456', NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_cal`
--

CREATE TABLE `usuario_cal` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `id_calificaciones` int(11) NOT NULL,
  `fecha_insercion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_hor`
--

CREATE TABLE `usuario_hor` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `id_horario` int(11) NOT NULL,
  `fecha_insercion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_hor`
--

INSERT INTO `usuario_hor` (`id`, `id_usuario`, `id_horario`, `fecha_insercion`) VALUES
(1, 22, 1, '2025-03-22 18:58:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_pla`
--

CREATE TABLE `usuario_pla` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `id_suscripcion` int(11) DEFAULT NULL,
  `fecha_insercion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_pla`
--

INSERT INTO `usuario_pla` (`id`, `id_usuario`, `id_suscripcion`, `fecha_insercion`) VALUES
(1, 23, 1, '2025-03-22 13:52:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tic`
--

CREATE TABLE `usuario_tic` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `fecha_insercion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_tic`
--

INSERT INTO `usuario_tic` (`id`, `id_usuario`, `id_ticket`, `fecha_insercion`) VALUES
(1, 23, 1, '2025-03-22 14:32:03');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `_directorio_secciones`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `_directorio_secciones` (
`ruta` varchar(150)
,`id_seccion` int(10) unsigned
,`id_seccion_superior` int(10) unsigned
,`nombre_seccion` varchar(150)
,`identificador_seccion` varchar(80)
,`estatus_seccion` enum('0','1')
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `_directorio_secciones_accion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `_directorio_secciones_accion` (
`ruta` varchar(305)
,`id_seccion` int(10) unsigned
,`id_seccion_superior` int(10) unsigned
,`nombre_seccion` varchar(150)
,`identificador_seccion` varchar(80)
,`estatus_seccion` enum('0','1')
,`id_accion` int(10) unsigned
,`nombre_accion` varchar(150)
,`identificador_accion` varchar(80)
,`estatus_accion` enum('0','1')
);

-- --------------------------------------------------------
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion`
--
ALTER TABLE `accion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_rol` (`id_rol`,`id_seccion`,`id_accion`),
  ADD KEY `id_seccion` (`id_seccion`),
  ADD KEY `id_accion` (`id_accion`);

--
-- Indices de la tabla `respaldo`
--
ALTER TABLE `respaldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificador` (`identificador`),
  ADD KEY `id_seccion_superior` (`id_seccion_superior`);

--
-- Indices de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_suscripcion` (`id_suscripcion`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `id_persona` (`id_persona`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `usuario_cal`
--
ALTER TABLE `usuario_cal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_calificaciones` (`id_calificaciones`);

--
-- Indices de la tabla `usuario_hor`
--
ALTER TABLE `usuario_hor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_horario` (`id_horario`);

--
-- Indices de la tabla `usuario_pla`
--
ALTER TABLE `usuario_pla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_suscripcion` (`id_suscripcion`);

--
-- Indices de la tabla `usuario_tic`
--
ALTER TABLE `usuario_tic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion`
--
ALTER TABLE `accion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1132;

--
-- AUTO_INCREMENT de la tabla `respaldo`
--
ALTER TABLE `respaldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuario_cal`
--
ALTER TABLE `usuario_cal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_hor`
--
ALTER TABLE `usuario_hor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario_pla`
--
ALTER TABLE `usuario_pla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario_tic`
--
ALTER TABLE `usuario_tic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accion`
--
ALTER TABLE `accion`
  ADD CONSTRAINT `accion_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD CONSTRAINT `privilegio_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `privilegio_ibfk_2` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `privilegio_ibfk_3` FOREIGN KEY (`id_accion`) REFERENCES `accion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respaldo`
--
ALTER TABLE `respaldo`
  ADD CONSTRAINT `respaldo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `seccion_ibfk_1` FOREIGN KEY (`id_seccion_superior`) REFERENCES `seccion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`id_suscripcion`) REFERENCES `suscripciones` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_cal`
--
ALTER TABLE `usuario_cal`
  ADD CONSTRAINT `usuario_cal_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_cal_ibfk_2` FOREIGN KEY (`id_calificaciones`) REFERENCES `calificaciones` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_hor`
--
ALTER TABLE `usuario_hor`
  ADD CONSTRAINT `usuario_hor_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_hor_ibfk_2` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_pla`
--
ALTER TABLE `usuario_pla`
  ADD CONSTRAINT `usuario_pla_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_pla_ibfk_2` FOREIGN KEY (`id_suscripcion`) REFERENCES `suscripciones` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_tic`
--
ALTER TABLE `usuario_tic`
  ADD CONSTRAINT `usuario_tic_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_tic_ibfk_2` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
