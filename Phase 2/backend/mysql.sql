-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for osx10.6 (i386)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

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
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `ssn` varchar(9) NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `name` (`name`,`address`,`ssn`),
  CONSTRAINT `author_ibfk_1` FOREIGN KEY (`name`, `address`, `ssn`) REFERENCES `people` (`name`, `address`, `ssn`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (10,'Casey Ann','12 Infinite Loop Rd.','123640001'),(8,'Casey Ann','15 Stack Underflow Rd.','123640021'),(9,'Casey Ann','21 Stack Overflow Rd.','123641101'),(7,'Jane Harper','12 Reference Way','000645798'),(6,'Mariana Enriquez','12 Null Pointer St.','013645798'),(3,'Meg Howrey','12 Constraint St.','123645798'),(4,'Megan Hawkins','12 Assembly Way.','123475879'),(1,'Paul La Farge','123 Core Exception St.','123456789'),(5,'Paula Hawkins','12 C Sharp','188645798'),(2,'Sam Shepard','123 Arithmetic Exception St.','123546798');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `ISBN13` varchar(13) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`ISBN13`),
  KEY `pname` (`pname`),
  CONSTRAINT `book_ibfk_1` FOREIGN KEY (`pname`) REFERENCES `publisher` (`pname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES ('2124293979723','Track',2012,'Mystery','Microsoft',12.16),('2198206314351','The Fall',2016,'Drama','Angular Picks',20.99),('4755501624196','Better Me',2011,'Drama','Ubuntu',15.59),('4762078140862','Bags',2017,'Adventure','UMass',17.99),('5144830892793','A dreamer\'s Dream',2015,'Drama','Penguin Press',8.99),('5320250903721','Run',2011,'Adventure','Angular Picks',12.99),('5511832319898','Now',2010,'Mystery','Apple',22.99),('6703920528059','Beginning',2003,'Biography','Ubuntu',21.99),('6766827008919','Loser',2015,'Sports','Angular Picks',12.99),('6909634283510','ABC',2015,'Children','Penguin Press',22.99),('7434511509723','Since Tomorrow',2015,'Drama','Google',12.99),('8290559350046','New Dawn',2002,'Biography','Java Factory',11.99),('8881184298079','Pass',2009,'Drama','UMass',19.99),('9160808332496','Wrong choice',2016,'Horror','Division Papers',9.99),('9284187369746','The Game',2015,'War','Ubuntu',11.99),('9326375508447','Watch',2001,'Mystery','Boston Press',12.99);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `cid` int(11) NOT NULL,
  `ISBN13` varchar(13) NOT NULL,
  `date_added` int(11) NOT NULL,
  KEY `cid` (`cid`),
  KEY `ISBN13` (`ISBN13`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ISBN13`) REFERENCES `book` (`ISBN13`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `ssn` varchar(9) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `name` (`name`,`address`,`ssn`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`name`, `address`, `ssn`) REFERENCES `people` (`name`, `address`, `ssn`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (5,'Casey Ann','12 Infinite Loop Rd.','123640001'),(1,'Devin Bas','50 Some Street','982376459'),(8,'Jane Harper','12 Reference Way','000645798'),(2,'Janet Cross','192 Work Street','987646912'),(10,'Jason Derulo','111 New St.','564675834'),(3,'Jason Garden','90 Old Way','982376459'),(4,'Kevin Garnett','1 Celtics Road','982376459'),(7,'Megan Hawkins','12 Assembly Way.','123475879'),(6,'Paula Hawkins','12 C Sharp','188645798');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `ssn` varchar(9) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`name`,`address`,`ssn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES ('Casey Ann','12 Infinite Loop Rd.','123640001','9874568120','c.ann@inbox.com'),('Casey Ann','15 Stack Underflow Rd.','123640021','9874568120','c.ann@inbox.com'),('Casey Ann','21 Stack Overflow Rd.','123641101','9874568120','c.ann@inbox.com'),('Devin Bas','50 Some Street','982376459','121434878','devinbas@gmail.com'),('Jane Harper','12 Reference Way','000645798','1234001120','harper@yahoo.com'),('Janet Cross','192 Work Street','987646912','131536894','jcross@gmail.com'),('Jason Derulo','111 New St.','564675834','3453422345','jasonderulo@gmail.com'),('Jason Garden','90 Old Way','982376459','121432111','garden@hotmail.com'),('Kevin Garnett','1 Celtics Road','982376459','121222878','kg@gmail.com'),('Mariana Enriquez','12 Null Pointer St.','013645798','1233348120','mariana@hotmail.com'),('Meg Howrey','12 Constraint St.','123645798','1234568120','meg@hotmail.com'),('Megan Hawkins','12 Assembly Way.','123475879','9994568120','hawkins@hotmail.com'),('Paul La Farge','123 Core Exception St.','123456789','1234567890','paul@email.com'),('Paula Hawkins','12 C Sharp','188645798','1230008120','paulahawkins@gmail.com'),('Sam Shepard','123 Arithmetic Exception St.','123546798','1034567120','sam@gmail.com');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publisher`
--

DROP TABLE IF EXISTS `publisher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publisher` (
  `pname` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` char(2) NOT NULL,
  PRIMARY KEY (`pname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publisher`
--

LOCK TABLES `publisher` WRITE;
/*!40000 ALTER TABLE `publisher` DISABLE KEYS */;
INSERT INTO `publisher` VALUES ('Angular Picks','New York City','NY'),('Apple','San Francisco','CA'),('Boston Press','Lowell','MA'),('Division Papers','San Francisco','CA'),('Google','San Francisco','CA'),('Java Factory','Boston','MA'),('Microsoft','Redmond','WA'),('Penguin Press','Boston','MA'),('Ubuntu','Lowell','MA'),('UMass','Boston','MA');
/*!40000 ALTER TABLE `publisher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase` (
  `ISBN13` varchar(13) NOT NULL,
  `cid` int(11) NOT NULL,
  `datetime` int(11) NOT NULL,
  PRIMARY KEY (`ISBN13`,`cid`,`datetime`),
  KEY `cid` (`cid`),
  CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`ISBN13`) REFERENCES `book` (`ISBN13`),
  CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `customer` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase`
--

LOCK TABLES `purchase` WRITE;
/*!40000 ALTER TABLE `purchase` DISABLE KEYS */;
INSERT INTO `purchase` VALUES ('2124293979723',1,1490277192),('2124293979723',2,1491272492),('2124293979723',4,1491274492),('2198206314351',1,1490275192),('2198206314351',4,1491273392),('4755501624196',7,1491272792),('4762078140862',7,1491217792),('5144830892793',7,1491277822),('5320250903721',2,1491272592),('5320250903721',4,1491276692),('5511832319898',1,1491272192),('5511832319898',3,1491271192),('6703920528059',7,1491279792),('6766827008919',2,1491272292),('6766827008919',3,1491272292),('6909634283510',2,1491272192),('6909634283510',7,1491274502),('7434511509723',4,1491275592),('7434511509723',7,1491219792),('8290559350046',4,1491263153),('8290559350046',5,1491270192),('8881184298079',2,1491272692),('8881184298079',6,1491290092),('9160808332496',2,1491272392),('9284187369746',2,1491272792),('9284187369746',4,1491277792);
/*!40000 ALTER TABLE `purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `warehouse_id` int(11) NOT NULL,
  `ISBN13` varchar(13) NOT NULL,
  `count` int(11) NOT NULL,
  KEY `warehouse_id` (`warehouse_id`),
  KEY `ISBN13` (`ISBN13`),
  CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`),
  CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`ISBN13`) REFERENCES `book` (`ISBN13`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(999) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'a@b.com','Zm4='),(2,'test@test.com','cXc=');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouse`
--

DROP TABLE IF EXISTS `warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `state` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouse`
--

LOCK TABLES `warehouse` WRITE;
/*!40000 ALTER TABLE `warehouse` DISABLE KEYS */;
/*!40000 ALTER TABLE `warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `writes`
--

DROP TABLE IF EXISTS `writes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `writes` (
  `ISBN13` varchar(13) NOT NULL,
  `aid` int(11) NOT NULL,
  PRIMARY KEY (`ISBN13`,`aid`),
  KEY `aid` (`aid`),
  CONSTRAINT `writes_ibfk_1` FOREIGN KEY (`ISBN13`) REFERENCES `book` (`ISBN13`),
  CONSTRAINT `writes_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `author` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `writes`
--

LOCK TABLES `writes` WRITE;
/*!40000 ALTER TABLE `writes` DISABLE KEYS */;
INSERT INTO `writes` VALUES ('2124293979723',1),('2198206314351',1),('4755501624196',1),('4762078140862',2),('5144830892793',3),('5320250903721',4),('5511832319898',4),('5511832319898',9),('6703920528059',5),('6703920528059',8),('6766827008919',6),('6909634283510',7),('7434511509723',7),('8290559350046',7),('8881184298079',7),('9160808332496',8),('9284187369746',9),('9326375508447',2),('9326375508447',3),('9326375508447',10);
/*!40000 ALTER TABLE `writes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-27  9:32:29
