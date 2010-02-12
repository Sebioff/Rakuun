<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_known_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';

?>