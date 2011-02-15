<?php

//outgoing Ressourcentransfers
//see also log_users_ressourcetransfer for incomming resourcetransfers
$queries[] = 'CREATE TABLE IF NOT EXISTS `log_users_ressourcetransfer_out` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `recipient` int(10) unsigned NOT NULL,
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
  INDEX `recipient` (`recipient`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=0;';

?>