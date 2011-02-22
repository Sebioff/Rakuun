<?php

abstract class Rakuun_Intern_GUI_Panel_Production_Production extends GUI_Panel {
	private $productionItem = null;
	private $headPanels = array();
	
	public function __construct($name, Rakuun_Intern_Production_Base $productionItem) {
		parent::__construct($name);
		
		$this->productionItem = $productionItem;
	}
	
	public function init() {
		parent::init();
		
		$this->addPanel(new GUI_Control_SecureSubmitButton('produce'));
		if ($this->getProductionItem() instanceof Rakuun_Intern_Production_CityItem) {
			// TODO add additional checks if removing is possible (in noob, ...)
			if ($this->getProductionItem()->getLevel() > $this->getProductionItem()->getMinimumLevel()) {
				$this->addPanel($remove = new GUI_Control_SecureSubmitButton('remove'));
				$remove->setConfirmationMessage('Wirklich entfernen?');
			}
		}
		$this->setTemplate(dirname(__FILE__).'/production.tpl');
	}
	
	public function onProduce() {
		if (!$this->getProductionItem()->meetsTechnicalRequirements())
			$this->addError('Fehlende technische Voraussetzungen');
			
		if (!$this->getProductionItem()->gotEnoughRessources())
			$this->addError('Fehlende Ressourcen');
			
		if ($this->getProductionItem()->reachedMaximumLevel())
			$this->addError('Maximale Ausbaustufe erreicht');
			
		if (!$this->getProductionItem()->canBuild())
			$this->addError('Kann nicht hergestellt werden');
	}
	
	public function onRemove() {
		if ($this->getProductionItem()->getMinimumLevel() == $this->getProductionItem()->getLevel())
			$this->addError('Befindet sich bereits auf der niedrigsten möglichen Stufe');
	}

	// GETTERS / SETTERS -------------------------------------------------------
	/**
	 * @return Rakuun_Intern_Production_Base
	 */
	public function getProductionItem() {
		return $this->productionItem;
	}
	
	public function addHeadPanel(GUI_Panel $panel) {
		$this->addPanel($panel);
		$this->headPanels[] = $panel;
	}
	
	public function getHeadPanels() {
		return $this->headPanels;
	}
}

?>