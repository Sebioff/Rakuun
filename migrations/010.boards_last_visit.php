<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';

$queries[] = 'ALTER TABLE `boards_visited`
  ADD CONSTRAINT `boards_visited_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards` (`id`) ON DELETE CASCADE;';
?>