<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

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
define('RAKUUN_SPEED_BUILDING', 100);
define('RAKUUN_SPEED_UNITPRODUCTION', 100);
define('RAKUUN_SPEED_UNITMOVEMENT', 100);
define('RAKUUN_SPEED_SATISFACTION_MULTIPLIER', 100);
define('RAKUUN_SPEED_DANCERTIA_STARTTIME', 5 * 60 * 60);

// $3  -  Ressources ///////////////////////////////////////////////////////////
define('RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER', 1);
define('RAKUUN_STORE_CAPACITY_MULTIPLIER', 50);
define('RAKUUN_STORE_CAPACITY_SAVE_MULTIPLIER', 10);
define('RAKUUN_TRADELIMIT_MULTIPLIER', 1);

// $4 - Noob ///////////////////////////////////////////////////////////////////
define('RAKUUN_NOOB_SECURE_PERCENTAGE', 0.5);
define('RAKUUN_NOOB_START_LIMIT_OF_POINTS', 120);
define('RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH', 600);
?>