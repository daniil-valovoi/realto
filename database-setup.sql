/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.3-MariaDB, for Linux (x86_64)
--
-- ------------------------------------------------------
-- Server version	11.8.3-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `districts` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(255) NOT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `districts` VALUES
(1,'Coconut Grove'),
(2,'Coral Gables'),
(3,'Wynwood'),
(4,'Pinecrest'),
(5,'Brickell'),
(6,'Kendall'),
(7,'Westchester'),
(8,'Miami Shores'),
(9,'Little Havana'),
(10,'Key Biscayne');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
commit;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`favorite_id`),
  KEY `fk_listing_id_favorites` (`listing_id`),
  KEY `fk_user_id_favorites` (`user_id`),
  CONSTRAINT `fk_listing_id_favorites` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id_favorites` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
commit;

--
-- Table structure for table `for_rent`
--

DROP TABLE IF EXISTS `for_rent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `for_rent` (
  `listing_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_friendly` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `security_deposit` int(11) NOT NULL,
  `minimal_rent_time` int(11) NOT NULL,
  `date_listed` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`listing_id`),
  KEY `fk_property_id_for_rent` (`property_id`),
  KEY `status_id_for_rent` (`status_id`),
  KEY `fk_user_id_for_rent` (`user_id`),
  CONSTRAINT `fk_listing_id_for_rent` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_property_id_for_rent` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id_for_rent` FOREIGN KEY (`user_id`) REFERENCES `properties` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `status_id_for_rent` FOREIGN KEY (`status_id`) REFERENCES `property_statuses` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_rent`
--

/*!40000 ALTER TABLE `for_rent` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `for_rent` ENABLE KEYS */;
commit;

--
-- Table structure for table `for_sale`
--

DROP TABLE IF EXISTS `for_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `for_sale` (
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_listed` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  PRIMARY KEY (`listing_id`),
  KEY `fk_property_id_for_sale` (`property_id`),
  KEY `fk_status_id_for_sale` (`status_id`),
  KEY `fk_user_id_for_sale` (`user_id`),
  CONSTRAINT `fk_listing_id_for_sale` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_property_id_for_sale` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_status_id_for_sale` FOREIGN KEY (`status_id`) REFERENCES `property_statuses` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id_for_sale` FOREIGN KEY (`user_id`) REFERENCES `properties` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `for_sale`
--

/*!40000 ALTER TABLE `for_sale` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `for_sale` ENABLE KEYS */;
commit;

--
-- Table structure for table `listings`
--

DROP TABLE IF EXISTS `listings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `listings` (
  `listing_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `date_listed` timestamp NOT NULL DEFAULT current_timestamp(),
  `offer_type_id` int(11) NOT NULL,
  PRIMARY KEY (`listing_id`),
  KEY `fk_property_id_listings` (`property_id`),
  CONSTRAINT `fk_property_id_listings` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listings`
--

/*!40000 ALTER TABLE `listings` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `listings` ENABLE KEYS */;
commit;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `content` varchar(2500) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`message_id`),
  KEY `fk_sender_id_messages` (`sender_id`),
  KEY `fk_recipient_id_messages` (`recipient_id`),
  KEY `fk_property_id_messages` (`property_id`),
  KEY `fk_image_id_messages` (`image_id`),
  CONSTRAINT `fk_image_id_messages` FOREIGN KEY (`image_id`) REFERENCES `user_images` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_property_id_messages` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_recipient_id_messages` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sender_id_messages` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
commit;

--
-- Table structure for table `offer_types`
--

DROP TABLE IF EXISTS `offer_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer_types` (
  `offer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_type_name` varchar(30) NOT NULL,
  PRIMARY KEY (`offer_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_types`
--

/*!40000 ALTER TABLE `offer_types` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `offer_types` VALUES
(1,'for rent'),
(2,'for sale');
/*!40000 ALTER TABLE `offer_types` ENABLE KEYS */;
commit;

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(75) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `zip` int(5) NOT NULL,
  `district_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `footage` int(11) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `floor` int(11) DEFAULT NULL,
  `building_floors` int(11) DEFAULT NULL,
  `lot_size` int(11) DEFAULT NULL,
  `parking_spots` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `main_image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`property_id`),
  KEY `fk_user_id_properties` (`user_id`),
  KEY `fk_type_id_properties` (`type_id`),
  KEY `fk_status_id_properties` (`status_id`),
  KEY `fk_district_id_properties` (`district_id`),
  KEY `fk_main_image_id_properties` (`main_image_id`),
  CONSTRAINT `fk_district_id` FOREIGN KEY (`district_id`) REFERENCES `districts` (`district_id`),
  CONSTRAINT `fk_district_id_properties` FOREIGN KEY (`district_id`) REFERENCES `districts` (`district_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_main_image_id_properties` FOREIGN KEY (`main_image_id`) REFERENCES `property_images` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_status_id_properties` FOREIGN KEY (`status_id`) REFERENCES `property_statuses` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_type_id_properties` FOREIGN KEY (`type_id`) REFERENCES `property_types` (`type_id`),
  CONSTRAINT `fk_user_id_properties` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `properties`
--

/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;
commit;

--
-- Table structure for table `property_images`
--

DROP TABLE IF EXISTS `property_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `property_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`image_id`),
  KEY `fk_user_id_property_images` (`user_id`) USING BTREE,
  KEY `fk_property_id_property_images` (`property_id`) USING BTREE,
  CONSTRAINT `fk_property_id_properties_images` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id_properties_images` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_images`
--

/*!40000 ALTER TABLE `property_images` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `property_images` ENABLE KEYS */;
commit;

--
-- Table structure for table `property_statuses`
--

DROP TABLE IF EXISTS `property_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `property_statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_statuses`
--

/*!40000 ALTER TABLE `property_statuses` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `property_statuses` VALUES
(1,'active'),
(2,'inactive'),
(3,'rented'),
(4,'sold');
/*!40000 ALTER TABLE `property_statuses` ENABLE KEYS */;
commit;

--
-- Table structure for table `property_types`
--

DROP TABLE IF EXISTS `property_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `property_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_types`
--

/*!40000 ALTER TABLE `property_types` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `property_types` VALUES
(1,'house'),
(2,'apartment');
/*!40000 ALTER TABLE `property_types` ENABLE KEYS */;
commit;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `roles` VALUES
(1,'user'),
(2,'admin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
commit;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `content` varchar(2500) NOT NULL,
  `image_id` int(255) DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp(),
  `listing_id` int(11) NOT NULL,
  PRIMARY KEY (`ticket_id`),
  KEY `fk_sender_id_support_tickets` (`sender_id`),
  KEY `fk_image_id_support_tickets` (`image_id`),
  KEY `fk_listing_id_support_tickets` (`listing_id`),
  CONSTRAINT `fk_image_id_support_tickets` FOREIGN KEY (`image_id`) REFERENCES `user_images` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_listing_id_support_tickets` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sender_id_support_tickets` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_tickets`
--

/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;
commit;

--
-- Table structure for table `user_images`
--

DROP TABLE IF EXISTS `user_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`image_id`),
  KEY `fk_user_id_user_images` (`user_id`) USING BTREE,
  CONSTRAINT `fk_user_id_users_images` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_images`
--

/*!40000 ALTER TABLE `user_images` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `user_images` ENABLE KEYS */;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'default.png',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
commit;

--
-- Dumping routines for database ''
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-12-22 12:57:41
