<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `databases_startpositions` (
  `identifier` tinyint(1) unsigned NOT NULL,
  `position_x` smallint(5) unsigned NOT NULL,
  `position_y` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `armies` DROP FOREIGN KEY `armies_ibfk_2`;';

?>