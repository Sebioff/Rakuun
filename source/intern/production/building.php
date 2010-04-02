<?php

abstract class Rakuun_Intern_Production_Building extends Rakuun_Intern_Production_CityItem {
	public function __construct(DB_Record $dataSource = null) {
		$user = null;
		if (!$dataSource) {
			if ($user = Rakuun_User_Manager::getCurrentUser())
				$dataSource = $user->buildings;
		}
		elseif ($dataSource instanceof Rakuun_DB_User) {
			$user = $dataSource;
			$dataSource = $dataSource->buildings;
		}
		else {
			$user = $dataSource->user;
		}
		parent::__construct($dataSource, $user);
	}
	
	/**
	 * Returns the amount of levels that are currently being build.
	 */
	public function getFutureLevels() {
		$options = array();
		$options['conditions'][] = array('user = ?', $this->getUser());
		$options['conditions'][] = array('building = ?', $this->getInternalName());
		return Rakuun_DB_Containers::getBuildingsWIPContainer()->count($options);
	}
	
	// OVERRIDES / IMPLEMENTS --------------------------------------------------
	public function getTimeCosts($level = null) {
		if ($level === null)
			$level = $this->getLevel();
			
		$costs = $this->getBaseTimeCosts() * $level;
		$costs -= $costs / 100 * Rakuun_Intern_Production_Technology_Momo::BUILDING_TIME_REDUCTION_PERCENT * Rakuun_Intern_Production_Factory::getTechnology('momo', $this->getUser())->getLevel();
		
		// quest award
		$quest = new Rakuun_Intern_Quest_FirstCompleteMomo();
		if ($quest->isOwnedBy($this->getUser()))
			$costs -= $costs / 100 * Rakuun_Intern_Quest_FirstCompleteMomo::BUILD_TIME_REDUCTION_PERCENT;
		
		$costs = round($costs / RAKUUN_SPEED_BUILDING);
		
		if ($costs < 1)
			$costs = 1;
		
		return $costs;
	}
}

?>