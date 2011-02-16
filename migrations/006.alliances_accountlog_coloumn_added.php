<?php

$queries[] = "ALTER TABLE `alliances_accountlog` ADD `ip` varchar( 16 ) NOT NULL;"; 
$queries[] = "ALTER TABLE `alliances_accountlog` ADD `hostname` int( 60 ) unsigned NOT NULL;";
$queries[] = "ALTER TABLE `alliances_accountlog` ADD `browser` varchar( 255 ) NOT NULL;";

?>