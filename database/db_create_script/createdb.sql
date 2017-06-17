-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: golf
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
-- Current Database: `golf`
--

/*!40000 DROP DATABASE IF EXISTS `golf`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `golf` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `golf`;

--
-- Table structure for table `campo`
--

DROP TABLE IF EXISTS `campo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campo` (
  `id` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `par_hoyo_1` int(11) NOT NULL,
  `par_hoyo_2` int(11) NOT NULL,
  `par_hoyo_3` int(11) NOT NULL,
  `par_hoyo_4` int(11) NOT NULL,
  `par_hoyo_5` int(11) NOT NULL,
  `par_hoyo_6` int(11) NOT NULL,
  `par_hoyo_7` int(11) NOT NULL,
  `par_hoyo_8` int(11) NOT NULL,
  `par_hoyo_9` int(11) NOT NULL,
  `par_hoyo_10` int(11) NOT NULL,
  `par_hoyo_11` int(11) NOT NULL,
  `par_hoyo_12` int(11) NOT NULL,
  `par_hoyo_13` int(11) NOT NULL,
  `par_hoyo_14` int(11) NOT NULL,
  `par_hoyo_15` int(11) NOT NULL,
  `par_hoyo_16` int(11) NOT NULL,
  `par_hoyo_17` int(11) NOT NULL,
  `par_hoyo_18` int(11) NOT NULL,
  `ventaja_hoyo_1` int(11) NOT NULL,
  `ventaja_hoyo_2` int(11) NOT NULL,
  `ventaja_hoyo_3` int(11) NOT NULL,
  `ventaja_hoyo_4` int(11) NOT NULL,
  `ventaja_hoyo_5` int(11) NOT NULL,
  `ventaja_hoyo_6` int(11) NOT NULL,
  `ventaja_hoyo_7` int(11) NOT NULL,
  `ventaja_hoyo_8` int(11) NOT NULL,
  `ventaja_hoyo_9` int(11) NOT NULL,
  `ventaja_hoyo_10` int(11) NOT NULL,
  `ventaja_hoyo_11` int(11) NOT NULL,
  `ventaja_hoyo_12` int(11) NOT NULL,
  `ventaja_hoyo_13` int(11) NOT NULL,
  `ventaja_hoyo_14` int(11) NOT NULL,
  `ventaja_hoyo_15` int(11) NOT NULL,
  `ventaja_hoyo_16` int(11) NOT NULL,
  `ventaja_hoyo_17` int(11) NOT NULL,
  `ventaja_hoyo_18` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campo_usuario_id_fk` (`owner_id`),
  CONSTRAINT `campo_usuario_id_fk` FOREIGN KEY (`owner_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clave_consulta_partido`
--

DROP TABLE IF EXISTS `clave_consulta_partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clave_consulta_partido` (
  `clave` char(8) NOT NULL,
  PRIMARY KEY (`clave`),
  UNIQUE KEY `clave_partido_clave_uindex` (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clave_edicion_partido`
--

DROP TABLE IF EXISTS `clave_edicion_partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clave_edicion_partido` (
  `clave` char(8) NOT NULL,
  PRIMARY KEY (`clave`),
  UNIQUE KEY `clave_edicion_partido_clave_uindex` (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contador_id_campo`
--

DROP TABLE IF EXISTS `contador_id_campo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contador_id_campo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partido`
--

DROP TABLE IF EXISTS `partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inicio` datetime NOT NULL,
  `fin` datetime DEFAULT NULL,
  `clave_consulta` char(8) NOT NULL,
  `clave_edicion` char(8) NOT NULL,
  `tablero_json` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partido_clave_consulta_uindex` (`clave_consulta`),
  UNIQUE KEY `partido_clave_edicion_uindex` (`clave_edicion`),
  CONSTRAINT `partido_clave_consulta_partido_clave_fk` FOREIGN KEY (`clave_consulta`) REFERENCES `clave_consulta_partido` (`clave`) ON DELETE CASCADE,
  CONSTRAINT `partido_clave_edicion_partido_clave_fk` FOREIGN KEY (`clave_edicion`) REFERENCES `clave_edicion_partido` (`clave`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_email_uindex` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-17 13:17:18
