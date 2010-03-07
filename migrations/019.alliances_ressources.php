<?php

$queries[] = 'ALTER TABLE `alliances`
	CHANGE `iron` `iron` INT( 10 ) NOT NULL DEFAULT \'0\',
	CHANGE `beryllium` `beryllium` INT( 10 ) NOT NULL DEFAULT \'0\',
	CHANGE `energy` `energy` INT( 10 ) NOT NULL DEFAULT \'0\',
	CHANGE `people` `people` INT( 10 ) NOT NULL DEFAULT \'0\'';

?>