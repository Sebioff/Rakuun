<?php

class Rakuun_Intern_GUI_Panel_Map_DefendingUnits extends GUI_Panel {
	private $panelsForDefendingUnits = array();
	private $panelsForOtherUnits = array();
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/defendingunits.tpl');
		$fightingSequence = array_reverse(explode('|', Rakuun_User_Manager::getCurrentUser()->units->fightingSequence));
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->getAmount() > 0) {
				if ($unit->getBaseDefenseValue() > 0) {
					$this->addPanel($itemPanel = new Rakuun_Intern_GUI_Panel_Map_DefendingUnits_Item($unit->getInternalName(), $unit));
					$this->panelsForDefendingUnits[array_search($unit->getInternalName(), $fightingSequence)] = $itemPanel;
				}
				else {
					$this->addPanel($itemPanel = new GUI_Panel_Text($unit->getInternalName(), $unit->getNameForAmount(2) .' ('.Text::formatNumber($unit->getAmount()).')'));
					$this->panelsForOtherUnits[] = $itemPanel;
				}
			}
		}
		ksort($this->panelsForDefendingUnits);
	}
	
	// GETTERS / SETTERS -------------------------------------------------------
	public function getPanelsForDefendingUnits() {
		return $this->panelsForDefendingUnits;
	}
	
	public function getPanelsForOtherUnits() {
		return $this->panelsForOtherUnits;
	}
}

?>