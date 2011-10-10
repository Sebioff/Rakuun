<?php

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