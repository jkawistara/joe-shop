-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: joeshop
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

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
-- Table structure for table `Banks`
--

DROP TABLE IF EXISTS `Banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Banks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `accountName` varchar(50) NOT NULL,
  `accountNumber` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Banks`
--

LOCK TABLES `Banks` WRITE;
/*!40000 ALTER TABLE `Banks` DISABLE KEYS */;
INSERT INTO `Banks` VALUES (1,'Bank Shopping Joe','1111-111-111-2'),(2,'Bank Daerah 1','1234-5678-9884'),(3,'Bank Kota 2','1234-5678-9883'),(4,'Bank Daerah 2','1234-5678-9885'),(5,'Bank Kota 1','1234-5678-9882');
/*!40000 ALTER TABLE `Banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Coupons`
--

DROP TABLE IF EXISTS `Coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Coupons` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `couponCode` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `value` float NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Coupons`
--

LOCK TABLES `Coupons` WRITE;
/*!40000 ALTER TABLE `Coupons` DISABLE KEYS */;
INSERT INTO `Coupons` VALUES (7,'1001',1,50000,42,'2018-01-01','2018-01-30'),(8,'1002',2,10,19,'2018-01-02','2018-01-30'),(9,'1003',2,20,0,'2018-01-03','2018-01-30'),(10,'1004',2,50,87,'2018-01-04','2018-01-04'),(11,'1005',1,25000,0,'2018-01-05','2018-01-30'),(12,'1006',1,10000,1,'2018-01-06','2018-01-30');
/*!40000 ALTER TABLE `Coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Couriers`
--

DROP TABLE IF EXISTS `Couriers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Couriers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Couriers`
--

LOCK TABLES `Couriers` WRITE;
/*!40000 ALTER TABLE `Couriers` DISABLE KEYS */;
INSERT INTO `Couriers` VALUES (1,'JKE'),(2,'SiNgebut');
/*!40000 ALTER TABLE `Couriers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `productId` bigint(20) NOT NULL,
  `orderedQuantity` int(11) NOT NULL,
  `orderedDate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Orders_fk0` (`userId`),
  KEY `Orders_fk1` (`productId`),
  CONSTRAINT `Orders_fk0` FOREIGN KEY (`userId`) REFERENCES `Users` (`id`),
  CONSTRAINT `Orders_fk1` FOREIGN KEY (`productId`) REFERENCES `Products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Orders`
--

LOCK TABLES `Orders` WRITE;
/*!40000 ALTER TABLE `Orders` DISABLE KEYS */;
INSERT INTO `Orders` VALUES (1,2,1,3,'2018-01-06'),(2,2,1,2,'2018-01-06'),(3,2,1,2,'2018-01-06'),(4,3,1,3,'2018-01-06'),(5,3,3,1,'2018-01-06');
/*!40000 ALTER TABLE `Orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` float NOT NULL,
  `cost` float NOT NULL,
  `discountValue` float DEFAULT NULL,
  `discountType` int(11) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
INSERT INTO `Products` VALUES (1,'Red Clothes XL',97,240000,240000,20,1,'https://s3-ap-southeast-1.amazonaws.com/jojoshoping/red-xl.png'),(2,'Green Cool XL',5,150000,150000,20000,2,'https://s3-ap-southeast-1.amazonaws.com/jojoshoping/green-xl.png'),(3,'Yellow Cool XL',49,150000,150000,0,0,'https://s3-ap-southeast-1.amazonaws.com/jojoshoping/yellow-xl.png');
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles`
--

LOCK TABLES `Roles` WRITE;
/*!40000 ALTER TABLE `Roles` DISABLE KEYS */;
INSERT INTO `Roles` VALUES (1,1,'member'),(2,2,'admin');
/*!40000 ALTER TABLE `Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TransactionDetails`
--

DROP TABLE IF EXISTS `TransactionDetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TransactionDetails` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bankId` bigint(20) NOT NULL,
  `couponId` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `totalPrice` float NOT NULL,
  `totalPayment` float NOT NULL,
  `transactionDate` date NOT NULL,
  `paymentDate` date DEFAULT NULL,
  `paymentReceipt` varchar(255) DEFAULT NULL,
  `shippingId` varchar(100) DEFAULT NULL,
  `courierId` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `TransactionDetails_fk0` (`bankId`),
  KEY `TransactionDetails_fk1` (`couponId`),
  CONSTRAINT `TransactionDetails_fk0` FOREIGN KEY (`bankId`) REFERENCES `Banks` (`id`),
  CONSTRAINT `TransactionDetails_fk1` FOREIGN KEY (`couponId`) REFERENCES `Coupons` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TransactionDetails`
--

LOCK TABLES `TransactionDetails` WRITE;
/*!40000 ALTER TABLE `TransactionDetails` DISABLE KEYS */;
INSERT INTO `TransactionDetails` VALUES (2,1,7,0,720000,670000,'2018-01-06',NULL,NULL,NULL,NULL),(3,1,7,0,480000,430000,'2018-01-06',NULL,NULL,NULL,NULL),(4,1,7,1,480000,430000,'2018-01-06','2018-01-06','https://jojoshoping.s3.ap-southeast-1.amazonaws.com/transaction/proof-transaction-4-690.jpg','',''),(5,1,8,0,870000,783000,'2018-01-06',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `TransactionDetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Transactions`
--

DROP TABLE IF EXISTS `Transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Transactions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transactionId` bigint(20) NOT NULL,
  `orderId` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Transactions_fk0` (`transactionId`),
  KEY `Transactions_fk1` (`orderId`),
  CONSTRAINT `Transactions_fk0` FOREIGN KEY (`transactionId`) REFERENCES `TransactionDetails` (`id`),
  CONSTRAINT `Transactions_fk1` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Transactions`
--

LOCK TABLES `Transactions` WRITE;
/*!40000 ALTER TABLE `Transactions` DISABLE KEYS */;
INSERT INTO `Transactions` VALUES (1,2,1),(2,3,2),(3,4,3),(4,5,4),(5,5,5);
/*!40000 ALTER TABLE `Transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `roleId` bigint(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `authKey` varchar(255) NOT NULL,
  `accessToken` varchar(255) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Users_fk0` (`roleId`),
  CONSTRAINT `Users_fk0` FOREIGN KEY (`roleId`) REFERENCES `Roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,2,'$2y$13$n4vVZ1Y7W5onrxLPf5s9MOT/7SdrU3wSughOpCv.XuN8eFhdnCEey','',NULL,'Admin','admin@gmail.com','087824347383','Cimahi'),(2,1,'$2y$13$n4vVZ1Y7W5onrxLPf5s9MOT/7SdrU3wSughOpCv.XuN8eFhdnCEey','',NULL,'User','user@gmail.com','087233123232','Cimahi'),(3,1,'$2y$13$ElqzMp7/BJBYCvVdn//.HeL4fpIzdpWB6t2IWz.4TNRf01ZvEQ2.u','',NULL,'User 2','user2@gmail.com','08784242244','Bandung');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1515224797),('m160117_225613_create_cart_table',1515224838);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'joeshop'
--

--
-- Dumping routines for database 'joeshop'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-06 23:26:37
