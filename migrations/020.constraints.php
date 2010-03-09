<?php

$queries[] = 'ALTER TABLE `shoutbox_alliances` DROP FOREIGN KEY `shoutbox_alliances_ibfk_3` ;';

$queries[] = 'ALTER TABLE `shoutbox_alliances` ADD FOREIGN KEY ( `alliance` ) REFERENCES `alliances` (`id`) ON DELETE CASCADE ;';

$queries[] = 'ALTER TABLE `shoutbox_alliances` DROP FOREIGN KEY `shoutbox_alliances_ibfk_2` ;';

$queries[] = 'ALTER TABLE `shoutbox_metas` DROP FOREIGN KEY `shoutbox_metas_ibfk_2` ;';

$queries[] = 'ALTER TABLE `boards_alliance_postings` DROP FOREIGN KEY `boards_alliance_postings_ibfk_2` ;';

$queries[] = 'ALTER TABLE `boards_meta_postings` DROP FOREIGN KEY `boards_meta_postings_ibfk_2` ;';

$queries[] = 'ALTER TABLE `boards_postings` DROP FOREIGN KEY `boards_postings_ibfk_2` ;';

?>