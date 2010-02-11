<?php

abstract class Rakuun_Intern_Production_AllianceBuilding extends Rakuun_Intern_Production_CityItem {
	public function __construct(DB_Record $dataSource = null) {
		$alliance = null;
		if (!$dataSource) {
			$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
			$dataSource = $alliance->buildings;
		}
		elseif ($dataSource instanceof Rakuun_DB_Alliance) {
			$alliance = $dataSource;
			$dataSource = $dataSource->buildings;
		}
		else {
			$alliance = $dataSource->alliance;
		}
		parent::__construct($dataSource, $alliance);
	}
	
	/**
	 * Returns the amount of levels that are currently being build.
	 */
	public function getFutureLevels() {
		$options = array();
		$options['conditions'][] = array('alliance = ?', $this->getOwner());
		$options['conditions'][] = array('building = ?', $this->getInternalName());
		return Rakuun_DB_Containers::getAlliancesBuildingsWIPContainer()->count($options);
	}
	
	public function meetsTechnicalRequirements() {
		foreach ($this->getNeededBuildings() as $internalName => $neededLevel) {
			if (Rakuun_Intern_Production_Factory_Alliances::getBuilding($internalName, $this->$this->getOwner())->getLevel() < $neededLevel)
				return false;
		}
		
		foreach ($this->getNeededRequirements() as $requirement) {
			if (!$requirement->fulfilled())
				return false;
		}
		
		return true;
	}
}

?>