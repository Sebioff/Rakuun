<?php

$queries[] = 'ALTER TABLE `users`
	ADD COLUMN `production_paused` int(10) unsigned NOT NULL DEFAULT \'0\'';

?>