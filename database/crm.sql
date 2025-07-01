-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2025 a las 18:55:08
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
-- Base de datos: `crm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_subidos`
--

CREATE TABLE `archivos_subidos` (
  `id` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `genero` char(1) DEFAULT 'N',
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `empresa` varchar(255) DEFAULT NULL,
  `puesto` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `estatus_color` varchar(7) DEFAULT '#808080',
  `comentarios` text DEFAULT NULL,
  `proxima_llamada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `genero`, `nombre`, `telefono`, `correo`, `direccion`, `fecha_registro`, `empresa`, `puesto`, `area`, `estatus_color`, `comentarios`, `proxima_llamada`) VALUES
(22, 'M', 'Esperanza Romo Saucedo', '4493931430', 'esperanzaromos@gmail.com', 'Ags, Jesus Maria', '2025-06-25 23:49:11', 'Universidad Tecnologica de Aguascalientes jh', 'Gerente', 'Recursos Humanos', '#FF0000', 'Se convencio de comprar un curso de Negociacion ', '2025-06-28 16:49:00'),
(23, 'H', 'Gonzalo Campos', '4496759457', 'Gonzalo@campos.com', 'Ags, Jesus Maria', '2025-06-29 23:30:00', 'Universidad Tecnologica de Aguascalientes', 'Gerente', 'Recursos Humanos', '#808080', 'dw', '2025-06-21 23:29:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_excel`
--

CREATE TABLE `documentos_excel` (
  `id` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos_excel`
--

INSERT INTO `documentos_excel` (`id`, `nombre_archivo`, `ruta`, `usuario`, `fecha_subida`) VALUES
(6, 'clientes_crm_20250625_050157.xlsx', 'backups/clientes_crm_20250625_050157.xlsx', 'Olivia Gallardo', '2025-06-25 05:01:57'),
(7, 'inscripciones_2025-06-30_08-24-09.xlsx', 'documentos/inscripciones_2025-06-30_08-24-09.xlsx', 'Olivia Gallardo', '2025-06-30 00:24:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_inscripcion`
--

CREATE TABLE `ficha_inscripcion` (
  `id` int(11) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `consultor` varchar(100) DEFAULT NULL,
  `curso` varchar(100) DEFAULT NULL,
  `participantes` text DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `calle_numero` varchar(255) DEFAULT NULL,
  `colonia_cp` varchar(255) DEFAULT NULL,
  `ciudad_estado` varchar(255) DEFAULT NULL,
  `rfc` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `regimen` varchar(100) DEFAULT NULL,
  `metodo_pago` varchar(100) DEFAULT NULL,
  `forma_pago` varchar(100) DEFAULT NULL,
  `uso_cfdi` varchar(100) DEFAULT NULL,
  `orden_compra` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `numero_participantes` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `condiciones_pago` varchar(255) DEFAULT NULL,
  `sede` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `horario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ficha_inscripcion`
--

INSERT INTO `ficha_inscripcion` (`id`, `fecha_inscripcion`, `consultor`, `curso`, `participantes`, `razon_social`, `calle_numero`, `colonia_cp`, `ciudad_estado`, `rfc`, `telefono`, `regimen`, `metodo_pago`, `forma_pago`, `uso_cfdi`, `orden_compra`, `correo`, `numero_participantes`, `precio_unitario`, `subtotal`, `iva`, `total`, `condiciones_pago`, `sede`, `fecha`, `horario`) VALUES
(2, '2025-06-24', 'Olivia Gallardo', 'Negociacion', 'Elena', 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', 'AV.  CONVENCION DE 1914 SUR  609 ', 'LAS AMERICAS C.P.  20230', 'AGUASCALIENTES, AGS', 'RAG041206ET1', '4496759457', 'REGIMEN GENERAL DE LAS PERSONAS MORALES', 'PUE', 'TRASFERENCIA ELECTRONICA', 'GASTOS EN GENERAL', '2', '0', 6, 678.00, 4068.00, 650.88, 4718.88, 'TRÁMITE', 'TEAMS', '0000-00-00', '8:30 a 10:00'),
(15, '2025-06-24', 'Olivia Gallardo', 'Negociacion', 'Elena', 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', 'AV.  CONVENCION DE 1914 SUR  609 ', 'LAS AMERICAS C.P.  20230', 'AGUASCALIENTES, AGS', 'RAG041206ET1', '4496759457', 'REGIMEN GENERAL DE LAS PERSONAS MORALES', 'PUE', 'TRASFERENCIA ELECTRONICA', 'GASTOS EN GENERAL', '2', '0', 4, 678.00, 2712.00, 433.92, 3145.92, 'TRÁMITE', 'TEAMS', '2025-06-18', '8:30 a 10:00'),
(16, '2025-07-02', 'Olivia Gallardo', 'Negociacion', 'Elena', 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', 'AV.  CONVENCION DE 1914 SUR  609 ', 'LAS AMERICAS C.P.  20230', 'AGUASCALIENTES, AGS', 'RAG041206ET1', '4496759457', 'REGIMEN GENERAL DE LAS PERSONAS MORALES', 'PUE', 'TRASFERENCIA ELECTRONICA', 'GASTOS EN GENERAL', '2', '0', 4, 678.00, 0.00, 0.00, 0.00, 'TRÁMITE', 'TEAMS', '2025-06-18', '8:30 a 10:00'),
(17, '2025-06-25', 'Olivia Gallardo', 'Negociacion', 'Ivan\r\nElena', 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', 'AV.  CONVENCION DE 1914 SUR  609 ', 'LAS AMERICAS C.P.  20230', 'AGUASCALIENTES, AGS', 'RAG041206ET1', '4496759457', 'REGIMEN GENERAL DE LAS PERSONAS MORALES', 'PUE', 'TRASFERENCIA ELECTRONICA', 'GASTOS EN GENERAL', '2', '0', 4, 678.00, 2712.00, 433.92, 3145.92, 'TRÁMITE', 'TEAMS', '2025-06-18', '8:30 a 10:00'),
(18, '2025-06-25', 'Olivia Gallardo', 'Negociacion', 'Elena Martinez \r\nGonzalo Campos\r\nIvan Moreno', 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', 'AV.  CONVENCION DE 1914 SUR  609 ', 'LAS AMERICAS C.P.  20230', 'AGUASCALIENTES, AGS', 'RAG041206ET1', '4496759457', 'REGIMEN GENERAL DE LAS PERSONAS MORALES', 'PUE', 'TRASFERENCIA ELECTRONICA', 'GASTOS EN GENERAL', '2', '0', 4, 678.00, 2712.00, 433.92, 3145.92, 'TRÁMITE', 'TEAMS', '2025-06-18', '8:30 a 10:00'),
(19, '2025-06-25', 'Olivia Gallardo', 'Negociacion', 'Elena', 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', 'AV.  CONVENCION DE 1914 SUR  609 ', 'LAS AMERICAS C.P.  20230', 'AGUASCALIENTES, AGS', 'RAG041206ET1', '4496759457', 'REGIMEN GENERAL DE LAS PERSONAS MORALES', 'PUE', 'TRASFERENCIA ELECTRONICA', 'GASTOS EN GENERAL', '2', '0', 4, 678.00, 2712.00, 433.92, 3145.92, 'TRÁMITE', 'TEAMS', '2025-06-18', '8:30 a 10:00'),
(20, '2025-06-26', 'Olivia Gallardo', 'Negociacion', 'Elena\r\nIvan\r\nKatia', 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', 'AV.  CONVENCION DE 1914 SUR  609 ', 'LAS AMERICAS C.P.  20230', 'AGUASCALIENTES, AGS', 'RAG041206ET1', '4496759457', 'REGIMEN GENERAL DE LAS PERSONAS MORALES', 'PUE', 'TRASFERENCIA ELECTRONICA', 'GASTOS EN GENERAL', '2', '0', 4, 678.00, 2712.00, 433.92, 3145.92, 'TRÁMITE', 'TEAMS', '2025-06-18', '8:30 a 10:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `participantes` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `curso` varchar(255) DEFAULT NULL,
  `nombre_cliente` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `razon_social`, `telefono`, `correo`, `participantes`, `total`, `curso`, `nombre_cliente`, `fecha_registro`) VALUES
(34, 'REBASA DE AGUASCALIENTES, S.A. DE C.V. ', '4496759457', 'Gonzalo@campos', 4, 3145.92, 'Negociacion', 'Esperanza Romo Saucedo', '2025-06-26 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperaciones`
--

CREATE TABLE `recuperaciones` (
  `id` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expira` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recuperaciones`
--

INSERT INTO `recuperaciones` (`id`, `correo`, `token`, `expira`) VALUES
(7, 'olivia.gallardo555@gmail.com', 'e0b445976d71239f6c9cd8069adbf50a6bce640430564f2580f36dbb98d4567a', '2025-06-24 07:31:37'),
(10, 'emtz51044@gmail.com', '9d0cc79f6e03b85533afc8b2bf5c76e5b5d5a41c5244d6afe66d5fd9d0a5730a', '2025-06-30 08:07:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos`
--

CREATE TABLE `seguimientos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `nota` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `estado` varchar(50) DEFAULT 'no respondido',
  `prioridad` varchar(50) DEFAULT 'importante'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimientos`
--

INSERT INTO `seguimientos` (`id`, `cliente_id`, `nota`, `fecha`, `estado`, `prioridad`) VALUES
(7, 22, 'kwhnfkwenf', '2025-06-30 00:24:40', 'respondió', 'urgente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL COMMENT 'id',
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `correo`, `contraseña`, `rol`) VALUES
(1, 'Olivia Gallardo', 'olivia.gallardo555@gmail.com', '$2y$10$6OB8faPz78HSFsq9jWq6.eUaKacnRALmk4VXV63fDjRvr8K6AxlQG', 'admin'),
(2, 'Sustituto', '', '$2y$10$6j6HyxVRYio7c9otrl4/muULj560B9GgGoGnCwUKGAYPchT84alKi', 'admin'),
(5, 'Elena Martinez', 'emtz51044@gmail.com', '$2y$10$WaL/7GS7kpwoMiyombRBbeFsZe0N3akQ0qIbVAAu6ggph71yN5R7O', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos_subidos`
--
ALTER TABLE `archivos_subidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos_excel`
--
ALTER TABLE `documentos_excel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ficha_inscripcion`
--
ALTER TABLE `ficha_inscripcion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recuperaciones`
--
ALTER TABLE `recuperaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos_subidos`
--
ALTER TABLE `archivos_subidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `documentos_excel`
--
ALTER TABLE `documentos_excel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ficha_inscripcion`
--
ALTER TABLE `ficha_inscripcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `recuperaciones`
--
ALTER TABLE `recuperaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `seguimientos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
