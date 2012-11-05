<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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