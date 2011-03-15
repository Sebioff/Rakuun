<?php

$queries[] = 'ALTER TABLE `boards_admin` ADD `closed` BOOL NOT NULL AFTER `name`;';

$queries[] = 'ALTER TABLE `boards_alliance` ADD `closed` BOOL NOT NULL AFTER `name`;';

$queries[] = 'ALTER TABLE `boards_meta` ADD `closed` BOOL NOT NULL AFTER `name`;';
?>