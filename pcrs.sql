-- MySQL dump 10.13  Distrib 5.1.43, for Win32 (ia32)
--
-- Host: localhost    Database: pcrs
-- ------------------------------------------------------
-- Server version	5.1.43-community

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
-- Table structure for table `access_levels`
--

DROP TABLE IF EXISTS `access_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_levels` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `description` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_levels`
--

LOCK TABLES `access_levels` WRITE;
/*!40000 ALTER TABLE `access_levels` DISABLE KEYS */;
INSERT INTO `access_levels` VALUES (1,'Customer'),(2,'Employee'),(3,'Sales'),(4,'Manager');
/*!40000 ALTER TABLE `access_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_customers`
--

DROP TABLE IF EXISTS `business_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_customers` (
  `customer_id` int(8) unsigned NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `contact_title` char(20) NOT NULL,
  `url` char(20) DEFAULT NULL,
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `business_customers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_customers`
--

LOCK TABLES `business_customers` WRITE;
/*!40000 ALTER TABLE `business_customers` DISABLE KEYS */;
INSERT INTO `business_customers` VALUES (1,'Google Inc.','Liason','http://google.com'),(13,'Apple Inc.','Steve Jobs','http://www.apple.com');
/*!40000 ALTER TABLE `business_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_complaints`
--

DROP TABLE IF EXISTS `customer_complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_complaints` (
  `id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_complaints_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_complaints`
--

LOCK TABLES `customer_complaints` WRITE;
/*!40000 ALTER TABLE `customer_complaints` DISABLE KEYS */;
INSERT INTO `customer_complaints` VALUES (1,1,'2010-04-29 19:19:52','something else','something',1),(2,1,'2010-04-29 19:25:27','new complaint','sdsadasdasdasd',1);
/*!40000 ALTER TABLE `customer_complaints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_discounts`
--

DROP TABLE IF EXISTS `customer_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_discounts` (
  `discount_id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `employee_id` int(8) unsigned NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`discount_id`,`customer_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `customer_discounts_ibfk_1` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`),
  CONSTRAINT `customer_discounts_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_discounts_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_discounts`
--

