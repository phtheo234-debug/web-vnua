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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `author` varchar(100) NOT NULL,
  `post_date` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `posts` */

insert  into `posts`(`id`,`category`,`title`,`excerpt`,`author`,`post_date`,`image`,`created_at`,`updated_at`,`user_id`,`deleted_at`) values 
(1,'Du lịch','Một ngày bình yên ở Đà Lạt','Đôi khi, điều chúng ta cần chỉ là một chuyến đi ngắn, một tách cà phê ấm và chút thời gian dành cho bản thân.','Minh Anh','2026-10-24','images/a1.jpg',NULL,NULL,2,NULL),
(2,'Phong cách sống','Bắt đầu ngày mới với những thói quen nhỏ','Một buổi sáng nhẹ nhàng có thể giúp bạn sắp xếp suy nghĩ và làm việc hiệu quả hơn.','Minh Anh','2026-10-22','images/a2.jpg',NULL,NULL,2,NULL),
(3,'Ẩm thực','Góc cà phê nhỏ cho ngày cuối tuần','Một góc thư giãn để đọc sách, nghe nhạc và tận hưởng ngày không vội vã.','Thu Hà','2026-10-20','images/a3.jpg',NULL,NULL,2,NULL),
(4,'Cảm hứng','Học cách yêu những điều giản dị','Niềm vui đôi khi đến từ những điều rất nhỏ mà ta thường vô tình bỏ qua.','Hoàng Nam','2026-10-18','images/a4.jpg',NULL,NULL,2,NULL),
(5,'âss','âs','ád','Minh','2026-10-25','images/a2.jpg','2026-10-25 04:55:40','2026-10-25 05:07:20',1,'2026-10-25 05:07:20'),
(6,'thaocute','mnb','nb','Minh Anh','2026-10-25','20261027114629_6ae08f155d230.jpg','2026-10-25 05:07:35','2026-10-27 11:46:29',1,NULL),
(7,'ád','adda','àgdf','Minh Anhđàc','2026-10-25','a1.jpg','2026-10-25 07:49:54','2026-10-25 07:49:54',1,NULL),
(8,'mnvhgc','mnvb','mvcg','Minh gfd','2026-10-25','20261025080449_6addb82142d14.jpg','2026-10-25 08:04:49','2026-10-25 08:04:49',1,NULL),
(9,'htdr','khjgy','nhjgyt','thao','2026-10-27','20261027114857_6ae08fa967b40.jpg','2026-10-27 11:48:57','2026-10-27 11:48:57',1,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`created_at`,`updated_at`) values 
(1,'thao','123@gmail.com','$2y$10$dc9HBZeYHMScYrE7.wzKau4Z63sGZsW/mZ2oahox8bSSOMLKX4NqG','2026-10-27 11:46:01','2026-10-27 11:46:01');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
