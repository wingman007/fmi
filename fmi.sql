-- MySQL dump 10.13  Distrib 5.1.50, for Win32 (ia32)
--
-- Host: localhost    Database: fmi
-- ------------------------------------------------------
-- Server version	5.1.50-community

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
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` VALUES (1,'The  Military  Wives','In  My  Dreams'),(2,'Adele','21'),(3,'Bruce  Springsteen','Wrecking Ball (Deluxe)'),(4,'Lana  Del  Rey','Born  To  Die'),(5,'Gotye','Making  Mirrors'),(7,'artistr32','test'),(8,'rewqqrqwerwq','erwqerqw'),(9,'test','test'),(10,'bind23','testche');
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `usrl_id` int(11) NOT NULL AUTO_INCREMENT,
  `usrl_name` varchar(50) NOT NULL,
  PRIMARY KEY (`usrl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='The System Roles. Who can see and do what';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,'Public'),(2,'Prospect'),(3,'Member'),(4,'Admin');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usr_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usr_email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `usrl_id` int(11) DEFAULT NULL,
  `lng_id` int(11) DEFAULT NULL,
  `usr_active` tinyint(1) NOT NULL,
  `usr_question` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_answer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_password_salt` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'dynamicSalt',
  `usr_registration_date` datetime DEFAULT NULL COMMENT 'Registration moment',
  `usr_registration_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'unique id sent by e-mail',
  `usr_email_confirmed` tinyint(1) NOT NULL COMMENT 'e-mail confirmed by user',
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sadfasfsa','fsadfasfas','fsdafs@fsdfs.com',2,1,1,'safasdf','fasdf','fsadfsa','','2013-07-19 12:00:00','',0),(10,'petkan','f05130dad0b4ac89e3127824346d0b9c','stoyancheresharov@gmail.com',2,1,1,NULL,NULL,NULL,'})Zkeir*azuwZ^F?<#|$Wn]EaE:iz^OP<`7oIKZu&(7@0FgNT#','2013-07-17 12:11:25','87a3eac1b666a250e9084925419f0020',1),(11,'dragan','123455','cheresharov@hotmail.com',2,1,1,'','','','SfuxI(5LPD;wZ>ehod@>Q*M7|+xTZk3DZ<QOaxaS@Du%!Z`EI[','2013-07-17 12:35:43','6b3b8769cfc0acdaafdfb49a34d02b43',1),(24,'efas','fasdfefsa','fsda@fdsfs.com',1,1,0,'sfd','dfsg','gdsfg','gsdfg','2013-07-19 12:00:00','gsdf',0),(25,'stoyan1','sfsfsfs','fdsfs@fdsfsd.com',2,1,1,'dsfsa','fsdaf','fsadf','fsad','2013-07-19 12:00:00','fadsfas',1),(26,'fdfasf','fsdafas','fasdfas@fsdfs.com',2,2,1,'fdsafasdf','fsdaf','fsdafas','','2013-07-19 12:00:00','fsdfads',1),(27,'dasda','DSADASd','dsa@asdasdasd.com',1,1,0,'fdsafas','fsdaf','fdsaf','fsdaf','2013-07-19 12:00:00','6b3b8769cfc0acdaafdfb49a34d02b43',0),(28,'test21','dqdqadfs','dsda@dfsf.com',1,1,1,'fsd','fsda','fsad','fsdaf','2013-07-19 12:00:00','fdasf',1),(29,'dsfsdfs','fdsfsa','sdfsa@fsds.com',3,2,1,'dfsfas','fsdfs','fsdf','fsdfasf','2013-07-19 12:00:00','weewqrqw',1),(30,'saasdfsaf','fdsafsadf','fdsf@fsdfds.com',2,2,1,'ewqrwq','rewqrq','rewqrwq','rewqrw','2013-07-19 12:00:00','eqwrqw',1),(31,'ewqrqw','rweqrwq','rwerewq@fdsfsd.com',2,2,1,'dfsaf','fsdafa','fdsafasd','fdsafas','2013-07-19 12:00:00','fsfgds',1),(32,'erwrewt21','retrwet','fgds@fsfds.com',2,2,1,'gdsfg','gdfsg','gdsf','gsfd','2013-07-19 12:23:00','fsfs',1),(53,'stoyan','c21d6dfdd7ce8613dd34c8a14db38bdd','cheresharov@ihahockey.com',2,1,1,NULL,NULL,NULL,'f0/4!,\\e@(~opaYn)VP?0r@yKBOW:Qd$^D\'/^_6}A!B>seB-o1','2013-08-02 05:50:45','bbf6f694131646eab918bf300b01dd5c',1);
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

-- Dump completed on 2013-08-08 21:59:59
