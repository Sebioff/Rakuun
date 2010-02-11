<?php

abstract class Rakuun_Intern_Production_MetaBuilding extends Rakuun_Intern_Production_CityItem {
	public function __construct(DB_Record $dataSource = null) {
		$meta = null;
		if (!$dataSource) {
			$meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
			$dataSource = $meta->buildings;
		}
		elseif ($dataSource instanceof Rakuun_DB_Meta) {
			$meta = $dataSource;
			$dataSource = $dataSource->buildings;
		}
		else {
			$meta = $dataSource->meta;
		}
		parent::__construct($dataSource, $meta);
	}
	
	/**
	 * Returns the amount of levels that are currently being build.
	 */
	public function getFutureLevels() {
		$options = array();
		$options['conditions'][] = array('meta = ?', $this->getOwner());
		$options['conditions'][] = array('building = ?', $this->getInternalName());
		return Rakuun_DB_Containers::getMetasBuildingsWIPContainer()->count($options);
	}
	
	public function meetsTechnicalRequirements() {
		foreach ($this->getNeededBuildings() as $internalName => $neededLevel) {
			if (Rakuun_Intern_Production_Factory_Metas::getBuilding($internalName, $this->getOwner())->getLevel() < $neededLevel)
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