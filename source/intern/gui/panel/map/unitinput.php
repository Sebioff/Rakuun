<?php

class Rakuun_Intern_GUI_Panel_Map_UnitInput extends GUI_Control {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/unitinput.tpl');
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($unit->getBaseAttackValue() > 0 && $unit->getAmount() > 0) {
				$this->addPanel(new GUI_Control_DigitBox($unit->getInternalName(), 0, $unit->getName().' ('.$unit->getAmount().')', 0, $unit->getAmount()));
			}
		}
	}
	
	public function getArmy() {
		$army = array();
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($this->hasPanel($unit->getInternalName()) && $this->{$unit->getInternalName()}->getValue() > 0) {
				$army[$unit->getInternalName()] = $this->{$unit->getInternalName()}->getValue();
			}
		}
		
		return $army;
	}
}

?>