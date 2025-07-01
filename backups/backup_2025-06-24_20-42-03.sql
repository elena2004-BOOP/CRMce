-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: crm
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `archivos_subidos`
--

DROP TABLE IF EXISTS `archivos_subidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archivos_subidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivos_subidos`
--

LOCK TABLES `archivos_subidos` WRITE;
/*!40000 ALTER TABLE `archivos_subidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivos_subidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `proxima_llamada` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (19,'M','Elena Martinez','4496759457','elena@gmail.com','Ags, Jesus Maria','2025-06-24 01:02:03','Universidad Tecnologica de Aguascalientes','Gerente','Recursos Humanos','#0000FF','hddjs','2025-06-25 01:06:00'),(20,'N','Ivan','4496759457','elena@gmail.com','Morelos','2025-06-24 18:07:17','Universidad Tecnologica de Aguascalientes','Gerente','Recursos Humanos','#FF0000','hddjs','2025-06-20 18:07:00'),(21,'M','Esperanza Romo Saucedo','4493931433','esperanzaromos@gmail.com','Plan de Allende #100','2025-06-24 20:32:16','Universidad Tecnologica de Aguascalientes','Gerente','Recursos Humanos','#FF0000','No tuvo oportunidad de contestar, estaba comiento','2025-06-20 20:32:00');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_excel`
--

DROP TABLE IF EXISTS `documentos_excel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentos_excel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_excel`
--

LOCK TABLES `documentos_excel` WRITE;
/*!40000 ALTER TABLE `documentos_excel` DISABLE KEYS */;
INSERT INTO `documentos_excel` VALUES (4,'inscripciones_2025-06-25_04-13-05.xlsx','documentos/inscripciones_2025-06-25_04-13-05.xlsx','Olivia Gallardo','2025-06-24 20:13:05');
/*!40000 ALTER TABLE `documentos_excel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ficha_inscripcion`
--

DROP TABLE IF EXISTS `ficha_inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ficha_inscripcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `horario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ficha_inscripcion`
--

LOCK TABLES `ficha_inscripcion` WRITE;
/*!40000 ALTER TABLE `ficha_inscripcion` DISABLE KEYS */;
INSERT INTO `ficha_inscripcion` VALUES (2,'2025-06-24','Olivia Gallardo','Negociacion','Elena','REBASA DE AGUASCALIENTES, S.A. DE C.V. ','AV.  CONVENCION DE 1914 SUR  609 ','LAS AMERICAS C.P.  20230','AGUASCALIENTES, AGS','RAG041206ET1','4496759457','REGIMEN GENERAL DE LAS PERSONAS MORALES','PUE','TRASFERENCIA ELECTRONICA','GASTOS EN GENERAL','2','0',6,678.00,4068.00,650.88,4718.88,'TRÁMITE','TEAMS','0000-00-00','8:30 a 10:00'),(15,'2025-06-24','Olivia Gallardo','Negociacion','Elena','REBASA DE AGUASCALIENTES, S.A. DE C.V. ','AV.  CONVENCION DE 1914 SUR  609 ','LAS AMERICAS C.P.  20230','AGUASCALIENTES, AGS','RAG041206ET1','4496759457','REGIMEN GENERAL DE LAS PERSONAS MORALES','PUE','TRASFERENCIA ELECTRONICA','GASTOS EN GENERAL','2','0',4,678.00,2712.00,433.92,3145.92,'TRÁMITE','TEAMS','2025-06-18','8:30 a 10:00'),(16,'2025-07-02','Olivia Gallardo','Negociacion','Elena','REBASA DE AGUASCALIENTES, S.A. DE C.V. ','AV.  CONVENCION DE 1914 SUR  609 ','LAS AMERICAS C.P.  20230','AGUASCALIENTES, AGS','RAG041206ET1','4496759457','REGIMEN GENERAL DE LAS PERSONAS MORALES','PUE','TRASFERENCIA ELECTRONICA','GASTOS EN GENERAL','2','0',4,678.00,0.00,0.00,0.00,'TRÁMITE','TEAMS','2025-06-18','8:30 a 10:00'),(17,'2025-06-25','Olivia Gallardo','Negociacion','Ivan\r\nElena','REBASA DE AGUASCALIENTES, S.A. DE C.V. ','AV.  CONVENCION DE 1914 SUR  609 ','LAS AMERICAS C.P.  20230','AGUASCALIENTES, AGS','RAG041206ET1','4496759457','REGIMEN GENERAL DE LAS PERSONAS MORALES','PUE','TRASFERENCIA ELECTRONICA','GASTOS EN GENERAL','2','0',4,678.00,2712.00,433.92,3145.92,'TRÁMITE','TEAMS','2025-06-18','8:30 a 10:00'),(18,'2025-06-25','Olivia Gallardo','Negociacion','Elena Martinez \r\nGonzalo Campos\r\nIvan Moreno','REBASA DE AGUASCALIENTES, S.A. DE C.V. ','AV.  CONVENCION DE 1914 SUR  609 ','LAS AMERICAS C.P.  20230','AGUASCALIENTES, AGS','RAG041206ET1','4496759457','REGIMEN GENERAL DE LAS PERSONAS MORALES','PUE','TRASFERENCIA ELECTRONICA','GASTOS EN GENERAL','2','0',4,678.00,2712.00,433.92,3145.92,'TRÁMITE','TEAMS','2025-06-18','8:30 a 10:00'),(19,'2025-06-25','Olivia Gallardo','Negociacion','Elena','REBASA DE AGUASCALIENTES, S.A. DE C.V. ','AV.  CONVENCION DE 1914 SUR  609 ','LAS AMERICAS C.P.  20230','AGUASCALIENTES, AGS','RAG041206ET1','4496759457','REGIMEN GENERAL DE LAS PERSONAS MORALES','PUE','TRASFERENCIA ELECTRONICA','GASTOS EN GENERAL','2','0',4,678.00,2712.00,433.92,3145.92,'TRÁMITE','TEAMS','2025-06-18','8:30 a 10:00');
/*!40000 ALTER TABLE `ficha_inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripciones`
--

DROP TABLE IF EXISTS `inscripciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(255) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `participantes` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `curso` varchar(255) DEFAULT NULL,
  `nombre_cliente` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripciones`
--

LOCK TABLES `inscripciones` WRITE;
/*!40000 ALTER TABLE `inscripciones` DISABLE KEYS */;
INSERT INTO `inscripciones` VALUES (31,'REBASA DE AGUASCALIENTES, S.A. DE C.V. ','4496759457','Gonzalo@campos',4,3145.92,'Negociacion','Ivan','2025-06-25 00:00:00'),(32,'REBASA DE AGUASCALIENTES, S.A. DE C.V. ','4496759457','Gonzalo@campos',4,3145.92,'Negociacion','Esperanza Romo Saucedo','2025-06-25 00:00:00'),(33,'REBASA DE AGUASCALIENTES, S.A. DE C.V. ','4496759457','Gonzalo@campos',4,3145.92,'Negociacion','Elena Martinez','2025-06-25 00:00:00');
/*!40000 ALTER TABLE `inscripciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recuperaciones`
--

DROP TABLE IF EXISTS `recuperaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recuperaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expira` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recuperaciones`
--

LOCK TABLES `recuperaciones` WRITE;
/*!40000 ALTER TABLE `recuperaciones` DISABLE KEYS */;
INSERT INTO `recuperaciones` VALUES (7,'olivia.gallardo555@gmail.com','e0b445976d71239f6c9cd8069adbf50a6bce640430564f2580f36dbb98d4567a','2025-06-24 07:31:37');
/*!40000 ALTER TABLE `recuperaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguimientos`
--

DROP TABLE IF EXISTS `seguimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `nota` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `estado` varchar(50) DEFAULT 'no respondido',
  `prioridad` varchar(50) DEFAULT 'importante',
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `seguimientos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguimientos`
--

LOCK TABLES `seguimientos` WRITE;
/*!40000 ALTER TABLE `seguimientos` DISABLE KEYS */;
INSERT INTO `seguimientos` VALUES (5,20,'Pago pendiente','2025-06-24 18:08:47','no respondió','importante');
/*!40000 ALTER TABLE `seguimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Olivia Gallardo','olivia.gallardo555@gmail.com','$2y$10$6OB8faPz78HSFsq9jWq6.eUaKacnRALmk4VXV63fDjRvr8K6AxlQG','admin'),(2,'Sustituto','','$2y$10$6j6HyxVRYio7c9otrl4/muULj560B9GgGoGnCwUKGAYPchT84alKi','admin'),(5,'Elena Martinez','emtz51044@gmail.com','$2y$10$tccpZAkXrBPgso8zHURqv.NMcme3UHkk49YITrnjynAwUGgiyI/uS','usuario');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-24 20:42:03
