<?php

$queries[] = 'CREATE TABLE IF NOT EXISTS `metas` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `intern` text NOT NULL,
  `iron` mediumint(9) NOT NULL DEFAULT \'0\',
  `beryllium` mediumint(9) NOT NULL DEFAULT \'0\',
  `energy` mediumint(9) NOT NULL DEFAULT \'0\',
  `people` mediumint(9) NOT NULL DEFAULT \'0\',
  `dancertia_starttime` int(10) unsigned NOT NULL DEFAULT \'0\',
  `picture` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `alliances` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `meta` smallint(5) unsigned DEFAULT NULL,
  `description` text NOT NULL,
  `intern` text NOT NULL,
  `iron` int(10) NOT NULL DEFAULT \'0\',
  `beryllium` int(10) NOT NULL DEFAULT \'0\',
  `energy` int(10) NOT NULL DEFAULT \'0\',
  `people` int(10) NOT NULL DEFAULT \'0\',
  `points` mediumint(5) unsigned NOT NULL,
  `picture` text,
  `invitations` tinyint(1) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliances`
  ADD CONSTRAINT `alliances_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE SET NULL;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `metas_applications` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned NOT NULL,
  `meta` smallint(5) unsigned NOT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`,`meta`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `metas_applications`
  ADD CONSTRAINT `metas_applications_ibfk_2` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `metas_applications_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

/*
 * last_login = time the user logged in last (sitting doesn't count; used to check if the account is actively used)
 * last_activity = last activity in this account (sitting counts, used for statistics)
 * last_bot_verification = last time someone verified this account is no bot
 * is_online = 0 if user is properly logged out, otherwise identical to last_activity (used to actually check if the user is online or not)
 */
$queries[] = 'CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `name_colored` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `registration_time` int(10) unsigned NOT NULL,
  `activation_time` int(10) unsigned NOT NULL,
  `mail` varchar(50) NOT NULL,
  `city_name` varchar(20) NOT NULL,
  `icq` int(9) NOT NULL,
  `points` mediumint(9) unsigned NOT NULL,
  `multi_points` mediumint(9) unsigned NOT NULL,
  `ip` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `collapsed_panels` text NOT NULL,
  `sequence_buildings` text NOT NULL,
  `sequence_technologies` text NOT NULL,
  `sequence_units` text NOT NULL,
  `skin` varchar(32) NOT NULL,
  `tradelimit` mediumint(9) unsigned NOT NULL,
  `stockmarkettrade` mediumint(9) unsigned NOT NULL,
  `alliance` smallint(5) unsigned DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  `last_login` int(10) unsigned NOT NULL,
  `last_bot_verification` int(10) unsigned NOT NULL,
  `is_online` int(10) unsigned NOT NULL,
  `news` text NOT NULL,
  `picture` text,
  `city_x` smallint(5) unsigned DEFAULT NULL,
  `city_y` smallint(5) unsigned DEFAULT NULL,
  `sitter` int(10) unsigned DEFAULT NULL,
  `sitter_note` text NOT NULL,
  `tutorial` tinyint(1) NOT NULL DEFAULT \'1\',
  `is_in_noob`tinyint(1) unsigned NOT NULL DEFAULT \'1\',
  `is_yimtay` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `production_paused` int(10) unsigned NOT NULL DEFAULT \'0\',
  `shoutbox_timeban` int(10) unsigned NOT NULL,
  `adminnews` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`),
  KEY `sitter` (`sitter`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`sitter`) REFERENCES `users` (`id`) ON DELETE SET NULL;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `code` varchar(32) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `has_been_remembered` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `users_activations`
  ADD CONSTRAINT `users_activations_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

/*
 * time is the endtime, when the ban is to be finish
 */
