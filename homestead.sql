-- MySQL dump 10.13  Distrib 5.7.12, for Linux (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.12

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
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_07_14_141054_create_websites_table',1),('2016_07_18_103804_create_configs_table',1),('2016_07_20_134811_create_website_users_table',1),('2016_07_24_112027_create_user_sent_messages_table',2),('2016_07_25_010122_create_notes_table',2),('2016_07_26_115850_create_user_managed_websites_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` int(10) unsigned NOT NULL,
  `conversation_id` int(10) unsigned NOT NULL,
  `type` enum('interlocutor','initiator') COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_managed_websites`
--

DROP TABLE IF EXISTS `user_managed_websites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_managed_websites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `website_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_managed_websites_user_id_foreign` (`user_id`),
  KEY `user_managed_websites_website_id_foreign` (`website_id`),
  CONSTRAINT `user_managed_websites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_managed_websites_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_managed_websites`
--

LOCK TABLES `user_managed_websites` WRITE;
/*!40000 ALTER TABLE `user_managed_websites` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_managed_websites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_sent_messages`
--

DROP TABLE IF EXISTS `user_sent_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_sent_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `website_id` int(10) unsigned NOT NULL,
  `message_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_sent_messages_user_id_foreign` (`user_id`),
  KEY `user_sent_messages_website_id_foreign` (`website_id`),
  CONSTRAINT `user_sent_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_sent_messages_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_sent_messages`
--

LOCK TABLES `user_sent_messages` WRITE;
/*!40000 ALTER TABLE `user_sent_messages` DISABLE KEYS */;
INSERT INTO `user_sent_messages` VALUES (3,1,2,704,'2016-07-25 06:38:45','2016-07-25 06:38:45'),(4,1,2,705,'2016-07-25 07:06:39','2016-07-25 07:06:39'),(5,1,2,706,'2016-07-25 07:09:36','2016-07-25 07:09:36'),(6,1,2,707,'2016-07-25 07:09:54','2016-07-25 07:09:54'),(7,1,2,708,'2016-07-25 07:10:26','2016-07-25 07:10:26'),(8,1,2,709,'2016-07-25 07:11:32','2016-07-25 07:11:32'),(9,1,2,715,'2016-07-25 09:57:46','2016-07-25 09:57:46'),(10,1,2,716,'2016-07-25 09:57:57','2016-07-25 09:57:57'),(11,1,2,717,'2016-07-25 12:39:11','2016-07-25 12:39:11'),(12,1,2,718,'2016-07-25 13:48:15','2016-07-25 13:48:15'),(13,1,2,719,'2016-07-25 13:48:50','2016-07-25 13:48:50'),(14,1,2,720,'2016-07-25 13:49:53','2016-07-25 13:49:53'),(15,1,2,721,'2016-07-25 13:50:42','2016-07-25 13:50:42'),(16,1,2,732,'2016-07-25 14:26:03','2016-07-25 14:26:03'),(17,1,2,733,'2016-07-25 23:30:29','2016-07-25 23:30:29'),(18,1,2,734,'2016-07-25 23:30:42','2016-07-25 23:30:42');
/*!40000 ALTER TABLE `user_sent_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_info` text COLLATE utf8_unicode_ci,
  `photo` longtext COLLATE utf8_unicode_ci,
  `type` enum('user','admin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@admin.com','$2y$10$GcpXSzHVX9x1VvA.WhENLu963K4M/YK3uXIbYRvIDfkriC3dm9j4G',NULL,NULL,'admin','8kKw4kIaL56FWbnAzTUVWpIbppTUHTgsiSeS8ivxZ1E1kfop2CPOiYGMQHKo','2016-07-21 11:23:10','2016-07-23 03:59:51'),(2,'Rosemale','rosemalejohn@gmail.com','$2y$10$/gOQuY45AvJVDWecAa2Sf.FyZSQDh09zbWL8z9JllCr0l6x8nLSZy','Simple man.',NULL,'user','geOuQ67UmUht9oPpR6bhmolDl2TCMFW4eO0WnicKfyuaIWSOnINf9T7921qd','2016-07-26 12:01:30','2016-07-26 12:39:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website_users`
--

DROP TABLE IF EXISTS `website_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `website_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `fake_message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `website_users_website_id_userid_unique` (`website_id`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_users`
--

LOCK TABLES `website_users` WRITE;
/*!40000 ALTER TABLE `website_users` DISABLE KEYS */;
INSERT INTO `website_users` VALUES (9,1,1,'Hello this is Christer.','2016-07-22 05:39:52','2016-07-22 05:40:07'),(10,1,40,'','2016-07-22 07:21:56','2016-07-22 07:21:56'),(16,1,28,'','2016-07-23 03:42:26','2016-07-23 03:42:26'),(17,2,583,'','2016-07-24 16:14:35','2016-07-24 16:14:35'),(18,2,567,'','2016-07-24 16:14:54','2016-07-24 16:14:54'),(19,2,456,'This is a fake message.','2016-07-24 16:15:10','2016-07-25 05:22:25'),(20,3,4868,'','2016-07-24 16:15:35','2016-07-24 16:15:35'),(21,3,4841,'','2016-07-24 16:15:48','2016-07-24 16:15:48'),(22,3,4840,'','2016-07-24 16:16:00','2016-07-24 16:16:00'),(23,3,4652,'','2016-07-24 16:16:11','2016-07-24 16:16:11'),(25,1,3,'Hi this is Bella.','2016-07-25 03:38:45','2016-07-25 03:38:45');
/*!40000 ALTER TABLE `website_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websites`
--

DROP TABLE IF EXISTS `websites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `websites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` longtext COLLATE utf8_unicode_ci,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `database` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websites`
--

LOCK TABLES `websites` WRITE;
/*!40000 ALTER TABLE `websites` DISABLE KEYS */;
INSERT INTO `websites` VALUES (1,'Scorfinder',NULL,'http://scorfinder.com','192.168.56.1','scorfinder','rosemalejohn','rosemalejohn',NULL,'ow_','2016-07-21 11:32:00','2016-07-21 11:32:53'),(2,'sextreff4u',NULL,'http://sextreff4u.com','192.168.56.1','sextreff4u','rosemalejohn','rosemalejohn',NULL,'ow_','2016-07-22 12:11:07','2016-07-22 12:11:07'),(3,'sexdatin_lite4',NULL,'http://adultdate4u.com/','192.168.56.1','sexdatin_lite4','rosemalejohn','rosemalejohn',NULL,'ow_','2016-07-23 02:52:45','2016-07-23 03:56:33');
/*!40000 ALTER TABLE `websites` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-26 12:41:45
