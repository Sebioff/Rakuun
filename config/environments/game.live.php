<?php

/* GAME SETTINGS ###############################################################
 * $1  -  Game Control
 * $2  -  Speed
 * $3  -  Ressources
 * $4  -  Noob
 */

// $1  -  Game Control /////////////////////////////////////////////////////////
define('RAKUUN_REGISTRATION_ENABLED', true);
define('RAKUUN_GAME_MODE', 'Rakuun_Intern_Mode_Standard');

// $2  -  Speed ////////////////////////////////////////////////////////////////
define('RAKUUN_SPEED_BUILDING', 1);
define('RAKUUN_SPEED_UNITPRODUCTION', 1);
define('RAKUUN_SPEED_UNITMOVEMENT', 1);
define('RAKUUN_SPEED_SATISFACTION_MULTIPLIER', 1);
define('RAKUUN_SPEED_DANCERTIA_STARTTIME', 5 * 24 * 60 * 60);

// $3  -  Ressources ///////////////////////////////////////////////////////////
define('RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER', 1);
define('RAKUUN_STORE_CAPACITY_MULTIPLIER', 1);
define('RAKUUN_STORE_CAPACITY_SAVE_MULTIPLIER', 1);
define('RAKUUN_TRADELIMIT_MULTIPLIER', 1);

// $4 - Noob ///////////////////////////////////////////////////////////////////
define('RAKUUN_NOOB_SECURE_PERCENTAGE', 0.5);
define('RAKUUN_NOOB_START_LIMIT_OF_POINTS', 120);
define('RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH', 600);
?>