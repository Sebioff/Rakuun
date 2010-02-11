<?php

/**
 * A panel displaying costs of a building and allowing to build/remove levels of
 * it.
 */
class Rakuun_Intern_GUI_Panel_Production_Alliance extends Rakuun_Intern_GUI_Panel_Production_Production {
	const WIP_ITEM_MAXAMOUNT = 1; // maximum allowed amount of items in the wip list
	
	public function init() {
		parent::init();
		
		$this->produce->setValue('Auf Stufe '.$this->getProductionItem()->getNextBuildableLevel().' ausbauen');
		if ($this->hasPanel('remove'))
			$this->removePanel($this->remove);
		
		$options = array();
		$options['conditions'][] = array('alliance = ?', Rakuun_User_Manager::getCurrentUser()->alliance);
		if (Rakuun_DB_Containers::getAlliancesBuildingsWIPContainer()->count($options) >= self::WIP_ITEM_MAXAMOUNT) {
			$this->removePanel($this->produce);
		}
	}
	
	public function onProduce() {
		parent::onProduce();
		
		if ($this->hasErrors()) {
			return;
		}
		
		DB_Connection::get()->beginTransaction();
		$nextBuildableLevel = $this->getProductionItem()->getNextBuildableLevel();
		$ironCosts = $this->getProductionItem()->getIronCostsForLevel($nextBuildableLevel);
		$berylliumCosts = $this->getProductionItem()->getBerylliumCostsForLevel($nextBuildableLevel);
		$energyCosts = $this->getProductionItem()->getEnergyCostsForLevel($nextBuildableLevel);
		$peopleCosts = $this->getProductionItem()->getPeopleCostsForLevel($nextBuildableLevel);
		$this->getProductionItem()->getOwner()->ressources->lower($ironCosts, $berylliumCosts, $energyCosts, $peopleCosts);
		$record = new DB_Record();
		$record->alliance = $this->getProductionItem()->getOwner();
		$record->building = $this->getProductionItem()->getInternalName();
		$record->level = $nextBuildableLevel;
		$record->starttime = time();
		$record->position = time();
		Rakuun_DB_Containers::getAlliancesBuildingsWIPContainer()->save($record);
		DB_Connection::get()->commit();
		Router::get()->getCurrentModule()->invalidate();
	}
}

?>