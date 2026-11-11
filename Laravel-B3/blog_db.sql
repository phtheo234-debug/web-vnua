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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `comments` */

insert  into `comments`(`id`,`post_id`,`user_id`,`content`,`created_at`,`updated_at`) values 
(2,9,1,'yep','2026-11-11 00:49:31','2026-11-11 00:49:31'),
(3,9,1,'yes','2026-11-11 01:04:20','2026-11-11 01:04:20'),
(5,7,10,'Good!','2026-11-11 01:21:26','2026-11-11 01:21:26'),
(6,6,10,'tuyệt vời!','2026-11-11 01:22:17','2026-11-11 01:22:17'),
(7,14,11,'Ngon quá!','2026-11-11 01:31:14','2026-11-11 01:31:14'),
(8,11,11,'Idol','2026-11-11 01:31:37','2026-11-11 01:31:37'),
(9,9,11,'tuyệt vời quá','2026-11-11 01:32:04','2026-11-11 01:32:04'),
(10,7,11,'CHẤT','2026-11-11 01:33:28','2026-11-11 01:33:28'),
(12,12,11,'ĐƯỢC ĐẤY!!!','2026-11-11 01:34:14','2026-11-11 01:34:14'),
(13,12,11,'hay','2026-11-11 01:34:22','2026-11-11 01:34:22');

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

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

insert  into `jobs`(`id`,`queue`,`payload`,`attempts`,`reserved_at`,`available_at`,`created_at`) values 
(1,'default','{\"uuid\":\"669db528-f4cd-46bc-8dec-23bdc1fc9289\",\"displayName\":\"App\\\\Mail\\\\CommentNotificationMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\CommentNotificationMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}',0,NULL,1794334886,1794334886),
(2,'default','{\"uuid\":\"b138916c-8d4c-4fe8-a3fa-10c4c3ce1b5b\",\"displayName\":\"App\\\\Mail\\\\CommentNotificationMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\CommentNotificationMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}',0,NULL,1794334937,1794334937),
(3,'default','{\"uuid\":\"b1c77db6-3dab-49dc-a326-861d4007d3f3\",\"displayName\":\"App\\\\Mail\\\\CommentNotificationMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\CommentNotificationMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"234@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}',0,NULL,1794335497,1794335497),
(4,'default','{\"uuid\":\"aef1cfd8-4cee-4368-bf5e-7361c762e86d\",\"displayName\":\"App\\\\Mail\\\\CommentNotificationMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\CommentNotificationMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}',0,NULL,1794335524,1794335524),
(5,'default','{\"uuid\":\"76545d5b-8cdf-4d85-8ba1-2491ab6983e5\",\"displayName\":\"App\\\\Mail\\\\CommentNotificationMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\CommentNotificationMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}',0,NULL,1794335608,1794335608),
(6,'default','{\"uuid\":\"e12ab9f8-361e-4566-8bb7-f561f13eedda\",\"displayName\":\"App\\\\Mail\\\\CommentNotificationMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\CommentNotificationMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"234@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}',0,NULL,1794335654,1794335654),
(7,'default','{\"uuid\":\"838739d1-69b2-43fd-8c0f-c0387620db91\",\"displayName\":\"App\\\\Mail\\\\CommentNotificationMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:32:\\\"App\\\\Mail\\\\CommentNotificationMail\\\":3:{s:7:\\\"comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"234@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:3:\\\"job\\\";N;}\"}}',0,NULL,1794335662,1794335662);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2026_11_05_155402_add_slug_to_posts_table',1),
(6,'2026_11_05_164932_add_role_to_users_table',1),
(7,'2026_11_05_165158_create_posts_table',1),
(8,'2026_11_05_165205_create_comments_table',1),
(9,'2026_11_11_011605_create_jobs_table',2);

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
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','scheduled') NOT NULL DEFAULT 'published',
  `author` varchar(255) NOT NULL,
  `post_date` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `posts` */

