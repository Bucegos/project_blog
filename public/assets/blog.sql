-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.31-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for blog
CREATE DATABASE IF NOT EXISTS `blog` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `blog`;

-- Dumping structure for table blog.article
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `cover` text COLLATE utf8mb4_unicode_ci,
  `status` enum('created','draft','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'created',
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_user_fk1` (`author_id`),
  CONSTRAINT `article_user_fk1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table blog.article: ~16 rows (approximately)
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` (`id`, `author_id`, `title`, `content`, `cover`, `status`, `created_at`, `modified_at`, `slug`) VALUES
	(1, 9, 'THIS IS DZA FIRST BIG TEST WITH POSTS', 'just some content', '', 'approved', '2020-07-19 19:35:22', NULL, ''),
	(2, 9, 'apiosjfposajfsaopjfp', 'pojasfpojaspofjaspojf', '', 'approved', '2020-07-19 19:40:53', NULL, ''),
	(3, 9, 'REAL TEST', 'jsut some content', '', 'created', '2020-07-19 19:43:22', NULL, ''),
	(4, 9, 'testing ??? this awe$ome 6702 &ilte()#23 !!@asifas^', 'asfasfasfasfasfasfasfasf', '', 'created', '2020-07-19 21:07:47', NULL, 'testing-this-awe-ome-6702-ilte-23-asifas'),
	(5, 9, 'asfasfasfasf', 'asfasfasfasf', '', 'created', '2020-07-19 21:09:35', NULL, 'asfasfasfasf'),
	(6, 9, 'testing this nice title', 'afasfasfasf', '', 'created', '2020-07-19 21:12:22', NULL, 'testing-this-nice-title'),
	(7, 9, 'again testing a nice title', 'asfasfasfas', '', 'created', '2020-07-19 21:13:59', NULL, 'again-testing-a-nice-title5f14b797d2c2b'),
	(8, 9, 'MARE ^&%($TITLU@#@#!', 'mare test cotntet', '', 'created', '2020-07-20 07:21:19', NULL, 'mare-titlu5f1545ef3539c'),
	(9, 9, 'mare test fara content', '', '', 'created', '2020-07-20 07:52:38', NULL, 'mare-test-fara-content5f154d46c869e'),
	(10, 9, 'asfsafasfa', 'sfasfasf', '', 'created', '2020-07-20 09:43:13', NULL, 'asfsafasfa5f1567315cc53'),
	(11, 9, 'asfasfasfas', 'fasfasfs', '', 'created', '2020-07-20 15:37:29', NULL, 'asfasfasfas5f15ba3913bff'),
	(12, 9, 'asfasfasf', 'afasfas', '', 'created', '2020-07-30 07:31:27', NULL, 'asfasfasf5f22774fe9b2f'),
	(13, 9, 'fsaasfasf', 'asfasf', '', 'created', '2020-07-30 07:32:03', NULL, 'fsaasfasf5f227773d1f84'),
	(14, 9, 'fasfasfsafas', 'fasfasf', '', 'created', '2020-07-30 07:35:01', NULL, 'fasfasfsafas5f2278256ec93'),
	(15, 9, 'testing new post tag id', 'asfasfasf', '', 'created', '2020-07-30 08:30:42', NULL, 'testing-new-post-tag-id5f2285324ca65'),
	(16, 9, 'TESTING', 'asfasf', '5f2912097b0d6.jpg', 'approved', '2020-08-04 07:45:23', NULL, 'testing5f291212f3bad');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;

-- Dumping structure for table blog.article_bookmarks
CREATE TABLE IF NOT EXISTS `article_bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `bookmarked_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_bookmarks_unique_idx1` (`bookmarked_by`,`article_id`),
  KEY `article_bookmarks_article_id_fk1` (`article_id`),
  KEY `article_bookmarks_bookmarked_by_fk2` (`bookmarked_by`),
  CONSTRAINT `article_bookmarks_article_id_fk1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_bookmarks_bookmarked_by_fk2` FOREIGN KEY (`bookmarked_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table blog.article_bookmarks: ~7 rows (approximately)
/*!40000 ALTER TABLE `article_bookmarks` DISABLE KEYS */;
INSERT INTO `article_bookmarks` (`id`, `article_id`, `bookmarked_by`) VALUES
	(18, 1, 9),
	(12, 2, 9),
	(15, 11, 9),
	(4, 16, 9),
	(3, 5, 37),
	(1, 7, 41),
	(2, 2, 43);
/*!40000 ALTER TABLE `article_bookmarks` ENABLE KEYS */;

-- Dumping structure for table blog.article_likes
CREATE TABLE IF NOT EXISTS `article_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `liked_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_likes_unique_idx1` (`liked_by`,`article_id`),
  KEY `article_likes_post_id_fk1` (`article_id`),
  KEY `article_likes_liked_by_fk2` (`liked_by`),
  CONSTRAINT `article_likes_liked_by_fk2` FOREIGN KEY (`liked_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_likes_post_id_fk1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table blog.article_likes: ~3 rows (approximately)
/*!40000 ALTER TABLE `article_likes` DISABLE KEYS */;
INSERT INTO `article_likes` (`id`, `article_id`, `liked_by`) VALUES
	(12, 1, 9),
	(11, 2, 9),
	(8, 16, 9);
/*!40000 ALTER TABLE `article_likes` ENABLE KEYS */;

-- Dumping structure for table blog.article_tags
CREATE TABLE IF NOT EXISTS `article_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_tags_unique_idx1` (`article_id`,`tag_id`) USING BTREE,
  KEY `article_tags_tag_id_fk2` (`tag_id`),
  KEY `article_tags_article_id_fk1` (`article_id`),
  CONSTRAINT `article_tags_article_id_fk1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `article_tags_tag_id_fk2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table blog.article_tags: ~30 rows (approximately)
/*!40000 ALTER TABLE `article_tags` DISABLE KEYS */;
INSERT INTO `article_tags` (`id`, `article_id`, `tag_id`) VALUES
	(1, 2, 1),
	(2, 2, 2),
	(3, 2, 3),
	(4, 3, 1),
	(5, 3, 2),
	(6, 3, 3),
	(7, 3, 4),
	(8, 4, 2),
	(9, 4, 3),
	(10, 5, 3),
	(11, 5, 4),
	(12, 6, 3),
	(13, 6, 5),
	(14, 7, 1),
	(15, 7, 2),
	(16, 8, 1),
	(17, 8, 2),
	(18, 8, 3),
	(19, 8, 4),
	(20, 9, 1),
	(21, 9, 2),
	(22, 10, 3),
	(23, 11, 2),
	(24, 15, 2),
	(25, 15, 3),
	(26, 16, 1),
	(27, 16, 2),
	(28, 16, 3),
	(29, 16, 4),
	(30, 16, 5);
/*!40000 ALTER TABLE `article_tags` ENABLE KEYS */;

-- Dumping structure for table blog.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table blog.tag: ~5 rows (approximately)
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` (`id`, `name`, `color`, `description`, `image`) VALUES
	(1, 'html', '#F53900', 'HTML is the standard markup language for Web pages.', NULL),
	(2, 'css', '#2965F1', 'Cascading Style Sheets (CSS) is a simple language for adding style (e.g., fonts, colors, spacing) to HTML documents. It describes how HTML elements should be displayed.', NULL),
	(3, 'javascript', '#F7DF1E', 'Once relegated to the browser as one of the 3 core technologies of the web, JavaScript can now be found almost anywhere you find code.', NULL),
	(4, 'php', '#1A2634', 'Home for all the PHP-related posts on Dev.to!', NULL),
	(5, 'sql', '#ED1556', 'Posts on tips and tricks, using and learning about SQL for database development and analysis.', NULL);
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

-- Dumping structure for table blog.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','Author','User') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guest.svg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table blog.user: ~8 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `email`, `role`, `password`, `created`, `image`) VALUES
	(9, 'sergiu', 'test@test.com', 'Admin', '$2y$10$jYl2v9VvbESBxCN6F7xDJuj5CbLS18AmC/RZBqUoHU75MHIGwknwK', '0000-00-00 00:00:00', 'guest.svg'),
	(37, 'mirelus', 'test@safiasfjaspfjoas.com', 'User', '$2y$10$pNuKbfP0BLDLYSXY.U0Hw.7mFKWG0meX8L1ny/HnT1bNMb7Dq8Jnu', '0000-00-00 00:00:00', 'guest.svg'),
	(38, 'mirelus2', 'apasoijfpaosj@psfaJPosf.com', 'User', '$2y$10$MLd3LDwzKnE0Zive8y949ek2Ko4LmSNLkGy8vtDshH7VgZHEYlKcq', '2020-07-19 09:18:42', 'guest.svg'),
	(39, 'aposifhasoipfhiop', 'pojfaspojfpoasj@asfa.cpom', 'User', '$2y$10$JW6rzzDWOeI6aJo7PHtIBuBjbYWaCRPxh10f0y2joY.rlVQ4GQJVm', '2020-07-19 14:33:44', 'guest.svg'),
	(40, 'sergiuasfasf', 'asfasf@asff.com', 'User', '$2y$10$R/M5vXvLD6ngkOwDpg0kf.UsjVnjIp1gVBktQ8dZ1aVhsEhd813PK', '2020-07-19 14:53:36', 'guest.svg'),
	(41, 'asfasfasfas', 'fasf@fasfas.com', 'User', '$2y$10$vqD/HpoB..Bbdm1I1tfTtuW/DosQKa249Iw1RKnAsM7/Uqv5ELtAm', '2020-07-19 15:12:00', 'guest.svg'),
	(42, 'paiosjfpoajsfpoajspofjaspoj', 'pojfaposjfposajP@poajsfpoasj.com', 'User', '$2y$10$0UsQ8IKTq4OZ8u2m1joV7.XlIGHk77Wf.HLp5.Uiv/AUDs6T0HRBa', '2020-07-20 15:04:22', 'guest.svg'),
	(43, 'asfasf', 'asfasfas@fasfa.com', 'User', '$2y$10$/j93KjFnmnGCU2G1fbrujOkcILNnCZLsxauLRlMLRmhmA1yWu8WXi', '2020-07-30 11:04:53', 'guest.svg');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
