-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  `tags` varchar(255) COLLATE utf8_bin NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL,
  `intro` text COLLATE utf8_bin NOT NULL,
  `intro_html` text COLLATE utf8_bin NOT NULL,
  `content` mediumtext COLLATE utf8_bin NOT NULL,
  `content_html` mediumtext COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `published` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `posts` (`id`, `slug`, `tags`, `title`, `intro`, `intro_html`, `content`, `content_html`, `created`, `published`, `user_id`) VALUES
(1,	'slug test',	'',	'title test',	'intro test',	'',	'content test',	'',	'2014-05-29 00:28:49',	NULL,	1);

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `settings` (`id`, `key`, `value`, `comment`) VALUES
(1,	'title',	'MindaBlog!',	'');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `salt` varchar(255) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `created`) VALUES
(1,	'test',	'c32ac6310706acdadea74c901c3f08fe06c44c61',	'd7e8541887cb9b3461d7364e4e7c8b7d',	'2014-05-28 22:58:22');

-- 2014-05-31 00:32:03
