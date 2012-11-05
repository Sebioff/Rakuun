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

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_outgoing_armies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `opponent` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `pezetto` mediumint(9) NOT NULL,
  `inra` mediumint(9) NOT NULL,
  `laser_rifleman` mediumint(9) NOT NULL,
  `tego` mediumint(9) NOT NULL,
  `minigani` mediumint(9) NOT NULL,
  `mandrogani` mediumint(9) NOT NULL,
  `buhogani` mediumint(9) NOT NULL,
  `donany` mediumint(9) NOT NULL,
  `tertor` mediumint(9) NOT NULL,
  `stormok` mediumint(9) NOT NULL,
  `laser_turret` mediumint(9) NOT NULL,
  `telaturri` mediumint(9) NOT NULL,
  `spydrone` mediumint(9) NOT NULL,
  `cloaked_spydrone` mediumint(9) NOT NULL,
  `lorica` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
?>