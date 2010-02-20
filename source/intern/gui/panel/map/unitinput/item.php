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
		$this->addPanel(new GUI_Control_DigitBox('value_panel', 0, $this->unit->getName(), 0, $this->unit->getAmount()));
		$this->addPanel(new GUI_Control_SubmitButton('move_up', '^'));
		$this->addPanel(new GUI_Control_SubmitButton('move_down', 'v'));
	}
	
	public function onMoveUp() {
		$attackSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->attackSequence);
		$position = array_search($this->unit->getInternalName(), $attackSequence);
		if ($position < count($attackSequence) - 1) {
			$temp = $attackSequence[$position];
			$attackSequence[$position] = $attackSequence[$position + 1];
			$attackSequence[$position + 1] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->attackSequence = implode('|', $attackSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
	
	public function onMoveDown() {
		$attackSequence = explode('|', Rakuun_User_Manager::getCurrentUser()->units->attackSequence);
		$position = array_search($this->unit->getInternalName(), $attackSequence);
		if ($position > 0) {
			$temp = $attackSequence[$position];
			$attackSequence[$position] = $attackSequence[$position - 1];
			$attackSequence[$position - 1] = $temp;
		}
		Rakuun_User_Manager::getCurrentUser()->units->attackSequence = implode('|', $attackSequence);
		Rakuun_User_Manager::getCurrentUser()->units->save();
		$this->getModule()->invalidate();
	}
}

?>