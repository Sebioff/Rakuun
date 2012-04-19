<?php

$queries[] = "ALTER TABLE `users` ADD `xp` INT( 10 ) NOT NULL;";

$queries[] = 'CREATE TABLE IF NOT EXISTS `user_skills` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `economy` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliance_history`
  ADD CONSTRAINT `user_skill_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

?>