<?php
/**
 * $1 - Creation of new tables and constraints
 * $2 - Copy data from old to new tables
 * $3 - Delete old data
 * $4 - Remove unused columns
 * $5 - Add new column
 */

// - $1 -- create new board-tables + constraints

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
  ADD CONSTRAINT `boards_alliance_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_alliance` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_alliance_postings_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE SET NULL;';

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
  ADD CONSTRAINT `boards_meta_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_meta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_meta_postings_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE SET NULL;';

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

// - $2 -- copy old data to new tables

$queries[] = 'INSERT INTO `boards_alliance` (`id`, `alliance`, `name`, `date`)
	SELECT `boards`.`id`, `boards`.`alliance`, `boards`.`name`, '.time().'
	FROM `boards`
	WHERE `boards`.`alliance` is not null;';

$queries[] = 'INSERT INTO `boards_meta` (`id`, `meta`, `name`, `date`)
	SELECT `boards`.`id`, `boards`.`meta`, `boards`.`name`, '.time().'
	FROM `boards`
	WHERE `boards`.`meta` is not null;';

$queries[] = 'INSERT INTO `boards_alliance_postings` (`board`, `user`, `text`, `date`, `editdate`)
	SELECT `board`, `user`, `text`, `date`, `editdate`
	FROM `boards_postings`
	WHERE `boards_postings`.`board` IN (SELECT `id` FROM `boards_alliance`);';

$queries[] = 'INSERT INTO `boards_meta_postings` (`board`, `user`, `text`, `date`, `editdate`)
	SELECT `board`, `user`, `text`, `date`, `editdate`
	FROM `boards_postings`
	WHERE `boards_postings`.`board` IN (SELECT `id` FROM `boards_meta`);';

// - $3 -- delete old data

$queries[] = 'DELETE FROM `boards`
	WHERE `id` in (SELECT `id` FROM `boards_alliance`);';

$queries[] = 'DELETE FROM `boards`
	WHERE `id` in (SELECT `id` FROM `boards_meta`);';

$queries[] = 'DELETE FROM `boards_postings`
	WHERE `board` in (SELECT `id` FROM `boards_alliance`);';

$queries[] = 'DELETE FROM `boards_postings`
	WHERE `board` in (SELECT `id` FROM `boards_meta`);';

$queries[] = 'TRUNCATE TABLE `boards_visited`;';

// - $4 -- remove unused columns and constraints

$queries[] = 'ALTER TABLE `boards` DROP FOREIGN KEY `boards_ibfk_1`;';

$queries[] = 'ALTER TABLE `boards` DROP FOREIGN KEY `boards_ibfk_2`;';

$queries[] = 'ALTER TABLE `boards` DROP `alliance`, DROP `meta`, DROP `type`;'; 

// - $5 -- add new column

$queries[] = 'ALTER TABLE `boards` ADD `date` INT( 10 ) UNSIGNED NOT NULL;';

?>