<?php

$queries[] = 'ALTER TABLE `users`
	CHANGE `tradelimit` `tradelimit` MEDIUMINT UNSIGNED NOT NULL,
	CHANGE `stockmarkettrade` `stockmarkettrade` MEDIUMINT UNSIGNED NOT NULL';

?>