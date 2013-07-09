/*
SQLyog Community v11.1 Beta1 (32 bit)
MySQL - 5.1.50-community : Database - alump
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`alump` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `alump`;

/*Table structure for table `alump_comments` */

DROP TABLE IF EXISTS `alump_comments`;

CREATE TABLE `alump_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(200) NOT NULL DEFAULT '',
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `mail` varchar(200) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `agent` varchar(200) NOT NULL DEFAULT '',
  `content` text,
  `type` varchar(16) NOT NULL DEFAULT 'comment',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

/*Table structure for table `alump_links` */

DROP TABLE IF EXISTS `alump_links`;

CREATE TABLE `alump_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `target` varchar(25) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `visible` tinyint(4) NOT NULL DEFAULT '1',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `alump_metas` */

DROP TABLE IF EXISTS `alump_metas`;

CREATE TABLE `alump_metas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `type` varchar(32) NOT NULL DEFAULT 'tag',
  `description` varchar(200) NOT NULL DEFAULT '',
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

/*Table structure for table `alump_options` */

DROP TABLE IF EXISTS `alump_options`;

CREATE TABLE `alump_options` (
  `name` varchar(32) NOT NULL,
  `value` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `alump_posts` */

DROP TABLE IF EXISTS `alump_posts`;

CREATE TABLE `alump_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL DEFAULT '0',
  `content` longtext,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(16) NOT NULL DEFAULT 'post',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `password` varchar(64) NOT NULL DEFAULT '',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0',
  `allow_comment` tinyint(4) NOT NULL DEFAULT '0',
  `allow_feed` tinyint(4) NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=179 DEFAULT CHARSET=utf8;

/*Table structure for table `alump_relation` */

DROP TABLE IF EXISTS `alump_relation`;

CREATE TABLE `alump_relation` (
  `post_id` int(10) unsigned NOT NULL,
  `meta_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`meta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `alump_users` */

DROP TABLE IF EXISTS `alump_users`;

CREATE TABLE `alump_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `mail` varchar(200) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `nickname` varchar(32) NOT NULL DEFAULT '',
  `visited` int(10) DEFAULT '0',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `group` varchar(16) NOT NULL DEFAULT 'editor',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `alump_logs` */

DROP TABLE IF EXISTS `alump_logs`;

CREATE TABLE `alump_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(8) NOT NULL DEFAULT 'action',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `page` varchar(255) NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `action` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
