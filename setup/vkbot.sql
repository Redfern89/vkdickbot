-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `api_log`
--

DROP TABLE IF EXISTS `api_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(255) NOT NULL,
  `request_data` longtext,
  `response_data` longtext,
  `status` varchar(255) DEFAULT NULL,
  `date` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `dick_names`
--

DROP TABLE IF EXISTS `dick_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dick_names` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dick_names`
--

LOCK TABLES `dick_names` WRITE;
/*!40000 ALTER TABLE `dick_names` DISABLE KEYS */;
INSERT INTO `dick_names` VALUES (1,'член'),(2,'писюлек'),(3,'Пипин Короткий'),(4,'пожилой Валера'),(5,'змей горыныч'),(6,'Джеки Чан'),(7,'причендал'),(8,'пиструн'),(9,'конь'),(10,'жизненно важный орган'),(11,'удав'),(12,'питон'),(13,'дрын'),(14,'пиструкан'),(15,'одноглазый змей'),(16,'шалун'),(17,'членик'),(18,'стручок'),(19,'отросток'),(20,'магнум'),(21,'пупсик'),(22,'писюн'),(23,'Капитан Крюк'),(24,'малыш'),(25,'пипидастр'),(26,'горец'),(27,'агрегат'),(28,'поршень'),(29,'шланг'),(30,'пипитр'),(31,'коршун'),(32,'энерджайзер'),(33,'петушок'),(34,'писюнчик'),(35,'важнейший орган'),(36,'половой орган'),(37,'головастик'),(38,'дик'),(39,'младший братец'),(40,'огрызок'),(41,'придаток'),(42,'висун'),(43,'детородный орган'),(44,'болт'),(45,'конец'),(46,'хрен'),(47,'кукан'),(48,'нефритовый стержень'),(49,'мудозвон'),(50,'болт'),(51,'конец'),(52,'хрен'),(53,'кукан'),(54,'нефритовый стержень'),(55,'елдак'),(56,'репродуктивный орган'),(57,'трахоштырь'),(58,'ебоштепсель'),(59,'вундерфалус'),(60,'смычок'),(61,'хер'),(62,'шишак'),(63,'пиюлек'),(64,'чижик'),(65,'клитор'),(66,'половой член'),(67,'кончик'),(68,'петун'),(69,'Вадимин стержень'),(70,'пистон'),(71,'пенис'),(72,'фаллос');
/*!40000 ALTER TABLE `dick_names` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `dicks`
--

DROP TABLE IF EXISTS `dicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dicks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `vkid` int unsigned NOT NULL,
  `regdate` int DEFAULT NULL,
  `screen_name` varchar(100) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `first_name_nom` varchar(255) DEFAULT NULL,
  `first_name_gen` varchar(255) DEFAULT NULL,
  `first_name_dat` varchar(255) DEFAULT NULL,
  `first_name_acc` varchar(255) DEFAULT NULL,
  `first_name_ins` varchar(255) DEFAULT NULL,
  `first_name_abl` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `last_name_nom` varchar(100) DEFAULT NULL,
  `last_name_gen` varchar(100) DEFAULT NULL,
  `last_name_dat` varchar(100) DEFAULT NULL,
  `last_name_acc` varchar(100) DEFAULT NULL,
  `last_name_ins` varchar(100) DEFAULT NULL,
  `last_name_abl` varchar(100) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `sex` varchar(1) NOT NULL DEFAULT 'm',
  `icon` int unsigned NOT NULL,
  `peer_id` int NOT NULL,
  `len` int NOT NULL,
  `reserved` int DEFAULT NULL,
  `last_metr` int NOT NULL,
  `metr_available` int DEFAULT NULL,
  `photo_50` varchar(1000) DEFAULT NULL,
  `photo_100` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `photo_200` varchar(1000) DEFAULT NULL,
  `photo_200_orig` varchar(1000) DEFAULT NULL,
  `photo_400_orig` varchar(1000) DEFAULT NULL,
  `photo_max` varchar(1000) DEFAULT NULL,
  `photo_max_orig` varchar(1000) DEFAULT NULL,
  `probabilities` longtext,
  `counter_min` int DEFAULT NULL,
  `counter_max` int DEFAULT NULL,
  `lucky_try` varchar(10) NOT NULL DEFAULT 'false',
  `lucky_val` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vkid` (`vkid`),
  KEY `peer_id` (`peer_id`),
  KEY `icon` (`icon`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `dicks_stats`
--

DROP TABLE IF EXISTS `dicks_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dicks_stats` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `vkid` int unsigned NOT NULL,
  `peer_id` int NOT NULL,
  `len` int NOT NULL,
  `val` int NOT NULL,
  `date` int NOT NULL,
  `act` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peer_id` (`peer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1636 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `globals`
--

DROP TABLE IF EXISTS `globals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `globals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `param` varchar(255) NOT NULL,
  `lparam` varchar(255) DEFAULT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `globals`
--

LOCK TABLES `globals` WRITE;
/*!40000 ALTER TABLE `globals` DISABLE KEYS */;
INSERT INTO `globals` VALUES (1,'dick_len_rnd_min',NULL,'1'),(2,'dick_len_rnd_max',NULL,'20'),(3,'def_dick_len',NULL,'10'),(4,'time_rnd_min',NULL,'1'),(5,'time_rnd_max',NULL,'7200'),(6,'top_count',NULL,'10'),(7,'bonus_dick_len',NULL,'30'),(8,'peer_probe_start',NULL,'1'),(9,'peer_probe_end',NULL,'15'),(10,'cron_work',NULL,'false'),(11,'vkapi_access_token',NULL,''),(12,'vkapi_version',NULL,'5.131'),(13,'vkapi_secret_key',NULL,''),(14,'vkapi_confirmation_token',NULL,'f0568a03'),(15,'admin_id',NULL,''),(16,'start_luck_cnt',NULL,'5'),(17,'stat_graph_cnt',NULL,'40'),(18,'graph_w',NULL,'1250'),(19,'graph_h',NULL,'671'),(20,'graph_bg_start',NULL,'3014929'),(21,'graph_bg_end',NULL,'0'),(22,'graph_frame_color',NULL,'8224125'),(23,'graph_x_lines_cnt',NULL,'30'),(24,'graph_x_labels_cnt',NULL,'10'),(25,'graph_y_lines_cnt',NULL,'10'),(26,'graph_title_font_size',NULL,'60'),(27,'graph_font',NULL,'ARIAL.TTF'),(28,'graph_font_size',NULL,'12'),(29,'graph_text_color',NULL,'16777215'),(30,'graph_line_color',NULL,'16711680'),(31,'bot_cmd',NULL,'!метр'),(32,'photo_top_count',NULL,'5'),(33,'photo_top_font_size',NULL,'12'),(34,'photo_top_size',NULL,'100'),(35,'small_dick_len',NULL,'30'),(36,'stats_graph_font_size',NULL,'17'),(37,'gods_cnt',NULL,'3'),(38,'gods_graph_cnt',NULL,'25'),(39,'bar_chart_bar_width',NULL,'65'),(40,'bar_chart_padding',NULL,'5'),(41,'daily_bonus_rnd_min',NULL,'1'),(42,'daily_bonus_rnd_max',NULL,'25'),(43,'god_dick_len',NULL,'50'),(44,'DEF_PROBABILITY_PERC_inc','inc','78'),(45,'DEF_PROBABILITY_PERC_dec','dec','17'),(46,'DEF_PROBABILITY_PERC_equ','equ','3'),(47,'DEF_PROBABILITY_PERC_die','die','1'),(48,'DEF_PROBABILITY_PERC_bon','bon','1'),(49,'lucky_rnd_min',NULL,'1'),(50,'lucky_rnd_max',NULL,'59'),(51,'inactive_users_seconds',NULL,'864000'),(52,'vkapi_cron_acces_token',NULL,''),(53,'msg_sep',NULL,'----------------------------------'),(54,'bar_chart_limit_cnt',NULL,'13'),(55,'sex_m',NULL,'мужской'),(56,'sex_f',NULL,'женский'),(57,'vkapi_users_fields',NULL,'photo_50,photo_100,photo_200,photo_200_orig,photo_400_orig,photo_max,photo_max_orig,first_name_nom,first_name_gen,first_name_dat,first_name_acc,first_name_ins,first_name_abl,last_name_nom,last_name_gen,last_name_dat,last_name_acc,last_name_ins,last_name_abl,screen_name');
/*!40000 ALTER TABLE `globals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `icons`
--

DROP TABLE IF EXISTS `icons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `icons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1048 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `icons`
--

LOCK TABLES `icons` WRITE;
/*!40000 ALTER TABLE `icons` DISABLE KEYS */;
INSERT INTO `icons` VALUES (1,'😊'),(2,'😃'),(3,'😉'),(4,'😆'),(5,'😜'),(6,'😋'),(7,'😍'),(8,'😎'),(9,'😒'),(10,'😏'),(11,'😔'),(12,'😢'),(13,'😭'),(14,'😩'),(15,'😨'),(16,'😐'),(17,'😌'),(18,'😄'),(19,'😇'),(20,'😰'),(21,'😲'),(22,'😳'),(23,'😷'),(24,'😂'),(25,'❤'),(26,'😚'),(27,'😕'),(28,'😯'),(29,'😦'),(30,'😵'),(31,'😠'),(32,'😡'),(33,'😝'),(34,'😴'),(35,'😘'),(36,'😟'),(37,'😬'),(38,'😶'),(39,'😪'),(40,'😫'),(41,'☺'),(42,'😀'),(43,'😥'),(44,'😛'),(45,'😖'),(46,'😤'),(47,'😣'),(48,'😧'),(49,'😑'),(50,'😅'),(51,'😮'),(52,'😞'),(53,'😙'),(54,'😓'),(55,'😁'),(56,'😱'),(57,'😈'),(58,'👿'),(59,'👽'),(60,'👍'),(61,'👎'),(62,'☝'),(63,'✌'),(64,'👌'),(65,'👏'),(66,'👊'),(67,'✋'),(68,'🙏'),(69,'👃'),(70,'👆'),(71,'👇'),(72,'👈'),(73,'💪'),(74,'👂'),(75,'💋'),(76,'💩'),(77,'❄'),(78,'🍊'),(79,'🍷'),(80,'🍸'),(81,'🎅'),(82,'💦'),(83,'👺'),(84,'🐨'),(85,'🔞'),(86,'👹'),(87,'⚽'),(88,'⛅'),(89,'🌟'),(90,'🍌'),(91,'🍺'),(92,'🍻'),(93,'🌹'),(94,'🍅'),(95,'🍒'),(96,'🎁'),(97,'🎂'),(98,'🎄'),(99,'🏁'),(100,'🏆'),(101,'🐎'),(102,'🐏'),(103,'🐜'),(104,'🐫'),(105,'🐮'),(106,'🐃'),(107,'🐻'),(108,'🐼'),(109,'🐅'),(110,'🐓'),(111,'🐘'),(112,'💔'),(113,'💭'),(114,'🐶'),(115,'🐱'),(116,'🐷'),(117,'🐑'),(118,'⏳'),(119,'⚾'),(120,'⛄'),(121,'☀'),(122,'🌺'),(123,'🌻'),(124,'🌼'),(125,'🌽'),(126,'🍋'),(127,'🍍'),(128,'🍎'),(129,'🍏'),(130,'🍭'),(131,'🌷'),(132,'🌸'),(133,'🍆'),(134,'🍉'),(135,'🍐'),(136,'🍑'),(137,'🍓'),(138,'🍔'),(139,'🍕'),(140,'🍖'),(141,'🍗'),(142,'🍩'),(143,'🎃'),(144,'🎪'),(145,'🎱'),(146,'🎲'),(147,'🎷'),(148,'🎸'),(149,'🎾'),(150,'🏀'),(151,'🏦'),(152,'😸'),(153,'😹'),(154,'😼'),(155,'😽'),(156,'😾'),(157,'😿'),(158,'😻'),(159,'🙀'),(160,'😺'),(161,'⏰'),(162,'☁'),(163,'☎'),(164,'☕'),(165,'♻'),(166,'⚠'),(167,'⚡'),(168,'⛔'),(169,'⛪'),(170,'⛳'),(171,'⛵'),(172,'⛽'),(173,'✂'),(174,'✈'),(175,'✉'),(176,'✊'),(177,'✏'),(178,'✒'),(179,'✨'),(180,'🀄'),(181,'🃏'),(182,'🆘'),(183,'🌂'),(184,'🌍'),(185,'🌛'),(186,'🌝'),(187,'🌞'),(188,'🌰'),(189,'🌱'),(190,'🌲'),(191,'🌳'),(192,'🌴'),(193,'🌵'),(194,'🌾'),(195,'🌿'),(196,'🍀'),(197,'🍁'),(198,'🍂'),(199,'🍃'),(200,'🍄'),(201,'🍇'),(202,'🍈'),(203,'🍚'),(204,'🍛'),(205,'🍜'),(206,'🍝'),(207,'🍞'),(208,'🍟'),(209,'🍠'),(210,'🍡'),(211,'🍢'),(212,'🍣'),(213,'🍤'),(214,'🍥'),(215,'🍦'),(216,'🍧'),(217,'🍨'),(218,'🍪'),(219,'🍫'),(220,'🍬'),(221,'🍮'),(222,'🍯'),(223,'🍰'),(224,'🍱'),(225,'🍲'),(226,'🍳'),(227,'🍴'),(228,'🍵'),(229,'🍶'),(230,'🍹'),(231,'🍼'),(232,'🎀'),(233,'🎈'),(234,'🎉'),(235,'🎊'),(236,'🎋'),(237,'🎌'),(238,'🎍'),(239,'🎎'),(240,'🎏'),(241,'🎐'),(242,'🎒'),(243,'🎓'),(244,'🎣'),(245,'🎤'),(246,'🎧'),(247,'🎨'),(248,'🎩'),(249,'🎫'),(250,'🎬'),(251,'🎭'),(252,'🎯'),(253,'🎰'),(254,'🎳'),(255,'🎴'),(256,'🎹'),(257,'🎺'),(258,'🎻'),(259,'🎽'),(260,'🎿'),(261,'🏂'),(262,'🏃'),(263,'🏄'),(264,'🏇'),(265,'🏈'),(266,'🏉'),(267,'🏊'),(268,'🐀'),(269,'🐁'),(270,'🐂'),(271,'🐄'),(272,'🐆'),(273,'🐇'),(274,'🐈'),(275,'🐉'),(276,'🐊'),(277,'🐋'),(278,'🐌'),(279,'🐍'),(280,'🐐'),(281,'🐒'),(282,'🐔'),(283,'🐕'),(284,'🐖'),(285,'🐗'),(286,'🐙'),(287,'🐚'),(288,'🐛'),(289,'🐝'),(290,'🐞'),(291,'🐟'),(292,'🐠'),(293,'🐡'),(294,'🐢'),(295,'🐣'),(296,'🐤'),(297,'🐥'),(298,'🐦'),(299,'🐧'),(300,'🐩'),(301,'🐪'),(302,'🐬'),(303,'🐭'),(304,'🐯'),(305,'🐰'),(306,'🐲'),(307,'🐳'),(308,'🐴'),(309,'🐵'),(310,'🐸'),(311,'🐹'),(312,'🐺'),(313,'🐽'),(314,'🐾'),(315,'👀'),(316,'👄'),(317,'👅'),(318,'👋'),(319,'👐'),(320,'👑'),(321,'👒'),(322,'👓'),(323,'👔'),(324,'👕'),(325,'👖'),(326,'👗'),(327,'👘'),(328,'👙'),(329,'👚'),(330,'👛'),(331,'👜'),(332,'👝'),(333,'👞'),(334,'👟'),(335,'👠'),(336,'👡'),(337,'👢'),(338,'👣'),(339,'👦'),(340,'👧'),(341,'👨'),(342,'👩'),(343,'👪'),(344,'👫'),(345,'👬'),(346,'👭'),(347,'👮'),(348,'👯'),(349,'👰'),(350,'👱'),(351,'👲'),(352,'👳'),(353,'👴'),(354,'👵'),(355,'👶'),(356,'👷'),(357,'👸'),(358,'👻'),(359,'👼'),(360,'👾'),(361,'💀'),(362,'💁'),(363,'💂'),(364,'💃'),(365,'💄'),(366,'💅'),(367,'💆'),(368,'💇'),(369,'💈'),(370,'💉'),(371,'💊'),(372,'💌'),(373,'💍'),(374,'💎'),(375,'💏'),(376,'💐'),(377,'💑'),(378,'💒'),(379,'💓'),(380,'💕'),(381,'💖'),(382,'💗'),(383,'💘'),(384,'💙'),(385,'💚'),(386,'💛'),(387,'💜'),(388,'💝'),(389,'💞'),(390,'💟'),(391,'💡'),(392,'💣'),(393,'💥'),(394,'💧'),(395,'💨'),(396,'💬'),(397,'💰'),(398,'💳'),(399,'💴'),(400,'💵'),(401,'💶'),(402,'💷'),(403,'💸'),(404,'💺'),(405,'💻'),(406,'💼'),(407,'💽'),(408,'💾'),(409,'💿'),(410,'📄'),(411,'📅'),(412,'📇'),(413,'📈'),(414,'📉'),(415,'📊'),(416,'📋'),(417,'📌'),(418,'📍'),(419,'📎'),(420,'📐'),(421,'📑'),(422,'📒'),(423,'📓'),(424,'📔'),(425,'📕'),(426,'📖'),(427,'📗'),(428,'📘'),(429,'📙'),(430,'📚'),(431,'📜'),(432,'📝'),(433,'📟'),(434,'📠'),(435,'📡'),(436,'📢'),(437,'📦'),(438,'📭'),(439,'📮'),(440,'📯'),(441,'📰'),(442,'📱'),(443,'📷'),(444,'📹'),(445,'📺'),(446,'📻'),(447,'📼'),(448,'🔆'),(449,'🔎'),(450,'🔑'),(451,'🔔'),(452,'🔖'),(453,'🔥'),(454,'🔦'),(455,'🔧'),(456,'🔨'),(457,'🔩'),(458,'🔪'),(459,'🔫'),(460,'🔬'),(461,'🔭'),(462,'🔮'),(463,'🔱'),(464,'🗿'),(465,'🙅'),(466,'🙆'),(467,'🙇'),(468,'🙈'),(469,'🙉'),(470,'🙊'),(471,'🙋'),(472,'🙌'),(473,'🙎'),(474,'🚀'),(475,'🚁'),(476,'🚂'),(477,'🚃'),(478,'🚄'),(479,'🚅'),(480,'🚆'),(481,'🚇'),(482,'🚈'),(483,'🚊'),(484,'🚌'),(485,'🚍'),(486,'🚎'),(487,'🚏'),(488,'🚐'),(489,'🚑'),(490,'🚒'),(491,'🚓'),(492,'🚔'),(493,'🚕'),(494,'🚖'),(495,'🚗'),(496,'🚘'),(497,'🚙'),(498,'🚚'),(499,'🚛'),(500,'🚜'),(501,'🚝'),(502,'🚞'),(503,'🚟'),(504,'🚠'),(505,'🚡'),(506,'🚣'),(507,'🚤'),(508,'🚧'),(509,'🚨'),(510,'🚪'),(511,'🚬'),(512,'🚴'),(513,'🚵'),(514,'🚶'),(515,'🚽'),(516,'🚿'),(517,'🛀'),(518,'🇨🇳'),(519,'🇩🇪'),(520,'🇪🇸'),(521,'🇫🇷'),(522,'🇬🇧'),(523,'🇮🇹'),(524,'🇯🇵'),(525,'🇰🇷'),(526,'🇷🇺'),(527,'🇺🇸'),(528,'🇺🇦'),(529,'🇦🇪'),(530,'🇦🇹'),(531,'🇦🇺'),(532,'🇧🇪'),(533,'🇧🇷'),(534,'🇨🇦'),(535,'🇨🇭'),(536,'🇨🇱'),(537,'🇨🇴'),(538,'🇩🇰'),(539,'🇫🇮'),(540,'🇭🇰'),(541,'🇮🇩'),(542,'🇮🇪'),(543,'🇮🇳'),(544,'🇲🇴'),(545,'🇲🇽'),(546,'🇲🇾'),(547,'🇳🇱'),(548,'🇳🇴'),(549,'🇳🇿'),(550,'🇵🇭'),(551,'🇵🇱'),(552,'🇵🇷'),(553,'🇵🇹'),(554,'🇸🇦'),(555,'🇸🇪'),(556,'🇸🇬'),(557,'🇻🇳'),(558,'🇿🇦'),(559,'🇰🇿'),(560,'🇧🇾'),(561,'🇮🇱'),(562,'🇹🇷'),(563,'‼'),(564,'⁉'),(565,'ℹ'),(566,'↔'),(567,'↕'),(568,'↖'),(569,'↗'),(570,'↘'),(571,'↙'),(572,'↩'),(573,'↪'),(574,'⌚'),(575,'⌛'),(576,'⏩'),(577,'⏪'),(578,'⏫'),(579,'⏬'),(580,'Ⓜ'),(581,'▪'),(582,'▫'),(583,'▶'),(584,'◀'),(585,'◻'),(586,'◼'),(587,'◽'),(588,'◾'),(589,'☑'),(590,'☔'),(591,'♈'),(592,'♉'),(593,'♊'),(594,'♋'),(595,'♌'),(596,'♍'),(597,'♎'),(598,'♏'),(599,'♐'),(600,'♑'),(601,'♒'),(602,'♓'),(603,'♠'),(604,'♣'),(605,'♥'),(606,'♦'),(607,'♨'),(608,'♿'),(609,'⚓'),(610,'⚪'),(611,'⚫'),(612,'⛎'),(613,'⛲'),(614,'⛺'),(615,'✅'),(616,'✔'),(617,'✖'),(618,'✳'),(619,'✴'),(620,'❇'),(621,'❌'),(622,'❎'),(623,'❓'),(624,'❔'),(625,'❕'),(626,'❗'),(627,'➕'),(628,'➖'),(629,'➗'),(630,'➡'),(631,'➰'),(632,'➿'),(633,'⤴'),(634,'⤵'),(635,'⬅'),(636,'⬆'),(637,'⬇'),(638,'⬛'),(639,'⬜'),(640,'⭐'),(641,'⭕'),(642,'〰'),(643,'〽'),(644,'🅰'),(645,'🅱'),(646,'🅾'),(647,'🅿'),(648,'🆎'),(649,'🆑'),(650,'🆒'),(651,'🆓'),(652,'🆔'),(653,'🆕'),(654,'🆖'),(655,'🆗'),(656,'🆙'),(657,'🆚'),(658,'🈁'),(659,'🌀'),(660,'🌁'),(661,'🌃'),(662,'🌄'),(663,'🌅'),(664,'🌆'),(665,'🌇'),(666,'🌈'),(667,'🌉'),(668,'🌊'),(669,'🌋'),(670,'🌌'),(671,'🌎'),(672,'🌏'),(673,'🌐'),(674,'🌑'),(675,'🌒'),(676,'🌓'),(677,'🌔'),(678,'🌕'),(679,'🌖'),(680,'🌗'),(681,'🌘'),(682,'🌙'),(683,'🌚'),(684,'🌜'),(685,'🌠'),(686,'🍘'),(687,'🍙'),(688,'🎆'),(689,'🎇'),(690,'🎑'),(691,'🎠'),(692,'🎡'),(693,'🎢'),(694,'🎥'),(695,'🎦'),(696,'🎮'),(697,'🎵'),(698,'🎶'),(699,'🎼'),(700,'🏠'),(701,'🏡'),(702,'🏢'),(703,'🏣'),(704,'🏤'),(705,'🏥'),(706,'🏧'),(707,'🏨'),(708,'🏩'),(709,'🏪'),(710,'🏫'),(711,'🏬'),(712,'🏭'),(713,'🏮'),(714,'🏯'),(715,'🏰'),(716,'👉'),(717,'👥'),(718,'💠'),(719,'💢'),(720,'💤'),(721,'💫'),(722,'💮'),(723,'💯'),(724,'💱'),(725,'💲'),(726,'💹'),(727,'📀'),(728,'📁'),(729,'📂'),(730,'📃'),(731,'📆'),(732,'📏'),(733,'📛'),(734,'📞'),(735,'📣'),(736,'📤'),(737,'📥'),(738,'📧'),(739,'📨'),(740,'📩'),(741,'📪'),(742,'📫'),(743,'📬'),(744,'📲'),(745,'📳'),(746,'📴'),(747,'📵'),(748,'📶'),(749,'🔀'),(750,'🔁'),(751,'🔂'),(752,'🔃'),(753,'🔄'),(754,'🔅'),(755,'🔇'),(756,'🔈'),(757,'🔉'),(758,'🔊'),(759,'🔋'),(760,'🔌'),(761,'🔍'),(762,'🔏'),(763,'🔐'),(764,'🔒'),(765,'🔓'),(766,'🔕'),(767,'🔗'),(768,'🔘'),(769,'🔙'),(770,'🔚'),(771,'🔛'),(772,'🔜'),(773,'🔝'),(774,'🔟'),(775,'🔠'),(776,'🔡'),(777,'🔢'),(778,'🔣'),(779,'🔤'),(780,'🔯'),(781,'🔲'),(782,'🔳'),(783,'🔴'),(784,'🔵'),(785,'🔶'),(786,'🔷'),(787,'🔸'),(788,'🔹'),(789,'🔺'),(790,'🔻'),(791,'🔼'),(792,'🔽'),(793,'🗻'),(794,'🗼'),(795,'🗽'),(796,'🗾'),(797,'😗'),(798,'🙍'),(799,'🚉'),(800,'🚋'),(801,'🚢'),(802,'🚥'),(803,'🚦'),(804,'🚩'),(805,'🚫'),(806,'🚭'),(807,'🚮'),(808,'🚯'),(809,'🚰'),(810,'🚱'),(811,'🚲'),(812,'🚳'),(813,'🚷'),(814,'🚸'),(815,'🚹'),(816,'🚺'),(817,'🚻'),(818,'🚼'),(819,'🚾'),(820,'🛁'),(821,'🛂'),(822,'🛃'),(823,'🛄'),(824,'🛅'),(825,'⌨'),(826,'⏭'),(827,'⏮'),(828,'⏯'),(829,'⏱'),(830,'⏲'),(831,'⏸'),(832,'⏹'),(833,'⏺'),(834,'☂'),(835,'☃'),(836,'☄'),(837,'☘'),(838,'☠'),(839,'☢'),(840,'☣'),(841,'☦'),(842,'☪'),(843,'☮'),(844,'☯'),(845,'☸'),(846,'☹'),(847,'⚒'),(848,'⚔'),(849,'⚖'),(850,'⚗'),(851,'⚙'),(852,'⚛'),(853,'⚜'),(854,'⚰'),(855,'⚱'),(856,'⛈'),(857,'⛏'),(858,'⛑'),(859,'⛓'),(860,'⛩'),(861,'⛰'),(862,'⛱'),(863,'⛴'),(864,'⛷'),(865,'⛸'),(866,'⛹'),(867,'✍'),(868,'✝'),(869,'✡'),(870,'❣'),(871,'🌡'),(872,'🌤'),(873,'🌥'),(874,'🌦'),(875,'🌧'),(876,'🌨'),(877,'🌩'),(878,'🌪'),(879,'🌫'),(880,'🌬'),(881,'🌭'),(882,'🌮'),(883,'🌯'),(884,'🌶'),(885,'🍽'),(886,'🍾'),(887,'🍿'),(888,'🎖'),(889,'🎗'),(890,'🎙'),(891,'🎚'),(892,'🎛'),(893,'🎞'),(894,'🎟'),(895,'🏅'),(896,'🏋🏌'),(897,'🏍'),(898,'🏎'),(899,'🏏'),(900,'🏐'),(901,'🏑'),(902,'🏒'),(903,'🏓'),(904,'🏔'),(905,'🏕'),(906,'🏖'),(907,'🏗'),(908,'🏘'),(909,'🏙'),(910,'🏚'),(911,'🏛'),(912,'🏜'),(913,'🏝'),(914,'🏞'),(915,'🏟'),(916,'🏳'),(917,'🏴'),(918,'🏵'),(919,'🏷'),(920,'🏸'),(921,'🏹'),(922,'🏺'),(923,'🐿'),(924,'👁'),(925,'📸'),(926,'📽'),(927,'📿'),(928,'🕉'),(929,'🕊'),(930,'🕋'),(931,'🕌'),(932,'🕍'),(933,'🕎'),(934,'🕯'),(935,'🕰'),(936,'🕳'),(937,'🕴'),(938,'🕵'),(939,'🕶'),(940,'🕷'),(941,'🕸'),(942,'🕹'),(943,'🖇'),(944,'🖊'),(945,'🖋'),(946,'🖌'),(947,'🖍'),(948,'🖐'),(949,'🖖'),(950,'🖥'),(951,'🖨'),(952,'🖱'),(953,'🖲'),(954,'🖼'),(955,'🗂'),(956,'🗃'),(957,'🗄'),(958,'🗑'),(959,'🗒'),(960,'🗓'),(961,'🗜'),(962,'🗝'),(963,'🗞'),(964,'🗡'),(965,'🗣'),(966,'🗯'),(967,'🗳'),(968,'🗺'),(969,'🙁'),(970,'🙂'),(971,'🙃'),(972,'🙄'),(973,'🛋'),(974,'🛌'),(975,'🛍'),(976,'🛎'),(977,'🛏'),(978,'🛐'),(979,'🛠'),(980,'🛡'),(981,'🛢'),(982,'🛣'),(983,'🛤'),(984,'🛥'),(985,'🛩'),(986,'🛫'),(987,'🛬'),(988,'🛰'),(989,'🛳'),(990,'🤐'),(991,'🤑'),(992,'🤒'),(993,'🤓'),(994,'🤔'),(995,'🤕'),(996,'🤖'),(997,'🤗'),(998,'🤘'),(999,'🦀'),(1000,'🦁'),(1001,'🦂'),(1002,'🦃'),(1003,'🦄'),(1004,'🧀'),(1005,'🗨'),(1006,'👁‍🗨'),(1007,'㊗'),(1008,'㊙'),(1009,'🈂'),(1010,'🈚'),(1011,'🈯'),(1012,'🈲'),(1013,'🈳'),(1014,'🈴'),(1015,'🈵'),(1016,'🈶'),(1017,'🈷'),(1018,'🈸'),(1019,'🈹'),(1020,'🈺'),(1021,'🉐'),(1022,'🉑'),(1023,'🕐'),(1024,'🕑'),(1025,'🕒'),(1026,'🕓'),(1027,'🕔'),(1028,'🕕'),(1029,'🕖'),(1030,'🕗'),(1031,'🕘'),(1032,'🕙'),(1033,'🕚'),(1034,'🕛'),(1035,'🕜'),(1036,'🕝'),(1037,'🕞'),(1038,'🕟'),(1039,'🕠'),(1040,'🕡'),(1041,'🕢'),(1042,'🕣'),(1043,'🕤'),(1044,'🕥'),(1045,'🕦'),(1046,'🕧'),(1047,'🔰');
/*!40000 ALTER TABLE `icons` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int unsigned NOT NULL,
  `msg_id` int unsigned DEFAULT NULL,
  `peer_id` int unsigned DEFAULT NULL,
  `date` int NOT NULL,
  `text` longtext,
  `object_full` longtext,
  PRIMARY KEY (`id`),
  KEY `msg_id` (`msg_id`),
  KEY `peer_id` (`peer_id`),
  KEY `from_id` (`from_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3293 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `peers`
--

DROP TABLE IF EXISTS `peers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `peer_id` int unsigned NOT NULL,
  `owner_id` int DEFAULT NULL,
  `admin_ids` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `members_count` int DEFAULT NULL,
  `photo_50` varchar(1000) DEFAULT NULL,
  `photo_100` varchar(1000) DEFAULT NULL,
  `photo_200` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peer_id` (`peer_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `small_dick_names`
--

DROP TABLE IF EXISTS `small_dick_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `small_dick_names` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `small_dick_names`
--

LOCK TABLES `small_dick_names` WRITE;
/*!40000 ALTER TABLE `small_dick_names` DISABLE KEYS */;
INSERT INTO `small_dick_names` VALUES (1,'писюлек'),(2,'Пипин Короткий'),(3,'членик'),(4,'стручок'),(5,'отросток'),(6,'пупсик'),(7,'малыш'),(8,'петушок'),(9,'писюнчик'),(10,'клитор'),(11,'чижик'),(12,'кончик');
/*!40000 ALTER TABLE `small_dick_names` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `users_peers`
--

DROP TABLE IF EXISTS `users_peers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_peers` (
  `peer_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  KEY `peer_id` (`peer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: vkbot
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

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
-- Table structure for table `vagina_names`
--

DROP TABLE IF EXISTS `vagina_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vagina_names` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vagina_names`
--

LOCK TABLES `vagina_names` WRITE;
/*!40000 ALTER TABLE `vagina_names` DISABLE KEYS */;
INSERT INTO `vagina_names` VALUES (1,'промежность'),(2,'киска'),(3,'кунька'),(4,'копилка'),(5,'щель'),(6,'расщелина'),(7,'мохнатка'),(8,'кунка'),(9,'лохмушка'),(10,'пуська'),(11,'лоханка'),(12,'ватрушка'),(13,'вагиська'),(14,'дырка'),(15,'колеориза'),(16,'вагина'),(17,'женская промежность'),(18,'сика'),(19,'пися'),(20,'писька'),(21,'писечка'),(22,'манда'),(23,'рыжая нахалка'),(24,'щёлка'),(25,'пилотка'),(26,'кормилица'),(27,'черная дыра'),(28,'лунка'),(29,'чертога траха'),(30,'скважина'),(31,'кожаная дверь'),(32,'пизда'),(33,'кунька глубокая'),(34,'петунья');
/*!40000 ALTER TABLE `vagina_names` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-23 17:02:45