$queries[] = 'CREATE TABLE IF NOT EXISTS `users_banned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `users_activations`
  ADD CONSTRAINT `users_banned_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_deleted` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(25) NOT NULL,
  `name_colored` varchar(255) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `alliances_applications` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `alliance` smallint(5) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `editor` int(10) unsigned DEFAULT NULL,
  `editor_notice` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `alliance` (`alliance`),
  KEY `editor` (`editor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliances_applications`
  ADD CONSTRAINT `alliances_applications_ibfk_3` FOREIGN KEY (`editor`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `alliances_applications_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `alliances_applications_ibfk_2` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_admin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_admin_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `deleted_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_admin_postings`
  ADD CONSTRAINT `boards_admin_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_admin` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_admin_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_admin_visited`
  ADD CONSTRAINT `boards_admin_visited_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_admin_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_admin` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_alliance` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_alliance`
  ADD CONSTRAINT `boards_alliance_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_alliance_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `deleted_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_alliance_postings`
  ADD CONSTRAINT `boards_alliance_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_alliance` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_alliance_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_alliance_visited`
  ADD CONSTRAINT `boards_alliance_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_alliance` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_alliance_visited_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `meta` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_meta`
  ADD CONSTRAINT `boards_meta_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_meta_postings` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned DEFAULT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `editdate` int(10) unsigned DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  `deleted_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_meta_postings`
  ADD CONSTRAINT `boards_meta_postings_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_meta` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `boards_meta_visited` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board` mediumint(8) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `board` (`board`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `boards_meta_visited`
  ADD CONSTRAINT `boards_meta_visited_ibfk_1` FOREIGN KEY (`board`) REFERENCES `boards_meta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boards_meta_visited_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `alliances_diplomacy` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance_active` smallint(5) unsigned DEFAULT NULL,
  `alliance_passive` smallint(5) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `notice` tinyint(2) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance_active` (`alliance_active`),
  KEY `alliance_passive` (`alliance_passive`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliances_diplomacy`
  ADD CONSTRAINT `alliances_diplomacy_ibfk_2` FOREIGN KEY (`alliance_passive`) REFERENCES `alliances` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `alliances_diplomacy_ibfk_1` FOREIGN KEY (`alliance_active`) REFERENCES `alliances` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `ressources` (
  `user` int(10) unsigned NOT NULL,
  `iron` int(10) NOT NULL,
  `beryllium` int(10) NOT NULL,
  `energy` int(10) NOT NULL,
  `people` int(10) NOT NULL,
  `produced_iron` float unsigned NOT NULL,
  `produced_beryllium` float unsigned NOT NULL,
  `produced_energy` float unsigned NOT NULL,
  `produced_people` float unsigned NOT NULL,
  `tick` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'ALTER TABLE `ressources`
  ADD CONSTRAINT `ressources_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `buildings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `ironmine` mediumint(9) NOT NULL,
  `berylliummine` mediumint(9) NOT NULL,
  `ironstore` mediumint(9) NOT NULL,
  `berylliumstore` mediumint(9) NOT NULL,
  `energystore` mediumint(9) NOT NULL,
  `house` mediumint(9) NOT NULL,
  `themepark` mediumint(9) NOT NULL,
  `clonomat` mediumint(9) NOT NULL,
  `laboratory` mediumint(9) NOT NULL,
  `hydropower_plant` mediumint(9) NOT NULL,
  `stock_market` mediumint(9) NOT NULL,
  `moleculartransmitter` mediumint(9) NOT NULL,
  `military_base` mediumint(9) NOT NULL,
  `tank_factory` mediumint(9) NOT NULL,
  `barracks` mediumint(9) NOT NULL,
  `city_wall` mediumint(9) NOT NULL,
  `airport` mediumint(9) NOT NULL,
  `sensor_bay` mediumint(9) NOT NULL,
  `shield_generator` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `buildings_wip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `building` varchar(30) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `level` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';

$queries[] = 'ALTER TABLE `buildings_wip`
  ADD CONSTRAINT `buildings_wip_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `buildings_workers` (
  `user` int(10) unsigned NOT NULL,
  `ironmine` mediumint(9) NOT NULL,
  `berylliummine` mediumint(9) NOT NULL,
  `clonomat` mediumint(9) NOT NULL,
  `hydropower_plant` mediumint(9) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'ALTER TABLE `buildings_workers`
  ADD CONSTRAINT `buildings_workers_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `technologies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `hydropower` mediumint(9) NOT NULL,
  `genetic` mediumint(9) NOT NULL,
  `light_weaponry` mediumint(9) NOT NULL,
  `light_plating` mediumint(9) NOT NULL,
  `jet` mediumint(9) NOT NULL,
  `laser` mediumint(9) NOT NULL,
  `antigravitation` mediumint(9) NOT NULL,
  `cloaking` mediumint(9) NOT NULL,
  `enhanced_cloaking` mediumint(9) NOT NULL,
  `momo` mediumint(9) NOT NULL,
  `supercompression` mediumint(9) NOT NULL,
  `plasmatechnology` mediumint(9) NOT NULL,
  `cybernetics` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'ALTER TABLE `technologies`
  ADD CONSTRAINT `technologies_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `technologies_wip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `technology` varchar(30) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `level` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';

$queries[] = 'ALTER TABLE `technologies_wip`
  ADD CONSTRAINT `technologies_wip_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `pezetto` mediumint(9) NOT NULL,
  `inra` mediumint(9) NOT NULL,
  `laser_rifleman` mediumint(9) NOT NULL,
  `tego` mediumint(9) NOT NULL,
  `minigani` mediumint(9) NOT NULL,
  `mandrogani` mediumint(9) NOT NULL,
  `buhogani` mediumint(9) NOT NULL,
  `donany` mediumint(9) NOT NULL,
  `tertor` mediumint(9) NOT NULL,
  `stormok` mediumint(9) NOT NULL,
  `laser_turret` mediumint(9) NOT NULL,
  `telaturri` mediumint(9) NOT NULL,
  `spydrone` mediumint(9) NOT NULL,
  `cloaked_spydrone` mediumint(9) NOT NULL,
  `lorica` mediumint(9) NOT NULL,
  `buildings` int(10) unsigned NOT NULL,
  `technologies` int(10) unsigned NOT NULL,
  `fighting_sequence` text NOT NULL,
  `attack_sequence` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `buildings` (`buildings`),
  KEY `technologies` (`technologies`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'ALTER TABLE `units`
  ADD CONSTRAINT `units_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_ibfk_2` FOREIGN KEY (`buildings`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_ibfk_3` FOREIGN KEY (`technologies`) REFERENCES `technologies` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `units_wip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `unit` varchar(30) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `amount` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';

$queries[] = 'ALTER TABLE `units_wip`
  ADD CONSTRAINT `units_wip_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `armies_technologies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hydropower` mediumint(9) NOT NULL,
  `light_weaponry` mediumint(9) NOT NULL,
  `light_plating` mediumint(9) NOT NULL,
  `jet` mediumint(9) NOT NULL,
  `laser` mediumint(9) NOT NULL,
  `antigravitation` mediumint(9) NOT NULL,
  `cloaking` mediumint(9) NOT NULL,
  `enhanced_cloaking` mediumint(9) NOT NULL,
  `supercompression` mediumint(9) NOT NULL,
  `plasmatechnology` mediumint(9) NOT NULL,
  `cybernetics` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `armies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `target` int(10) unsigned DEFAULT NULL,
  `inra` mediumint(9) NOT NULL,
  `laser_rifleman` mediumint(9) NOT NULL,
  `tego` mediumint(9) NOT NULL,
  `minigani` mediumint(9) NOT NULL,
  `mandrogani` mediumint(9) NOT NULL,
  `buhogani` mediumint(9) NOT NULL,
  `donany` mediumint(9) NOT NULL,
  `tertor` mediumint(9) NOT NULL,
  `stormok` mediumint(9) NOT NULL,
  `spydrone` mediumint(9) NOT NULL,
  `cloaked_spydrone` mediumint(9) NOT NULL,
  `lorica` mediumint(9) NOT NULL,
  `target_x` smallint(5) unsigned NOT NULL,
  `target_y` smallint(5) unsigned NOT NULL,
  `target_time` int(10) unsigned NOT NULL,
  `position_x` smallint(5) unsigned NOT NULL,
  `position_y` smallint(5) unsigned NOT NULL,
  `tick` int(10) unsigned NOT NULL,
  `technologies` int(10) unsigned NOT NULL,
  `fighting_sequence` text NOT NULL,
  `destroy_buildings` tinyint(1) unsigned NOT NULL,
  `iron` mediumint(9) NOT NULL,
  `beryllium` mediumint(9) NOT NULL,
  `energy` mediumint(9) NOT NULL,
  `iron_priority` tinyint(1) unsigned NOT NULL,
  `beryllium_priority` tinyint(1) unsigned NOT NULL,
  `energy_priority` tinyint(1) unsigned NOT NULL,
  `speed_multiplier` float unsigned NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `target` (`target`),
  KEY `technologies` (`technologies`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'ALTER TABLE `armies`
  ADD CONSTRAINT `armies_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `armies_ibfk_2` FOREIGN KEY (`technologies`) REFERENCES `armies_technologies` (`id`);';

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

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_users_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `action` tinyint(1) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `ip` varchar(20) NOT NULL,
  `hostname` int(60) unsigned NOT NULL,
  `browser` varchar(255) NOT NULL,
  `cookie` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `log_users_activity`
  ADD CONSTRAINT `log_users_activity_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_users_ressourcetransfer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `sender` int(10) unsigned NOT NULL,
  `action` tinyint(1) unsigned NOT NULL,
  `iron` mediumint(9) NOT NULL,
  `beryllium` mediumint(9) NOT NULL,
  `energy` mediumint(9) NOT NULL,
  `people` mediumint(9) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `ip` varchar(20) NOT NULL,
  `hostname` int(60) unsigned NOT NULL,
  `browser` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user` (`user`),
  INDEX `sender` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_users_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `action` tinyint(1) unsigned NOT NULL,
  `data` varchar(255) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `ip` varchar(20) NOT NULL,
  `hostname` int(60) unsigned NOT NULL,
  `browser` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `log_users_data`
  ADD CONSTRAINT `log_users_data_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';


$queries[] = 'CREATE TABLE IF NOT EXISTS `log_multiactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` tinyint(1) unsigned NOT NULL,
  `multiaction` tinyint(1) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_multiactions_users_assoc` (
  `multi_action` int(10) unsigned DEFAULT NULL,
  `user` int(10) unsigned DEFAULT NULL,
  KEY `multi_action` (`multi_action`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `log_multiactions_users_assoc`
  ADD CONSTRAINT `log_multiactions_users_assoc_ibfk_1` FOREIGN KEY (`multi_action`) REFERENCES `log_multiactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `log_multiactions_users_assoc_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_units_production` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `pezetto` mediumint(9) NOT NULL,
  `inra` mediumint(9) NOT NULL,
  `laser_rifleman` mediumint(9) NOT NULL,
  `tego` mediumint(9) NOT NULL,
  `minigani` mediumint(9) NOT NULL,
  `mandrogani` mediumint(9) NOT NULL,
  `buhogani` mediumint(9) NOT NULL,
  `donany` mediumint(9) NOT NULL,
  `tertor` mediumint(9) NOT NULL,
  `stormok` mediumint(9) NOT NULL,
  `laser_turret` mediumint(9) NOT NULL,
  `telaturri` mediumint(9) NOT NULL,
  `spydrone` mediumint(9) NOT NULL,
  `cloaked_spydrone` mediumint(9) NOT NULL,
  `lorica` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_fights` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `opponent` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `fight_id` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `role` tinyint(1) unsigned NOT NULL,
  `pezetto` mediumint(9) NOT NULL,
  `inra` mediumint(9) NOT NULL,
  `laser_rifleman` mediumint(9) NOT NULL,
  `tego` mediumint(9) NOT NULL,
  `minigani` mediumint(9) NOT NULL,
  `mandrogani` mediumint(9) NOT NULL,
  `buhogani` mediumint(9) NOT NULL,
  `donany` mediumint(9) NOT NULL,
  `tertor` mediumint(9) NOT NULL,
  `stormok` mediumint(9) NOT NULL,
  `laser_turret` mediumint(9) NOT NULL,
  `telaturri` mediumint(9) NOT NULL,
  `spydrone` mediumint(9) NOT NULL,
  `cloaked_spydrone` mediumint(9) NOT NULL,
  `lorica` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user` (`user`),
  INDEX ( `fight_id` )
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_spies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `spied_user` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `pezetto` mediumint(9) NOT NULL,
  `inra` mediumint(9) NOT NULL,
  `laser_rifleman` mediumint(9) NOT NULL,
  `tego` mediumint(9) NOT NULL,
  `minigani` mediumint(9) NOT NULL,
  `mandrogani` mediumint(9) NOT NULL,
  `buhogani` mediumint(9) NOT NULL,
  `donany` mediumint(9) NOT NULL,
  `tertor` mediumint(9) NOT NULL,
  `stormok` mediumint(9) NOT NULL,
  `laser_turret` mediumint(9) NOT NULL,
  `telaturri` mediumint(9) NOT NULL,
  `spydrone` mediumint(9) NOT NULL,
  `cloaked_spydrone` mediumint(9) NOT NULL,
  `lorica` mediumint(9) NOT NULL,
  `ironmine` mediumint(9) NOT NULL,
  `berylliummine` mediumint(9) NOT NULL,
  `ironstore` mediumint(9) NOT NULL,
  `berylliumstore` mediumint(9) NOT NULL,
  `energystore` mediumint(9) NOT NULL,
  `house` mediumint(9) NOT NULL,
  `themepark` mediumint(9) NOT NULL,
  `clonomat` mediumint(9) NOT NULL,
  `laboratory` mediumint(9) NOT NULL,
  `hydropower_plant` mediumint(9) NOT NULL,
  `stock_market` mediumint(9) NOT NULL,
  `moleculartransmitter` mediumint(9) NOT NULL,
  `military_base` mediumint(9) NOT NULL,
  `tank_factory` mediumint(9) NOT NULL,
  `barracks` mediumint(9) NOT NULL,
  `city_wall` mediumint(9) NOT NULL,
  `airport` mediumint(9) NOT NULL,
  `sensor_bay` mediumint(9) NOT NULL,
  `shield_generator` mediumint(9) NOT NULL,
  `iron` int(10) NOT NULL,
  `beryllium` int(10) NOT NULL,
  `energy` int(10) NOT NULL,
  `people` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `log_spies`
  ADD CONSTRAINT `log_spies_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `sender` int(10) unsigned DEFAULT NULL,
  `sender_name` varchar(25) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `has_been_read` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE SET NULL;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `messages_attachments` (
  `message` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  KEY `message` (`message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `messages_attachments`
  ADD CONSTRAINT `messages_attachments_ibfk_1` FOREIGN KEY (`message`) REFERENCES `messages` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `polls` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `alliance` smallint(5) unsigned DEFAULT NULL,
  `meta` smallint(5) unsigned DEFAULT NULL,
  `question` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `runtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `polls`
  ADD CONSTRAINT `polls_ibfk_2` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `polls_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `polls_answers` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `poll` smallint(5) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `poll` (`poll`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `polls_answers`
  ADD CONSTRAINT `polls_answers_ibfk_1` FOREIGN KEY (`poll`) REFERENCES `polls` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `polls_answers_users_assoc` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `answer` smallint(5) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `answer` (`answer`,`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `polls_answers_users_assoc`
  ADD CONSTRAINT `polls_answers_users_assoc_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `polls_answers_users_assoc_ibfk_1` FOREIGN KEY (`answer`) REFERENCES `polls_answers` (`id`) ON DELETE CASCADE;';
 
$queries[] = 'CREATE TABLE IF NOT EXISTS `alliances_accountlog` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned NOT NULL,
  `sender` int(10) unsigned DEFAULT NULL,
  `receiver` int(10) unsigned DEFAULT NULL,
  `iron` mediumint(9) NOT NULL,
  `beryllium` mediumint(9) NOT NULL,
  `energy` mediumint(9) NOT NULL,
  `people` mediumint(9) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `type` smallint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`),
  KEY `sender` (`sender`),
  KEY `receiver` (`receiver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `alliances_accountlog`
  ADD CONSTRAINT `alliances_accountlog_ibfk_1` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `metas_accountlog` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned DEFAULT NULL,
  `meta` smallint(5) unsigned NOT NULL,
  `iron` mediumint(9) NOT NULL,
  `beryllium` mediumint(9) NOT NULL,
  `energy` mediumint(9) NOT NULL,
  `people` mediumint(9) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alliance` (`alliance`),
  KEY `meta` (`meta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `metas_accountlog`
  ADD CONSTRAINT `metas_accountlog_ibfk_2` FOREIGN KEY (`alliance`) REFERENCES `alliances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `metas_accountlog_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `text` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `cautions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `admin` int(10) unsigned DEFAULT NULL,
  `points` int(10) unsigned NOT NULL,
  `reason` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `admin` (`admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `cautions`
  ADD CONSTRAINT `cautions_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cautions_ibfk_2` FOREIGN KEY (`admin`) REFERENCES `users` (`id`) ON DELETE SET NULL;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `specials_users_assoc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `identifier` tinyint(2) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `specials_users_assoc`
  ADD CONSTRAINT `specials_users_assoc_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `specials_params` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `specials_users` int(10) unsigned NOT NULL,
  `key` varchar(15) NOT NULL,
  `value` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `specials_users` (`specials_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `specials_params`
  ADD CONSTRAINT `specials_params_ibfk_1` FOREIGN KEY (`specials_users`) REFERENCES `specials_users_assoc` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_buildings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `executing_user` int(10) unsigned NOT NULL,
  `time` int(15) unsigned NOT NULL,
  `building` varchar(30) NOT NULL,
  `level` mediumint(9) NOT NULL,
  `delta_level` tinyint(1) NOT NULL,
  `event_type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `log_technologies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `time` int(15) unsigned NOT NULL,
  `technology` varchar(30) NOT NULL,
  `level` mediumint(9) NOT NULL,
  `delta_level` tinyint(1) NOT NULL,
  `event_type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `log_technologies`
  ADD CONSTRAINT `log_technologies_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_callbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `style` smallint(1) unsigned NOT NULL,
  `method` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `users_callbacks`
  ADD CONSTRAINT `users_callbacks_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `supporttickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned DEFAULT NULL,
  `supporter` int(10) unsigned DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `has_been_read` tinyint(1) unsigned NOT NULL,
  `is_answered` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `supporter` (`supporter`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `supporttickets`
  ADD CONSTRAINT `supporttickets_ibfk_1` FOREIGN KEY (`supporter`) REFERENCES `users` (`id`) ON DELETE SET NULL;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_directory_messages_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `users_directory_messages_groups`
  ADD CONSTRAINT `users_directory_messages_groups_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_directory_messages_groups_assoc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group` (`group`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `users_directory_messages_groups_assoc`
  ADD CONSTRAINT `users_directory_messages_groups_assoc_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_directory_messages_groups_assoc_ibfk_1` FOREIGN KEY (`group`) REFERENCES `users_directory_messages_groups` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_directory_army_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$queries[] = 'ALTER TABLE `users_directory_army_groups`
  ADD CONSTRAINT `users_directory_army_groups_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_directory_army_groups_assoc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group` (`group`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `users_directory_army_groups_assoc`
  ADD CONSTRAINT `users_directory_army_groups_assoc_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_directory_army_groups_assoc_ibfk_1` FOREIGN KEY (`group`) REFERENCES `users_directory_army_groups` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `tutor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `level` varchar(25) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `stockmarket` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL,
  `iron` int(10) unsigned NOT NULL,
  `beryllium` int(10) unsigned NOT NULL,
  `energy` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

$queries[] = 'INSERT INTO `stockmarket` (`id`, `date`, `iron`, `beryllium`, `energy`) VALUES
(1, '.mktime(12, 0, 0).', '.Rakuun_Intern_GUI_Panel_StockMarket::BASE_IRON.', '.Rakuun_Intern_GUI_Panel_StockMarket::BASE_BERYLLIUM.', '.Rakuun_Intern_GUI_Panel_StockMarket::BASE_ENERGY.');';

$queries[] = 'CREATE TABLE IF NOT EXISTS `databases_startpositions` (
  `identifier` tinyint(1) unsigned NOT NULL,
  `position_x` smallint(5) unsigned NOT NULL,
  `position_y` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;';

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
  ADD CONSTRAINT `shoutbox_alliances_ibfk_1` FOREIGN KEY ( `alliance` ) REFERENCES `alliances` (`id`) ON DELETE CASCADE;';

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
  ADD CONSTRAINT `shoutbox_metas_ibfk_1` FOREIGN KEY (`meta`) REFERENCES `metas` (`id`) ON DELETE CASCADE;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `alliances_buildings` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alliance` smallint(5) unsigned NOT NULL,
  `database_detector_blue` mediumint(9) NOT NULL,
  `database_detector_brown` mediumint(9) NOT NULL,
  `database_detector_green` mediumint(9) NOT NULL,
  `database_detector_red` mediumint(9) NOT NULL,
  `database_detector_yellow` mediumint(9) NOT NULL,
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

$queries[] = 'CREATE TABLE IF NOT EXISTS `quests` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `identifier` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

$queries[] = 'CREATE TABLE IF NOT EXISTS `users_eternal_user_assoc` (
  `user` int(10) unsigned NOT NULL,
  `eternal_user` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;';

$queries[] = 'ALTER TABLE `users_eternal_user_assoc`
  ADD CONSTRAINT `users_eternal_user_assoc_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE;';

?>