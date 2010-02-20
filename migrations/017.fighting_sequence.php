<?php

$queries[] = 'ALTER TABLE `units`
	ADD COLUMN `attack_sequence` text NOT NULL';

$queries[] = 'UPDATE `units` SET attack_sequence = "tertor|inra|donany|stormok|mandrogani|laser_rifleman|tego|minigani|buhogani"';

?>