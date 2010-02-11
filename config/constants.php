<?php

require_once dirname(__FILE__).'/revision.php';

// CORE CONFIGURATION ----------------------------------------------------------
define('CORE_PATH', realpath(dirname(__FILE__).'/../../CORE'));
define('CORE_MAILSENDER', 'Rakuun <service@rakuun.de>');

// PROJECT CONFIGURATION -------------------------------------------------------
define('PROJECT_NAME', 'Rakuun');
define('CALLBACK_ERROR', 'Rakuun_Module::onError');
define('CALLBACK_ONAFTERRESET', 'Rakuun_Module::onSetup');
define('CALLBACK_MAINTENANCE', 'Rakuun_Module::maintenanceMode');

// PROJECT SPECIFIC CONSTANTS --------------------------------------------------
define('RAKUUN_ERRORMAIL_RECIPIENTS', 'sebioff@gmx.de');
define('RAKUUN_VERSION', '4.0.0 beta');
define('RAKUUN_ROUND_NUMBER', 24);

?>