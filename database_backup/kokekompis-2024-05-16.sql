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
-- Dumping data for table `bestilling`
--

LOCK TABLES `bestilling` WRITE;
/*!40000 ALTER TABLE `bestilling` DISABLE KEYS */;
INSERT INTO `bestilling` VALUES (1,4,'2024-05-15 00:18:41'),(2,4,'2024-05-15 00:23:59'),(3,4,'2024-05-15 00:25:49'),(4,4,'2024-05-15 00:27:04'),(5,4,'2024-05-15 00:28:19'),(6,4,'2024-05-15 00:30:55'),(7,4,'2024-05-15 00:32:09'),(8,4,'2024-05-15 00:34:22'),(9,4,'2024-05-15 00:35:04'),(10,4,'2024-05-15 00:36:05'),(11,4,'2024-05-15 00:37:24'),(12,4,'2024-05-15 00:37:43'),(13,4,'2024-05-15 00:38:51'),(14,4,'2024-05-15 00:39:30'),(15,4,'2024-05-15 00:45:33'),(16,11,'2024-05-15 21:24:58'),(17,11,'2024-05-15 21:29:28'),(18,11,'2024-05-15 21:29:48'),(19,12,'2024-05-15 21:55:30'),(20,12,'2024-05-15 23:29:29');
/*!40000 ALTER TABLE `bestilling` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `brukere`
--

LOCK TABLES `brukere` WRITE;
/*!40000 ALTER TABLE `brukere` DISABLE KEYS */;
INSERT INTO `brukere` VALUES (4,'ulrik','123','ulrik nesheim','ulrik@dethvitehus.org','94199644','Eltonveien 24',586,'Oslo',3),(5,'svein','svein123','svein myhrne','svein@gmail.com','12345678','elton',1234,'oslo',2),(8,'Samoht','1234','Thomas','Thomas@gmail.com','12435687','thomasveien',584,'Oslo',1),(11,'toretore','entore','tore ','tore@gmail.com','22222222','toreveien',2222,'Oslo',1),(12,'thorthor','123','thor','thor@gmail.com','23578983','thorsveien',4533,'Oslo',1);
/*!40000 ALTER TABLE `brukere` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` VALUES (1,'Hvordan logger man inn?','Trykk på logg inn ikonet øverst til høyere for å komme til logg in siden. deretter fyller du in brukernavnet og passordet ditt og trykker på logg inn'),(2,'Hvordan registrer jeg en bruker?','Trykk på ikonet øverst til høyere av en person. Så trykker du på signup og fyller ut infylingsboxene. Til slutt trykker du bare på signup så vil brukeren bli registrert.'),(3,'Hvordan legger man til oppskrifter selv?','For å legge til oppskrifter selv må du først ha tilgang ved å få rolle som kokk. Hvis du har det vil du få opp en legg til oppskrift knapp på oppskrift siden som lar deg legge til oppskrifter.'),(4,'Hvordan kan jeg filtrere oppskrifter?','Det er mulig å filtrere oppskrifter på forsiden ved å trykke på kattegoriene som ligger over oppskriftene på oppskrift siden.'),(5,'Hvordan kan jeg søke etter oppskrifter?','Du kan søke etter oppskrifter ved å skrive in søket dit i søkefeltet øverst til høyere på oppskriftsiden til venstre for handlekurv ikonet.'),(6,'Hvordan kan jeg se det jeg har lagt i handlekurven min?','Hvis du har lyst til å se det du har i handlekurven må du trykke på handlekurv ikonet øverst til høyere på nettsiden imellom log inn ikonet og søkefeltet.'),(13,'Hvordan kommer jeg tilbake til forsiden?','Du kan komme tilbake til forsiden ved å trykke på logoen øverst til venstre på skjermen til høyere for meny ikonet.'),(14,'Hvordan kan jeg endre på oppskrifter?','For å endre på oppskriftene dine må du gå inn på oppskriften som du vile endre. der vil du kunne trykke på endre oppskrift øverst.'),(15,'Hvordan kan jeg slette oppskrifter som kokk?','På oppskrift siden vil du få opp en slette knapp under oppskriftene dine som du kan trykke på for å slette den.'),(16,'Hvordan kan jeg legge til rating på oppskriftene?','For å rate oppskriftene må du gå inn på oppskriften og trykke på hvor mange stjerner du vil gi den nederst.');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `handlekurv`
--

LOCK TABLES `handlekurv` WRITE;
/*!40000 ALTER TABLE `handlekurv` DISABLE KEYS */;
INSERT INTO `handlekurv` VALUES (24,4,1,80);
/*!40000 ALTER TABLE `handlekurv` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingrediens_mengde`
--

LOCK TABLES `ingrediens_mengde` WRITE;
/*!40000 ALTER TABLE `ingrediens_mengde` DISABLE KEYS */;
INSERT INTO `ingrediens_mengde` VALUES (24,5,1,'stk',1),(26,5,1,'stk',2),(27,5,0,'litt',3),(33,10,400,'gram',13),(34,10,1,'pakke',14),(35,10,3,'dl',15),(36,10,1,'ts',16),(37,10,2,'dl',17);
/*!40000 ALTER TABLE `ingrediens_mengde` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredienser`
--

LOCK TABLES `ingredienser` WRITE;
/*!40000 ALTER TABLE `ingredienser` DISABLE KEYS */;
INSERT INTO `ingredienser` VALUES (1,'pølse',0),(2,'pølsebrød',1),(3,'sennep',1),(4,'ketchup',1),(5,'sprøstektløk',1),(6,'kokain',NULL),(7,'stein',NULL),(8,'sprøstekt løk',NULL),(9,'egg',NULL),(10,'poteter',NULL),(11,'ekkelt',NULL),(12,'',NULL),(13,'hvetemel',NULL),(14,'tørr gjær',NULL),(15,'melk',NULL),(16,'kardemomme',NULL),(17,'sukker',NULL),(18,'tomat',NULL);
/*!40000 ALTER TABLE `ingredienser` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Frokost'),(2,'Lønsj'),(3,'Middag'),(4,'Kveldsmat'),(5,'Snack'),(6,'Dessert');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `oppskrift_i_bestilling`
--

LOCK TABLES `oppskrift_i_bestilling` WRITE;
/*!40000 ALTER TABLE `oppskrift_i_bestilling` DISABLE KEYS */;
INSERT INTO `oppskrift_i_bestilling` VALUES (1,5,30,2),(2,5,30,2),(3,5,30,2),(4,5,40,2),(5,5,40,3),(6,4,55,3),(7,6,10,3),(8,5,40,5),(9,4,55,6),(10,16,150,6),(11,5,40,9),(12,7,100,9),(13,5,40,9),(14,5,40,9),(15,5,40,10),(16,7,100,10),(17,5,40,10),(18,5,40,10),(19,5,40,11),(20,7,100,11),(21,5,40,11),(22,5,40,11),(23,5,40,12),(24,16,150,12),(25,4,55,12),(26,5,40,13),(27,16,150,14),(28,16,150,14),(29,16,150,14),(30,5,40,15),(31,5,30,15),(32,5,35,16),(33,4,55,17),(34,5,35,18),(35,5,35,19),(36,4,55,20);
/*!40000 ALTER TABLE `oppskrift_i_bestilling` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oppskrifter`
--

LOCK TABLES `oppskrifter` WRITE;
/*!40000 ALTER TABLE `oppskrifter` DISABLE KEYS */;
INSERT INTO `oppskrifter` VALUES (1,'Pizza','pizza.png','2024-05-15 09:14:24','lett',69,3,'20 min',80.00,'<a href=\"http://10.200.1.169\">Klikk her</a>'),(4,'Lasange','lasange.png','0000-00-00 00:00:00','middels',1,3,'30-40 min',55.00,NULL),(5,'Pølse','polse.png','2024-05-15 00:45:21','lett',4,3,'10 min',35.00,'kok pølsa i vann. Åpne pølsebrødet, legg inn pølsa og ta på sennep'),(6,'Bønner','beans.png','0000-00-00 00:00:00','middels',4,1,'30-40 min',10.00,NULL),(7,'Burger','burger.png','2024-05-13 21:39:42','middels',3,3,'18 min',100.00,'stek den og plaser greiene oppå hverandre'),(9,'Sushi','sushi.png','0000-00-00 00:00:00','hard',8,3,'40-60 min',200.00,NULL),(10,'boller','boller.png','2024-05-13 00:55:40','middels',6,5,'120',55.00,'lag dem'),(14,'Frokost blanding','frokostblanding.png','2024-05-13 11:42:30','lett',1,1,'5',33.00,'hell frokostblandingen i en skål, hell oppi melken og ta på litt blåbær'),(15,'Eggerøre salat ','eggerøre_salat.png','2024-05-13 11:48:50','middels',1,2,'15',44.00,'lag egfgerøre, kutt op grønsaker og dander talerknen. spis maten \r\n'),(16,'Sjokoladefondant','sjokoladefondant.png','2024-05-13 11:55:08','vannsklig',4,6,'40',150.00,'bland sammen greier. pu det i ovnen i 8 min. ta den ut og se om den er ferdig. dander med melis og jordbær og forsyn deg ');
/*!40000 ALTER TABLE `oppskrifter` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
INSERT INTO `rating` VALUES (18,7,5,5),(51,1,5,5),(55,6,5,1),(56,9,5,5),(72,4,5,5),(74,5,5,3),(91,5,4,5),(100,1,4,5),(102,16,8,3),(103,4,4,3),(104,15,4,2),(111,5,11,3),(112,5,12,5);
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `roller`
--

LOCK TABLES `roller` WRITE;
/*!40000 ALTER TABLE `roller` DISABLE KEYS */;
INSERT INTO `roller` VALUES (1,'kunde'),(2,'kokk'),(3,'admin');
/*!40000 ALTER TABLE `roller` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `weather_data`
--

LOCK TABLES `weather_data` WRITE;
/*!40000 ALTER TABLE `weather_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `weather_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-16  0:50:30
