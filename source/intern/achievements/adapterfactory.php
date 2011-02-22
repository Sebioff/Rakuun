<?php

class Rakuun_Intern_Achievements_AdapterFactory {
	private static $instance = null;
	private $adapterList = array();
	
	private function __construct() {
		// Singleton
	}
	
	private function buildAdapterList() {
		$this->adapterList[] = new Rakuun_Intern_Achievements_Round24Adapter('24');
		$this->adapterList[] = new Rakuun_Intern_Achievements_Round25Adapter('25');
	}
	
	/**
	 * @return Rakuun_Intern_Achievements_Adapter
	 */
	public function getAdapterForRound($roundName) {
		if (!$this->adapterList)
			$this->buildAdapterList();
			
		$roundInformation = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByRoundNameFirst($roundName);
		
		foreach (array_reverse($this->adapterList) as $adapter) {
			$adapterRoundInformation = $adapter->getRoundInformation($adapter->getValidSinceRoundName());
			if ($adapterRoundInformation && $adapterRoundInformation->endTime <= $roundInformation->endTime)
				return $adapter;
		}
	}
	
	/**
	 * @return Rakuun_Intern_Achievements_AdapterFactory
	 */
	public static function get() {
		return (self::$instance) ? self::$instance : self::$instance = new self();
	}
}