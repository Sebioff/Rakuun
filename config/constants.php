<?php

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