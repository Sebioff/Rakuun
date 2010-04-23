<?php

$queries[] = 'DROP TABLE `boards_postings`;';

$queries[] = 'DROP TABLE `boards_visited`;';

$queries[] = 'DROP TABLE `boards`;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_admin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_admin_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_admin_postings`
  ADD CONSTRAINT `boards_admin_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_admin` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_admin_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_admin_visited`
  ADD CONSTRAINT `boards_admin_visited_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_admin_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_admin` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_global` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_global_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user_name` varchar(25) NOT NULL,
  `round_number` tinyint(4) unsigned NOT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_global_postings`
  ADD CONSTRAINT `boards_global_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_global` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_global_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `round_number` tinyint(4) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_global_visited`
  ADD CONSTRAINT `boards_global_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_global` (`id`) ON DELETE CASCADE;';

?>