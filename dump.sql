-- MySQL dump 10.13  Distrib 5.1.72, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: kosjrunyon
-- ------------------------------------------------------
-- Server version	5.1.72-2

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
-- Table structure for table `apps`
--

DROP TABLE IF EXISTS `apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apps` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appname` varchar(100) NOT NULL,
  `classname` varchar(100) NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  `filename` varchar(100) NOT NULL,
  `access` enum('user','operator','manager') NOT NULL DEFAULT 'user',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`aid`),
  UNIQUE KEY `appname` (`appname`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apps`
--

LOCK TABLES `apps` WRITE;
/*!40000 ALTER TABLE `apps` DISABLE KEYS */;
INSERT INTO `apps` VALUES (1,'App Zone','App_Zone',2,'default/appzone.php','manager',0),(2,'User Manager','User_Manager',2,'default/users.php','operator',1),(3,'App Settings','App_Settings_Manager',2,'default/appsetup.php','operator',0);
/*!40000 ALTER TABLE `apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(100) NOT NULL,
  PRIMARY KEY (`cid`),
  UNIQUE KEY `catname` (`catname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'System'),(2,'Administration');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_apps`
--

DROP TABLE IF EXISTS `session_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_apps` (
  `iid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(10) unsigned NOT NULL,
  `aid` int(11) NOT NULL,
  `corename` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`iid`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_apps`
--

LOCK TABLES `session_apps` WRITE;
/*!40000 ALTER TABLE `session_apps` DISABLE KEYS */;
INSERT INTO `session_apps` VALUES (1,2,4,NULL),(2,3,4,NULL),(3,6,0,NULL),(4,6,0,NULL),(5,6,0,NULL),(6,6,0,NULL),(7,6,0,NULL),(8,6,0,NULL),(9,7,0,NULL),(10,7,0,NULL),(11,7,4,NULL),(12,8,0,NULL),(13,11,0,NULL),(14,12,0,NULL),(15,14,2,NULL),(16,15,0,NULL),(17,16,-1,'credits'),(18,17,-1,'credits'),(19,18,-1,'credits'),(20,18,-1,'credits'),(21,19,-1,'credits'),(22,20,2,NULL),(23,21,2,NULL),(24,22,2,NULL),(25,23,2,NULL),(26,24,2,NULL),(27,25,2,NULL),(28,26,2,NULL);
/*!40000 ALTER TABLE `session_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `started` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lockip` text NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(2,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(3,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(4,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(5,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(6,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(7,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(8,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(9,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(10,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(11,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(12,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(13,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(14,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','85.157.91.21'),(15,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(16,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(17,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(18,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(19,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(20,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(21,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(22,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(23,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(24,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(25,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133'),(26,1,'0000-00-00 00:00:00','0000-00-00 00:00:00','67.79.10.133');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` char(40) NOT NULL,
  `salt` char(5) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `level` enum('user','operator','manager') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'jrunyon','0e4fbcfac8f8627fbebace9647f0b8af8b13eac9','53214','John','manager'),(2,'test','2c378084a75e475bc98a964e27923ab6f1789966','saltd','Test User','manager');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-03 17:31:27
