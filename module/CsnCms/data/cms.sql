-- MySQL dump 10.13  Distrib 5.5.27, for Win32 (x86)
--
-- Host: localhost    Database: grd
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
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `artc_id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `usr_id` int(11) DEFAULT NULL,
  `artc_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `artc_slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `artc_introtext` longtext COLLATE utf8_unicode_ci,
  `artc_fulltext` longtext COLLATE utf8_unicode_ci,
  `artc_created` datetime DEFAULT NULL,
  `artc_parent_id` int(11) DEFAULT NULL,
  `rs_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`artc_id`),
  KEY `IDX_BFDD3168D7077436` (`lng_id`),
  KEY `IDX_BFDD3168C69D3FB` (`usr_id`),
  KEY `IDX_BFDD316828D797FE` (`artc_parent_id`),
  KEY `IDX_BFDD3168A5BA57E2` (`rs_id`),
  CONSTRAINT `FK_BFDD316828D797FE` FOREIGN KEY (`artc_parent_id`) REFERENCES `articles` (`artc_id`),
  CONSTRAINT `FK_BFDD3168A5BA57E2` FOREIGN KEY (`rs_id`) REFERENCES `resources` (`rs_id`),
  CONSTRAINT `FK_BFDD3168C69D3FB` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`),
  CONSTRAINT `FK_BFDD3168D7077436` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`lng_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,1,1,'cretated-by-stoyan','created-by-stoyan-html','Test for Stoyan','Test for Stoyan','2013-05-24 23:00:00',NULL,NULL),(2,1,2,'test2-by-stoyan','test2-by-stoyan2','Tralalal la la','Tralalal la la','2013-05-01 23:00:56',NULL,NULL),(4,2,3,'test-stoyan-test','test-stoyan-test','Tralalal','Ful text','2013-05-26 00:00:00',NULL,NULL),(6,1,4,'test-test-for-stoyan','test-slug-stoyan','Test dhfsajh fhsdajhfsdjh!','Test retewtwre mfgsdgsfd slslgskl!','2013-05-24 23:55:36',NULL,NULL),(7,1,2,'test-for-parent','test-for-parent-html','Test intro','Test full text','2013-05-24 20:04:36',1,NULL),(8,2,2,'this-is-translation','translation-html','טףוטףע  רטוסךרס ן  ךוטסךרוסטך\r\nפסהפספ ס פסה ס','sdfdsf מאÿ מÿ פסהפסה','2013-05-27 23:45:56',1,NULL),(9,3,6,'sdf-dsaf-fsd','fsdf-fsdf-fsd','Øוÿר ÿאמאÿמ מÿאמÿא האסהסאה האהאס','ÿמעÿאזעגם עזםג עזÿאם פיס ךכי יספ כ','2013-05-27 09:05:37',1,NULL),(10,2,6,'hsdfgjh-fsdhfksah','sdjhfkjsd-fds-html','akjfhsjk fjh jfh kj','fjsdhfkj fjk jfk jfkd','2013-05-27 09:14:03',2,NULL),(11,1,3,'sfjf-fdgfhj-gfdhjh','gfdhgjdf-gfdgfjkh-fdg','Inter fasjdfhj  hjh','dsn h h','2013-05-27 12:38:21',1,NULL),(12,5,6,'translation-for-bukgarian','translation-for-bukgarian','Translation sdfafa','fadsfasas das asf','2013-05-27 12:42:25',1,NULL),(15,4,1,'my-first-translation','my-first-translation','My first translation intro','My first translation full','2013-05-27 16:01:36',6,NULL),(16,1,2,'public-article','this-is-my-slug','Intro text','Fll text','2013-05-24 20:04:36',NULL,NULL),(17,1,2,'public-article','this-is-my-slug','Intro text','Fll text','2013-05-24 20:04:36',NULL,NULL),(18,1,2,'public-article','this-is-my-slug','Intro text','Fll text','2013-05-24 20:04:36',NULL,NULL),(19,1,2,'public-article','this-is-my-slug','Intro text','Fll text','2013-05-24 20:04:36',NULL,NULL),(20,2,2,'wqewr-rweqrwqe','rwere-rwerew','Intro text','Full text','2012-05-24 00:00:00',2,NULL),(21,1,3,'date-time-separated','date-time-separated','<p>Intro text</p>','<p>Full text</p>','2013-05-24 23:00:00',NULL,NULL),(22,1,3,'date-time-separated','date-time-separated','<p>Intro text</p>','<p>Full text</p>','2013-05-08 01:00:00',NULL,2),(23,2,3,'test-for-parent1','rwere-rwerew','<p>intro text</p>','<p>full text</p>','2013-05-09 01:58:00',NULL,4),(24,2,3,'test-for-parent1','rwere-rwerew','<p>intro text</p>','<p>full text</p>','2013-05-09 11:58:00',NULL,4);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles_categories`
--

DROP TABLE IF EXISTS `articles_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles_categories` (
  `artc_id` int(11) NOT NULL,
  `ctgr_id` int(11) NOT NULL,
  PRIMARY KEY (`artc_id`,`ctgr_id`),
  KEY `IDX_DE004A0E4A863625` (`artc_id`),
  KEY `IDX_DE004A0EC4A519B9` (`ctgr_id`),
  CONSTRAINT `FK_DE004A0E4A863625` FOREIGN KEY (`artc_id`) REFERENCES `articles` (`artc_id`),
  CONSTRAINT `FK_DE004A0EC4A519B9` FOREIGN KEY (`ctgr_id`) REFERENCES `categories` (`ctgr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles_categories`
--

LOCK TABLES `articles_categories` WRITE;
/*!40000 ALTER TABLE `articles_categories` DISABLE KEYS */;
INSERT INTO `articles_categories` VALUES (1,1),(1,2),(2,2),(2,3),(4,1),(4,3),(6,1),(7,1),(7,3),(8,1),(8,3),(9,1),(9,2),(10,2),(10,3),(11,1),(11,2),(12,1),(12,2),(15,2),(15,3),(16,1),(16,2),(17,1),(17,2),(18,1),(18,2),(19,1),(19,2),(20,1),(20,2),(21,1),(22,1),(23,1),(23,3),(24,1),(24,3);
/*!40000 ALTER TABLE `articles_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `ctgr_id` int(11) NOT NULL AUTO_INCREMENT,
  `ctgr_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ctgr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Sport'),(2,'Science'),(3,'Education');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_id` int(11) DEFAULT NULL,
  `usr_id` int(11) DEFAULT NULL,
  `artc_id` int(11) DEFAULT NULL,
  `com_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `com_text` longtext COLLATE utf8_unicode_ci,
  `com_created` datetime DEFAULT NULL,
  PRIMARY KEY (`com_id`),
  KEY `IDX_5F9E962AD7077436` (`lng_id`),
  KEY `IDX_5F9E962AC69D3FB` (`usr_id`),
  KEY `IDX_5F9E962A4A863625` (`artc_id`),
  CONSTRAINT `FK_5F9E962A4A863625` FOREIGN KEY (`artc_id`) REFERENCES `articles` (`artc_id`),
  CONSTRAINT `FK_5F9E962AC69D3FB` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`),
  CONSTRAINT `FK_5F9E962AD7077436` FOREIGN KEY (`lng_id`) REFERENCES `languages` (`lng_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,3,3,1,'test-comment','This is my test comment','2013-05-27 17:38:09'),(2,3,1,7,'comment-my','This is my comment','2013-05-27 17:41:30'),(3,1,1,7,'ahsdaf-fsdfhkh','test for Stoyan','2013-05-27 18:16:58'),(6,1,2,1,'ANother-comment','This is another comment','2013-05-28 10:07:57');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `lng_id` int(11) NOT NULL AUTO_INCREMENT,
  `lng_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lng_abbreviation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lng_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English','en'),(2,'French','fr'),(3,'Spanish','es'),(4,'German','de'),(5,'Bulgarian','bg');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `rs_id` int(11) NOT NULL AUTO_INCREMENT,
  `rs_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`rs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
INSERT INTO `resources` VALUES (1,'all'),(2,'Public Resource'),(3,'Private Resource'),(4,'Admin Resource');
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `rl_id` int(11) NOT NULL AUTO_INCREMENT,
  `rl_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`rl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Public'),(2,'Member'),(3,'Administrator'),(4,'Test');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-10 14:57:43
