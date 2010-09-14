<?php

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

?>