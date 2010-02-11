<?php

abstract class Rakuun_Cronjob_Script {
	private $identifier = '';
	private $executionInterval = 0;
	
	/**
	 * @param $identifier String a unique identifier for this script
	 * @param $executionInterval int the interval in seconds in which this script
	 * should be executed (NOTE: min. 60 seconds, should be full minutes)
	 */
	public function __construct($identifier, $executionInterval = 60) {
		$this->identifier = $identifier;
		$this->executionInterval = $executionInterval;
	}
	
	public abstract function execute();
	
	public function requiresExecution($lastExecutionTime) {
		return (time() - $lastExecutionTime >= $this->executionInterval);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getIdentifier() {
		return $this->identifier;
	}
}

?>