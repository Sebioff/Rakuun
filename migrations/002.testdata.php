<?php

// USER "Test"
$queries[] = "INSERT INTO `users` (`id`, `name`, `name_colored`, `city_name`, `password`, `salt`, `mail`, `skin`, `city_x`, `city_y`) VALUES
(1, 'Test', '[gold]Test[/gold]', 'Teststadt', '362d538ca473183259014418311e241a', 'e57fd64014b627dca55b3ec1f98d7b6b', 'sebioff@gmx.de', 'tech', '10', '15');";

$queries[] = 'INSERT INTO `ressources` (`user`, `iron`, `beryllium`, `energy`, `people`, `tick`) VALUES
(1, 100000, 100000, 100000, 100000, '.time().');';

$queries[] = 'INSERT INTO `buildings` (`user`, `ironmine`, `berylliummine`, `ironstore`, `berylliumstore`, `energystore`, `house`, `themepark`, `moleculartransmitter`, `stock_market`) VALUES (1, 1, 1, 1, 1, 1, 1, 1, 1, 1);';

$queries[] = 'INSERT INTO `buildings_workers` (`user`) VALUES (1);';

$queries[] = 'INSERT INTO `technologies` (`user`) VALUES (1);';

$queries[] = 'INSERT INTO `units` (`user`, `buildings`, `technologies`, `fighting_sequence`) VALUES (1, 1, 1, \'telaturri|tertor|inra|donany|stormok|mandrogani|laser_rifleman|tego|minigani|buhogani|laser_turret|pezetto\');';


// USER "someoneelse"
$queries[] = "INSERT INTO `users` (`id`, `name`, `password`, `salt`, `mail`, `skin`, `city_x`, `city_y`) VALUES
(2, 'someoneelse', '362d538ca473183259014418311e241a', 'e57fd64014b627dca55b3ec1f98d7b6b', 'someoneelse@test.de', 'tech', '20', '20');";

$queries[] = 'INSERT INTO `ressources` (`user`, `iron`, `beryllium`, `energy`, `people`, `tick`) VALUES
(2, 100000, 100000, 100000, 100000, '.time().');';

$queries[] = 'INSERT INTO `buildings` (`user`, `ironmine`, `berylliummine`, `ironstore`, `berylliumstore`, `energystore`, `house`, `themepark`, `moleculartransmitter`) VALUES (2, 1, 1, 1, 1, 1, 1, 1, 1);';

$queries[] = 'INSERT INTO `buildings_workers` (`user`) VALUES (2);';

$queries[] = 'INSERT INTO `technologies` (`user`) VALUES (2);';

$queries[] = 'INSERT INTO `units` (`user`, `buildings`, `technologies`, `fighting_sequence`) VALUES (2, 2, 2, \'telaturri|tertor|inra|donany|stormok|mandrogani|laser_rifleman|tego|minigani|buhogani|laser_turret|pezetto\');';

?>