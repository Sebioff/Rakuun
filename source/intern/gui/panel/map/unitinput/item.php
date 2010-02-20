<?php

class Rakuun_Intern_GUI_Panel_Map_UnitInput_Item extends GUI_Panel {
	private $unit = null;
	
	public function __construct($name, Rakuun_Intern_Production_Unit $unit) {
		parent::__construct($name);
		$this->unit = $unit;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/item.tpl');
		$this->addPanel(new GUI_Control_DigitBox('value_panel', 0, $this->unit->getNameForAmount(2), 0, $this->unit->getAmount()));
		$attackSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->attackSequence);
		$position = array_search($this->unit->getInternalName(), $attackSequence);
		if ($position < count($attackSequence) - 1)
			$this->addPanel(new GUI_Control_SubmitButton('move_up', '^'));
		if ($position > 0)
			$this->addPanel(new GUI_Control_SubmitButton('move_down', 'v'));
	}
	
	public function onMoveUp() {
		$attackSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->attackSequence);
		$position = array_search($this->unit->getInternalName(), $attackSequence);
		if ($position < count($attackSequence) - 1) {
			$moveTo = 0;
			for ($i = $position + 1; $i <= count($attackSequence) - 1; $i++) {
				$unit = Rakuun_Intern_Production_Factory::getUnit($attackSequence[$i]);
				if ($unit->getAmount() > 0 && $unit->getBaseAttackValue() > 0) {
					$moveTo = $i;
					break;
				}
			}
			$temp = $attackSequence[$position];
			$attackSequence[$position] = $attackSequence[$moveTo];
			$attackSequence[$moveTo] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->attackSequence = implode('|', $attackSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
	
	public function onMoveDown() {
		$attackSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->attackSequence);
		$position = array_search($this->unit->getInternalName(), $attackSequence);
		if ($position > 0) {
			$moveTo = 0;
			for ($i = $position - 1; $i >= 0; $i--) {
				$unit = Rakuun_Intern_Production_Factory::getUnit($attackSequence[$i]);
				if ($unit->getAmount() > 0 && $unit->getBaseAttackValue() > 0) {
					$moveTo = $i;
					break;
				}
			}
			$temp = $attackSequence[$position];
			$attackSequence[$position] = $attackSequence[$moveTo];
			$attackSequence[$moveTo] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->attackSequence = implode('|', $attackSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
}

?>