<?php

$queries[] = "ALTER TABLE `users`
	ADD `show_global_board_count` TINYINT( 1 ) unsigned NOT NULL DEFAULT '1',
	ADD `last_gn_voting` int(10) unsigned NOT NULL;";
?>