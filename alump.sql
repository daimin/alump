--
-- 表的结构 `alump_users`
--
CREATE TABLE `alump_users` (
  `id` int unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `mail` varchar(200) NOT NULL default '',
  `url` varchar(200) NOT NULL default '',
  `nickname` varchar(32) NOT NULL default '',
  `created` int unsigned NOT NULL default '0',
  `group` varchar(16) NOT NULL default 'editor',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



--
-- 表的结构 `alump_options`
--
CREATE TABLE `alump_options` (
  `name` varchar(32) NOT NULL,
  `value` text,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 表的结构 `alump_posts`
--
CREATE TABLE `alump_posts` (
  `id` int unsigned NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `slug` varchar(200) NOT NULL default '',
  `created` int unsigned NOT NULL default '0',
  `modified` int unsigned NOT NULL default '0',
  `content` text,
  `order` int unsigned NOT NULL default '0',
  `author_id` int unsigned NOT NULL default '0',
  `type` varchar(16) NOT NULL default 'post',
  `status` tinyint NOT NULL default 1,
  `password` varchar(64) NOT NULL default '',
  `comment_count` int unsigned  NOT NULL default '0',
  `view_count` int unsigned  NOT NULL default '0',
  `allow_comment` tinyint NOT NULL default '0',
  `allow_feed` tinyint NOT NULL default '0',
  `parent_id` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 表的结构 `alump_metas`
--

CREATE TABLE `alump_metas` (
  `id` int unsigned NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `slug` varchar(200) NOT NULL default '',
  `type` varchar(32) NOT NULL default 'tag',
  `description` varchar(200) NOT NULL default '',
  `count` int unsigned NOT NULL default '0',
  `order` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 表的结构 `alump_relation`
--

CREATE TABLE `alump_relation` (
  `post_id` int unsigned NOT NULL,
  `meta_id` int unsigned NOT NULL,
  PRIMARY KEY  (`post_id`,`meta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- 表的结构 `alump_comments`
--

CREATE TABLE `alump_comments` (
  `id` int unsigned NOT NULL auto_increment,
  `post_id` int unsigned NOT NULL default '0',
  `created` int unsigned NOT NULL default '0',
  `author` varchar(200) NOT NULL default '',
  `author_id` int unsigned NOT NULL default '0',
  `mail` varchar(200) NOT NULL default '',
  `url` varchar(200) NOT NULL default '',
  `ip` varchar(64) NOT NULL default '',
  `agent` varchar(200) NOT NULL default '',
  `content` text,
  `type` varchar(16) NOT NULL default 'comment',
  `status` tinyint NOT NULL default '1',
  `parent_id` int unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `post_id` (`post_id`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 表的结构 `alump_comments`
--
CREATE TABLE `alump_links` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `url` varchar(255) NOT NULL DEFAULT '',
 `name` varchar(255) NOT NULL DEFAULT '',
 `image` varchar(255) NOT NULL DEFAULT '',
 `target` varchar(25) NOT NULL DEFAULT '',
 `description` varchar(255) NOT NULL DEFAULT '',
 `visible` tinyint NOT NULL DEFAULT 1,
 `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
 `created` int unsigned NOT NULL default '0',
 `order` int unsigned NOT NULL default '0',
 PRIMARY KEY (`id`),
 KEY `visible` (`visible`)
 )ENGINE=MyISAM DEFAULT CHARSET=utf8;