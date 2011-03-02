<?php

class Rakuun_Intern_GUI_Panel_Production_Workers extends Rakuun_GUI_Panel_Box {
	private $productionItem = null;
	
	public function __construct($name, Rakuun_Intern_Production_Building_RessourceProducer $productionItem) {
		parent::__construct($name, null, $productionItem->getName());
		
		$this->productionItem = $productionItem;
	}
	
	public function init() {
		parent::init();
		
		$this->contentPanel->setTemplate(dirname(__FILE__).'/workers.tpl');
		
		$missingWorkers = $this->getProductionItem()->getRequiredWorkers() - $this->getProductionItem()->getWorkers();
		if ($missingWorkers > $this->getProductionItem()->getUser()->ressources->people)
			$missingWorkers = $this->getProductionItem()->getUser()->ressources->people;
		$maxAddAmount = min($missingWorkers, $this->getProductionItem()->getUser()->ressources->people);
		$this->contentPanel->addPanel(new GUI_Control_DigitBox('workers_add_amount', $missingWorkers, 'Einzustellende Arbeiter', 0, $maxAddAmount));
		$this->contentPanel->addPanel(new GUI_Control_SubmitButton('workers_add', 'Arbeiter einstellen'));
		
		$this->contentPanel->addPanel(new GUI_Control_DigitBox('workers_remove_amount', 0, 'Zu entlassende Arbeiter', 0, $this->getProductionItem()->getWorkers()));
		$this->contentPanel->addPanel(new GUI_Control_SubmitButton('workers_remove', 'Arbeiter entlassen'));
	}
	
	// CALLBACKS ---------------------------------------------------------------
	public function onWorkersAdd() {
		if ($this->hasErrors())
			return;
		
		if (Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($this->getProductionItem()->getUser())->{Text::underscoreToCamelCase($this->getProductionItem()->getInternalName())} + $this->contentPanel->workersAddAmount->getValue() <= $this->getProductionItem()->getRequiredWorkers()) {
			DB_Connection::get()->beginTransaction();
			$this->getProductionItem()->getUser()->ressources->lower(0, 0, 0, $this->contentPanel->workersAddAmount->getValue());
			$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($this->getProductionItem()->getUser());
			$workers->{Text::underscoreToCamelCase($this->getProductionItem()->getInternalName())} += $this->contentPanel->workersAddAmount->getValue();
			$workers->save();
			DB_Connection::get()->commit();
				
			$this->getModule()->invalidate();	
		}
	}
	
	public function onWorkersRemove() {
		if ($this->hasErrors())
			return;
		if (Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($this->getProductionItem()->getUser())->{Text::underscoreToCamelCase($this->getProductionItem()->getInternalName())} - $this->contentPanel->workersRemoveAmount->getValue() >= 0) {
			DB_Connection::get()->beginTransaction();
			$currentWorkers = $this->getProductionItem()->getWorkers();
		
			$this->getProductionItem()->getUser()->ressources->raise(0, 0, 0, $this->contentPanel->workersRemoveAmount->getValue());
			$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($this->getProductionItem()->getUser());
			$workers->{Text::underscoreToCamelCase($this->getProductionItem()->getInternalName())} -= $this->contentPanel->workersRemoveAmount->getValue();
			$workers->save();
			DB_Connection::get()->commit();
			$this->getModule()->invalidate();
		}
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_Intern_Production_Building_RessourceProducer
	 */
	public function getProductionItem() {
		return $this->productionItem;
	}
}

?>