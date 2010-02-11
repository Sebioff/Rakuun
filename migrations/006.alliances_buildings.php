<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `alliances_buildings` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned NOT NULL,
  `database_detector` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliances_buildings`
  ADD CONSTRAINT `alliances_buildings_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `alliances_buildings_wip` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned NOT NULL,
  `building` varchar(30) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `level` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

$queries[] = 'ALTER TABLE `alliances_buildings_wip`
  ADD CONSTRAINT `alliances_buildings_wip_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `metas_buildings` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `meta` smallint(5) unsigned NOT NULL,
  `space_port` mediumint(9) NOT NULL,
  `dancertia` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `metas_buildings`
  ADD CONSTRAINT `metas_buildings_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `metas_buildings_wip` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `meta` smallint(5) unsigned NOT NULL,
  `building` varchar(30) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `level` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

$queries[] = 'ALTER TABLE `metas_buildings_wip`
  ADD CONSTRAINT `metas_buildings_wip_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE;';


// TODO remove following queries when merging migrations
$queries[] = 'INSERT INTO `alliances_buildings` (alliance) SELECT ID from `alliances`';
$queries[] = 'INSERT INTO `metas_buildings` (meta) SELECT ID from `metas`';

?>