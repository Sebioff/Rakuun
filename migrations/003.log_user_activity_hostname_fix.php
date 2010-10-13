<?php

$queries[] = 'ALTER TABLE `log_users_activity` CHANGE `hostname` `hostname` VARCHAR( 60 ) NOT NULL;';
$queries[] = 'ALTER TABLE `log_users_ressourcetransfer` CHANGE `hostname` `hostname` VARCHAR( 60 ) NOT NULL;';
$queries[] = 'ALTER TABLE `log_users_data` CHANGE `hostname` `hostname` VARCHAR( 60 ) NOT NULL;';

?>
