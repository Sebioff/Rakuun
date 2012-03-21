<?php

$queries[] = "ALTER TABLE `messages`
	ADD `is_reported` TINYINT( 1 ) unsigned NOT NULL DEFAULT '0';";
?>