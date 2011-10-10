<?php

/**
 * A panel displaying costs of a building and allowing to build/remove levels of
 * it.
 */
class Rakuun_Intern_GUI_Panel_Production_Building extends Rakuun_Intern_GUI_Panel_Production_Production {
	const WIP_ITEM_MAXAMOUNT = 5; // maximum allowed amount of items in the wip list
	
	public function init() {
		parent::init();
		
		$this->produce->setValue('Auf Stufe '.$this->getProductionItem()->getNextBuildableLevel().' ausbauen');
		if ($this->hasPanel('remove')) {
			$this->remove->setValue('Abreißen');
			$this->remove->setConfirmationMessage(
				'Wirklich eine Stufe dieses Gebäudes abreißen?\nEs werden 50% der Kosten erstattet:'.
				'\n'.round($this->getProductionItem()->getIronRepayForLevel()).' Eisen'.
				'\n'.round($this->getProductionItem()->getBerylliumRepayForLevel()).' Beryllium'.
				'\n'.round($this->getProductionItem()->getEnergyRepayForLevel()).' Energie'.
				'\n'.round($this->getProductionItem()->getPeopleRepayForLevel()).' Leute'
			);
		}
		
		$options = array();
		$options['conditions'][] = array('user = ?', $this->getProductionItem()->getUser());
		if (Rakuun_DB_Containers::getBuildingsWIPContainer()->count($options) >= self::WIP_ITEM_MAXAMOUNT) {
			$this->removePanel($this->produce);
		}
		
		if ($this->getProductionItem() instanceof Rakuun_Intern_Production_Building_RessourceProducer) {
			$currentWorkers = $this->getProductionItem()->getWorkers();
			$requiredWorkers = $this->getProductionItem()->getRequiredWorkers();
			
			$this->addHeadPanel($workers = new GUI_Panel_Text('workers', 'Arbeiter: '.Text::formatNumber($currentWorkers).'/'.Text::formatNumber($requiredWorkers)));
			$workers->addClasses('workers');
			
			if ($currentWorkers < $requiredWorkers)
				$workers->addClasses('rakuun_requirements_failed');
			
			$this->addHeadPanel(new GUI_Control_Link('workers_manage', 'Arbeiter verwalten', App::get()->getInternModule()->getSubmodule('build')->getSubmodule('workers')->getUrl()));
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
		$this->getProductionItem()->getUser()->ressources->lower($ironCosts, $berylliumCosts, $energyCosts, $peopleCosts);
		$record = new DB_Record();
		$record->user = $this->getProductionItem()->getUser();
		$record->building = $this->getProductionItem()->getInternalName();
		$record->level = $nextBuildableLevel;
		$record->starttime = time();
		Rakuun_DB_Containers::getBuildingsWIPContainer()->save($record);
		$record->position = $record->getPK();
		$record->save();
		DB_Connection::get()->commit();
		Router::get()->getCurrentModule()->invalidate();
	}
	
	public function onRemove() {
		parent::onRemove();
		
		if ($this->hasErrors()) {
			return;
		}
		
		DB_Connection::get()->beginTransaction();
		// repay ressources
		$building = $this->getProductionItem();
		$iron = $building->getIronRepayForLevel();
		$beryllium = $building->getBerylliumRepayForLevel();
		$energy = $building->getEnergyRepayForLevel();
		$people = $building->getPeopleRepayForLevel();
		$building->getUser()->ressources->raise($iron, $beryllium, $energy, $people);
		// lower building level
		$building->getUser()->buildings->lower($building->getInternalName(), Rakuun_User_Manager::getCurrentUser());
		// remove unneeded workers
		if ($building instanceof Rakuun_Intern_Production_Building_RessourceProducer) {
			$lowerLevel = $building->getLevel();
			if ($building->getWorkers() > $building->getRequiredWorkers($lowerLevel)) {
				$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($building->getUser());
				$building->getUser()->ressources->raise(0, 0, 0, $building->getWorkers() - $building->getRequiredWorkers($lowerLevel));
				$workers->{Text::underscoreToCamelCase($building->getInternalName())} = $building->getRequiredWorkers($lowerLevel);
				$workers->save();
			}
		}
		DB_Connection::get()->commit();
		Router::get()->getCurrentModule()->invalidate();
	}
}

?>