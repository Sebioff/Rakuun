<?php

$queries[] = "ALTER TABLE `boards_admin_postings` ADD `deleted` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0', ADD `deleted_by` INT UNSIGNED NOT NULL;";

$queries[] = "ALTER TABLE `boards_alliance_postings` ADD `deleted` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0', ADD `deleted_by` INT UNSIGNED NOT NULL;";

$queries[] = "ALTER TABLE `boards_global_postings` ADD `deleted` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0', ADD `deleted_by_name` varchar(25) NOT NULL, ADD `deleted_by_round_number` tinyint(4) unsigned NOT NULL;";

$queries[] = "ALTER TABLE `boards_meta_postings` ADD `deleted` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0', ADD `deleted_by` INT UNSIGNED NOT NULL;";

?>