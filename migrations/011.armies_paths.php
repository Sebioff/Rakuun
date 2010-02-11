<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `armies_paths` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `army` int(10) unsigned NOT NULL ,
  `x` tinyint(3) unsigned NOT NULL,
  `y` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `army` (`army`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';

$queries[] = 'ALTER TABLE `armies_paths`
  ADD CONSTRAINT `armies_paths_ibfk_1` FOREIGN KEY (`army`) REFERENCES `armies` (`id`) ON DELETE CASCADE;';

?>