-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: kokekompis
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bestilling`
--

DROP TABLE IF EXISTS `bestilling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bestilling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bruker_id` int(11) NOT NULL,
  `handle_tid` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bestilling_brukere1_idx` (`bruker_id`),
  CONSTRAINT `bestilling_bruker_id_fk` FOREIGN KEY (`bruker_id`) REFERENCES `brukere` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brukere`
--

DROP TABLE IF EXISTS `brukere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brukere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brukernavn` varchar(45) NOT NULL,
  `passord` varchar(45) NOT NULL,
  `navn` varchar(80) NOT NULL,
  `epost` varchar(100) DEFAULT NULL,
  `telefon` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `postnummer` int(11) DEFAULT NULL,
  `poststed` varchar(45) DEFAULT NULL,
  `rolle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rolle_id_idx` (`rolle_id`),
  CONSTRAINT `rolle_id_fk` FOREIGN KEY (`rolle_id`) REFERENCES `roller` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spørsmål_tittel` varchar(255) NOT NULL,
  `spørsmål_svar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `handlekurv`
--

DROP TABLE IF EXISTS `handlekurv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `handlekurv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bruker_id` int(11) NOT NULL,
  `oppskrift_id` int(11) NOT NULL,
  `pris_i_handlekurv` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bruker_id_fk_idx` (`bruker_id`),
  KEY `oppskrift_id_fk_idx` (`oppskrift_id`),
  CONSTRAINT `handlekurv_bruker_id_fk` FOREIGN KEY (`bruker_id`) REFERENCES `brukere` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `handlekurv_oppskrift_id_fk` FOREIGN KEY (`oppskrift_id`) REFERENCES `oppskrifter` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ingrediens_mengde`
--

DROP TABLE IF EXISTS `ingrediens_mengde`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingrediens_mengde` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oppskrift_id` int(11) NOT NULL,
  `mengde` int(11) DEFAULT NULL,
  `enhet` varchar(45) DEFAULT NULL,
  `ingrediens_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ingridiens_id_fk_idx` (`ingrediens_id`),
  KEY `oppskrift_id_fk_idx` (`oppskrift_id`),
  CONSTRAINT `ingrediens_id_fk` FOREIGN KEY (`ingrediens_id`) REFERENCES `ingredienser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `oppskrift_id_fk` FOREIGN KEY (`oppskrift_id`) REFERENCES `oppskrifter` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ingredienser`
--

DROP TABLE IF EXISTS `ingredienser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredienser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ingrediens` varchar(60) NOT NULL,
  `vegetar` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `navn` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oppskrift_i_bestilling`
--

DROP TABLE IF EXISTS `oppskrift_i_bestilling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oppskrift_i_bestilling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oppskrift_id` int(11) NOT NULL,
  `pris_i_bestilling` int(11) NOT NULL,
  `bestilling_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oppskrift_i_bestilling_oppskrifter1_idx` (`oppskrift_id`),
  KEY `oib_bestilling_id_fk_idx` (`bestilling_id`),
  CONSTRAINT `oib_bestilling_id_fk` FOREIGN KEY (`bestilling_id`) REFERENCES `bestilling` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `oib_oppskrift_id_fk` FOREIGN KEY (`oppskrift_id`) REFERENCES `oppskrifter` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oppskrifter`
--

DROP TABLE IF EXISTS `oppskrifter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oppskrifter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tittel` varchar(45) NOT NULL,
  `bilde_url` varchar(45) DEFAULT NULL,
  `utgitt_dato` datetime NOT NULL,
  `vanskelighetsgrad` varchar(45) NOT NULL,
  `anbefalt_porsjoner` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `beregnet_tid` varchar(45) NOT NULL,
  `pris` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fremgangsmåte` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oppskrifter_kategori1_idx` (`kategori_id`),
  CONSTRAINT `fk_oppskrifter_kategori1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oppskrift_id` int(11) NOT NULL,
  `bruker_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rating_oppskrifter_idx` (`oppskrift_id`),
  KEY `fk_rating_brukere1_idx` (`bruker_id`),
  CONSTRAINT `fk_rating_brukere1` FOREIGN KEY (`bruker_id`) REFERENCES `brukere` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_rating_oppskrifter` FOREIGN KEY (`oppskrift_id`) REFERENCES `oppskrifter` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roller`
--

DROP TABLE IF EXISTS `roller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolle` enum('kunde','kokk','admin') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `weather_data`
--

DROP TABLE IF EXISTS `weather_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) NOT NULL,
  `temperature` float NOT NULL,
  `humidity` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-20 23:40:41
