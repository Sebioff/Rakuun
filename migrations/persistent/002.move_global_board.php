<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_global` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `closed` BOOL NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_global_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user_name` varchar(25) NOT NULL,
  `round_number` varchar(15) NOT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `deleted_by_name` varchar(25) NOT NULL,
  `deleted_by_round_number` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  CONSTRAINT `boards_global_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_global` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_global_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `round_number` varchar(15) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  CONSTRAINT `boards_global_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_global` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

?>