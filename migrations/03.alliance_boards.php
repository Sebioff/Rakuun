<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_alliance` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_alliance`
  ADD CONSTRAINT `boards_alliance_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_alliance_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_alliance_postings`
  ADD CONSTRAINT `boards_alliance_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_alliance` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_alliance_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_alliance_visited`
  ADD CONSTRAINT `boards_alliance_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_alliance` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_alliance_visited_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `meta` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_meta`
  ADD CONSTRAINT `boards_meta_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_meta_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_meta_postings`
  ADD CONSTRAINT `boards_meta_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_meta` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_meta_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_meta_visited`
  ADD CONSTRAINT `boards_meta_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_meta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_meta_visited_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

?>