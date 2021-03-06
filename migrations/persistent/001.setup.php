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

$queries[] = 'CREATE TABLE IF NOT EXISTS `round_information` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `round_name` varchar(25) NOT NULL,
  `winning_meta` varchar(25) NOT NULL,
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `writer` varchar(25) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `eternal_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `eternal_user_user_assoc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eternal_user` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `round` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eternal_user` (`eternal_user`),
  KEY `round` (`round`),
  CONSTRAINT `eternal_user_user_assoc_ibfk_1` FOREIGN KEY (`eternal_user`) REFERENCES `eternal_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `eternal_user_user_assoc_ibfk_2` FOREIGN KEY (`round`) REFERENCES `round_information` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `eternal_user_achievements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eternal_user` int(10) unsigned NOT NULL,
  `round` smallint(5) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT \'0\',
  `achievement` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eternal_user` (`eternal_user`),
  KEY `round` (`round`),
  CONSTRAINT `eternal_user_achievements_ibfk_1` FOREIGN KEY (`eternal_user`) REFERENCES `eternal_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `eternal_user_achievements_ibfk_2` FOREIGN KEY (`round`) REFERENCES `round_information` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

?>