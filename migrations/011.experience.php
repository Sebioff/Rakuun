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

$queries[] = "ALTER TABLE `users` ADD `xp` INT( 10 ) NOT NULL;";

$queries[] = 'CREATE TABLE IF NOT EXISTS `user_skills` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `economy` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliance_history`
  ADD CONSTRAINT `user_skill_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

?>