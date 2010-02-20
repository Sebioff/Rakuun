<?php

class Rakuun_Intern_GUI_Panel_Map_UnitInput extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/unitinput.tpl');
		$attackSequence = array_reverse(explode('|', Rakuun_User_Manager::getCurrentUser()->units->attackSequence));
		foreach ($attackSequence as $unitName) {
			$unit = Rakuun_Intern_Production_Factory::getUnit($unitName);
			if ($unit->getBaseAttackValue() > 0 && $unit->getAmount() > 0) {
				$this->addPanel(new Rakuun_Intern_GUI_Panel_Map_UnitInput_Item($unit->getInternalName(), $unit));
			}
		}
	}
	
	public function getArmy() {
		$army = array();
		
		foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
			if ($this->hasPanel($unit->getInternalName()))
			if ($this->hasPanel($unit->getInternalName()) && $this->{Text::underscoreToCamelCase($unit->getInternalName())}->valuePanel->getValue() > 0) {
				$army[$unit->getInternalName()] = $this->{Text::underscoreToCamelCase($unit->getInternalName())}->valuePanel->getValue();
			}
		}
		
		return $army;
	}
}

?>