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
		$this->contentPanel->addPanel(new GUI_Control_DigitBox('workers_add_amount', $missingWorkers));
		$this->contentPanel->addPanel(new GUI_Control_SubmitButton('workers_add', 'Arbeiter einstellen'));
		
		$this->contentPanel->addPanel(new GUI_Control_DigitBox('workers_remove_amount'));
		$this->contentPanel->addPanel(new GUI_Control_SubmitButton('workers_remove', 'Arbeiter entlassen'));
	}
	
	// CALLBACKS ---------------------------------------------------------------
	public function onWorkersAdd() {
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		$missingWorkers = $this->getProductionItem()->getRequiredWorkers() - $this->getProductionItem()->getWorkers();
		if ($this->contentPanel->workersAddAmount->getValue() > $missingWorkers)
			$this->contentPanel->workersAddAmount->setValue($missingWorkers);
	
		if ($this->contentPanel->workersAddAmount->getValue() > $this->getProductionItem()->getUser()->ressources->people)
			$this->contentPanel->workersAddAmount->setValue($this->getProductionItem()->getUser()->ressources->people);

		$this->getProductionItem()->getUser()->ressources->lower(0, 0, 0, $this->contentPanel->workersAddAmount->getValue());
		$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($this->getProductionItem()->getUser());
		$workers->{Text::underscoreToCamelCase($this->getProductionItem()->getInternalName())} += $this->contentPanel->workersAddAmount->getValue();
		$workers->save();
		DB_Connection::get()->commit();
		
		if ($missingWorkers - $this->contentPanel->workersAddAmount->getValue() <= 0)
			$this->contentPanel->workersAddAmount->setValue(0);
	}
	
	public function onWorkersRemove() {
		if ($this->hasErrors())
			return;
			
		DB_Connection::get()->beginTransaction();
		$currentWorkers = $this->getProductionItem()->getWorkers();
		if ($this->contentPanel->workersRemoveAmount->getValue() > $currentWorkers)
			$this->contentPanel->workersRemoveAmount->setValue($currentWorkers);

		$this->getProductionItem()->getUser()->ressources->raise(0, 0, 0, $this->contentPanel->workersRemoveAmount->getValue());
		$workers = Rakuun_DB_Containers::getBuildingsWorkersContainer()->selectByUserFirst($this->getProductionItem()->getUser());
		$workers->{Text::underscoreToCamelCase($this->getProductionItem()->getInternalName())} -= $this->contentPanel->workersRemoveAmount->getValue();
		$workers->save();
		DB_Connection::get()->commit();
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