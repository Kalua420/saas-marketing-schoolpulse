-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: schoolpulse_marketing
-- ------------------------------------------------------
-- Server version	8.0.44
--
-- IMPORTANT: Create database with UTF8MB4 charset
-- CREATE DATABASE IF NOT EXISTS schoolpulse_marketing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE schoolpulse_marketing;

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
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'Super Admin','admin@schoolpulse.in','$2b$12$KWjSVo7LepjiBufTBpobIuOnW.MaP029Kq6L5yLa7NWb30uCdNu8a','superadmin','assets/uploads/profiles/profile_1_1778042774.jpg','2026-05-01 03:45:18');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan` enum('starter','growth','enterprise') COLLATE utf8mb4_unicode_ci DEFAULT 'starter',
  `status` enum('active','inactive','trial','churned') COLLATE utf8mb4_unicode_ci DEFAULT 'trial',
  `onboarded_at` date DEFAULT NULL,
  `renewal_date` date DEFAULT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_clients_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_submissions`
--

DROP TABLE IF EXISTS `contact_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_count` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inquiry_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `newsletter_signup` tinyint(1) DEFAULT '0',
  `status` enum('new','responded','resolved') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_submissions`
--

LOCK TABLES `contact_submissions` WRITE;
/*!40000 ALTER TABLE `contact_submissions` DISABLE KEYS */;
INSERT INTO `contact_submissions` VALUES (1,'John','Doe','john.doe@testschool.com','9876543210','Test High School','500','demo','Interested in learning more about SchoolPulse',1,'new','::1','2026-05-06 04:18:10','2026-05-06 04:18:10');
/*!40000 ALTER TABLE `contact_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo_requests`
--

DROP TABLE IF EXISTS `demo_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `demo_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_count` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` enum('new','contacted','demo_scheduled','converted','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_demo_requests_status` (`status`),
  KEY `idx_demo_requests_created` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_requests`
--

LOCK TABLES `demo_requests` WRITE;
/*!40000 ALTER TABLE `demo_requests` DISABLE KEYS */;
INSERT INTO `demo_requests` VALUES (1,'don bosco school','Alex pandia','alex@alex.com','6002587888','Pune',NULL,'1500','jlsjfdl slfljaljflja ljflajl; fj slfsla fljaljsfljaljlf jal jfj','new',NULL,'2026-05-05 14:08:04','2026-05-05 14:08:04'),(2,'don bosco school','Alex pandia','alex@alex.com','6002587888','Pune',NULL,'1500','jlsjfdl slfljaljflja ljflajl; fj slfsla fljaljsfljaljlf jal jfj','new',NULL,'2026-05-05 14:08:04','2026-05-05 14:08:04'),(3,'abcd','School Pulse','schoolpulse816@gmail.com','6002587888','Pune',NULL,'1500','','new',NULL,'2026-05-05 14:08:44','2026-05-05 14:08:44'),(4,'abcd','School Pulse','schoolpulse816@gmail.com','6002587888','Pune',NULL,'1500','','new',NULL,'2026-05-05 14:08:44','2026-05-05 14:08:44'),(6,'abcd','School Pulse','schoolpulse816@gmail.com','6002587888','Pune',NULL,'3000','','new',NULL,'2026-05-05 14:14:14','2026-05-05 14:14:14'),(7,'abcd','School Pulse','schoolpulse816@gmail.com','6002587888','Pune',NULL,'1500','','new',NULL,'2026-05-05 14:15:20','2026-05-05 14:15:20'),(8,'abcd','School Pulse','schoolpulse816@gmail.com','6002587888','Pune',NULL,'1500','','new',NULL,'2026-05-05 14:17:04','2026-05-05 14:17:04'),(9,'abcd','School Pulse','schoolpulse816@gmail.com','6002587888','Pune',NULL,'1500','','new',NULL,'2026-05-05 14:17:08','2026-05-05 14:17:08'),(10,'Test School','Alex','alex@test.com','1234567890','Pune',NULL,'500','Test message','new',NULL,'2026-05-05 14:18:06','2026-05-05 14:18:06'),(11,'Test School','Alex','alex@test.com','1234567890','Pune',NULL,'500','Test message','new',NULL,'2026-05-05 14:18:44','2026-05-05 14:18:44'),(12,'abcd','School Pulse','schoolpulse816@gmail.com','6002587888','Pune',NULL,'1500','','new',NULL,'2026-05-05 14:19:32','2026-05-05 14:19:32'),(13,'Demo School','Jane Smith','jane@demoschool.com','1234567890','Mumbai',NULL,'1000','Would like to schedule a demo','new',NULL,'2026-05-06 04:17:00','2026-05-06 04:17:00'),(14,'Demo School','Jane Smith','jane@demoschool.com','1234567890','Mumbai',NULL,'1000','Would like to schedule a demo','new',NULL,'2026-05-06 04:18:10','2026-05-06 04:18:10'),(15,'Test Academy','John Smith','john.smith@testacademy.edu','9876543210','Mumbai',NULL,'750','Test demo request','new',NULL,'2026-05-06 05:26:13','2026-05-06 05:26:13'),(16,'Sonababu','Sona','sona@babu.com','6002587888','Mumbai',NULL,'1500','','new',NULL,'2026-05-06 05:26:57','2026-05-06 05:26:57');
/*!40000 ALTER TABLE `demo_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES ('address','India','2026-05-06 04:24:27'),('contact_email','hello@schoolpulse.in','2026-05-06 04:24:27'),('contact_phone','+91 98765 43210','2026-05-06 04:24:27'),('meta_description','SchoolPulse is a modern school management system for attendance, fees, timetable, admissions and more.','2026-05-06 04:24:27'),('site_name','SchoolPulse','2026-05-06 04:24:27'),('site_tagline','The Complete School Management System','2026-05-06 04:24:27'),('whatsapp_number','919876543210','2026-05-06 04:24:27');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-06 11:00:20
