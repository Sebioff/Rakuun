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

require_once dirname(__FILE__).'/revision.php';
require_once dirname(__FILE__).'/local.php';

// CORE CONFIGURATION ----------------------------------------------------------
define('CORE_MAILSENDER', 'Rakuun <service@rakuun.de>');

// PROJECT CONFIGURATION -------------------------------------------------------
define('PROJECT_NAME', 'Rakuun');
define('CALLBACK_ERROR', 'Rakuun_Module::onError');
define('CALLBACK_ONAFTERRESET', 'Rakuun_Module::onSetup');
define('CALLBACK_MAINTENANCE', 'Rakuun_Module::maintenanceMode');
if (PHP_SAPI == 'cli')
	define('PROJECT_ROOTURI', 'http://www.rakuun.de');
ini_set('session.gc_maxlifetime', 3600);

// PROJECT SPECIFIC CONSTANTS --------------------------------------------------
define('RAKUUN_ERRORMAIL_RECIPIENTS', 'sebioff@gmx.de');
define('RAKUUN_VERSION', '4.3.1');
define('RAKUUN_ROUND_NAME', '33');

?>