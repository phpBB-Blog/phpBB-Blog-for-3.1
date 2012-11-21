#
# This dump is for referance only!
#

# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.16)
# Database: phpbbdevelop
# Generation Time: 2012-11-21 15:22:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table phpbb_blog_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_blog_categories`;

CREATE TABLE `phpbb_blog_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `options` int(11) NOT NULL,
  `bitfield` varchar(255) NOT NULL DEFAULT '',
  `uid` varchar(8) NOT NULL DEFAULT '',
  `total_posts` int(11) NOT NULL,
  `last_post` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

LOCK TABLES `phpbb_blog_categories` WRITE;
/*!40000 ALTER TABLE `phpbb_blog_categories` DISABLE KEYS */;

INSERT INTO `phpbb_blog_categories` (`id`, `name`, `description`, `options`, `bitfield`, `uid`, `total_posts`, `last_post`)
VALUES
	(1,'cat1','Some first category\n',0,'','',0,0),
	(2,'cat2','Second category\n',0,'','',0,0);

/*!40000 ALTER TABLE `phpbb_blog_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table phpbb_blog_posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phpbb_blog_posts`;

CREATE TABLE `phpbb_blog_posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `post` text NOT NULL,
  `options` int(11) NOT NULL,
  `bitfield` varchar(255) NOT NULL DEFAULT '',
  `uid` varchar(8) NOT NULL DEFAULT '',
  `poster` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
