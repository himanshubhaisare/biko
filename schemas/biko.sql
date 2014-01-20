-- MySQL dump 10.13  Distrib 5.5.27, for osx10.7 (i386)
--
-- Host: localhost    Database: biko
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `biko_categories`
--

DROP TABLE IF EXISTS `biko_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `biko_categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_short_name` varchar(16) NOT NULL,
  `cat_name` varchar(32) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `biko_categories`
--

LOCK TABLES `biko_categories` WRITE;
/*!40000 ALTER TABLE `biko_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `biko_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `biko_products`
--

DROP TABLE IF EXISTS `biko_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `biko_products` (
  `pro_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pro_code` varchar(20) NOT NULL,
  `pro_name` varchar(64) NOT NULL,
  `pro_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `biko_products`
--

LOCK TABLES `biko_products` WRITE;
/*!40000 ALTER TABLE `biko_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `biko_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `biko_users`
--

DROP TABLE IF EXISTS `biko_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `biko_users` (
  `usr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(32) NOT NULL,
  `usr_password` char(60) NOT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `biko_users`
--

LOCK TABLES `biko_users` WRITE;
/*!40000 ALTER TABLE `biko_users` DISABLE KEYS */;
INSERT INTO `biko_users` VALUES (1,'admin','$2a$08$uVtp0noQWpznYmgY2Ch91u3eOEpAGoppxezKZ.BhNgnB1VEpIfkvO');
/*!40000 ALTER TABLE `biko_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-20 10:21:39
