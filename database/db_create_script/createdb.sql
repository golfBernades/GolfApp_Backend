-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: golf
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apuesta`
--

DROP TABLE IF EXISTS `apuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apuesta_nombre_uindex` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apuesta`
--

LOCK TABLES `apuesta` WRITE;
/*!40000 ALTER TABLE `apuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `apuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apuesta_partido`
--

DROP TABLE IF EXISTS `apuesta_partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apuesta_partido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partido_id` int(11) NOT NULL,
  `apuesta_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apuesta_partido_partido_id_apuesta_id_uindex` (`partido_id`,`apuesta_id`),
  KEY `apuesta_partido_apuesta_id_fk` (`apuesta_id`),
  CONSTRAINT `apuesta_partido_apuesta_id_fk` FOREIGN KEY (`apuesta_id`) REFERENCES `apuesta` (`id`),
  CONSTRAINT `apuesta_partido_partido_id_fk` FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apuesta_partido`
--

LOCK TABLES `apuesta_partido` WRITE;
/*!40000 ALTER TABLE `apuesta_partido` DISABLE KEYS */;
/*!40000 ALTER TABLE `apuesta_partido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campo`
--

DROP TABLE IF EXISTS `campo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `par_hoyo_1` int(11) DEFAULT NULL,
  `par_hoyo_2` int(11) DEFAULT NULL,
  `par_hoyo_3` int(11) DEFAULT NULL,
  `par_hoyo_4` int(11) DEFAULT NULL,
  `par_hoyo_5` int(11) DEFAULT NULL,
  `par_hoyo_6` int(11) DEFAULT NULL,
  `par_hoyo_7` int(11) DEFAULT NULL,
  `par_hoyo_8` int(11) DEFAULT NULL,
  `par_hoyo_9` int(11) DEFAULT NULL,
  `par_hoyo_10` int(11) DEFAULT NULL,
  `par_hoyo_11` int(11) DEFAULT NULL,
  `par_hoyo_12` int(11) DEFAULT NULL,
  `par_hoyo_13` int(11) DEFAULT NULL,
  `par_hoyo_14` int(11) DEFAULT NULL,
  `par_hoyo_15` int(11) DEFAULT NULL,
  `par_hoyo_16` int(11) DEFAULT NULL,
  `par_hoyo_17` int(11) DEFAULT NULL,
  `par_hoyo_18` int(11) DEFAULT NULL,
  `ventaja_hoyo_1` int(11) DEFAULT NULL,
  `ventaja_hoyo_2` int(11) DEFAULT NULL,
  `ventaja_hoyo_3` int(11) DEFAULT NULL,
  `ventaja_hoyo_4` int(11) DEFAULT NULL,
  `ventaja_hoyo_5` int(11) DEFAULT NULL,
  `ventaja_hoyo_6` int(11) DEFAULT NULL,
  `ventaja_hoyo_7` int(11) DEFAULT NULL,
  `ventaja_hoyo_8` int(11) DEFAULT NULL,
  `ventaja_hoyo_9` int(11) DEFAULT NULL,
  `ventaja_hoyo_10` int(11) DEFAULT NULL,
  `ventaja_hoyo_11` int(11) DEFAULT NULL,
  `ventaja_hoyo_12` int(11) DEFAULT NULL,
  `ventaja_hoyo_13` int(11) DEFAULT NULL,
  `ventaja_hoyo_14` int(11) DEFAULT NULL,
  `ventaja_hoyo_15` int(11) DEFAULT NULL,
  `ventaja_hoyo_16` int(11) DEFAULT NULL,
  `ventaja_hoyo_17` int(11) DEFAULT NULL,
  `ventaja_hoyo_18` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campo`
--

LOCK TABLES `campo` WRITE;
/*!40000 ALTER TABLE `campo` DISABLE KEYS */;
INSERT INTO `campo` VALUES (1,'Bernardes',5,6,4,3,8,9,3,7,8,4,7,9,3,9,4,4,5,7,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1);
INSERT INTO `campo` VALUES (2,'Aguascalientes',6,45,5,6,6,5,7,6,5,6,6,5,4,4,5,5,6,5,1,2,3,4,5,10,9,8,7,6,11,12,13,14,15,18,17,16);
INSERT INTO `campo` VALUES (3,'Jerez',4,4,6,6,6,5,5,5,7,6,5,4,5,4,6,5,7,6,1,3,5,7,9,11,13,15,17,2,4,6,8,10,12,14,16,18);
/*!40000 ALTER TABLE `campo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jugador`
--

DROP TABLE IF EXISTS `jugador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jugador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apodo` varchar(10) NOT NULL,
  `handicap` int(11) NOT NULL,
  `sexo` char(1) NOT NULL,
  `url_foto` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jugador_email_uindex` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jugador`
--

LOCK TABLES `jugador` WRITE;
/*!40000 ALTER TABLE `jugador` DISABLE KEYS */;
INSERT INTO `jugador` VALUES (2,'Martín Martínez Pérez','Martín',6,'H','fotos/usuario_2.jpg','holamundo','martin@gmail.com');
INSERT INTO `jugador` VALUES (4,'Porfirio','Porfi',10,'h','foto.jpg','holamundo','porfirioads1@gmail.com');
INSERT INTO `jugador` VALUES (5,'Porfirio','Porfi',10,'h','foto.jpg','holamundo','porfirioads11@gmail.com');
INSERT INTO `jugador` VALUES (6,'Porfirio','Porfi',10,'h','foto.jpg','holamundo','porfirioads1s1@gmail.com');
/*!40000 ALTER TABLE `jugador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jugador_partido`
--

DROP TABLE IF EXISTS `jugador_partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jugador_partido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jugador_id` int(11) NOT NULL,
  `partido_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jugador_partido_jugador_id_partido_id_uindex` (`jugador_id`,`partido_id`),
  KEY `jugador_partido_partido_id_fk` (`partido_id`),
  CONSTRAINT `jugador_partido_jugador_id_fk` FOREIGN KEY (`jugador_id`) REFERENCES `jugador` (`id`),
  CONSTRAINT `jugador_partido_partido_id_fk` FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jugador_partido`
--

LOCK TABLES `jugador_partido` WRITE;
/*!40000 ALTER TABLE `jugador_partido` DISABLE KEYS */;
/*!40000 ALTER TABLE `jugador_partido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partido`
--

DROP TABLE IF EXISTS `partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` char(8) NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime DEFAULT NULL,
  `jugador_id` int(11) NOT NULL,
  `campo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partido_clave_uindex` (`clave`),
  KEY `partido_jugador_id_fk` (`jugador_id`),
  KEY `partido_campo_id_fk` (`campo_id`),
  CONSTRAINT `partido_campo_id_fk` FOREIGN KEY (`campo_id`) REFERENCES `campo` (`id`),
  CONSTRAINT `partido_jugador_id_fk` FOREIGN KEY (`jugador_id`) REFERENCES `jugador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partido`
--

LOCK TABLES `partido` WRITE;
/*!40000 ALTER TABLE `partido` DISABLE KEYS */;
/*!40000 ALTER TABLE `partido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puntuaciones`
--

DROP TABLE IF EXISTS `puntuaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puntuaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hoyo` int(11) NOT NULL,
  `golpes` int(11) NOT NULL,
  `unidades` int(11) NOT NULL DEFAULT '0',
  `jugador_id` int(11) NOT NULL,
  `partido_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `puntuaciones_jugador_id_partido_id_uindex` (`jugador_id`,`partido_id`),
  KEY `puntuaciones_partido_id_fk` (`partido_id`),
  CONSTRAINT `puntuaciones_jugador_id_fk` FOREIGN KEY (`jugador_id`) REFERENCES `jugador` (`id`),
  CONSTRAINT `puntuaciones_partido_id_fk` FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puntuaciones`
--

LOCK TABLES `puntuaciones` WRITE;
/*!40000 ALTER TABLE `puntuaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `puntuaciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-06 13:54:32
