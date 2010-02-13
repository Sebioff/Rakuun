<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `shoutbox_alliances` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned NOT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `alliance` (`alliance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';

$queries[] = 'ALTER TABLE `shoutbox_alliances`
  ADD CONSTRAINT `shoutbox_alliances_ibfk_3` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `shoutbox_alliances_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON UPDATE SET NULL;';

?>