insert  into `posts`(`id`,`user_id`,`category`,`title`,`slug`,`excerpt`,`tags`,`status`,`author`,`post_date`,`image`,`deleted_at`,`created_at`,`updated_at`) values 
(6,1,'Du lịch','Chuyến du lịch Đà Nẵng','chuyen-du-lich-da-nang-1794332311','Một chuyến du lịch bổ ích tại Đà Nẵng - vùng đất đầy tươi mới và hấp dẫn với điểm đến là cầu Rồng uy nga tráng lệ nơi phồn hoa tấp nập.','DULICH, Dulich, dulich, DANANG, Danang, DaNang','published','Thảo','2026-11-11 00:38:31','20261111003831_6af356970ed55.jpg',NULL,'2026-11-11 00:38:31','2026-11-11 00:38:31'),
(7,1,'Phong cách sống','Sống hết mình','song-het-minh-1794332500','Cứ sống hết mình với đam mê cháy bỏng đi! Những quy tắc sống của cuộc đời đã vốn không hề tồn tại, đừng gò bó bản thân mà cứ tiếp tục bước tới những điều bạn muốn làm nhé!','PHONGCACHSONG, Phongcachsong, phongcachsong, pcs','published','Phương Thảo','2026-11-11 00:41:40','20261111004140_6af35754f1552.jpg',NULL,'2026-11-11 00:41:41','2026-11-11 00:41:41'),
(8,1,'Ẩm thực','Cà phê sáng tại Hà Nội','ca-phe-sang-tai-ha-noi-1794332702','Một buổi sáng trong lành bên khí trời ấm áp của mùa thu Hà Nội...Thưởng thức hương vị cà phê đậm đà bản sắc ta mới thấy cuộc sống này thật đáng sống!','AMTHUC, Amthuc, amthuc, caphe, CAPHE, Caphe, Coffee, coffee, COFFEE','published','Tạ Phương Thảo','2026-11-11 00:45:02','20261111004502_6af3581e96318.jpg',NULL,'2026-11-11 00:45:02','2026-11-11 00:45:02'),
(9,1,'Cảm hứng','Cuộc sống quanh ta','cuoc-song-quanh-ta-1794332903','Đôi khi ta cần chậm lại để ngắm nhìn cảnh vật hiện hữu quanh chúng ta. Một cảnh đẹp yên bình mà quá đỗi quen thuộc chính là niềm cảm hứng bất tận cho việc sáng tạo nghệ thuật đặc trưng của chính mình.','CAMHUNG, Camhung, camhung','published','Thao','2026-11-11 00:48:23','20261111004823_6af358e7cd8ec.jpg',NULL,'2026-11-11 00:48:23','2026-11-11 00:48:23'),
(11,10,'Du lịch','Du Lịch Hàn Quốc','du-lich-han-quoc-1794334209','Khám phá một Seoul sôi động nhưng không kém phần cổ kính, Nami lãng mạn với hàng cây ngân hạnh, Jeju thơ mộng với những cánh đồng hoa trải dài ngút ngàn…chắc chắn sẽ mang đến cho bạn những trải nghiệm tuyệt vời, và không thề nào quên.','DULICH, dulich, HANQUOC, Korea, hanquoc, KOREA','published','Duy Nam','2026-11-11 01:10:09','20261111011009_6af35e01ea88f.jpg',NULL,'2026-11-11 01:10:09','2026-11-11 01:10:09'),
(12,10,'Phong cách sống','Lối sống tối giản','loi-song-toi-gian-1794334348','Toàn bộ trang phục của Sasaki gói gọn trong khoảng hơn 10 món đồ bao gồm áo sơ mi, quần jean, chiếc jogger thật thoải mái, vài chiếc áo khoác cho các loại thời tiết khác nhau. Sự đơn giản đôi khi khiến người ta được trở thành chính là mình và cũng không phải băn khoăn về phục sức.','pcs, phongcachsong, PHONGCACHSONG, songtoigian, SONGTOIGIAN','published','CR7','2026-11-11 01:12:28','20261111011228_6af35e8c77f66.jpg',NULL,'2026-11-11 01:12:28','2026-11-11 01:12:28'),
(14,11,'Ẩm thực','Phở - nét tinh túy của ẩm thực Hà Nội','pho-net-tinh-tuy-cua-am-thuc-ha-noi-1794335265','Phở không chỉ là món ăn sáng quen thuộc của người Việt mà còn là biểu tượng của ẩm thực Hà Nội được phục vụ cả ngày tại nhiều quán ăn lớn nhỏ. Điểm đặc trưng làm nên hương vị khó quên của phở Hà Nội nằm ở phần nước dùng được ninh từ xương bò trong nhiều giờ, hòa quyện cùng hương thơm dịu nhẹ của quế và hồi. Tô phở đầy đủ bao gồm bánh phở mềm, thịt bò thái mỏng, hành lá và các loại rau thơm rắc đều phía trên. Vị ngọt thanh của nước, vị béo nhẹ từ thịt cùng mùi thơm của rau gia vị khiến thực khách chỉ cần thử một lần cũng đủ cảm nhận được sự tinh tế trong món ăn trứ danh này.','AMTHUC, amthuc, Amthuc, PHO, pho, HANOI, hanoi','published','Phương Anh','2026-11-11 01:27:45','20261111012745_6af36221de653.jpeg',NULL,'2026-11-11 01:27:45','2026-11-11 01:27:45'),
(15,11,'Cảm hứng','Truyền cảm hứng','truyen-cam-hung-1794335371','Hiệu quả công việc không chỉ đến từ sức mạnh chuyên môn mà còn phụ thuộc phần lớn còn sức mạnh tinh thần. Và một trong những yếu tố mang đến sức mạnh tinh thần này chính là khả năng truyền cảm hứng từ người lãnh đạo.','CAMHUNG, camhung, truyencamhung','published','Nhật Ánh','2026-11-11 01:29:31','20261111012931_6af3628b23604.jpg',NULL,'2026-11-11 01:29:31','2026-11-11 01:29:31');

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
(1,'Admin Thảo','123@gmail.com','admin',NULL,'$2y$10$dc9HBZeYHMScYrE7.wzKau4Z63sGZsW/mZ2oahox8bSSOMLKX4NqG',NULL,'2026-11-11 00:31:58','2026-11-11 00:31:58'),
(10,'CR7','234@gmail.com','member',NULL,'$2y$10$MMICnjp/AUtoXtjwN1V6eeKBWn7YqZOVq8peins1ez4ui7DWMKyd6',NULL,'2026-11-11 01:06:52','2026-11-11 01:06:52'),
(11,'M10','345@gmail.com','member',NULL,'$2y$10$9DUT21/TIS8TF0qj8easkOSvXaJyypcRQl4YwIp/k1/Npr4K0G1IG',NULL,'2026-11-11 01:24:16','2026-11-11 01:24:16');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
