<?php

class Rakuun_Intern_GUI_Panel_Production_Unit extends Rakuun_Intern_GUI_Panel_Production_Production {
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_DigitBox('amount', 0, 'Anzahl'));
		$this->produce->setValue('Produzieren');
		$this->setTemplate(dirname(__FILE__).'/production_unit.tpl');
	}
	
	public function onProduce() {
		$amount = $this->amount->getValue();
		
		if ($amount <= 0)
			$this->addError('Mindestens 1 Einheit muss produziert werden');
		
		if (!$this->getProductionItem()->meetsTechnicalRequirements())
			$this->addError('Fehlende technische Vorraussetzungen');
		
		if (!$this->getProductionItem()->gotEnoughRessources($amount))
			$this->addError('Fehlende Ressourcen');
		
		if (!$this->getProductionItem()->canBuild($amount))
			$this->addError('Kann nicht hergestellt werden');
		
		if ($this->hasErrors()) {
			return;
		}
		
		DB_Connection::get()->beginTransaction();
		$ironCosts = $this->getProductionItem()->getIronCostsForAmount($amount);
		$berylliumCosts = $this->getProductionItem()->getBerylliumCostsForAmount($amount);
		$energyCosts = $this->getProductionItem()->getEnergyCostsForAmount($amount);
		$peopleCosts = $this->getProductionItem()->getPeopleCostsForAmount($amount);
		$this->getProductionItem()->getUser()->ressources->lower($ironCosts, $berylliumCosts, $energyCosts, $peopleCosts);
		$record = new DB_Record();
		$record->user = $this->getProductionItem()->getUser();
		$record->unit = $this->getProductionItem()->getInternalName();
		$record->amount = $amount;
		$record->starttime = time();
		$record->position = time();
		Rakuun_DB_Containers::getUnitsWIPContainer()->save($record);
		DB_Connection::get()->commit();
		Router::get()->getCurrentModule()->invalidate();
	}
}

?>