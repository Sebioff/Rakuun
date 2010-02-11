<?php

/**
 * Cronjob script that is executed at a specific time.
 */
abstract class Rakuun_Cronjob_Script_FixedTime extends Rakuun_Cronjob_Script {
	private $timeToExecute = 0;
	
	public function __construct($identifier, $hourToExecute, $minuteToExecute) {
		parent::__construct($identifier);
		$this->timeToExecute = mktime($hourToExecute, $minuteToExecute);
	}
	
	public function requiresExecution($lastExecutionTime) {
		$lastExecutionDay = date('z', $lastExecutionTime);
		return (date('z') != $lastExecutionDay && time() >= $this->timeToExecute);
	}
}

?>