LOCK TABLES `customer_discounts` WRITE;
/*!40000 ALTER TABLE `customer_discounts` DISABLE KEYS */;
INSERT INTO `customer_discounts` VALUES (2,1,2,'2010-04-28'),(2,2,2,'2010-04-28'),(3,1,2,'2010-04-28');
/*!40000 ALTER TABLE `customer_discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_leads`
--

DROP TABLE IF EXISTS `customer_leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_leads` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `lead_id` int(8) unsigned NOT NULL,
  `rank` int(1) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `lead_id` (`lead_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `customer_leads_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  CONSTRAINT `customer_leads_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_leads_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_leads`
--

LOCK TABLES `customer_leads` WRITE;
/*!40000 ALTER TABLE `customer_leads` DISABLE KEYS */;
INSERT INTO `customer_leads` VALUES (1,2,1,1,1,'2010-04-24 08:30:43'),(2,2,2,2,1,'2010-04-24 08:31:21'),(3,2,2,3,1,'2010-04-24 08:31:45'),(4,2,1,4,1,'2010-04-24 08:34:19'),(5,2,2,5,1,'2010-04-24 08:41:59'),(6,2,2,6,1,'2010-04-24 08:45:59'),(7,2,2,7,1,'2010-04-24 08:48:22'),(8,2,2,8,1,'2010-04-24 08:48:43'),(9,2,1,9,1,'2010-04-24 08:49:18'),(10,2,1,10,4,'2010-04-24 08:59:25'),(11,2,1,11,1,'2010-04-24 09:00:58'),(12,2,1,12,1,'2010-04-24 09:05:48'),(13,2,1,13,1,'2010-04-24 09:10:40'),(14,2,1,14,1,'2010-04-24 09:11:36'),(15,2,1,15,1,'2010-04-24 09:14:16'),(16,2,1,16,3,'2010-04-24 09:14:48'),(17,2,1,17,1,'2010-04-24 09:18:04'),(18,2,1,18,1,'2010-04-24 09:18:45'),(19,2,2,19,1,'2010-04-25 07:25:01');
/*!40000 ALTER TABLE `customer_leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_orders`
--

DROP TABLE IF EXISTS `customer_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_orders` (
  `id` int(8) unsigned NOT NULL,
  `customer_id` int(8) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `service_id` int(8) unsigned NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `customer_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_orders_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_orders`
--

LOCK TABLES `customer_orders` WRITE;
/*!40000 ALTER TABLE `customer_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` char(15) NOT NULL,
  `last_name` char(20) NOT NULL,
  `email` char(30) NOT NULL,
  `street` varchar(80) NOT NULL,
  `suite` char(8) DEFAULT NULL,
  `city` char(15) NOT NULL,
  `state` char(2) NOT NULL,
  `zipcode` char(6) NOT NULL,
  `type` set('b','i') NOT NULL,
  `status` set('a','i') NOT NULL,
  `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'John','Hancock','j.hancock@google.com','100 North Ave','2R','Chicago','IL','60605','b','a','2010-04-29 21:53:01','jHancock1'),(2,'Peter','Hancock','p.Hancock@gmail.com','12 W 31st street','2 Rear','Chicago','IL','60616','b','a','2010-04-29 21:53:15','pHancock1'),(8,'Stewie','Griffin','stewie@familyguy.com','31 Spooner Street','NA','Quahog','AK','93','i','a','2010-04-27 20:45:56','sGriffin1'),(9,'Glenn','Quagmire','g.Quagmire@alright.com','27 Spooner Street','NA','Quahog','RI','93','i','a','2010-04-28 03:48:09','gQuagmire1'),(13,'Steve','Jobs','steve@apple.com','Far Far Away','1','Palo Alto','CA','94301','b','a','2010-04-28 05:10:19','sJobs1');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `employee_id` int(8) unsigned NOT NULL,
  `value` double DEFAULT NULL,
  `lead_type` char(15) NOT NULL,
  `criteria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
INSERT INTO `discounts` VALUES (1,'Visa Card Holders','2010-04-01','2010-04-21',2,10,'Sales',1),(2,'Mastercard Customers','2010-04-22','2010-04-30',2,7.5,'Repair',2),(3,'Spring Sale!','2010-04-01','2010-05-15',2,7.5,'Sales',10),(4,'Summer Bonanza','2010-05-03','2010-05-30',2,10,'Sales',3),(5,'Summer Bonanza','2010-04-01','2010-06-01',2,10,'Sales',15),(6,'Independance Say Sale','2010-07-01','2010-07-08',2,15,'Sales',4);
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` char(15) NOT NULL,
  `last_name` char(20) NOT NULL,
  `email` char(30) NOT NULL,
  `street` varchar(80) NOT NULL,
  `suite` char(8) DEFAULT NULL,
  `city` char(15) NOT NULL,
  `state` char(2) NOT NULL,
  `zipcode` char(6) NOT NULL,
  `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` char(12) NOT NULL,
  `access_level` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `access_level` (`access_level`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`access_level`) REFERENCES `access_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Admini','Strator','admin@pcrs.com','3420 S Cottage Grove','1105','Chicago','IL','60616','2010-04-29 21:51:53','aDmin1',4),(2,'Sally','Pearson','pearson@pcrs.com','232 Fullerton','3F','Chicago','IL','60632','2010-04-29 21:51:36','sPearson1',3),(3,'Peter','Griffin','peter@familyguy.com','31 Spooner Street','NA','Qouhog','RI','93','2010-04-29 18:58:40','pGriffin1',3),(5,'Sheldon','Cooper','s.cooper@bbt.com','No Idea','4A','Pasadena','CA','91101','2010-04-28 04:25:41','sCooper1',3);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leads` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` char(100) NOT NULL,
  `type` varchar(12) NOT NULL,
  `status` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (1,'HP Pavilion Laptop HDD Repair','Repair','Open'),(2,'MS Office 2007 Product Suite','Sales','Open'),(3,'Fedora Core 12','Installation','Open'),(4,'Laptop Fan','Repair','Open'),(5,'Desktop Monitor','Repair','Open'),(6,'Apple MacBook Pro','Sales','Open'),(7,'HP Pavilion Laptop Screen','Repair','Open'),(8,'HP Pavilion Laptop Screen','Repair','Open'),(9,'MS Windows 7','Installation','Open'),(10,'Sony Vaio Laptop','Sales','Open'),(11,'Sony Vaio - OS Crash','Repair','Open'),(12,'Something New','Sales','Open'),(13,'Something','Sales','Open'),(14,'Something','Sales','Closed'),(15,'Check Power','Repair','Closed'),(16,'Check Power cable dude','Repair','Open'),(17,'Check it out','Sales','Open'),(18,'Check out','Sales','Open'),(19,'LOTR','Sales','Open');
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `description` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-04-29 16:55:28
