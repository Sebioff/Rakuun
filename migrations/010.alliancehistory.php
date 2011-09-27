<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `alliance_history` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `alliance_name` varchar(25) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliance_history`
  ADD CONSTRAINT `alliance_history_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE SET NULL;';

?>