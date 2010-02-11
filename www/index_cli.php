#!/usr/local/bin/php
<?php

ob_clean();

if (PHP_SAPI != 'cli') {
	echo 'Must be executed from command line.';
	exit;
}

require_once dirname(__FILE__).'/../config/constants.php';
require_once CORE_PATH.'/app.php';

App::boot();

?>