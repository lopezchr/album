CREATE DATABASE  IF NOT EXISTS `album` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `album`;
-- MySQL dump 10.13  Distrib 5.6.17, for osx10.6 (i386)
--
-- Host: intance1.cbvlxycvzn0h.sa-east-1.rds.amazonaws.com    Database: album
-- ------------------------------------------------------
-- Server version	5.6.13-log

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
-- Table structure for table `album_sections`
--

DROP TABLE IF EXISTS `album_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album_sections` (
  `als_id` int(11) NOT NULL AUTO_INCREMENT,
  `alb_id` int(11) NOT NULL,
  `als_name` varchar(45) NOT NULL,
  `als_order` varchar(45) NOT NULL,
  `als_num_sheets` varchar(45) NOT NULL,
  PRIMARY KEY (`als_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_sections`
--

LOCK TABLES `album_sections` WRITE;
/*!40000 ALTER TABLE `album_sections` DISABLE KEYS */;
INSERT INTO `album_sections` VALUES (1,7,'Default Sectction','1','300'),(2,2,'default','1','350'),(4,3,'seccion prueba','1','300'),(5,2,'equipos','2','100');
/*!40000 ALTER TABLE `album_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albums` (
  `alb_id` int(11) NOT NULL AUTO_INCREMENT,
  `alb_name` varchar(45) NOT NULL,
  `alb_description` varchar(45) NOT NULL,
  `alb_year` varchar(45) NOT NULL,
  PRIMARY KEY (`alb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums`
--

LOCK TABLES `albums` WRITE;
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
INSERT INTO `albums` VALUES (2,'prueba','asdfsadf','2223'),(3,'prueba 2','sadfdsa','1234');
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sheets`
--

DROP TABLE IF EXISTS `sheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sheets` (
  `sht_id` int(11) NOT NULL AUTO_INCREMENT,
  `alb_id` int(11) NOT NULL,
  `sht_number` int(11) NOT NULL,
  PRIMARY KEY (`sht_id`,`sht_number`,`alb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sheets`
--

LOCK TABLES `sheets` WRITE;
/*!40000 ALTER TABLE `sheets` DISABLE KEYS */;
INSERT INTO `sheets` VALUES (4,2,1),(7,2,0),(8,2,3),(9,2,4),(10,2,7),(11,2,8),(12,2,50);
/*!40000 ALTER TABLE `sheets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-30 23:55:11
