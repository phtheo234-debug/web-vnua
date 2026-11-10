/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - blog_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`blog_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `blog_db`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Du lịch','2026-11-06 00:01:21','2026-11-06 00:01:21'),
(2,'Phong cách sống','2026-11-06 00:01:21','2026-11-06 00:01:21'),
(3,'Ẩm thực','2026-11-06 00:01:21','2026-11-06 00:01:21'),
(4,'Cảm hứng','2026-11-06 00:01:21','2026-11-06 00:01:21');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_foreign` (`post_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `comments` */

insert  into `comments`(`id`,`post_id`,`user_id`,`content`,`created_at`,`updated_at`) values 
(2,9,11,'tuyệt vời','2026-11-05 17:59:51','2026-11-05 17:59:51'),
(3,10,11,'yes','2026-11-05 18:04:29','2026-11-05 18:04:29');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2026_11_05_155402_add_slug_to_posts_table',1),
(6,'2026_11_05_164932_add_role_to_users_table',1),
(7,'2026_11_05_165158_create_posts_table',1),
(8,'2026_11_05_165205_create_comments_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `posts` */

insert  into `posts`(`id`,`category`,`tags`,`title`,`slug`,`excerpt`,`author`,`post_date`,`image`,`user_id`,`deleted_at`,`created_at`,`updated_at`) values 
(6,'Ẩm thực',NULL,'Buổi sáng chan hòa cùng ly coffee',NULL,'Âm thanh của Hà Nội tươi mới cùng với ly coffee sánh mịn ngọt ngào tạo nên một cảm giác thư giãn.','Thảo','2026-11-05','20261105172651_6aecbc5b52d1f.jpg',10,'2026-11-08 17:42:17','2026-11-05 17:26:51','2026-11-08 17:42:17'),
(7,'Cảm hứng',NULL,'Ngày bình yên',NULL,'Không phải đi đâu xa để học hỏi kiến thức. Đôi khi xung quanh ta còn nhiều điều tưởng giản dị mà khó có được ở nơi khác','Phương Anh','2026-11-05','20261105172927_6aecbcf7f222d.jpg',10,'2026-11-08 17:42:17','2026-11-05 17:29:27','2026-11-08 17:42:17'),
(8,'Du lịch',NULL,'Một ngày bình yên ở Đà Lạt',NULL,'Đi tới Đà Lạt tưởng chừng đông đúc bộn bề nhưng nhịp sống nơi đây lại diễn ra một cách hài hòa như một bản tình ca ngọt ngào','Duy Nam','2026-11-05','20261105173126_6aecbd6ef2651.jpg',10,'2026-11-08 17:42:17','2026-11-05 17:31:26','2026-11-08 17:42:17'),
(9,'Phong cách sống',NULL,'Sống hết mình, không theo quy chuẩn xã hội',NULL,'Sao phải sống dập khuôn khi cuộc đời của ta chính là của ta! Tự tin, bản lĩnh thì sẽ có cuộc sống tràn đầy niềm vui!','Nhật Ánh','2026-11-06','20261105173425_6aecbe219992b.jpg',10,'2026-11-08 17:42:17','2026-11-05 17:34:25','2026-11-08 17:42:17'),
(10,'Phong cách sống',NULL,'vip',NULL,'abc','Thảo','2026-11-05','20261105180409_6aecc519ecec3.jpg',11,'2026-11-08 17:42:17','2026-11-05 18:04:09','2026-11-08 17:42:17');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'member',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`role`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(10,'Quản Trị Viên','admin@gmail.com','admin',NULL,'$2y$10$QeRwtHHTg8oDv2V4z8noY.AMxRCCOTmfYhyZJf72nGtMltkP1BV2u',NULL,'2026-11-05 17:23:18','2026-11-05 17:23:18'),
(11,'Thảo','123@gmail.com','member',NULL,'$2y$10$3ju29IHGF2N1cKK00b8P2.Ba8eg9Qqd5dg/IY32W0NRfO/wxE8DvW',NULL,'2026-11-05 17:59:27','2026-11-05 17:59:27');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
