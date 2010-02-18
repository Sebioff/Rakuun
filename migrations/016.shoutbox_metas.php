<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `shoutbox_metas` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `meta` smallint(5) unsigned NOT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `shoutbox_metas`
  ADD CONSTRAINT `shoutbox_metas_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shoutbox_metas_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE;';

?>