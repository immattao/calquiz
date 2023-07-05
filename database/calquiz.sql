-- MySQL dump 10.13  Distrib 8.0.30, for macos12 (arm64)
--
-- Host: localhost    Database: calquiz
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz` (
  `quizID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `date_completed` date DEFAULT NULL,
  `quiz_score` int DEFAULT NULL,
  `quiz_length` int DEFAULT NULL,
  PRIMARY KEY (`quizID`),
  KEY `userID_idx` (`userID`),
  CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz`
--

LOCK TABLES `quiz` WRITE;
/*!40000 ALTER TABLE `quiz` DISABLE KEYS */;
INSERT INTO `quiz` VALUES (1,1,'2022-12-07',1,1),(2,2,'2022-12-12',3,9),(18,4,'2023-02-26',1,4),(19,4,'2023-02-26',1,2),(20,5,'2023-02-26',2,3),(21,5,'2023-02-26',1,5),(22,5,'2023-02-26',0,1),(23,5,'2023-02-27',1,4),(24,5,'2023-03-01',0,0),(25,5,'2023-03-01',1,1),(26,5,'2023-03-02',0,1),(27,5,'2023-03-03',0,1),(28,6,'2023-03-05',1,2),(29,6,'2023-03-05',1,1),(30,6,'2023-03-06',0,1),(33,4,'2023-03-06',2,4),(34,4,'2023-03-06',1,5),(35,6,'2023-03-06',1,3);
/*!40000 ALTER TABLE `quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password_hash` varchar(225) NOT NULL,
  `email` varchar(64) NOT NULL,
  `total_score` int DEFAULT '0',
  `email_verified` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'olivia','$2y$10$Jj99JQjWCmsBbyyZEiagf.dHYdlNUJtraoLE5/XBUD7232z2GsIwK','olive@gai.com',1,0),(2,'liam','$2y$10$10.uaGSIK6dBvkiwV5KdKuNyuospNIUDMFwa7lHeqTJ9oAa7LeZjK','liamliem@me.org',3,0),(3,'megan','$2y$10$LeY1jUgBsNctt3U.TzpyBuhWIr3qkGrytGVX8oiskscMNy.hdTKGy','meganize@gmail.com',7,0),(4,'alex','$2y$10$kQDwAwS2A6/t/sZEGd5BruzxtR4DKnPlURLpWxMzc.pG9D1Vqv0pa','alex@gmail.com',2,0),(5,'celia','$2y$10$qJrn2x2/EjZvZtd1CWVoSe35WXzIDlFotaFhDQp910ZTjlOQTxVti','celia@gmail.com',5,0),(6,'john','$2y$10$CnnxECLpvz3xuHniLX/UqOG.bybezKwq77V7XK8CTuVRqFl1j7T0y','john@gmail.com',3,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-22 14:42:20
